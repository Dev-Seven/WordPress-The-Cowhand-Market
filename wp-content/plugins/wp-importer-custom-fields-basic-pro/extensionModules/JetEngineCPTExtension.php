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

class JetEngineCPTExtension extends ExtensionHandler{
    private static $instance = null;
	
    public static function getInstance() {		
		if (JetEngineCPTExtension::$instance == null) {
			JetEngineCPTExtension::$instance = new JetEngineCPTExtension;
		}
		return JetEngineCPTExtension::$instance;
	}
	
	/**
	* Provides default mapping fields for Jet Engine Pro plugin
	* @param string $data - selected import type
	* @return array - mapping fields
	*/
	public function processExtension($data){
		$import_type = $data;
		$response = [];
		$jet_engine_cpt_fields = $this->JetEngineCPTFields($import_type);
		$response['jetenginecpt_fields'] = $jet_engine_cpt_fields;	
		$jet_engine_cpt_rf_fields = $this->JetEngineCPTRFFields($import_type);
		$response['jetenginecpt_rf_fields'] = $jet_engine_cpt_rf_fields;
		return $response;	
	}

	/**
	* Retrieves Jet Engine custom post  mapping fields
	* @param string $import_type - selected import type
	* @return array - mapping fields
	*/
	public function JetEngineCPTFields($import_type) {	
		global $wpdb;	
		
		$get_meta_fields = $wpdb->get_results($wpdb->prepare("SELECT id, meta_fields FROM {$wpdb->prefix}jet_post_types WHERE slug = %s AND status = %s", $import_type, 'publish'));
		
	
		if(isset($get_meta_fields[0])){
			$unserialized_meta = maybe_unserialize($get_meta_fields[0]->meta_fields);
		}
		else{
			$unserialized_meta = '';
		}
		
		if(is_array($unserialized_meta)){
			foreach($unserialized_meta as $jet_key => $jet_value){
				$jet_field_label = $jet_value['title'];
				$jet_field_name = $jet_value['name'];
				$jet_field_type = $jet_value['type'];
				if($jet_field_type != 'repeater'){
				
					$customFields["JECPT"][ $jet_key ]['label'] = $jet_field_label;
					$customFields["JECPT"][ $jet_key ]['name']  = $jet_field_name;	
				}
	
			}
		}
		
		$jet_value = $this->convert_fields_to_array($customFields);
		return $jet_value;		
	}

	public function JetEngineCPTRFFields($import_type) {	
		global $wpdb;	
		
		$get_meta_fields = $wpdb->get_results($wpdb->prepare("SELECT id, meta_fields FROM {$wpdb->prefix}jet_post_types WHERE slug = %s AND status = %s", $import_type, 'publish'));
		//$unserialized_meta = maybe_unserialize($get_meta_fields[0]->meta_fields);
		if(isset($get_meta_fields[0])){
			$unserialized_meta = maybe_unserialize($get_meta_fields[0]->meta_fields);
		}
		else{
			$unserialized_meta = '';
		}
		if(is_array($unserialized_meta)){
			foreach($unserialized_meta as $jet_key => $jet_value){
				$jet_field_type = $jet_value['type'];
				if($jet_field_type == 'repeater'){
					$jet_rep_fields = $jet_value['repeater-fields'];
					foreach($jet_rep_fields as $jet_rep_fkey => $jet_rep_fvalue){
						$jet_field_label[] = $jet_rep_fvalue['title'];
						$jet_field_name[] = $jet_rep_fvalue['name'];
						// $customFields["JECPTRF"][ $jet_rep_fkey ]['label'] =$jet_field_label;
						// $customFields["JECPTRF"][ $jet_rep_fkey ]['name']  = $jet_field_name;
					}
				}
			}
		}
	
		foreach($jet_field_label as $jet_label_key => $jet_label_value){
			$customFields["JECPTRF"][ $jet_label_key ]['label'] =$jet_label_value;	
		}
		foreach($jet_field_name as $jet_name_key => $jet_name_value){
			$customFields["JECPTRF"][ $jet_name_key ]['name']  = $jet_name_value;
		}
		$jet_value = $this->convert_fields_to_array($customFields);
		return $jet_value;	
	}
	/**
	* Jet Engine extension supported import types
	* @param string $import_type - selected import type
	* @return boolean
	*/
	public function extensionSupportedImportType($import_type){
		if(is_plugin_active('jet-engine/jet-engine.php')){
			if($import_type == 'nav_menu_item'){
				return false;
			}
			$import_type = $this->import_name_as($import_type);
			if($import_type =='Posts' || $import_type =='Pages' || $import_type =='CustomPosts' || $import_type =='event' || $import_type =='location' || $import_type == 'event-recurring' || $import_type =='Users' || $import_type =='WooCommerce'  || $import_type =='WooCommerceCategories' || $import_type =='WooCommerceattribute' || $import_type =='WooCommercetags' || $import_type =='MarketPress' || $import_type =='WPeCommerce' || $import_type =='eShop' || $import_type =='Taxonomies' || $import_type =='Tags' || $import_type =='Categories' || $import_type == 'CustomerReviews' || $import_type ='Comments') {		
				return true;
			}
			if($import_type == 'ticket'){
				if(is_plugin_active('events-manager/events-manager.php')){
					return false;
				}else{
					return true;
				}
			}
			else{
				return false;
			}
		}
	}
}