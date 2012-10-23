<?php


if ( function_exists('register_nav_menus') ) {
	register_nav_menus(array('primary' => '头部导航栏'));
}

define('SAYME','iSayme');
define('FUNC',TEMPLATEPATH.'/func');
define('CUSTOMFUNC',TEMPLATEPATH.'/custom-func');
/**
 * include all PHP script
 * @param string $dir
 * @return unknown_type
 */
function iSaymeIncludeAll($dir){
	$dir = realpath($dir);
	if($dir){
		$files = scandir($dir);
		sort($files);
		foreach($files as $file){
			if($file == '.' || $file == '..'){
				continue;
			}elseif(preg_match('/\.php$/i', $file)){
				include_once $dir.'/'.$file;
			}
		}
	}
}
iSaymeIncludeAll( FUNC );
iSaymeIncludeAll( CUSTOMFUNC );
define('FAKEBLOGGER_OPTIONS', 'fakeblogger_options');
include_once TEMPLATEPATH.'/admin/admin.php';
$GLOBALS['fakeblogger_options'] = FakeBloggerOptions::getInstance();
function custom_smilies_src($src, $img){
    return get_bloginfo('template_directory').'/img/smilies/' . $img;
}
add_filter('smilies_src', 'custom_smilies_src', 10, 2); 
if ( !isset( $wpsmiliestrans ) ) {
		$wpsmiliestrans = array(
		':mrgreen:' => '11.gif',
		 ':no:' => '1.gif',
		':twisted:' => '19.gif',
		 ':shut:' => '23.gif',
		 ':eat:' => '3.gif',
		  ':arrow:' => '16.gif',
		  ':shock:' => '7.gif',
		   ':surprise:' => '26.gif',
		  ':smile:' => '33.gif',
		    ':???:' => '5.gif',
		   ':cool:' => '10.gif',
		    ':cold:' => '14.gif',
		   ':evil:' => '2.gif',
		   ':grin:' => '4.gif',
		   ':idea:' => '9.gif',
		    ':han:' => '6.gif',
		   ':oops:' => '25.gif',
		   ':mask:'=>'27.gif',
		    ':sigh:' => '15.gif',
		   ':razz:' => '17.gif',
		   ':roll:' => '21.gif',
		    ':cry:' => '28.gif',
		    ':zzz:' => '29.gif',
		    ':eek:' => '18.gif',
		     ':love:' => '20.gif',
		      ':sex:' => '13.gif',
		      ':jiong:' => '8.gif',
		    ':lol:' => '24.gif',
		    ':mad:' => '31.gif',
		     ':ool:' => '32.gif',
		    ':sad:' => '30.gif',
		);
	}
//禁用半角符号自动转换为全角
foreach(array('comment_text','the_content','the_excerpt','the_title') as $xx)
  remove_filter($xx,'wptexturize');
