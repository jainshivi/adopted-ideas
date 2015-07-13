jQuery(document).ready(function(){
	jQuery('#submitIdea').click(function(e){
		var text = jQuery("#ideaText").val();
		var user = jQuery('#userid').val();
		var post = jQuery('#campaignid').val();
		var author = jQuery('#author').val();
		var subject = jQuery('#ideaSubject').val();
		var plugindir = jQuery('#plugindir').val();
		
		if(text != "" && subject != "") {								// Ensure that we are not sending a blank message (subject or body)
			jQuery('#ideaText').val('');
			jQuery('#ideaSubject').val('');
			jQuery.post(plugindir+'/adopted-ideas/send_message.php',{text:text,user:user,post:post,author:author,subject:subject},function(data){
				//console.log(data);
			});
		}
	});
});
