<?php
/**
 * 错误泡泡
 *
 * 用于抛出错误
 * 实现$s的多变
 * 摘自著名主题 k2
 * 修改了参数类型,更方便使用!
 *
 * @since 1.0
 */
function fail($s) {
	if(!defined('DOING_AJAX')){
		wp_die($s, 'PhilNa Error');
		return;
	}
	header('HTTP/1.0 403 Forbidden');
	header('Content-Type: text/plain');
	if(is_string($s)){
		die($s);
	}else{
		$s;
		die;
	}
}
function iSaymeCanonical(){
	if(function_exists('rel_canonical') && is_singular()){
		return;
	}
	if(is_404() || is_search()){
		return;
	}
	global $post;
	if( is_home() )
		echo '<link rel="canonical" href="'.get_bloginfo('url').'"/>',"\n";
	else
		echo  '<link rel="canonical" href="'.get_permalink($post->ID).'"/>',"\n";
}
add_action('wp_head','iSaymeCanonical');

/**
 * Document title
 *
 * @return string
 */
function iSaymeDocumentTitle(){

	// check SEO plugins
	if(iSaymeCheckSEOPlugins()){
		wp_title();
		return;
	}

	global $post, $wp_query;
	$page = $wp_query->get('paged');
	$page = !empty($page) ? __(' - Page  ').$page : '';

	if( is_home() ){//首页
		echo bloginfo('name'), ' - ' . get_bloginfo('description'), $page;
	}elseif( is_single() ){ // 单篇文章页
		$catAndTag = get_the_category_list(' - ', '', false) . get_the_tag_list(' - ', ' - ', '');
		echo wp_title('',true), ' - ' . strip_tags($catAndTag), ' - ', get_bloginfo('name'), $page;
	}elseif( is_page()){ //者普通页面
		echo wp_title('',true), ' - ', get_bloginfo('name');
	}elseif( is_search() ){ //搜索页
		printf(__('Search results for &quot;%1$s&quot;'),
		attribute_escape(get_search_query()));
		echo ' - ', bloginfo('name'), $page;
	}elseif( is_category() ){ //分类页
		echo  single_cat_title(), ' - ', get_bloginfo('name'), $page;
	}elseif( is_tag() ){ //Tags页 (标签页)
		echo single_tag_title(), ' - ', get_bloginfo('name'), $page;
	}elseif( is_month() ){ //存档页(目前只有月份存档,如果有需要再添加其他的存档可能)
		printf(__('Archive for %1$s'), single_month_title(' ', false));
		echo  ' - ', get_bloginfo('name'), $page;
	}elseif( is_404() ){ //404 错误页面
		echo __('404 Not Found  I\'m sorry'), ' - ', get_bloginfo('name');
	}else{ //其他没有考虑到的情况
		echo wp_title('',true), ' - ', get_bloginfo('name'), $page;
	}
}

/**
 * 通过USER_Agent判断是否为机器人.
 *
 * @return Boolean
 */
function is_bot(){
	$bots = array('Google Bot1' => 'googlebot', 'Google Bot2' => 'google', 'MSN' => 'msnbot', 'Alex' => 'ia_archiver', 'Lycos' => 'lycos', 'Ask Jeeves' => 'jeeves', 'Altavista' => 'scooter', 'AllTheWeb' => 'fast-webcrawler', 'Inktomi' => 'slurp@inktomi', 'Turnitin.com' => 'turnitinbot', 'Technorati' => 'technorati', 'Yahoo' => 'yahoo', 'Findexa' => 'findexa', 'NextLinks' => 'findlinks', 'Gais' => 'gaisbo', 'WiseNut' => 'zyborg', 'WhoisSource' => 'surveybot', 'Bloglines' => 'bloglines', 'BlogSearch' => 'blogsearch', 'PubSub' => 'pubsub', 'Syndic8' => 'syndic8', 'RadioUserland' => 'userland', 'Gigabot' => 'gigabot', 'Become.com' => 'become.com','Bot'=>'bot','Spider'=>'spider','iSayme_for_test'=>'dFirefox');
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	foreach ($bots as $name => $lookfor) {
		if (stristr($useragent, $lookfor) !== false) {
			return true;
			break;
		}
	}
}

function iSaymeHeadItem(){
	echo
	'<link rel="shortcut icon" href="'.get_bloginfo('template_url').'/img/favicon.png" type="image/x-icon" />',"\n",
	'<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 文章" href="'.get_bloginfo('rss2_url').'" />',"\n",
	'<!--<link rel="alternate" type="application/rss+xml" title="RSS 2.0 - 全部评论" href="'.get_bloginfo('comments_rss2_url').'" />-->',"\n";

	echo is_singular() ? '<link rel="pingback" href="'.get_bloginfo('pingback_url').'"/>'."\n" : '';

	if(is_day() || is_tag() || is_search() || is_author()){
		echo '<meta name="robots" content="noindex,follow,noodp" />', "\n";
	}

	!is_bot() || wp_get_archives('type=monthly&format=link'); // for bots
}
add_action('wp_head', 'iSaymeHeadItem', 2);

function iSaymeCheckSEOPlugins(){
	// SEO plugins
	$seoClasses = array('All_in_One_SEO_Pack');
	$seoFunctions = array();

	foreach($seoClasses as $v){
		if(class_exists($v)) return true;
	}
	foreach($seoFunctions as $v){
		if(function_exists($v)) return true;
	}
}

/**
 * Keywords and description for head meta tag
 *
 * @return unknown_type
 */
function iSaymeKeywordsAndDescription(){

	// check SEO plugins
	if(iSaymeCheckSEOPlugins()){
		return;
	}

	global $post, $wp_query;

	// default
	$keywords = $GLOBALS['fakeblogger_options']['keywords'] ? $GLOBALS['fakeblogger_options']['keywords'] : '';
	$description = $GLOBALS['fakeblogger_options']['description'] ? $GLOBALS['fakeblogger_options']['description'] : get_bloginfo('description');

	if(is_singular()){ // 普通页面
		$keywords = array($keywords);
		$keywords[] = get_post_meta($post->ID, 'Keywords', true);
		$keywords[] = get_post_meta($post->ID, 'keywords', true);

		// 仅对 单篇文章页( single ) 处理
		if( is_single() ){
			//获得分类名称 作为关键字
			$cats = get_the_category();
			if($cats){
				foreach( $cats as $cat ){
					$keywords[] = $cat->name;
				}
			}
			//获取Tags 将Tags 作为关键字
			$tags = get_the_tags();
			if($tags){
				foreach( $tags as $tag ){
					$keywords[] = $tag->name;
				}
			}
		}

		// 格式化处理 $keywords
		if(count($keywords) > 1){
			array_shift($keywords);
		}
		$keywords = array_filter($keywords);
		$keywords = join(',', $keywords);

		// 对 description 的处理
		if(!empty($post->post_password)){ // 受保护的文章
			$keywords = '';
			$description = '密码保护文章. 要阅读请输入密码.';
		}else{
			//获取自定义域内容
			 $description = mb_strimwidth(strip_tags($post->post_content),0,300);
			 if( empty($description) ){
				 $description = get_post_meta($post->ID, 'description', true);
			 }
			//自定义域为空 试试Excerpt
			if( empty($description) ){
				$description = get_the_excerpt();
			}

			//依然为空 则截取文章的前210个字符作为描述
			if( empty($description) ){
				$description = iSaymeStriptags($post->post_content);
				$description = iSaymeSubstr($description, 260);
			}
		}

	}elseif(is_category()){ // 分类页
		$keywords = single_cat_title('', false);
		$description = iSaymeStriptags(category_description());
	}elseif(is_author()){ // 作者页
		$meta_auth = get_userdata(get_query_var('author'));
		$keywords = $meta_auth->display_name;
		$description = str_replace(array('"'), '&quot;', $meta_auth->description);
		$description = iSaymeStriptags($description);
	}elseif(is_tag()){ // 标签页
		$keywords = single_cat_title('', false);
		$description = tag_description();
		$description = iSaymeStriptags($description);
	}elseif(is_month()){ // 月份存档页
		$description = single_month_title(' ', false);
	}

	if( !empty($keywords) ){
		echo '<meta name="keywords" content="',trim($keywords),'" />',"\n";
	}

	if( !empty($description) ){
		echo '<meta name="description" content="',trim($description),'" />',"\n";
	}

	$currentTheme = get_current_theme();

	if(!$themes = wp_cache_get('allThemes', 'iSayme')){
		$themes = get_themes();
		wp_cache_add('allThemes', $themes, 'iSayme');
	}

	$theme = $themes[$currentTheme]['Title'];
	$version = $themes[$currentTheme]['Version'];
	$themeAuthor = iSaymeStriptags($themes[$currentTheme]['Author']);

	unset($keywords,$description,$currentTheme,$themes,$theme,$version,$themeAuthor);
	//hook
 	do_action('after_keywords_desc');
}
add_action('wp_head', 'iSaymeKeywordsAndDescription',1);




if ( function_exists('register_sidebar') ){
    register_sidebar(array(
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3><span>',
        'after_title' => '</span></h3>',
        'name' =>'First'
    ));
    register_sidebar(array(
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3><span>',
        'after_title' => '</span></h3>',
        'name' =>'Second'
    ));
}

function iSaymeStriptags($str,$allow = ''){
	$str = preg_replace('/(\r\n)|(\n)/', '', $str); // 消灭换行符
	$str = strip_tags($str,$allow); //去掉html标签
	$str = preg_replace('/\[(.+?)\]/', '', $str); // 消灭'[]'这样的标签
	return $str;
}
/**
 * 截取字符
 *
 * @param string $str
 * @param int $length
 * @return string
 */
function iSaymeSubstr($str, $len = 100){
	if(!$str){
		return;
	}

	if( strlen( $str ) <= $len ){
		return $str;
	}else{
		$ellipsis = '...';
	}

	$new_str = array();
	for($i=0;$i<$len;$i++){
		$temp_str=substr($str,0,1);
		if(ord($temp_str) > 127){
			$i++;
			if($i<$len){
				$new_str[]=substr($str,0,3);
				$str=substr($str,3);
			}
		}else{
			$new_str[]=substr($str,0,1);
			$str=substr($str,1);
		}
	}
	$new_str = join($new_str);
	$new_str .=$ellipsis;

	return $new_str;
}

function cache_buster_code($stylesheet_uri){
    $pieces = explode('wp-content', $stylesheet_uri);
    $stylesheet_uri = $stylesheet_uri . '?v=' . filemtime(ABSPATH . '/wp-content' . $pieces[1]);
    return $stylesheet_uri;
}
add_filter('stylesheet_uri','cache_buster_code',9999,1);
/**
 * load js in footer
 * @return null
 */
function iSaymeLoadJS(){
	global $post;
	$blogurl = get_bloginfo('url').'/';
	$thepostID = ', postID=';
	$thepostID .= !is_home() ? $post->ID : 'null';
	//$jslang = philnaJSLanguage();
	$themeurl=get_bloginfo('template_directory');

	// javascript loader
	$jsFileURI = get_bloginfo('template_directory') . '/js.php';

	// add a version (timestamp)
	$jsFile = TEMPLATEPATH.'/js/all.js';
	if(file_exists($jsFile)){
		$jsFileURI .= '?v='.date('YmdHis', filemtime($jsFile));
	}

	$text = <<<EOF
<script type="text/javascript">
/* <![CDATA[ */
var iSayme = {},themeurl="$themeurl",blogURL = "$blogurl"{$thepostID};
/* ]]> */
</script>
<script src="{$jsFileURI}" type="text/javascript"></script>\n
EOF;
	echo $text;
}
add_action('wp_footer', 'iSaymeLoadJS', 100);

/**
 * when comment check the comment_author comment_author_email
 * @param unknown_type $comment_author
 * @param unknown_type $comment_author_email
 * @return unknown_type
 */
function iSaymeCheckEmailAndName(){
	global $wpdb;
	$comment_author       = ( isset($_POST['author']) )  ? trim(strip_tags($_POST['author'])) : null;
	$comment_author_email = ( isset($_POST['email']) )   ? trim($_POST['email']) : null;
	if(!$comment_author || !$comment_author_email){
		return;
	}

	$result_set = $wpdb->get_results("SELECT display_name, user_email FROM $wpdb->users WHERE display_name = '" . $comment_author . "' OR user_email = '" . $comment_author_email . "'");
	if ($result_set) {
		if ($result_set[0]->display_name == $comment_author){
			$errorMessage = '错误: 您不能以这个名字提交评论.如果您是管理员,请登录后再评论.';
		}else{
			$errorMessage = '错误: 您不能以这个邮箱地址提交评论.如果您是管理员,请登录后再评论.';
		}
		defined('DOING_AJAX') ? fail($errorMessage) : wp_die($errorMessage);
	}
}
add_action('pre_comment_on_post', 'iSaymeCheckEmailAndName');
