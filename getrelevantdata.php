<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$contents = file_get_contents('files/input/resemails.txt');

preg_match_all('(Name: \w+[- \w]*[ ]\w+)', $contents, $names, PREG_PATTERN_ORDER);

preg_match_all('(Contact Email: \w+([.-][\w]+)*[@]\w+[.]\w+[.\w]*)', $contents, $emails, PREG_PATTERN_ORDER);

preg_match_all('(Date: \d{1,2}[/]\d{1,2}[/]\d{2,4})', $contents, $dates, PREG_PATTERN_ORDER);

preg_match_all('(Post Code: [A-Za-z0-9]{3}[ ]*[A-Za-z0-9]{3})', $contents, $pcode, PREG_PATTERN_ORDER);

$trimnames = array();
$trimemails = array();
$trimdates = array();
foreach($names as $key){
    foreach($key as $val){
    $trimmed = substr_replace($val,"",0,6);
    array_push($trimnames,$trimmed);
    }
}

foreach($emails as $key){
    foreach($key as $val){
       $trimmedem = substr_replace($val,"",0,15);
    array_push($trimemails,$trimmedem);   
    }
}

foreach($dates as $key){
    foreach($key as $val){
       $trimmedate = substr_replace($val,"",0,6);
    array_push($trimdates,$trimmedate);   
    }
}

$count = count($trimdates);
$n = 0;
$file = fopen('files/output/data.csv', 'w+');
fwrite($file, 'name,email,date' . PHP_EOL);
for ($n === 0; $n <= $count; $n++) {
    if ($trimemails[$n] && $trimnames[$n] && $trimdates[$n]) {
        fwrite($file,$trimnames[$n] . ',' . $trimemails[$n] . ',' . $trimdates[$n] . PHP_EOL);
    }
}

