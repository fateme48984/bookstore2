$(document).ready(function()
{
   /* $('.editable').each(function(){
        this.contentEditable = true;
    });*/
});

function insertHtml()
{
    if(txtBody.value.length>0 ) {
        var body = txtBody.value;

        sHTML = '<div>' + body + '</div>';
        window.parent.tinyMCE.activeEditor.execCommand('mceInsertContent', 0, sHTML);
        parent.tinymce.activeEditor.windowManager.close();
    }
};