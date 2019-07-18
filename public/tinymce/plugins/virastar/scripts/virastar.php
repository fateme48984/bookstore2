<?php
require_once('../../conf.php');
$request = new Request(SECURITY_DOMAIN);
$cid = trim(strip_tags($request->getParameter('cid')));
$moduleCode = trim(strip_tags($request->getParameter('moduleCode')));
$contentType = trim(strip_tags($request->getParameter('ctype')));

if (!empty($contentType) && in_array($contentType, $contentTypes) && is_numeric($moduleCode) && in_array($moduleCode, $modulesCode[$contentType])) {
    if($modulesCode == 401 ) {
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
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="../../../skins/editor.css" rel="stylesheet" type="text/css">
    <link href="../../../skins/ui/oxide/skin.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo THEME_URI ?>/css/home.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo THEME_URI ?>/js/lib/lib.js"></script>
    <script type="text/javascript" src="<?php echo THEME_URI ?>/js/lib/lib.diff_match_patch.js"></script>
    <script type="text/javascript" src="<?php echo THEME_URI ?>/js/lib/lib.pretty-text-diff.js"></script>
    <script type="text/javascript" src="../js/virast.js"></script>
    <style>
        body {
            direction: rtl;
            font: 12px tahoma;
        }

        .diffcon .diff_div {
            border: 1px solid #ccc;
            background: #F9F9F9;
            border-radius: 4px;
            width: 334px;
            height: 305px;
            padding: 1.5%;
            overflow-y: scroll;
            direction: <?php echo $direction; ?>;
            text-align: <?php echo $textAlign; ?>;

        }

        .diffcon .focusout {
            height: 318px;
            margin-left: 5px;
            margin-right: 8px;
            width: 360px;
            border: 1px solid #ccc;
            border-radius: 3px;
            direction: <?php echo $direction; ?>;
            text-align: <?php echo $textAlign; ?>;
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

    <title>ویراستار</title>
</head>
<body>
<div class="tox tox-dialog__body">
    <div class="tox-dialog__body-content">
        <div class="tox-form">
            <table cellpadding="0" cellspacing="0" width="100%" height="100%">
                <tr class="diffcon">
                    <?php if($language == 'FA') {?>
                        <td style="display: none"><textarea class="original" name=""></textarea></td>
                        <td>
                            <div class="diff diff_div" ></div>
                        </td>
                        <td><textarea class="focusout changed" name=""></textarea></td>
                    <?php } else { ?>
                        <td style="display: none"><textarea class="original" name=""></textarea></td>
                        <td><textarea class="focusout changed" name=""></textarea></td>
                        <td>
                            <div class="diff diff_div" ></div>
                        </td>

                    <?php }?>

                </tr>
                <tr class="button_con">
                    <td colspan="2" style="text-align:center;">
                        <div>
                            <label class="first container" style="margin: 0px 5px">
                                <input type="checkbox" checked="checked" id="virast_psnumber">
                                <?php echo $translate['Change numbers to persian'][$lang] ?>
                            </label>
                        </div>
                        <div class="first mce-primary mce-btn"
                             style="text-align: center;margin-top: 7px;margin-bottom: 7px;">
                            <button type="button" class="virast_butt_matn btn-virast">
                                <span class="tox-button tox-button--secondary"><?php echo $translate['Edit'][$lang] ?></span>
                            </button>
                        </div>
                        <div class="second" style="display: none;margin-top: 8px;">
                                <button type="button" class="virast_submit_butt_matn btn-virast"
                                        onclick="insertVirast();return false;">
                                    <span class="tox-button"><?php echo $translate['Add'][$lang] ?></span>
                                </button>
                                <button type="button" class="virast_undo_butt_matn btn-virast">
                                    <span class="tox-button tox-button--secondary">
                                        <?php echo $translate['Cancel'][$lang] ?>
                                    </span>
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