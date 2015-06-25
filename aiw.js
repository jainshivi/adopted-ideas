jQuery(document).ready(function(){
	jQuery('#submitIdea').click(function(e){
		var text = jQuery("#ideaText").val();
		console.log("text");
		var user = jQuery('#userid').val();
		var post = jQuery('#campaignid').val();
		var author = jQuery('#author').val();
		var subject = jQuery('#ideaSubject').val();
		var plugindir = jQuery('#plugindir').val();
		jQuery('#ideaText').val('');
		jQuery('#ideaSubject').val('');
		jQuery.post(plugindir+'/adopted-ideas/send_message.php',{text:text,user:user,post:post,author:author,subject:subject},function(data){
			console.log(data);
		});
	});
});
