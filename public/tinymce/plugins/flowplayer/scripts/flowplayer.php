<?php
require_once('../../conf.php');
$request = new Request(SECURITY_DOMAIN);
$cid = trim(strip_tags($request->getParameter('cid')));
$contentType = trim(strip_tags($request->getParameter('ctype')));
$moduleCode = trim(strip_tags($request->getParameter('moduleCode')));
$fileGroup = 2;

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
        $filename = $files[$i]['file_name'];
        $fileid = $files[$i]['file_id'];
        $filedesc = $files[$i]['file_desc'];
        $size = 0;

        $ext = File::getFileExtention($filename);

        if (in_array($ext, array('mp3', 'mid', 'wav', 'wma', 'avi', 'wmv', 'mpeg', 'webm', 'mpg', 'mp4', 'flv', '3gp'))) {
            if ($ext == "mp3") {
                $icon = "ico_mp3.gif";
            }
            if ($ext == "mid") {
                $icon = "ico_sound.gif";
            }
            if ($ext == "wav") {
                $icon = "ico_sound.gif";
            }
            if ($ext == "wma") {
                $icon = "ico_sound.gif";
            }
            if ($ext == "avi") {
                $icon = "ico_video.gif";
            }
            if ($ext == "wmv") {
                $icon = "ico_video.gif";
            }
            if ($ext == "webm") {
                $icon = "ico_video.gif";
            }
            if ($ext == "mpeg") {
                $icon = "ico_video.gif";
            }
            if ($ext == "flv") {
                $icon = "ico_video.gif";
            }
            if ($ext == "3gp") {
                $icon = "ico_video.gif";
            }
            if ($ext == "mpg") {
                $icon = "ico_video.gif";
            }
            if ($ext == "mp4") {
                $icon = "ico_video.gif";
            }
            $sdate = $files[$i]['sdate'];
            $fileURI = $contentFiles->getFileURI($sdate);
            if (file_exists(PUBLIC_ROOT . $fileURI . '/' . $filename)) {
                $size = getFileSize(filesize(PUBLIC_ROOT . $fileURI . '/' . $filename));
            }

            $list .= '<tr>
            <td style="20px;text-align:center;padding:3px;"><img src="../../../images/' . $icon . '"></td>
            <td width="90%" style="padding:3px 20px 3px 3px;cursor:pointer;direction:ltr;" file_id="' . $fileid . '" file_uri="' . $fileURI . '" file_name="' . $filename . '" onClick="selectFile(this);"> ' . $filename . '</td>
            <td style="padding:3px;">' . $size . '</td>
          </tr>';
        }
    }
    $list .= '</table>';


    }else {
        exit();
    }
} else {
    exit();
}


function getFileSize($bytes, $decimals = 2) {
    $size = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1000, $factor)) . ' ' . @$size[$factor];
}

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link href="../../../skins/ui/oxide/skin.min.css" rel="stylesheet" type="text/css">
    <style>
        /*.mce-mce-combobox input {
            width: 95% !important;
        }*/
        .tox-form .span_style {
            text-align: <?php echo $textAlign?>;
        }
        .tox-form input {
            direction: ltr;
        }

        .tox-form .input_style {
            margin-bottom: 7px;
        }
    </style>
    <script type="text/javascript" src="<?php echo THEME_URI ?>/js/lib/lib.js"></script>
    <script>


        function selectFile(obj) {
            var file_id = obj.getAttribute('file_id');
            var file_name = obj.getAttribute('file_name');

            var file_uri = obj.getAttribute('file_uri');
            var url = file_uri + '/' + file_name;
            var sourceField = document.getElementById('file_uri');
            sourceField.value = url;
            media_key.value = file_id;

        }

        function insertMedia() {

            if (media_key.value.length > 0) {
                var width = document.getElementById('inpWidth').value;
                var height = document.getElementById('inpHeight').value;
                if (width == '' || width == '0') {
                    width = '400';
                }
                if (height == '' || height == '0') {
                    height = '300';
                }
                key = '{$sepehr_media_' + media_key.value + '_' + width + '_' + height + '}';
                insertHTML(key);

            }
        }

        function insertHTML(media_key) {
            sHTML = '<div dir="ltr" >' + media_key + '</div>';
            window.parent.tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sHTML);
            parent.tinymce.activeEditor.windowManager.close();
        }
    </script>

    <title>Media</title>
</head>
<body>
<div class="tox tox-dialog__body" style="direction: <?php echo $direction; ?>">
    <div class="tox-dialog__body-content">
        <div class="tox-form">

            <table border="0" height="280" dir="ltr" cellpadding="0" cellspacing="0"
                   style="width: 90%;margin: 0px auto; ">
                <tr>
                    <td colspan="2" height="150" align="center" valign="top"
                        style="border: 1px solid dimgray;background-color: #fff;padding: 5px;">
                        <div id="listMedia" style="max-height: 130px;min-height: 130px;overflow: auto;width: 100%;max-width: 100%;direction: ltr;">
                            <?php echo $list ?>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td><span id="txtLang" class="tox-label span_style"><?php echo $translate['Source'][$lang] ?> :</span></td>
                    <td class="mce-mce-combobox">
                        <input type="text" class="tox-textfield input_style inpTxt" name="file_uri" id="file_uri"
                               style="margin-top: 5px;" dir="ltr" readonly>
                    </td>
                </tr>
                <tr>
                    <td nowrap><span id="txtLang" class="tox-label span_style"><?php echo $translate['Width'][$lang] ?> : </span></td>
                    <td style="text-align: left;" class="mce-mce-combobox">
                        <input type="text" class="tox-textfield input_style" name="inpWidth" id="inpWidth" value=400
                               class="inpTxt">
                    </td>
                </tr>
                <tr>
                    <td nowrap><span id="txtLang" class="tox-label span_style"><?php echo $translate['Height'][$lang] ?> : </span></td>
                    <td style="text-align: left;" class="mce-mce-combobox">
                        <input type="text" class="tox-textfield input_style" name="inpHeight" id="inpHeight" value=300
                               class="inpTxt">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <div class="mce-primary mce-btn"
                             style="float: <?php echo $antiTextAlign;?>">
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
</html>