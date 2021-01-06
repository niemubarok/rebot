<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Traits\messageTrait;
use QRcode;

include(app_path('phpqrcode/qrlib.php'));

trait agTrait
{
    use messageTrait;

    public function reply($pesan)
    {
        if (Str::contains($this->senderMessage(), ['assalam', 'asalam', 'ass', 'assalamualaikum', 'assalamu\'alaikum', 'slm', 'salam'])) {
            return "Wa'alaikumussalam\n" . $pesan;
        } else if (Str::contains($this->senderMessage(), ['selamat pagi', 'slmt pagi', 'slmt pagi'])) {
            return "selamat pagi,\n$pesan";
        } else if (Str::contains($this->senderMessage(), ['selamat siang', 'slmt siang', 'slmt siang'])) {
            return "selamat siang,\n$pesan";
        } else if (Str::contains($this->senderMessage(), ['selamat sore', 'slmt sore', 'slmt sore'])) {
            return "selamat sore,\n$pesan";
        } else if (Str::contains($this->senderMessage(), ['selamat malam', 'slmt malam', 'slmt malam'])) {
            return "selamat malam,\n$pesan";
        } else {

            return $pesan;
        }
    }

    public function mainMenu()
    {
        return  "Silahkan pilih menu berikut:" .
            "\n1. Pendaftaran Pasien *Lama*" .
            "\n2. Pendaftaran Pasien *Baru*" .
            "\n3. Cek Jadwal Praktek" .
            "\n\n*Balas dengan angka pilihan anda (1-3)*.";
    }

    public function defaultReply()
    {
        return $this->reply("Mohon maaf kami belum dapat menjawab pesan anda.\n" . $this->mainMenu());
    }

    public function formDaftar()
    {
        return $this->reply("\n- *NIK/Rekam Medis*:\n- *Nama sesuai KTP*:\n- *Lahir(tgl-bln-thn)*:\n- *Poli tujuan*:\n- *Dokter tujuan*:\n- *TGL. Berobat(tgl-bln-thn)*:");
    }

    //sementara belum digunakan

    public function replyMedia($contact, $source, $caption)
    {
        // $client = new \GuzzleHttp\Client(["base_uri" => "http://localhost:3000"]);
        // $options = [
        //     'headers' => [
        //         'Origin' => 'http://localhost:9090',
        //     ],

        //     'json' => [
        //         'type' => 'media',
        //         'contact' => $contact,
        //         'source' => $source,
        //         'img-name' => 'qrcode',
        //         'caption' => $caption,
        //     ]
        // ];
        // $client->get("/", $options);

        $result = [
            'type' => 'media',
            'contact' => $contact,
            'source' => $source,
            'img-name' => 'qrcode',
            'caption' => $caption
        ];

        return json_encode($result);
    }



    public function storeQrCode($content, $fileName)
    {
        $tempDir = public_path('storage/qrcode/');
        $codeContents = $content;
        $file = $fileName . '.png';
        $pngAbsoluteFilePath = $tempDir . $file;
        QRcode::png($codeContents, $pngAbsoluteFilePath);
        return asset('storage/qrcode/' . $file);
    }

    //     public function sendQrCode($pesan, $link)
    //     {
    //         $response = new MessagingResponse();
    //         $message = $response->message($pesan);
    //         $message->media($link);

    //         return $response;
    //     }
    // }
}
