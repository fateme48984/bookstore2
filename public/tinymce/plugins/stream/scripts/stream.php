<?php
include_once('../../conf.php');


require_once 'wrapper/ZendDb.class.php';
require_once 'wrapper/ZendDbTable.class.php';

$request = new Request(SECURITY_DOMAIN);
$cid = trim(strip_tags($request->getParameter('cid')));
$contentType = trim(strip_tags($request->getParameter('ctype')));
$moduleCode = trim(strip_tags($request->getParameter('moduleCode')));

if (!empty($contentType) && in_array($contentType, $contentTypes) && is_numeric($moduleCode) && in_array($moduleCode, $modulesCode[$contentType])) {
    if (is_numeric($cid) && $cid > 0) {

        define('MODULE_CODE', $moduleCode);
        $authorizationObj = new Authorization();
        $authorizationObj->authorize();

    } else {
       exit();
    }
} else {
    exit();
}


?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="../../../skins/ui/oxide/skin.min.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="<?php echo THEME_URI ?>/js/lib/lib.js"></script>

    <script>

        function insertMedia() {
            var source = document.getElementById('file_uri').value;
            if (isUrl(source)) {

                var url = document.getElementById('file_uri').value;
                var cid = window.parent.tinyMCE.activeEditor.getParam('content_id');
                var moduleCode = window.parent.tinyMCE.activeEditor.getParam('module_code');
                var ctype = window.parent.tinyMCE.activeEditor.getParam('content_type');
                $.post("stream_ajax.php", {
                    cid: cid,
                    ctype: ctype,
                    url: url,
                    moduleCode: moduleCode
                }, function (data) {
                    data = eval("(" + data + ")");
                    if (data.success == false) {

                        alert(data.message);
                    } else {
                        var width = document.getElementById('inpWidth').value;
                        var height = document.getElementById('inpHeight').value;
                        if (width == '' || width == '0') {
                            width = '400';
                        }
                        if (height == '' || height == '0') {
                            height = '300';
                        }
                        key = '{$sepehr_stream_' + data.id + '_' + width + '_' + height + '}';
                        insertHTML(key);
                    }
                });


            } else {
                document.getElementById('source').style.color = "red";
            }
        }


        function isUrl(str) {
            var pattern = new RegExp('(?:(?:https?|ftp|rtmp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]', 'i'); // fragment locator
            return pattern.test(str);
        }


        function insertHTML(stream_key) {
            sHTML = '<div dir="ltr" >' + stream_key + '</div>';
            window.parent.tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sHTML);
            parent.tinymce.activeEditor.windowManager.close();
        }

    </script>
    <title>Stream</title>
</head>
<body>
<div class="tox tox-dialog__body" style="direction: <?php echo $direction; ?>">
    <div class="tox-dialog__body-content">
        <div class="tox-form">
            <table border="0" height="100" dir="ltr" cellpadding="0" cellspacing="0" style="margin: 0px auto;">

                <tr>
                    <td width="60" class="tox-label"><span id="source" style="line-height: 28px;"><?php echo $translate['Source'][$lang] ?> :</span></td>
                    <td width="220" class="tox-selectfield">
                        <input class="tox-textfield" type="text" name="file_uri" id="file_uri"
                               style="width: 250px;margin-bottom: 7px;margin-<?php echo $textAlign?>: 11px;" class="inpTxt" dir="ltr">
                    </td>
                </tr>
                <tr>
                    <td nowrap class="tox-label"><span id="txtLang" style="line-height: 28px;"><?php echo $translate['Width'][$lang] ?> : </span></td>
                    <td style="text-align: <?php echo $textAlign?>;" class="tox-selectfield">
                        <input class="tox-textfield" type="text" name="inpWidth" id="inpWidth" value=400 size=4
                               class="inpTxt" style="text-align: left;width: 60px;margin-bottom: 7px;margin-<?php echo $textAlign?>: 11px;">
                    </td>
                </tr>
                <tr>
                    <td nowrap class="tox-label"><span id="txtLang" style="line-height: 28px;"><?php echo $translate['Height'][$lang] ?> : </span></td>
                    <td style="text-align: <?php echo $textAlign?>;" class="tox-selectfield">
                        <input class="tox-textfield" type="text" name="inpHeight" id="inpHeight" value=300 size=4
                               class="inpTxt" style="text-align: left;width: 60px;margin-bottom: 7px;margin-<?php echo $textAlign?>: 11px;">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: <?php echo $textAlign?>;">

                    </td>
                    <td colspan="2" align="right">

                        <div class="mce-primary mce-btn"
                             style="text-align: center;margin-top: 7px;float: <?php echo $antiTextAlign ?>;">
                            <button type="button" style="" onclick="insertMedia();">
                                <span class="tox-button"><?php echo $translate['Insert'][$lang] ?></span>
                            </button>
                        </div>

                    </td>
                </tr>
            </table>
            <input type="hidden" name="media_key" id="media_key">
        </div>
    </div>
</div>


</body>
