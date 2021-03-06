<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Google_plus_comments_plugin extends Plugins_mdl{
	
	public function run( &$data, $params = NULL ){
		
		$ok = check_var( $this->mcm->filtered_system_params[ 'show_google_plus_comments' ] );
		
		if ( $ok ){
			
			$ok = FALSE;
			
			if( $this->current_component[ 'unique_name' ] === 'articles' ){
				
				if ( NULL !== $this->component_function ){
					
					if ( $this->component_function === 'index' ){
						
						if ( $this->component_function_action === 'articles_list' ){
							
							$ok = check_var( $this->mcm->filtered_system_params[ 'show_google_plus_comments_on_articles_list' ] );
							
						}
						else if ( $this->component_function_action === 'article_detail' ){
							
							$ok = check_var( $this->mcm->filtered_system_params[ 'show_google_plus_comments_on_article_detail' ] );
							
						}
						
					}
					
				}
				
			}
			
			if ( $ok ){
				
				log_message( 'debug', '[Plugins] Google Plus comments plugin initialized' );
				
				$this->_set_plugin_output( 'google_plus_comments', $this->load->view( 'admin/plugins/google_plus_comments/default/google_plus_comments', NULL, TRUE ) );
				
			}
			
		}
		
		parent::_set_performed( 'google_plus_comments' );
		
		return $ok;
		
	}
	
	public function get_params_spec(){
		
		$current_component = $this->current_component;
		
		$params = array();
		
		if( $current_component[ 'unique_name' ] === 'main' ){
			
			if ( NULL !== $this->component_function ){
				
				if ( $this->component_function === 'config_management' ){
					
					$params = array_merge_recursive( $params, get_params_spec_from_xml( PLUGINS_PATH . 'google_plus_comments/after_content_global_params.xml' ) );
					
				}
				
			}
			
		}
		else if( $current_component[ 'unique_name' ] === 'articles' ){
			
			if ( NULL !== $this->component_function ){
				
				if ( $this->component_function === 'component_config' ){
					
					$params = array_merge_recursive( $params, get_params_spec_from_xml( PLUGINS_PATH . 'google_plus_comments/articles/articles_global_params.xml' ) );
					
				}
				
			}
			
		}
		else if( $current_component[ 'unique_name' ] === 'menus' ){
			
			if ( NULL !== $this->menu_item_component_item ){
				
				if ( $this->menu_item_component_item === 'menu_item_article_detail' ){
					
					$params = array_merge_recursive( $params, get_params_spec_from_xml( PLUGINS_PATH . 'google_plus_comments/articles/article_detail.xml' ) );
					
				}
				else if ( $this->menu_item_component_item === 'menu_item_articles_list' ){
					
					$params = array_merge_recursive( $params, get_params_spec_from_xml( PLUGINS_PATH . 'google_plus_comments/articles/articles_list.xml' ) );
					$params = array_merge_recursive( $params, get_params_spec_from_xml( PLUGINS_PATH . 'google_plus_comments/articles/article_detail.xml' ) );
					
				}
				
			}
			
		}
		
		return $params;
		
	}
	
}
