<?php
header('Content-type: text/plain; charset=utf-8');
header('Cache-Control: no-store, no-cache');
//header('Expires: ' . date('r'));

$response = [];
$response['h1'] = $header_title;
$response['count'] = $countCompany;
$response['filters'] = $filters;
if($navLetters->list) $response['listLetters'] = $navLetters->list;
$response['listCompany'] = $listCompany;
//$response['navparams'] = $navparams;

echo json_encode($response);

?>