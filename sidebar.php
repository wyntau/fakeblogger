<div id="sidebar" class="left">
	<div id="rss">
	<!--<a id="myrss" href="<?php bloginfo('rss2_url');?>" title="RSS Feed">rss</a>
	<a id="tqq" href="#" title="腾讯微博">tqq</a>
	<a id="tsina" href="#" title="新浪微博">tsina</a>-->
	</div>
<div class="widget">
<form role="search" method="get" id="searchform" action="<?php echo get_option('siteurl');?>" > 
	<div> 
	<input type="text" value="" name="s" id="s" /> 
	<input type="submit" id="searchsubmit" value="搜索" /> 
	</div> 
	</form>
</div>		
<?php if( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ): ?>
<div class="widget">
		<?php iSaymeRecentcomments('number=5&status=approve');?>
</div>
<div class="widget">
<?php if(is_singular()):
	Recentposts($limit = 8);
	else :
	Randomposts($limit = 8);
	endif;?>
</div>
	<?php endif;//widget 1?>
<?php if( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ): ?>

	<?php endif;//widget 2?>
<div class="widget">
<?php wp_tag_cloud('unit=px&smallest=11&largest=18&order=RAND&number=30');//参数含义:单位(px),最小(11),最大(18),排序(随机) ?>
</div>
<div class="widget">
<?php wp_list_bookmarks('title_before=<h3>&title_after=</h3>&orderby=rand&limit=24&category=2'); //如不想随机显示.请去掉 &orderby=rand
		//此处显示的是友情链接,如果只想让某个分类显示,请去后台查看相应的分类ID,然后在orderby=rand的后面添加如下内容 &category= ID 即可 如果还想显示显示的数目,请再添加&limit=数字?>
<div class="clear"></div>
</div>
	<div class="widget">
		<h3><span>功能</span></h3>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
		</ul>
	</div>
	<div id="sidebarbottom"></div>
</div><!--end of sidebar-->
