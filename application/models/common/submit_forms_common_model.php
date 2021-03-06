<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Submit_forms_common_model extends CI_Model{
	
	// --------------------------------------------------------------------
	
	public function __construct(){
		
		if ( ! $this->load->is_model_loaded( 'unid' ) ) {
			
			$this->load->model( 'unid_mdl', 'unid' );
			
		}
		
	}
	
	// --------------------------------------------------------------------
	
	private function _get_ud_d_list_layout_site_params( $menu_item, $params_spec_values ) {
		
		$component_params = $this->mcm->get_component( 'submit_forms' );
		$component_params = $component_params[ 'params' ];
		$menu_item_params = $menu_item[ 'params' ];
		
		
		$params_values = filter_params( $component_params, $params_spec_values );
		$params_values = filter_params( $component_params, $menu_item_params );
		
		$layout_params = array();
		
		if ( isset( $params_values[ 'ud_d_list_layout_site' ] ) AND $params_values[ 'ud_d_list_layout_site' ] != 'global' ) {
			
			$system_views_path = VIEWS_PATH . SITE_COMPONENTS_VIEWS_PATH . get_class_name( get_class() ) . DS . 'index' . DS . 'list' . DS;
			$theme_views_path = THEMES_PATH . site_theme_components_views_path() . get_class_name( get_class() ) . DS . 'index' . DS . 'list' . DS;
			
			if ( file_exists( $system_views_path . $params_values[ 'ud_d_list_layout_site' ] . DS . 'params.xml' ) ) {
				
				$layout_params = get_params_spec_from_xml( $system_views_path . $params_values[ 'ud_d_list_layout_site' ] . DS . 'params.xml' );
				
				if ( file_exists( $system_views_path . $params_values[ 'ud_d_list_layout_site' ] . DS . 'params.php' ) ) {
					
					include_once $system_views_path . $params_values[ 'ud_d_list_layout_site' ] . DS . 'params.php';
					
				}
				
			}
			else if ( file_exists( $theme_views_path . $params_values[ 'ud_d_list_layout_site' ] . DS . 'params.xml' ) ) {
				
				$layout_params = get_params_spec_from_xml( $theme_views_path . $params_values[ 'ud_d_list_layout_site' ] . DS . 'params.xml' );
				
				if ( file_exists( $theme_views_path . $params_values[ 'ud_d_list_layout_site' ] . DS . 'params.php' ) ) {
					
					include_once $theme_views_path . $params_values[ 'ud_d_list_layout_site' ] . DS . 'params.php';
					
				}
				
			}
			
			//echo '<pre>' . print_r( $layout_params, TRUE ) . '</pre>';
			
		}
		
		return $layout_params;
		
	}
	
	// --------------------------------------------------------------------
	
	public function get_submit_forms( $f_params = NULL ){
		
		// inicializando as variáveis
		$where_condition =						isset( $f_params['where_condition'] ) ? $f_params['where_condition'] : NULL;
		$or_where_condition =					isset( $f_params['or_where_condition'] ) ? $f_params['or_where_condition'] : NULL;
		$limit =								isset( $f_params['limit'] ) ? $f_params['limit'] : NULL;
		$offset =								isset( $f_params['offset'] ) ? $f_params['offset'] : NULL;
		$order_by =								isset( $f_params['order_by'] ) ? $f_params['order_by'] : 't1.title asc, t1.id asc';
		$order_by_escape =						isset( $f_params['order_by_escape'] ) ? $f_params['order_by_escape'] : TRUE;
		$return_type =							isset( $f_params['return_type'] ) ? $f_params['return_type'] : 'get';
		
		$this->db->select('
			
			t1.*
			
		');
		
		$this->db->from('tb_submit_forms t1');
		
		$this->db->order_by( $order_by, '', $order_by_escape );
		
		if ( $where_condition ){
			
			if( is_array( $where_condition ) ){

				foreach ( $where_condition as $key => $value ) {

					if( gettype( $where_condition ) === 'array' AND ( strpos( $key, 'fake_index_' ) !== FALSE ) ){

						$this->db->where( $value );
					}
					else $this->db->where( $key, $value );
				}
			}
			else $this->db->where( $where_condition );
		}
		if ( $or_where_condition ){
			if( is_array( $or_where_condition ) ){
				foreach ( $or_where_condition as $key => $value ) {

					if( gettype( $or_where_condition ) === 'array' AND ( strpos( $key, 'fake_index_' ) !== FALSE ) ){

						$this->db->or_where( $value );

					}
					else $this->db->or_where( $key, $value );

				}
			}
			else $this->db->or_where( $or_where_condition );

		}
		if ( $return_type === 'count_all_results' ){

			return $this->db->count_all_results();

		}
		if ( $limit ){

			$this->db->limit( $limit, $offset ? $offset : NULL );

		}
		
		return $this->db->get();

	}
	
	// --------------------------------------------------------------------
	
	public function get_submit_form( $id = NULL ){
		
		if ( $id!=NULL ){
			$this->db->select('t1.*');
			$this->db->from('tb_submit_forms t1');
			$this->db->where( 't1.id', $id );
			// limitando o resultando em apenas 1
			$this->db->limit(1);
			return $this->db->get();
		}
		else {
			return FALSE;
		}
		
	}
	
	// --------------------------------------------------------------------
	
	public function insert( $data = NULL ){
		if ($data != NULL){
			if ($this->db->insert('tb_submit_forms',$data)){
				// confirm the insertion for controller
				return $this->db->insert_id();
			}
			else {
				// case the insertion fails, return false
				return FALSE;
			}
		}
		else {
			redirect('categories');
		}
	}
	
	// --------------------------------------------------------------------
	
	public function update( $data = NULL, $condition = NULL ){
		if ($data != NULL && $condition != NULL){
			if ($this->db->update('tb_submit_forms',$data,$condition)){
				// confirm update for controller
				return TRUE;
			}
			else {
				// case update fails, return false
				return FALSE;
			}
		}
		redirect('admin/menus');
	}
	
	// --------------------------------------------------------------------
	
	public function delete( $condition = NULL ){
		if ($condition != null){
			if ($this->db->delete('tb_submit_forms',$condition)){
				// confirm delete for controller
				return TRUE;
			}
			else {
				// case delete fails, return false
				return FALSE;
			}
		}

	}
	
	// --------------------------------------------------------------------
	
	public function delete_all(){

		$sql = 'DELETE FROM tb_submit_forms';

		if ( $this->db->query( $sql ) ){

			// confirm delete for controller
			return TRUE;

		}
		else {

			// case delete fails, return false
			return FALSE;

		}

	}

	// --------------------------------------------------------------------
	
	public function get_submit_form_params( $data_scheme, $current_params_values ){
		
		$params = get_params_spec_from_xml( APPPATH . 'controllers/admin/com_submit_forms/submit_form_params.xml' );
		
		$_current_params_values = isset( $current_params_values ) ? $current_params_values : array();
		
		/*
		 * ------------------------------------
		 * Api access
		 */
		
		$new_params[ 'ud_ds_api_access' ][] = array(
			
			'type' => 'spacer',
			'label' => 'user_group',
			
		);
		
		/*
		 * ------------------------------------
		 * User groups
		 */
		
		//$users_groups = $this->users->get_accessible_users_groups( $this->users->user_data[ 'id' ] );
		$users_groups = $this->users->get_users_groups_tree( 0, 0, 'list' );
		
		foreach ( $users_groups as $key => $ug ) {
			
			$ug_id = $ug[ 'id' ];
			
			$_tmp = array(
				
				'type' => 'checkbox',
				'name' => 'ud_ds_api_access_type_user_group[' . $ug_id . ']',
				'label' => $ug[ 'indented_title' ],
				'value' => $ug_id,
				'validation' => array(
					
					'rules' => 'trim',
					
				),
				
			);
			
			if ( ! isset( $current_params_values ) ) {
				
				$params[ 'params_spec_values' ][ 'ud_ds_api_access_type_user_group[' . $ug_id . ']' ] = $ug_id;
				
			}
			
			$new_params[ 'ud_ds_api_access' ][] = $_tmp;
			
		}
		
		/*
		 * ------------------------------------
		 */
		
		$new_params[ 'ud_ds_api_access' ][] = array(
			
			'type' => 'spacer',
			'label' => 'users',
			
		);
		
		/*
		 * ------------------------------------
		 */
		
		$users = $this->users->get_users_checking_privileges()->result_array();
		
		foreach ( $users as $key => $user ) {
			
			$user_id = $user[ 'id' ];
			
			$_tmp = array(
				
				'type' => 'checkbox',
				'inline' => TRUE,
				'name' => 'ud_ds_api_access_type_users[' . $user_id . ']',
				'label' => $user[ 'name' ] . ' (<strong class="small" title="' . lang( 'username' ) . '">' . $user[ 'username' ] . '</strong>)',
				'value' => $user_id,
				'validation' => array(
					
					'rules' => 'trim',
					
				),
				
			);
			
			if ( ! $current_params_values ) {
				
				$params[ 'params_spec_values' ][ 'ud_ds_api_access_type_users[' . $user_id . ']' ] = $user_id;
				
			}
			
			$new_params[ 'ud_ds_api_access' ][] = $_tmp;
			
		}
		
		array_push_pos( $params[ 'params_spec' ][ 'ud_ds_api' ], $new_params[ 'ud_ds_api_access' ], 4  );
		
		/*
		 * Api access
		 * ------------------------------------
		 * Security
		 */
		
		$new_params[ 'ud_ds_access' ][] = array(
			
			'type' => 'spacer',
			'label' => 'user_group',
			
		);
		
		/*
		 * ------------------------------------
		 * User groups
		 */
		
		//$users_groups = $this->users->get_accessible_users_groups( $this->users->user_data[ 'id' ] );
		$users_groups = $this->users->get_users_groups_tree( 0, 0, 'list' );
		
		foreach ( $users_groups as $key => $ug ) {
			
			$ug_id = $ug[ 'id' ];
			
			$_tmp = array(
				
				'type' => 'checkbox',
				'name' => 'ud_ds_access_type_users_groups[' . $ug_id . ']',
				'label' => $ug[ 'indented_title' ],
				'value' => $ug_id,
				'validation' => array(
					
					'rules' => 'trim',
					
				),
				
			);
			
			if ( ! $current_params_values ) {
				
				$params[ 'params_spec_values' ][ 'ud_ds_access_type_users_groups[' . $ug_id . ']' ] = $ug_id;
				
			}
			
			$new_params[ 'ud_ds_access' ][] = $_tmp;
			
		}
		
		/*
		 * ------------------------------------
		 */
		
		$new_params[ 'ud_ds_access' ][] = array(
			
			'type' => 'spacer',
			'label' => 'ud_ds_access_users_label',
			'tip' => 'tip_ud_ds_access_users_label',
			
		);
		
		/*
		 * ------------------------------------
		 */
		
		foreach ( $users as $key => $user ) {
			
			$user_id = $user[ 'id' ];
			
			$_tmp = array(
				
				'type' => 'checkbox',
				'inline' => TRUE,
				'name' => 'ud_ds_access_type_users[' . $user_id . ']',
				'label' => $user[ 'name' ] . ' (<strong class="small" title="' . lang( 'username' ) . '">' . $user[ 'username' ] . '</strong>)',
				'value' => $user_id,
				'validation' => array(
					
					'rules' => 'trim',
					
				),
				
			);
			
			if ( ! $current_params_values ) {
				
				$params[ 'params_spec_values' ][ 'ud_ds_access_type_users[' . $user_id . ']' ] = $user_id;
				
			}
			
			$new_params[ 'ud_ds_access' ][] = $_tmp;
			
		}
		
		array_push_pos( $params[ 'params_spec' ][ 'sf_security_and_access' ], $new_params[ 'ud_ds_access' ], 3  );
		
		/*
		 * ------------------------------------
		 */
		
		$users_groups_options = array(
			
			'' => lang( 'combobox_select' ),
			
		);
		
		foreach ( $users_groups as $key => $ug ) {
			
			$users_groups_options[ $ug[ 'id' ] ] = $ug[ 'indented_title' ];
			
		}
		
		$new_params[ 'ud_ds_default_user_group_registered_from_form' ][] = array(
			
			'type' => 'select',
			'inline' => TRUE,
			'name' => 'ud_ds_default_user_group_registered_from_form',
			'label' => 'ud_ds_default_user_group_registered_from_form',
			'tip' => 'tip_ud_ds_default_user_group_registered_from_form',
			'validation' => array(
				
				'rules' => 'trim',
				
			),
			'options' => $users_groups_options,
			
		);
		
		$params[ 'params_spec_values' ][ 'ud_ds_default_user_group_registered_from_form' ] = '';
		
		/*
		 * ------------------------------------
		 */
		
		array_push_pos( $params[ 'params_spec' ][ 'sf_security_and_access' ], $new_params[ 'ud_ds_default_user_group_registered_from_form' ], 3  );
		
		/*
		 * ------------------------------------
		 */
		
		
		
		
		
		
		
		
		/*
		 * ------------------------------------
		 */
		
		$ud_data_list_params = array();
		
		/*
		* ------------------------------------
		*/
		
		$_tmp = array(
			
			'type' => 'select',
			'name' => 'use_search',
			'label' => 'use_search',
			'tip' => 'tip_use_search',
			'validation' => array(
				
				'rules' => 'trim|required',
				
			),
			'options' => array(
				
				'1' => 'yes',
				'0' => 'no',
				
			),
			
		);
		
		$params[ 'params_spec_values' ][ 'use_search' ] = 0;
		
		$ud_data_list_params[] = $_tmp;
		
		/*
		 * ------------------------------------
		 */
		
		$ud_data_list_params[] = array(
			
			'type' => 'spacer',
			'label' => 'ud_data_availability_site_search_lbl',
			'name' => 'ud_data_availability_site_search_lbl',
			
		);
		
		/*
		 * ------------------------------------
		 */
		 
		$users_groups_options = array(
			
			'' => lang( 'combobox_select' ),
			
		);
		
		foreach ( $users_groups as $key => $ug ) {
			
			$users_groups_options[ $ug[ 'id' ] ] = $ug[ 'indented_title' ];
			
		}
		
		$ud_data_list_params[] = array(
			
			'type' => 'checkbox',
			'inline' => TRUE,
			'name' => 'ud_data_availability_site_search[__terms]',
			'label' => 'ud_data_list_prop_search_field_terms',
			'value' => '__terms',
			'validation' => array(
				
				'rules' => 'trim',
				
			),
			
		);
		
		$params[ 'params_spec_values' ][ 'ud_data_availability_site_search[__terms]' ] = '__terms';
		
		/*
		 * ------------------------------------
		 */
		
		array_push_pos( $params[ 'params_spec' ][ 'users_submits_list' ], $ud_data_list_params, 0  );
		
		/*
		 * ------------------------------------
		 */
		
		
		
		
		
		
		
		
		
		
		/*
		 * ------------------------------------
		 */
		
		$options = array(
			
			'1' => lang( 'yes' ),
			'0' => lang( 'no' ),
			
		);
		
		$new_params[ 'ud_ds_send_user_data_to_submitter_on_registration' ][] = array(
			
			'type' => 'select',
			'inline' => TRUE,
			'name' => 'ud_ds_send_user_data_to_submitter_on_registration',
			'label' => 'ud_ds_send_user_data_to_submitter_on_registration',
			'tip' => 'tip_ud_ds_send_user_data_to_submitter_on_registration',
			'validation' => array(
				
				'rules' => 'trim',
				
			),
			'options' => $options,
			
		);
		
		$params[ 'params_spec_values' ][ 'ud_ds_send_user_data_to_submitter_on_registration' ] = '';
		
		/*
		 * ------------------------------------
		 */
		
		array_push_pos( $params[ 'params_spec' ][ 'sf_security_and_access' ], $new_params[ 'ud_ds_send_user_data_to_submitter_on_registration' ], 3  );
		
		/*
		 * ------------------------------------
		 */
		
		/*************************************/
		/******* Carregando os contatos ******/

		$this->load->model( array( 'common/contacts_common_model' ) );

		$contacts = $this->contacts_common_model->get_contacts()->result_array();

		$contacts_options = array();

		foreach ( $contacts as $contact ){

			$contacts_options[ $contact[ 'id' ] ] = $contact[ 'name' ];

		}

		/******* Carregando os contatos ******/
		/*************************************/


		// carregando os layouts do tema atual
		$layouts_sending_email = dir_list_to_array( THEMES_PATH . site_theme_components_views_path() . 'submit_forms' . DS . 'index' . DS . 'emails' . DS . 'receivers' );
		// carregando os layouts do diretório de views padrão
		$layouts_sending_email = array_merge( $layouts_sending_email, dir_list_to_array( VIEWS_PATH . SITE_COMPONENTS_VIEWS_PATH . 'submit_forms' . DS . 'index' . DS . 'emails' . DS . 'receivers' ) );

		// carregando os layouts de cópia para o usuário do tema atual
		$layouts_sending_email_submitter = dir_list_to_array( THEMES_PATH . site_theme_components_views_path() . 'submit_forms' . DS . 'index' . DS . 'emails' . DS . 'submitters' );
		// carregando os layouts de cópia para o usuário do diretório de views padrão
		$layouts_sending_email_submitter = array_merge( $layouts_sending_email, dir_list_to_array( VIEWS_PATH . SITE_COMPONENTS_VIEWS_PATH . 'submit_forms' . DS . 'index' . DS . 'emails' . DS . 'submitters' ) );

		$current_section = 'ud_ds_emails_for_receivers';
		foreach ( $params[ 'params_spec' ][ $current_section ] as $key => $element ) {

			if ( $element[ 'name' ] == 'submit_form_param_send_email_to_contact' ){

				$spec_options = array();

				if ( isset( $params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ] ) )
					$spec_options = $params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ];

				$params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ] = is_array( $spec_options ) ? $spec_options + $contacts_options : $contacts_options;

			}
			if ( $element[ 'name' ] == 'submit_form_sending_email_layout_view' ){

				$spec_options = array();

				if ( isset( $params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ] ) )
					$spec_options = $params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ];

				$params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ] = is_array( $spec_options ) ? $spec_options + $layouts_sending_email : $layouts_sending_email;

			}

		}

		$current_section = 'ud_ds_emails_for_submitters';
		foreach ( $params[ 'params_spec' ][ $current_section ] as $key => $element ) {

			if ( $element[ 'name' ] == 'sfsmr_layout_view' ){

				$spec_options = array();

				if ( isset( $params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ] ) )
					$spec_options = $params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ];

				$params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ] = is_array( $spec_options ) ? $spec_options + $layouts_sending_email_submitter : $layouts_sending_email_submitter;

			}

		}
		
		$current_section = 'ud_ds_look_and_feel';
		
		// ds form layouts
		$layouts = dir_list_to_array( THEMES_PATH . site_theme_components_views_path() . 'submit_forms' . DS . 'index' . DS . 'submit_form' );
		// carregando os layouts do diretório de views padrão
		$layouts = array_merge( $layouts, dir_list_to_array( VIEWS_PATH . SITE_COMPONENTS_VIEWS_PATH . 'submit_forms' . DS . 'index' . DS . 'submit_form' ) );
		
		foreach ( $params[ 'params_spec' ][ $current_section ] as $key => $element ) {
			
			if ( $element[ 'name' ] == 'ud_ds_form_layout_site' ){
				
				$spec_options = array();
				
				if ( isset( $params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ] ) )
					$spec_options = $params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ];
					
				$params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ] = is_array( $spec_options ) ? $spec_options + $layouts : $layouts;
				
			}
			
		}
		
		// carregando os layouts do tema atual
		$layouts = dir_list_to_array( THEMES_PATH . site_theme_components_views_path() . 'submit_forms' . DS . 'index' . DS . 'users_submits' );
		// carregando os layouts do diretório de views padrão
		$layouts = array_merge( $layouts, dir_list_to_array( VIEWS_PATH . SITE_COMPONENTS_VIEWS_PATH . 'submit_forms' . DS . 'index' . DS . 'users_submits' ) );
		
		foreach ( $params[ 'params_spec' ][ $current_section ] as $key => $element ) {
			
			if ( $element[ 'name' ] == 'ud_d_list_layout_site' ){
				
				$spec_options = array();
				
				if ( isset( $params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ] ) )
					$spec_options = $params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ];
					
				$params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ] = is_array( $spec_options ) ? $spec_options + $layouts : $layouts;
				
			}
			
		}
		
		$current_section = 'ud_params_section_d_detail_params';
		
		// carregando os layouts do tema atual
		$layouts = dir_list_to_array( THEMES_PATH . site_theme_components_views_path() . 'submit_forms' . DS . 'index' . DS . 'ud_data_detail' );
		// carregando os layouts do diretório de views padrão
		$layouts = array_merge( $layouts, dir_list_to_array( VIEWS_PATH . SITE_COMPONENTS_VIEWS_PATH . 'submit_forms' . DS . 'index' . DS . 'ud_data_detail' ) );
		
		foreach ( $params[ 'params_spec' ][ $current_section ] as $key => $element ) {
			
			if ( $element[ 'name' ] == 'ud_d_detail_layout_site' ){
				
				$spec_options = array();
				
				if ( isset( $params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ] ) )
					$spec_options = $params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ];
					
				$params[ 'params_spec' ][ $current_section ][ $key ][ 'options' ] = is_array( $spec_options ) ? $spec_options + $layouts : $layouts;
				
			}
			
		}
		
		// ------------------------------------
		// Receivers layout specific params
		
		$receivers_email_layout = check_var( $current_params_values[ 'submit_form_sending_email_layout_view' ] ) ? $current_params_values[ 'submit_form_sending_email_layout_view' ] : ( check_var( $params[ 'params_spec_values' ][ 'submit_form_sending_email_layout_view' ] ) ? $params[ 'params_spec_values' ][ 'submit_form_sending_email_layout_view' ] : FALSE );
		
			//echo '<pre>' . print_r( $current_params_values, TRUE ) . '</pre>'; exit;
			
		if ( $receivers_email_layout ) {
			
			$system_views_path = VIEWS_PATH . SITE_COMPONENTS_VIEWS_PATH . 'submit_forms' . DS . 'index' . DS . 'emails' . DS . 'receivers' . DS;
			$theme_views_path = THEMES_PATH . site_theme_components_views_path() . 'submit_forms' . DS . 'index' . DS . 'emails' . DS . 'receivers' . DS;
			
			if ( file_exists( $system_views_path . $receivers_email_layout . DS . 'params.xml' ) ) {
				
				$receivers_layout_params = get_params_spec_from_xml( $system_views_path . $receivers_email_layout . DS . 'params.xml' );
				
				if ( file_exists( $system_views_path . $receivers_email_layout . DS . 'params.php' ) ) {
					
					include_once $system_views_path . $receivers_email_layout . DS . 'params.php';
					
				}
				
			}
			else if ( file_exists( $theme_views_path . $receivers_email_layout . DS . 'params.xml' ) ) {
				
				$receivers_layout_params = get_params_spec_from_xml( $theme_views_path . $receivers_email_layout . DS . 'params.xml' );
				
				if ( file_exists( $theme_views_path . $receivers_email_layout . DS . 'params.php' ) ) {
					
					include_once $theme_views_path . $receivers_email_layout . DS . 'params.php';
					
				}
				
			}
			
			if ( check_var( $params ) AND check_var( $receivers_layout_params ) ) {
			
				$params[ 'params_spec_values' ] = array_merge_recursive( $params[ 'params_spec_values' ], $receivers_layout_params[ 'params_spec_values' ] );
				
				foreach( $params[ 'params_spec' ][ 'ud_ds_emails_for_receivers' ] as $k => $v ) {
					
					if ( $v[ 'name' ] == 'submit_form_sending_email_layout_view' ) {
						
						array_push_pos( $params[ 'params_spec' ][ 'ud_ds_emails_for_receivers' ], $receivers_layout_params[ 'params_spec' ][ 'ud_ds_emails_for_receivers' ], $k + 1 );
						
						break;
						
					}
					
				}
				
			}
			
			//echo '<pre>' . print_r( $params, TRUE ) . '</pre>';
			
		}
		
		// Receivers layout specific params
		// ------------------------------------
		
		// ------------------------------------
		// Submitters layout specific params
		
		$submitters_email_layout = check_var( $current_params_values[ 'sfsmr_layout_view' ] ) ? $current_params_values[ 'sfsmr_layout_view' ] : ( check_var( $params[ 'params_spec_values' ][ 'sfsmr_layout_view' ] ) ? $params[ 'params_spec_values' ][ 'sfsmr_layout_view' ] : FALSE );
		
			//echo '<pre>' . print_r( $current_params_values, TRUE ) . '</pre>'; exit;
			
		if ( $submitters_email_layout ) {
			
			$system_views_path = VIEWS_PATH . SITE_COMPONENTS_VIEWS_PATH . 'submit_forms' . DS . 'index' . DS . 'emails' . DS . 'submitters' . DS;
			$theme_views_path = THEMES_PATH . site_theme_components_views_path() . 'submit_forms' . DS . 'index' . DS . 'emails' . DS . 'submitters' . DS;
			
			if ( file_exists( $system_views_path . $submitters_email_layout . DS . 'params.xml' ) ) {
				
				$submitters_layout_params = get_params_spec_from_xml( $system_views_path . $submitters_email_layout . DS . 'params.xml' );
				
				if ( file_exists( $system_views_path . $submitters_email_layout . DS . 'params.php' ) ) {
					
					include_once $system_views_path . $submitters_email_layout . DS . 'params.php';
					
				}
				
			}
			else if ( file_exists( $theme_views_path . $submitters_email_layout . DS . 'params.xml' ) ) {
				
				$submitters_layout_params = get_params_spec_from_xml( $theme_views_path . $submitters_email_layout . DS . 'params.xml' );
				
				if ( file_exists( $theme_views_path . $submitters_email_layout . DS . 'params.php' ) ) {
					
					include_once $theme_views_path . $submitters_email_layout . DS . 'params.php';
					
				}
				
			}
			
			if ( check_var( $params ) AND check_var( $submitters_layout_params ) ) {
			
				$params[ 'params_spec_values' ] = array_merge_recursive( $params[ 'params_spec_values' ], $submitters_layout_params[ 'params_spec_values' ] );
				
				foreach( $params[ 'params_spec' ][ 'ud_ds_emails_for_submitters' ] as $k => $v ) {
					
					if ( $v[ 'name' ] == 'sfsmr_layout_view' ) {
						
						array_push_pos( $params[ 'params_spec' ][ 'ud_ds_emails_for_submitters' ], $submitters_layout_params[ 'params_spec' ][ 'ud_ds_emails_for_submitters' ], $k + 1 );
						
						break;
						
					}
					
				}
				
			}
			
			//echo '<pre>' . print_r( $params, TRUE ) . '</pre>';
			
		}
		
		// Submitters layout specific params
		// ------------------------------------
		
		
		// ------------------------------------
		// Export layout specific params
		
		$export_layout = check_var( $current_params_values[ 'ud_data_export_layout_view' ] ) ? $current_params_values[ 'ud_data_export_layout_view' ] : ( check_var( $params[ 'params_spec_values' ][ 'ud_data_export_layout_view' ] ) ? $params[ 'params_spec_values' ][ 'ud_data_export_layout_view' ] : FALSE );
		
			$system_views_path = ADMIN_COMPONENTS_VIEWS_PATH . 'submit_forms' . DS . 'export' . DS . 'ud_data' . DS;
			$theme_views_path = THEMES_PATH . admin_theme_components_views_path() . 'submit_forms' . DS . 'export' . DS . 'ud_data' . DS;
			
			// carregando os layouts do tema atual
			$export_layouts_options = dir_list_to_array( $system_views_path );
			// carregando os layouts do diretório de views padrão
			$export_layouts_options = array_merge( $export_layouts_options, dir_list_to_array( $theme_views_path ) );
			
// 			echo '<pre>' . print_r( $export_layouts_options, TRUE ) . '</pre>'; exit;
			
		if ( $export_layout ) {
			
			if ( file_exists( $system_views_path . $export_layout . DS . 'params.xml' ) ) {
				
				$export_layout_params = get_params_spec_from_xml( $system_views_path . $export_layout . DS . 'params.xml' );
				
				if ( file_exists( $system_views_path . $export_layout . DS . 'params.php' ) ) {
					
					include_once $system_views_path . $export_layout . DS . 'params.php';
					
				}
				
			}
			else if ( file_exists( $theme_views_path . $export_layout . DS . 'params.xml' ) ) {
				
				$export_layout_params = get_params_spec_from_xml( $theme_views_path . $export_layout . DS . 'params.xml' );
				
				if ( file_exists( $theme_views_path . $export_layout . DS . 'params.php' ) ) {
					
					include_once $theme_views_path . $export_layout . DS . 'params.php';
					
				}
				
			}
			
			if ( check_var( $params ) AND check_var( $export_layout_params ) ) {
			
				$params[ 'params_spec_values' ] = array_merge_recursive( $params[ 'params_spec_values' ], $export_layout_params[ 'params_spec_values' ] );
				
				$current_section = 'ud_export_params';
				foreach( $params[ 'params_spec' ][ $current_section ] as $k => $v ) {
					
					if ( $v[ 'name' ] == 'ud_data_export_layout_view' ) {
						
						$spec_options = array();
						
						if ( isset( $params[ 'params_spec' ][ $current_section ][ $k ][ 'options' ] ) )
							$spec_options = $params[ 'params_spec' ][ $current_section ][ $k ][ 'options' ];
							
						$params[ 'params_spec' ][ $current_section ][ $k ][ 'options' ] = is_array( $spec_options ) ? $spec_options + $export_layouts_options : $export_layouts_options;
						
						array_push_pos( $params[ 'params_spec' ][ $current_section ], $export_layout_params[ 'params_spec' ][ $current_section ], $k + 1 );
						
						break;
						
					}
					
				}
				
			}
			
		}
		
		// Receivers layout specific params
		// ------------------------------------
		
		// print_r($params);

		//------------------------------------------------------
		
		$new_params = array();
		
		$layout = ( isset( $current_params_values[ 'ud_d_detail_layout_site' ] ) AND $current_params_values[ 'ud_d_detail_layout_site' ] != 'global' ) ? $current_params_values[ 'ud_d_detail_layout_site' ] : 'default';
		
		$system_views_path = VIEWS_PATH . SITE_COMPONENTS_VIEWS_PATH . 'submit_forms' . DS . 'index' . DS . 'ud_data_detail' . DS;
		$theme_views_path = THEMES_PATH . site_theme_components_views_path() . 'submit_forms' . DS . 'index' . DS . 'ud_data_detail' . DS;
		
		if ( file_exists( $system_views_path . $layout . DS . 'params.php' ) ) {
			
			include_once $system_views_path . $layout . DS . 'params.php';
			
		}
		else if ( file_exists( $theme_views_path . $layout . DS . 'params.php' ) ) {
			
			include_once $theme_views_path . $layout . DS . 'params.php';
			
		}
		
		array_push_pos( $params[ 'params_spec' ][ 'ud_params_section_d_detail_params' ], $new_params, 1  );
		
		return $params;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Parse a user submit data
	 *
	 * @access public
	 * @param array
	 * @param bool | determines whether the parameters should be filtered
	 * @return mixed
	 */
	
	public function parse_sf( & $sf = NULL, $filter_params = FALSE ){
		
		$errors = FALSE;
		
		reset( $sf );
		if ( is_array( $sf ) AND is_numeric( key( $sf ) ) ) {
			
			while ( list( $key, $item ) = each( $sf ) ) {
				
				if ( key_exists( 'id', $item ) ) {
					
					$this->parse_sf( $item );
					
				}
				
			}
			
			/*
			foreach ( $sf as $key => $item ) {
				
				if ( key_exists( 'id', $item ) ) {
					
					$this->parse_sf( $item );
					
				}
				
			}
			*/
		}
		
		if ( is_array( $sf ) AND key_exists( 'id', $sf ) ){
			
			
			$_ds_menu_item = NULL;
			$_dl_menu_item = NULL;
			
			$menu_item = NULL;
			
			$sf[ 'site_link' ] = $this->unid->get_link(
				
				array (
					
					'url_alias' => 'site_add_data',
					'ds' => $sf,
					
				)
				
			);
			
			// Data submit menu item
			// -------------------------------------------------
			
			// -------------------------------------------------
			// Data list menu item
			
			$sf[ 'data_list_site_link' ] = $this->unid->get_link(
				
				array (
					
					'url_alias' => 'site_data_list',
					'ds' => $sf,
					
				)
				
			);
			
			// Data list menu item
			// -------------------------------------------------
			
			
			
			
			
			
			$sf[ 'params' ] = get_params( $sf[ 'params' ] );
			
			if ( $filter_params ) {
				
				// obtendo os parâmetros globais do componente
				$component_params = $this->mcm->get_component( 'submit_forms' );
				$component_params = $component_params[ 'params' ];
				
				$params = array();
				
				$sf[ 'params' ] = filter_params( $component_params, $sf[ 'params' ] );
				
				if ( $_ds_menu_item ){
					
					$sf[ 'params' ] = filter_params( $sf[ 'params' ], $_ds_menu_item[ 'params' ] );
					
					// -------------------------------------------------
					// 
					
					// 
					// -------------------------------------------------
					
				}
				
				if ( $_dl_menu_item ){
					
					$sf[ 'params' ] = filter_params( $sf[ 'params' ], $_dl_menu_item[ 'params' ] );
					
					// -------------------------------------------------
					// 
					
					// 
					// -------------------------------------------------
					
				}
				
			}
			
			$sf[ 'fields' ] = get_params( $sf[ 'fields' ], TRUE );
			
			$sf[ 'edit_link' ] = ADMIN_ALIAS . '/' . $this->component_name . '/sfm/' . $this->uri->assoc_to_uri(
				
				array(
					
					'a' => 'esf',
					'sfid' => $sf[ 'id' ],
					
				)
				
			);
			
			$sf[ 'users_submits_link' ] = ADMIN_ALIAS . '/' . $this->component_name . '/usm/' . $this->uri->assoc_to_uri(
				
				array(
					
					'a' => 'usl',
					'sfid' => $sf[ 'id' ],
					
				)
				
			);
			
			$sf[ 'remove_link' ] = ADMIN_ALIAS . '/' . $this->component_name . '/sfm/' . $this->uri->assoc_to_uri(
				
				array(
					
					'a' => 'rds',
					'sfid' => $sf[ 'id' ],
					
				)
				
			);
			
			$_fields = array();
			
			$sf[ 'ud_image_prop' ] = NULL;
			
			reset( $sf[ 'fields' ] );
			
			while ( list( $k, $prop ) = each( $sf[ 'fields' ] ) ) {
				
				if ( ! check_var( $prop[ 'key' ] ) ) {
					
					unset( $sf[ 'fields' ][ $k ] );
					//$prop[ 'alias' ] = isset( $prop[ 'alias' ] ) ? $prop[ 'alias' ] : $this->make_field_name( $prop[ 'label' ] );
					
				}
				else {
					
					if ( empty( $prop[ 'label' ] ) ) {
						
						if ( isset( $prop[ 'presentation_label' ] ) ) {
							
							$prop[ 'label' ] = $prop[ 'presentation_label' ];
							
						}
						else {
							
							$prop[ 'label' ] = lang( 'field' ) . ' ' . $prop[ 'key' ];
							
						}
						
					}
					
					if ( empty( $prop[ 'presentation_label' ] ) ) {
						
						if ( isset( $prop[ 'label' ] ) ) {
							
							$prop[ 'presentation_label' ] = $prop[ 'label' ];
							
						}
						else {
							
							$prop[ 'presentation_label' ] = lang( 'field' ) . ' ' . $prop[ 'key' ];
							
						}
						
					}
					
					if ( empty( $prop[ 'alias' ] ) ) {
						
						if ( isset( $prop[ 'label' ] ) ) {
							
							$prop[ 'alias' ] = $this->make_field_name( $prop[ 'label' ] );
							
						}
						else {
							
							$prop[ 'alias' ] = $this->make_field_name( lang( 'field' ) . ' ' . $prop[ 'key' ] );
							
						}
						
					}
					
					// -------------------------------------------------
					// Properties types
					
					if ( isset( $prop[ 'advanced_options' ][ 'prop_is_ud_image' ] ) ) {
						
						$sf[ 'ud_image_prop' ][ $prop[ 'alias' ] ] = 1;
						
					}
					
					if ( isset( $prop[ 'advanced_options' ][ 'prop_is_ud_title' ] ) ) {
						
						$sf[ 'ud_title_prop' ][ $prop[ 'alias' ] ] = 1;
						
					}
					
					if ( isset( $prop[ 'advanced_options' ][ 'prop_is_ud_content' ] ) ) {
						
						$sf[ 'ud_content_prop' ][ $prop[ 'alias' ] ] = 1;
						
					}
					
					if ( isset( $prop[ 'advanced_options' ][ 'prop_is_ud_other_info' ] ) ) {
						
						$sf[ 'ud_other_info_prop' ][ $prop[ 'alias' ] ] = 1;
						
					}
					
					if ( isset( $prop[ 'advanced_options' ][ 'prop_is_ud_status' ] ) ) {
						
						$sf[ 'ud_status_prop' ][ $prop[ 'alias' ] ] = 1;
						
					}
					
					if ( isset( $prop[ 'advanced_options' ][ 'prop_is_ud_event_datetime' ] ) ) {
						
						$sf[ 'ud_event_datetime_prop' ][ $prop[ 'alias' ] ] = 1;
						
					}
					
					// Properties types
					// -------------------------------------------------
					
					$_fields[ $prop[ 'alias' ] ] = $prop;
					
				}
				
			}
			
			$sf[ 'fields' ] = $_fields;
			
			array_unshift( $sf[ 'fields' ], NULL );
			
			unset( $sf[ 'fields' ][ 0 ] );
			unset( $_fields );
			
		}
		
		if ( ! $errors ) {
			
			return TRUE;
			
		}
		else if ( $errors ) {
			
			return $errors;
			
		}
		
	}
	
	// --------------------------------------------------------------------
	
	public function get_user_submit( $id, $submit_form_id = NULL, $ignore_cache = FALSE ) {
		
		$search_config = array(
			
			'plugins' => 'sf_us_search',
			'ignore_cache' => $ignore_cache,
			'allow_empty_terms' => TRUE,
			'ipp' => 1,
			'cp' => 1,
			'plugins_params' => array(
				
				'sf_us_search' => array(
					
					'us_id' => $id,
					'sf_id' => $submit_form_id,
					
				),
				
			),
			
		);
		
		$this->load->library( 'search' );
		$this->search->config( $search_config );
		
		$user_submit = $this->search->get_full_results( 'sf_us_search', TRUE );
		
		if ( isset( $user_submit[ 0 ] ) ) {
			
			return $user_submit[ 0 ];
			
		}
		else {
			
			return FALSE;
			
		}
		
	}
	
	// --------------------------------------------------------------------
	
	public function get_users_submits( $f_params = NULL ){
		
		// atribuindo valores às variávies
		$where_condition =						isset( $f_params[ 'where_condition' ] ) ? $f_params[ 'where_condition' ] : NULL;
		$or_where_condition =					isset( $f_params[ 'or_where_condition' ] ) ? $f_params[ 'or_where_condition' ] : NULL;
		$ipp =									isset( $f_params[ 'ipp' ] ) ? $f_params[ 'ipp' ] : NULL;
		$cp =									isset( $f_params[ 'cp' ] ) ? $f_params[ 'cp' ] : NULL;
		$order_by =								isset( $f_params[ 'order_by' ] ) ? $f_params[ 'order_by' ] : 't1.title asc, t1.id asc';
		$order_by_direction =					isset( $f_params[ 'order_by_direction' ] ) ? $f_params[ 'order_by_direction' ] : 'ASC';
		$order_by_escape =						isset( $f_params[ 'order_by_escape' ] ) ? $f_params[ 'order_by_escape' ] : TRUE;
		$return_type =							isset( $f_params[ 'return_type' ] ) ? $f_params[ 'return_type' ] : 'get';
		$random =								check_var( $f_params[ 'random' ] ) ? TRUE : FALSE;
		$has_image_first =						check_var( $f_params[ 'has_image_first' ] ) ? TRUE : FALSE;
		$terms =								isset( $f_params[ 'terms' ] ) ? $f_params[ 'terms' ] : NULL;
		
		// user submit id
		$us_id =								isset( $f_params[ 'us_id' ] ) ? $f_params[ 'us_id' ] : ( isset( $f_params[ 'id' ] ) ? $f_params[ 'id' ] : ( isset( $f_params[ 'user_submit_id' ] ) ? $f_params[ 'user_submit_id' ] : NULL ) );
		$sf_id =								isset( $f_params[ 'sf_id' ] ) ? $f_params[ 'sf_id' ] : ( isset( $f_params[ 'submit_form_id' ] ) ? $f_params[ 'submit_form_id' ] : NULL );
		
		$search_config = array(
			
			'plugins' => 'sf_us_search',
			'ipp' => $ipp,
			'cp' => $cp,
			'allow_empty_terms' => TRUE,
			'plugins_params' => array(
				
				'sf_us_search' => array(
					
					'order_by' => $order_by,
					'order_by_direction' => $order_by_direction,
					'order_by_escape' => $order_by_escape,
					'us_id' => $us_id,
					'sf_id' => $sf_id,
					
				),
				
			),
			
		);
		
		$this->load->library( 'search' );
		$this->search->config( $search_config );
		
		$users_submits = $this->search->get_full_results( 'sf_us_search', TRUE );
		
		return $users_submits;
		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get formated fied name
	 *
	 * @access public
	 * @param string
	 * @return string
	 */
	
	public function make_field_name( $label ){
		
		return url_title( $label, '-', TRUE );
		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Parse a user submit data
	 *
	 * @access public
	 * @param array
	 * @param bool | determines whether the parameters should be filtered
	 * @return void
	 */
	
	public function parse_us( & $us = NULL, $filter_params = FALSE, $menu_item_id = 0 ){
		
		if ( ! $menu_item_id ) $menu_item_id = 0;
		
		if ( is_array( $us ) AND is_numeric( key( $us ) ) ) {
			
			reset( $us );
			
			while ( list( $key, $item ) = each( $us ) ) {
				
				if ( key_exists( 'id', $item ) ) {
					
					$this->parse_us( $item );
					
				}
				
			}
			
		}
		
		if ( is_array( $us ) AND key_exists( 'id', $us ) ){
			
			if ( $filter_params ) {
				
				// obtendo os parâmetros globais do componente
				$component_params = $this->mcm->get_component( 'submit_forms' );
				$component_params = $component_params[ 'params' ];
				
				// obtendo os parâmetros do item de menu
				if ( $this->mcm->current_menu_item ){
					
					$menu_item_params = get_params( $this->mcm->current_menu_item[ 'params' ] );
					$params = filter_params( $component_params, $menu_item_params );
					
				}
				else{
					
					$params = $component_params;
					
				}
				$us[ 'params' ] = filter_params( $params, get_params( $us[ 'params' ] ) );
				
			}
			else {
				
				$us[ 'params' ] = get_params( $us[ 'params' ] );
				
			}
			
			$us[ 'data' ] = get_params( $us[ 'data' ] );
			
			$us[ 'site_link' ] = $this->unid->menu_item_get_link_ud_data_detail( $menu_item_id, array( 'ud_data_id' => $us[ 'id' ] ) );
			
		}
		
	}
	
	// --------------------------------------------------------------------
	
	public function insert_user_submit( $data = NULL ){
		
		if ( isset( $data[ 'data' ] ) ) {
			
			$data[ 'xml_data' ] = $this->us_json_data_to_xml( $data );
			
		}
		
		if ( $data != NULL AND is_array( $data ) ){
			
			if ( $this->db->insert( 'tb_submit_forms_us', $data ) ){
				
				$return_id = $this->db->insert_id();
				
				return $return_id;
				
			}
			
		}
		
		log_message( 'error', '[Submit forms] Error attempting to insert submit record!' );
		
		return FALSE;
		
	}
	
	// --------------------------------------------------------------------
	
	public function update_user_submit( $data = NULL, $condition = NULL ){
		
		if ( $data != NULL && $condition != NULL ){
			
			if ( isset( $data[ 'data' ] ) ) {
				
				$data[ 'xml_data' ] = $this->us_json_data_to_xml( $data );
				
			}
			
			// detecting values differences
			
			if ( isset( $data[ 'id' ] ) ) {
				
				$_d_id = $data[ 'id' ];
				
				unset( $data[ 'id' ] );
				
				$current_data = $this->get_user_submit( $_d_id, NULL, TRUE );
				
				$d_data = get_params( $data[ 'data' ] );
				
				foreach( $d_data as $alias => $value ) {
					
					if ( isset( $current_data[ 'data' ][ $alias ] ) AND $current_data[ 'data' ][ $alias ] !== $d_data[ $alias ] ) {
						
						$diff[] = $alias;
						
					}
					
				}
				
			}
			
			if ( $this->db->update( 'tb_submit_forms_us', $data, $condition ) ){
				
				if ( isset( $diff ) ) {
					
					$data[ 'id' ] = $_d_id;
					
					foreach( $diff as $changed_prop_alias ) {
						
						$this->adjust_referenced_data( $data, $changed_prop_alias );
						
					}
					
				}
				
				// confirm update for controller
				return TRUE;
				
			}
			else {
				
				// case update fails, return false
				return FALSE;
				
			}
			
		}
		
	}
	
	// --------------------------------------------------------------------
	
	public function remove_user_submit( $id = NULL ){
		
		if ( $id ) {
			
			if ( $this->db->delete( 'tb_submit_forms_us', array( 'id' => $id ) ) ){
				
				return TRUE;
				
			}
			
		}
		
		return FALSE;
		
	}
	
	// --------------------------------------------------------------------
	
	public function us_json_data_to_xml( $us ){
		
		$us_data = $us[ 'data' ];
		
		if ( is_string( $us_data ) ) {
			
			$us_data = get_params( $us_data );
			
		}
		
		//echo '<pre>' . print_r( $us_data, TRUE ) . '</pre>';
		
		if ( is_array( $us_data ) ) {
			
			$xml = '<?xml version="1.0" encoding="UTF-8" ?>';
			
			// get submit form params
			$gsfp = array(
				
				'where_condition' => 't1.id = ' . $us[ 'submit_form_id' ],
				'limit' => 1,
				
			);
			
			$submit_form = $this->get_submit_forms( $gsfp )->row_array();
			
			if ( ! $submit_form ) {
				
				return NULL;
				
			}
			
			$this->sfcm->parse_sf( $submit_form, TRUE );
			
			$fields = $submit_form[ 'fields' ];
			
			reset( $us_data );
			
			while ( list( $alias, $value ) = each( $us_data ) ) {
				
				reset( $fields );
				
				while ( list( $k, $field ) = each( $fields ) ) {
					
					if ( ! isset( $field[ 'field_type' ] ) ) { continue; }
					
					if ( $field[ 'alias' ] == $alias  ) {
						
						if ( $field[ 'field_type' ] == 'date' ){
							
							$___date = explode( '-', $value );
							
							$format = '';
							
							$use_y = check_var( $field[ 'sf_date_field_use_year' ] ) ? TRUE : FALSE;
							$use_m = check_var( $field[ 'sf_date_field_use_month' ] ) ? TRUE : FALSE;
							$use_d = check_var( $field[ 'sf_date_field_use_day' ] ) ? TRUE : FALSE;
							
							$format .= ( $use_y AND isset( $___date[ 0 ] ) AND ( int ) $___date[ 0 ] > 0 ) ? 'y' : '';
							$format .= ( $use_m AND isset( $___date[ 1 ] ) AND ( int ) $___date[ 1 ] > 0 ) ? 'm' : '';
							$format .= ( $use_d AND isset( $___date[ 2 ] ) AND ( int ) $___date[ 2 ] > 0 ) ? 'd' : '';
							
							$___date[ 0 ] = ( int ) $___date[ 0 ] > 0 ? $___date[ 0 ] : '2000';
							$___date[ 1 ] = ( int ) $___date[ 1 ] > 1 ? $___date[ 1 ] : '01';
							$___date[ 2 ] = ( int ) $___date[ 2 ] > 2 ? $___date[ 2 ] : '01';
							
							$value = $___date[ 0 ] . '-' . $___date[ 1 ] . '-' . $___date[ 2 ];
							
							if ( ! empty( $format ) ) {
								
								$format = 'sf_us_dt_ft_pt_' . $format . '_' . $field[ 'sf_date_field_presentation_format' ];
								
								$value =  ov_strftime( lang( $format ), strtotime( $value ) );
								
							}
							else {
								
								$value =  '';
								
							}
							
						}
						else if ( in_array( $field[ 'field_type' ], array( 'combo_box', 'radiobox', 'checkbox', ) ) ) {
							
							if ( ! is_array( $value ) ) {
								
								$__tmp = @json_decode( $value, TRUE );
								
								if ( is_array( $__tmp ) ) {
									
									$value = $__tmp;
									
								}
								
							}
							
							if ( is_array( $value ) ) {
								
								if ( count( $value ) == 1 ) {
									
									$value = $value[ 0 ];
									
									if ( check_var( $fields[ $alias ][ 'options_from_users_submits' ] ) AND ( check_var( $fields[ $alias ][ 'options_title_field' ] ) OR check_var( $fields[ $alias ][ 'options_title_field_custom' ] ) ) AND is_numeric( $value ) AND $_user_submit = $this->sfcm->get_user_submit( $value ) ) {
										
										$this->ud_api->parse_ud_data( $_user_submit, NULL, TRUE );
										
										$value = isset( $_user_submit[ 'parsed_data' ][ 'full' ][ $fields[ $alias ][ 'options_title_field' ] ][ 'value' ] ) ? $_user_submit[ 'parsed_data' ][ 'full' ][ $fields[ $alias ][ 'options_title_field' ] ][ 'value' ] : $_user_submit[ 'id' ];
										
									}
									else {
										
										if ( in_array( $fields[ $alias ][ 'field_type' ], array( 'checkbox', 'radiobox' ) ) AND ! check_var( $fields[ $alias ][ 'options' ] ) AND ( $value == '1' OR $value == '' ) ) {
											
											if ( check_var( $value ) ) {
												
												$value = lang( 'yes' );
												
											}
											else {
												
												$value = lang( 'no' );
												
											}
											
										}
										
									}
									
								}
								else {
									
									$_field_value = array();
									
									foreach ( $value as $k => $v ) {
										
										if ( is_string( $v ) ) {
											
											if ( check_var( $fields[ $alias ][ 'options_from_users_submits' ] ) AND ( check_var( $fields[ $alias ][ 'options_title_field' ] ) OR check_var( $fields[ $alias ][ 'options_title_field_custom' ] ) ) AND is_numeric( $v ) AND $_user_submit = $this->sfcm->get_user_submit( $v ) ) {
												
												$this->ud_api->parse_ud_data( $_user_submit, NULL, TRUE );
												
												$v = isset( $_user_submit[ 'parsed_data' ][ 'full' ][ $fields[ $alias ][ 'options_title_field' ] ][ 'value' ] ) ? $_user_submit[ 'parsed_data' ][ 'full' ][ $fields[ $alias ][ 'options_title_field' ] ][ 'value' ] : $_user_submit[ 'id' ];
												
											}
											
											$_field_value[] = $v;
											
										}
										
									}
									
									$value = join( ', ', $_field_value );
									
								}
								
							}
							else {
								
								if ( check_var( $fields[ $alias ][ 'options_from_users_submits' ] ) AND ( check_var( $fields[ $alias ][ 'options_title_field' ] ) OR check_var( $fields[ $alias ][ 'options_title_field_custom' ] ) ) AND is_numeric( $value ) AND $_user_submit = $this->get_user_submit( $value, NULL, TRUE ) ) {
									
									$this->ud_api->parse_ud_data( $_user_submit, NULL, TRUE );
									
									$value = isset( $_user_submit[ 'parsed_data' ][ 'full' ][ $fields[ $alias ][ 'options_title_field' ] ][ 'value' ] ) ? $_user_submit[ 'parsed_data' ][ 'full' ][ $fields[ $alias ][ 'options_title_field' ] ][ 'value' ] : $_user_submit[ 'id' ];
									
								}
								
							}
							
						}
						
					}
					
				}
				
				$xml .= '<' . $alias . '>';
				$xml .= strip_tags( html_entity_decode( $value ) );
				$xml .= '</' . $alias . '>' . "\n";
				
			}
			
			/*
			foreach ( $us_data as $alias => & $value ) {
				
				foreach( $fields as $k => & $field ) {
					
					if ( ! isset( $field[ 'field_type' ] ) ) { continue; }
					
					if ( $field[ 'alias' ] == $alias  ) {
						
						if ( $field[ 'field_type' ] == 'date' ){
							
							$___date = explode( '-', $value );
							
							$format = '';
							
							$use_y = check_var( $field[ 'sf_date_field_use_year' ] ) ? TRUE : FALSE;
							$use_m = check_var( $field[ 'sf_date_field_use_month' ] ) ? TRUE : FALSE;
							$use_d = check_var( $field[ 'sf_date_field_use_day' ] ) ? TRUE : FALSE;
							
							$format .= ( $use_y AND isset( $___date[ 0 ] ) AND ( int ) $___date[ 0 ] > 0 ) ? 'y' : '';
							$format .= ( $use_m AND isset( $___date[ 1 ] ) AND ( int ) $___date[ 1 ] > 0 ) ? 'm' : '';
							$format .= ( $use_d AND isset( $___date[ 2 ] ) AND ( int ) $___date[ 2 ] > 0 ) ? 'd' : '';
							
							$___date[ 0 ] = ( int ) $___date[ 0 ] > 0 ? $___date[ 0 ] : '2000';
							$___date[ 1 ] = ( int ) $___date[ 1 ] > 1 ? $___date[ 1 ] : '01';
							$___date[ 2 ] = ( int ) $___date[ 2 ] > 2 ? $___date[ 2 ] : '01';
							
							$value = $___date[ 0 ] . '-' . $___date[ 1 ] . '-' . $___date[ 2 ];
							
							if ( ! empty( $format ) ) {
								
								$format = 'sf_us_dt_ft_pt_' . $format . '_' . $field[ 'sf_date_field_presentation_format' ];
								
								$value =  strftime( lang( $format ), strtotime( $value ) );
								
							}
							else {
								
								$value =  '';
								
							}
							
						}
						else if ( in_array( $field[ 'field_type' ], array( 'combo_box', 'radiobox', 'checkbox', ) ) AND check_var( $field[ 'options_from_users_submits' ] ) ) {
							
							$__tmp = @json_decode( $value, TRUE );
							
							if ( is_array( $__tmp ) OR is_array( $value ) ) {
								
								if ( is_array( $__tmp ) ) {
									
									$value = $__tmp;
									
								}
								
								if ( count( $value ) == 1 ) {
									
									$value = $value[ 0 ];
									
									if ( check_var( $fields[ $alias ][ 'options_from_users_submits' ] ) AND ( check_var( $fields[ $alias ][ 'options_title_field' ] ) OR check_var( $fields[ $alias ][ 'options_title_field_custom' ] ) ) AND is_numeric( $value ) AND $_user_submit = $this->sfcm->get_user_submit( $value ) ) {
										
										$value = isset( $_user_submit[ 'data' ][ $fields[ $alias ][ 'options_title_field' ] ] ) ? $_user_submit[ 'data' ][ $fields[ $alias ][ 'options_title_field' ] ] : $_user_submit[ 'id' ];
										
									}
									else {
										
										if ( in_array( $fields[ $alias ][ 'field_type' ], array( 'checkbox', 'radiobox' ) ) AND ! check_var( $fields[ $alias ][ 'options' ] ) AND ( $value == '1' OR $value == '' ) ) {
											
											if ( check_var( $value ) ) {
												
												$value = lang( 'yes' );
												
											}
											else {
												
												$value = lang( 'no' );
												
											}
											
										}
										
									}
									
								}
								else {
									
									$_field_value = array();
									
									foreach ( $value as $k => $v ) {
										
										if ( is_string( $v ) ) {
											
											if ( check_var( $fields[ $alias ][ 'options_from_users_submits' ] ) AND ( check_var( $fields[ $alias ][ 'options_title_field' ] ) OR check_var( $fields[ $alias ][ 'options_title_field_custom' ] ) ) AND is_numeric( $v ) AND $_user_submit = $this->sfcm->get_user_submit( $v ) ) {
												
												$v = isset( $_user_submit[ 'data' ][ $fields[ $alias ][ 'options_title_field' ] ] ) ? $_user_submit[ 'data' ][ $fields[ $alias ][ 'options_title_field' ] ] : $_user_submit[ 'id' ];
												
											}
											
											$_field_value[] = $v;
											
										}
										
									}
									
									$value = join( ', ', $_field_value );
									
								}
								
							}
							else {
								
								if ( check_var( $fields[ $alias ][ 'options_from_users_submits' ] ) AND ( check_var( $fields[ $alias ][ 'options_title_field' ] ) OR check_var( $fields[ $alias ][ 'options_title_field_custom' ] ) ) AND is_numeric( $value ) AND $_user_submit = $this->get_user_submit( $value, NULL, TRUE ) ) {
									
									$value = isset( $_user_submit[ 'data' ][ $fields[ $alias ][ 'options_title_field' ] ] ) ? $_user_submit[ 'data' ][ $fields[ $alias ][ 'options_title_field' ] ] : $_user_submit[ 'id' ];
									
								}
								
							}
							
						}
						
					}
					
				}
				
				$xml .= '<' . $alias . '>';
				$xml .= strip_tags( html_entity_decode( $value ) );
				$xml .= '</' . $alias . '>' . "\n";
				
				
			}
			*/
			
			return $xml;
			
		}
		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Scan all data seeking referenced properties and adjusts its values
	 *
	 * @access public
	 * @return array
	 */
	
	public function adjust_referenced_data( $data, $changed_prop_alias ) {
		
		// We select data schemes that use the property of this data as reference
		
		$this->db->select( 'id' );
		$this->db->from( 'tb_submit_forms' );
		$this->db->where( '`fields` LIKE \'%"options_from_users_submits":"' . $data[ 'submit_form_id' ] . '"%\' COLLATE \'utf8_general_ci\'' );
		
		$where = '(';
		$where .= '`fields` LIKE \'%"options_title_field":"' . $changed_prop_alias . '"%\' COLLATE \'utf8_general_ci\' OR ';
		$where .= '`fields` LIKE \'%"options_filter_order_by":"' . $changed_prop_alias . '"%\' COLLATE \'utf8_general_ci\'';
		$where .= ')';
		
		$this->db->where( $where );
		
		$ds_ids = $this->db->get()->result_array();
		
		if ( $ds_ids ) {
			
			$this->db->select( '
				
				id,
				submit_form_id,
				data
				
			' );
			$this->db->from( 'tb_submit_forms_us' );
			
			$where_1 = array();
			
			reset( $ds_ids );
			
			while ( list( $k, $value ) = each( $ds_ids ) ) {
				
				$id = $value[ 'id' ];
				
				$where_1[] = '`submit_form_id` = ' . $id;
				
			}
			
			/*
			foreach( $ds_ids as $value ) {
				
				$id = $value[ 'id' ];
				
				$where_1[] = '`submit_form_id` = ' . $id;
				
			}
			*/
			
			$where_1 = '(' . join( ' OR ', $where_1 ) . ')';
			
			// ----------------
			
			$where_2 = array();
			
			$where_2[] = '`data` LIKE \'%"%":["' . $data[ 'id' ] . '"]%\' COLLATE \'utf8_general_ci\'';
			$where_2[] = '`data` LIKE \'%"%":["' . $data[ 'id' ] . '","%]%\' COLLATE \'utf8_general_ci\'';
			$where_2[] = '`data` LIKE \'%"%":[%","' . $data[ 'id' ] . '"]%\' COLLATE \'utf8_general_ci\'';
			$where_2[] = '`data` LIKE \'%"%":[%","' . $data[ 'id' ] . '","%]%\' COLLATE \'utf8_general_ci\'';
			$where_2[] = '`data` LIKE \'%"%":"' . $data[ 'id' ] . '"%\' COLLATE \'utf8_general_ci\'';
			
			$where_2 = '(' . join( ' OR ', $where_2 ) . ')';
			
			$where = $where_1 . ' AND ' . $where_2;
			
			$this->db->where( $where );
			
			$data_results = $this->db->get()->result_array();
			
			if ( $data_results ) {
				
				reset( $data_results );
				
				while ( list( $k, $_data ) = each( $data_results ) ) {
					
					$_data[ 'xml_data' ] = $this->us_json_data_to_xml( $_data );
					
					$_d_id = $_data[ 'id' ];
					
					unset( $_data[ 'id' ] );
					
					if ( ! $this->db->update( 'tb_submit_forms_us', $_data, array( 'id' => $_d_id ) ) ){
						
						msg( lang( $data[ 'params' ][ 'ud_data_update_fail_referenced_data' ], NULL, $data[ 'id' ] ), 'error' );
						
					}
					
				}
				
				/*
				foreach( $data_results as $_data ) {
					
					$_data[ 'xml_data' ] = $this->us_json_data_to_xml( $_data );
					
					$_d_id = $_data[ 'id' ];
					
					unset( $_data[ 'id' ] );
					
					if ( ! $this->db->update( 'tb_submit_forms_us', $_data, array( 'id' => $_d_id ) ) ){
						
						msg( lang( $data[ 'params' ][ 'ud_data_update_fail_referenced_data' ], NULL, $data[ 'id' ] ), 'error' );
						
					}
					
				}
				*/
				
			}
			
		}
		
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Get the current url params and return the params allowed
	 *
	 * @access public
	 * @return array
	 */
	
	public function get_us_url_params() {
		
		$url_params = $this->uri->ruri_to_assoc();
		
		$allowed_actions = array(
			
			'l', // List
			'd', // Detail
			'a', // Add
			'e', // Edit
			'r', // Remove
			'cob', // Change order by
			'b', // Batch
			
		);
		
		if ( isset( $url_params[ 'a' ] ) AND ! in_array( $url_params[ 'a' ], $allowed_actions ) ) {
			
			exit( lang( 'unknow_action' ) );
			
		}
		
		$params[ 'action' ] =									isset( $url_params[ 'a' ] ) ? $url_params[ 'a' ] : 'l'; // action
		$params[ 'sub_action' ] =								isset( $url_params[ 'sa' ] ) ? $url_params[ 'sa' ] : NULL; // sub action
		$params[ 'layout' ] =									isset( $url_params[ 'l' ] ) ? $url_params[ 'l' ] : 'default'; // layout
		
		
		$params[ 'submit_form_id' ] =							isset( $url_params[ 'sfid' ] ) ? $url_params[ 'sfid' ] : NULL; // submit form id(s)
		
		// Adjusting the submit form id or ids
		if ( strpos( $params[ 'submit_form_id' ] , ',' ) ) {
			
			$params[ 'submit_form_id' ]  = explode( ',', $params[ 'submit_form_id' ] );
			
		}
		else {
			
			$params[ 'submit_form_id' ]  = array( $params[ 'submit_form_id' ] );
			
		}
		
		reset( $params[ 'submit_form_id' ] );
		
		while ( list( $k, $sfid ) = each( $params[ 'submit_form_id' ] ) ) {
			
			if ( ! ( $sfid AND is_numeric( $sfid ) AND is_int( $sfid + 0 ) ) ) {
				
				unset( $params[ 'submit_form_id' ][ $k ] );
				
			}
			
		}
		
		/*
		foreach( $params[ 'submit_form_id' ] as $k => $sfid ) {
			
			if ( ! ( $sfid AND is_numeric( $sfid ) AND is_int( $sfid + 0 ) ) ) {
				
				unset( $params[ 'submit_form_id' ][ $k ] );
				
			}
			
		}
		*/
		
		$params[ 'user_submit_id' ] =							isset( $url_params[ 'usid' ] ) ? $url_params[ 'usid' ] : NULL; // user submit id(s)
		
		// Adjusting the users submits id or ids
		if ( strpos( $params[ 'user_submit_id' ], ',' ) ) {
			
			$params[ 'user_submit_id' ] = explode( ',', $params[ 'user_submit_id' ] );
			
		}
		else {
			
			$params[ 'user_submit_id' ] = array( $params[ 'user_submit_id' ] );
			
		}
		
		reset( $params[ 'user_submit_id' ] );
		
		while ( list( $k, $usid ) = each( $params[ 'submit_form_id' ] ) ) {
			
			if ( ! ( $usid AND is_numeric( $usid ) AND is_int( $usid + 0 ) ) ) {
				
				unset( $params[ 'user_submit_id' ][ $k ] );
				
			}
			
		}
		
		/*
		foreach( $params[ 'user_submit_id' ] as $k => $usid ) {
			
			if ( ! ( $usid AND is_numeric( $usid ) AND is_int( $usid + 0 ) ) ) {
				
				unset( $params[ 'user_submit_id' ][ $k ] );
				
			}
			
		}
		*/
		
		$params[ 'current_page' ] =								isset( $url_params[ 'cp' ] ) ? $url_params[ 'cp' ] : NULL; // current page
		$params[ 'items_per_page' ] =							isset( $url_params[ 'ipp' ] ) ? $url_params[ 'ipp' ] : NULL; // items per page
		$params[ 'order_by' ] =									isset( $url_params[ 'ob' ] ) ? $url_params[ 'ob' ] : NULL; // order by
		$params[ 'order_by_direction' ] =						isset( $url_params[ 'obd' ] ) ? $url_params[ 'obd' ] : NULL; // order by direction
		$params[ 'search' ] =									isset( $url_params[ 's' ] ) ? ( int )( ( bool ) $url_params[ 's' ] ) : NULL; // search flag
		$params[ 'filters' ] =									isset( $url_params[ 'f' ] ) ? $this->unid->url_decode_ud_filters( $url_params[ 'f' ] ) : array(); // filters
		
		return $params;
		
	}
	
	// --------------------------------------------------------------------
	
}
