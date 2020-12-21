<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait stringsTrait
{

    function splitNewLine($text) {
        $string=preg_replace('/\n$/','',preg_replace('/^\n/','',preg_replace('/[\r\n]+/',"\n",$text)));
        return explode("\n",$string);
    }

    function splitCrash($text) {
        $string=preg_replace('/#$/','',preg_replace('/^#/','',preg_replace('/[\r#]+/',"#",$text)));
        return explode("#",$string);
    }

    function removeDot($text) {
        $string=preg_replace('/.$/','',preg_replace('/^./','',preg_replace('/[\r.]+/',".",$text)));
        return trim(".",$string);
    }




}
