<?php
require_once('../../conf.php');


$request = new Request(SECURITY_DOMAIN);
$cid = trim(strip_tags($request->getParameter('cid')));
$contentType = trim(strip_tags($request->getParameter('ctype')));
$moduleCode = trim(strip_tags($request->getParameter('moduleCode')));

//------------------------------------------------------
if (!empty($contentType) && in_array($contentType, $contentTypes) && is_numeric($moduleCode) && in_array($moduleCode, $modulesCode[$contentType])) {
    if (is_numeric($cid) && $cid > 0) {

        define('MODULE_CODE', $moduleCode);
        $authorizationObj = new Authorization();
       $authorizationObj->authorize() ;

        $list = '';

        $newsAlbumsObj = new NewsAlbum($cid);
        $albums = $newsAlbumsObj->getAllAlbums(true);

        $list = '
    <div style="height:190px;overflow:scroll;direction: '.$direction.';max-width:270px;overflow:auto;">
    <table border=0 cellpadding=2 cellspacing=0 dir="rtl" width="100%" >';
        for ($i = 0; $i < count($albums); $i++) {
            $albumName = $albums[$i]['album_name'];
            $albumID = $albums[$i]['album_id'];


            $list .= '<tr>
          <td width="100%" style="cursor:pointer;padding: 3px 5px;direction: rtl;text-align: right;" album_id="' . $albumID . '" album_name="' . $albumName . '" onClick="selectAlbum(this);"> ' . $albumName . '</td>
          </tr>';
        }
        $list .= '</table></div>';

    } else {
       exit();
    }
} else {
   exit();
}
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Insert News Albums</title>
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

        function insertHTML(title, album_key) {
            sHTML = '<div dir="ltr" title="' + title + '">' + album_key + '</div>';
            window.parent.tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sHTML);
            parent.tinymce.activeEditor.windowManager.close();
        }

        function selectAlbum(obj) {
            var album_name = obj.getAttribute('album_name');
            var album_id = obj.getAttribute('album_id');
            var key = '{$sepehr_album_' + album_id + '}';

            album_key.value = key;
            title.value = album_name;
        }

        function insert() {
            if (album_key.value.length > 0 && title.value.length > 0) {
                insertHTML(title.value, album_key.value)
            }
        }
    </script>
</head>
<body>
<div class="tox tox-dialog__body" style="direction: <?php echo $direction; ?>">
    <div class="tox-dialog__body-content">
        <div class="tox-form">
            <div align="center" style="margin: 0px auto;">
                <table border="0" height="240" dir="ltr" cellpadding="0" cellspacing="0" style="width: 100%;">
                    <tr>
                        <td id="list_albums" colspan="2" height="190" align="center" valign="top"
                            style="border: 1px solid dimgray">
                            <?php echo $list ?>
                        </td>
                    </tr>
                    <tr>
                        <td dir="rtl" width="60">
                            <span id="txtLang" name="txtLang" class="tox-label span_style"><?php echo $translate['Link title'][$lang] ?> : </span>
                        </td>
                        <td width="190" class="mce-mce-combobox">
                            <input type="text" id="title" name="title"
                                   style="width:195px;margin-top: 7px;text-align: <?php echo $textAlign;?>;"
                                   class="inpTxt tox-textfield input_style" dir="rtl">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right">

                            <div class="mce-primary mce-btn"
                                 style="text-align: center;margin-top: 7px;float: <?php echo $antiTextAlign;?>;">
                                <button type="button" style="" onclick="insert();">
                                    <span class="tox-button"><?php echo $translate['Insert'][$lang] ?></span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="album_key" id="album_key">
            </div>
        </div>
    </div>
</div>
</body>
</html>