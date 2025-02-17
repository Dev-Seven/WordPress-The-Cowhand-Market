<?php
/******************************************************************************************
 * Copyright (C) Smackcoders. - All Rights Reserved under Smackcoders Proprietary License
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/
namespace Smackcoders\CFCSV;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

/**
 * Class Security
 * @package Smackcoders\CFCSV
 */
class Security {

	protected static $instance = null;

	public static function getInstance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
			self::$instance->doHooks();
		}
		return self::$instance;
	}

	/**
	 * Security constructor.
	 */
	public function __construct() {
		$this->plugin = Plugin::getInstance();
	}

	/**
	 *  Security hooks.
	 */
	public function doHooks(){
		add_action('wp_ajax_security_performance', array($this,'securityPerformance'));
	}

	public  function securityPerformance(){
		global $wpdb,$wp_version;
		$result['post_max_size'] = ini_get('post_max_size');
		$result['auto_append_file'] = ini_get('auto_append_file');
		$result['auto_prepend_file'] = ini_get('auto_prepend_file');
		$result['upload_max_filesize'] = ini_get('upload_max_filesize');
		$result['max_execution_time'] = ini_get('max_execution_time');
		$result['max_input_time'] = ini_get('max_input_time');
		$result['max_input_vars'] = ini_get('max_input_vars');
		$result['php_version'] = phpversion();
		$loader_extensions = get_loaded_extensions();
		if(in_array('PDO', $loader_extensions)) {
			$result['PDO'] = 'Yes';
		}
		else{
			$result['PDO'] = 'No';
		}
		if(in_array('curl', $loader_extensions)) {
			$result['curl'] = 'Yes';
		}
		else{
			$result['curl'] = 'No';
		}
		if(ini_get('file_uploads') == 1){
			$result['file_uploads'] = 'On';
		}
		else{
		     $result['file_uploads'] = 'Off';
		}
		if(ini_get('allow_url_fopen') == 1){
			$result['allow_url_fopen'] = 'On';
		}
		else{
			$result['allow_url_fopen'] = 'Off';
		}
		$result['wp_version'] = $wp_version;
		$result['db_version'] = $wpdb->db_version();
		$result['server_software'] = $_SERVER[ 'SERVER_SOFTWARE' ];
		$result['http_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$result['db_prefix'] = $wpdb->prefix;
		$result['wp_memory_limit'] = (int) ini_get('memory_limit');
		if(is_multisite()){
			$result['wp_multi_site'] = 'Eanbled';
		}
		else{
		$result['wp_multi_site'] = 'Disabled';
		}
		echo wp_json_encode($result);
		wp_die();

	}

}
