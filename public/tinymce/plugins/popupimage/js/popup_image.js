$(document).ready(function(){

	if($('.scaleInput').length){
		$('.scaleInput').keyup(function () {
            if($('#checkImgResize').is( ":checked" ) == true) {
                var imageWith = $('#preview').width();
                var imageHeight = $('#preview').height();

                var calculatedSize = 0;
                var otherSideID;

                if ($(this).attr('id') == 'inpImgWidth') {
                    calculatedSize = $(this).val() * imageHeight / imageWith;
                    calculatedSize =  Math.round(calculatedSize);
                    otherSideID = 'inpImgHeight';
                } else {
                    calculatedSize = $(this).val() * imageWith / imageHeight;
                    calculatedSize =  Math.round(calculatedSize);
                    otherSideID = 'inpImgWidth';
                }
                $('#' + otherSideID).val(calculatedSize);
            }
		});
	}

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

function doInsert() {

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

		if(inpImgTop == '' && inpImgBottom == '' && inpImgLeft == '' && inpImgRight == '') {
			margin = '0px';
		}else {
			if(inpImgTop != '') {
				margin = inpImgTop+'px ';
			}else{
				margin = ' 0px ';
			}

            if(inpImgRight != '') {
                margin += inpImgRight+'px ';
            }else{
                margin += '0px ';
            }
			
			if(inpImgBottom != '') {
				margin += inpImgBottom+'px ';
			}else{
				margin += '0px ';
			}
			
			if(inpImgLeft != '') {
				margin += inpImgLeft+'px ';
			}else{
				margin += '0px ';
			}
			

		}



		
		$.post('../scripts/thumbnail_image.php',{imgUrl : inpImgURL ,
			width : inpImgWidth , height : inpImgHeight},
				function(data){
					data = eval("("+data+")");
					if(data.success){

						var html ='';
						if(inpImgCaption != '') {
							var i = Math.floor((Math.random() * 100) + 1);
							html =	'<div style="margin:'+margin+';">';
							html +=  '<figure style="width:'+inpImgWidth+'" class="figure">';
							html += '<a href="'+inpImgURL+'" title="'+inpImgCaption+'" target="_blank" style="text-decoration: none;" class="popUp aimg" id="lighbox_'+i+'">';
							html += '<img src="'+data.message+'" alt="'+inpImgAlt+'" />';
							html += '</a>';
							html += '<figcaption class="figure_caption">';
							html += '<div class="magnify"><a href="'+inpImgURL+'" title="'+inpImgCaption+'" target="_blank" style="text-decoration: none;" class="popUp">&nbsp;</a></div>';
							html += inpImgCaption+'</div>';
							html += '</figcaption>';
							html += '</figure>';
							html += '&nbsp;</div>';
						} else {
							var i = Math.floor((Math.random() * 100) + 1);
                            html =	'<div style="margin:'+margin+';">';
                            html +=  '<figure style="width:'+inpImgWidth+'" class="figure">';
							html +=  '<a href="'+inpImgURL+'" title="'+inpImgCaption+'" target="_blank" style="text-decoration: none;" class="popUp" id="lighbox_'+i+'">';
							html += '<img src="'+data.message+'" alt="'+inpImgAlt+'" />';
							html += '</a>';
							html += '<div class="magnify"><a href="'+inpImgURL+'" title="'+inpImgCaption+'" target="_blank" style="text-decoration: none;" class="popUp">&nbsp;</a></div>';
							html += '</figure>';
                            html += '&nbsp;</div>';
						}

                        window.parent.tinyMCE.activeEditor.execCommand( 'mceInsertContent', 0, html );
                        parent.tinymce.activeEditor.windowManager.close();
						

					}else {
						alert(data.message);
					}
				}
		); // end of post
		
	}
	return false;
    
    
}