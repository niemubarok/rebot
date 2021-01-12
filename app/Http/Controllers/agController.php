<?php

namespace App\Http\Controllers;

use App\Traits\responseTrait;
use Illuminate\Support\Facades\Config;

class agController extends Controller
{
    use responseTrait;


    public function replyMessage()
    {
        return $this->responseMessage();

    }
        
}
