<?php
/**
 * Add class 'tagcolor_0 ~ 9' to each tag link use regular expression by filter hook
 *
 * @param string $tagLinks the tag links
 * @return string
 */
function iSaymeColorfullTags($tagLinks){
	$r = "/class='(.*?)'/i";
	$tagLinks = explode("\n", $tagLinks);
	$c = array(0,1,2,3,4,5,6,7,8,9);
	$returns = '';
	foreach($tagLinks as $tagLink){
		$returns .= preg_replace($r, 'class="$1 tagcolor_'.$c[mt_rand(0, count($c)-1)].'"', $tagLink)."\n ";
	}
	return $returns;
}
// add filter to wp_tag_cloud
add_filter('wp_tag_cloud', 'iSaymeColorfullTags');
