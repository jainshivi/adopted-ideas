jQuery(document).ready(function(){
	jQuery('#submitIdea').click(function(e){
		var text = jQuery("#ideaText").val();
		var user = jQuery('#userid').val();
		var post = jQuery('#campaignid').val();
		var author = jQuery('#author').val();
		var plugindir = jQuery('#plugindir').val();
		jQuery('#ideaText').val('');
		jQuery.post(plugindir+'/adopted-ideas/send_message.php',{text:text,user:user,post:post,author:author},function(data){
			console.log(data);
		});
	});
});