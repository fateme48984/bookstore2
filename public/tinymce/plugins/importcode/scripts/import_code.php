<?php
require_once('../../conf.php');

$request = new Request(SECURITY_DOMAIN);
$cid = trim(strip_tags($request->getParameter('cid')));
$moduleCode = trim(strip_tags($request->getParameter('moduleCode')));
$contentType = trim(strip_tags($request->getParameter('ctype')));

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
    <script type="text/javascript" src="<?php echo THEME_URI; ?>/js/lib/lib.js"></script>
    <script>
        function insertCode() {
            var code = $('#divedit').text();
            var cid = window.parent.tinyMCE.activeEditor.getParam('content_id');
            var moduleCode = window.parent.tinyMCE.activeEditor.getParam('module_code');
            $.post("import_code_ajax.php", {
                cid: cid,
                code: code,
                moduleCode: moduleCode,
            }, function (data) {
                data = eval("(" + data + ")");
                if (data.success == false) {
                    alert(data.message);
                } else {
                    key = '{$sepehr_code_' + data.id + '}';
                    insertHTML(key);
                }
            });

        };


        function insertHTML(stream_key) {
            sHTML = '<div dir="ltr" >' + stream_key + '</div>';
            window.parent.tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sHTML);
            parent.tinymce.activeEditor.windowManager.close();
        };

    </script>
    <style>
        body {
            direction: ltr;
            font: 12px tahoma;
        }

        div.editable {
            width: 450px;
            max-width: 450px;
            height: 200px;
            border: 1px solid #ccc;
            padding: 4px;
            margin: 5px auto;
            overflow: scroll;
            direction: ltr;
        }

    </style>

    <title>Import Code</title>
</head>
<body>
<div class="tox tox-dialog__body">
    <div class="tox-dialog__body-content">
        <div class="tox-form">
                <div class="diffcon">
                    <div class="editable" contenteditable="true" name="editable" id="divedit"></div>
                </div>
                <div class="button_con">
                        <div class="mce-primary mce-btn" style="text-align: center;margin-top: 7px;margin-bottom: 7px;">
                            <button type="button" class="virast_submit_butt_matn btn-virast"
                                    onclick="insertCode();return false;">
                                <span class="tox-button"><?php echo $translate['Insert'][$lang] ?></span>
                            </button>
                            <button type="button" class="virast_undo_butt_matn btn-virast"
                                    onclick="parent.tinymce.activeEditor.windowManager.close();">
                                <span class="tox-button tox-button--secondary"><?php echo $translate['Cancel'][$lang] ?></span>
                            </button>
                        </div>
                </div>
        </div>
    </div>
</div>
</body>
</html>

