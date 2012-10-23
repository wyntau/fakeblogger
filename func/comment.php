<?php
function fakeblogger_comment($comment, $args, $depth){
	$GLOBALS['comment'] = $comment;
	static $commentcount;
	extract($args, EXTR_SKIP);
	if(defined('DOING_AJAX') && !isset($page)){
		$commentcount = get_comments_number($comment->comment_post_ID)-1; // will be increased
	}elseif(!$commentcount){
		if (get_option('page_comments')){
			$page = isset($page) ? $page : 1;
			$commentcount = get_option('comments_per_page') * ($page - 1);
		}else{
			$commentcount = 0;
		}
	}
	++$commentcount; // increase
	?>
<li <?php comment_class();?> id="comment-<?php comment_ID();?>">
	<div id="div-comment-<?php comment_ID();?>" class="contentbody">
<div class="comment-author vcard contenthead"> <cite class="fn"><?php comment_author_link(); ?></cite><span class="says">&nbsp;说道：</span></div>
<div class="comment-meta right">#<?php echo $commentcount;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php comment_time(__('M jS, Y @ H:i'))?>&nbsp;&nbsp;<?php if($user_ID) edit_comment_link(__('Edit')); ?></div>

<div class="comment-content postcontent"><?php if( ! $comment->comment_approved ): ?>
<p><strong>您的评论正在等待审核...</strong></p><?php endif; ?>	<?php comment_text(); ?></div>
<div class="reply contentfoot"><?php if(!defined('DOING_AJAX')):?><a rel="nofollow" class="quote" href="#comment-<?php comment_ID() ?>" title="引用这条评论"><?php _e('Quote'); ?></a> | <a class="replyto" rel="nofollow" href="#comment-<?php comment_ID() ?>" title="回复这条评论"><?php _e('Reply'); ?></a><?php endif;?>&nbsp;</div>
</div>
</li>
<?php
}
