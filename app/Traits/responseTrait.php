<?php

namespace App\Traits;

use App\Traits\agTrait;
use App\Traits\messageTrait;
use app\Traits\poliTrait;
use App\Traits\registrationTrait;
use Illuminate\Support\Str;
use App\Traits\keywordsTrait;
// use Illuminate\Support\Facades\Config;

trait responseTrait
{

    use agTrait;
    use messageTrait;
    use registrationTrait;
    use poliTrait;
    use keywordsTrait;

    public function responseMessage()
    {
        $regIntent          = Str::of($this->senderMessage())->containsAll(['nama', 'dokter', 'poli']);
        $regIntent2          = Str::of($this->senderMessage())->containsAll(['daftar', 'ke',]);
        $sayaMauDaftar      = Str::of($this->senderMessage())->containsAll(['mau', 'daftar']);
        $mauKePoli      = Str::of($this->senderMessage())->containsAll(['mau', 'ke', 'poli']);
        $sayaInginDaftar      = Str::of($this->senderMessage())->containsAll(['ingin', 'daftar']);
        $pasienBaruIntent   = Str::of($this->senderMessage())->containsAll(['jns', 'kelamin', 'alamat']);
        $pregjadwal         = stripos($this->senderMessage(), "jadwal");

        $jadwalIntent       = $pregjadwal > 1 ? Str::of($this->senderMessage())->contains([$pregjadwal, 'jadwal']) : Str::of($this->senderMessage())->contains('jadwal');
        $formDaftar         = $this->senderMessage() == 'daftar';
        // $groupName          = $this->getGroup()['name'];
        $pilih0             = trim($this->senderMessage(), ' ') == "0";
        $pilih1             = trim($this->senderMessage(), ' ') == "1";
        $pilih2             = trim($this->senderMessage(), ' ') == "2";
        $pilih3             = trim($this->senderMessage(), ' ') == "3";
        $hi                 = $this->senderMessage() == "hai" || $this->senderMessage() == "hi";
        $tes                 = $this->senderMessage() == "tes" || $this->senderMessage() == "test";
        $thanks             = Str::of($this->senderMessage())->replace(["thx", 'terimakasih', 'terima kasih', 'makasi', 'trims', 'thank', 'thankyou', 'thank you', 'tq'], 'terima kasih');

        // return $this->getBirthDate();
        // return $this->getPoli();

        switch (true) {

            case $hi:
            case $tes:
                return $this->multipleReply('WELCOME','MAIN_MENU');
                break;

            case $thanks == "terima kasih":
                return $this->reply('THANKS');
                break;

            case $this->getWaTableData('questions') == "pilih poli":
                $this->updateWaTable('poli', $this->getPoli());
                $this->updateWaTable('questions', '');
                return $this->registration();
                break;

            case $this->getWaTableData('questions') == "tglBerobat":
                $this->updateWaTable('questions', '');
                $date = $this->find_date($this->senderMessage());
                $this->updateWaTable('tgl_berobat', $date);
                // $this->updateWaTable('tgl_berobat', $this->getTglBerobat());


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
            case $mauKePoli:
            case $regIntent2:
                return $this->multipleReply('TO_CHECK_SCH', 'IF_KNEW_SCH');
            case $pilih0:
                return $this->mainMenu();
                break;
            case $pilih1:
            case $formDaftar:
                // return $this->reply('TO_CHECK_SCH');
                return $this->multipleReply('TO_CHECK_SCH', 'TO_REGISTERED_PATIENT', 'REG_FORMAT');
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
    }
}
