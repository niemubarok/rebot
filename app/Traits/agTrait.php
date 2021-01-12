<?php

namespace App\Traits;

use Illuminate\Support\Str;
use App\Traits\messageTrait;
use Illuminate\Support\Facades\Config;
use QRcode;

include(app_path('phpqrcode/qrlib.php'));

trait agTrait
{
    use messageTrait;

    public function greeting($pesan)
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

    public function reply($pesan)
    {
        $getConfig = Config::get("reply.$pesan");

        if ($getConfig == null) {
            return $this->greeting($pesan);
        }
        return $this->greeting(Config::get("reply.$pesan"));
    }

    public function multipleReply($pesan1, $pesan2, $pesan3 = null)
    {

        $getConfig = Config::get("reply.$pesan1");
        $getConfig2 = Config::get("reply.$pesan2");

        if ($getConfig == null || $getConfig2 == null) {

            return [$this->greeting($pesan1), $pesan2, $pesan3];
        }

        return [
            $this->greeting(Config::get("reply.$pesan1")),
            Config::get("reply.$pesan2"),
            Config::get("reply.$pesan3")
        ];
    }

    public function mainMenu()
    {
        return  Config::get('reply.MAIN_MENU');
    }

    public function defaultReply()
    {
        return $this->reply('DEFAULT_REPLY');
    }

    public function formDaftar()
    {
        return $this->reply('FORMAT_DAFTAR');
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
