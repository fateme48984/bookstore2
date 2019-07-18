<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header("Content-Type: text/html; charset=utf-8");
/**************************************************************/
include_once('../../conf.php');


require_once 'wrapper/ZendDb.class.php';
require_once 'wrapper/ZendDbTable.class.php';

$request = new Request(SECURITY_DOMAIN);
$url = trim(strip_tags($request->getParameter('url')));
$cid = trim(strip_tags($request->getParameter('cid')));
$contentType = trim(strip_tags($request->getParameter('ctype')));
$moduleCode = trim(strip_tags($request->getParameter('moduleCode')));

if (!empty($contentType) && in_array($contentType, $contentTypes) && is_numeric($moduleCode) && in_array($moduleCode, $modulesCode[$contentType])) {
    if (is_numeric($cid) && $cid > 0) {

        define('MODULE_CODE', $moduleCode);
        $authorizationObj = new Authorization();
        $authorizationObj->authorize();
        $username =$authorizationObj->getUserName();

        $dateObj = new Date();
        $lang = new Langs();
        $config = $GLOBALS['config'];
        $calendar = $lang->getLangCalendar($config->get('site.app_lang'));
        $sdate = $dateObj->getDate($calendar, '%Y%m%d%H%i%s');

        $config = $GLOBALS['config'];
        $dbAdapter = Zend_Db::factory('Pdo_Mysql', array(
                'host'     => $config->get('db.host'),
                'username' => $config->get('db.user'),
                'password' => $config->get('db.pass'),
                'dbname'   => $config->get('db.name'),
                'charset'  => $config->get('db.charset')
            )
        );


        Zend_Db_Table::setDefaultAdapter($dbAdapter);
        $steamTable = new Zend_Db_Table('stream_url');

        $data['data_id'] = $cid;
        $data['url'] = $url;
        $data['add_by'] = $username;
        $data['add_date'] = $sdate;
        $data['content_type'] = $contentType;
        if ($id = $steamTable->insert($data)) {
            $result['success'] = true;
            $result['id'] = $id;
            echo json_encode($result);
        } else {
            $result['success'] = false;
            $result['message'] = 'عملیات با مشکل مواجه شد';
            echo json_encode($result);
        }


    } else {
        $result['success'] = false;
        $result['message'] = 'اطلاعات وارد شده نامعتبر می باشد.';
        echo json_encode($result);
    }
} else {
    $result['success'] = false;
    $result['message'] = 'پارامترهای ورودی معتبر نمی باشد';
    echo json_encode($result);
}

