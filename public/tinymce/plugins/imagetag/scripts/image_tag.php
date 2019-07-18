<?php
require_once('../../conf.php');

$request = new Request(SECURITY_DOMAIN);
$cid = trim(strip_tags($request->getParameter('cid')));
$contentType = trim(strip_tags($request->getParameter('ctype')));
$moduleCode = trim(strip_tags($request->getParameter('moduleCode')));
$fileGroup = 1;
//------------------------------------------------------

if (!empty($contentType) && in_array($contentType, $contentTypes) && is_numeric($moduleCode) && in_array($moduleCode, $modulesCode[$contentType])) {
    if (is_numeric($cid) && $cid > 0) {

        define('MODULE_CODE', $moduleCode);
        $authorizationObj = new Authorization();
        $authorizationObj->authorize();
            $list = '';

            $contentFiles = new ContentFiles();
            $contentFiles->init($contentType, $fileGroup, $lang);

            $files = $contentFiles->getFiles($cid, $fileGroup);

            $list = '<table border=0 cellpadding=2 cellspacing=0 dir=rtl width="100%">';
            for ($i = 0; $i < count($files); $i++) {
                $newsImageObj = new NewsImages();
                $tagsArray = $newsImageObj->getTagsByImageID($files[$i]['file_id']);

                if (is_array($tagsArray) && count($tagsArray) > 0) {
                    $filename = $files[$i]['file_name'];
                    $fileid = $files[$i]['file_id'];
                    $filedesc = $files[$i]['file_desc'];

                    $ext = File::getFileExtention($filename);

                    if (in_array($ext, array('png', 'gif', 'jpg', 'jpeg', 'pjpeg', 'x-png'))) {
                        $icon = "ico_unknown.gif";
                        if ($ext == "gif") {
                            $icon = "ico_gif.gif";
                        }
                        if ($ext == "jpg") {
                            $icon = "ico_jpg.gif";
                        }
                        if ($ext == "jpeg") {
                            $icon = "ico_jpg.gif";
                        }
                        if ($ext == "pjpeg") {
                            $icon = "ico_jpg.gif";
                        }
                        if ($ext == "png") {
                            $icon = "ico_png.gif";
                        }
                        if ($ext == "x-png") {
                            $icon = "ico_png.gif";
                        }
                        $sdate = $files[$i]['sdate'];
                        $fileURI = $contentFiles->getFileURI($sdate);

                        $list .= '<tr>
			                    <td style="20px;text-align:center;padding: 3px;"><img src="../../../images/' . $icon . '"></td><td>' . $size . '</td>
			                    <td width="90%;" style="cursor:pointer;direction:ltr;padding:3px;" file_id="' . $fileid . '" file_uri="' . $fileURI . '" file_name="' . $filename . '" onClick="selectFile(this);"> ' . $filename . '</td>
			                  </tr>';
                    }
                }
            }
            $list .= '</table>';

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
    <link href="../../../skins/editor.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo THEME_URI ?>/js/lib/lib.js"></script>

    <script>

        function selectFile(obj) {
            var file_id = obj.getAttribute('file_id');
            var file_name = obj.getAttribute('file_name');

            var file_uri = obj.getAttribute('file_uri');
            var url = file_uri + '/' + file_name;
            var sourceField = document.getElementById('inpImgURL');
            sourceField.value = url;
            image_key.value = file_id;

            var preview = document.getElementById('preview');
            preview.src = url;

        }

        function insertImage() {

            if (image_key.value.length > 0) {
                key = '{$sepehr_image_tag_' + image_key.value + '}';
                insertHTML(key);
            }
        }

        function insertHTML(image_key) {

            sHTML = '<div dir="ltr" >' + image_key + '</div>';
            window.parent.tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sHTML);
            parent.tinymce.activeEditor.windowManager.close();
        }
    </script>
    <title>Tag image</title>
</head>
<body>
<div class="tox tox-dialog__body">
    <div class="tox-dialog__body-content">
        <div class="tox-form">
            <table height="100%" align="center" cellpadding=0 cellspacing=0 style="width:100%;">
                <tr>
                    <td valign=top style="padding-right:5px;">
                        <div id="listImages"
                             style="height: 220px;border: 1px solid dimgray;overflow: auto;width: 262px;">
                            <?php echo $list ?>
                        </div>
                    </td>
                    <td valign="top">
                        <div style="width:434px; height:220px; border: 1px solid dimgray;overflow: auto;"><img
                                    id="preview" src="../../../images/imgpreview.gif"></div>
                    </td>


                </tr>

            </table>
            <div>
                <div>
                    <span id="txtLang" class="tox-label" style="width: 100px;line-height:45px;float: <?php echo $textAlign ;?>;direction: <?php echo $direction;?>;text-align: <?php echo $textAlign;?>"><?php echo $translate['Source'][$lang] ?> :</span>


                    <input type="text" id="inpImgURL" name=inpImgURL
                           style="margin-top: 7px;width: 601px;float: <?php echo $textAlign ;?>"
                           class="inpTxt tox-textfield" readonly>
            <div class="wrpper"></div>
                </div>
            </div>
            <div>

                <div>

                    <table cellpadding=0 cellspacing=0>
                        <tr>
                            <td style="padding: 0px 125px;">
                            </td>
                            <td style="padding: 0px 10px;">
                                <div class="mce-btn" style="text-align: center;margin-top: 7px;">
                                    <button type="button" name="btnCancel" id="btnCancel"
                                            onclick="parent.tinymce.activeEditor.windowManager.close();"
                                            class="inpBtn" onmouseover="this.className='inpBtnOver';"
                                            onmouseout="this.className='inpBtnOut'">
                                        <span class="tox-button tox-button--secondary"><?php echo $translate['Cancel'][$lang] ?></span>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <div class="mce-primary mce-btn"
                                     style="text-align: center;margin-top: 7px;">
                                    <button type="button" name="btnInsert" id="btnInsert" onclick="insertImage();"
                                            class="inpBtn" onmouseover="this.className='inpBtnOver';"
                                            onmouseout="this.className='inpBtnOut'">
                                        <span class="tox-button"><?php echo $translate['Insert'][$lang] ?></span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>


            </div>

            <input type="hidden" name="image_key" id="image_key">
        </div>
    </div>
</div>


</body>
</html>