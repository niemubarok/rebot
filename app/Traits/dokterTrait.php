<?php

namespace App\Traits;

use App\Models\JadwalDokter;
use Illuminate\Support\Str;
use App\Models\Dokter;
use App\Traits\timeTrait;
use App\Traits\messageTrait;
use App\Traits\poliTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

trait dokterTrait
{
    use messageTrait;
    use timeTrait;
    use poliTrait;

    public function dokter()
    {
        $dokterTujuan   = $this->getDokter();
        $dokterTujuan   = Dokter::where('nm_dokter', 'LIKE', "%$dokterTujuan%")->first();
        return $dokterTujuan;
    }

    public function kodeDokter()
    {
        $kodeDokter = $this->dokter()['kd_dokter'];
        return $kodeDokter;
    }

    public function kodeDokterDiJadwal()
    {
        $dokter = JadwalDokter::select('kd_dokter')->from('dokter')->where('nm_dokter', 'like', "%{$this->getDokter()}%")->first();
        return $dokter->kd_dokter;
    }

    public function keywordsNamaDokter($dokter)
    {

        //dokter umum

        //   $SIBROHMALISI
        //   $RUSIAH
        //   $ENDANGSETIABUDI 
        //   $INDRAPARINDRIANTO
        //   $FADLYSALAHUDDIN
        //   $NIENKURNIASIH
        //   $SITIFATIMAH 
        //   $ARMAHIDA

        // $dokter = $this->getDokter();


        // penyakit dalam
        $LINA = $this->findKeywords(['lina', 'lyna', 'rina'], $dokter);
        $WULUNGGONO = $this->findKeywords(['wulung gono', 'wulungono', 'wulunggono', 'wullunggono', 'wulung ono'], $dokter);


        //poli anak

        $LENGKONG = $this->findKeywords(['lengkong', 'lenkong'], $dokter);
        $NAOMI = $this->findKeywords(['naomi', 'naumi', 'nami'], $dokter);

        $INDRA = $this->findKeywords(['indra'], $dokter);
        $JUNIATI = $this->findKeywords(['juniati', 'juniaty', 'juniyati', 'junyati'], $dokter);
        $KOMANGARIANTO = $this->findKeywords(['komang', 'komang arianto', 'komang ariyanto', 'komang aryanto'], $dokter);

        // POLI BEDAH UMUM
        $AZMIROSYAFORAYOGA = $this->findKeywords(['azmi rosya forayoga', 'azmi rosa', 'azmi rosya'], $dokter);
        $HENDRASHTO = $this->findKeywords(['hendrashto', 'hendrasto', 'hendasto', 'hendarasto'], $dokter);

        // POLIMATA
        $OLLYCONGGA = $this->findKeywords(['olly congga', 'oly congga', 'olly', 'olli conga', 'olli congga', 'olly conga'], $dokter);
        $ELIZAR = $this->findKeywords(['elizar', 'ellizar', 'elizzar'], $dokter);

        // POLI PARU 
        $ABDULROHMAN = $this->findKeywords(['abdul rahman', 'abdurrahman', 'abdur rahman', 'abdurrohman', 'abdul rohman', 'abdur rohman', 'abd. rohman', 'abd rohman', 'abdul rokhman', 'abdurrokhman', 'abdurrochman', 'abdur rokhman', 'abdur rochman'], $dokter);

        // POLI THT 
        $IRMA  = $this->findKeywords(['irma', 'ilma', 'ilna', 'irna'], $dokter);

        // POLI SYARAF
        if (strtolower($this->getPoli()) == 'poli syaraf') {
            $NOVIEDIYAHNURAINI = $this->findKeywords(['novy', 'novi', 'novie diyah nuraini', 'novie diyah nu\'aini', 'novie dyah'], $dokter);
        }
        $NASRULMUSADIR = $this->findKeywords(['nasrul musadir', 'nasrul'], $dokter);

        // POLI KULIT DAN KELAMIN
        $VINCENTIA  = $this->findKeywords(['vincentia', 'vicentia', 'vicencia', 'vincencia', 'vincen'], $dokter);

        // POLI GIGI 
        $NELLYYUNIADEWI = $this->findKeywords(['nelly yunia dewi', 'nely yunia dewi', 'nely', 'nelly', 'nelli', 'neli yunia dewi'], $dokter);
        $PANARIA = $this->findKeywords(['panaria', 'panarya'], $dokter);
        $PRASETYO = $this->findKeywords(['prasetyo', 'prasetio'], $dokter);

        if (strtolower($this->getPoli()) == 'poli gigi') {

            $NOVIINDRIANI = $this->findKeywords(['novy', 'novi', 'novy indriani', 'novy indriany', 'novi indriani', 'novi indriyani'], $dokter);
        }

        switch (true) {
            case  $LINA:
                return "lina";
                break;

            case $WULUNGGONO:
                return "wulunggono";
                break;
            case $LENGKONG:
                return "lengkong";
                break;
            case $NAOMI:
                return "naomi";
                break;
            case $INDRA:
                return "indra";
                break;
            case $JUNIATI:
                return "juniaty";
                break;
            case $KOMANGARIANTO:
                return "komang arianto";
                break;
            case $AZMIROSYAFORAYOGA:
                return "azmi rosya";
                break;
            case $HENDRASHTO:
                return "hendrastho";
                break;
            case $OLLYCONGGA:
                return "olly conga";
                break;
            case $ELIZAR:
                return "elizar";
                break;
            case $ABDULROHMAN:
                return "abdurrahman";
                break;
            case $IRMA:
                return "irma";
                break;
            case $NOVIEDIYAHNURAINI:
                if (strtolower($this->getPoli()) == 'poli syaraf') {

                    return "novi";
                }
                break;
            case $NASRULMUSADIR:
                return "nasrul musadir";
                break;
            case $VINCENTIA:
                return "vicencia";
                break;
            case $NELLYYUNIADEWI:
                return "nely yulia dewi";
                break;
            case $NOVIINDRIANI:
                if (strtolower($this->getPoli()) == 'poli gigi') {

                    return "novy";
                }
                // return "novy";
                break;
            case $PANARIA:
                return "panaria";
                break;
            case $PRASETYO:
                return "prasetyo";
                break;
        }
    }
}
