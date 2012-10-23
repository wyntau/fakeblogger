<?php
function iSaymeRecentcomments($args='number=5&status=approve'){

	$cacheID = md5($args);

	if($output = wp_cache_get('recentComments_'.$cacheID, 'iSayme')){
		echo $output;
		return;
	}

	$rcms = get_comments($args);

	//print_r($rcms);return;
	if(empty($rcms)){
		_e('没有找到数据');
		return;
	}
	//历遍数据
	$output = '<h3><span>最新评论</span></h3>';
	foreach( $rcms as $rcm ){
		// 如果访客昵称为空, 则将显示名字设为 "Anonymous"
		$author = $rcm->comment_author ? $rcm->comment_author : __('Anonymous');

		$content = iSaymeStriptags( $rcm->comment_content);

		$l_excerpt = iSaymeSubstr( $content, 200 );
		$l_excerpt = preg_replace('/["\']/', '', $l_excerpt);
		$s_excerpt = convert_smilies( iSaymeSubstr( $content, 24 ) );

		$comment_author_link = '<a href="'.get_comment_link($rcm).'" rel="external nofollow" title="'.$l_excerpt.'">'.$author.'</a>';

		if($rcm->comment_type == ''){
			$output .= '<li class="r_item"><div class="row"><span class="r_name">'.$comment_author_link.'</span><br /><span class="r_excerpt">'.$s_excerpt.'</span></div></li>'."\n";
		}elseif($rcm->comment_type == 'pingback'){
			$output .= '<li class="r_item r_pingback"><span class="rc_label name">' . __('Pingback:') . '</span>'.$comment_author_link.'</li>';
		}elseif($rcm->comment_type == 'trackback'){
			$output .= '<li class="r_item r_traback"><span class="rc_label name">' . __('Trackback:') . '</span>'.$comment_author_link.'</li>';
		}
	}
	wp_cache_add('recentComments_'.$cacheID. $output, 'iSayme');
	echo $output;
}
