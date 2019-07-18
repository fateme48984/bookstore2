$(document).ready(function(){

    $('#downloadLink').change(function(){
        if($(this).is(':checked')){
            $('#downloadLinkTitle').prop('readonly', '').focus();
        } else {
            $('#downloadLinkTitle').prop('readonly', 'readonly');
        }
    });

	$('.editor_multimedia_top_tabs_c').find('a').click(function(){
		if(!$(this).hasClass('active_tab')){
			resetEditor($('.active_content').find("#file_group").val());
			resetSearchInputs();
			
			$('.active_content').removeClass('active_content');
			$('.active_tab').removeClass('active_tab');
			$(this).addClass('active_tab');
			$("#file_group").val($(this).prop('rel'));
			if("I" == $("#file_group").val()){
				$("#multimedia_images_content").addClass('active_content');
			} else {
				$("#multimedia_videos_content").addClass('active_content');
			}
			
			var catID = $("#cat_id").val();
			if(catID != '*'){
				getFiles(catID, 1);
			} else {
				$("#multimedia_images_content").find('.file_list').html('');
				$("#multimedia_videos_content").find('.file_list').html('');
			}
		}
		return false;
	});
	
	$('#search').click(function(){
		doSearch(1);
		return false;
	});
	
});
function pageChanged(element){
	page = element.value;
	if(page > 0){
		doSearch(page);
	}
	return false;
}
function doSearch(page){
	if($("#query").val() != ''){
		var fileGroup = $("#file_group").val();
		resetEditor(fileGroup);
		
		var params = {
				action		: 'search',
				query		: $("#query").val(),
				file_group	: fileGroup,
				addby		: $("#addby").val(),
				cat_id		: $("#cat_id").val(),
				page		: page
		};
		
		var url = '../scripts/multimedia_ajax.php';
		
		var loader = '<img class="loader" alt="" src="/admin/tinymce/images/loading.gif">';
		if(fileGroup == 'I'){
			$("#multimedia_images_content").find('.file_list').html(loader);
		} else if(fileGroup == "V" || fileGroup == "S"){
			$("#multimedia_videos_content").find('.file_list').html(loader);
		}
		
		$.post(url, params, function(response){
			if(response && response != undefined){
				response = eval("("+response+")");
				if(response['success']){
					$('.loader').remove();
					if(fileGroup == 'I'){
						$("#multimedia_images_content").find('.file_list').html(response['message']);
					} else if(fileGroup == "V" || fileGroup == "S"){
						$("#multimedia_videos_content").find('.file_list').html(response['message']);
					} 
				} else {
					alert(response['message'])
				}
			}
		});
	}
};

function resetSearchInputs(){
	$("#query").val('');
	$("#addby").val('');
};
function resetEditor(type){
	if(type == 'I'){
		$("#preview").prop('src', '../../../images/imgpreview.gif');
		$("#inpImgURL").val('');
		$("#inpImgAlt").val('');
		$("#inpImgAlign").val('');
		$("#inpImgWidth").val('');
		$("#inpImgHeight").val('');
		$("#inpImgTop").val('');
		$("#inpImgBottom").val('');
		$("#inpImgLeft").val('');
		$("#inpImgRight").val('');
	} else if(type == 'V' || type == 'S'){
		if($("#inpURL").val() != ''){
			$("#inpURL").val('');
			$("#inpWidth").val('400');
			$("#inpHeight").val('300');
		}
	}
};
function getCatName(catID){
	if(catID && catID > 0){
		var url = 'multimedia_ajax.php';
		
		var catNameParams = {
				action	:'cat_name',
				cat_id	: catID
		};
		
		$.post(url, catNameParams, function(response){
			if(response && response != undefined){
				response = eval("("+response+")");
				$('.cat_name').html(response['message']);
				$('.cat_name_c').show();
				$('#cat_id').val(catID);
			}
		});
	} else {
		$('#cat_id').val('*');
		$('.cat_name').html('');
		$('.cat_name_c').hide();
	}
};
function getFiles(catID, page){
	var fileGroup = $("#file_group").val();
	if(catID && catID > 0){
		var url = '../scripts/multimedia_ajax.php';
		//var fileGroup = $("#file_group").val(); 
		resetEditor(fileGroup);
		
		var params = {
				action		: 'list',
				file_group	: fileGroup,
				cat_id		: catID,
				page		: page
		};
		
		var loader = '<img class="loader" alt="" src="/admin/tinymce/images/loading.gif">';
		if(fileGroup == 'I'){
			$("#multimedia_images_content").find('.file_list').html(loader);
		} else if(fileGroup == "V" || fileGroup == "S"){
			$("#multimedia_videos_content").find('.file_list').html(loader);
		} 
		
		$.post(url, params, function(response){
			if(response && response != undefined){
				response = eval("("+response+")");
				if(response['success']){
					$('.loader').remove();
					if(fileGroup == 'I'){
						$("#multimedia_images_content").find('.file_list').html(response['message']);
					} else if(fileGroup == "V" || fileGroup == "S"){
						$("#multimedia_videos_content").find('.file_list').html(response['message']);
					} 
				} else {
					alert(response['message']);
				}
			}
		});
	} else {
		resetEditor(fileGroup);
		if(fileGroup == 'I'){
			$("#multimedia_images_content").find('.file_list').html('');
		} else if(fileGroup == "V" || fileGroup == "S"){
			$("#multimedia_videos_content").find('.file_list').html('');
		} 
	}
	return false;
};