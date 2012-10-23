<?php
/**
 * Template Name: 归档(archive)
 */
get_header();
?>
		<div id="content" class="left">
<?php if(have_posts()):?>
<?php while(have_posts()):?>
<?php the_post();?>
	<div id="post-<?php the_ID();?>" class="everypost contentbody">
		<h4 class="postdate contenthead">
			<?php the_time(__('F jS, Y')); ?>
		</h4><!--end of postdate-->
		<h2 class="posttitle">
		<a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a>
		</h2><!--end of posttitle-->
		<div class="postcontent">
		<?php the_content();?>
		<a id="expand_collapse" href="#">全部展开/收缩</a>
<div id="archives"><?php archives_list_SHe(); ?></div>
		</div><!--end of postcontent-->
		<div class="postmeta contentfoot">
		<?php _e('分类:'); ?> <?php the_category(', ') ?> | <?php _e('发布:'); ?> <?php  the_author(); ?> | 
    		评论:<?php comments_popup_link(' 0', ' 1', ' %'); ?> <?php edit_post_link('Edit', ' | ', ''); ?>
		</div><!--end of postmeta-->
	</div><!--end of everypost-->
<?php endwhile;?>
<?php else:?>
 Not Found!
<?php endif;?>

		</div><!--end of content-->
<?php
function callback($buffer)
{
  $append_js=<<<EOT
	<script type="text/javascript">
		/* <![CDATA[ */
	jQuery(document).ready(function() {
	$('#expand_collapse,.archives-yearmonth').css({
		cursor: "s-resize"
	});
	$('#archives ul li ul.archives-monthlisting').hide();
	$('#archives ul li ul.archives-monthlisting:first').show();
	$('#archives ul li span.archives-yearmonth').click(function() {
		$(this).next().slideToggle('fast');
		return false;
	});
	//以下下是全局的操作
	$('#expand_collapse').toggle(
	function() {
		$('#archives ul li ul.archives-monthlisting').slideDown('fast');
	},
	function() {
		$('#archives ul li ul.archives-monthlisting').slideUp('fast');
	});
});
		/* ]]> */
	</script>
EOT;
//$buffer=ob_get_contents();
$buffer=str_replace('</body>',$append_js.'</body>',$buffer);
  return $buffer;
}
ob_start("callback");
get_sidebar();
get_footer();
ob_end_flush();
?>	
