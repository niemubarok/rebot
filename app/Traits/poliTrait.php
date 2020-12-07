<?php

namespace app\Traits;

error_reporting(E_ALL ^ E_NOTICE);

use App\Models\JadwalDokter;
use App\Traits\messageTrait;
use Illuminate\Support\Str;
use App\Models\Poli;
use App\Traits\agTrait;
use App\Traits\timeTrait;
use Illuminate\Support\Arr;
use App\Traits\waTableTrait;
use App\Traits\keywordsTrait;

trait poliTrait
{
    use messageTrait;
    use timeTrait;
    use agTrait;
    use waTableTrait;
    use keywordsTrait;




    public function keywordsPoli($message)
    {
        // $message = $message;

        //mencari keywords syaraf yang diketikan pasien
        $keywordsSyaraf = $this->findKeywords(['syaraf', 'neurologi', 'SARAF', 'neurolog', 'sp.n', 'spn'], $message);

        //mencari keywords obgyn yang diketikan pasien
        $keywordsObgyn  = $this->findKeywords(['kndungan', 'kandungan', 'obgin', 'obgyn', 'spog', 'sp.og', 'kndngn', 'obg'], $message);

        //mencari keywords internis yang diketikan pasien
        $keywordsPoliDalam  = $this->findKeywords(['internis', 'intrenis', 'intrns', 'penyakit dalam', 'pnykt dlm', 'pny dlm', 'p.dlm', 'sppd', 'poli dalam', 'polidalam', 'polidlm', 'poli dlm', 'spesialis dalam'], $message);

        //mencari keywords spesialis anak yang diketikan pasien
        $keywordsPoliAnak  =  $this->findKeywords(['spesialis anak', 'spa', 'sp.a', 'anak', 'poli Anak'], $message);

        //mencari keywords spesialis Mata yang diketikan pasien
        $keywordsPoliMata  = $this->findKeywords(['spesialis mata', 'spm', 'sp.m', 'mata', 'poli mata', 'mata', 'polimata'], $message);

        //mencari keywords spesialis Kulit yang diketikan pasien
        $keywordsPoliKulit  = $this->findKeywords(['spesialis kulit', 'spkk', 'sp.kk', 'kulit', 'poli kulit', 'polikulit'], $message);

        // $keywordsGigi
        $keywordsGigi = $this->findKeywords(['gigi', 'gigi dan mulut', 'dentis', 'dentist', 'poli gigi'], $message);

        $keywordsBedahUmum = $this->findKeywords(['bedah umum', 'bedahumum', 'poli bedah umum', 'poli bedah'], $message);

        $keywordsOrthopedi = $this->findKeywords(['orthopaedy', 'orthopedy', 'orthopaedi', 'orthopedi', 'ortopedi', 'ortopaedi', 'ortopeadi', 'orthopeady', 'orthopeady', 'orthopeadi', 'orthopeadi'], $message);

        $keywordsParu = $this->findKeywords(['paru', 'poli paru', 'poliaparu', 'spp', 'sp.P', 'spesialis paru', 'specialis paru'], $message);

        $keywordsTht = $this->findKeywords(['tht', 'poli tht', 'politht', 'sptht', 'sp.tht', 'spesialis tht', 'specialis tht'], $message);

        // $keywordsMata = $this->findKeywords(['tht', 'poli tht', 'politht','sptht', 'sp.tht', 'spesialis tht', 'specialis tht'], $message);

        //replace keyword dengan nama poli yang sesuai dengan database
        if ($keywordsObgyn) {
            $poliTujuan = substr_replace($keywordsObgyn, "poli obgyn", 0);
        } else if ($keywordsSyaraf) {
            $poliTujuan = substr_replace($keywordsSyaraf, "poli syaraf", 0);
        } else if ($keywordsPoliDalam) {
            $poliTujuan = substr_replace($keywordsPoliDalam, "Poli Dalam", 0);
        } else if ($keywordsPoliAnak) {
            $poliTujuan = substr_replace($keywordsPoliAnak, "Poli anak", 0);
        } else if ($keywordsPoliMata) {
            $poliTujuan = substr_replace($keywordsPoliMata, "Poli Mata", 0);
        } else if ($keywordsPoliKulit) {
            $poliTujuan = substr_replace($keywordsPoliKulit, "Poli Kulit", 0);
        } else if ($keywordsGigi) {
            $poliTujuan = substr_replace($keywordsGigi, "Poli gigi", 0);
        } else if ($keywordsBedahUmum) {
            $poliTujuan = substr_replace($keywordsBedahUmum, "Poli Bedah Umum", 0);
        } else if ($keywordsOrthopedi) {
            $poliTujuan = substr_replace($keywordsOrthopedi, "Poli Orthopedi", 0);
        } else if ($keywordsParu) {
            $poliTujuan = substr_replace($keywordsParu, "Poli Paru", 0);
        } else if ($keywordsTht) {
            $poliTujuan = substr_replace($keywordsTht, "Poli Tht", 0);
        }
        // else {
        //     $poliTujuan;
        // }

        return $poliTujuan;
    }

    public function getPoli()
    {
        $containsPoli = Str::of($this->senderMessage())->contains('poli');
        $containsJadwal = Str::of($this->senderMessage())->contains('jadwal');

        $message = Str::of($this->senderMessage())->replaceMatches('/poli tujuan|poli yang dituju|poli yg dituju/', 'poli');


        if($containsJadwal && $containsPoli){
            $poli = Str::of($this->senderMessage())->after('jadwal');
            $poli = trim($poli, ' ');
            $poli = $this->keywordsPoli($poli);
            if ($poli !== null) {
                return $poli;
            }
            return $this->getWaTableData('poli');
        }

        if ($containsPoli == true) {

            $poli = Str::of($message)->after('poli');
            $poli = Str::of($poli)->before('-');
            $poli = trim(Str::of($poli)->before('dokter'), ' ');
            // return $poli;
            $keywordPoli = $this->keywordsPoli($poli);
            // return $keywordPoli;

            if ($keywordPoli !== null) {
                return $keywordPoli;
            }

            // return $this->getWaTableData('poli');
        } else if ($containsJadwal == true) {

            $poli = Str::of($this->senderMessage())->after('jadwal');
            $poli = trim($poli, ' ');
            $poli = $this->keywordsPoli($poli);
            if ($poli !== null) {
                return $poli;
            }
            return $this->getWaTableData('poli');
        } else {

            $keywordsPoli           = strtoupper($this->keywordsPoli($this->senderMessage()));
            $listPoliDariJadwal     = Str::of($this->listPoliDariJadwal())->contains($keywordsPoli);
            if($listPoliDariJadwal){

                return $this->keywordsPoli($this->senderMessage());
            }
            return $this->getWaTableData('poli');
        }
    }

    public function poli() //mencari poli dari database sesuai poli yang diketik pasien
    {
        // $namaPoli = $this->keywordsPoli($this->getWaTableData('poli'));
        $namaPoli = $this->getPoli();
        // $namaPoli = $namaPoli == null ? $this->getPoli() : $namaPoli;
        if($namaPoli !== null){

            $poli = Poli::where('nm_poli', 'like', $namaPoli)->first();
            return $poli;
        }
    }

    public function kodePoli()
    {
        $kodePoli = $this->poli()['kd_poli'];
        return $kodePoli;
    }

    public function listPoli()
    {
        $listPoli   = Poli::pluck('nm_poli')->toArray();
        $listPoli   = Arr::except($listPoli, ['0', '1', '2', '3', '4', '18', '19', '20', '21']);
        $listPoli   = array_values($listPoli);
        return $listPoli;
    }

    public function listPoliDariJadwal()
    {
        $listPoli   = JadwalDokter::join('poliklinik', 'poliklinik.kd_poli', '=', 'jadwal.kd_poli')->pluck('nm_poli');
        $listPoli   = array_values($listPoli->unique()->toArray());
        return implode("\n- ", $listPoli);
    }

    public function poliSesuaiJadwal()
    {
        //nama poli dari table jadwal dokter
        $poliTujuan         = JadwalDokter::where('kd_poli', $this->kodePoli())->where('hari_kerja', $this->tglKeHari($this->getWaTableData('tgl_berobat')))->first();
        $poliSesuaiJadwal   = $poliTujuan->poli['nm_poli'];
        return $poliSesuaiJadwal;
    }

    public function jadwalPoli()
    {

        $jadwalPoli   = JadwalDokter::where('kd_poli', $this->kodePoli())->join('dokter', 'dokter.kd_dokter', '=', 'jadwal.kd_dokter')->get();
        $jadwalPoli   = $jadwalPoli->mapToGroups(function ($item, $key) {
            $createDate = date_create($this->hariKeTgl($item['hari_kerja']));
            $date = date_format($createDate, 'd-m-Y');
            $day = date_format($createDate, 'D,');
            $dayAndDate = "{$this->dayTohari($day)}~ " . $date;
            return ["#{$item['nm_dokter']}"  => [["&" . $dayAndDate . " (" . $item['jam_mulai'] . " - " . $item['jam_selesai'] . ")" . "#"]]];
        });
        $jadwalPoli   = explode(']]', $jadwalPoli);
        $jadwalPoli   = implode($jadwalPoli);
        $jadwalPoli   = Str::of($jadwalPoli)->replaceMatches('/{|}|[[|]|]|"|"|,/', '');
        $jadwalPoli   = Str::of($jadwalPoli)->replaceMatches('/\#|:/', "\n");
        $jadwalPoli   = Str::of($jadwalPoli)->replaceMatches('/~|:/', ",");
        $jadwalPoli   = Str::of($jadwalPoli)->replaceMatches('/&|:/', " -");

        return $jadwalPoli;
    }


    public function matchPoli()
    {

        $poliFromTable = $this->poli()->nm_poli;
        $poliFromMessage = strtoupper($this->keywordsPoli($this->getPoli()));
        $matchPoli = $poliFromMessage == $poliFromTable;
        return $matchPoli;
    }
}
