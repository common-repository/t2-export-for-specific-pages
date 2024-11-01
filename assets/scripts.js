jQuery(function($){

	var $pages = [];
	$('#hidden_pages').find('>span').each(function(){
		$pages.push( { id: $(this).data('id'), text:$(this).text() } );
	});

	$('#t2export_allpages').select2({
		data: $pages,
		placeholder: "Select page...",
    	allowClear: true,
    	multiple: true,
    	width: '50%'
	});
});