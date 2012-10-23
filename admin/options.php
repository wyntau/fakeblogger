<?php
class FakeBloggerOptions implements ArrayAccess {

	private static $instance;
	
	/**
	 * 所有设置
	 *
	 * @var array
	 */
	private $options_array = array();
	
	/**
	 * 从数据库中取得设置
	 *
	 * @return null
	 */
	private function __construct() {
		if($o = get_option(FAKEBLOGGER_OPTIONS)) {
			$this->options_array = $o;
			unset($o);
		}
	}
	
	/**
	 * 重新取得设置
	 *
	 * @return null
	 */
	public function refresh() {
		$this->__construct();
	}
	
	/**
	 * 获取 PhilNaGetOpt 单一实例
	 *
	 * @return PhilNaGetOpt
	 */
	public static function getInstance() {
		if(self::$instance == null) {
			self::$instance = new FakeBloggerOptions();
		}
		return self::$instance;
	}
	
	/**
	 * 给定的偏移量是否存在?
	 *
	 * @return bool
	 */
	public function offsetExists($key) {
		return array_key_exists($key, $this->options_array);
	}
	
	/**
	 * 返回给定偏移量上的数据
	 *
	 * @return null|mix
	 */
	public function offsetGet($key) {
		if(array_key_exists($key, $this->options_array)) {
			if(is_string($this->options_array[$key])) {
				return stripslashes($this->options_array[$key]);
			} else {
				return $this->options_array[$key];
			}
		} else {
			return null;
		}
	}
	
	/**
	 * 设置给定偏移量上的数据
	 *
	 * @return bool|mix
	 */
	public function offsetSet($key, $val) {
		$this->options_array[$key] = $val;
	}
	
	/**
	 * 置空给定偏移量上的数据
	 *
	 * @return bool
	 */
	public function offsetUnset($key) {
		if(array_key_exists($key, $this->options_array)) {
			unset($this->options_array[$key]);
		}
	}

	public function merge_array($true_array, $override=true) {
		$result = $true_array;
		foreach($this->options_array as $key => $val) {
			if(!array_key_exists($key, $result) || $override)
				$result[$key] = $val;
		}
		return $result;
	}
	
	/*public function merge_array($true_array, $override=false) {
		foreach($true_array as $key => $val) {
			if(!array_key_exists($key, $this->options_array) || $override) {
				$this->options_array[$key] = $val;
			}
		}
		return $this->options_array;
	}
	*/
}
?>
