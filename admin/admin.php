<?php
require_once(dirname(__FILE__) .'/options.php');

class FakeBloggerAdmin {
	private $string_options = array();
	private $bool_options = array();
	private $int_options = array();
	private $options = array();
	private static $options_default = array();

	public static function get_options_default() {
		return self::$options_default;
	}

	public static function init() {
		self::$options_default = array(
			'excerpt_length'		=> 220,
		);
	}

	public function __construct(array $options) {
		if(!get_option(FAKEBLOGGER_OPTIONS))
			update_option(FAKEBLOGGER_OPTIONS, FakeBloggerOptions::getInstance()->merge_array(self::$options_default));
		$this->string_options = isset($options['string']) ? (array)$options['string'] : array();
		$this->bool_options = isset($options['bool']) ? (array)$options['bool'] : array();
		$this->int_options = isset($options['int']) ? (array)$options['int'] : array();
		add_action('admin_menu', array($this,'_admin'));
	}

	public function _admin() {
		$page = add_theme_page(__('FakeBlogger 选项'), __('FakeBlogger 选项'), 'administrator', 'FakeBloggerAdmin', array($this, '_admin_panel'));
		if ( function_exists('add_contextual_help') ) {
			$help = '<a href="http://isayme.com/" target="_blank">'.__('Check here for more information.').'</a>';
			add_contextual_help($page,$help);
		}
	}

	public function save($data) {
		foreach($data as $key=>$value) {
			if(in_array($key, $this->string_options)){
				$this->options[$key] = rtrim(preg_replace('/\n\s*\r/', '', $value));
				$this->options[$key] = str_replace('<!--', '', $this->options[$key]);
				$this->options[$key] = str_replace('-->', '', $this->options[$key]);
			} elseif(in_array($key, $this->bool_options)){
				$this->options[$key] = (bool)$value;
			} elseif(in_array($key, $this->int_options)){
				$this->options[$key] = (int)$value;
			}
		}
		update_option(FAKEBLOGGER_OPTIONS, $this->options);
	}

	public function restore() {
		update_option(FAKEBLOGGER_OPTIONS, self::$options_default);
	}

	public function _admin_panel() {
?>
<div class="wrap">
<?php screen_icon(); ?>
	<h2><?php _e('FakeBlogger 选项设置'); ?></h2>
<?php
$saved_options = &$GLOBALS['fakeblogger_options'];
if(isset($_POST['Submit'])) {
	$this->save($_POST);
?>
	<div id="message" class="updated fade">
		<p><strong>您的修改已经被保存。</strong></p>
	</div>
<?php
} else if(isset($_POST['Restore'])) {
	$this->restore();
?>
	<div id="message" class="updated fade">
		<p><strong>已恢复成默认设置。</strong></p>
	</div>
<?php
}
$saved_options->refresh();
?>
	<form action="" method="post" style="background-color: #f1f1f1;">
	<table class="form-table">
	<tbody>
		<tr valign="top" style="border-bottom: 2px solid #fff;">
			<th scope="row"><h5>Meta</h5><em>仅对首页有效</em></th>
			<td class="form-field">
				关键字
				<label for="keywords">( 每个关键字用逗号隔开)</label><br/>
				<input type="text" name="keywords" id="keywords" class="code" value="<?php echo($saved_options['keywords']); ?>"><br/><br/>
				描述
				<label for="description">( 您博客的主要描述 )</label><br/>
				<input type="text" name="description" id="description" class="code" value="<?php echo($saved_options['description']); ?>"><br/>
			</td>
		</tr>
		<tr valign="top" style="border-bottom: 2px solid #fff;">
			<th scope="row"><h5>首页文章截断长度</h5></th>
			<td class="form-field">
				<label for="excerpt_length">默认为220,请根据自己的需要进行调整(手动加More标签时无效,显示more标签之前的内容)</label><br/>
				<input type="text" name="excerpt_length" id="excerpt_length" class="code" value="<?php echo($saved_options['excerpt_length']); ?>"><br/><br/>
			</td>
		</tr>
		<tr valign="top" style="border-bottom: 2px solid #fff;">
			<th scope="row"><?php _e('<h5>Google统计代码</h5>',YHL); ?></th>
			<td><input id="enable_google_analytics" name="enable_google_analytics" type="checkbox" value="checkbox" <?php echo $saved_options['enable_google_analytics'] ? "checked='checked'" : '';?>/>
				<label for="enable_google_analytics"><?php _e('开启Google统计代码'); ?></label>
				<p>
					<textarea name="google_analytics_code" rows="6" cols="50" class="large-text"><?php echo $saved_options['google_analytics_code']; ?></textarea>
				</p>
				<input id="exclude_admin_analytics" name="exclude_admin_analytics" type="checkbox" value="checkbox" <?php echo $saved_options['exclude_admin_analytics'] ? "checked='checked'" : '';?>/>
				<label for="exclude_admin_analytics"><?php _e(' (管理员登录时不统计)', YHL); ?></label>
			</td>
		</tr>
		<tr valign="top" style="border-bottom: 2px solid #fff;">
			<th scope="row"><h5>版权信息设置</h5></th>
			<td>
				<label>
				<input name="rss_additional_show" type="checkbox" value="checkbox" <?php if($saved_options['rss_additional_show']) echo "checked='checked'"; ?> />
				添加自定义文字到 文章和RSS 输出中.比如版权信息等.
				</label>
				<br/>
				<label for="rss_copyright">
				在下面填写自定义信息(支持HTML代码).
				</label>
				<br/>
				<textarea name="rss_additional" cols="50" rows="5" style="width:98%;font-size:12px;"><?php echo $saved_options['rss_additional']; ?></textarea>
				<div class="info">
					<p>你可以在您的代码中使用下面这些占位符：</p>
					<ul>
						<li>%BLOG_LINK% - 博客地址</li>
						<li>%FEED_URL% - RSS订阅地址</li>
						<li>%POST_URL% - 文章固定链接</li>
						<li>%POST_TITLE% - 文章标题</li>
					</ul>
					<p>例如：本文链接地址：&lt;a href="%POST_URL%">%POST_TITLE%&lt;/a><br />
					欢迎&lt;a href="%FEED_URL%">订阅我们&lt;/a> 来阅读更多有趣的文章。</p>
					<p>输出结果将被包围在一个DIV元素中</p>
				</div>
			</td>
		</tr>
	</tbody>
	</table>
	<p class="submit">
		<input class="button-primary" type="submit" value="保存修改" name="Submit"/>
		<input class="button-primary" type="submit" value="恢复默认设置" name="Restore"/>
	</p>
	</form>
</div>
<?php
	}
}

FakeBloggerAdmin::init();

if(is_admin()){
	$fakeblogger_default_option_types = array(
		'string'	=> array(
			'keywords',
			'description',
			'google_analytics_code',
			'rss_additional'
			
		),
		'bool'		=> array(
			'enable_google_analytics',
			'exclude_admin_analytics',
			'rss_additional_show'
			
		),
		'int'		=> array(
			'excerpt_length',
			
		)
	);
	new FakeBloggerAdmin($fakeblogger_default_option_types);
}
?>
