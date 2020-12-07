<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\stringsTrait;
use App\Traits\sessionTrait;
use App\Models\Whatsapp;
// use App\Traits\waTableTrait;
use App\Traits\keywordsTrait;

trait messageTrait
{
    use stringsTrait;
    use sessionTrait;
    // use waTableTrait;
    use keywordsTrait;

    public  $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function tesJadwal()
    {
        return "list Jadwal";
    }





    public function senderMessage()
    {

        $message = strtolower($this->request['data']['message']['pesan']);
        $message = Str::of($message)->replaceMatches('/\*|\n|:|\./', '');
        // $message = Str::finish($message, '~');
        return $message;
    }



    public function timestamp()
    {
        return $this->request['data']['message']['timestamp'];
    }

    public function getContact()
    {
        $contact = $this->request['data']['from'];
        return $contact;
    }

    public function getGroup()
    {
        return $this->request['data']['group'];
    }

    public function getNoKtp()
    {
        $message = Str::of($this->senderMessage())->replaceMatches("/nik\/rekam medis|ktp|nik|nomor ktp|no.ktp|no ktp|rekam medis|rm/",'nik');
        $explode = explode(' ',$message);
        $nik = preg_grep('/[0-9]{14}/', $explode);
        $nik = implode($nik);
        // $nik = Str::of($nik)->replaceMatches("/medis|nik\/rekam medis|ktp|nik|nomor ktp|no.ktp|no ktp|rekam medis|rm|\s|~|-|\./", '');
        $nik = Str::of($nik)->replaceMatches("/[a-z]|-|\s|~|\+/", '');
        // return $nik;
        
        if (Str::of($message)->contains("nik")) {
            return $nik;

        } else {
            return $this->getWaTableData('nik');
        }
    }



    public function getRm()
    {

        $message = explode(' ',$this->senderMessage());
        $nik = preg_grep('/[0-9]{5}/', $message);
        $nik = implode($nik);
        $nik = Str::of($nik)->replaceMatches("/nik\/rekam medis|ktp|nik|nomor ktp|no.ktp|no ktp|rekam medis|rm|\s|~|-|\./", '');
        return $nik;
    }



    public function getNamaPasien()
    {

        $isExist = Str::of($this->senderMessage())->contains('nama');
        // dd($isExist);
        $this->getWaTableData('nama');

        if ($isExist) {

            $namaPasien = Str::after($this->keywordsNama(), 'nama');
            $namaPasien = Str::of($namaPasien)->replaceMatches('/-|>|lahir|\(|pasien|\"|\//', '~');
            $namaPasien = Str::before($namaPasien, '~');
            $namaPasien = Str::title(trim($namaPasien, ' '));

            return $namaPasien;
        } else {
            return $this->getWaTableData('nama');

        }
    }

    public function getDokter()
    {

        $isExist = Str::of($this->senderMessage())->contains('dokter');

        if ($isExist == true) {

            $containsSp = Str::of($this->senderMessage())->contains(["sp.", "sp"]);
            $dokter     = $containsSp == true ? Str::between($this->senderMessage(), "dokter", "sp") : Str::between($this->senderMessage(), "dokter", '~');
            $dokter     = Str::of($dokter)->replaceMatches('/tgl|berobat|\(|-/', '~');
            $dokter     = Str::before($dokter, '~');
            $dokter     = Str::of($dokter)->replaceMatches('/tujuan|yang dituju|dokter tujuan|dokter|dr. |dr|doktor|-/', '');
            
            // return $dokter;
            $dokter = $this->keywordsNamaDokter($dokter);

            return trim($dokter, ' ');
        } else {
            return $this->getWaTableData('dokter');
        }
    }

    // public function getDayFromMessage()
    // {
    //     $day = trim(Str::after($this->senderMessage(), "hari:"), "\"");
    //     return ltrim(rtrim($day, ' '), ' ');
    // }

    public function getJenisKelamin()
    {

        $jk     = Str::of($this->senderMessage())->replaceMatches('/jenis kelamin|jns kelamin|jns. kelamin|kelamin|gender/', 'jenis kelamin');
        // return $jk;

        $isExist = Str::of($jk)->contains('jenis kelamin');

        if ($isExist == true) {

            $jnsKelamin     = Str::after($jk, "jenis kelamin");
            $jnsKelamin     = Str::before($jnsKelamin,   '~');
            $jnsKelamin     = Str::before($jnsKelamin,   '-');
            $jnsKelamin     = trim($jnsKelamin, ' ');
            $laki           = Str::of($jnsKelamin)->replace(['laki-laki', 'laki2', 'laki', 'laki - laki', 'male', 'cowo', 'cowok', 'lk2'], 'L');
            $cewek          = Str::of($jnsKelamin)->replace(['perempuan', 'wanita', 'p', 'female', 'betina', 'cewek', 'cewe', 'cw', 'prmpuan', ''], 'P');

            $jnsKelamin =  $laki == "L" ? $laki : $cewek;
            return $jnsKelamin;
        } else {
            return trim($this->getWaTableData('jk'), '\n');
        }
    }

    public function getAlamat()
    {

        $isExist = Str::of($this->senderMessage())->contains('alamat:');

        if ($isExist == true) {

            $alamat  = Str::between($this->senderMessage(), "alamat", '~');
            $alamat = Str::before($alamat, '~');

            $alamat  = trim(trim($alamat, ' '), ': ');
            return trim(trim($alamat, "\n"), '\n');
        } else {
            return trim($this->getWaTableData('alamat'), '\n');
        }
    }

    public function getTempatLahir()
    {
        $isExist = Str::of($this->senderMessage())->contains('tempat lahir:');

        if ($isExist == true) {


            $tempatLahir = Str::between($this->senderMessage(), "tempat lahir", '~');
            $tempatLahir = Str::before($tempatLahir, '~');
            $tempatLahir = Str::title(trim($tempatLahir, ': '));
            return trim(trim(trim($tempatLahir, "\n"), ' '), '\n');
        }


    }

    public function getAgama()
    {
        $afterAgama = Str::after($this->senderMessage(), 'agama');
        $agama = Str::before($afterAgama, '-');
        $agama = Str::before($afterAgama, '>');
        $agama = Str::before($afterAgama, 'alamat');
        $agama = Str::before($afterAgama, '~');

        return trim($agama, ' ');
    }
}
