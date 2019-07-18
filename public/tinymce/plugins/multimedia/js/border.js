/*****************************
 Border Style
 *****************************/
function drawBorderStyleSelection(idSelected)
{
    arrStyleOptions=[
        ["idStyle_none","border:none;height:10px;","No Border"],
        ["idStyle_solid","border-bottom:black 1px solid;height:10px;",""],
        ["idStyle_dotted","border-bottom:black dotted;height:10px",""],
        ["idStyle_dashed","border-bottom:black dashed;height:10px",""],
        ["idStyle_double","border-bottom:black double;height:10px",""],
        ["idStyle_groove","border-style:groove;height:18px",""],
        ["idStyle_ridge","border-style:ridge;height:18px",""],
        ["idStyle_inset","border-style:inset;height:18px",""],
        ["idStyle_outset","border-style:outset;height:18px",""]
    ];//[ID,CssText,Caption)
    sHTML="<div style='overflow:auto;border:gray 1px solid;width:125px;height:127px;'>"
    sHTML+="<table id=tblBorderStyle cellpadding=0 cellspacing=0 width=100% style='table-layout:fixed;background:white'>"
    for(var i=0;i<arrStyleOptions.length;i++)
    {
        sHTML+="<tr>"
        sHTML+="<td valign=top onclick=\"doSelectBorderStyle(this)\" style=\"cursor:default;height:25px;padding:4px;border:white 1px solid;\" onmouseover=\"doOver(this);\" onmouseout=\"doOut(this);\">"
        sHTML+="<table id="+arrStyleOptions[i][0]+" name="+arrStyleOptions[i][0]+" style='"+arrStyleOptions[i][1]+"' width=100%><tr><td>"+arrStyleOptions[i][2]+"</td></tr></table>"
        sHTML+="</td>"
        sHTML+="</tr>"
    }
    sHTML+="</table><input type=hidden name='idSelBorderStyle' id='idSelBorderStyle'>"
    sHTML+="</div>"
    document.write(sHTML)
}

function doSelectBorderStyle(me)
{
    oNodes=document.all.tblBorderStyle.childNodes[0].childNodes;

    for(var i=0;i<oNodes.length;i++)
    {
        oNodes[i].childNodes[0].style.backgroundColor='#ffffff';
        oNodes[i].childNodes[0].style.border='#ffffff 1px solid';
    }

    me.style.backgroundColor='#f1f1f1';
    me.style.border='#708090 1px solid';
    idSelBorderStyle.value = me.childNodes[0].style.borderBottomStyle;
}

/*****************************
 Border Width
 *****************************/
function drawBorderWidthSelection()
{
    arrWidthOptions=[
        ["idWidth_1px","border-bottom:black 1px solid;height:16;","1px"],
        ["idWidth_2px","border-bottom:black 2px solid;height:16;","2px"],
        ["idWidth_3px","border-bottom:black 3px solid;height:16;","3px"],
        ["idWidth_4px","border-bottom:black 4px solid;height:16;","4px"],
        ["idWidth_5px","border-bottom:black 5px solid;height:16;","5px"],
        ["idWidth_6px","border-bottom:black 6px solid;height:16;","6px"],
        ["idWidth_7px","border-bottom:black 7px solid;height:16;","7px"]];
    sHTML="<div style='overflow:auto;border:gray 1px solid;width:125px;height:127px'>"
    sHTML+="<table id=tblBorderWidth cellpadding=0 cellspacing=0 width=100% style='table-layout:fixed;background:white'>"
    for(var i=0;i<arrWidthOptions.length;i++)
    {
        sHTML+="<tr>"
        sHTML+="<td id="+arrWidthOptions[i][0]+" name="+arrWidthOptions[i][0]+" style=\"height:25px;padding:1px;border:white 1px solid;\" onclick=\"doSelectBorderWidth(this)\" onmouseover=\"doOver(this);\" onmouseout=\"doOut(this);\">"
        sHTML+="<table width=100%><tr><td style=\"height:25px\" >"+arrWidthOptions[i][2]+"</td><td valign=top width=100%><table style='"+arrWidthOptions[i][1]+"' width=100%><tr><td></td></tr></table></td></tr></table>"
        sHTML+="</td>"
        sHTML+="</tr>"
    }
    sHTML+="</table><input type=hidden name='idSelBorderWidth' id='idSelBorderWidth'>"
    sHTML+="</div>"
    document.write(sHTML)
}
function doSelectBorderWidth(me)
{
    oNodes=tblBorderWidth.childNodes[0].childNodes
    for(var i=0;i<oNodes.length;i++)
    {
        oNodes[i].childNodes[0].style.backgroundColor='#ffffff';
        oNodes[i].childNodes[0].style.border='#ffffff 1px solid';
    }
    me.style.backgroundColor='#f1f1f1';
    me.style.border='#718191 1px solid';
    idSelBorderWidth.value = me.childNodes[0].childNodes[0].childNodes[0].childNodes[1].childNodes[0].style.borderBottomWidth;
}

/*****************************
 Border Apply To
 *****************************/
function drawBorderApplyToSelection()
{
    arrApplyToOptions=[
        ["idApplyTo_None","../img/border/border_none.gif","No Border"],
        ["idApplyTo_Outside","../img/border/border_outside.gif","Outside Border"],
        ["idApplyTo_Left","../img/border/border_left.gif","Left Border"],
        ["idApplyTo_Top","../img/border/border_top.gif","Top Border"],
        ["idApplyTo_Right","../img/border/border_right.gif","Right Border"],
        ["idApplyTo_Bottom","../img/border/border_bottom.gif","Bottom Border"]];
    sHTML="<div style='overflow:auto;border:gray 1px solid;width:60px;height:127px'>"
    sHTML+="<table id=tblBorderApplyTo cellpadding=0 cellspacing=0 width=100% style='table-layout:fixed;background:white'>"
    for(var i=0;i<arrApplyToOptions.length;i++)
    {
        sHTML+="<tr>"
        sHTML+="<td id="+arrApplyToOptions[i][0]+" name="+arrApplyToOptions[i][0]+" valign=top style=\"height:30px;padding:4px;border:white 1px solid;\" onclick=\"doSelectBorderApplyTo(this)\" onmouseover=\"doOver(this);\" onmouseout=\"doOut(this);\">"
        sHTML+="<img src='"+arrApplyToOptions[i][1]+"' alt='"+arrApplyToOptions[i][2]+"'>"
        sHTML+="</td>"
        sHTML+="</tr>"
    }
    sHTML+="</table><input type=hidden name='idSelBorderApplyTo' id='idSelBorderApplyTo'>"
    sHTML+="</div>"

    document.write(sHTML)
}
function doSelectBorderApplyTo(me)
{
    oNodes=tblBorderApplyTo.childNodes[0].childNodes
    for(var i=0;i<oNodes.length;i++)
    {
        oNodes[i].childNodes[0].style.backgroundColor='#ffffff';
        oNodes[i].childNodes[0].style.border='#ffffff 1 solid';
    }
    me.style.backgroundColor='#f1f1f1';
    me.style.border='#718191 1px solid';
    idSelBorderApplyTo.value=me.id;
}

function doOver(me)
{
    if(extractRGBColor(me.style.backgroundColor)!='f1f1f1' && me.style.backgroundColor!="#f1f1f1")
    {
        me.style.backgroundColor='#f0f0f0';
        me.style.border='#708090 1px solid';
    }
}
function doOut(me)
{
    if(extractRGBColor(me.style.backgroundColor)!='f1f1f1' && me.style.backgroundColor!="#f1f1f1")
    {
        me.style.backgroundColor='#ffffff';
        me.style.border='#ffffff 1px solid';
    }
}
function extractRGBColor(col) {
    var re = /rgb\((\d{1,3}),\s*(\d{1,3}),\s*(\d{1,3})\)/i;
    if (re.test(col)) {
        var result = re.exec(col);
        return convertDecToHex(parseInt(result[1])) +
            convertDecToHex(parseInt(result[2])) +
            convertDecToHex(parseInt(result[3]));
    }
    return convertDecToHex2(0);
}

function convertDecToHex(dec)
{
    var tmp = parseInt(dec).toString(16);
    if(tmp.length == 1) tmp = ("0" +tmp);
    return tmp;//.toUpperCase();
}

function convertDecToHex2(dec)
{
    var tmp = parseInt(dec).toString(16);

    if(tmp.length == 1) tmp = ("00000" +tmp);
    if(tmp.length == 2) tmp = ("0000" +tmp);
    if(tmp.length == 3) tmp = ("000" +tmp);
    if(tmp.length == 4) tmp = ("00" +tmp);
    if(tmp.length == 5) tmp = ("0" +tmp);

    tmp = tmp.substr(4,1) + tmp.substr(5,1) + tmp.substr(2,1) + tmp.substr(3,1) + tmp.substr(0,1) + tmp.substr(1,1)
    return tmp;//.toUpperCase();
}