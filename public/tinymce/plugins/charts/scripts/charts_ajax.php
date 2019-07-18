<?php
include_once('../../conf.php');
//-----------------------------------------------------------------------
function purifyData($data, $htmlpurifier, $htmlpurifierConfig) {
    return $htmlpurifier->purify(htmlspecialchars_decode(strip_tags($data)), $htmlpurifierConfig);
}
//-----------------------------------------------------------------------
function parseResults($chartFieldObj, $results, $dsID, $cntAllRows, $page = 1,$action = 'list', $tpl = 'editor_search.tpl' , $language){
	
	if(is_array($results) && count($results) > 0){
		foreach($results as $key=>$result){

			$results[$key]['icon'] = "../icons/ico_chart.png";
			
			switch($result['chart_type']) {
				case 'L':
					$type = 'خطی';
					break;
						
				case 'C':
					$type = 'استوانه ای';
					break;
						
				case 'B':
					$type = 'میله ای';
					break;
					
				case 'P':
					$type = 'دایره ای';
					break;
					
				case 'A':
					$type = 'ناحیه ای';
					break;
					
				case 'S':
					$type = 'نقطه ای';
					break;
			}
			unset($results[$key]['chart_type']);
			$results[$key]['chart_type'] = $type;
		}
		
		if($action == 'search'){
			$nextOnClick = 'doSearch('.($page+1).');return false;';
			$prevOnClick = 'doSearch('.($page-1).');return false;';
		} else {
			$nextOnClick = 'getCharts('.$dsID.','.($page+1).');return false;';
			$prevOnClick = 'getCharts('.$dsID.','.($page-1).');return false;';
		}
        if($language == 'FA') {
            $direction ='rtl';
        } else {

            $direction ='ltr';
        }
		
		$pager = new Pager($cntAllRows, 15, $page);
		$pagerTemplateArray[0] = '<table cellpadding="0" cellspacing="0" border="0" style="direction:'.$direction.';width:153px;height:18px;margin: 0px auto;" id="pager">
									<tr>
									<td style="width:100px;text-align:center;">{page} <input name="page" id="page" type="text" size="4" value="{current}" onchange="pageChanged(this)" style="width:45px;"></td>
									<td style="width:35px;text-align:center;">{of} {total}</td>
									<td style="width:18px;"><a title="{next}" href="#" onclick="'.$nextOnClick.'">»</a></td>
									</tr></table>';
		$pagerTemplateArray[1] = '<table cellpadding="0" cellspacing="0" border="0" style="direction:'.$direction.';width:171px;height:18px;margin: 0px auto;" id="pager">
									<tr>
									<td style="width:18px;"><a title="{previous}" href="#" onclick="'.$prevOnClick.'">«</a></td>
									<td style="width:100px;text-align:center;">{page} <input name="page" id="page" type="text" size="4" value="{current}" onchange="pageChanged(this)" style="width:45px;"></td>
									<td style="width:35px;text-align:center;">{of} {total}</td>
									<td style="width:18px;"><a title="{next}" href="#" onclick="'.$nextOnClick.'">»</a></td>
									</tr></table>';
		$pagerTemplateArray[2] = '<table cellpadding="0" cellspacing="0" border="0" style="direction:'.$direction.';width:153px;height:18px;margin: 0px auto;" id="pager">
									<tr>
									<td style="width:18px;"><a title="{previous}" href="#" onclick="'.$prevOnClick.'">«</a></td>
									<td style="width:100px;text-align:center;">{page} <input name="page" id="page" type="text" size="4" value="{current}" onchange="pageChanged(this)" style="width:45px;"></td>
									<td style="width:35px;text-align:center;">{of} {total}</td>
									</tr></table>';
        if($language == 'FA') {
            $pagerHtml = $pager->renderPager($pagerTemplateArray, 'FA', '', 'page', array());
        } else {
            $pagerHtml = $pager->renderPager($pagerTemplateArray, 'EN', '', 'page', array());
        }
		
		$smartyObj = $chartFieldObj->getSmartyInstance();
		$smartyObj->assign('results', $results);
		$smartyObj->assign('pager', $pagerHtml);
			
		$result['success'] = true;
		$result['message'] = $smartyObj->fetch('editor_search.tpl');
	} else {
		$result['success'] = true;
		$result['message'] = '';
	}
	
	
	return $result;
}
//-----------------------------------------------------------------------
$request   = new Request(SECURITY_DOMAIN);
$action		= trim(strip_tags($request->getParameter('action', 'list')));
$query		= trim(strip_tags(stripcslashes(html_entity_decode($request->getParameter('query')))));
$dsID		= trim(strip_tags($request->getParameter('ds_id', '*')));
$page		= trim(strip_tags($request->getParameter('page', 1)));
//-----------------------------------------------------------------------
$htmlpurifier       = new HTMLPurifier();
$htmlpurifierConfig = HTMLPurifier_Config::createDefault();

switch ($action) {
	case 'datasheet_name':
		if(is_numeric($dsID) && $dsID > 0){
			$isValid = true;
			$result['success'] = true;
			$datasheetObj = new ChartDataSheet();
			$result['message'] = $datasheetObj->getDatasheetName($dsID);
		} else {
			$result['success'] = false;
			$result['message'] = '';
		}
		break;
	case 'list':
		if(is_numeric($dsID) && $dsID > 0){
			
			if(is_numeric($page) && $page >0){
				$isValid = true;
					
				
				$chartFieldObj = new ChartField();
				$where['ds_id']= $dsID;
				list($cntAllRows, $results) = $chartFieldObj->getCharts($page, 15, $where);
				
				$result = parseResults($chartFieldObj, $results, $dsID, $cntAllRows, $page, 'list','editor_search.tpl' , $language);
				
			}
			
		}
	break;
	
	case 'search':
		if(!empty($query) && strlen($query) > 1 && strlen($query) < 200){
				if((is_numeric($dsID) && $dsID > 0) || $dsID == '*'){
						if(is_numeric($page) && $page > 0){
							$isValid = true;
							$query = purifyData($query, $htmlpurifier, $htmlpurifierConfig);
							
							$chartFieldObj = new ChartField();
							/* 
							
							if($dsID != '*'){
								$where .= ' ds_id = "'.$dsID.'" AND';
							}
							

							$where .= ' MATCH (title,y_title,x_title) AGAINST ("'.$query.'*" in boolean mode)'; */
							
							list($cntAllRows, $results) = $chartFieldObj->searchCharts($page, 15, $query , $dsID);
							$result = parseResults($chartFieldObj, $results, $dsID, $cntAllRows, $page, 'search','editor_search.tpl' , $language);
						}
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
	$result['message'] = $result['message'];
}

echo json_encode($result);