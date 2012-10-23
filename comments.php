<?php
if( post_password_required() ):
?>
<div>
	<?php _e('This post is password protected. Enter the password to view comments.');?>
</div>
<?php return; endif;?>

<ol id="comments" class="clear">
<?php if( have_comments() ):?>
<?php wp_list_comments(array( 'callback' => 'fakeblogger_comment'));//array( 'callback' => 'fakeblogger_comment')?>
<?php else:?>
	<?php //_e('No comments yet.'); ?>
<?php endif; ?>
</ol>

<?php if(comments_open()):?>
<div id="ajaxbox" class="contentbody hide">
	<div class="contenthead"> 评论哥 <span class="says">&nbsp;说道：</span></div>
	<div class="postcontent"><p class="ajaxloading">评论提交中, 请稍候...</p></div>
	<div class="contentfoot">请耐心等待<span>&darr;</span></div>
</div>
<?php endif; ?>
<?php
if (get_option('page_comments')):
	$comment_pages = paginate_comments_links('echo=0');
	if ($comment_pages):
?>
<!--comments pages-->
<div id="commentnavi" class="page">
	<span class="pages icon"><?php _e('评论分页: '); ?></span>
	<span id="cpager"><?php echo $comment_pages; ?></span>
</div>
<?php
	endif;
endif;
?>


<?php  if(comments_open()) : ?>
<div class="contentbody" id="respond">
<p class="contenthead">发表评论:</p>
<form action="<?php echo get_option('siteurl');?>/wp-comments-post.php" method="post" id="commentform" class="postcontent">
<?php if ($user_ID):?>
<p>Logged in as <a href="<?php echo get_option('siteurl');?>/wp-admin/profile.php"><?php echo $user_identity;?></a>. <a href="<?php echo get_option('siteurl');?>/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a>
</p>
<?php else:?>
<p>	<input type="text" name="author" id="author" value="<?php echo $comment_author;?>" size="40" tabindex="1" />
	<label for="author"><small>Name <?php if ($req) echo "(required)";?></small></label>
</p>
<p>	<input type="text" name="email" id="email" value="<?php echo $comment_author_email;?>" size="40" tabindex="2" />
	<label for="email"><small>Mail (will not be published) <?php if ($req) echo "(required)";?></small></label>
</p>
<p>	<input type="text" name="url" id="url" value="<?php echo $comment_author_url;?>" size="40" tabindex="3" />
	<label for="url"><small>Website</small></label>
</p>
<?php endif;?>
<p>	<textarea name="comment" id="comment" cols="60" rows="10" tabindex="4"></textarea></p>
<p>	<input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
	<input type="hidden" name="comment_post_ID" value="<?php echo $id;?>" />
</p>
<?php //comment_id_fields(); ?>
<?php	do_action('comment_form', $post->ID);?>
</form>
<p class="contentfoot">◎欢迎参与讨论，请在这里发表您的看法、交流您的观点。</p>
</div>
<?php else:?>
<?php _e( 'Comments are closed.'); ?>
<?php endif;?>
