var fetchedChilds = new Array();
$(document).ready(function(){
	var isRTL = true;
	var treeDirection = 'ltr';
	var treeTheme = 'default';
	var treeLables = new Array();
	treeLables['create'] = 'create';
	treeLables['rename'] = 'rename';
	treeLables['remove'] = 'remove';
	treeLables['edit']	 = 'edit';
	treeLables['cut'] 	 = 'cut';
	treeLables['paste']  = 'paste';
	
	if($("#cats").hasClass('rtl')){
		isRTL = true;
		treeDirection = 'rtl';
		treeTheme = 'default-rtl';
		treeLables['create'] = 'ایجاد';
		treeLables['rename'] = 'تغییر نام';
		treeLables['remove'] = 'حذف';
		treeLables['edit']	 = 'ویرایش';
		treeLables['cut'] 	 = 'بریدن';
		treeLables['paste']  = 'چسباندن';
	}
	
	$("#cats")
		.jstree({
			"core":{
				"initially_open" : [ "cat_0" ],
				"rtl":isRTL
			},
			"types" : {
				"valid_children" : 'all',
				"types" : {
					"DS" : {
						"icon" : { 
							"image" : "/admin/modules/charts/image/datasheet.png" 
						},
					},
				},
			},
			"themes" : {
				"theme" : treeTheme,
				"url"	: "/admin/themes/classic/css/lib.jstree.rtl.css",
	            "dots"	: true,
	            "icons" : true
	        },
	        "plugins" : [ "ui", "themes", "html_data" , "types"]
		}).bind('open_node.jstree', function(e, info){
			var parentID = info.rslt.obj.attr('id').replace('cat_', '');
			getChildsByParentID(parentID, info);
		}).delegate('a', 'dblclick', function(e, info){
			var dsID = $(this).parent('li').attr('id').replace('ds_', '');
			treeDblClickAction(dsID);
		});;
});

function getChildsByParentID(parentID, info){
	if($("#cat_"+parentID).children('ul').length){
		var childs = new Array();
		$("#cat_"+parentID).children('ul').children('li').each(function(){
			if(!$(this).children('ul').length && $.inArray($(this).attr('id').replace('cat_', ''), fetchedChilds) == -1){
				var childID = $(this).attr('id').replace('cat_', '');
				childs.push(childID);
				fetchedChilds.push(childID);
			}
		});
		if(childs.length > 0){
			$.post('../scripts/cats_ajax.php', {action: 'get_childs', cat_childs: childs}
				,function(response){
					response = eval("("+response+")");
					if(response.success){
						var childs_html = new Array();
						childs_html = response.childs_html;
						$.each(childs_html, function(index, value){
							$("#cat_"+index).append(value).find("li, a").filter(function () { return this.firstChild.tagName !== "INS"; }).prepend("<ins class='jstree-icon'>&#160;</ins>");
							$.jstree._reference("#cats").clean_node($("#cat_"+index));
						});
					} else {
						
					}
				}
			);
		}
	}
};
function treeDblClickAction(dsID){
	getDatasheetName(dsID);
	getCharts(dsID,1);
};