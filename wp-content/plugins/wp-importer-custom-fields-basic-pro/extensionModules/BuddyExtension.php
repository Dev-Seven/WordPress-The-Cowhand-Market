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

class BPExtension extends ExtensionHandler{
	private static $instance = null;

    public static function getInstance() {		
		if (BPExtension::$instance == null) {
			BPExtension::$instance = new BPExtension;
		}
		return BPExtension::$instance;
    }
   
    public function processExtension($data){  
        
        global $wpdb; 
        $response = [];
        $all_buddy_fields = [];
       
        $get_BPfields = $wpdb->get_results("SELECT id, name FROM {$wpdb->prefix}bp_xprofile_fields", ARRAY_A);
        foreach($get_BPfields as $get_buddy_fields){
            $all_buddy_fields[$get_buddy_fields['name']] = $get_buddy_fields['id'];
        }        
        $bp_fields_key = $this->convert_static_fields_to_array($all_buddy_fields);
		$response['bp_fields'] = $bp_fields_key; 
        return $response;
    } 

    public function extensionSupportedImportType($import_type ){
        if(is_plugin_active('buddypress/bp-loader.php')){
            if($import_type == 'Users'){
                return true;
            }
        }
	}
}
