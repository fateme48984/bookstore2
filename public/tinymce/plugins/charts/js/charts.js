$(document).ready(function(){
	
	
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
		
		resetEditor();
		
		var params = {
				action		: 'search',
				query		: $("#query").val(),
				ds_id		: $("#ds_id").val(),
				page		: page
		};
		
		var url = '../scripts/charts_ajax.php';
		
		var loader = '<img class="loader" alt="" src="/admin/tinymce/images/loading.gif">';
		
		$("#multimedia_images_content").find('.file_list').html(loader);
		
		
		$.post(url, params, function(response){
			if(response && response != undefined){
				response = eval("("+response+")");
				if(response['success']){
					$('.loader').remove();
					$("#multimedia_images_content").find('.file_list').html(response['message']);
					
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
function resetEditor(){
	
		$("#preview").attr('src', '../../../images/imgpreview.gif');
		$("#inpImgURL").val('');
		$("#inpImgAlt").val('');
		$("#inpImgAlign").val('');
		$("#inpImgWidth").val('');
		$("#inpImgHeight").val('');
		$("#inpImgTop").val('');
		$("#inpImgBottom").val('');
		$("#inpImgLeft").val('');
		$("#inpImgRight").val('');
	
};
function getDatasheetName(dsID){
	if(dsID && dsID > 0){
		var url = 'charts_ajax.php';
		
		var datashhetNameParams = {
				action	:'datasheet_name',
				ds_id	: dsID
		};
		
		$.post(url, datashhetNameParams, function(response){
			if(response && response != undefined){
				response = eval("("+response+")");
				$('.datasheet_name').html(response['message']);
				$('.datasheet_name_c').show();
				$('#ds_id').val(dsID);
			}
		});
	} else {
		$('#ds_id').val('*');
		$('.datasheet_name').html('');
		$('.datasheet_name_c').hide();
	}
};
function getCharts(dsID, page){
	
	if(dsID && dsID > 0){
		var url = '../scripts/charts_ajax.php';
		//var fileGroup = $("#file_group").val(); 
		resetEditor();
		
		var params = {
				action		: 'list',
				ds_id		: dsID,
				page		: page
		};
		
		var loader = '<img class="loader" alt="" src="/admin/tinymce/images/loading.gif">';
		
		$("#multimedia_images_content").find('.file_list').html(loader);
		
		
		$.post(url, params, function(response){
			if(response && response != undefined){
				response = eval("("+response+")");
				if(response['success']){
					$('.loader').remove();
					
					$("#multimedia_images_content").find('.file_list').html(response['message']);
					
				} else {
					alert(response['message']);
				}
			}
		});
	} else {
		resetEditor();
	
			$("#multimedia_images_content").find('.file_list').html('');
		
	}
	return false;
};