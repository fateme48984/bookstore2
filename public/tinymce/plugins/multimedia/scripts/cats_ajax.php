<?php
require_once('../../conf.php');
//-----------------------------------------------------------------------
function purifyData($data, $htmlpurifier, $htmlpurifierConfig) {
    foreach($data as $key=>$value){
        $data[$key] = strip_tags($htmlpurifier->purify(htmlspecialchars_decode(strip_tags($value)), $htmlpurifierConfig));
    }
    return $data;
}
//-----------------------------------------------------------------------
function validateData($data, $opr){
   if($opr == 'get_childs'){
    	if(is_array($data) && count($data) > 0){
    		foreach($data as $child){
    			if(is_numeric($child) && $child > 0){
    				return true;
    			}
    		}
    	}
    }
    return false;
}
//-----------------------------------------------------------------------
$request   = new Request(SECURITY_DOMAIN);
$action    = trim(strip_tags($request->getParameter('action')));
$isValid   = false;
//-----------------------------------------------------------------------
$htmlpurifier       = new HTMLPurifier();
$htmlpurifierConfig = HTMLPurifier_Config::createDefault();

$multimediaCatsObj = new MultimediaCats();
switch($action){
    case 'get_childs':
    	$childs = $request->getParameter('cat_childs');
    	$childs = purifyData($childs, $htmlpurifier, $htmlpurifierConfig);
		if(validateData($childs, 'get_childs')){
			$isValid = true;
        	//If success
            if($childsHtml = $multimediaCatsObj->drawSubCatsTree($childs)){
                $result['success'] = true;
                $result['childs_html'] = $childsHtml;
            } else {
                 
            }
        }
    	break;
    default:
        break;
}

if($isValid == false){
	$result['success'] = false;
	$result['message'] = 'پارامتر های ورودی معتبر نمی باشد';
}

if(!isset($result['success'])){
	$result['success'] = false;
	$result['message'] = 'انجام عملیات با مشکل مواجه شد';
}

echo json_encode($result);