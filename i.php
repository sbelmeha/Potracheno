<?php
// Turn off all error reporting
error_reporting(0);
ini_set("display_errors", 0);

$name = key($_GET);
$name = str_replace (' ','+',$name);
$request = "http://www.omdbapi.com/?t=".$name."&y=&plot=full&r=json";
$json = file_get_contents($request);
$info = json_decode($json);

$title = $info->Title;
$time = getNumberFromString($info->Runtime);

if ($time) {
  getTimeFromFile() ? saveTimeToFile($time+getTimeFromFile()) : saveTimeToFile($time);
}

function showAllTime(){
  $minutes = getTimeFromFile();
  $d = floor ($minutes / 1440);
  $h = floor (($minutes - $d * 1440) / 60);
  $m = $minutes - ($d * 1440) - ($h * 60);
  echo "Потрачено  {$d}д {$h}ч {$m}м";
}

function getNumberFromString($str){
  preg_match_all('!\d+!', $str, $matches);
  return implode(' ', $matches[0]);
}

function getTimeFromFile(){
  $file = fopen("file.txt", "r") or die("Unable to open file!");
  $time_=fgets($file);
  fclose($file);
  return $time_;
}

function saveTimeToFile($t){
  $file = fopen("file.txt", "w") or die("Unable to open file!");
  fwrite($file, $t);
  fclose($file);
}

?>

<html>
<head>
<title><? showAllTime();?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style>
html, body {margin:50px;}
</style>
</head>
<body>

<center>
  <h1><? showAllTime();?></h1>
  <img src="<?echo $info->Poster;?>">
  <h2><? echo $title;?></h2>
</center>

</body>
</html>