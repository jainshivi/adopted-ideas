<?php
/*
* Template for the output of the Adopted Ideas Widget
* Override by placing a file called aiw_template.php in your active theme
*/

global $wpdb;
$postid = get_the_ID();
$idea_count = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix."adoptedideaswidget WHERE campaignid='$postid'");

?>

<aside id='adoptedIdeasWidget' class='widget cf widget-adopted-ideas-widget'>
	<div class='title-wrapper'>
		<h4 class='widget-title'>Adopted Ideas</h4>
	</div>



	<?php if($idea_count){ ?>
	<script>


		var ideas = {};			// information from ideas to be stored here for collapsable reuse

		/**
		 * method: collapse
		 * implements collapsable contents. executed on click
		 * from element. Uses element idea id information
		 * to determine whether it is collapsed or open
		 * and then acts on that.
		 * @param  element
		 */
		function collapse(element)
		{
			ideaId = element.getAttribute("idea-id");
			idea = ideas[ideaId];
			if(idea.display == 1) {
				element.innerHTML = idea.content.substring(0, idea.maxCharacters) + "...";
				idea.display = 0;
			}
			else {
				element.innerHTML = idea.content;
				idea.display = 1;
			}
		}
	</script>
	<div class='adopted-ideas'>
		<?php $ideas = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix."adoptedideaswidget WHERE campaignid='$postid' ORDER BY time DESC");
		foreach ($ideas as $idea) {
			$userinfo = get_userdata($idea->userid);
			$userinfo = $userinfo->data;

			$MAX_CHARACTERS = 75;							//the maxiumum number of characters to be displayed in the shortened content
			$content = stripslashes($idea->content);
			$subcontent = substr($content, 0, $MAX_CHARACTERS);
			$id = $idea->id;
			echo "<div class='idea'>
					<div class='avatar'>".get_avatar($idea->userid,'25')."</div>
					<div class='ideaContent'><strong>".$userinfo->user_nicename."</strong> 
					<span onclick='collapse(this)' idea-id='".$id."'>".$subcontent."...</span></div>
					
				</div>
				<script>
					ideas['".$id."']= {content: '".$content."', maxCharacters:".$MAX_CHARACTERS.", display: 0};
				</script>
				";

		}?>
	</div>
	
	<?php } ?>



	<?php if(get_current_user_id()){ ?>	
	<div class='suggest-idea'>
		<a class="button button-small" href="#" data-reveal-id="contributeAnIdeaModal">CONTRIBUTE AN IDEA</a>
	</div>
	<?php } ?>
</aside>
<input type="hidden" id="plugindir" value="<?php echo plugins_url();?>">
<input type="hidden" id="userid" value="<?php echo $postid;?>">
<input type="hidden" id="campaignid" value="<?php echo get_the_ID();?>">
<input type="hidden" id="author" value="<?php echo the_author_meta('ID');?>">


<div id="contributeAnIdeaModal" class="reveal-modal campaign-form content-block" data-reveal aria-labelledby="contributeAnIdeaModal" aria-hidden="true" role="dialog">
	<div class="title-wrapper"><h2 class="block-title">Contribute An Idea</h2></div>

	<div class="row">
	  <div class="large-12 columns">
	    <textarea placeholder="Your Idea" id="ideaText"></textarea>
	  </div>
	</div>

	<a class="close-reveal-modal" aria-label="Close"><i class="icon-remove-sign"></i></a>

	<p>
		<a id="submitIdea" class="button button-small" href="#" data-reveal-id="contributeAnIdeaModal">Send</a>
		<a class="button button-small" href="#" data-reveal-id="contributeAnIdeaModal">Cancel</a>
	</p>
</div>