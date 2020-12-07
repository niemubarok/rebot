<?php

namespace App\Traits;

use App\Traits\messageTrait;
use App\Traits\agTrait;
use Illuminate\Support\Str;
use App\Traits\jadwalTrait;
use app\Traits\poliTrait;

trait messageValidatorTrait
{

    use agTrait;
    use messageTrait;
    use jadwalTrait;
    use poliTrait;

    public function messageValidation()
    {

        $senderMessage = Str::of($this->senderMessage())->containsAll(['nama', 'ktp', 'lahir', 'dokter', 'poli']);

        // dd($matchPoli);
        if ($senderMessage == false) {
            return false;
        } else {


            $messageEmptyNoKtp                  = "- *NIK:*";
            $messageEmptyNamaPasien             = "- *nama pasien sesuai KTP:*";
            $messageEmptyBirthDate              = "- *tanggal lahir pasien dengan format (tgl-bln-thn):*";
            $messageEmptyJK                     = "- *Jenis Kelamin:*";
            $messageEmptyAlamat                 = "- *Alamat:*";
            $messageEmptyPoli                   = "- *Poli Tujuan:*";
            $messageEmptyDokter                 = "- *Dokter Tujuan:*";
            $messageEmptyTglBerobat             = "- *Tgl. Berobat(tgl-bln-thn)*";
            $messageTglBerobatKurangDariHariIni = "Tanggal berobat tidak boleh kurang dari hari ini" .
                "\nBalas dengan format (tanggal-bulan-tahun)" .
                "\n\nContoh: " . date('d-m-Y');

            $emptyNamaPasien            = Str::of($this->getNamaPasien())->trim()->isEmpty();
            // $emptyBirthDate             = Str::of($this->getBirthDate())->trim()->isEmpty();
            $emptyNoKtp                 = Str::of($this->getNoKtp())->trim()->isEmpty();
            $emptyJK                    = Str::of($this->getJenisKelamin())->trim()->isEmpty();
            $emptyAlamat                = Str::of($this->getAlamat())->trim()->isEmpty();
            $emptyPoli                  = Str::of($this->getPoli())->trim()->isEmpty();
            $emptyDokter                = Str::of($this->getDokter())->trim()->isEmpty();
            $emptyTglBerobat            = Str::of($this->getTglBerobat())->trim()->isEmpty();
            $pasienBaruIntent           = Str::of($this->senderMessage())->containsAll(['jns', 'kelamin', 'alamat']);

            $tglBerobatKurangDariHariIni = $this->getTglBerobat() <= date('Y-m-d');

            $messageEmptyNamaPasien         = $emptyNamaPasien == true ? $messageEmptyNamaPasien . $this->flashSession('q-name', 'lengkapi nama pasien') : '';
            // $messageEmptyBirthDate          = $emptyBirthDate == true ? $messageEmptyBirthDate . $this->flashSession('q-birthDate', 'lengkapi tgl lahir') : '';
            $messageEmptyNoKtp              = $emptyNoKtp == true ? $messageEmptyNoKtp . $this->flashSession('q-nik', 'lengkapi nik') : '';

            $messageEmptyJK                 = $emptyJK == true  && $pasienBaruIntent == true ? $messageEmptyJK . $this->flashSession('q-jk', 'lengkapi jenis kelamin') : '';
            $messageEmptyAlamat             = $emptyAlamat == true && $pasienBaruIntent == true ? $messageEmptyAlamat . $this->flashSession('q-address', 'lengkapi alamat') .  "\n " : '';
            $messageEmptyPoli               = $emptyPoli == true ? $messageEmptyPoli . $this->flashSession('q-poli', 'lengkapi poli') : '';
            $messageEmptyDokter             = $emptyDokter == true ? $messageEmptyDokter . $this->flashSession('q-dokter', 'lengkapi dokter') : '';
            $messageEmptyTglBerobat         = $emptyTglBerobat == true ? $messageEmptyTglBerobat . $this->flashSession('q-regDate', 'lengkapi tanggal berobat') : '';


            $messageTglBerobatKurangDariHariIni = $emptyTglBerobat == false && $tglBerobatKurangDariHariIni == true ? $messageTglBerobatKurangDariHariIni : '';

            $message = $messageEmptyNamaPasien || $messageEmptyNoKtp || $messageEmptyJK || $messageEmptyAlamat || $messageEmptyPoli || $messageEmptyDokter || $messageEmptyTglBerobat || $tglBerobatKurangDariHariIni == true ? "Mohon maaf data anda belum lengkap.\n Silahkan *copy* pesan ini dan lengkapi data berikut:\n " . $messageEmptyNoKtp . $messageEmptyNamaPasien . $messageEmptyJK . $messageEmptyAlamat . $messageEmptyPoli . $messageEmptyDokter . $messageEmptyTglBerobat . $messageTglBerobatKurangDariHariIni : false;



            // dd($messageTglBerobatKurangDariHariIni);

            $poliFromTable = $this->poli()->nm_poli;
            $poliFromMessage = strtoupper($this->keywordsPoli($this->getPoli()));
            $matchPoli = $poliFromMessage == $poliFromTable;

            $jadwal = "Berikut jadwal $poliFromMessage:\n" . $this->jadwalPoli();
            $listPoli = "Berikut poli yang tersedia: \n- " . $this->listPoliDariJadwal();
            $message = $this->reply($message);
            return $message;
















            // if ($tglBerobatKurangDariHariIni == true) {
            //     $this->flashSession('tglBerobat', 'tglBerobat');
            //     return $messageTglBerobatKurangDariHariIni;
            // } else

            // if ($emptyPoli == true) {

            //     //masukan session pertanyaan untuk pilih poli
            //     $this->flashSession('pilih poli', 'pilih poli');
            //     $res = [$message, $listPoli];

            //     //balas dengan pesan dan list poli yang tersedia
            //     return $res;

            //     //jika poli yang dikirim tidak ada di dalam table
            // }

            // if ($matchPoli == false) {
            //     $this->flashSession('pilih poli', 'pilih poli');
            //     $res = ["Cek kembali nama poli tujuan anda", $listPoli . "\n\nBalas dengan nama poli di atas"];
            //     return $res;


            //     //jika dokter tidak dituliskan
            // }
            // if ($emptyDokter == true) {

            //     $this->flashSession('question', 'pilih dokter');

            //     if ($emptyPoli == false) {

            //         return [$message, $jadwal];
            //     }
            //     $res = [$message];
            //     return $res;
            // }


            // // dd($tglBerobatKurangDariHariIni);
            // return $message;



            // return $this->formatTgl($this->senderMessage());

        }
    }
}
