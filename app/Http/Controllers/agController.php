<?php

namespace App\Http\Controllers;

use App\Traits\responseTrait;


class agController extends Controller
{
    use responseTrait;


    public function replyMessage()
    {
        return $this->responseMessage();

    }
        
}
