<?php
require_once dirname(__FILE__).'/Service.php';
$service = new Service();
$refererUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

$resultJson = $service->doConvert($refererUrl);
$result = json_decode($resultJson, true);
$result = count($result) > 0? $result[0]:['network'=>'', 'html'=>''];
$matchedNetworks = $result['network'];
$generatedCode = html_entity_decode($result['html'], ENT_QUOTES);

//$resultJson = $service->doConvertAll($refererUrl);
//$result = json_decode($resultJson, true);
//$matchedNetworks = implode(',', $result['networks']);
//$generatedCode = html_entity_decode($result['html'], ENT_QUOTES);


