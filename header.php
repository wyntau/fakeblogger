<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />	
<title><?php iSaymeDocumentTitle(); ?></title>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<?php wp_head(); ?>
<?php
if($GLOBALS['fakeblogger_options']['enable_google_analytics']) {
		if(!$GLOBALS['fakeblogger_options']['exclude_admin_analytics'] || !current_user_can('manage_options')) {
			echo $GLOBALS['fakeblogger_options']['google_analytics_code'];
		}
	}
	?>
</head>
<body>
<div id="divall">
	<div id="wrap">
		<div id="header">
			<div id="bloginfo">
				<h1 id="logo"><a href="<?php bloginfo('url');?>"><?php bloginfo('name');?></a></h1>
				<h3 id="desc"><?php bloginfo('description');?></h3><!--end of desc-->
			</div><!--end of bloginfo-->
			<div id="menu">
<?php wp_nav_menu(array('theme_location'=>'primary')); ?>
			</div><!--end of menu-->
			<div class="clear"></div>
		</div><!--end of header-->
