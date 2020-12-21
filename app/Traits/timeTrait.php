<?php

namespace App\Traits;

use DateTime;
use App\Traits\messageTrait;
use Illuminate\Support\Str;

trait timeTrait
{
  use messageTrait;


  function dayDate($day)
  {
    return new DateTime($day);
  }

  public function hariKeTgl($day)
  {
    //tanggal pendaftaran
    $date = date('Y-m-d');
    $hari = $day;
    switch (strtolower($hari)) {
      case "senin":
      case "senen":
      case "snen":
        $hari = $this->dayDate('Mon')->format('Y-m-d');

        break;
      case "selasa":
      case "selas":
      case "salasa":
      case "slsa":
      case "slasa":
        $hari = $this->dayDate('Tue')->format('Y-m-d');
        break;
      case "rabu":
      case "rabo":
      case "rebo":
      case "rebu":
        $hari = $this->dayDate('Wed')->format('Y-m-d');
        break;
      case "kamis":
      case "kemis":
      case "kmis":
        $hari = $this->dayDate('Thu')->format('Y-m-d');
        break;
      case "jumat":
      case "jum'at":
      case "jm'at":
      case "jmat":
      case "jmt":
        $hari = $this->dayDate('Fri')->format('Y-m-d');
        break;
      case "sabtu":
      case "saptu":
      case "sbt":
      case "sptu":
      case "sbtu":
        $hari = $this->dayDate('Sat')->format('Y-m-d');
        break;
      case "minggu":
      case "mnggu":
      case "mngg":
      case "ahad":
      case "akhad":
        $hari = $this->dayDate('Sun')->format('Y-m-d');
        break;
      case "hari ini":
      case "hr ini":
      case "hrini":
      case "hariini":
        $hari = $date;
        break;
      case "besok":
        $hari = date('Y-m-d', strtotime($date . '+ 1 day'));
        break;
      case "lusa":
        $hari = date('Y-m-d', strtotime($date . '+ 2 day'));
        break;
      default:
        $hari = $date;
    }
    return $hari;
  }


  //mengubah hari dalam bahasa inggris ke hari dalam bahasa indonesia/sesuai di database
  public function dayToHari($str)
  {
    $strTotime      = strtotime($str);
    $tentukanHari   = date('D', $strTotime);
    $day = array(
      'Sun' => 'AKHAD',
      'Mon' => 'SENIN',
      'Tue' => 'SELASA',
      'Wed' => 'RABU',
      'Thu' => 'KAMIS',
      'Fri' => 'JUMAT',
      'Sat' => 'SABTU'
    );

    $hari = $day[$tentukanHari];
    return $hari;
  }

  public function hariToDay($str)
  {
    $strTotime      = strtotime($str);
    $tentukanHari   = date('D', $strTotime);
    $day = array(
      'AKHAD' =>    'Sun',
      'SENIN' =>    'Mon',
      'SELASA' =>    'Tue',
      'RABU' =>      'Wed',
      'KAMIS' =>    'Thu',
      'JUMAT' =>    'Fri',
      'SABTU' =>   'Sat'
    );

    $hari = $day[$tentukanHari];
    return $hari;
  }

  // public function hariKeTgl()
  // {
  //     $hari = $this->getHari();
  //     $strTotime =strtotime($hari);
  //     $tgl =date('Y-m-d', $strTotime);
  //     return $tgl;
  // }

  public function formatTgl($tglLahirDariPesan)
  {
    $getTgl = $tglLahirDariPesan;
    switch (true) {
      case str_contains($getTgl, "january"):
        $getTgl = str_replace("january", "jan", $getTgl);
        break;
      case str_contains($getTgl, "januari"):
        $getTgl = str_replace("januari", "jan", $getTgl);
        break;
      case str_contains($getTgl, "februari"):
        $getTgl = str_replace("februari", "feb", $getTgl);
        break;
      case str_contains($getTgl, "febuari"):
        $getTgl = str_replace("febuari", "feb", $getTgl);
        break;
      case str_contains($getTgl, "febuary"):
        $getTgl = str_replace("febuary", "feb", $getTgl);
        break;
      case str_contains($getTgl, "maret"):
        $getTgl = str_replace("maret", "march", $getTgl);
        break;
      case str_contains($getTgl, "mart"):
        $getTgl = str_replace("mart", "march", $getTgl);
        break;
      case str_contains($getTgl, "april"):
        $getTgl = str_replace("april", "april", $getTgl);
        break;
      case str_contains($getTgl, "mei"):
        $getTgl = str_replace("mei", "may", $getTgl);
        break;
      case str_contains($getTgl, "juni"):
        $getTgl = str_replace("juni", "june", $getTgl);
        break;
      case str_contains($getTgl, "juli"):
        $getTgl = str_replace("juli", "july", $getTgl);
        break;
      case str_contains($getTgl, "agustus"):
        $getTgl = str_replace("agustus", "august", $getTgl);
        break;
      case str_contains($getTgl, "agsts"):
        $getTgl = str_replace("agsts", "august", $getTgl);
        break;
      case str_contains($getTgl, "agusts"):
        $getTgl = str_replace("agusts", "august", $getTgl);
        break;
      case str_contains($getTgl, "agstus"):
        $getTgl = str_replace("agstus", "august", $getTgl);
        break;
      case str_contains($getTgl, "september"):
        $getTgl = str_replace("september", "september", $getTgl);
        break;
      case str_contains($getTgl, "septmber"):
        $getTgl = str_replace("septmber", "september", $getTgl);
        break;
      case str_contains($getTgl, "septmbr"):
        $getTgl = str_replace("septmbr", "september", $getTgl);
        break;
      case str_contains($getTgl, "sptmbr"):
        $getTgl = str_replace("sptmbr", "september", $getTgl);
        break;
      case str_contains($getTgl, "oktober"):
        $getTgl = str_replace("oktober", "october", $getTgl);
        break;
      case str_contains($getTgl, "november"):
        $getTgl = str_replace("november", "november", $getTgl);
        break;
      case str_contains($getTgl, "desember"):
        $getTgl = str_replace("desember", "december", $getTgl);
        break;
    }

    $tglToTime = strtotime($getTgl);
    $tgl = date('Y-m-d', $tglToTime);
    return $tgl;
  }


  public function findMonth($src)
  {
    $month = $src;
    switch (true) {
      case str_contains($month, "january"):
        $month = str_replace("january", "jan", $month);
        break;
      case str_contains($month, "januari"):
        $month = str_replace("januari", "jan", $month);
        break;
      case str_contains($month, "februari"):
        $month = str_replace("februari", "feb", $month);
        break;
      case str_contains($month, "febuari"):
        $month = str_replace("febuari", "feb", $month);
        break;
      case str_contains($month, "febuary"):
        $month = str_replace("febuary", "feb", $month);
        break;
      case str_contains($month, "maret"):
        $month = str_replace("maret", "march", $month);
        break;
      case str_contains($month, "mart"):
        $month = str_replace("mart", "march", $month);
        break;
      case str_contains($month, "april"):
        $month = str_replace("april", "april", $month);
        break;
      case str_contains($month, "mei"):
        $month = str_replace("mei", "may", $month);
        break;
      case str_contains($month, "juni"):
        $month = str_replace("juni", "june", $month);
        break;
      case str_contains($month, "juli"):
        $month = str_replace("juli", "july", $month);
        break;
      case str_contains($month, "agustus"):
        $month = str_replace("agustus", "august", $month);
        break;
      case str_contains($month, "agsts"):
        $month = str_replace("agsts", "august", $month);
        break;
      case str_contains($month, "agusts"):
        $month = str_replace("agusts", "august", $month);
        break;
      case str_contains($month, "agstus"):
        $month = str_replace("agstus", "august", $month);
        break;
      case str_contains($month, "september"):
        $month = str_replace("september", "september", $month);
        break;
      case str_contains($month, "septmber"):
        $month = str_replace("septmber", "september", $month);
        break;
      case str_contains($month, "sepetember"):
        $month = str_replace("sepetember", "september", $month);
        break;
      case str_contains($month, "septmbr"):
        $month = str_replace("septmbr", "september", $month);
        break;
      case str_contains($month, "sept"):
        $month = str_replace("sept", "september", $month);
        break;
      case str_contains($month, "sptmbr"):
        $month = str_replace("sptmbr", "september", $month);
        break;
      case str_contains($month, "oktober"):
        $month = str_replace("oktober", "october", $month);
        break;
      case str_contains($month, "november"):
        $month = str_replace("november", "november", $month);
        break;
      case str_contains($month, "desember"):
        $month = str_replace("desember", "december", $month);
        break;
    }

    // $replace = str_replace($src, $month,);
    // $tgl = date('Y-m-d', $replace);
    return $month;
  }


  public function tglKeHari($tgl)
  {
    $date = strtotime($tgl);
    $tentukanHari   = date('D', $date);
    $day = array(
      'Sun' => 'AKHAD',
      'Mon' => 'SENIN',
      'Tue' => 'SELASA',
      'Wed' => 'RABU',
      'Thu' => 'KAMIS',
      'Fri' => 'JUMAT',
      'Sat' => 'SABTU'
    );

    $hari = $day[$tentukanHari];
    return $hari;
  }

  public function jam()
  {
    //jam registrasi
    return date('H:i:s');
  }

  public function getBirthDate()
  {
    $tgl  = Str::of($this->senderMessage())->replaceMatches('/lahir\(tgl\-bln\-thn\)|tanggal lahir|tgl. lahir|ttl|tempat, tanggal lahir|birthdate/', 'tanggal lahir');
    $isExist = Str::of($tgl)->contains('lahir');


    $questions = $this->getWaTableData('questions');


    if ($questions == 'tglBerobat') {
      $tglLahir = $this->getWaTabledata('tgl_lahir');
    }

    if ($questions == 'pilih poli') {
      $tglLahir = $this->getWaTabledata('tgl_lahir');
    }


    if ($isExist == true) {

      $tglLahir = Str::after($tgl, 'tanggal lahir');
      $tglLahir = Str::before($tglLahir, '~');
      $tglLahir = Str::before($tglLahir, '>');

      $tglLahir = Str::before($tglLahir, 'berobat');
      $tglLahir = Str::before($tglLahir, 'dokter');
      $tglLahir = Str::before($tglLahir, 'poli');
      $tglLahir = Str::of($tglLahir)->replaceMatches('/\(|tgl|\(tgl-bln-thn\)/', '');
      $tglLahir = trim($tglLahir, ' ');
      $tglLahir = $this->findMonth($tglLahir);

      $tglLahir = Str::endsWith($tglLahir, '-') ? rtrim($tglLahir, '-') : $tglLahir;
      $tglLahir = $this->find_date($tglLahir);
    }

    return $tglLahir;
  }



  public function getTglBerobat()
  {
    $questions = $this->getWaTableData('questions');


    if ($questions == 'tglBerobat') {
      $date= $this->find_date($this->senderMessage());
      $this->updateWaTable('tgl_berobat', $date);
      // return "okeh";
    }

    if ($questions == 'pilih poli') {
      $date = $this->getWaTabledata('tgl_berobat');

    }

    $tgl = Str::of($this->senderMessage())->replaceMatches("/tgl berobat|tanggal periksa|tgl registrasi|tanggal registrasi|tanggal berobat|berobat(tgl-bln-thn)/", 'tgl berobat');

    $isExist = Str::of($tgl)->contains('tgl');

    // if ($isExist){


    $date = Str::of($tgl)->replace('(tgl-bln-thn)', '');
    $date = Str::after($date, 'tgl berobat');

    $explode = explode('-', $date);
    $grep = preg_grep('/[0-9]{2}|[0-9]{2}[a-z][0-9]{4}/', $explode);
    $date = implode('-', $grep);
    $date = trim($date, ' ');
    $date = $this->findMonth($date);

    if ($isExist) {

      $date = $this->find_date($date);
      $date = date('Y-m-d', strtotime($date));
    } else {

      $date = $this->getWaTabledata('tgl_berobat');
    }

    $this->updateWaTable('tgl_berobat', $date);
   
    return $date;


    // }else{
    // }


  }


  public function find_date($string)
  {
    $shortenize = function ($string) {
      return substr($string, 0, 3);
    };

    // Define month name:
    $month_names = array(
      "january",
      "february",
      "march",
      "april",
      "may",
      "june",
      "july",
      "august",
      "september",
      "october",
      "november",
      "december"
    );
    $short_month_names = array_map($shortenize, $month_names);

    // Define day name
    $day_names = array(
      "monday",
      "tuesday",
      "wednesday",
      "thursday",
      "friday",
      "saturday",
      "sunday"
    );
    $short_day_names = array_map($shortenize, $day_names);

    // Define ordinal number
    $ordinal_number = ['st', 'nd', 'rd', 'th'];

    $day = "";
    $month = "";
    $year = "";


    //match 2020-09-20
    $dateWithStrip = preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $string);
    // return $matches;

    //match 2020/09/20
    $dateWithSlash = preg_match('/[0-9]{4}\/[0-9]{2}\/[0-9]{2}/', $string);

    //match 2020 09 20
    $dateWithSpace = preg_match('/[0-9]{4} [0-9]{2}/', $string);

    //match 20 09 2020
    $dateWithSpace2 = preg_match('/[0-9]{2} [0-9]{2}/', $string);

    if (preg_match('/[0-9]{6}/', $string)) {

      $split = str_split($string, 2);
      $date = implode('-', $split);
    }

    if ($dateWithSpace || $dateWithSpace2) {
      $date = explode(" ", $string);
      $date = implode('-', $date);
    }

    $strTotimeDate = strtotime($date);

    if ($strTotimeDate == date('m-d-Y') || $strTotimeDate == date('m-d-y') || $strTotimeDate == date('Y-d-m') || $strTotimeDate == date('d-m-Y') || $strTotimeDate == date('y-m-d') || $strTotimeDate == date('d-m-y')) {
      $date = date('Y-m-d', $strTotimeDate);
    } else if ($dateWithStrip || $dateWithSlash || $dateWithSpace) {
     
      return $this->formatTgl($date);
    }

    // Match dates: 01/01/2012 or 30-12-11 or 1 2 1985
    preg_match('/([0-9]?[0-9])[\.\-\/\s ]+([0-1]?[0-9])[\.\-\/\s ]+([0-9]{2,4})/', $string, $matches);
    if ($matches) {
      if ($matches[1])
        $day = $matches[1];
      if ($matches[2])
        $month = $matches[2];
      if ($matches[3])
        $year = $matches[3];
    }


    // Match dates: Sunday 1st March 2015; Sunday, 1 March 2015; Sun 1 Mar 2015; Sun-1-March-2015
    preg_match('/(?:(?:' . implode('|', $day_names) . '|' . implode('|', $short_day_names) . ')[ ,\-_\/]*)?([0-9]?[0-9])[ ,\-_\/]*(?:' . implode('|', $ordinal_number) . ')?[ ,\-_\/]*(' . implode('|', $month_names) . '|' . implode('|', $short_month_names) . ')[ ,\-_\/]+([0-9]{4})/i', $string, $matches);
    if ($matches) {
      if (empty($day) && $matches[1])
        $day = $matches[1];

      if (empty($month) && $matches[2]) {
        $month = array_search(strtolower($matches[2]),  $short_month_names);

        if (!$month)
          $month = array_search(strtolower($matches[2]),  $month_names);

        $month = $month + 1;
      }

      if (empty($year) && $matches[3])
        $year = $matches[3];
    }

    // Match dates: March 1st 2015; March 1 2015; March-1st-2015
    preg_match('/(' . implode('|', $month_names) . '|' . implode('|', $short_month_names) . ')[ ,\-_\/]*([0-9]?[0-9])[ ,\-_\/]*(?:' . implode('|', $ordinal_number) . ')?[ ,\-_\/]+([0-9]{4})/i', $string, $matches);
    if ($matches) {
      if (empty($month) && $matches[1]) {
        $month = array_search(strtolower($matches[1]),  $short_month_names);

        if (!$month)
          $month = array_search(strtolower($matches[1]),  $month_names);

        $month = $month + 1;
      }

      if (empty($day) && $matches[2])
        $day = $matches[2];

      if (empty($year) && $matches[3])
        $year = $matches[3];
    }

    // Match month name:
    if (empty($month)) {
      preg_match('/(' . implode('|', $month_names) . ')/i', $string, $matches_month_word);
      if ($matches_month_word && $matches_month_word[1])
        $month = array_search(strtolower($matches_month_word[1]),  $month_names);

      // Match short month names
      if (empty($month)) {
        preg_match('/(' . implode('|', $short_month_names) . ')/i', $string, $matches_month_word);
        if ($matches_month_word && $matches_month_word[1])
          $month = array_search(strtolower($matches_month_word[1]),  $short_month_names);
      }

      $month = $month + 1;
    }

    // Match 5th 1st day:
    if (empty($day)) {
      preg_match('/([0-9]?[0-9])(' . implode('|', $ordinal_number) . ')/', $string, $matches_day);
      if ($matches_day && $matches_day[1])
        $day = $matches_day[1];
    }

    // Match Year if not already setted:
    if (empty($year)) {
      preg_match('/[0-9]{4}/', $string, $matches_year);
      if ($matches_year && $matches_year[0])
        $year = $matches_year[0];
    }
    if (!empty($day) && !empty($month) && empty($year)) {
      preg_match('/[0-9]{2}/', $string, $matches_year);
      if ($matches_year && $matches_year[0])
        $year = $matches_year[0];
    }

    // Day leading 0
    if (1 == strlen($day))
      $day = '0' . $day;

    // Month leading 0
    if (1 == strlen($month))
      $month = '0' . $month;

    // Check year:
    if (2 == strlen($year) && $year > 20)
      $year = '19' . $year;
    else if (2 == strlen($year) && $year < 20)
      $year = '20' . $year;

    $date = array(
      'year'  => $year,
      'month' => $month,
      'day'   => $day
    );

    // Return false if nothing found:
    if (empty($year) && empty($month) && empty($day))
      return false;
    else

      return implode('-', $date);
  }
}
