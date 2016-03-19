
$("form").submit(function(e){
	$("#" + $(this).attr('id') + "-submit").val("Send");
	return true;
});