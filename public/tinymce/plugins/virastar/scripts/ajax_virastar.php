<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header("Content-Type: text/html; charset=utf-8");
/**************************************************************/
include_once('../../conf.php');

$request = new Request(SECURITY_DOMAIN);

$str = trim(strip_tags($request->getParameter('string')));
$psnumber = trim(strip_tags($request->getParameter('psnumber')));
if (strlen($str) >= 1) {
    $virastObj = new SepehrVirastar();
    $str = $virastObj->virast($str, array('r53', 'r53-2'), array('persian_number' => $psnumber));
    echo json_encode(array(
        'virast'  => $str,
        'success' => true
    ));
} else {
    echo json_encode(array(
        'success' => false
    ));
}


