<?php
include_once('../../conf.php');
//-----------------------------------------------------------------------
function purifyData($data, $htmlpurifier, $htmlpurifierConfig) {
    return $htmlpurifier->purify(htmlspecialchars_decode(strip_tags($data)), $htmlpurifierConfig);
}

//-----------------------------------------------------------------------
function parseResults($multimediaFilesObj, $fileGroup, $results, $catID, $cntAllRows, $page = 1,$action = 'list', $tpl = 'editor_search.tpl' , $language = 'EN'){
	if(is_array($results) && count($results) > 0){
		$dateObj = new Date();
		foreach($results as $key=>$result){
			$ext = File::getFileExtention($result['filename']);
			$icon="ico_unknown.gif";
			if($ext=="asp")$icon="ico_asp.gif";
			if($ext=="bmp")$icon="ico_bmp.gif";
			if($ext=="css")$icon="ico_css.gif";
			if($ext=="doc")$icon="ico_doc.gif";
			if($ext=="exe")$icon="ico_exe.gif";
			if($ext=="gif")$icon="ico_gif.gif";
			if($ext=="htm")$icon="ico_htm.gif";
			if($ext=="html")$icon="ico_htm.gif";
			if($ext=="jpg")$icon="ico_jpg.gif";
			if($ext=="js")$icon="ico_js.gif";
			if($ext=="mdb")$icon="ico_mdb.gif";
			if($ext=="mov")$icon="ico_mov.gif";
			if($ext=="mp3")$icon="ico_mp3.gif";
			if($ext=="pdf")$icon="ico_pdf.gif";
			if($ext=="png")$icon="ico_png.gif";
			if($ext=="ppt")$icon="ico_ppt.gif";
			if($ext=="mid")$icon="ico_sound.gif";
			if($ext=="wav")$icon="ico_sound.gif";
			if($ext=="wma")$icon="ico_sound.gif";
			if($ext=="swf")$icon="ico_swf.gif";
			if($ext=="txt")$icon="ico_txt.gif";
			if($ext=="vbs")$icon="ico_vbs.gif";
			if($ext=="avi")$icon="ico_video.gif";
			if($ext=="wmv")$icon="ico_video.gif";
			if($ext=="mpeg")$icon="ico_video.gif";
			if($ext=="mpg")$icon="ico_video.gif";
			if($ext=="xls")$icon="ico_xls.gif";
			if($ext=="zip")$icon="ico_zip.gif";
			$results[$key]['icon'] = '../../../images/'.$icon;
			
			$fileFinalUploadPath = $multimediaFilesObj->getFinalUploadPathBySdate($result['sdate']);
			if(file_exists($fileFinalUploadPath.'/'.$result['filename'])){
				if($result['file_group'] == 'I'){
					$fileInfo 					= getimagesize($fileFinalUploadPath.'/'.$result['filename']);
					$results[$key]['width']		= $fileInfo[0];
					$results[$key]['height']	= $fileInfo[1];
					$results[$key]['size']		= round(filesize($fileFinalUploadPath.'/'.$result['filename'])/1024, 3);
				} elseif($result['file_group'] == 'V'){
					$results[$key]['size']		= round(filesize($fileFinalUploadPath.'/'.$result['filename'])/1024/1024, 3);
				} elseif($result['file_group'] == 'S'){
					$results[$key]['size']		= round(filesize($fileFinalUploadPath.'/'.$result['filename'])/1024/1024, 3);
				}
				$results[$key]['final_uplaod_uri'] = str_replace($_SERVER['DOCUMENT_ROOT'], '', $fileFinalUploadPath);
				$sDateArr 					= $dateObj->explodeDate($result['sdate']);
				$results[$key]['sdate']		= $dateObj->format($sDateArr, '%H:%i - %Y/%m/%d');
				$results[$key]['description'] = nl2br($result['description']);
				$results[$key]['tags'] 		= implode('، ', SepehrString::explodeByNewLine($result['tags']));
			}
		}
		
		if($action == 'search'){
			$nextOnClick = 'doSearch('.($page+1).');return false;';
			$prevOnClick = 'doSearch('.($page-1).');return false;';
		} else {
			$nextOnClick = 'getFiles('.$catID.','.($page+1).');return false;';
			$prevOnClick = 'getFiles('.$catID.','.($page-1).');return false;';
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
		//sepehrString::dump($pager);
        if($language == 'FA') {
            $pagerHtml = $pager->renderPager($pagerTemplateArray, 'FA', '', 'page', array());
        } else {
            $pagerHtml = $pager->renderPager($pagerTemplateArray, 'EN', '', 'page', array());
        }

		$smartyObj = $multimediaFilesObj->getSmartyInstance();
		$smartyObj->assign('type', $fileGroup);
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
$fileGroup	= trim(strip_tags($request->getParameter('file_group')));
$addby		= trim(strip_tags($request->getParameter('addby', '*')));
$catID		= trim(strip_tags($request->getParameter('cat_id', '*')));
$page		= trim(strip_tags($request->getParameter('page', 1)));
//-----------------------------------------------------------------------
$htmlpurifier       = new HTMLPurifier();
$htmlpurifierConfig = HTMLPurifier_Config::createDefault();

switch ($action) {
	case 'cat_name':
		if(is_numeric($catID) && $catID > 0){
			$isValid = true;
			$result['success'] = true;
			$multimediaCatsObj = new MultimediaCats();
			$result['message'] = $multimediaCatsObj->getCatName($catID);
		} else {
			$result['success'] = false;
			$result['message'] = '';
		}
		break;
	case 'list':
		if(is_numeric($catID) && $catID > 0){
			if(in_array($fileGroup, array('I', 'V', 'S'))){
				if(is_numeric($page) && $page >0){
					$isValid = true;
					
					$multimediaFilesObj = new MultimediaFiles();
					list($cntAllRows, $results) = $multimediaFilesObj->getFiles($catID, $page, 15, $fileGroup);
					$result = parseResults($multimediaFilesObj, $fileGroup, $results, $catID, $cntAllRows, $page, 'list','editor_search.tpl' ,$language );
				}
			}
		}
	break;
	
	case 'search':
		if(!empty($query) && strlen($query) > 1 && strlen($query) < 200){
			if(in_array($fileGroup, array('I', 'V', 'S'))){
				if(!empty($addby) && strlen($addby) >= 1 && strlen($addby) < 200){
					if((is_numeric($catID) && $catID > 0) || $catID == '*'){
						if(is_numeric($page) && $page > 0){
							$isValid = true;
							$query = purifyData($query, $htmlpurifier, $htmlpurifierConfig);
							
							$multimediaFilesObj = new MultimediaFiles();
							
							$where .= 'file_group = "'.$fileGroup.'" AND';
							
							if($catID != '*'){
								$where .= ' cat_id = "'.$catID.'" AND';
							}
							
							if($addby != '*'){
								$where .= ' '.MULTIMEDIA_FILES.'.addby = "'.$addby.'" AND';
							}
							
							$where .= ' MATCH (filename,description,tags) AGAINST ("'.$query.'*" in boolean mode)';
							
							list($cntAllRows, $results) = $multimediaFilesObj->searchFiles($page, 15, $where);
							$result = parseResults($multimediaFilesObj, $fileGroup, $results, $catID, $cntAllRows, $page, 'search','editor_search.tpl' ,$language );
						}
					}
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