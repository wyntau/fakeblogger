<div class="clear"></div>
		<div id="footer">
		Powered by Wordpress | Copyright &copy; 2011 <?php bloginfo('name');?><sup>&reg;</sup>  | FakeBlogger Coded By <a href="http://isayme.com">iSayme</a> Designed By <a rel="nofollow" href="http://blogger.com">Blogger</a>.
		</div><!--end of footer-->

	</div><!--end of wrap-->
</div><!--end of divall-->
<?php wp_footer();?>
<?php if(!is_page()):?>
<div id="updown">
<div id="up" title="我要上天!"></div>
<?php if(is_single()):?>
<div id="comt" title="查看评论"></div>
<div id="down" title="我要吐槽!"></div>
<?php else:?><div id="down" title="我要入地!"></div><?php endif;?>
</div><?php endif;?>
</body>
</html>
