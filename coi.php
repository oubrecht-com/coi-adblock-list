<?php
//Vytvořil OUBRECHT.com


//ČOI CSV url adresa rizikových webů
$coi_open_data = "https://www.coi.cz/userdata/files/dokumenty-ke-stazeni/open-data/rizikove.csv";

//načíst data
$coi_open_data = file_get_contents($coi_open_data);
//file_put_contents("rizikove.csv", $coi_open_data);

//kontrola dat
if(strlen($coi_open_data)<10){exit("CHYBA: Staženo příliš málo dat");};

//rozsekat data po řádcích
$coi_open_data = explode(PHP_EOL, $coi_open_data);

//smazat starý soubor
unlink("coi_adblock.txt");

//otevřít soubor/vytvořit
$coi_adblock = fopen("coi_adblock.txt", "a");

//zapsat hlavičku do souboru
fwrite($coi_adblock, "[Adblock Plus 2.0]\n");
fwrite($coi_adblock, "! Title: COI rizikove weby\n");
fwrite($coi_adblock, "! Description: Adblock list poskladany z verejnych dat COI rizikove weby.\n");
fwrite($coi_adblock, "! Version: ".time()."\n");
//fwrite($coi_adblock, "! TimeUpdated: ".date("Y-m-d", time())."T".date("H:i:s", time())."+12:00\n");   //čas vytvoření, na konci 12:00 je čas za jak dlouho se tento soubor mění
fwrite($coi_adblock, "! Expires: 1 days (update frequency)\n");
fwrite($coi_adblock, "! Homepage: https://oubrecht.com\n");
fwrite($coi_adblock, "! License: https://oubrecht.com\n\n\n");


//zpracovat řádek po řádku
foreach($coi_open_data as $url){
    $url = str_replace(array("\n", "\r"), '', $url);
    if(explode(".", $url)[1]==NULL){continue;};//přeskočit weby/řádky, které neobsahují tečku (.) v adrese
    $data = "||".$url."^"."\n"; //vytvořit řádek do filtru
    //echo $data;
    fwrite($coi_adblock, $data); //zapsat řádek do souboru
;};

//zavřít soubor/dokončit
fclose($coi_adblock);
;?>
