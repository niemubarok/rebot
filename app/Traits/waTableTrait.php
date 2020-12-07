<?php

namespace App\Traits;

use App\Models\Whatsapp;
use app\Traits\poliTrait;
use App\Traits\timeTrait;

trait waTableTrait
{
    use timeTrait;

    public function updateWaTable($column, $data)
    {
        return Whatsapp::where('kontak', $this->getContact())->update([$column => $data]);
    }



    public function getWaTableData($column)
    {
        $data = Whatsapp::where('kontak', $this->getContact())->first();
        return $data->$column;
    }

    public function storeToWaTable()
    {

        Whatsapp::updateOrCreate(
            ['kontak' => $this->getContact()],
            [
                'nik' => $this->getNoKtp(),
                'rm' => $this->getRm(),
                'nama' => $this->getNamaPasien(),
                'tempat_lahir' => $this->getTempatLahir(),
                'tgl_lahir' => $this->getBirthDate(),
                'jk' => $this->getJenisKelamin(),
                'alamat' => $this->getAlamat(),
                'poli' => $this->getPoli(),
                'dokter' => $this->getDokter(),
                'tgl_berobat' => $this->getTglBerobat(),
                'pesan' => $this->senderMessage(),
                'questions' => '',
                'message_time' => $this->timestamp()
            ]

        );
    }
}
