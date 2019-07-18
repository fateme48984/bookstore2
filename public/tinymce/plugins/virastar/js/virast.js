$(document).ready(function () {
    $('.virast_butt_matn').click(function () {

        var url = '../scripts/ajax_virastar.php';
        var parent = $(this).parents('table tr.diffcon:first');
        var textarea = $(parent).find("textarea:visible:first");
        var string = $(textarea).val();
        var ex_element = $(parent).find("textarea:hidden:first");

        var cid = window.parent.tinyMCE.activeEditor.getParam('content_id');
        var moduleCode = window.parent.tinyMCE.activeEditor.getParam('module_code');
        var ctype = window.parent.tinyMCE.activeEditor.getParam('content_type');
        var psnumber = 0;
        //متن قبلی را نگه می داریم
        $(ex_element).html(string);
        $(ex_element).val(string);

        if ($('#virast_psnumber').is(":checked")) {
            psnumber = 1;
        }

        if (string.length >= 1) {
            $.post(url, {
                string: string,
                psnumber: psnumber,
                cid: cid,
                ctype: ctype,
                moduleCode: moduleCode
            }, function (data) {
                if (data['success']) {
                    $(textarea).val(data['virast']);
                    $(textarea).html(data['virast']);
                    $(parent).prettyTextDiff({
                        cleanup: true
                    });

                    $('.first').hide('fast');
                    $('.second').show('fast');
                } else {
                    $(textarea).val(data['virast']);
                    $(textarea).html(data['virast']);
                }

            }, 'json');

        } else {
            $(textarea).val('');
            $(textarea).html("");
        }
        return false;
    });

    $('.virast_undo_butt_matn').click(function () {
        var parent = $(this).parents('table tr.diffcon:first');
        var textarea = $(parent).find('textarea:visible:first');
        var ex_element = $(parent).find("textarea:hidden:first");
        var diff = $(parent).find('div.diff');

        $('.second').hide('fast');
        $('.first').show('fast');

        var string = $(ex_element).val();
        $(textarea).html(string);
        $(textarea).val(string);
        $(diff).val('');
        $(diff).html('');
        return false;
    });

});

function insertHTML(string) {
    // var obj=(opener?opener:openerWin).oUtil.obj;
    string = string.replace(/(?:\r\n|\r|\n)/g, '<br />');
    sHTML = '<div dir="rtl" >' + string + '</div>';

    window.parent.tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sHTML);
    parent.tinymce.activeEditor.windowManager.close();
}

function insertVirast() {
    var parent = $(this).parents('table tr.diffcon:first');
    var textarea = $(parent).find("textarea:visible:first");
    var string = $(textarea).val();
    insertHTML(string);
}