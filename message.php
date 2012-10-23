<?php
/**
 * Template Name: 留言读者墙(message)
 *
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

<div align="center"><h2>在此留言就可以上墙哦</h2></div>
<div align="center"><b>信春哥.原地满血,爆极品神器.</b>想要满血吗?赶紧来说几句吧!</div>
	<!-- start 读者墙 -->
<?php
    $adminEmail = get_option('admin_email');
    $query="SELECT COUNT(comment_ID) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL 24 MONTH ) AND user_id='0' AND comment_author_email !='$adminEmail' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author_email ORDER BY cnt DESC LIMIT 30";//最后的这个40是选取多少个头像，我一次让它显示40个。
    $wall = $wpdb->get_results($query);
    $maxNum = $wall[0]->cnt;
    foreach ($wall as $comment) 
    {
        $width = round(40 / ($maxNum / $comment->cnt),2);//这个40是我设置头像的宽度，和下面&size=40里的40一个概念，如果你头像宽度32，这里就是32了。
        if( $comment->comment_author_url ) 
        $url = $comment->comment_author_url;
        else $url="#";
        $tmp = "<li><a target=\"_blank\" href=\"".$comment->comment_author_url."\"><span class=\"pic\" style=\"background: url(http://www.gravatar.com/avatar/".md5(strtolower($comment->comment_author_email))."?s=36&d=monsterid&r=G) no-repeat;\">pic</span><span class=\"num\">".$comment->cnt."</span><span class=\"name\">".$comment->comment_author."</span></a><div class='active-bg'><div class='active-degree' style='width:".$width."px'></div></div></li>";
        $output .= $tmp; 
     }
    $output = "<div class=\"readerwall\">".$output."<div class=\"clear\"></div></div>";
    echo $output ;
?>
<!-- end 读者墙 -->

		<?php the_content();?>
		</div><!--end of postcontent-->
		<div class="postmeta contentfoot">
		<?php _e('分类:'); ?> <?php the_category(', ') ?> | <?php _e('发布:'); ?> <?php  the_author(); ?> | 
    		评论:<?php comments_popup_link(' 0', ' 1', ' %'); ?> <?php edit_post_link('Edit', ' | ', ''); ?>
		</div><!--end of postmeta-->
	</div><!--end of everypost-->
<?php endwhile;?>

<?php comments_template();?>
<?php else:?>
 Not Found!
<?php endif;?>

		</div><!--end of content-->
<?php get_sidebar();?>
<?php get_footer();?>
