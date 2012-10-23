<?php
function Randomposts($limit = 8){
	global $wpdb, $id;
$posts_widget_title = '<h3><span>随机文章</span></h3>';
if(!$posts = wp_cache_get('widgetPostsLinkElse', 'iSayme')){
			$posts = get_posts("numberposts={$limit}&orderby=rand");
			wp_cache_add('widgetPostsLinkElse', $posts, 'iSayme');
		}
	$output .=$posts_widget_title;
	$output .="<ul>\n";
	if(empty($posts)){
		$output .= '<li>Can\'t found (没有找到)</li>';
		$output .= "</ul>\n";
		echo $output;
		return;
	}
	foreach($posts as $post) {
		$output .=  '	<li><a href="' . get_permalink($post) . '" title="' . $post->post_title . '" rel="bookmark inlinks">' . $post->post_title . '</a></li>'."\n";
	}
	$output .= "</ul>\n";
	echo $output;
}
function Recentposts($limit = 8){
	global $wpdb, $id;
$posts_widget_title = '<h3><span>最新文章</span></h3>';
		if(!$posts = wp_cache_get('widgetPostsLinkSingle', 'iSayme')){
			$posts = get_posts("numberposts={$limit}&orderby=post_date");
			wp_cache_add('widgetPostsLinkSingle', $posts, 'iSayme');
}
	$output .=$posts_widget_title;
	$output .="<ul>\n";
	if(empty($posts)){
		$output .= '<li>Can\'t found (没有找到)</li>';
		$output .= "</ul>\n";
		echo $output;
		return;
	}
	foreach($posts as $post) {
		$output .=  '	<li><a href="' . get_permalink($post) . '" title="' . $post->post_title . '" rel="bookmark inlinks">' . $post->post_title . '</a></li>'."\n";
	}
	$output .= "</ul>\n";
	echo $output;
}
