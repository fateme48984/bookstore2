<?php
require_once('../../conf.php');
$request = new Request(SECURITY_DOMAIN);
$action  = trim(strip_tags($request->getParameter('action')));

$request = new Request(SECURITY_DOMAIN);
$cid = trim(strip_tags($request->getParameter('cid')));
$contentType = trim(strip_tags($request->getParameter('ctype')));
$moduleCode = trim(strip_tags($request->getParameter('moduleCode')));
$fileGroup = 1;
//------------------------------------------------------


if($action == 'insert'){
    $smartyObj = SepehrSmartyFactory::getInstance();
    $smartyObj->setTemplateDir(TEMPLATES_DIR.'/helpers/shared/');
    $smartyObj->setCompileDir(THEME_DIR.'/templates/templates_c');

    $width	= trim(strip_tags($request->getParameter('width', 200)));
    $align	= trim(strip_tags($request->getParameter('align', 'right')));
    $text 	= trim(strip_tags($request->getParameter('text')));

    if(is_numeric($width) && $width > 100 && $width < 300 && in_array($align, array('right', 'left'))){
        $smartyObj->assign('width', $width);
        $smartyObj->assign('align', $align);
        $smartyObj->assign('text', $text);

        echo $smartyObj->fetch("quote_$align.tpl");
    }
} else {

    if (!empty($contentType) && in_array($contentType, $contentTypes) && is_numeric($moduleCode) && in_array($moduleCode, $modulesCode[$contentType])) {
        if($contentType == 'ne') {
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
    <!doctype html public "-//w3c//dtd html 4.0 transitional//en">
    <html dir="<?php echo $direction; ?>">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="../../../skins/ui/oxide/skin.min.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?php echo THEME_URI;?>/js/lib/lib.js"></script>

        <script>

            function insertText() {

                var width = document.getElementById('inpWidth').value;
                var align = document.getElementById('inpAlign').value;
                var text = document.getElementById('inpText').value;

                var params = {
                    action: 'insert',
                    width: $("#inpWidth").val(),
                    align: $("#inpAlign").val(),
                    text: $("#inpText").val()
                };


                $.post('quote.php', params, function(response){
                    if(!response || response == undefined){
                        parent.tinymce.activeEditor.windowManager.close();
                    } else {
                        var sHTML = response;
                        insertObject(sHTML);
                    }
                });
            };

            function insertObject(sHTML) {
                window.parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, sHTML );
                parent.tinymce.activeEditor.windowManager.close();
            };
        </script>
        <style>
            .combo_plugin {
                background-color: #f0f0f0;
                border: 1px solid #c5c5c5;
                height: 24px;
                width: 100px;
            }

            .tox .tox-selectfield select {
                -webkit-appearance: menulist;
            }
        </style>
        <title>Quote</title>
    </head>
    <body>
    <div class="tox tox-dialog__body" style="direction: <?php echo $direction; ?>">
        <div class="tox-dialog__body-content">
            <div class="tox-form">
                <table border="0" width="250" height="280" cellpadding="3" cellspacing="0" style="margin: 0px auto;">
                    <tr>
                        <td colspan="2" align="center" valign="top" style="border: 1px solid dimgray;background-color: #fff;">
                            <textarea class="tox-textarea" rows="12" cols="30" style="width: 250px;border: 0px;font: normal 12px tahoma;direction: <?php echo $direction; ?>;text-align: <?php echo $textAlign; ?>;" id="inpText"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap style="text-align: <?php echo $textAlign; ?>;direction: <?php echo $direction; ?>;"  class="tox-text"><span id="txtLang" style="line-height: 47px;"><?php echo $translate['Width'][$lang] ?> :</span></td>
                        <td style="text-align: <?php echo $textAlign; ?>;direction: <?php echo $direction; ?>; font-size: 10px;" class="mce-mce-combobox" >
                            <input type="text" class="tox-textfield" name="inpWidth" id="inpWidth" value="200" size=4 class="inpTxt" style="margin-top: 10px;width:50px;"><span style="line-height: 47px;font-size: 9px;">&nbsp;<?php echo $translate['(Allowed width 100px-300xp)'][$lang] ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td nowrap style="text-align: <?php echo $textAlign; ?>;direction: <?php echo $direction; ?>;">
                            <span id="txtLang"><?php echo $translate['Direction'][$lang] ?> : </span>
                        </td>
                        <td nowrap>
                            <div class="tox-selectfield">
                                <select id="inpAlign" name="inpAlign" class="inpSel" style="text-align:<?php echo $textAlign; ?> ">
                                    <option value="left" id="optLang"><?php echo $translate['Left'][$lang] ?></option>
                                    <option value="right" id="optLang"><?php echo $translate['Right'][$lang] ?></option>
                                </select>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right" >
                            <div class="mce-primary mce-btn" style="margin-top: 7px;float: <?php echo $antiTextAlign; ?>">
                                <button type="button" style="" onclick="insertText();">
                                    <span class="tox-button"><?php echo $translate['Insert'][$lang] ?></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </table>

            </div>

        </div>
    </div>



    </body>
    </html>
    <?php
}