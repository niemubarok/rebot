<?php

namespace App\Traits;

use App\Models\JadwalDokter;
use App\Models\Dokter;
use app\Traits\poliTrait;
use App\Traits\dokterTrait;
use App\Traits\timeTrait;
use App\Traits\messageTrait;
use Illuminate\Support\Str;
use App\Traits\agTrait;

trait jadwalTrait
{
    use dokterTrait;
    use poliTrait;
    use timeTrait;
    use messageTrait;
    use agTrait;

    public function jadwal()
    {
        return JadwalDokter::all();
    }



    public function namaDokterDariJadwal()
    {

        // $tglBerobat = $this->getWaTableData('questions') == "tglBerobat" ? $this->formatTgl($this->senderMessage()): $this->getTglBerobat();
        //dokter tujuan jika ditemukan di jadwal dokter
        $jadwalPerDokter = JadwalDokter::where('kd_poli', $this->kodePoli())
            ->where('kd_dokter', $this->kodeDokterDiJadwal())
            ->where('hari_kerja', $this->tglKeHari($this->getTglBerobat()))->first();

        $dokterTujuan = Dokter::where('kd_dokter', $jadwalPerDokter->kd_dokter)->first();
        $nmDokterDariJadwal =  $dokterTujuan->nm_dokter;
        return $nmDokterDariJadwal;
    }

    public function jadwalPerPoli($i)
    {
        //mencari jadwal dokter jika pasien mengetikan nama dokter tidak sesuai spesialisnya.
        $jadwalPerPoli = JadwalDokter::where('kd_poli', $this->kodePoli())->where('hari_kerja', $this->tglKeHari($this->getTglBerobat()))->join('dokter', 'dokter.kd_dokter', '=', 'jadwal.kd_dokter')->orderBy('hari_kerja')->get();

        $jadwal = collect($jadwalPerPoli);



        $namaDokter = $jadwal[$i]['nm_dokter'];
        $jamMulai   = $jadwal[$i]['jam_mulai'];
        $jamSelesai = $jadwal[$i]['jam_selesai'];

        $jadwalPerPoli  = "- " . $namaDokter . " (" . $jamMulai . "-" . $jamSelesai . ")";
        return $jadwalPerPoli;
    }

    public function jamMulaiPraktek()
    {
        $jamPraktek = JadwalDokter::select('jam_mulai', 'jam_selesai')->where('kd_dokter', $this->kodeDokterDiJadwal())->where('hari_kerja', $this->tglKeHari($this->getTglBerobat()))->first();

        return $jamPraktek->jam_mulai;
    }

    public function jamSelesaiPraktek()
    {
        $jamPraktek = JadwalDokter::select('jam_mulai', 'jam_selesai')->where('kd_dokter', $this->kodeDokterDiJadwal())->where('hari_kerja', $this->tglKeHari($this->getTglBerobat()))->first();

        return $jamPraktek->jam_selesai;
    }

    public function replyJadwal()
    {
        $poli        = $this->poli()->nm_poli;
        $jadwaPoli      = $this->jadwalPoli();
        $afterJadwal        = trim(strtoupper(Str::after($this->senderMessage(), 'jadwal')), ' ');
        $keywordsPoli = strtoupper($this->keywordsPoli($afterJadwal));


        if ($keywordsPoli !== $poli) {
            $reply = $this->reply("Cek jadwal silahkan ketik: *jadwal <spasi> nama poli*\n\n Contoh: jadwal poli anak");
            return $reply;
        } else if ($keywordsPoli == $poli && $this->poli() == null) {

            $this->updateWaTable('question', 'pilih poli');
            return $this->reply("Mohon maaf jadwal $poli tidak tersedia. \nBerikut poli yang tersedia: \n{$this->listPoliDariJadwal()}\n\n" .
                "Silahkan balas dengan nama poli di atas");
        } else if ($this->jadwalPoli() == "") {
            return $this->reply("Mohon maaf jadwal {$this->poli()->nm_poli} tidak tersedia. \nBerikut poli yang tersedia: \n{$this->listPoliDariJadwal()} \nSilahkan ketik: \" *jadwal nama poli* \"");
        } else {

            return [$this->reply("Berikut jadwal {$this->poli()->nm_poli}:" . "\n" . $this->jadwalPoli()), $this->mainMenu()];
        }
    }
}
