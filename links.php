<?php
/**
 * Template Name: 链接页面 (links)
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
		<div class="linkpage">
				<ul>
					<?php my_list_bookmarks('title_li=&categorize=1&orderby=rand&title_before=<h3 style="background:#cccccc;font-size:14px;padding:5px;">&title_after=</h3>&category_before=<li>&category_after=</li>'); ?>
				</ul>

			</div>
		<?php the_content();?>
		</div><!--end of postcontent-->
		<div class="postmeta contentfoot">
		<?php _e('分类:'); ?> <?php the_category(', ') ?> | <?php _e('发布:'); ?> <?php  the_author(); ?> | 
    		评论:<?php comments_popup_link(' 0', ' 1', ' %'); ?> <?php edit_post_link('Edit', ' | ', ''); ?>
		</div><!--end of postmeta-->
	</div><!--end of everypost-->
<?php endwhile;?>
<div id="relatedpost" class="contentbody clear">
<?php iSaymeRelatedPosts();?>
<div class="contentfoot">&nbsp;</div>
</div><!--end of relatedpost-->
<?php else:?>
 Not Found!
<?php endif;?>

		</div><!--end of content-->
<?php get_sidebar();?>
<?php get_footer();?>
