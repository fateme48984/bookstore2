<?php
require_once('../../conf.php');
$request = new Request(SECURITY_DOMAIN);
$cid = trim(strip_tags($request->getParameter('cid')));
$moduleCode = trim(strip_tags($request->getParameter('moduleCode')));
$contentType = trim(strip_tags($request->getParameter('ctype')));

if (!empty($contentType) && in_array($contentType, $contentTypes) && is_numeric($moduleCode) && in_array($moduleCode, $modulesCode[$contentType])) {
    if(($contentType == 'ne' && $moduleCode == 401)) {
        if (!is_numeric($cid) && $cid <= 0) {
            exit();
        }
    }
    define('MODULE_CODE', $moduleCode);
    $authorizationObj = new Authorization();
    $authorizationObj->authorize();
} else {
    exit();
}
?>
<html dir="<?php echo $direction; ?>" >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="../../../skins/editor.css" rel="stylesheet" type="text/css">
    <link href="../../../skins/ui/oxide/skin.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo THEME_URI ?>/css/home.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo THEME_URI ?>/js/lib/lib.js"></script>
    <script>

        var lang = window.parent.tinymce.activeEditor.getParam('lang');

        function insertHtml() {
            cleanHtml('#divedit');
            var body = $('#divedit').html();


            sHTML = '<div>' + body + '</div>';
            window.parent.tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sHTML);
            parent.tinymce.activeEditor.windowManager.close();

        };

        function cleanHtml(container) {
            var childs = $('*', $(container)), i;
            for (i = 0; i < childs.length; i++) {
                if ($(childs[i]).is('br')) {
                    $(childs[i]).append('{put_a_br_tag_here}');
                } else if (!$(childs[i]).is('script')) {
                    if ($(childs[i]).is(':visible') && $(childs[i]).text() !== '' && $(childs[i]).css('display') == 'block') {
                        $(childs[i]).append('{put_a_br_tag_here}');
                    }
                } else {
                    $(childs[i]).remove();
                }
            }

            $(container).html($(container).text().replace(/\{put_a_br_tag_here\}/g, '<br/>'));
        }

        function addBreak() {
            var body = $('#divedit').html();
            var seprate = ["</div>",];
            var matches = body.split('</\div>');
            var matches = body.split('</\h1>');
            var matches = body.split('</\h2>');
            var matches = body.split('</\div>');
            $('#divedit').value = matches.join("<br>\n") + "<br>";
            var body2 = matches.join("<br>\n") + "<br>";
            alert(body2);
        }
    </script>
    <style>
        body {
            direction: rtl;
            font: 12px tahoma;
        }

        /* .focusout {
             height: 360px;
             margin-left: 5px;
             margin-right: 5px;
             width: 98%;
         }*/
        div.editable {
            width: 80%;
            height: 280px;
            border: 1px solid #ccc;
            padding: 4px;
            margin: 0px auto;
            overflow: scroll;
        }

        .button_con {
            height: 30px;
        }

        .button_con a {
            cursor: pointer;
        }

        .btn-virast {
            border: 0px;
            background: transparent;
            font: 12px tahoma;
        }

    </style>

    <title>Paste</title>
</head>
<body>
<div class="tox tox-dialog__body">
    <div class="tox-dialog__body-content">
        <div class="tox-form">
                <div class="diffcon">

                        <div class="editable" contenteditable="true" name="editable" id="divedit" style="text-align: <?php echo $textAlign; ?>;direction: <?php echo $direction ?>"></div>
                </div>
                <div class="button_con">
                        <div class="mce-primary mce-btn" style="text-align: center;margin-top: 7px;margin-bottom: 7px;">
                            <button type="button" class="virast_submit_butt_matn btn-virast"
                                    onclick="insertHtml();return false;">
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