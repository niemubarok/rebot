<?php

namespace App\Traits;

use App\Traits\agTrait;
use App\Classes\WhatsATL;
use App\Models\Dokter;
use App\Models\RegPeriksa;
use App\Models\Whatsapp;
use App\Traits\messageTrait;
use app\Traits\poliTrait;
use App\Traits\registrationTrait;
use Illuminate\Support\Str;
use App\Traits\sessionTrait;
use Illuminate\Support\Facades\Log;
use App\Traits\questionsTrait;
use App\Traits\messageValidatorTrait;
use App\Traits\keywordsTrait;
use Carbon\Carbon;

trait responseTrait
{

    use agTrait;
    use messageTrait;
    use registrationTrait;
    use sessionTrait;
    use questionsTrait;
    use poliTrait;
    use messageValidatorTrait;
    use keywordsTrait;

    public function responseMessage()
    {
        $regIntent          = Str::of($this->senderMessage())->containsAll(['nama', 'dokter', 'poli']);
        $regIntent2          = Str::of($this->senderMessage())->containsAll(['daftar', 'ke',]);
        $sayaMauDaftar      = Str::of($this->senderMessage())->containsAll(['mau', 'daftar']);
        $sayaInginDaftar      = Str::of($this->senderMessage())->containsAll(['ingin', 'daftar']);
        $pasienBaruIntent   = Str::of($this->senderMessage())->containsAll(['jns', 'kelamin', 'alamat']);
        $pregjadwal         = stripos($this->senderMessage(), "jadwal");

        $jadwalIntent       = $pregjadwal > 1 ? Str::of($this->senderMessage())->contains([$pregjadwal, 'jadwal']) : Str::of($this->senderMessage())->contains('jadwal');
        $formDaftar         = $this->senderMessage() == 'daftar';
        // $lengkapiData       = Str::of($this->senderMessage())->contains(['mohon maaf data anda belum lengkap']);
        $groupName          = $this->getGroup()['name'];
        $pilih0             = trim($this->senderMessage(), ' ') == "0";
        $pilih1             = trim($this->senderMessage(), ' ') == "1";
        $pilih2             = trim($this->senderMessage(), ' ') == "2";
        $pilih3             = trim($this->senderMessage(), ' ') == "3";
        $hi                 = $this->senderMessage() == "hai" || $this->senderMessage() == "hi";
        $tes                 = $this->senderMessage() == "tes" || $this->senderMessage() == "test";
        $thanks             = Str::of($this->senderMessage())->replace(["thx", 'terimakasih', 'terima kasih', 'makasi', 'trims', 'thank', 'thankyou', 'thank you', 'tq'], 'terima kasih');

        // return $this->getBirthDate();
        // dd($this->getTglBerobat());
        // dd($this->getDokterFromMessage());

        switch (true) {

            case $hi:
            case $tes:
                return [$this->reply('Selamat datang di RS. Ali Sibroh Malisi.'), $this->mainMenu()];
                break;

            case $thanks == "terima kasih":
                return "Terimakasih Kembali";
                break;

            case $this->getWaTableData('questions') == "pilih poli":
                $this->updateWaTable('poli', $this->getPoli());
                $this->updateWaTable('questions', '');
                return $this->registration();
                break;

            case $this->getWaTableData('questions') == "tglBerobat":
                $this->updateWaTable('questions', '');
                $this->updateWaTable('tgl_berobat', $this->formatTgl($this->senderMessage()));

                return $this->registration();


                break;
            case $regIntent:

                if ($pasienBaruIntent == true) {

                    $this->storeToWaTable();
                    $this->storePasienBaru();
                    $this->updateWaTable('questions', '');
                    return $this->registration();
                }

                $this->storeToWaTable();
                $this->updateWaTable('questions', '');
                return $this->registration();
                break;
            case $sayaInginDaftar:
            case $sayaMauDaftar:
            case $regIntent2:
                return [
                    "Sebelum mendaftar kami sarankan untuk cek jadwal praktek dokter terlebih dahulu dengan ketik \" *jadwal <spasi> nama poli* \" \n\nContoh: jadwal poli anak.",
                    "Jika sudah mengetahui jadwal dokter tujuan anda silahkan pilih:\n1.Pasien Lama\n2.Pasien Baru\n\nMohon balas dengan angka pilihan anda (1 atau 2)"
                ];
            case $pilih0:
                return $this->mainMenu();
                break;
            case $pilih1:
            case $formDaftar:
                return ["Sebelum mendaftar kami sarankan untuk cek jadwal praktek dokter terlebih dahulu dengan ketik \" *jadwal <spasi> nama poli*"."\n\nContoh: *jadwal poli anak*.", "Pendaftaran pasien lama silahkan *COPY PESAN INI* dan lengkapi form berikut:\n" . $this->formDaftar()];
                break;
            case $jadwalIntent:
                return $this->replyJadwal();
                break;
            case $pilih2:
                return ["Sebelum mendaftar kami sarankan untuk cek jadwal praktek dokter terlebih dahulu dengan ketik \" *jadwal <spasi> nama poli* \". \n\nContoh: *jadwal poli anak*.", "--Pendaftaran pasien baru-- \n Silahkan *COPY PESAN INI* dan lengkapi formulir berikut:" .
                    "\n\n~ *NIK*:" .
                    "\n~ *Nama sesuai KTP*:" .
                    "\n~ *Tempat Lahir*:" .
                    "\n~ *Lahir(tgl-bln-thn)*:" .
                    "\n~ *JNS. Kelamin*:" .
                    "\n~ *Agama*:" .
                    "\n~ *Alamat*:" .
                    "\n~ *Poli tujuan*:" .
                    "\n~ *Dokter tujuan*:" .
                    "\n~ *TGL. Berobat(tgl-bln-thn)*:"];
                break;
            case $pilih3:
                return "Cek jadwal silahkan ketik: \" *jadwal <spasi> nama poli*\"";
                break;

                // default:
                //     if ($groupName !== "Botgrup") {
                //         return $this->defaultReply();
                //     }
        }







































        // if($pilih1){
        //     return $this->formDaftar();
        // }else if($pilih2){
        //     return "--Pendaftaran pasien baru-- \n Silahkan lengkapi formulir berikut:".
        //     "\n\n> *NIK*:".
        //     "\n> *Nama sesuai KTP*:".
        //     "\n> *Tempat Lahir*:".
        //     "\n> *Lahir(tgl-bln-thn)*:".
        //     "\n> *Jns. Kelamin*:".
        //     "\n> *Alamat*:".
        //     "\n> *poli tujuan*:".
        //     "\n> *dokter tujuan*:".
        //     "\n> *TGl. Berobat*:";
        // }else if($pilih3){
        //     return "Cek jadwal silahkan ketik: \" *jadwal <spasi> nama poli*\"";
        // }else if (session('question') == 'pilih poli') {
        //     $this->updateWaTable('poli', $this->senderMessage());

        //     if($this->poli() == null) {
        //         $this->flashSession('question', 'pilih poli');
        //         return "Poli tidak ditemukan".
        //         "\nBerikut poli yang tersedia\n". $this->listPoliDariJadwal().
        //         "\nBalas dengan nama poli";
        //     }else if(session('tglBerobat') !== null){
        //         // return "Tanggal berobat masih kurang dari hari ini".
        //         // "\nBalas dengan format (tanggal-bulan-tahun)".
        //         // "\n\nContoh: ".date('d-m-Y');
        //         return "tgl di poli";
        //     }else{

        //         $poli = trim($this->getWaTableData('poli'), 'jadwal');
        //         $poli = $this->keywordsPoli($poli);
        //         $this->updateWaTable('poli', $poli);

        //         return $this->registration();
        //     }

        //  } else if (session('question') == 'pilih dokter') {
        //     $this->updateWaTable('dokter', $this->senderMessage());

        //     if($jadwalIntent){

        //         $dokter = trim($this->getWaTableData('dokter'), 'jadwal');
        //     }else{
        //         $dokter = $this->getWaTableData('dokter');
        //     }

        //     // $dokter = $this->keywordsdokter($dokter);
        //     if($this->dokter() == null){
        //         $this->flashSession('question', 'pilih dokter');
        //         return "dokter tidak ditemukan". 
        //         "\nBerikut Nama dokter {$this->poli()->nm_poli}".
        //         "\n".$this->jadwalPoli().
        //         "\n\n *Silahkan balas dengan nama dokter di atas*";
        //     }
        //     $this->updateWaTable('dokter', $dokter);
        //     // dd($dokter);
        //     return $this->registration();
        // } else if (session('question') == 'tanya daftar') {
        //     $this->updateWaTable('poli', $this->senderMessage());
        //     $poli = $this->getWaTableData('poli');
        //     $poli = $this->keywordsPoli($poli);

        //     return $this->registration();
        // }  else if (session('tglBerobat') !== null) {
        //     $this->updateWaTable('tgl_berobat', $this->senderMessage());
        //     $tgl = $this->getWaTableData('tgl_berobat');
        //     $tgl = $this->formatTgl($this->senderMessage());

        //     if($tgl < date('Y-m-d')){
        //         // return "Tanggal berobat masih kurang dari hari ini".
        //         // "\nBalas dengan format (tanggal-bulan-tahun)".
        //         // "\n\nContoh: ".date('d-m-Y');

        //         return "tgl";
        //     }


        //     return $this->registration();
        // // }else if ($pasienBaruIntent == true) {

        // //     $this->storeToWaTable();
        // //     $this->storePasienBaru();
        // //     // dd($pasienBaruIntent);
        // //     return $this->registration();
        // }else {
        //     // if ($groupName == "Botgrup" || $this->getContact()) {
        //     switch (true) {

        //         case $regIntent:

        //             if ( $this->messageValidation() ) {
        //                 $this->storeToWaTable();
        //                 return $this->messageValidation();
        //                 // return $this->registration();
        //             }

        //             if ($pasienBaruIntent == true) {

        //                 $this->storeToWaTable();
        //                 $this->storePasienBaru();
        //                 // dd($pasienBaruIntent);
        //                 return $this->registration();
        //             }

        //             $this->storeToWaTable();
        //             return $this->registration();
        //             break;
        //         case $lengkapiData:
        //             $this->storeToWaTable();
        //             return $this->registration();
        //         case $formDaftar:
        //             return $this->formDaftar();
        //             break;
        //         case $jadwalIntent:
        //             return $this->replyJadwal();
        //             break;
        //         default:
        //         if ($groupName == "Botgrup"){

        //             return $this->defaultReply();
        //         }

        //     }
        // }
        // } 


    }
}



// case $answerYes:
//     case $answerNo:
//     case $pilihPoli:
//     case $answerNamaPasien:
//     case $answerBirthDate;
//     case $answerDokter;
//     case $answerPoli;
//     case $lengkapiData;
    
//         return $this->getAnswer();
//         break;



// $answerYes          = Str::of($this->senderMessage())->contains(['ya', '1']);
// $answerNo           = Str::of($this->senderMessage())->contains(['tidak', 'g', 'gak']);
// $pilihPoli          = Str::of($this->senderMessage())->contains(['poli']);
// $answerNamaPasien   = Str::of($this->senderMessage())->contains(['nama pasien sesuai ktp']);
// $answerBirthDate    = Str::of($this->senderMessage())->contains(['tanggal lahir pasien dengan format (tgl-bln-thn)']);
// $answerDokter       = Str::of($this->senderMessage())->contains(['dokter tujuan', 'untuk cek jadwal']);
// $answerPoli         = Str::of($this->senderMessage())->contains(['poli tujuan', 'untuk cek jadwal']);
