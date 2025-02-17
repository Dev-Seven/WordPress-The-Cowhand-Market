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

class FtpsUpload implements Uploads{

	private static $instance = null;
	private static $smack_csv_instance = null;

	private function __construct(){
		add_action('wp_ajax_get_ftps_url',array($this,'upload_function'));
	}

	public static function getInstance() {
		if (FtpsUpload::$instance == null) {
			FtpsUpload::$instance = new FtpsUpload;
			FtpsUpload::$smack_csv_instance = SmackCSV::getInstance();
			return FtpsUpload::$instance;
		}
		return FtpsUpload::$instance;
	}


	/**
	 * Upload file from FTPS.
	 */
	public function upload_function(){
		global $wpdb;
		$host_name = $_POST['HostName'];
		$host_port = $_POST['HostPort'];
		$host_username = $_POST['HostUserName'];
		$host_password = $_POST['HostPassword'];
		$host_path = $_POST['HostPath'];
		$file_table_name = $wpdb->prefix ."smackcf_file_events";
		// set up basic connection
		$conn_id = ftp_ssl_connect($host_name , $host_port);
		$response = [];
		if(!$conn_id){
			$response['success'] = false;
			$response['message'] = 'FTPS connection failed';
			echo wp_json_encode($response);
		}else{    
			// login with username and password
			$login_result = ftp_login($conn_id, $host_username, $host_password);
			$ftp_file_name = basename($host_path);
			$validate_instance = ValidateFile::getInstance();
			$zip_instance = ZipHandler::getInstance();
			$validate_format = $validate_instance->validate_file_format($ftp_file_name);
			if($validate_format == 'yes'){
				$upload_dir = FtpsUpload::$smack_csv_instance->create_upload_dir();
				if($upload_dir){
					ftp_pasv($conn_id, true);            
					$path = explode($ftp_file_name, $host_path);
					$path = isset($path[0]) ? $path[0] : '';
					$file_extension = pathinfo($ftp_file_name, PATHINFO_EXTENSION);
					if(empty($file_extension)){
						$file_extension = 'xml';
					}
					$file_extn = '.' . $file_extension;
					$get_local_filename = explode($file_extn, $ftp_file_name);
					$local_file_name = $get_local_filename[0] . '-1' . $file_extn;
					$event_key = FtpsUpload::$smack_csv_instance->convert_string2hash_key($local_file_name);
					if($file_extension == 'zip'){
						$zip_response = [];        
						$path = $upload_dir . $event_key . '.zip';
						$extract_path = $upload_dir . $event_key;
						$server_file = $host_path;                        
						$ret = ftp_nb_get($conn_id,$path,$server_file,FTP_ASCII);
						$ret = ftp_nb_continue($conn_id);
						if($ret == FTP_FINISHED){
							chmod($path, 0777);
							$zip_response['success'] = true;
							$zip_response['filename'] = $ftp_file_name;
							$zip_response['file_type'] = 'zip';
							$zip_response['info'] = $zip_instance->zip_upload($path , $extract_path);
						}else{
							$zip_response['success'] = false;
							$zip_response['message'] = 'Cannot Download the file , file not found';
						}
						echo wp_json_encode($zip_response); 
						wp_die();        
					}

					$upload_dir_path = $upload_dir. $event_key;
					if (!is_dir($upload_dir_path)) {
						wp_mkdir_p( $upload_dir_path);
					}
					chmod($upload_dir_path, 0777);	  
					$wpdb->insert( $file_table_name , array( 'file_name' => $ftp_file_name , 'hash_key' => $event_key , 'status' => 'Downloading' , 'lock' => true ) );
					$last_id = $wpdb->get_results("SELECT id FROM $file_table_name ORDER BY id DESC LIMIT 1",ARRAY_A);
					$lastid=$last_id[0]['id'];
					$local_file = $upload_dir. $event_key .'/'.$event_key;
					$server_file = $host_path;                    
					$fs = ftp_size($conn_id , $server_file);                    
					$ret = ftp_nb_get($conn_id , $local_file,$server_file,FTP_BINARY);            
					$filesize = filesize($local_file);
					if ($filesize > 1024 && $filesize < (1024 * 1024)) {
						$fileSize = round(($filesize / 1024), 2) . ' kb';
					} else {
						if ($filesize > (1024 * 1024)) {
							$fileSize = round(($filesize / (1024 * 1024)), 2) . ' mb';
						} else {
							$fileSize = $filesize . ' byte';
						}
					}
					while($ret == FTP_MOREDATA){
						clearstatcache();
						$dld = $fileSize;
						if($dld > 0){
							$i = ($dld/$fs)*100;
							$wpdb->get_results("UPDATE $file_table_name SET  progress='$i' , `lock`=true WHERE id = '$lastid'");
						}
						$ret = ftp_nb_continue($conn_id);
					}
					if($ret == FTP_FINISHED){
						chmod($local_file, 0777);
						$validate_file = $validate_instance->file_validation($local_file , $file_extension);
						$file_size = filesize($local_file);
						$files_size = $validate_instance->formatSizeUnits($file_size);
						if($validate_file == "yes"){
							$wpdb->get_results("UPDATE $file_table_name SET status='Downloaded',`lock`=false WHERE id = '$lastid'");
							$get_result = $validate_instance->import_record_function($event_key , $ftp_file_name);
							$response['success'] = true;
							$response['filename'] = $ftp_file_name;
							$response['hashkey'] = $event_key;
							$response['posttype'] = $get_result['Post Type'];
							$response['taxonomy'] = $get_result['Taxonomy'];
							$response['selectedtype'] = $get_result['selected type'];
							$response['file_type'] = $file_extension;
							$response['file_size'] = $files_size;
							$response['message'] = 'Downloaded Successfully';
							echo wp_json_encode($response);
						}else{
							$response['success'] = false;
							$response['message'] = $validate_file;
							echo wp_json_encode($response); 
							unlink($path);
							$wpdb->get_results("UPDATE $file_table_name SET status='Download Failed' WHERE id = '$lastid'");
						}
					} else {
						$wpdb->get_results("UPDATE $file_table_name SET status='Download Failed' WHERE id = '$lastid'");
						$response['message'] = 'Cannot Download the file , file not found';
						echo wp_json_encode($response);
					}
					// close the connection
					ftp_close($conn_id);
				}else{
					$response['success'] = false;
					$response['message'] = "Please create Upload folder with writable permission";
					echo wp_json_encode($response); 
				}
			}else{
				$response['success'] = false;
				$response['message'] = $validate_format;
				echo wp_json_encode($response); 
			}
		}
		wp_die();
	}
}
