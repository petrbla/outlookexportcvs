<?php
/*
 * exportcvsoutlock.php
 * version 0.1
 * programing petrbla@gmail.com
 * vytvoreno 02 2015
 */
 
 include_once './conectdb.php';
 
function array2csv(array &$array){
   if(count($array)==0){return null;}
   ob_start();
   $df = fopen("php://output", 'w');
   foreach($array as $row){fputcsv($df, $row);}
   fclose($df);
   return ob_get_clean();
}

function download_send_headers($filename) {
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
	header('Content-Encoding: windows-1250');
    header('Content-type: text/csv; charset=windows-1250');
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}

$jmeno=iconv('utf-8','windows-1250', "Jméno");
$email=iconv('utf-8','windows-1250', "E-mailová adresa");
$list[]=array("$jmeno", "$email");
$vysledek = mysql_query("SELECT * FROM `uzivatele` ORDER BY `id` ASC");
while ($zaznam = MySQL_Fetch_Array($vysledek)){
	$jmeno=iconv('utf-8','windows-1250', $zaznam[jmeno]);
	$email=iconv('utf-8','windows-1250', $zaznam[email]);
	$list[]=array("$jmeno", "$email");
}

download_send_headers("zakaznik_export_" . date("Y-m-d") . ".csv");
echo array2csv($list);
die();
