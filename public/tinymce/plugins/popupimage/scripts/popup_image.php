<?php
include_once('../../conf.php');

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
            $result = array();
            $langDir = 'rtl';

            $langsObj = new Langs();
            $langDir = $langsObj->getLangDir($lang);
//--------------------------------------------------------
            $contentFiles = new ContentFiles();
            $contentFiles->init($contentType, 1, $lang);

            if ($contentType == 'ne' && is_numeric($cid)) {
                $cid = intval($cid);
                $newsObj = new News();
                $newsFields = $newsObj->getNewsField(array('title'), $cid);
                $titleValue = $newsFields['title'];
            } else {
                $titleValue = '';
            }

            $files = $contentFiles->getFiles($cid, $fileGroup);

            $list = '<table border=0 cellpadding=2 cellspacing=0 dir=ltr>';
            for ($i = 0; $i < count($files); $i++) {
                $filename = $files[$i]['file_name'];
                $fileid = $files[$i]['file_id'];

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

                $list .= '<tr>
                  <td style="padding: 3px;"><img src="../../../images/' . $icon . '"></td>
                  <td width="70%" style="cursor:pointer;padding:3px;" file_id="' . $fileid . '" file_uri="' . $fileURI . '" file_name="' . $filename . '" onClick="selectFile(this);"> ' . $filename . '</td>
              <td></td></tr>';
            }
            $list .= '</table>';
            $result['list'] = $list;
            $result['title'] = $titleValue;
            $result['langDir'] = $langDir;


    } else {
        exit();
    }
} else {
   exit();
}
?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../../../skins/ui/oxide/skin.min.css" rel="stylesheet" type="text/css">
<link href="../../../skins/editor.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo THEME_URI ?>/js/lib/lib.js"></script>
<script type="text/javascript" src="../js/popup_image.js"></script>
<script>
    function selectFile(obj) {
        var file_name = obj.getAttribute('file_name');
        var file_id = obj.getAttribute('file_id');
        var file_uri = obj.getAttribute('file_uri');

        var url = file_uri + '/' + file_name;


        var imgSrcField = document.getElementById('inpImgURL');
        imgSrcField.value = url;

        var preview = document.getElementById('preview');
        preview.src = url;

        $("#preview").load(function () {
            $('#inpImgWidth').attr('value', $('#preview').width());
            $('#inpImgHeight').attr('value', $('#preview').height());
        });

        $('#btnReset').click(function () {
            $('#inpImgWidth').attr('value', $('#preview').width());
            $('#inpImgHeight').attr('value', $('#preview').height());
        });
    }

</script>
<title>Popup image</title>
</head>
<body>
<div class="tox tox-dialog__body">
    <div class="tox-dialog__body-content">
        <div class="tox-form" style="width: 100%; ">
            <table width='100%'>
                <tr>
                    <td >
                        <table width='100%' style="margin-top: 3px;direction: <?php echo $direction?>;text-align: <?php echo $textAlign ?>">
                            <tr>
                                <td colspan="5">
                                    <div id="listImages" style="height: 100px;border: 1px solid dimgray;overflow: auto;text-align: left;direction: ltr;">
                                        <?php echo $result['list'] ?>
                                    </div>
                                </td>

                            </tr>
                            <tr>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup" style="margin-top: 3px;"><?php echo $translate['Source'][$lang] ?> : </span>
                                </td>
                                <td colspan=4 style="width:100%">
                                    <table cellpadding="0" cellspacing="0" style="width:100%">
                                        <tr>
                                            <td style="width:100%">
                                                <input type="text" id="inpImgURL" name="inpImgURL"
                                                       style="width:315px;margin-top: 5px;" class="inpTxt tox-textfield dir-align"
                                                       readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Caption'][$lang] ?> : </span>
                                </td>
                                <td colspan=4 style="width:100%">
                                    <input type="text" id="inpImgCaption" name="inpImgCaption"
                                           style="width:315px;text-align: <?php echo $textAlign; ?>;direction: <?php echo $direction?>" value=""
                                           class="inpTxt tox-textfield " onkeyup="" >

                                </td>
                            </tr>
                            <tr>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Title'][$lang] ?> : </span>
                                </td>
                                <td width="100%">
                                    <input type="text" id="inpImgAlt" name=inpImgAlt
                                           style="width:150px;text-align: <?php echo $textAlign; ?>;direction: <?php echo $direction?>" value="<?php echo $result['title']?>"
                                           class="inpTxt tox-textfield " onkeyup="">
                                </td>
                                <td>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Spacing'][$lang] ?> : </span>
                                </td>
                                <td style="padding-top:4px;padding-right:7px"></td>

                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Thumbnail width'][$lang] ?> :</span>
                                </td>
                                <td nowrap rowspan="2">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <input type="text" name="inpImgWidth" id="inpImgWidth" style="width: 60%"
                                                       class="inpTxt widthScale scaleInput tox-textfield dir-align" value="">
                                                &nbsp;<span style="line-height: 24px;">px</span>
                                            </td>

                                            <td rowspan="2"  style="padding-top:23px;padding-left: 5px">
                                                <input type="button" name="btnReset" id="btnReset"
                                                       style="border:1px solid #ccc;background-color: #e3e3e3;color:#333;padding: 5px 8px;margin-<?php echo $antiTextAlign;?>:22px;cursor: pointer;"
                                                       value="<?php echo $translate['Reset'][$lang] ?>">
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="inpImgHeight" id="inpImgHeight" style="width: 60%;margin-top: 2px;"
                                                       class="inpTxt heightScale scaleInput tox-textfield dir-align" value="">
                                                &nbsp;<span style="line-height: 24px;">px</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Top'][$lang] ?> : </span>
                                </td>
                                <td nowrap>
                                    <input type="text" name="inpImgTop" id="inpImgTop" style="width: 60%"
                                           class="inpTxt tox-textfield dir-align" onkeyup=""> &nbsp;
                                    <span>px</span>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup "><?php echo $translate['Thumbnail height'][$lang] ?> :</span>

                                </td>

                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Bottom'][$lang] ?> :</span>
                                </td>
                                <td nowrap>
                                    <input type="text" name="inpImgBottom" id="inpImgBottom" style="width: 60%"
                                           class="inpTxt tox-textfield dir-align" onkeyup=""> &nbsp;
                                    <span>px</span>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap>
                                </td>
                                <td rowspan="3" style="padding-top: 10px">
                                    <input id="checkImgResize" class="scaleInput" checked="" name="checkImgResize" dir="rtl" value="" type="checkbox">
                                    <label for="checkImgResize" style="line-height: 21px;font-size: 8pt"><?php echo $translate['Fit photo'][$lang] ?></label>
                                </td>
                                <!--     <td nowrap>

                                     </td>-->
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Left'][$lang] ?> :</span>
                                </td>
                                <td nowrap>
                                    <input type="text" name="inpImgLeft" id="inpImgLeft" style="width: 60%"
                                           class="inpTxt tox-textfield dir-align" onkeyup="" id="Text2"> &nbsp;
                                    <span>px</span>
                                </td>
                            </tr>
                            <tr>

                                <td nowrap>
                                </td>

                                <!-- <td nowrap>
                                 </td>-->

                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Right'][$lang] ?> :</span>
                                </td>
                                <td nowrap>
                                    <input type="text" name="inpImgRight" id="inpImgRight" style="width: 60%"
                                           class="inpTxt tox-textfield dir-align" onkeyup="" id="Text1"> &nbsp;
                                    <span>px</span>
                                </td>
                            </tr>


                            <tr>
                                <td colspan="5">

                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:268px;" valign="top">
                        <div style="width:265px;max-width: 265px; height:350px; border: 1px solid dimgray;overflow: scroll;margin-top:5px;">
                            <img id="preview" src="../../../images/imgpreview.gif">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="dialogFooter" align="right" style="background-color: inherit;">
                        <table cellpadding=0 cellspacing=0>
                            <tr>
                                <td <?php if($direction == 'ltr'){ ?>style="padding: 0px 148px;"<?php }?>>
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
                                        <button type="button" name="btnInsert" id="btnInsert" onclick="doInsert();"
                                                class="inpBtn" onmouseover="this.className='inpBtnOver';"
                                                onmouseout="this.className='inpBtnOut'">
                                            <span class="tox-button"><?php echo $translate['Insert'][$lang] ?></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td class="dialogFooter">
                        <table cellpadding=0 cellspacing=0>
                            <tr>
                                <td nowrap>
                                </td>
                                <td width="100%">
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>


</body>
</html>