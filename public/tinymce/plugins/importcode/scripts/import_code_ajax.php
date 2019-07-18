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
$code = $request->getParameter('code');
$cid = trim(strip_tags($request->getParameter('cid')));
$moduleCode = trim(strip_tags($request->getParameter('moduleCode')));

if (!empty($code) && is_numeric($moduleCode) && is_numeric($cid) && $cid > 0) {

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
            $codeTable = new Zend_Db_Table('news_jscode');

            $data['data_id'] = $cid;
            $data['code'] = $code;
            $data['add_by'] = $username;
            $data['add_date'] = $sdate;
            if ($id = $codeTable->insert($data)) {
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
    $result['message'] = 'پارامترهای ورودی نامعتبر است';
    echo json_encode($result);
}


