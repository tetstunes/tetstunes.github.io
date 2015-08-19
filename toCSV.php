<?php

$out = fopen('tracklist.csv', 'w');
fwrite($out,"Date,Track Number, Song, Artist, Album\n");

$files = scandir('.');

foreach($files as $file)
{
  if(strpos($file, '.html') !== false && strpos($file, 'index') === false)
  {
    $date = str_replace('.html','',$file);
    $html = file_get_contents($file);
    $tbody = get_string_between($html, "<tbody>", "</tbody");
    $tbody = str_replace(',', ' ', $tbody);
    $tbody = str_replace('<tr>', '', $tbody);
    $tbody = str_replace('</tr>', '', $tbody);
    $tbody = str_replace('<td>', '', $tbody);
    $tbody = str_replace('</td>', ',', $tbody);
    $tbody = str_replace('<th>', '', $tbody);
    $tbody = str_replace('</th>', ',', $tbody);   
    
    $rows = explode("\n", $tbody);
    foreach($rows as $row){
       if(strlen($row) < 2) { continue; }
       $row = trim($row);
       $row = rtrim($row, ",");
       $row = $date.",".$row;
       $rowArray = explode(',', $row);
       fputcsv($out, $rowArray);
    } 
  }
}

fclose($out);

function get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}
