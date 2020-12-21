<?php

namespace App\Traits;

use App\Models\Poli;
use App\Models\RegPeriksa;
use Illuminate\Support\Str;
use App\Traits\dokterTrait;
use App\Traits\messageTrait;
use App\Traits\pasienTrait;
use App\Traits\poliTrait;
use App\Traits\timeTrait;
use App\Traits\agTrait;
use App\Traits\jadwalTrait;
use App\Models\Whatsapp;
use App\Traits\waTableTrait;
use App\Traits\messageValidatorTrait;

trait registrationTrait
{
    use messageTrait;
    use messageValidatorTrait;
    use poliTrait;
    use timeTrait;
    use dokterTrait;
    use pasienTrait;
    use agTrait;
    use jadwalTrait;
    use waTableTrait;

    public function registration()
    {

        $this->updateWaTable('questions', '');
        $dateFromTable = $this->getWaTableData('tgl_berobat');
        $dateFromMessage = $this->formatTgl($this->getTglBerobat());

        $pasien                 = $this->pasien();
        $noRm                   = $this->noRm();
        $tglLahir               = strtotime($this->getWaTableData('tgl_lahir'));
        $tglLahir               = date('d-m-Y', $tglLahir);
        $poliSesuaiJadwal       = $this->poliSesuaiJadwal();
        $poli                   = $this->poli()->nm_poli;
        $kodePoli               = $this->kodePoli();
        $listPoli               = $this->listPoliDariJadwal();
        $listPoliDariJadwal     = Str::of($this->listPoliDariJadwal())->contains($poli);
        $dokter                 = $this->namaDokterDariJadwal();
        $dokterFromMessage      = $this->getDokter();
        $kodeDokter             = $this->kodeDokterDiJadwal();
        $hari                   = $this->tglKeHari($dateFromTable);
        $tglRegistrasi          = strtotime($this->getTglBerobat());
        $formatTglRegistrasi    = date('Y-m-d', $tglRegistrasi);
        $jamMulai               = $this->jamMulaiPraktek();
        $jamSelesai             = $this->jamSelesaiPraktek();
        $strtotimeJamSelesai    = strtotime($this->jamSelesaiPraktek());
        $moreThanJamPraktek       = $strtotimeJamSelesai == null ? false: $this->timestamp() >= $strtotimeJamSelesai;

        $regPeriksa             = RegPeriksa::select('no_rawat', 'tgl_registrasi', 'kd_dokter', 'no_reg', 'kd_poli', 'no_rkm_medis')->where('no_rkm_medis', $noRm)->where('tgl_registrasi', $dateFromTable)->where('kd_dokter', $kodeDokter)->where('kd_poli', $kodePoli)->first();

        if ($this->getTglBerobat() == date('Y-m-d') && $moreThanJamPraktek && $poliSesuaiJadwal !== null) {
            return [$this->reply("Mohon maaf bapak/ibu untuk hari ini jam praktek dr. $dokterFromMessage *SUDAH / AKAN SELESAI*"), "Berikut jadwal $poli:\n" . $this->jadwalPoli(), "\nSilahkan *ULANGI PENDAFTARAN DAN PILIH TANGGAL LAINNYA*."];
        }

        // || $dateFromTable < date('Y-m-d') == true
        // dd($this->getTglBerobat()) ;

        if ($this->getTglBerobat() < date('Y-m-d') == true) {

            $this->updateWaTable('questions', 'tglBerobat');
            return "Tanggal berobat tidak boleh *KURANG* dari *HARI INI*" .
                "\n*BALAS* dengan format (tanggal-bulan-tahun)" .
                "\n\nContoh: " . date('d-m-Y');
        }

        if (!isset($pasien)) {

            return [
                $this->reply(
                    "Mohon maaf kami tidak dapat menemukan data anda." .
                        "\nJika anda *PASIEN LAMA* mohon cek kembali *NIK/Nama/Tgl. Lahir* anda dan ulangi pendaftaran."
                ),
                "\nJika anda *PASIEN BARU* silahkan *COPY PESAN INI* dan lengkapi data berikut:" .

                    "\n\n~ *NIK*: {$this->getNoKtp()}" .
                    "\n~ *Nama sesuai KTP*: {$this->getNamaPasien()}" .
                    "\n~ *Tempat Lahir*: " .
                    "\n~ *Lahir(tgl-bln-thn)*: " . $tglLahir .
                    "\n~ *Jns. Kelamin*: " .
                    "\n~ *Agama*: " .
                    "\n~ *Alamat*: {$this->getAlamat()} " .
                    "\n~ *Poli tujuan*: {$this->getPoli()}" .
                    "\n~ *Dokter tujuan*: {$this->getWaTableData('dokter')}" .
                    "\n~ *TGl. Berobat(tgl-bln-thn)*: " . date('d-m-Y', strtotime($dateFromTable))

                // "Balas dengan angka 0 untuk kembali ke menu utama"
            ];
        } else if (!isset($poli)) {
            $this->updateWaTable('questions', 'pilih poli');
            return $this->reply("Anda ingin berobat ke poli apa?\nBerikut nama poli yang tersedia:\n- " . $listPoli . "\n\nSilahkan balas dengan *nama poli* tujuan anda");
        } else if (!isset($poliSesuaiJadwal) || $poliSesuaiJadwal == null) {

            if ($listPoliDariJadwal == false) {
                $this->updateWaTable('questions', 'pilih poli');
                return [$this->reply("Mohon maaf jadwal $poli tidak tersedia. \nBerikut poli yang tersedia: \n{$this->listPoliDariJadwal()}"), "Silahkan ulangi pendaftaran dengan nama dokter dan tanggal yang sesuai"];
            } else {

                return [$this->reply("Mohon maaf hari $hari (" . date('d-m-Y', $tglRegistrasi) . ") tidak ada jadwal $poli.\nBerikut jadwal $poli:\n{$this->jadwalPoli()}"), "Silahkan *ULANGI PENDAFTARAN* dengan *NAMA POLI* dan *TANGGAL YANG SESUAI*"];
            }
        } else if ($dokterFromMessage == null || !isset($dokter)) {

            $this->updateWaTable('questions', '');


            $createDate = strtotime(($this->getTglBerobat()));
            $date = date('d-m-Y', $createDate);
            $day = date('D', $createDate);
            $dayAndDate = "{$this->dayTohari($day)}, " . $date;

            return [
                $this->reply("Mohon maaf hari " . $dayAndDate. " tidak ada dokter yang anda maksud.\nBerikut jadwal " . $poli . ":\n" . $this->jadwalPoli(0)),
                "Silahkan *ULANGI PENDAFTARAN* dengan *NAMA DOKTER* dan *TANGGAL YANG SESUAI*"
            ];
        } else if (!empty($regPeriksa)) {
            $this->updateWaTable('questions', '');
            return $this->reply("Pasien atas nama *{$this->pasien()->nm_pasien}* sebelumnya sudah terdaftar pada hari *$hari(" . date('d-m-Y', strtotime($dateFromTable)) . ")* ke *$poli* dengan *{$regPeriksa->dokter['nm_dokter']}*. Praktek pkl. $jamMulai - $jamSelesai dapat antrian no. *{$regPeriksa['no_reg']}* \nSegera informasikan kepada kami jika anda berhalangan hadir. \nTerimakasih.");
        } else {

            $this->updateWaTable('questions', '');

            $no_reg = RegPeriksa::where('kd_dokter', $this->kodeDokter())->where('tgl_registrasi', $this->getWaTableData('tgl_berobat'))->max('no_reg');

            $no_reg = sprintf('%03s', ($no_reg + 1));

            $no_rawat_akhir = RegPeriksa::where('tgl_registrasi', $this->getWaTableData('tgl_berobat'))->max('no_rawat');
            $no_urut_rawat = substr($no_rawat_akhir, 11, 6);
            $tgl_reg_no_rawat = date('Y/m/d', strtotime($this->getWaTableData('tgl_berobat')));
            $no_rawat = $tgl_reg_no_rawat . '/' . sprintf('%06s', ($no_urut_rawat + 1));

            $biaya_reg = Poli::select('registrasilama')->where('kd_poli', $this->kodePoli())->first();
            $biaya_reg = $biaya_reg['registrasilama'];

            $store = RegPeriksa::create([
                'no_reg'          => $no_reg,
                'no_rawat'        => $no_rawat,
                'tgl_registrasi'  => $dateFromTable,
                'jam_reg'         => $this->jam(),
                'kd_dokter'       => $this->kodeDokterDiJadwal(),
                'no_rkm_medis'    => $this->noRm(),
                'kd_poli'         => $this->kodePoli(),
                'p_jawab'         => $this->pasien()->namakeluarga,
                'almt_pj'         => $this->pasien()->almt_pj,
                'hubunganpj'      => $this->pasien()->hubunganpj,
                'biaya_reg'       => $biaya_reg,
                'stts'            => 'Belum',
                'stts_daftar'     => 'Lama',
                'status_lanjut'   => 'Ralan',
                'kd_pj'           => $this->pasien()->kd_pj,
                'umurdaftar'      => $this->umur($this->pasien()->tgl_lahir),
                'sttsumur'        => 'Th',
                'status_bayar'    => 'Belum Bayar'

            ]);
            $store->save();

            // $qrcode = $this->storeQrCode($this->pasien()->no_rkm_medis, $this->pasien()->no_rkm_medis);

            $regPeriksa             = RegPeriksa::select('no_rawat', 'tgl_registrasi', 'kd_dokter', 'no_reg', 'kd_poli', 'no_rkm_medis')->where('no_rkm_medis', $noRm)->where('tgl_registrasi', $dateFromTable)->where('kd_dokter', $kodeDokter)->where('kd_poli', $kodePoli)->first();
            $noAntrian = $regPeriksa->no_reg;

            $namaPasien = trim($pasien->nm_pasien,' ');

            $response = $this->reply(
                "Anda sudah terdaftar" .
                    "\n\n--Detail Pendaftaran--" .
                    "\nNama: *$namaPasien*" .
                    "\nNo. RM: *$pasien->no_rkm_medis*" .
                    "\nPoli Tujuan : *$poli*" .
                    "\nDokter: *$dokter*" .
                    "\nTanggal Periksa: *" . date('d-m-Y', strtotime($dateFromTable)) . "*" .
                    "\nJam praktek : pkl. $jamMulai s/d $jamSelesai." .
                    "\nNo. Antrian : *" . $noAntrian . "*" .

                    "\n\n*Datanglah sesuai jam praktek dokter.*" .

                    "\n\nTunjukan pesan ini kepada petugas pendaftaran di Lobby utama." .

                    "\n\nTerimakasih telah mempercayakan kesehatan keluarga anda di RS Ali Sibroh Malisi" .
                    "\nSemoga lekas sembuh"
            );

            return $response;
        }
        // }
    }
}
