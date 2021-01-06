<?php

namespace App\Traits;

use App\Models\Whatsapp;
use App\Traits\registrationTrait;
use App\Traits\sessionTrait;
use App\Traits\messageTrait;
use Illuminate\Support\Str;


trait questionsTrait
{
    use messageTrait;

    public function getAnswer()
    {
        $WaTable  = Whatsapp::where('kontak', $this->getContact())->first();
        $contact = $WaTable->kontak;
        // $question = $WaTable->questions; 
        $question = session('question');

        while($contact){
            if($question == 'salah poli'){
                return $this->senderMessage();
            }

        }
        exit;

       
    }
}