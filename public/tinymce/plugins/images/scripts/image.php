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

            $contentFiles = new ContentFiles();
            $contentFiles->init($contentType, 1, $lang);

            $cid = intval($cid);
            $newsObj = new News();
            $newsFields = $newsObj->getNewsField(array('title'), $cid);
            $titleValue = $newsFields['title'];


            $files = $contentFiles->getFiles($cid, $fileGroup);

            $list = '<table border=0 cellpadding=2 cellspacing=0 dir=ltr id="list">';
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
                      <td width="70%" style="cursor:pointer;padding:3px;font-size:14px;" file_id="' . $fileid . '" file_uri="' . $fileURI . '" file_name="' . $filename . '" onClick="selectFile(this);" class=""> ' . $filename . '</td>
                  <td></td></tr>';
            }
            $list .= '</table>';

            $result = array('list' => $list, 'title' => $titleValue);


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
    <!--<link href="../../../skins/editor.css" rel="stylesheet" type="text/css">-->
    <link href="../css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="../css/colorPicker.css" rel="stylesheet" type="text/css">
    <link href="../css/style.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="../js/lib-12.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../js/image.js"></script>
    <script type="text/javascript" src="../js/border.js"></script>
    <script type="text/javascript" src="../js/colorPicker.js"></script>
<script>

function selectFile(obj) {
    var file_name = obj.getAttribute('file_name');
    var file_id   = obj.getAttribute('file_id');
    var file_uri  = obj.getAttribute('file_uri');

    var url = file_uri + '/' + file_name;

    var imgSrcField = document.getElementById('inpImgURL');
    imgSrcField.value = url;

    var preview = document.getElementById('preview');
    preview.src = url;

    $('#list tr td').removeClass('selected_class');
    $(obj).addClass('selected_class');

   $("#preview").load(function(){
		$('#inpImgWidth').prop('value', $('#preview').width());
		$('#inpImgHeight').prop('value', $('#preview').height());
    });

	$('#btnReset').click(function() {
		$('#inpImgWidth').prop('value', $('#preview').width());
		$('#inpImgHeight').prop('value', $('#preview').height());
	});
}

</script>
    <title>Images</title>
</head>
<body>
<div class="tox tox-dialog__body">
    <div class="tox-dialog__body-content">
        <div class="tox-form" style="font-size: 12px;">

            <table width=100% height=100% align=center cellpadding=0 cellspacing=0>
                <tr>
                    <td valign=top style="padding:5px;height:100%">
                        <div id="image_list" style="height: 100px;border: 1px solid dimgray;overflow: auto;">
                            <?php echo $result['list'];?>
                        </div>
                        <table width=100% style="direction: <?php echo $direction ;?>;text-align: <?php echo $textAlign ;?>">
                            <tr>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup" style="margin-top: 3px;"><?php echo $translate['Source'][$lang] ?> : </span>
                                </td>
                                <td colspan=4 style="width:100%">
                                    <table cellpadding="0" cellspacing="0" style="width:100%">
                                        <tr>
                                            <td style="width:100%">
                                                <input type="text" id="inpImgURL" name="inpImgURL" style="width:93%;margin-top: 5px;" class="inpTxt tox-textfield dir-align" readonly>
                                            </td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup" style="margin-top: 3px;"><?php echo $translate['Title'][$lang] ?> : </span>
                                </td>
                                <td colspan=4 style="width:100%">
                                    <table cellpadding="0" cellspacing="0" style="width:100%">
                                        <tr>
                                            <td style="width:100%">
                                                <input type="text" id="inpImgTitle" name="inpImgTitle" style="width:93%;margin-top: 5px;" class="inpTxt tox-textfield" onkeyup="doPreview();"  dir="<?php echo $direction;?>" value="<?php echo $result['title'];?>">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Alt'][$lang] ?> : </span>
                                </td>
                                <td width="100%">
                                    <input type="text" id="inpImgAlt" name=inpImgAlt style="width:150px" value="<?php echo $result['title'];?>" class="inpTxt tox-textfield " onkeyup="doPreview();"  dir="<?php echo $direction;?>" >
                                </td>
                                <td rowspan="5" style="padding-top:4px;padding-right:7px;">
                                    <div style="height:169px;border-left:#c7c7c7 1px solid;width:1px"></div>
                                </td>
                                <td>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Spacing'][$lang] ?> :</span>
                                </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Alignment'][$lang] ?> :</span>
                                </td>
                                <td nowrap>
                                    <div class="tox-selectfield">
                                        <select id="inpImgAlign" name="inpImgAlign" class="inpSel combo_plugin i" onchange="doPreview();">
                                            <option value="" selected></option><!-- &lt;Not Set&gt; -->
                                            <option value="absBottom" id="optLang">absBottom</option>
                                            <option value="absMiddle" id="optLang">absMiddle</option>
                                            <option value="baseline" id="optLang">baseline</option>
                                            <option value="bottom" id="optLang">bottom</option>
                                            <option value="left" id="optLang">left</option>
                                            <option value="middle" id="optLang">middle</option>
                                            <option value="right" id="optLang">right</option>
                                            <option value="textTop" id="optLang">textTop</option>
                                            <option value="top" id="optLang">top</option>
                                        </select>&nbsp;
                                    </div>
                                </td>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Top'][$lang] ?> : </span>
                                </td>
                                <td nowrap>
                                    <input type="text" name="inpImgTop" id="inpImgTop" style="width: 36px;" class="inpTxt tox-textfield dir-align" onkeyup="doPreview()" style="width: 60px;"> &nbsp;
                                    <span>px</span>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Border'][$lang] ?> :</span>
                                </td>
                                <td nowrap>
                                    <input type="button" name=btnBorder id=btnBorder value="<?php echo $translate['Border Style'][$lang] ?>" class="inpTxt tox-textfield  border_btn" style="width:150px" />
                                </td>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Bottom'][$lang] ?> :</span>
                                </td>
                                <td nowrap>
                                    <input type="text" name="inpImgBottom" id="inpImgBottom" style="width: 36px;" class="inpTxt tox-textfield dir-align" onkeyup="doPreview()"  style="width: 42px;"> &nbsp;
                                    <span>px</span>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Width'][$lang] ?> :</span>
                                </td>
                                <td nowrap rowspan="2">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <input type="text" name="inpImgWidth" id="inpImgWidth"  style="width: 36px;" class="inpTxt widthScale scaleInput tox-textfield input_style_im dir-align" value=""> &nbsp;
                                                <span style="line-height: 21px;">px</span>
                                            </td>
                                            <td rowspan="2" height="50" style="padding-left:3px;padding-top:0">
                                                <img src="../img/image_reset_<?php echo $direction ?>.gif" align=left width="15" height="56">
                                            </td>
                                            <td rowspan="2" height="50" style="padding-top:0px;padding-left: 5px">
                                                <input type="button" name="btnReset" id="btnReset" style="border:1px solid #ccc;background-color: #e3e3e3;color:#333;padding: 5px 8px;cursor: pointer;" value="<?php echo $translate['Reset'][$lang] ?>">
                                            </td>
                                            <td rowspan="2" style="margin-top: 10px">
                                                <input id="checkImgResize" class="scaleInput" checked="" name="checkImgResize" dir="rtl" value="" type="checkbox">
                                                <label for="checkImgResize" style="line-height: 21px;font-size: 7pt"><?php echo $translate['Fit photo'][$lang] ?></label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="text" name="inpImgHeight" id="inpImgHeight"  style="width: 36px;" class="inpTxt heightScale scaleInput tox-textfield input_style_im dir-align" value=""> &nbsp;
                                                <span style="line-height: 21px;">px</span>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Left'][$lang] ?> :</span>
                                </td>
                                <td nowrap>
                                    <input type="text" name="inpImgLeft" id="inpImgLeft" style="width: 36px;"  class="inpTxt tox-textfield dir-align" onkeyup="doPreview()" id="Text2"> &nbsp;
                                    <span>px</span>
                                </td>
                            </tr>
                            <tr>
                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Height'][$lang] ?> :</span>

                                </td>

                                <td nowrap>
                                    <span id="txtLang" class="tox-label span_style_popup"><?php echo $translate['Right'][$lang] ?> :</span>
                                </td>
                                <td nowrap>
                                    <input type="text" name="inpImgRight" id="inpImgRight" style="width: 36px;"  class="inpTxt tox-textfield dir-align" onkeyup="doPreview()" id="Text1"> &nbsp;
                                    <span>px</span>

                                </td>
                            </tr>


                            <tr>
                                <td colspan="6">
                                    <div style="padding:3px;"></div>
                                    <div id="divPreview" style="font-size: 11px; padding:5px;padding-left:5px;overflow:auto;border:1px dimgray solid;height:85px;background:#ccc;width:428px;">
                                        <img src="../img/img.gif" id="idImg" align=left width="53" height="51">
                                        Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
                                        sed diam nonumy eirmod tempor invidunt ut labore et
                                        dolore magna aliquyam erat,
                                        sed diam voluptua. At vero eos et accusam et justo
                                        duo dolores et ea rebum. Stet clita kasd gubergren,
                                            no sea takimata sanctus est Lorem ipsum dolor sit amet.

                                    </div>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td style="width: 400px;" valign="top">
                        <div style=" max-width: 350px;overflow: scroll;width: 350px; height:370px; border: 1px solid dimgray;margin-top:5px;"><img id="preview" src="../../../images/imgpreview.gif"></div>
                        <table cellpadding=0 cellspacing=0>
                            <tr>
                                <td style="padding: 0px 10px;">
                                    <div class="mce-btn" style="text-align: center;margin-top: 7px;">
                                        <button type="button" name="btnCancel" id="btnCancel" onclick="parent.tinymce.activeEditor.windowManager.close();" class="inpBtn"  onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">
                                            <span class="tox-button tox-button--secondary"><?php echo $translate['Cancel'][$lang] ?></span>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="mce-primary mce-btn" style="text-align: center;margin-top: 7px;">
                                        <button type="button" name="btnInsert" id="btnInsert" onclick="doInsert();" class="inpBtn" onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">
                                            <span class="tox-button"><?php echo $translate['Insert'][$lang] ?></span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td class="dialogFooter" align="right" style="background-color;">

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


            <div class="border_dialog" title="Border">

                <div class="border_body">
                    <table width=100% height=100% align=center cellpadding=0 cellspacing=0>
                        <tr>
                            <td valign=top style="padding:5px;height:165px">

                                <table>
                                    <tr>
                                        <td valign=top style="padding:3px">
                                            <script>
                                                drawBorderStyleSelection()
                                            </script>
                                        </td>
                                        <td valign=top style="padding:3px">
                                            <script>
                                                drawBorderWidthSelection()
                                            </script>
                                        </td>
                                        <td valign=top style="padding:3px" nowrap>
                                            <script>
                                                drawBorderApplyToSelection()
                                            </script>
                                        </td>
                                        <td valign=top style="padding:3px" nowrap>
                                            <div><span id="txtLang" name="txtLang">Color</span>:</div>
                                            <input class="colorPicker" name="color" id="idSelBorderColor">

                                        </td>
                                    </tr>
                                </table>


                            </td>
                        </tr>
                        <tr>
                            <td class="dialogFooter" align="right">
                                <table cellpadding="1" cellspacing="0">
                                    <tr>
                                        <td>
                                            <input type="button" name="btnClose" id="btnClose" value="cancel" class="inpBtn" class="inpBtn" >
                                        </td>
                                        <td>
                                            <input type="button" name="btnOk" id="btnOk" value=" ok " onclick="doApply()" class="inpBtn" class="inpBtn" >
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>



</body>
</html>