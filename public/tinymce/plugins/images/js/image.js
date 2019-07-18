$(document).ready(function()
{


    if($('.scaleInput').length){

            $('.scaleInput').keyup(function () {
                if($('#checkImgResize').is( ":checked" ) == true){
                    var imageWith = $('#preview').width();
                    var imageHeight = $('#preview').height();
                    var calculatedSize = 0;
                    var otherSideID;
                    if ($(this).attr('id') == 'inpImgWidth') {
                        calculatedSize = $(this).val() * imageHeight / imageWith;
                        calculatedSize =  Math.round(calculatedSize);
                        otherSideID = 'inpImgHeight';
                    } else {
                        calculatedSize = $(this).val() * imageWith / imageHeight ;
                        calculatedSize =  Math.round(calculatedSize);
                        otherSideID = 'inpImgWidth';
                    }
                    $('#' + otherSideID).val(calculatedSize);
                }

            });

    }

    var oElement = window.parent.tinyMCE.activeEditor.selection.getNode() ;

    if(oElement.tagName=="IMG")
    {

        var src = oElement.getAttribute("SRC");

        inpImgURL.value= src;

        var preview = document.getElementById('preview');
        preview.src = src;

        var imgSrcField = document.getElementById('inpImgURL');
        imgSrcField.value = src;

        inpImgAlt.value = oElement.getAttribute("TITLE");
        inpImgAlt.value = oElement.getAttribute("ALT");

        inpImgAlign.value = oElement.getAttribute("align");

        idImg.style.borderTop=oElement.style.borderTop;
        idImg.style.borderBottom=oElement.style.borderBottom;
        idImg.style.borderLeft=oElement.style.borderLeft;
        idImg.style.borderRight=oElement.style.borderRight;

        inpImgWidth.value = oElement.getAttribute("WIDTH");
        inpImgHeight.value = oElement.getAttribute("HEIGHT");

        if(oElement.style.marginTop.substr(oElement.style.marginTop.length-2,2)=="px")
            inpImgTop.value=oElement.style.marginTop.substr(0,oElement.style.marginTop.length-2);
        else inpImgTop.value="";

        if(oElement.style.marginBottom.substr(oElement.style.marginBottom.length-2,2)=="px")
            inpImgBottom.value=oElement.style.marginBottom.substr(0,oElement.style.marginBottom.length-2);
        else inpImgBottom.value="";

        if(oElement.style.marginLeft.substr(oElement.style.marginLeft.length-2,2)=="px")
            inpImgLeft.value=oElement.style.marginLeft.substr(0,oElement.style.marginLeft.length-2);
        else inpImgLeft.value="";

        if(oElement.style.marginRight.substr(oElement.style.marginRight.length-2,2)=="px")
            inpImgRight.value=oElement.style.marginRight.substr(0,oElement.style.marginRight.length-2);
        else inpImgRight.value="";

       // btnApply.style.display="block";
      //  btnOk.style.display="block";
      //  btnInsert.style.display="none";

        doPreview();
    }
    else
    {
      //  btnApply.style.display="none";
     //   btnOk.style.display="none";
     //   btnInsert.style.display="block";
    }

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

function loadTxt()
{
    var txtLang = document.getElementsByName("txtLang");
    txtLang[0].innerHTML = "Source";
    txtLang[1].innerHTML = "Texte au survol<br>de la souris";
    txtLang[2].innerHTML = "Espacements";
    txtLang[3].innerHTML = "Alignement";
    txtLang[4].innerHTML = "Haut";
    txtLang[5].innerHTML = "Bordure d\u0027image";
    txtLang[6].innerHTML = "Bas";
    txtLang[7].innerHTML = "Largeur";
    txtLang[8].innerHTML = "Gauche";
    txtLang[9].innerHTML = "Hauteur";
    txtLang[10].innerHTML = "Droite";

    var optLang = document.getElementsByName("optAlign");
    optLang[0].text = "gauche";
    optLang[1].text = "droite";
    
    var optLang = document.getElementsByName("optLang");
    optLang[0].text = "absBas";
    optLang[1].text = "absMilieu";
    optLang[2].text = "ligne de base";
    optLang[3].text = "bas";
    optLang[4].text = "gauche";
    optLang[5].text = "milieu";
    optLang[6].text = "droite";
    optLang[7].text = "d\u00E9but du texte";
    optLang[8].text = "haut";
 
    document.getElementById("btnBorder").value = " style de bordure ";
    document.getElementById("btnReset").value = "r\u00E9initialiser";
    
    document.getElementById("btnCancel").value = "Annuler";
    document.getElementById("btnInsert").value = "Ins\u00E9rer";
    document.getElementById("btnApply").value = "Actualiser";
    document.getElementById("btnOk").value = " ok ";
}

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

        var inpImgTitle = $("#inpImgTitle").val();
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
            margin = '0px;';
        } else {
            if (inpImgTop != '') {
                margin = inpImgTop + 'px ';
            } else {
                margin = ' 0px ';
            }

            if (inpImgRight != '') {
                margin += inpImgRight + 'px ;';
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


        sHtml += '<img class="image_btn" src="'+inpImgURL+'" alt="'+inpImgAlt+'" title="'+inpImgTitle+'" width="'+inpImgWidth+'" height="'+inpImgHeight+'"  style="margin:'+margin+';'+border+'"  align="'+align+'"/>';

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

