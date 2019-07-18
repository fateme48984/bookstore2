<?php
require_once('../../conf.php');

$request = new Request ( SECURITY_DOMAIN );
$cid          = trim(strip_tags($request->getParameter('cid')));
$contentType  = trim(strip_tags($request->getParameter('ctype')));
$moduleCode = trim(strip_tags($request->getParameter('moduleCode')));
$fileGroup = 2;
if (!empty($contentType) && in_array($contentType, $contentTypes) && is_numeric($moduleCode) && in_array($moduleCode, $modulesCode[$contentType])) {
    if($contentType == 'ne' && $moduleCode == 401) {
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

$multimediaCatsObj = new MultimediaCats();
$cats = $multimediaCatsObj->drawCatsTree();

$usersObj = new Users();
$users = $usersObj->getAllUsers();
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="../../../skins/ui/oxide/skin.min.css" rel="stylesheet" type="text/css">
    <link href="../../../skins/editor.css" rel="stylesheet" type="text/css">
    <link href="../css/multimedia.<?php echo $direction?>.css" rel="stylesheet" type="text/css">
    <link href="../css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="../css/colorPicker.css" rel="stylesheet" type="text/css">
    <link href="<?php echo THEME_URI?>/css/lib.jstree.rtl.css" rel="stylesheet" type="text/css">

    <script type="text/javascript" src="../js/lib-12.js"></script>
    <script type="text/javascript" src="<?php echo THEME_URI?>/js/lib/lib.cookie.js"></script>
    <script type="text/javascript" src="<?php echo THEME_URI?>/js/lib/lib.jstree.rtl.js"></script>
    <script type="text/javascript" src="../js/cats_popup.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../js/border.js"></script>
    <script type="text/javascript" src="../js/colorPicker.js"></script>

    <script type="text/javascript" src="../js/multimedia.js"></script>
    <script type="text/javascript" src="../js/image.js"></script>



<script>

function clearAllProperties() {
	document.getElementById("inpURL").value="";
	document.getElementById("inpWidth").value="400";
	document.getElementById("inpHeight").value="300";
	media_key.value = '';
};
function insertMedia() {

    if(media_key.value.length > 0) {
    	var width = document.getElementById('inpWidth').value;
 	   	var height = document.getElementById('inpHeight').value;
 	   	if(width == '' || width == '0') {
 	 	   	width = '400';
 	   	}
  	   	if(height == '' || height == '0') {
  	  	   	height = '300';
	   	}
	   	key = '{$sepehr_mmedia_'+media_key.value+'_'+width+'_'+height+'}';
        insertHTML(key);

    }
}

function insertHTML(media_key)
{
   var hasDownload = document.getElementById('downloadLink').value;
   var downloadLinkTitle = document.getElementById('downloadLinkTitle').value;
   sHtml = '<div dir="ltr" >'+media_key+'</div>';
   window.parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, sHtml );

   if($("#downloadLink").is(':checked')){
	   var fileURI = document.getElementById('inpURL').value;
	   if($("#downloadLinkTitle").val().trim().length != 0){
           var downloadLinkHtml = $("#downloadLinkTitle").val().trim();
       } else{
           if(lang == 'FA'){
	            var downloadLinkHtml = 'دانلود';
           } else {
	            var downloadLinkHtml = 'Download';
           }
       }


       var downloadLink = '<div dir="<?php echo $direction;?>" align="center">'+
           				'<a href="'+fileURI+'" target="_blank" rel="attachment" title="'+downloadLinkHtml+'">'+downloadLinkHtml+'</a>'+
           			'</div>';
       //obj.insertHTML(downloadLink);

       window.parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, downloadLink );
       parent.tinymce.activeEditor.windowManager.close();


   }
}

//-------------------------------------------------------------------------------
//General Scripts
function selectFile(obj) {
    var file_name = obj.getAttribute('file_name');
    var file_id   = obj.getAttribute('file_id');
    var file_uri  = obj.getAttribute('file_uri');

	if($("#file_group").val() == "I"){
	    var file_thm = obj.getAttribute('file_thm');

	    var url = file_uri + '/' + file_name;
		var preview_url = file_uri + '/' + file_thm;

	    var imgSrcField = document.getElementById('inpImgURL');
	    imgSrcField.value = url;

	    var preview = document.getElementById('preview');
	    preview.src = preview_url;

        /*$("#preview").load(function(){
            $('#inpImgWidth').prop('value', $('#preview').width());
            $('#inpImgHeight').prop('value', $('#preview').height());
        });*/

        $('#btnReset').click(function() {
            $('#inpImgWidth').prop('value', '');
            $('#inpImgHeight').prop('value', '');
        });

	} else if($("#file_group").val() == "V" || $("#file_group").val() == "S"){
		var url = file_uri + '/' + file_name;

	    var srcField = document.getElementById('inpURL');
	    srcField.value = url;
	    media_key.value = file_id
	}
};

</script>

<title>چندرسانه ای</title>
</head>
<body>
<div class="tox tox-dialog__body" style="direction: rtl;">
    <div class="tox-dialog__body-content" style="overflow: hidden">
        <div class="tox-form1 mce-container1" style="white-space: normal">
            <table cellpadding="0" cellspacing="0" width="100%" height="100%" dir="<?php echo $direction;?>">
                <tr>
                    <td valign="top" width="30%" style="text-align: right; border-left: 1px dotted #000;border-top: 1px dotted #000;overflow: auto;">
                        <div id="cats" class="cats_container rtl" style="background: none;width: 226px;overflow: auto;">
                            <ul>
                                <li id="cat_0">
                                    <a href="#">ریشه</a>
                                    <ul>
                                        <?php echo $cats;?>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </td>
                    <td valign="top" width="70%" style="border-top: 1px dotted #000;">
                        <div class="editor_multimedia_top_tabs_c">
                            <a href="#" id="multimedia_images" rel="I" class="active_tab"><?php echo $translate['Image'][$lang] ?></a>
                            <a href="#" id="multimedia_videos" rel="V"><?php echo $translate['Video'][$lang] ?></a>
                            <a href="#" id="multimedia_sounds" rel="S"><?php echo $translate['Sound'][$lang] ?></a>
                            <div class="wrapper"></div>
                        </div>
                        <div class="editor_multimedia_search_c">
                            <table>
                                <tbody>
                                <tr>
                                    <td>
                                        <span class="tox-label"><?php echo $translate['phrase'][$lang] ?>:</span>
                                    </td>
                                    <td>
                                        <input id="query" name="query" type="text" class="inpTxt tox-textfield " style="width: 127px;direction: ltr;">&nbsp;
                                    </td>
                                    <td>
                                        <span class="tox-label"><?php echo $translate['Send by'][$lang] ?>:</span>
                                    </td>
                                    <td>
                                        <div style=" cursor: pointer;position: relative;border: 1px solid #ccc;border-radius: 3px;padding: 2px;background: #fff;height: 25px;">
                                            <select name="addby" id="addby" class="inpSel combo_plugin i cmbo" style="width: 127px;">
                                                <option value="*"><?php echo $translate['All'][$lang] ?></option>
                                                <?php
                                                foreach($users as $key=>$user){
                                                    echo '<option value="'.$key.'">'.$user.'</option>';
                                                }
                                                ?>
                                            </select>&nbsp;

                                        </div>
                                    </td>
                                    <td>
                                        <input type="button" value="<?php echo $translate['Search'][$lang] ?>" name="search" id="search" class="inpTxt tox-button btn-search" >
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" >
                                        <span class="cat_name_c">
                                            <span class="tox-label" style="width: 45px;float: <?php echo $textAlign;?>;"><?php echo $translate['Category'][$lang] ?>:</span>
                                            <span class="cat_name tox-label" style="width: 45px;float: right;"></span>&nbsp;
                                            <div class="wrapper"></div>
                                        </span>
                                    </td>
                                    <td colspan="1">

                                        <input type="hidden" name="cat_id" id="cat_id" value="*">
                                    </td>
                                    <td colspan="1">
                                        <input type="hidden" name="file_group" id="file_group" value="I">
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>

                        <!-- Images Tab Content -->
                        <div id="multimedia_images_content" class="multimedia_tab_content active_content">
                            <div class="files">
                                <div class="file_list">

                                </div>
                                <div class="file_preview">
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td height="150" width="150" valign="middle" align="center" style="text-align: center;">
                                                <div style="overflow: hidden;">
                                                    <img id="preview" src="../../../images/imgpreview.gif">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="wrapper"></div>
                            </div>
                            <div class="settings"  style="text-align: <?php echo $textAlign;?>;direction: <?php echo $direction;?>;">
                                <table width=100%>
                                    <tr>
                                        <td nowrap>
                                            <span id="txtLang" class="tox-label" style="margin-top: 3px;"><?php echo $translate['Source'][$lang] ?> : </span>
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
                                            <span id="txtLang" class="tox-label"><?php echo $translate['Title'][$lang] ?> : </span>
                                        </td>
                                        <td width="">
                                            <input type="text" id="inpImgAlt" name=inpImgAlt style="width:150px" value="" class="inpTxt tox-textfield " onkeyup="doPreview();"  dir="<?php echo $direction;?>" >
                                        </td>
                                        <td rowspan="5" style="padding-top:4px;padding-right:7px;">
                                            <div style="height:166px;border-left:#c7c7c7 1px solid;width:1px"></div>
                                        </td>
                                        <td>
                                            <span id="txtLang" class="tox-label"><?php echo $translate['Spacing'][$lang] ?> :</span>
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td nowrap>
                                            <span id="txtLang" class="tox-label"><?php echo $translate['Alignment'][$lang] ?> :</span>
                                        </td>
                                        <td nowrap>
                                            <div class="tox-selectfield" style="width: 150px;">
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
                                                </select>

                                            </div>
                                        </td>
                                        <td nowrap>
                                            <span id="txtLang" class="tox-label"><?php echo $translate['Top'][$lang] ?> : </span>
                                        </td>
                                        <td nowrap>
                                            <input type="text" name="inpImgTop" id="inpImgTop" size=2 class="inpTxt tox-textfield dir-align" onkeyup="doPreview()" style="width: 60px;"> &nbsp;
                                            <span>px</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap>
                                            <span id="txtLang" class="tox-label"><?php echo $translate['Border'][$lang] ?> :</span>
                                        </td>
                                        <td nowrap>
                                            <input type="button" name=btnBorder id=btnBorder value="<?php echo $translate['Border Style'][$lang] ?>" class="inpTxt tox-textfield  border_btn" style="width:150px" />
                                        </td>
                                        <td nowrap>
                                            <span id="txtLang" class="tox-label"><?php echo $translate['Bottom'][$lang] ?> :</span>
                                        </td>
                                        <td nowrap>
                                            <input type="text" name="inpImgBottom" id="inpImgBottom" size=2 class="inpTxt tox-textfield dir-align" onkeyup="doPreview()" style="width: 60px;"> &nbsp;
                                            <span>px</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap>
                                            <span id="txtLang" class="tox-label"> <?php echo $translate['Width'][$lang] ?> :</span>
                                        </td>
                                        <td nowrap rowspan="2">
                                            <table cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td>
                                                        <input type="text" name="inpImgWidth" id="inpImgWidth" size=2 class="inpTxt widthScale scaleInput tox-textfield input_style_m dir-align" value=""  style="width: 60px;"> &nbsp;
                                                        <span style="line-height: 21px;">px</span>
                                                    </td>
                                                    <td rowspan="2" height="50" style="padding-left:3px;padding-top:0">
                                                        <img src="../img/image_reset_<?php echo $direction ?>.gif" align=left width="15" height="56">
                                                    </td>
                                                    <td rowspan="2" height="50" style="padding-top:0px;padding-left: 5px">
                                                        <input type="button" name="btnReset" id="btnReset" style="border:1px solid #ccc;background-color: #e3e3e3;color:#333;padding: 5px 8px;cursor: pointer;" value="<?php echo $translate['Reset'][$lang] ?>">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="inpImgHeight" id="inpImgHeight" size=2 class="inpTxt heightScale scaleInput tox-textfield input_style_m dir-align" value=""  style="width: 60px;"> &nbsp;
                                                        <span style="line-height: 21px;">px</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td nowrap>
                                            <span id="txtLang" class="tox-label"><?php echo $translate['Left'][$lang] ?> :</span>
                                        </td>
                                        <td nowrap>
                                            <input type="text" name="inpImgLeft" id="inpImgLeft" size=2 class="inpTxt tox-textfield dir-align" onkeyup="doPreview()" id="Text2"  style="width: 60px;"> &nbsp;
                                            <span>px</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap>
                                            <span id="txtLang" class="tox-label"><?php echo $translate['Height'][$lang] ?> :</span>

                                        </td>

                                        <td nowrap>
                                            <span id="txtLang" class="tox-label"><?php echo $translate['Right'][$lang] ?> :</span>
                                        </td>
                                        <td nowrap>
                                            <input type="text" name="inpImgRight" id="inpImgRight" size=2 class="inpTxt tox-textfield dir-align" onkeyup="doPreview()" id="Text1"  style="width: 60px;"> &nbsp;
                                            <span>px</span>

                                        </td>
                                    </tr>


                                    <tr>
                                        <td colspan="6">
                                            <div style="padding:3px;"></div>
                                            <div id="divPreview" style="font-size: 12px; padding:5px;padding-left:5px;overflow:auto;border:1px dimgray solid;height:85px;background:#ccc;width:428px;">
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

                            </div>
                            <div>
                                <table>
                                    <tr>
                                        <td class="dialogFooter" align="right">
                                            <table cellpadding=0 cellspacing=0>
                                                <tr>
                                                    <td style="padding: 0px 10px;">
                                                        <div class="mce-btn" style="text-align: center;">
                                                            <button type="button" name="btnCancel" id="btnCancel" onclick="parent.tinymce.activeEditor.windowManager.close();" class="inpBtn"  onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">
                                                                <span class="tox-button tox-button--secondary"><?php echo $translate['Cancel'][$lang] ?></span>
                                                            </button>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="mce-primary mce-btn" style="text-align: center;">
                                                            <button type="button" name="btnInsert" id="btnInsert" onclick="doInsert();" class="inpBtn" onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">
                                                                <span class="tox-button"><?php echo $translate['Insert'][$lang] ?></span>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Videos Tab Content -->
                        <div id="multimedia_videos_content" class="multimedia_tab_content">
                            <div class="files">
                                <div class="file_list">

                                </div>
                            </div>
                            <div class="settings settings_multimedia" style="text-align: <?php echo $textAlign;?>;direction: <?php echo $direction;?>;">
                                <table cellpadding=2 cellspacing=0  style="width:100%">
                                    <tr>
                                        <td nowrap><span id="txtLang" name="txtLang" class="tox-label" readonly="readonly"><?php echo $translate['Source'][$lang] ?> :</span></td>
                                        <td colspan="4" style="">
                                            <table cellpadding="0" cellspacing="0" style="">
                                                <tr>
                                                    <td style="width:100%">
                                                        <input type="text" name='inpURL' id='inpURL' value="" style="width: 300px;margin: 1px;text-align: left;direction: ltr;" class="inpTxt tox-textfield ">
                                                    </td>
                                                    <td>

                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap><span id="txtLang" name="txtLang" class="tox-label"><?php echo $translate['Width'][$lang] ?> :</span></td>
                                        <td colspan="4">
                                            <input type="text" name="inpWidth" id="inpWidth" value=400 style="width: 60px;margin: 1px;" class="inpTxt tox-textfield">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap><span id="txtLang" name="txtLang" class="tox-label"><?php echo $translate['Height'][$lang] ?> :</span></td>
                                        <td colspan="4"><input type="text" name="inpHeight" id="inpHeight" value=300 style="width: 60px;margin: 1px;" class="inpTxt tox-textfield"></td>
                                    </tr>
                                    <tr style="height: 30px;">
                                        <td nowrap><span id="txtLang" name="txtLang" class="tox-label"><?php echo $translate['Download link'][$lang] ?> : </span></td>
                                        <td nowrap>
                                            <input type="checkbox" name="downloadLink" id="downloadLink" class="inpChk">

                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap><span id="txtLang" name="txtLang" class="tox-label"><?php echo $translate['Download link title'][$lang] ?> : </span></td>
                                        <td nowrap>
                                            <input type="text" name="downloadLinkTitle" id="downloadLinkTitle" class="inpTxt tox-textfield " style="width: 300px;" readonly="readonly" dir="<?php echo $direction;?>">

                                        </td>
                                    </tr>
                                </table>
                                <input type="hidden" name="media_key" id="media_key">
                                <div>
                                    <table cellpadding=0 cellspacing=0 style="float: right;margin-right: 10px;">
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
                                                    <button type="button" name="btnInsert" id="btnInsert" onclick="insertMedia();parent.tinymce.activeEditor.windowManager.close();" class="inpBtn" onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">
                                                        <span class="tox-button"><?php echo $translate['Insert'][$lang] ?></span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="wrapper"></div>
                                </div>
                            </div>
                        </div>
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
                                            <input type="button" name="btnClose" id="btnClose" value="cancel" class="inpBtn" class="inpBtn tox-button tox-button--secondary" >
                                        </td>
                                        <td>
                                            <input type="button" name="btnOk" id="btnOk" value=" ok " onclick="doApply()" class="inpBtn" class="inpBtn tox-button" >
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