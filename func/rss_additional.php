<?php
function iSaymecopyright($content){
	if(is_feed()||is_single()){
		if($GLOBALS['fakeblogger_options']['rss_additional_show'] && $GLOBALS['fakeblogger_options']['rss_additional']){
		$after = '<div class="copyright_info">' . $GLOBALS['fakeblogger_options']['rss_additional'] . '</div>';
		$blog_link = get_bloginfo('home');
		$feed_url = get_bloginfo('rss2_url');
		$post_url = get_permalink();
		$post_title = get_the_title();
		$after = str_replace('%BLOG_LINK%', $blog_link, $after);
		$after = str_replace('%FEED_URL%', $feed_url, $after);
		$after = str_replace('%POST_URL%', $post_url, $after);
		$after = str_replace('%POST_TITLE%', $post_title, $after);
		}
	}
	return $content.$after;
}
add_filter('the_content', 'iSaymecopyright', 0);
