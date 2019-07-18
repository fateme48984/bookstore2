<?php 

require_once('../../conf.php');
//------------------------------------------------------
$request  = new Request(SECURITY_DOMAIN);
$imgUrl       = $request->getParameter('imgUrl');
$width         = $request->getParameter('width');
$height        = $request->getParameter('height');

if(!empty($imgUrl) && !empty($width) && !empty($height)) {
	
	$imagePath = PUBLIC_ROOT.$imgUrl;
	if(file_exists($imagePath)){
		$imagickObj = new Imagick($imagePath);

		$path = dirname($imagePath);
		$outThumbnail = $path.'/thumb';

		if(!is_dir($outThumbnail)){
			File::mkdirs($outThumbnail, DIR_WRITEABLE_MOD);
		}
		
		$fileName = rand(100,1000).'_'.basename($imgUrl);
		
		$imagickObj->thumbnailimage($width , $height);
		
		if($imagickObj->writeimage($outThumbnail.'/thm_'.$fileName)) {
			$result['success'] = true;
			$imgUrl = dirname($imgUrl);
			$result['message'] = $imgUrl.'/thumb/thm_'.$fileName;
			$imagickObj->clear();
			$imagickObj->destroy();
		} else {
			$result['success'] = false;
			$result['message'] = 'عملیات با مشکل مواجه شد';
		}
	
	}

}else {
	$result['success'] = false;
	$result['message'] = 'پارامتر های ورودی معتبر نمی باشد';
}

echo json_encode($result);