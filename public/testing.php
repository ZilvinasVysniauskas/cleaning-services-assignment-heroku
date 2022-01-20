<?php

function generateRandomString($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function generateRandomNumber($length = 10) {
    $characters = '0147258369';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$arr = [];
$x = 0;
while ($x < 1000){
    $arr[] = [generateRandomString(rand(4, 10)), generateRandomString(rand(4, 10)) . '@' . generateRandomString(rand(3, 6)) . '.com',
        '+3706' . generateRandomNumber(7), generateRandomString(rand(4, 10)) . " Street " . generateRandomNumber(2) . '-' . generateRandomNumber(3),
        date('Y-m-d', rand(1641038386,1652487964 )), rand(0, 22) . ':00'];
    $x++;
}
$file = fopen('./files/records.csv' , 'w');
foreach ($arr as $csvLine){
    fputcsv($file, $csvLine);
}
fclose($file);