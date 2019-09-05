<?php
header('Content-type: text/plain; charset=utf-8');
header('Cache-Control: no-store, no-cache');
//header('Expires: ' . date('r'));

$response = [];
$response['h1'] = $header_title;
$response['count'] = $countCompany;
$response['filters'] = $filters;
if($listLetters) $response['listLetters'] = $listLetters;
$response['listCompany'] = $listCompany;
//$response['navparams'] = $navparams;

echo json_encode($response);

?>