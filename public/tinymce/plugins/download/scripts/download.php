<?php
require_once('../../conf.php');
$request = new Request ( SECURITY_DOMAIN );
$cid          = trim(strip_tags($request->getParameter('cid')));
$contentType  = trim(strip_tags($request->getParameter('ctype')));
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
            $icon = "ico_unknown.gif";
            if ($ext == "asp") {
                $icon = "ico_asp.gif";
            }
            if ($ext == "bmp") {
                $icon = "ico_bmp.gif";
            }
            if ($ext == "css") {
                $icon = "ico_css.gif";
            }
            if ($ext == "doc") {
                $icon = "ico_doc.gif";
            }
            if ($ext == "exe") {
                $icon = "ico_exe.gif";
            }
            if ($ext == "gif") {
                $icon = "ico_gif.gif";
            }
            if ($ext == "htm") {
                $icon = "ico_htm.gif";
            }
            if ($ext == "html") {
                $icon = "ico_htm.gif";
            }
            if ($ext == "jpg") {
                $icon = "ico_jpg.gif";
            }
            if ($ext == "js") {
                $icon = "ico_js.gif";
            }
            if ($ext == "mdb") {
                $icon = "ico_mdb.gif";
            }
            if ($ext == "mov") {
                $icon = "ico_mov.gif";
            }
            if ($ext == "mp3") {
                $icon = "ico_mp3.gif";
            }
            if ($ext == "pdf") {
                $icon = "ico_pdf.gif";
            }
            if ($ext == "png") {
                $icon = "ico_png.gif";
            }
            if ($ext == "ppt") {
                $icon = "ico_ppt.gif";
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
            if ($ext == "swf") {
                $icon = "ico_swf.gif";
            }
            if ($ext == "txt") {
                $icon = "ico_txt.gif";
            }
            if ($ext == "vbs") {
                $icon = "ico_vbs.gif";
            }
            if ($ext == "avi") {
                $icon = "ico_video.gif";
            }
            if ($ext == "wmv") {
                $icon = "ico_video.gif";
            }
            if ($ext == "mpeg") {
                $icon = "ico_video.gif";
            }
            if ($ext == "mpg") {
                $icon = "ico_video.gif";
            }
            if ($ext == "xls") {
                $icon = "ico_xls.gif";
            }
            if ($ext == "zip") {
                $icon = "ico_zip.gif";
            }

            $sdate = $files[$i]['sdate'];
            $fileURI = $contentFiles->getFileURI($sdate);
            if (file_exists(PUBLIC_ROOT . $fileURI . '/' . $filename)) {
                $size = getFileSize(filesize(PUBLIC_ROOT . $fileURI . '/' . $filename));
            }


            $list .= '<tr>
          <td style="20px;text-align:center;padding:3px;"><img src="../../../images/' . $icon . '"></td>
          <td width="100%" style="padding:3px 20px 3px 3px;cursor:pointer;" file_desc="' . $filedesc . '" file_uri="' . $fileURI . '" file_name="' . $filename . '" onClick="selectFile(this);"> ' . $filedesc . '</td>
          <td style="padding:3px;">' . $size . '</td>
          </tr>';
        }
        $list .= '</table>';

    } else {

        exit();
    }
} else {
    exit();
}

function getFileSize($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1000, $factor)) .' '.@$size[$factor];
}

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="../../../skins/ui/oxide/skin.min.css" rel="stylesheet" type="text/css">
    <link href="../../../skins/editor.css" rel="stylesheet" type="text/css">
    <style >
        .tox-form .span_style {
            padding-<?php echo $textAlign ?> : 0px;
            padding-<?php echo $antiTextAlign ?> : 8px;
        }
    </style>
    <script type="text/javascript" src="<?php echo THEME_URI ?>/js/lib/lib.js"></script>
    <script>

        function insertLink(url, title, target = '_blank') {

            var selectedNode = parent.tinymce.activeEditor.selection.getNode().nodeName;
            if (selectedNode == 'IMG') {
                var nodeContent = parent.tinymce.activeEditor.selection.getContent();
                var link = '<a href="' + url + '" class="download_link" target="' + target + '">' + nodeContent + '</a>';
                window.parent.tinyMCE.activeEditor.execCommand('mceInsertContent', 0, link);
            } else {
                var selected = parent.tinymce.activeEditor.selection.getContent({format: 'text'});
                if (selected.trim() != '') {
                    title = selected;
                }
                var link = '<a href="' + url + '"  rel="attachment" class="download_link" target="' + target + '">' + title + '</a>';

                window.parent.tinyMCE.activeEditor.execCommand('mceInsertContent', 0, link);
            }


        }

        function selectFile(obj) {
            var file_name = obj.getAttribute('file_name');
            var file_desc = obj.getAttribute('file_desc');
            var file_uri = obj.getAttribute('file_uri');
            var url = file_uri + '/' + file_name;

            file_url.value = url;
            title.value = file_desc;
        }

        function insert() {
            if (file_url.value.length > 0 && title.value.length > 0) {
                insertLink(file_url.value, title.value);
                parent.tinymce.activeEditor.windowManager.close();
            }
        }
    </script>
    <title>Download</title>
</head>
<body>
<div class="tox tox-dialog__body" style="direction: <?php echo $direction; ?>">
    <div class="tox-dialog__body-content">
        <div class="tox-form">
            <table border="0" height="280" dir="ltr" cellpadding="0" cellspacing="0"
                   style="width: 85%;margin: 0px auto;">
                <tr>
                    <td colspan="2" height="200" align="center" valign="top" style="border: 1px solid dimgray;">
                        <div id="listMedia" style="max-height: 180px;min-height: 180px;overflow: scroll;width: 278px;max-width: 278px;direction: ltr;">
                            <?php echo $list?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td dir="rtl" width="60">
                        <span id="txtLang" name="txtLang" class="tox-label span_style"><?php echo $translate['Link title'][$lang] ?> :  </span>
                    </td>
                    <td width="190" class="mce-mce-combobox">
                        <input type="text" id="title" name=title style="margin-top: 5px;"
                               class="inpTxt tox-textfield input_style" dir="rtl">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right">
                        <div class="mce-primary mce-btn"
                             style="float: <?php echo $antiTextAlign;?>;">
                            <button type="button" style="" onclick="insert();">
                                <span class="tox-button"><?php echo $translate['Insert'][$lang] ?></span>
                            </button>
                        </div>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="file_url" id="file_url">
        </div>
    </div>
</div>

</body>
</html>