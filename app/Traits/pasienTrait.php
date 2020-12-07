<?php

namespace App\Traits;

use App\Traits\messageTrait;
use App\Models\Pasien;
use App\Models\RM;
use App\Models\Whatsapp;
use App\Traits\timeTrait;
use App\Traits\waTableTrait;


trait pasienTrait
{
    use messageTrait;
    use timeTrait;
    use waTableTrait;

    public function cariPasienDiDatabase($noKtp, $nmPasien, $tglLahir)
    {

        $pasien = Pasien::where('no_rkm_medis', $noKtp)->where('nm_pasien', 'like', "%$nmPasien%") //no. rekam medis
            ->orWhere(function ($query) use ($noKtp, $nmPasien) {
                $query->where('no_ktp', $noKtp)->where('nm_pasien', 'like', "%$nmPasien%");
            })
            ->orWhere(function ($query) use ($tglLahir, $nmPasien) {
                $query->where('tgl_lahir', $tglLahir)->Where('nm_pasien', 'like', "%$nmPasien%");
            })->first();

        return $pasien;
    }

    public function pasien()
    {
        $noKtp = $this->getNoKtp();
        $noRm = $this->getRm();
        $nmPasien = $this->pasienFromWaTable();
        $tglLahir = $this->getBirthDate();

        $pasien = Pasien::where('no_rkm_medis', $noRm) //no. rekam medis
            ->orWhere(function ($query) use ($noKtp, $nmPasien) {
                $query->where('no_ktp', $noKtp)->where('nm_pasien', 'like', "%$nmPasien%");
            })
            ->orWhere(function ($query) use ($tglLahir, $nmPasien) {
                $query->where('tgl_lahir', $tglLahir)->Where('nm_pasien', 'like', "%$nmPasien%");
            })->first();

        return $pasien;
    }

    public function PasienFromWaTable()
    {
        return $this->getWaTableData('nama');
    }

    public function storePasienBaru()
    {
        $get_rm = Pasien::select('no_rkm_medis')->latest('no_rkm_medis')->first();
        $get_rm = $get_rm->no_rkm_medis;
        $lastRM = substr($get_rm[0], 0, 6);
        $no_rm_next = sprintf('%06s', ($get_rm + 1));

        if ($this->pasien() == null) {
            $store               = Pasien::updateOrCreate(
                ['no_rkm_medis'      => $no_rm_next],
                [
                    'nm_pasien'         => $this->getNamaPasien(),
                    'no_ktp'            => $this->getNoKtp(),
                    'jk'                => $this->getJenisKelamin(),
                    'tmp_lahir'         => $this->getTempatLahir(),
                    'tgl_lahir'         => $this->formatTgl($this->getBirthDate()),
                    'nm_ibu'            => '-',
                    'alamat'            => $this->getAlamat(),
                    'gol_darah'         => '-', //enum('A', 'B', 'O', 'AB', '-') 
                    'pekerjaan'         => '-',
                    'stts_nikah'         => 'MENIKAH', //enum('BELUM MENIKAH', 'MENIKAH', 'JANDA', 'DUDHA',
                    'agama'             => $this->getAgama(),
                    'tgl_daftar'        => $this->getWaTableData('tgl_berobat'),
                    'no_tlp'            => $this->getContact(),
                    'umur'              => '-',
                    'pnd'                 => '-', //'TS', 'TK', 'SD', 'SMP', 'SMA', 'SLTA/SEDERAJ'.''
                    'keluarga'             => 'SAUDARA', //enum('AYAH', 'IBU', 'ISTRI', 'SUAMI', 'SAUDARA'
                    'namakeluarga'      => '-',
                    'kd_pj'             => '-',
                    'no_peserta'        => '-',
                    'kd_kel'            => '80545',
                    'kd_kec'            => '1',
                    'kd_kab'            => '1',
                    'pekerjaanpj'       => '-',
                    'alamatpj'          => '-',
                    'kelurahanpj'       => 'KELURAHAN',
                    'kecamatanpj'       => 'KECAMATAN',
                    'kabupatenpj'       => 'KABUPATEN',
                    'perusahaan_pasien' => '-',
                    'suku_bangsa'       => '1',
                    'bahasa_pasien'     => '5',
                    'cacat_fisik'       => '1',
                    'email'             => '-',
                    'nip'               => '-',
                    'kd_prop'           => '1',
                    'propinsipj'        => '-'
                ]
            );
        }
    }

    public function umur($tgl_lahir)
    {
        //menentukan umur sekarang
        $birthDate = $tgl_lahir;
        $birthDate = explode('-', $birthDate);
        $y = $birthDate[0];
        $cy = date('Y');

        return $cy - $y;
    }


    public function nik()
    {
        return $this->pasien()->no_ktp;
    }

    public function noRm()
    {
        return $this->pasien()->no_rkm_medis;
    }

    public function pasienToWaTable()
    {
        return Whatsapp::firstOrCreate(['nama' => $this->getNamaPasien()]);
    }
}
