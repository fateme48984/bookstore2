$(document).ready(function()
{


    $( function() {
        $( ".border_dialog" ).dialog({
            autoOpen: false,
            height: 260,
            width: 460,
            position:[1, 28]

        });

        $( "#btnBorder" ).on( "click", function() {
            $( ".border_dialog" ).dialog( "open" );
        });

        $('#btnClose').click(function() {
            $('.border_dialog').dialog('close');
        });
    } );

    $('.colorPicker').colorPicker();
});


function doPreview()
{
    var idImg = document.getElementById("idImg");
    var inpImgAlt = document.getElementById("inpImgAlt");
    var inpImgAlign = document.getElementById("inpImgAlign");

    var inpImgTop = document.getElementById("inpImgTop");
    var inpImgBottom = document.getElementById("inpImgBottom");
    var inpImgLeft = document.getElementById("inpImgLeft");
    var inpImgRight = document.getElementById("inpImgRight");

    idImg.style.width="";
    idImg.style.height="";

    idImg.title=inpImgAlt.value;
    idImg.alt=inpImgAlt.value;

    idImg.setAttribute("ALIGN", inpImgAlign.value);

    if(inpImgTop.value!="")idImg.style.marginTop=inpImgTop.value;
    else idImg.style.marginTop="";
    if(inpImgBottom.value!="")idImg.style.marginBottom=inpImgBottom.value;
    else idImg.style.marginBottom="";
    if(inpImgLeft.value!="")idImg.style.marginLeft=inpImgLeft.value;
    else idImg.style.marginLeft="";
    if(inpImgRight.value!="")idImg.style.marginRight=inpImgRight.value;
    else idImg.style.marginRight="";
}

function doInsert()
{

    var sHtml = '';
    var inpImgURL = $('#inpImgURL').val();
    if(inpImgURL != '') {

        var inpImgCaption = $("#inpImgCaption").val();
        var inpImgAlign = $("#inpImgAlign").val();
        var inpImgAlt = $("#inpImgAlt").val();

        var inpImgTop = $("#inpImgTop").val();
        var inpImgBottom = $("#inpImgBottom").val();
        var inpImgLeft = $("#inpImgLeft").val();
        var inpImgRight = $("#inpImgRight").val();

        var inpImgWidth = $("#inpImgWidth").val();
        var inpImgHeight = $("#inpImgHeight").val();

        var margin = '';

        if (inpImgTop == '' && inpImgBottom == '' && inpImgLeft == '' && inpImgRight == '') {
            margin = '0px';
        } else {
            if (inpImgTop != '') {
                margin = inpImgTop + 'px ';
            } else {
                margin = ' 0px ';
            }

            if (inpImgRight != '') {
                margin += inpImgRight + 'px ';
            } else {
                margin += '0px ';
            }

            if (inpImgBottom != '') {
                margin += inpImgBottom + 'px ';
            } else {
                margin += '0px ';
            }

            if (inpImgLeft != '') {
                margin += inpImgLeft + 'px ';
            } else {
                margin += '0px ';
            }


        }

        var idImg = document.getElementById("idImg");
        var sImgBorderTop=idImg.style.borderTop;
        var sImgBorderBottom=idImg.style.borderBottom;
        var sImgBorderLeft=idImg.style.borderLeft;
        var sImgBorderRight=idImg.style.borderRight;

        var bNoBorder=false;
        if((idImg.style.borderTopStyle=="none"||idImg.style.borderTop=="")&&
            (idImg.style.borderBottomStyle=="none"||idImg.style.borderBottom=="")&&
            (idImg.style.borderLeftStyle=="none"||idImg.style.borderLeft=="")&&
            (idImg.style.borderRightStyle=="none"||idImg.style.borderRight==""))
            bNoBorder=true;

        if(bNoBorder) {
            var border = "none";
        }
        else
        {
            var border ='border-top: '+sImgBorderTop+';';
            border +='border-bottom: '+sImgBorderBottom+';';
            border +='border-left: '+sImgBorderLeft+';';
            border +='border-right: '+sImgBorderRight+';';
        }


        var align = '';
        if (inpImgAlign != '') {
            align = inpImgAlign;
        }

        sHtml += '<img src="'+inpImgURL+'" alt="'+inpImgAlt+'" title="'+inpImgAlt+'" width="'+inpImgWidth+'" height="'+inpImgHeight+'"  style="margin:'+margin+';'+border+'" align="'+align+'"/>';

    }

    window.parent.tinyMCE.activeEditor.execCommand("mceInsertContent", false, sHtml);
    parent.tinymce.activeEditor.windowManager.close();

}

function doApply()
{
    sStyle=idSelBorderStyle.value;
    sWidth=idSelBorderWidth.value;
    sApplyTo=idSelBorderApplyTo.value;
    sColor=idSelBorderColor.style.backgroundColor;

    switch(sApplyTo)
    {
        case "idApplyTo_None":
            idImg.style.border="none";
            break;
        case "idApplyTo_Outside":
            idImg.style.border="none";
            idImg.style.border = sColor + " " + sWidth + " " + sStyle;

            break;
        case "idApplyTo_Left":
            idImg.style.border="none";
            idImg.style.borderLeft = sColor + " " + sWidth + " " + sStyle;

            break;
        case "idApplyTo_Top":
            idImg.style.border="none";
            idImg.style.borderTop = sColor + " " + sWidth + " " + sStyle;

            break;
        case "idApplyTo_Right":
            idImg.style.border="none";
            idImg.style.borderRight = sColor + " " + sWidth + " " + sStyle;

            break;
        case "idApplyTo_Bottom":
            idImg.style.border="none";
            idImg.style.borderBottom = sColor + " " + sWidth + " " + sStyle;

            break;
    }
    $('.border_dialog').dialog('close');
}
