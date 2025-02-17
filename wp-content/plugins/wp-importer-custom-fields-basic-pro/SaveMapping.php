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

$import_extensions = glob( __DIR__ . '/importExtensions/*.php');

foreach ($import_extensions as $import_extension_value) {
	require_once($import_extension_value);
}

class SaveMapping{
	private static $instance=null,$validatefile;
	private static $smackcsv_instance = null;
	private static $core = null,$nextgen_instance;

	private function __construct(){
		add_action('wp_ajax_saveMappedFields',array($this,'check_templatename_exists'));
		add_action('wp_ajax_StartImport' , array($this,'background_starts_function'));
		add_action('wp_ajax_GetProgress',array($this,'import_detail_function'));
		add_action('wp_ajax_ImportState',array($this,'import_state_function'));
		add_action('wp_ajax_ImportStop',array($this,'import_stop_function'));
		add_action('wp_ajax_checkmain_mode',array($this,'checkmain_mode'));
		add_action('wp_ajax_disable_main_mode',array($this,'disable_main_mode'));
		add_action('wp_ajax_bulk_file_import',array($this,'bulk_file_import_function'));
		add_action('wp_ajax_bulk_import',array($this,'bulk_import'));
		add_action('wp_ajax_PauseImport',array($this,'pause_import'));
		add_action('wp_ajax_ResumeImport',array($this,'resume_import'));
	}

	public static function getInstance() {
		if (SaveMapping::$instance == null) {
			SaveMapping::$instance = new SaveMapping;
			SaveMapping::$validatefile = new ValidateFile;
			SaveMapping::$smackcsv_instance = SmackCSV::getInstance();
			SaveMapping::$nextgen_instance = new NextGenGalleryImport;
			return SaveMapping::$instance;
		}
		return SaveMapping::$instance;
	}

	public static function disable_main_mode(){
		$disable_option = $_POST['option'];
		delete_option($disable_option);
		$result['success'] = true;
		echo wp_json_encode($result);
		wp_die();
	}

	public static function checkmain_mode(){
		$ucisettings = get_option('sm_uci_pro_settings');
		if(isset($ucisettings['enable_main_mode']) && $ucisettings['enable_main_mode'] == 'true') {
			$result['success'] = true;
		}
		else{
			$result['success'] = false;
		}
		echo wp_json_encode($result);
		wp_die();
	}

	public function check_templatename_exists(){
		$use_template = $_POST['UseTemplateState'];
		$template_name = $_POST['TemplateName'];	
		$response = [];

		if($use_template === 'true'){	
			$response['success'] = $this->save_temp_fields();

		}else{
			global $wpdb;
			$template_table_name = "ultimate_cfimporter_pro_mappingtemplate";
			$get_template_names = $wpdb->get_results( "SELECT templatename FROM $template_table_name" );	
			if(!empty($get_template_names)){

				foreach($get_template_names as $temp_names){
					$inserted_temp_names[] = $temp_names->templatename;
				}
				if(in_array($template_name , $inserted_temp_names) && $template_name != ''){
					$response['success'] = false;
					$response['message'] = 'Template Name Already Exists';
				}else{
					$response['success'] = $this->save_fields_function();
				}

			}else{	
				$response['success'] = $this->save_fields_function();
			}
		}
		echo wp_json_encode($response); 	
		wp_die();

	}

	public function save_temp_fields(){

		$type          = $_POST['Types'];
		$map_fields    = $_POST['MappedFields'];	
		$template_name = $_POST['TemplateName'];
		$new_template_name = $_POST['NewTemplate'];
		$mapping_type = $_POST['MappingType'];
		$hash_key = $_POST['HashKey'];
		$response = [];

		global $wpdb;
		$template_table_name = "ultimate_cfimporter_pro_mappingtemplate";
		$get_detail = null;
		$get_detail   = $wpdb->get_results( "SELECT id FROM $template_table_name WHERE templatename = '$template_name' " );
		$get_id = $get_detail[0]->id;

		$mapped_fields = json_decode(stripslashes($map_fields),true);

		$mapping_fields = serialize( $mapped_fields );
		//added for saving serialized value with apostrophe
		$mapping_fields = $wpdb->_real_escape($mapping_fields);
		$time = date('Y-m-d h:i:s');

		if(!empty($new_template_name)){
			$wpdb->get_results("UPDATE $template_table_name SET templatename = '$new_template_name' , mapping ='$mapping_fields' , createdtime = '$time' , module = '$type' , eventKey = '$hash_key' , mapping_type = '$mapping_type' WHERE id = $get_id ");	
		}else{	
			//$wpdb->get_results("UPDATE $template_table_name SET eventKey = '$hash_key' , mapping_type = '$mapping_type' WHERE id = $get_id ");	
			//changed
			$wpdb->get_results("UPDATE $template_table_name SET mapping ='$mapping_fields', eventKey = '$hash_key', mapping_type = '$mapping_type' WHERE id = $get_id ");

		}

		return true;

	}

	public function save_fields_function() {
		global $wpdb;
		$hash_key      = $_POST['HashKey'];
		$type          = $_POST['Types'];
		$map_fields    = $_POST['MappedFields'];	
		$template_name = $_POST['TemplateName'];
		$mapping_type = $_POST['MappingType'];
		$template_table_name = "ultimate_cfimporter_pro_mappingtemplate";
		$file_table_name = $wpdb->prefix . "smackcf_file_events";
		$mapped_fields = json_decode(stripslashes($map_fields),true);
		$mapping_fields = serialize( $mapped_fields );
		$time = date('Y-m-d h:i:s');
		$get_detail   = $wpdb->get_results( "SELECT file_name FROM $file_table_name WHERE `hash_key` = '$hash_key'" );
		$get_file_name = $get_detail[0]->file_name;
		$get_hash = $wpdb->get_results( "SELECT eventKey FROM $template_table_name" );

		if(!empty($get_hash)){
			foreach($get_hash as $hash_values){
				$inserted_hash_values[] = $hash_values->eventKey;
			}
			if(in_array($hash_key , $inserted_hash_values)){
				$wpdb->get_results("UPDATE $template_table_name SET templatename = '$template_name' , mapping ='$mapping_fields' , createdtime = '$time' , module = '$type' , mapping_type = '$mapping_type' WHERE eventKey = '$hash_key'");	
			}
			else{
				$wpdb->get_results( "INSERT INTO $template_table_name(templatename ,mapping ,createdtime ,module,csvname ,eventKey , mapping_type)values('$template_name','$mapping_fields' , '$time' , '$type' , '$get_file_name', '$hash_key', '$mapping_type')" );	
			}
		}else{
			$wpdb->get_results( "INSERT INTO $template_table_name(templatename ,mapping ,createdtime ,module,csvname ,eventKey , mapping_type)values('$template_name','$mapping_fields' , '$time' , '$type' , '$get_file_name', '$hash_key' , '$mapping_type' )" );

		}
		return true;
	}

	public function import_detail_function(){
		$hash_key = $_POST['HashKey'];
		$response = [];

		global $wpdb;
		$log_table_name = $wpdb->prefix . "cfimport_detail_log";
		$file_table_name = $wpdb->prefix ."smackcf_file_events";

		$file_records = $wpdb->get_results("SELECT mode FROM $file_table_name WHERE hash_key = '$hash_key' ",ARRAY_A);
		$mode = $file_records[0]['mode'];

		if($mode == 'Insert'){
			$method = 'Import';
		}
		if($mode == 'Update'){
			$method = 'Update';
		}
		

		$total_records = $wpdb->get_results("SELECT file_name , total_records , processing_records ,status ,remaining_records , filesize FROM $log_table_name WHERE hash_key = '$hash_key' ",ARRAY_A);

		$response['success'] = true;
		$response['file_name']= $total_records[0]['file_name'];
		$response['total_records']= $total_records[0]['total_records'];
		$response['processing_records']= $total_records[0]['processing_records'];
		$response['remaining_records']= $total_records[0]['remaining_records'];
		$response['status']= $total_records[0]['status'];
		$response['filesize'] = $total_records[0]['filesize'];
		$response['method'] = $method;

		if($total_records[0]['status'] == 'Completed'){
			$response['progress'] = false;
		}else{
			$response['progress'] = true;
		}
		$response['Info'] = [];

		echo wp_json_encode($response); 
		wp_die();
	}

	public function import_state_function(){
		$response = [];
		$hash_key = $_POST['HashKey'];
		$upload = wp_upload_dir();
		$upload_base_url = $upload['baseurl'];
		$upload_url = $upload_base_url . '/smack_uci_uploads/imports/';
		$upload_dir = SaveMapping::$smackcsv_instance->create_upload_dir();
		$log_path = $upload_dir.$hash_key.'/'.$hash_key.'.html';
		if(file_exists($log_path)){
			$log_link_path = $upload_url. $hash_key .'/'.$hash_key.'.html';
		}

		$import_txt_path = $upload_dir.'import_state.txt';
		chmod($import_txt_path , 0777);
		$import_state_arr = array();

		if($_POST['State'] == 'true'){
			//first check then set on
			$open_file = fopen( $import_txt_path , "w");
			$import_state_arr = array('import_state' => 'on','import_stop' => 'on');
			$state_arr = serialize($import_state_arr);
			fwrite($open_file , $state_arr);
			fclose($open_file);

			$response['import_state'] = false;	
		}
		if($_POST['State'] == 'false'){
			//first check then set off	
			$open_file = fopen( $import_txt_path , "w");
			$import_state_arr = array('import_state' => 'off','import_stop' => 'on');
			$state_arr = serialize($import_state_arr);
			fwrite($open_file , $state_arr);
			fclose($open_file);

			if ($log_link_path != null){
				$response['show_log'] = true;	
			}
			else{
				$response['show_log'] = false;
			}

			$response['import_state'] = true;
			$response['log_link'] = $log_link_path;			
		}	
		echo wp_json_encode($response);
		wp_die();
	}

	public function import_stop_function(){
		$upload_dir = SaveMapping::$smackcsv_instance->create_upload_dir();
		/* Gets string 'false' when page is refreshed */

		if($_POST['Stop'] == 'false'){
			$import_txt_path = $upload_dir.'import_state.txt';
			chmod($import_txt_path , 0777);
			$import_state_arr = array();

			$open_file = fopen( $import_txt_path , "w");
			$import_state_arr = array('import_state' => 'on','import_stop' => 'off');
			$state_arr = serialize($import_state_arr);
			fwrite($open_file , $state_arr);
			fclose($open_file);
		}
		wp_die();
	}

	public function parse_element($xml,$query){
		$query = strip_tags($query);
		$xpath = new \DOMXPath($xml);
		$entries = $xpath->query($query);
		$content = $entries->item(0)->textContent;
		return $content;
	}
	
	public function background_starts_function(){

		global $wpdb;
		$hash_key  = $_POST['HashKey'];
		$check = $_POST['Check'];
		$rollback_option = $_POST['RollBack'];
		$unmatched_row_value = get_option('sm_uci_pro_settings');
		$unmatched_row = $unmatched_row_value['unmatchedrow'];
		//first check then set true	
		$upload_dir = SaveMapping::$smackcsv_instance->create_upload_dir();
		$import_txt_path = $upload_dir.'import_state.txt';
		chmod($import_txt_path , 0777);
		$import_state_arr = array();

		$open_file = fopen( $import_txt_path , "w");
		$import_state_arr = array('import_state' => 'on','import_stop' => 'on');
		$state_arr = serialize($import_state_arr);
		fwrite($open_file , $state_arr);
		fclose($open_file);

		$helpers_instance = ImportHelpers::getInstance();
		$core_instance = CoreFieldsImport::getInstance();
		$import_config_instance = ImportConfiguration::getInstance();
		$file_manager_instance = FileManager::getInstance();
		$log_manager_instance = LogManager::getInstance();
		global $core_instance;

		$file_table_name = $wpdb->prefix ."smackcf_file_events";
		$template_table_name = "ultimate_cfimporter_pro_mappingtemplate";
		$log_table_name = $wpdb->prefix ."cfimport_detail_log";
		$response = [];

		$background_values = $wpdb->get_results("SELECT mapping , module  FROM $template_table_name WHERE `eventKey` = '$hash_key' ");
		foreach($background_values as $values){
			$mapped_fields_values = $values->mapping;	
			$selected_type = $values->module;
		}

		if($rollback_option === 'true'){
			$tables = $import_config_instance->get_rollback_tables($selected_type);
			$import_config_instance->set_backup_restore($hash_key, 'backup', $tables);	
		}

		$get_id = $wpdb->get_results( "SELECT id , mode ,file_name , total_rows FROM $file_table_name WHERE `hash_key` = '$hash_key'");

		$get_mode = $get_id[0]->mode;
		$total_rows = $get_id[0]->total_rows;
		$file_name = $get_id[0]->file_name;
		$file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
		if(empty($file_extension)){
			$file_extension = 'xml';
		}
		$file_size = filesize($upload_dir.$hash_key.'/'.$hash_key);
		$filesize = $helpers_instance->formatSizeUnits($file_size);

		$remain_records = $total_rows - 1;
		$wpdb->insert( $log_table_name , array('file_name' => $file_name , 'hash_key' => $hash_key , 'total_records' => $total_rows , 'filesize' => $filesize , 'processing_records' => 1 , 'remaining_records' => $remain_records, 'status' => 'Processing' ) );

		$map = unserialize($mapped_fields_values);
		$gmode = 'Normal';
		if($file_extension == 'csv' || $file_extension == 'txt'){

			ini_set("auto_detect_line_endings", true	);
			$info = [];
			if (($h = fopen($upload_dir.$hash_key.'/'.$hash_key, "r")) !== FALSE) 
			{
				// Convert each line into the local $data variable
				$line_number = 0;
				$header_array = [];
				$value_array = [];
				$addHeader = true;
				$delimiters = array( ',','\t',';','|',':','&nbsp');
				$file_path = $upload_dir . $hash_key . '/' . $hash_key;
				$delimiter = SaveMapping::$validatefile->getFileDelimiter($file_path, 5);
				$array_index = array_search($delimiter,$delimiters);
				if($array_index == 5){
					$delimiters[$array_index] = ' ';
				}
				while(($data = fgetcsv($h, 0, $delimiters[$array_index]))!== FALSE) 
				{		
					// Read the data from a single line
					$trimmed_array = array_map('trim', $data);
					array_push($info , $trimmed_array);
					if($line_number == 0){
						$header_array = $info[$line_number];

					}else{
						$value_array = $info[$line_number];
						$get_arr = $this->main_import_process($map , $header_array ,$value_array , $selected_type , $get_mode, $line_number , $unmatched_row, $check , $hash_key, '', $gmode);
						$post_id = $get_arr['id'];	
						$core_instance->detailed_log = $get_arr['detail_log'];
						$helpers_instance->get_post_ids($post_id ,$hash_key);
						$remaining_records = $total_rows - $line_number;
						$wpdb->get_results("UPDATE $log_table_name SET processing_records = $line_number , remaining_records = $remaining_records , status = 'Processing' WHERE hash_key = '$hash_key'");

						if($line_number == $total_rows){
							$wpdb->get_results("UPDATE $log_table_name SET status = 'Completed' WHERE hash_key = '$hash_key'");
						}

						if (count($core_instance->detailed_log) > 5) {
							$log_manager_instance->get_event_log($hash_key , $file_name , $file_extension, $get_mode , $total_rows , $selected_type , $core_instance->detailed_log, $addHeader);
							$addHeader = false;
							$core_instance->detailed_log = [];
						}

					}

					// get the pause or resume state
					$open_txt = fopen($import_txt_path , "r");
					$read_text_ser = fread($open_txt , filesize($import_txt_path));  
					$read_state = unserialize($read_text_ser);    
					fclose($open_txt);

					if($read_state['import_stop'] == 'off'){
						return;
					}

					while($read_state['import_state'] == 'off'){	
						$open_txts = fopen($import_txt_path , "r");
						$read_text_sers = fread($open_txts , filesize($import_txt_path));  
						$read_states = unserialize($read_text_sers);    
						fclose($open_txts);

						if($read_states['import_state'] == 'on'){
							break;
						}

						if($read_states['import_stop'] == 'off'){
							return;
						}
					}
					$line_number++;			
				}
				fclose($h);
			}
		}
		if($file_extension == 'xml'){
			$path = $upload_dir . $hash_key . '/' . $hash_key;
			$line_number = 0;
			$header_array = [];
			$value_array = [];
			$addHeader = true;
			
			for ($line_number = 0; $line_number < $total_rows; $line_number++) {
				$xml_class = new XmlHandler();
				$parse_xml = $xml_class->parse_xmls($hash_key,$line_number);
				$i = 0;
				foreach($parse_xml as $xml_key => $xml_value){
					if(is_array($xml_value)){
						foreach ($xml_value as $e_key => $e_value){
							$header_array['header'][$i] = $e_value['name'];
							$value_array['value'][$i] = $e_value['value'];
							$i++;
						}
					}
				}
				$xml = simplexml_load_file($path);
				foreach($xml->children() as $child){   
					$tag = $child->getName();     
				}
				$total_xml_count = $this->get_xml_count($path , $tag);
				if($total_xml_count == 0){
					$sub_child = $this->get_child($child,$path);
					$tag = $sub_child['child_name'];
					$total_xml_count = $sub_child['total_count'];
				}

				$doc = new \DOMDocument();
				$doc->load($path);
				foreach ($map as $field => $value) {
					foreach ($value as $head => $val) {
						if (preg_match('/{/',$val) && preg_match('/}/',$val)){
							preg_match_all('/{(.*?)}/', $val, $matches);
							$line_numbers = $line_number+1;	
							$val = preg_replace("{"."(".$tag."[+[0-9]+])"."}", $tag."[".$line_numbers."]", $val);
							for($i = 0 ; $i < count($matches[1]) ; $i++){		
								$matches[1][$i] = preg_replace("(".$tag."[+[0-9]+])", $tag."[".$line_numbers."]", $matches[1][$i]);
								$value = $this->parse_element($doc, $matches[1][$i], $line_number);	
								$search = '{'.$matches[1][$i].'}';
								$val = str_replace($search, $value, $val);
							}
							$mapping[$field][$head] = $val;	
						} 
						else{
							$mapping[$field][$head] = $val;
						}
					}
				}
				$get_arr = $this->main_import_process($mapping, $header_array['header'], $value_array['value'], $selected_type, $get_mode, $line_number, $unmatched_row, $check, $hash_key, '', $gmode);
				$post_id = $get_arr['id'];
				$core_instance->detailed_log = $get_arr['detail_log'];
				$helpers_instance->get_post_ids($post_id, $hash_key);
				$line_numbers = $line_number + 1;
				$remaining_records = $total_rows - $line_numbers;
				$wpdb->get_results("UPDATE $log_table_name SET processing_records = $line_number + 1 , remaining_records = $remaining_records, status = 'Processing' WHERE hash_key = '$hash_key'");

				if ($line_number == $total_rows - 1) {
					$wpdb->get_results("UPDATE $log_table_name SET status = 'Completed' WHERE hash_key = '$hash_key'");
				}

				if (count($core_instance->detailed_log) > 5) {
					$log_manager_instance->get_event_log($hash_key, $file_name, $file_extension, $get_mode, $total_rows, $selected_type, $core_instance->detailed_log, $line_number);
					$addHeader = false;
					$core_instance->detailed_log = [];
				}

				$open_txt = fopen($import_txt_path, "r");
				$read_text_ser = fread($open_txt, filesize($import_txt_path));
				$read_state = unserialize($read_text_ser);
				fclose($open_txt);

				if ($read_state['import_stop'] == 'off') {
					return;
				}

				while ($read_state['import_state'] == 'off') {
					$open_txts = fopen($import_txt_path, "r");
					$read_text_sers = fread($open_txts, filesize($import_txt_path));
					$read_states = unserialize($read_text_sers);
					fclose($open_txts);

					if ($read_states['import_state'] == 'on') {
						break;
					}

					if ($read_states['import_stop'] == 'off') {
						return;
					}
				}
			}
		}

		if (count($core_instance->detailed_log) > 0) {
			$log_manager_instance->get_event_log($hash_key , $file_name , $file_extension, $get_mode , $total_rows , $selected_type , $core_instance->detailed_log, $addHeader);
		}

		$file_manager_instance->manage_records($hash_key ,$selected_type , $file_name , $total_rows);
		if (is_array($value_array)){
			foreach ($value_array as $key => $value) {
				if(preg_match("/<img/", $value)){
					SaveMapping::$smackcsv_instance->image_schedule();
					$image = $wpdb->get_results("select * from {$wpdb->prefix}ultimate_cf_importer_shortcode_manager where hash_key = '{$hash_key}' ");
					if(!empty($image)){
						SaveMapping::$smackcsv_instance->delete_image_schedule();
					}
				}
			}
		}
		$upload = wp_upload_dir();
		$upload_base_url = $upload['baseurl'];
		$upload_url = $upload_base_url . '/smack_uci_uploads/imports/';
		$log_link_path = $upload_url. $hash_key .'/'.$hash_key.'.html';
		$response['success'] = true;
		$response['log_link'] = $log_link_path;
		if($rollback_option === 'true'){
			$response['rollback'] = true;
		}
		unlink($import_txt_path);
		echo wp_json_encode($response);
		wp_die();
	}

	public	function bulk_file_import_function()
	{
		global $wpdb;
		$helpers_instance = ImportHelpers::getInstance();
		$hash_key = $_POST['HashKey'];
		$highspeed=$_POST['highspeed'];
		$piecebypiece=$_POST['PieceByPiece'];
		$fileiteration=$_POST['FileIteration'];
		$splitchunks=$_POST['SplitChunks'];
		if($highspeed=='true'){
			$fileiteration='30';
			update_option('sm_bulk_import_iteration_limit', $fileiteration);
		}
		if($piecebypiece=='true'){
			$fileiteration=$_POST['FileIteration'];
			update_option('sm_bulk_import_iteration_limit', $fileiteration);

		}
		$file_table_name = $wpdb->prefix ."smackcf_file_events";
		$get_id = $wpdb->get_results( "SELECT id , mode ,file_name , total_rows FROM $file_table_name WHERE `hash_key` = '$hash_key'");
		$total_rows = $get_id[0]->total_rows;
		$file_name = $get_id[0]->file_name;
		$file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
		$upload_dir = SaveMapping::$smackcsv_instance->create_upload_dir();
		$file_size = filesize($upload_dir.$hash_key.'/'.$hash_key);
		$filesize = $helpers_instance->formatSizeUnits($file_size);
		$response['total_rows'] = $total_rows;
		$response['file_extension'] = $file_extension;
		$response['file_name']= $file_name;
		$response['filesize'] = $filesize;
		//$response['file_iteration'] = (int)$fileiteration;
		$response['file_iteration']=5;
		echo wp_json_encode($response);
		wp_die();
	}

	public function bulk_import(){
	
		global $wpdb,$core_instance;
		$upload_dir = SaveMapping::$smackcsv_instance->create_upload_dir();
		$hash_key  = $_POST['HashKey'];
		$check = $_POST['Check'];
		$page_number = $_POST['PageNumber'];
		$rollback_option = $_POST['RollBack'];
		$unmatched_row_value = get_option('sm_uci_pro_settings');
		$unmatched_row = $unmatched_row_value['unmatchedrow'];
		$update_based_on = $_POST['UpdateUsing'];
		$helpers_instance = ImportHelpers::getInstance();
		$core_instance = CoreFieldsImport::getInstance();
		$import_config_instance = ImportConfiguration::getInstance();
		$file_manager_instance = FileManager::getInstance();
		$log_manager_instance = LogManager::getInstance();
		$file_table_name = $wpdb->prefix ."smackcf_file_events";
		$template_table_name = "ultimate_cfimporter_pro_mappingtemplate";
		$log_table_name = $wpdb->prefix ."cfimport_detail_log";
		$response = [];	
		$mapped_fields_values = '';
		$selected_type = '';
		$get_id = $wpdb->get_results( "SELECT id , mode ,file_name , total_rows FROM $file_table_name WHERE `hash_key` = '$hash_key'");
		$get_mode = $get_id[0]->mode;
		$total_rows = $get_id[0]->total_rows;
		$file_iteration = 5;
		$total_pages = ceil($total_rows/$file_iteration);
		$file_name = $get_id[0]->file_name;
		$file_extension = pathinfo($file_name, PATHINFO_EXTENSION);
		if(empty($file_extension)){
			$file_extension = 'xml';
		}
		$gmode = 'Normal';
		$upload_dir = SaveMapping::$smackcsv_instance->create_upload_dir();
		$file_size = filesize($upload_dir.$hash_key.'/'.$hash_key);
		$filesize = $helpers_instance->formatSizeUnits($file_size);
		update_option('sm_bulk_import_page_number', $page_number);
		$remain_records = $total_rows - 1;
		$wpdb->insert( $log_table_name , array('file_name' => $file_name , 'hash_key' => $hash_key , 'total_records' => $total_rows , 'filesize' => $filesize , 'processing_records' => 1 , 'remaining_records' => $remain_records , 'status' => 'Processing' ) );		
		$background_values = $wpdb->get_results("SELECT mapping , module  FROM $template_table_name WHERE `eventKey` = '$hash_key' ");	
		foreach($background_values as $values){
			$mapped_fields_values = $values->mapping;	
			$selected_type = $values->module;
		}
		$map = unserialize($mapped_fields_values);
		if($rollback_option == 'true'){
			$tables = $import_config_instance->get_rollback_tables($selected_type);
			$import_config_instance->set_backup_restore($hash_key, 'backup', $tables);	
		}
		if($file_extension == 'csv' || $file_extension == 'txt'){
			ini_set("auto_detect_line_endings", true);
			if (($h = fopen($upload_dir.$hash_key.'/'.$hash_key, "r")) !== FALSE) 
			{
				$delimiters = array( ',','\t',';','|',':','&nbsp');
				$file_path = $upload_dir . $hash_key . '/' . $hash_key;
				$delimiter = SaveMapping::$validatefile->getFileDelimiter($file_path, 5);
				$array_index = array_search($delimiter,$delimiters);
				//$file_iteration = get_option('sm_bulk_import_iteration_limit');
				$file_iteration = 5;
				if($array_index == 5){
					$delimiters[$array_index] = ' ';
				}
				// $line_number = ((50 * $page_number) - 50) + 1;
				// $limit = (50 * $page_number);
				$line_number = (($file_iteration * $page_number) - $file_iteration) + 1;
				$limit = ($file_iteration * $page_number);
				if($page_number == 1){
					$addHeader = true;
				}
				$info = [];
				$i = 0;
				while(($data = fgetcsv($h, 0, $delimiters[$array_index]))!== FALSE) {
					$trimmed_array = array_map('trim', $data);
					array_push($info , $trimmed_array);

					if ($i == 0) {
						$header_array = $info[$i];
						$i++;
						continue;
					}

					if ($i >= $line_number && $i <= $limit) {
						$value_array = $info[$i];
						$get_arr = $this->main_import_process($map , $header_array ,$value_array , $selected_type , $get_mode, $i , $unmatched_row, $check , $hash_key, $update_based_on, $gmode);
						$post_id = $get_arr['id'];	
						$core_instance->detailed_log = $get_arr['detail_log'];

						$helpers_instance->get_post_ids($post_id ,$hash_key);

						$remaining_records = $total_rows - $i;
						$wpdb->get_results("UPDATE $log_table_name SET processing_records = $i , remaining_records = $remaining_records , status = 'Processing' WHERE hash_key = '$hash_key'");

						if($i == $total_rows){
							$wpdb->get_results("UPDATE $log_table_name SET status = 'Completed' WHERE hash_key = '$hash_key'");
						}

						if (isset($core_instance->detailed_log) && count($core_instance->detailed_log) > 5) {
							$log_manager_instance->get_event_log($hash_key , $file_name , $file_extension, $get_mode , $total_rows , $selected_type , $core_instance->detailed_log, $addHeader);
							$addHeader = false;
							$core_instance->detailed_log = [];
						}
					}

					if ($i > $limit) {
						break;
					}

					$i++;
				}
				$running = $wpdb->get_row("SELECT running FROM $log_table_name WHERE hash_key = '$hash_key' ");
				$check_pause = $running->running;
					if($check_pause == 0){

					$response['success'] = false;
					$response['pause_message'] = 'Record Paused';
					echo wp_json_encode($response);
					wp_die();
				}
				fclose($h);
			}
		}

		if ($file_extension == 'xml') {
			$path = $upload_dir . $hash_key . '/' . $hash_key;
			$lined_number = ((3 * $page_number) - 3);
			$limit = (3 * $page_number) - 1;
			$header_array = [];
			$value_array = [];
			$i = 0;
			$info = [];
			$addHeader = true;
	
			for ($line_number = 0; $line_number < $total_rows; $line_number++) {
				if ( $i >= $lined_number && $i <= $limit) {
					$xml_class = new XmlHandler();
					$parse_xml = $xml_class->parse_xmls($hash_key,$i);
					$j = 0;
					foreach($parse_xml as $xml_key => $xml_value){
						if(is_array($xml_value)){
							foreach ($xml_value as $e_key => $e_value){
								$header_array['header'][$j] = $e_value['name'];
								$value_array['value'][$j] = $e_value['value'];
								$j++;
							}
						}
					}
					$xml = simplexml_load_file($path);
					foreach($xml->children() as $child){   
						$tag = $child->getName();     
					}
					$total_xml_count = $this->get_xml_count($path , $tag);
					if($total_xml_count == 0){
						$sub_child = $this->get_child($child,$path);
						$tag = $sub_child['child_name'];
						$total_xml_count = $sub_child['total_count'];
					}
					$doc = new \DOMDocument();
					$doc->load($path);
					foreach ($map as $field => $value) {
						foreach ($value as $head => $val) {
							if (preg_match('/{/',$val) && preg_match('/}/',$val)){
								preg_match_all('/{(.*?)}/', $val, $matches);
								$line_numbers = $i+1;	
								$val = preg_replace("{"."(".$tag."[+[0-9]+])"."}", $tag."[".$line_numbers."]", $val);
								for($k = 0 ; $k < count($matches[1]) ; $k++){		
									$matches[1][$k] = preg_replace("(".$tag."[+[0-9]+])", $tag."[".$line_numbers."]", $matches[1][$k]);
									$value = $this->parse_element($doc, $matches[1][$k], $i);	
									$search = '{'.$matches[1][$k].'}';
									$val = str_replace($search, $value, $val);
								}
								$mapping[$field][$head] = $val;	
							} 
							else{
								$mapping[$field][$head] = $val;
							}
						}
					}

					array_push($info, $value_array['value']);
					$get_arr = $this->main_import_process($mapping, $header_array['header'], $value_array['value'], $selected_type, $get_mode, $i, $unmatched_row, $check, $hash_key, $update_based_on, $gmode);
					$post_id = $get_arr['id'];
					$core_instance->detailed_log = $get_arr['detail_log'];

					$helpers_instance->get_post_ids($post_id, $hash_key);
					$line_numbers = $i + 1;
					$remaining_records = $total_rows - $line_numbers;
					$wpdb->get_results("UPDATE $log_table_name SET processing_records = $i + 1 , remaining_records = $remaining_records, status = 'Processing' WHERE hash_key = '$hash_key'");

					if ($i == $total_rows - 1) {
						$wpdb->get_results("UPDATE $log_table_name SET status = 'Completed' WHERE hash_key = '$hash_key'");
					}

					if (count($core_instance->detailed_log) > 5) {
						$log_manager_instance->get_event_log($hash_key, $file_name, $file_extension, $get_mode, $total_rows, $selected_type, $core_instance->detailed_log, $i);
						$addHeader = false;
						$core_instance->detailed_log = [];
					}
				}
				if ($i > $limit) {
					break;
				}
				$i++;
			}
			$running = $wpdb->get_row("SELECT running FROM $log_table_name WHERE hash_key = '$hash_key' ");
			$check_pause = $running->running;
			if ($check_pause == 0) {
				$response['success'] = false;
				$response['pause_message'] = 'Record Paused';
				echo wp_json_encode($response);
				wp_die();
			}
		}

		if (($unmatched_row == 'true') && ($page_number >= $total_pages)){
			$post_entries_table = $wpdb->prefix ."post_entries";
			$post_entries_value = $wpdb->get_results("select ID from {$wpdb->prefix}post_entries_table " ,ARRAY_A);
		
			foreach($post_entries_value as $product_id){
				$test [] = $product_id['ID'];
			}

		    $unmatched_object = new ExtensionHandler;
			$import_type = $unmatched_object->import_type_as($selected_type);
			$import_type_value = $unmatched_object->import_post_types($import_type);
			$import_name_as = $unmatched_object->import_name_as($import_type);
			if($import_type_value == 'category' || $import_type_value == 'post_tag' || $import_type_value == 'product_cat' || $import_type_value == 'product_tag'){
				
				$get_total_row_count =  $wpdb->get_col("SELECT term_id FROM {$wpdb->prefix}term_taxonomy WHERE taxonomy = '$import_type_value'");
				$unmatched_id=array_diff($get_total_row_count,$test);

				foreach($unmatched_id as $keys => $values){
					$wpdb->get_results("DELETE FROM {$wpdb->prefix}terms WHERE `term_id` = '$values' ");
				}
			}
			if($import_type_value == 'post' || $import_type_value == 'product' || $import_type_value == 'page'  || $import_name_as == 'CustomPosts'){
				
				$get_total_row_count =  $wpdb->get_col("SELECT DISTINCT ID FROM {$wpdb->prefix}posts WHERE post_type = '{$import_type_value}' AND post_status != 'trash' ");
				$unmatched_id=array_diff($get_total_row_count,$test);
			
				foreach($unmatched_id as $keys => $values){
					$wpdb->get_results("DELETE FROM {$wpdb->prefix}posts WHERE `ID` = '$values' ");
				}
			}
			$wpdb->get_results("DELETE FROM {$wpdb->prefix}post_entries_table");
			
		}

		if (isset($core_instance->detailed_log) && count($core_instance->detailed_log) > 0) {
			$log_manager_instance->get_event_log($hash_key , $file_name , $file_extension, $get_mode , $total_rows , $selected_type , $core_instance->detailed_log, $addHeader);
		}
		$file_manager_instance->manage_records($hash_key ,$selected_type , $file_name , $total_rows);			
		$count = count($info);
		
		for ($i = 1; $i <= $count; $i++) {
			if ((is_array($info)) && (isset($info[$i]))){
				foreach ($info[$i] as $key => $value) {
					if(preg_match("/<img/", $value)) {
						SaveMapping::$smackcsv_instance->image_schedule();

						$image = $wpdb->get_results("select * from {$wpdb->prefix}ultimate_cf_importer_shortcode_manager where hash_key = '{$hash_key}'");
						if(!empty($image)){
							SaveMapping::$smackcsv_instance->delete_image_schedule();
						}
					}
				}
			}
		}
		$upload = wp_upload_dir();
		$upload_base_url = $upload['baseurl'];
		$upload_url = $upload_base_url . '/smack_uci_uploads/imports/';
		$log_link_path = $upload_url. $hash_key .'/'.$hash_key.'.html';
		$response['success'] = true;
		$response['log_link'] = $log_link_path;
		if($rollback_option == 'true'){
			$response['rollback'] = true;
		}	
		echo wp_json_encode($response);
		wp_die();
	}

	public function pause_import(){
		global $wpdb;
		$response = [];
		$hash_key = $_POST['HashKey'];
		$log_table_name = $wpdb->prefix ."cfimport_detail_log";
		$wpdb->get_results("UPDATE $log_table_name SET running = 0  WHERE hash_key = '$hash_key'");					
		$response['pause_state'] = true;	
		echo wp_json_encode($response);
		wp_die();
	}

	public function resume_import(){
		global $wpdb;
		$response = [];
		$hash_key = $_POST['HashKey'];
		$log_table_name = $wpdb->prefix ."cfimport_detail_log";
		$wpdb->get_results("UPDATE $log_table_name SET running = 1  WHERE hash_key = '$hash_key'");					
		$response['resume_state'] = true;	
		$response['page_number'] = get_option('sm_bulk_import_page_number');
		echo wp_json_encode($response);
		wp_die();
	}

	public function get_xml_count($eventFile , $child_name){
		$doc = new \DOMDocument();
		$doc->load($eventFile);
		$nodes=$doc->getElementsByTagName($child_name);
		$total_row_count = $nodes->length;
		return $total_row_count;	
	}

	public function get_child($child,$path){
		foreach($child->children() as $sub_child){
			$sub_child_name = $sub_child->getName();
		}
		$total_xml_count = $this->get_xml_count($path , $sub_child_name);
		if($total_xml_count == 0){
			$this->get_child($sub_child,$path);
		}
		else{
			$result['child_name'] = $sub_child_name;
			$result['total_count'] = $total_xml_count;
			return $result;
		}
	}

	public function main_import_process($map , $header_arrays ,$value_array , $selected_type , $get_mode, $line_number , $unmatched_row, $check , $hash_key, $update_based_on, $gmode){

		$header_array = [];
		foreach($header_arrays as $header_values){
			$header_array[] = rtrim($header_values, " ");
		}

		global $core_instance;
		$return_arr = [];
		$post_id = isset($post_id) ? $post_id :'';
		$core_instance = CoreFieldsImport::getInstance();
		foreach($map as $group_name => $group_value){
			if($group_name == 'CORE'){
				$acf_map = isset($map['ACF']) ? $map['ACF'] : '';
				$types_map = isset($map['TYPES']) ? $map['TYPES'] : '';
				$pods_map = isset($map['PODS']) ? $map['PODS'] : '';
				
				$core_instance = CoreFieldsImport::getInstance();
				$post_id = $core_instance->set_core_values($header_array ,$value_array , $map['CORE'] , $selected_type , $get_mode, $line_number , $unmatched_row, $check , $hash_key, $acf_map, $pods_map ,$types_map, $update_based_on, $gmode);		
			}
		}
        if(!empty($post_id)){
			foreach($map as $group_name => $group_value){
				switch($group_name){
	
				case 'ACF':	
					$acf_image = isset($map['ACFIMAGEMETA']) ? $map['ACFIMAGEMETA'] : '';
					$acf_pro_instance = ACFProImport::getInstance();
					$acf_pro_instance->set_acf_pro_values( $header_array, $value_array, $map['ACF'],$acf_image , $post_id, $selected_type ,$get_mode);
					break;
	
				case 'RF':
					$acf_image = isset($map['ACFIMAGEMETA']) ? $map['ACFIMAGEMETA'] : '';
					$acf_pro_instance = ACFProImport::getInstance();
					$acf_pro_instance->set_acf_rf_values( $header_array, $value_array, $map['RF'],$acf_image , $post_id, $selected_type,$get_mode );
					break;
	
				case 'FC':
					$acf_pro_instance = ACFProImport::getInstance();
					$acf_pro_instance->set_acf_fc_values($header_array, $value_array, $map['FC'], $map['ACFIMAGEMETA'], $post_id, $selected_type,$get_mode,$hash_key);
					break;	
		
				case 'GF':
					$acf_pro_instance = ACFProImport::getInstance();
					$acf_pro_instance->set_acf_gf_values( $header_array, $value_array, $map['GF'],$map['ACFIMAGEMETA'] , $post_id, $selected_type,$get_mode );
					break;
	
				case 'TYPES':
					$types_image_meta = isset($map['TYPESIMAGEMETA']) ? $map['TYPESIMAGEMETA'] :'';
					$toolset_instance = ToolsetImport::getInstance();
					$toolset_instance->set_toolset_values( $header_array, $value_array, $map['TYPES'], $types_image_meta, $post_id, $selected_type , $get_mode );
					break;	
				
				case 'JE':
					$jet_engine_instance = JetEngineImport::getInstance();
					$jet_engine_instance->set_jet_engine_values($header_array, $value_array, $map['JE'], $post_id, $selected_type, $get_mode);
					break;
				case 'JERF':
					$jet_engine_instance = JetEngineImport::getInstance();
					$jet_engine_instance->set_jet_engine_rf_values($header_array, $value_array, $map['JERF'], $post_id, $selected_type, $get_mode);
					break;
				case 'JECPT':
					$jet_engine_cpt_instance = JetEngineCPTImport::getInstance();
					$jet_engine_cpt_instance->set_jet_engine_cpt_values($header_array, $value_array, $map['JECPT'], $post_id, $selected_type, $get_mode);
					break;
				case 'JECPTRF':
					$jet_engine_cpt_instance = JetEngineCPTImport::getInstance();
					$jet_engine_cpt_instance->set_jet_engine_cpt_rf_values($header_array, $value_array, $map['JECPTRF'], $post_id, $selected_type, $get_mode);
					break;
				case 'JETAX':
					$jet_engine_tax_instance = JetEngineTAXImport::getInstance();
					$jet_engine_tax_instance->set_jet_engine_tax_values($header_array, $value_array, $map['JETAX'], $post_id, $selected_type, $get_mode);
					break;
				case 'JETAXRF':
					$jet_engine_tax_instance = JetEngineTAXImport::getInstance();
					$jet_engine_tax_instance->set_jet_engine_tax_rf_values($header_array, $value_array, $map['JETAXRF'], $post_id, $selected_type, $get_mode);
					break;
				case 'JEREL':
					$jet_engine_rel_instance = JetEngineRELImport::getInstance();
					$jet_engine_rel_instance->set_jet_engine_rel_values($header_array, $value_array, $map['JEREL'], $post_id, $selected_type, $get_mode);
					break;			
	
				case 'PODS':
					$pods_image_meta = isset($map['PODSIMAGEMETA']) ? $map['PODSIMAGEMETA'] :'';
					$pods_instance = PodsImport::getInstance();
					$pods_instance->set_pods_values($header_array ,$value_array , $map['PODS'],$pods_image_meta, $post_id , $selected_type);
					break;
	
				case 'AIOSEO':
					$all_seo_instance = AllInOneSeoImport::getInstance();
					$all_seo_instance->set_all_seo_values($header_array ,$value_array , $map['AIOSEO'], $post_id , $selected_type,$get_mode);
					break;
	
				case 'YOASTSEO':
					$yoast_instance = YoastSeoImport::getInstance();
					$yoast_instance->set_yoast_values($header_array ,$value_array , $map['YOASTSEO'], $post_id , $selected_type);
					break;
				case 'RANKMATH':
					$rankmath_instance = RankMathImport::getInstance();
					$rankmath_instance->set_rankmath_values($header_array, $value_array, $map['RANKMATH'], $post_id, $selected_type);
					break;
	
				case 'CCTM':
					$cctm_instance = CCTMImport::getInstance();
					$cctm_instance->set_cctm_values($header_array ,$value_array , $map['CCTM'], $post_id , $selected_type);
					break;
	
				case 'CFS':
					$cfs_instance = CFSImport::getInstance();
					$cfs_instance->set_cfs_values($header_array ,$value_array , $map['CFS'], $post_id , $selected_type);
					break;
	
				case 'CMB2':
					$cmb2_instance = CMB2Import::getInstance();
					$cmb2_instance->set_cmb2_values($header_array ,$value_array , $map['CMB2'], $post_id , $selected_type);
					break;
	
				case 'TERMS':
					$terms_taxo_instance = TermsandTaxonomiesImport::getInstance();
					$terms_taxo_instance->set_terms_taxo_values($header_array ,$value_array , $map['TERMS'], $post_id , $selected_type , $get_mode , $line_number);
					break;
	
				case 'CORECUSTFIELDS':
					$wordpress_custom_instance = WordpressCustomImport::getInstance();
					$wordpress_custom_instance->set_wordpress_custom_values($header_array ,$value_array , $map['CORECUSTFIELDS'], $post_id , $selected_type);
					break;
	
				case 'NEXTGEN':
					SaveMapping::$nextgen_instance->nextgenImport($header_array ,$value_array , $map['NEXTGEN'], $post_id , $selected_type);
					break;
	
				case 'COREUSERCUSTFIELDS':
					$wordpress_custom_instance = WordpressCustomImport::getInstance();
					$wordpress_custom_instance->set_wordpress_custom_values($header_array ,$value_array , $map['COREUSERCUSTFIELDS'], $post_id , $selected_type);
					break;
				case 'BP' :
					$buddy_instance = BuddyImport::getInstance();
					$buddy_instance->set_buddy_values($header_array,$value_array,$map['BP'],$post_id,$selected_type);
					break;
		
				}
			}

		}
		
		$return_arr['id'] = $post_id;
		$return_arr['detail_log'] = $core_instance->detailed_log;	
		return $return_arr;	
	}
}
