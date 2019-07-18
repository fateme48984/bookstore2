<?php
require_once('../../conf.php');
$request = new Request ( SECURITY_DOMAIN );
$cid          = trim(strip_tags($request->getParameter('cid')));
$contentType  = trim(strip_tags($request->getParameter('ctype')));
$moduleCode = trim(strip_tags($request->getParameter('moduleCode')));
if (!empty($contentType) && in_array($contentType, $contentTypes) && is_numeric($moduleCode) && in_array($moduleCode, $modulesCode[$contentType])) {
    if (is_numeric($cid) && $cid > 0) {

        define('MODULE_CODE', $moduleCode);
        $authorizationObj = new Authorization();
        $authorizationObj->authorize();

        $chartCategoryObj = new ChartCategory();
        $cats = $chartCategoryObj->drawCatsTree();
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
<link href="../../../skins/editor.css" rel="stylesheet" type="text/css">
  <link href="../../../skins/ui/oxide/skin.min.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo THEME_URI?>/js/lib/lib.js"></script>
<script type="text/javascript" src="<?php echo THEME_URI?>/js/lib/lib.jstree.rtl.js"></script>
<link href="<?php echo THEME_URI?>/css/lib.jstree.rtl.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/ds_popup.js"></script>
<script type="text/javascript" src="../js/charts.js"></script>
<link href="../css/charts.<?php echo $direction?>.css" rel="stylesheet" type="text/css">
<link href="../css/charts.css" rel="stylesheet" type="text/css">


<script>

//-------------------------------------------------------------------------------
//General Scripts

function insertHTML(title,chart_key)
{
  sHTML = '<div dir="ltr" title="'+title+'">'+chart_key+'</div>';
  window.parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, sHTML );
  parent.tinymce.activeEditor.windowManager.close();
}

function selectChart(obj) {
    var chart_name = obj.getAttribute('chart_name');
    var chart_id   = obj.getAttribute('chart_id');
    var key = '{$sepehr_chart_'+chart_id+'}';
    
    chart_key.value = key;
    title.value = chart_name;
}

function insert() {
    if(chart_key.value.length>0 && title.value.length >0) {
        insertHTML(title.value,chart_key.value)
    }
}
</script>
<title>Charts</title>
</head>
<body>
<div class="tox tox-dialog__body" style="direction: rtl;">
    <div class="tox-dialog__body-content" style="overflow: hidden">
        <div class="tox-form1 mce-container1" style="white-space: normal">
            <table cellpadding="0" cellspacing="0" width="100%" height="100%" dir="<?php echo $direction;?>">
                <tr>
                    <td valign="top" width="30%" style="text-align: right;border-left: 1px dotted #000;border-top: 1px dotted #000;overflow: auto;">
                        <div id="cats" class="cats_container rtl" style="background: none;width: 226px;overflow: auto;">
                            <ul>
                                <li id="cat_0">
                                    <a href="#">گروه</a>
                                        <ul>
                                            <?php echo $cats;?>
                                        </ul>
                                </li>
                            </ul>
                        </div>
                    </td>
                    <td valign="top" width="70%" style="border-top: 1px dotted #000;">

                        <div class="editor_multimedia_search_c">
                            <div>
                                <div style="width: 60px;float: <?php echo $textAlign?>;">
                                <label  class="tox-label" style="line-height: 30px"><?php echo $translate['Title'][$lang] ?>:</label>

                                </div>
                                <div style="float: <?php echo $textAlign?>;">

                                    <input id="query" name="query" type="text" class="inpTxt tox-textfield " style="width: 127px;">&nbsp;

                                    <input type="button" value="<?php echo $translate['Search'][$lang] ?>" name="search" id="search" class="inpTxt tox-button btn-search">
                                </div>
                                <div class="wrapper"></div>
                            </div>
                            <div style="padding-top: 5px;">
                                <span class="datasheet_name_c">
                                    <label><?php echo $translate['Datasheet'][$lang] ?> :</label>
                                    <span class="datasheet_name"></span>&nbsp;
                                </span>

                                <input type="hidden" name="ds_id" id="ds_id" value="*">
                            </div>
                        </div>

                        <!-- Images Tab Content -->
                        <div id="multimedia_images_content" class="multimedia_tab_content active_content">
                            <div class="files">
                                <div class="file_list">

                                </div>

                                <div class="wrapper"></div>
                            </div>

                            <div class="settings">
                                <table width=100%   dir="ltr">
                                    <tr>
                                        <?php if ($direction == 'rtl') { ?>
                                            <td dir="rtl" width="10"><td nowrap>
                                                <span id="txtLang" style="direction: rtl;" class="tox-label"> <?php echo $translate['Chart'][$lang] ?> :  </span>
                                            </td>
                                            <td style="width: 445px">
                                                <input readonly type="text" id="title" name="title" class="inpTxt tox-textfield "  style="width:100%;text-align: right">
                                            </td>
                                        <?php } else { ?>
                                            <td style="width: 445px">
                                                <input readonly type="text" id="title" name="title" class="inpTxt tox-textfield "  style="width:100%;text-align: left;">
                                            </td>
                                            <td dir="rtl" width="10"><td nowrap>
                                                <span id="txtLang" style="direction: ltr;" class="tox-label"> <?php echo $translate['Chart'][$lang] ?> :  </span>
                                            </td>

                                        <?php } ?>


                                    </tr>

                                   </table>
                            </div>


                            <div>

                            <div class="mce-primary mce-btn" style="margin-top: 7px; float: <?php echo $antiTextAlign?>;">
                                <button type="button" name="btnInsert" id="btnInsert" onclick="insert();" class="inpBtn" onmouseover="this.className='inpBtnOver';" onmouseout="this.className='inpBtnOut'">
                                    <span class="tox-button"><?php echo $translate['Insert'][$lang] ?></span>
                                </button>
                            </div>


                                <input type="hidden" name="chart_key" id="chart_key">
                            </div>

                        </div>


                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
</body>
</html>