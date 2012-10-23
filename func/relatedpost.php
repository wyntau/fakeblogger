<?php
function iSaymeRelatedPosts( $args = '' ){
	global $wpdb, $post, $id;

	$cacheID = $id.md5($args);

	if($relatedPosts = wp_cache_get('relatedPosts_'.$cacheID, 'iSayme')){
		return $relatedPosts;
	}

	$default = array('limit'=>5, 'excerpt_length'=>78);
	$args = wp_parse_args( $args, $default );
	extract( $args, EXTR_SKIP );

	if(!$post->ID) return;

	$tags = wp_get_post_tags($id);

	$title =  '相关文章';
	$related_posts = '';

	if(!empty($tags)){
		$taglist = array();
		$tagcount = count($tags);
		if ($tagcount > 0) {
			for ($i = 0; $i < $tagcount; $i++) {
				$taglist[] = $tags[$i]->term_id;
			}
		}
		$related_query_args=array(
					'tag__in' => $taglist,
					'post__not_in' => array($post->ID),
					'showposts'=>$limit,
					'orderby'=>'rand',
					'caller_get_posts'=>1
		);
		$r_posts = new WP_Query($related_query_args);
		$related_posts = $r_posts->posts;
	}else{
		$related_query_args=array(
					'post__not_in' => array($post->ID),
					'showposts'=>$limit,
					'orderby'=>'rand',
					'caller_get_posts'=>1
		);
		$title = '随机文章';
		$r_posts = new WP_Query($related_query_args);
		$related_posts = $r_posts->posts;
	}

	//print_r($related_posts);

	$output = '<div class="contenthead"><h3>'.$title.'</h3></div>'."\n";
	$output .= '<div class="postcontent"><ul>'."\n";

	// not found
	if(!$related_posts){
		$output .= '<li>'.__('Not found.').'</li>'."\n";

	}else{

		foreach($related_posts as $related_post){
			$post_title = $related_post->post_title ? $related_post->post_title : __('No title');
			$comment_count = '<span class="count"> ( '.$related_post->comment_count.' )</span><br />';
			$post_excerpt = $excerpt_length ? iSaymeStriptags($related_post->post_content) : '';
			$post_excerpt = $post_excerpt ? '<small class="excerpt">'.convert_smilies( iSaymeSubstr($post_excerpt, $excerpt_length) ).'</small>' : '';
			$output .= '<li><a href="'.get_permalink($related_post).'" title="'.$post_title.'" rel="bookmark inlinks">'.$post_title.'</a>'.$comment_count.$post_excerpt.'</li>'."\n";
		}
	}

	$output .= '</ul></div>'."\n";

	wp_cache_add('relatedPosts_'.$cacheID. $output, 'iSayme');

	echo $output;
}

