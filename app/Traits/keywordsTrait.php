<?php

namespace App\Traits;

use DateTime;
use Illuminate\Support\Str;

trait keywordsTrait
{
  function findKeywords($keywords, $message)
  {
    $keywords  = $keywords;
    $match     = array_map('stristr', array_fill(0, count($keywords), $message), $keywords);
    $match     = implode($match);
    return $match;
  }

  public function keywordsNik()
  {

    $replace = Str::of($this->senderMessage())->replaceMatches("/nik\/rekam medis|ktp|nik|nomor ktp|no.ktp|no ktp|rekam medis|rm/", 'nik');
    return $replace;
  }


  public function keywordsNama()
  {

    $replace = Str::of($this->senderMessage())->replaceMatches("/nama sesuai ktp|nama sesuai|nama pasien|nama lengkap|namanya|nama di ktp|nama saya|nama sy/", 'nama');
    return $replace;
  }

  public function keywordsTglLahir()
  {

    $replace = Str::of($this->senderMessage())->replaceMatches("/lahir|tgl. lahir|tanggal lahir| ttl/", 'ttl');
    return $replace;
    // }
  }


 

  public function keywordsHari()
  {
    return [
      "senin",
      "senen",
      "snen",
      'Mon',
      "selasa",
      "selas",
      "salasa",
      "slsa",
      "slasa",
      'Tue',
      "rabu",
      "rabo",
      "rebo",
      "rebu",
      'Wed',
      "kamis",
      "kemis",
      "kmis",
      'Thu',
      "jumat",
      "jum'at",
      "jm'at",
      "jmat",
      "jmt",
      'Fri',
      "sabtu",
      "saptu",
      "sbt",
      "sptu",
      "sbtu",
      'Sat',
      "minggu",
      "mnggu",
      "mngg",
      "ahad",
      "akhad",
      'Sun',
      "hari ini",
      "hr ini",
      "hrini",
      "hariini",

      "besok",

      "lusa"
    ];
  }
}
