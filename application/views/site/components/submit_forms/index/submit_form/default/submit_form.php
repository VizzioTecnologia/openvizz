<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );
	
	$fields = array();
	
	foreach ( $submit_form[ 'fields' ] as $key => $field ) {
		
		$fields[ $field[ 'alias' ] ] = $field;
		
	}
	
	if ( check_var( $this->current_component[ 'params' ][ 'users_fields' ] ) ) {
		
		$users_fields = $this->current_component[ 'params' ][ 'users_fields' ];
		
	}
	
?>

<section class="submit-form <?= @$params['page_class']; ?>">
	
	<div id="component-content" class="submit-form-wrapper">
		
		<?php if ( check_var( $submit_form[ 'title' ] ) OR check_var( $this->mcm->html_data[ 'content' ][ 'title' ] ) ) { ?>
		<header class="component-heading">
			
			<?php
				
				$_title_1 = FALSE;
				$_title_2 = FALSE;
				
				if ( check_var( $params['submit_form_show_title'] ) AND check_var( $submit_form[ 'title' ] ) ) {
					
					$_title_1 = $submit_form[ 'title' ];
					
				}
				
				if ( check_var( $params['show_page_content_title'] ) AND check_var( $this->mcm->html_data[ 'content' ][ 'title' ] ) ) {
					
					$_title_1 = $this->mcm->html_data[ 'content' ][ 'title' ];
					
				}
				
				if ( check_var( $params['show_page_content_title'] ) AND check_var( $params['custom_page_content_title'] ) ) {
					
					$_title_1 = $params['custom_page_content_title'];
					
				}
				
				if ( check_var( $params['submit_form_show_title'] ) AND check_var( $submit_form[ 'title' ] ) AND $_title_1 != $submit_form[ 'title' ] ) {
					
					$_title_2 = $submit_form[ 'title' ];
					
				}
				
			?>
			
			<?php if ( $_title_1 ) { ?>
				
				<h1>
					
					<?= $_title_1 ; ?>
					
				</h1>
				
			<?php } ?>
			
			<?php if ( $_title_2 ) { ?>
				
				<h2>
					
					<?=  $_title_2 ; ?>
					
				</h2>
				
			<?php } ?>
			
		</header>
		<?php } ?>
		
		<?= form_open_multipart( get_url( $this->uri->ruri_string() ), array( 'id' => 'user-submit-form', ) ); ?>
			
			<?php foreach ( $fields as $key => $field ) {
				
				if ( check_var( $field[ 'availability' ][ 'site' ] ) ) {
					
					$field_name = $field[ 'alias' ];
					$formatted_field_name = 'form[' . $field_name . ']';
				
					$field_value = ( check_var( $field[ 'default_value' ] ) ) ? $field[ 'default_value' ] : NULL;
					$field_value = ( isset( $get[ $field_name ] ) ) ? $get[ $field_name ] : $field_value;
					$field_value = ( isset( $post[ 'form' ][ $field_name ] ) ) ? $post[ 'form' ][ $field_name ] : ( ( isset( $user_submit[ 'data' ][ $field_name ] ) ) ? $user_submit[ 'data' ][ $field_name ] : $field_value );
					$error = form_error( $formatted_field_name, '<span class="msg-inline-error error">', '</span>' );
					
					if ( $field[ 'field_type' ] == 'html' AND isset( $field[ 'html' ] ) ) {
					
					?><div id="container-<?= $field_name; ?>" class="<?= ( check_var( $field[ 'form_css_class' ] ) ) ? $field[ 'form_css_class' ] : ''; ?> submit-form-field-wrapper submit-form-field-wrapper-<?= $field_name; ?> submit-form-field-wrapper-<?= $field[ 'field_type' ]; ?> <?= ( $error ) ? 'form-error error' : ''; ?>">
						
						<div class="submit-form-field-control">
							
							<?= $field[ 'html' ]; ?>
							
						</div>
						
					</div><?php
					
					} else if ( $field[ 'field_type' ] == 'input_text' ) {
						
						?><div id="container-<?= $field_name; ?>" class="<?= ( check_var( $field[ 'form_css_class' ] ) ) ? $field[ 'form_css_class' ] : ''; ?> submit-form-field-wrapper submit-form-field-wrapper-<?= $field_name; ?> submit-form-field-wrapper-<?= $field[ 'field_type' ]; ?> <?= ( $error ) ? 'form-error error' : ''; ?>">
							
							<?= form_label( lang( $field[ 'label' ] ) . ( check_var( $field[ 'field_is_required' ] ) ? ' <span class="submit-form-required">*</span> ' . $error : ' ' . $error ) ); ?>
							
							<div class="submit-form-field-control">
								
								<?php
									
									if ( check_var( $field[ 'advanced_options' ][ 'prop_is_ud_file' ] ) ) {
										
										echo vui_el_input_file(
											
											array(
												
												'text' => lang( $field[ 'presentation_label' ] ),
												'id' => 'submit-form-' . $field_name,
												'name' => $formatted_field_name,
												'class' => 'form-element submit-form submit-form-' . $field_name,
												
											)
											
										);
										
										if ( check_var( $field[ 'advanced_options' ][ 'prop_is_ud_file_max_size' ] ) ) {
											
											echo '<div class="submit-form-field-description">';
											echo lang( 'ud_data_prop_ud_file_max_size_desc', NULL, format_file_size( kilobytes_to_b( $field[ 'advanced_options' ][ 'prop_is_ud_file_max_size' ] ) ) );
											echo '</div>';
											
										}
										
										if ( check_var( $field[ 'advanced_options' ][ 'prop_is_ud_file_allowed_types' ] ) ) {
											
											echo '<div class="submit-form-field-description">';
											
											$allowed_types = explode( '|', $field[ 'advanced_options' ][ 'prop_is_ud_file_allowed_types' ] );
											
											$_allowed_types = '';
											
											foreach( $allowed_types as $a_type ) {
												
												$_allowed_types[] = '.' . strtolower( trim( $a_type ) );
												
											}
											
											$allowed_types = join( ', ', $_allowed_types );
											
											echo lang( 'ud_data_prop_ud_file_allowed_types_desc', NULL, $allowed_types );
											
											echo '</div>';
											
										}
										
									}
									else {
										
										echo vui_el_input_text(
											
											array(
												
												'text' => lang( $field[ 'presentation_label' ] ),
												'id' => 'submit-form-' . $field_name,
												'value' => $field_value,
												'name' => $formatted_field_name,
												'class' => 'form-element submit-form submit-form-' . $field_name,
												
											)
											
										);
										
									}
									
								?>
								
								<?php if ( check_var( $field[ 'description' ] ) ) { ?>
								<div class="submit-form-field-description">
									
									<?= $field[ 'description' ]; ?>
									
								</div>
								<?php } ?>
								
							</div>
							
						</div><?php
						
					} else if ( in_array( $field[ 'field_type' ], array( 'combo_box', 'radiobox', 'checkbox' ) ) ) {
						
						?><div id="container-<?= $field_name; ?>" class="<?= ( check_var( $field[ 'form_css_class' ] ) ) ? $field[ 'form_css_class' ] : ''; ?> submit-form-field-wrapper submit-form-field-wrapper-<?= $field_name; ?> submit-form-field-wrapper-<?= $field[ 'field_type' ]; ?> <?= ( $error ) ? 'form-error error' : ''; ?>">
							
							<?php
								
								if ( ( in_array( $field[ 'field_type' ], array( 'radiobox', 'checkbox' ) ) AND ( check_var( $field[ 'options' ] ) OR check_var( $field[ 'options_from_users_submits' ] ) ) ) OR ! ( in_array( $field[ 'field_type' ], array( 'radiobox', 'checkbox' ) ) AND ! ( check_var( $field[ 'options' ] ) OR check_var( $field[ 'options_from_users_submits' ] ) ) ) OR ! in_array( $field[ 'field_type' ], array( 'radiobox', 'checkbox' ) ) ) {
									
									echo form_label( lang( $field[ 'label' ] ) . ( check_var( $field[ 'field_is_required' ] ) ? ' <span class="submit-form-required">*</span> ' . $error : ' ' . $error ) );
									
								}
								
								$options = array();
								
								if ( $field[ 'field_type' ] == 'combo_box' ) {
									
									$options[ '' ] = lang( 'combobox_select' );
									
								}
								
								if ( check_var( $field[ 'options_from_users_submits' ] ) AND ( check_var( $field[ 'options_title_field' ] ) OR check_var( $field[ 'options_title_field_custom' ] ) ) ) {
									
									$filters = NULL;
									
									if ( check_var( $field[ 'options_filter_site' ] ) ) {
										
										$filters = $field[ 'options_filter_site' ];
										
									}
									else if ( check_var( $field[ 'options_filter' ] ) ) {
										
										$filters = $field[ 'options_filter' ];
										
									}
									
									$search_config = array(
										
										'plugins' => 'sf_us_search',
										'allow_empty_terms' => TRUE,
										'ipp' => 0,
										'cp' => NULL,
										'plugins_params' => array(
											
											'sf_us_search' => array(
												
												'sf_id' => $field[ 'options_from_users_submits' ],
												'filters' => json_decode( $filters, TRUE ),
												'order_by' => ( isset( $field[ 'options_filter_order_by' ] ) ? $field[ 'options_filter_order_by' ] : $field[ 'options_title_field' ] ),
												'order_by_direction' => ( isset( $field[ 'options_filter_order_by_direction' ] ) ? $field[ 'options_filter_order_by_direction' ] : 'ASC' ),
												
											),
											
										),
										
									);
									
									$CI =& get_instance();
									$CI->load->library( 'search' );
									$CI->search->config( $search_config );
									
									$users_submits = $CI->search->get_full_results( 'sf_us_search', TRUE );
									
									foreach( $users_submits as & $_ud_data ) {
										
										$this->ud_api->parse_ud_data( $_ud_data, NULL, TRUE );
										
// 										$_ud_data[ 'data' ] = get_params( $_ud_data[ 'data' ] );
										
										if ( $_data_scheme = $this->sfcm->get_submit_forms( array( 'where_condition' => 't1.id = ' . $_ud_data[ 'submit_form_id' ], 'limit' => 1, ) )->row_array() ) {
											
											$this->ud_api->parse_ds( $_data_scheme );
											
// 											echo '<pre>' . print_r( $_data_scheme, TRUE ) . '</pre>';
											
											if ( check_var( $_data_scheme[ 'fields' ][ $field[ 'options_title_field' ] ] ) ) {
												
												$options[ $_ud_data[ 'id' ] ] = check_var( $_ud_data[ 'parsed_data' ][ 'full' ][ $field[ 'options_title_field' ] ][ 'value' ] ) ? $_ud_data[ 'parsed_data' ][ 'full' ][ $field[ 'options_title_field' ] ][ 'value' ] : '';
												
												/*
												foreach( $_ud_data[ 'data' ] as $_dk => $_data ) {
													
													if ( $_dk == $field[ 'options_title_field' ] )
													
													$options[ $_ud_data[ 'id' ] ] = $_ud_data[ 'parsed_data' ][ 'full' ][ $_alias ][ 'value' ];
													
												};
												*/
												
											}
											
										}
										
									};
									
								}
								else {
									
									if ( check_var( $field[ 'options' ] ) ) {
										
										$options_temp = explode( "\n" , $field[ 'options' ] );
										
										foreach( $options_temp as $option ) {
											
											$options[ $option ] = $option;
											
										};
										
									}
									else {
										
										$options[ 1 ] = $field[ 'label' ];
										
									}
								
								}
								
							?>
							
							<div class="submit-form-field-control">
								
								<?php
									
									if ( $field[ 'field_type' ] == 'radiobox' ) {
										
										foreach( $options as $k => $option ) {
											
											$attr_options = array(
												
												'wrapper-class' => 'radiobox-sub-item',
												'class' => 'form-element submit-form submit-form-' . $field_name,
												'name' => $formatted_field_name,
												'id' => 'submit-form-' . $field_name,
												'value' => $k,
												'checked' => FALSE,
												'text' => $option,
												
											);
											
											if ( $field_value AND is_array( $field_value ) AND in_array( $k, $field_value ) ) {
												
												$attr_options[ 'checked' ] = TRUE;
												
											}
											else if ( $field_value AND is_string( $field_value ) AND $k == $field_value ) {
												
												$attr_options[ 'checked' ] = TRUE;
												
											}
											
											echo vui_el_radiobox( $attr_options );
											
										};
										
									}
									else if ( $field[ 'field_type' ] == 'combo_box' ) {
										
										echo vui_el_dropdown(
											
											array(
												
												'id' => 'submit-form-' . $field_name,
												'title' => isset( $field[ 'description' ] ) ? lang( $field[ 'description' ] ) : NULL,
												'value' => $field_value,
												'name' => $formatted_field_name,
												'options' => $options,
												'class' => 'form-element submit-form submit-form-' . $field_name,
												
											)
											
										);
										
									}
									else if ( $field[ 'field_type' ] == 'checkbox' ) {
										
										$formatted_field_name .= '[]';
										
										//print_r( $field_value );
										
										//print_r( $options );
										
										foreach( $options as $k => $option ) {
											
											$attr_options = array(
												
												'wrapper-class' => 'checkbox-sub-item',
												'class' => 'form-element submit-form submit-form-' . $field_name,
												'name' => $formatted_field_name,
												'id' => 'submit-form-' . $field_name,
												'value' => $k,
												'checked' => ( $field_value AND in_array( $k, $field_value ) ) ? 'checked' : FALSE,
												'text' => $option,
												
											);
											
											if ( $field_value AND is_array( $field_value ) AND in_array( $k, $field_value ) ) {
												
												$attr_options[ 'checked' ] = TRUE;
												
											}
											else if ( $field_value AND is_string( $field_value ) AND $k == $field_value ) {
												
												$attr_options[ 'checked' ] = TRUE;
												
											}
											
											echo vui_el_checkbox( $attr_options );
											
										};
										
									}
									
								?>
								
								<?php if ( check_var( $field[ 'description' ] ) ) { ?>
								<div class="submit-form-field-description">
									
									<?= $field[ 'description' ]; ?>
									
								</div>
								<?php } ?>
								
							</div>
							
						</div><?php
						
					} else if ( $field[ 'field_type' ] == 'date' ) {
						
						$this->plugins->load( array( 'types' => array( 'js_time_picker', ) ) );
						
						?><div id="container-<?= $field_name; ?>" class="<?= ( check_var( $field[ 'form_css_class' ] ) ) ? $field[ 'form_css_class' ] : ''; ?> submit-form-field-wrapper submit-form-field-wrapper-<?= $field_name; ?> submit-form-field-wrapper-<?= $field[ 'field_type' ]; ?> <?= ( $error ) ? 'form-error error' : ''; ?>">
							
							<?php
								
								$error = form_error( $formatted_field_name . '[d]', '<span class="msg-inline-error error">', '</span>' );
								$error .= form_error( $formatted_field_name . '[m]', '<span class="msg-inline-error error">', '</span>' );
								$error .= form_error( $formatted_field_name . '[y]', '<span class="msg-inline-error error">', '</span>' );
								
							?>
							
							<?= form_label( lang( $field[ 'label' ] ) . $error ); ?>
							
							<?php
								
								$options_d = array(
									
									'' => lang( 'combobox_select_day' ) . ( $field[ 'sf_date_field_day_is_req' ] ? ' *' : '' ),
									
								);
								
								for ( $i = $field[ 'sf_date_field_day_min_value' ]; $i <= $field[ 'sf_date_field_day_max_value' ]; $i++ ){
									
									$options_d[ str_pad( $i, 2, "0", STR_PAD_LEFT ) ] = str_pad( $i, 2, "0", STR_PAD_LEFT );
									
								}
								
								$options_m = array(
									
									'' => lang( 'combobox_select_month' ) . ( $field[ 'sf_date_field_month_is_req' ] ? ' *' : '' ),
									
								);
								
								for ( $i = $field[ 'sf_date_field_month_min_value' ]; $i <= $field[ 'sf_date_field_month_max_value' ]; $i++ ){
									
									$options_m[ str_pad( $i, 2, "0", STR_PAD_LEFT ) ] = str_pad( $i, 2, "0", STR_PAD_LEFT );
									
								}
								
								$options_y = array(
									
									'' => lang( 'combobox_select_year' ) . ( $field[ 'sf_date_field_year_is_req' ] ? ' *' : '' ),
									
								);
								
								for ( $i = $field[ 'sf_date_field_year_min_value' ]; $i <= $field[ 'sf_date_field_year_max_value' ]; $i++ ){
									
									$options_y[ str_pad( $i, 2, "0", STR_PAD_LEFT ) ] = str_pad( $i, 2, "0", STR_PAD_LEFT );
									
								}
								
								$field_name = isset( $field[ 'alias' ] ) ? $field[ 'alias' ] : $this->sfcm->make_field_name( $field[ 'label' ] );
								$formatted_field_name = 'form[' . $field_name . ']';
								
								if ( isset( $post[ 'form' ][ $field_name ] ) ) {
									
									$field_value_d = ( isset( $post[ 'form' ][ $field_name ][ 'd' ] ) ) ? $post[ 'form' ][ $field_name ][ 'd' ] : ( isset( $field[ 'sf_date_field_day_def_value' ] ) ? $field[ 'sf_date_field_day_def_value' ] : '' );
									$field_value_m = ( isset( $post[ 'form' ][ $field_name ][ 'm' ] ) ) ? $post[ 'form' ][ $field_name ][ 'm' ] : ( isset( $field[ 'sf_date_field_month_def_value' ] ) ? $field[ 'sf_date_field_month_def_value' ] : '' );
									$field_value_y = ( isset( $post[ 'form' ][ $field_name ][ 'y' ] ) ) ? $post[ 'form' ][ $field_name ][ 'y' ] : ( isset( $field[ 'sf_date_field_year_def_value' ] ) ? $field[ 'sf_date_field_year_def_value' ] : '' );
									
								}
								else if ( $field_value ) {
									
									$date = DateTime::createFromFormat( 'Y-m-d', $field_value );
									$field_value_y = $date->format( 'Y' );
									$field_value_m = $date->format( 'm' );
									$field_value_d = $date->format( 'd' );
									unset( $date );
									
								}
								else {
									
									$field_value_d = ( isset( $field[ 'sf_date_field_day_def_value' ] ) ? $field[ 'sf_date_field_day_def_value' ] : '' );
									$field_value_m = ( isset( $field[ 'sf_date_field_month_def_value' ] ) ? $field[ 'sf_date_field_month_def_value' ] : '' );
									$field_value_y = ( isset( $field[ 'sf_date_field_year_def_value' ] ) ? $field[ 'sf_date_field_year_def_value' ] : '' );
									
								}
								
								$use_day = check_var( $field[ 'sf_date_field_use_day' ] );
								$use_month = check_var( $field[ 'sf_date_field_use_month' ] );
								$use_year = check_var( $field[ 'sf_date_field_use_year' ] );
								
							?>
							
							<div class="submit-form-field-control submit-form-field-control-date submit-form-field-control-date-<?php if ( $use_day ) echo 'd'; ?><?php if ( $use_month ) echo 'm'; ?><?php if ( $use_year ) echo 'y'; ?>">
								
								<?php
									
									if ( $use_day ) {
										
										echo vui_el_dropdown(
											
											array(
												
												'id' => 'submit-form-' . $field_name . '-d',
												'title' => isset( $field[ 'description' ] ) ? lang( $field[ 'description' ] ) : NULL,
												'value' => $field_value_d,
												'name' => $formatted_field_name . '[d]',
												'options' => $options_d,
												'class' => 'form-element submit-form submit-form-' . $field_name . '-d',
												
											)
											
										);
										
									}
									
									if ( $use_month ) {
										
										echo vui_el_dropdown(
											
											array(
												
												'id' => 'submit-form-' . $field_name . '-m',
												'value' => $field_value_m,
												'name' => $formatted_field_name . '[m]',
												'options' => $options_m,
												'class' => 'form-element submit-form submit-form-' . $field_name . '-m',
												
											)
											
										);
										
									}
									
									if ( $use_year ) {
										
										echo vui_el_dropdown(
											
											array(
												
												'id' => 'submit-form-' . $field_name . '-y',
												'value' => $field_value_y,
												'name' => $formatted_field_name . '[y]',
												'options' => $options_y,
												'class' => 'form-element submit-form submit-form-' . $field_name . '-y',
												
											)
											
										);
										
									}
									
								?>
								
								<?php if ( check_var( $field[ 'description' ] ) ) { ?>
								<div class="submit-form-field-description">
									
									<?= $field[ 'description' ]; ?>
									
								</div>
								<?php } ?>
								
							</div>
							
						</div><?php
						
					} else if ( $field[ 'field_type' ] == 'articles' ) {
						
						?><div id="container-<?= $field_name; ?>" class="<?= ( check_var( $field[ 'form_css_class' ] ) ) ? $field[ 'form_css_class' ] : ''; ?> submit-form-field-wrapper submit-form-field-wrapper-<?= $field_name; ?> submit-form-field-wrapper-<?= $field[ 'field_type' ]; ?> <?= ( $error ) ? 'form-error error' : ''; ?>">
							
							<?= form_label( lang( $field[ 'label' ] ) . ( check_var( $field[ 'field_is_required' ] ) ? ' <span class="submit-form-required">*</span> ' . $error : '' ) ); ?>
							
							<?php
								
								$options = array(
									
									'' => lang( 'combobox_select' ),
									
								);
								
								foreach ( $field[ 'articles' ] as $article_key => $article ) {
									
									$options[ $article[ 'category_title' ] ][ $article[ 'title' ] ] = $article[ 'title' ];
									
								}
								
							?>
							
							<div class="submit-form-field-control">
								
								<?php
									
									echo vui_el_dropdown(
										
										array(
											
											'id' => 'submit-form-' . $field_name,
											'value' => $field_value,
											'name' => $formatted_field_name,
											'options' => $options,
											'class' => 'form-element submit-form submit-form-' . $field_name,
											
										)
										
									);
									
								?>
								
								<?php if ( check_var( $field[ 'description' ] ) ) { ?>
								<div class="submit-form-field-description">
									
									<?= $field[ 'description' ]; ?>
									
								</div>
								<?php } ?>
								
							</div>
							
						</div><?php
						
					} else if ( $field[ 'field_type' ] == 'textarea' ) {
						
						?><div id="container-<?= $field_name; ?>" class="<?= ( check_var( $field[ 'form_css_class' ] ) ) ? $field[ 'form_css_class' ] : ''; ?> submit-form-field-wrapper submit-form-field-wrapper-<?= $field_name; ?> submit-form-field-wrapper-<?= $field[ 'field_type' ]; ?> <?= ( $error ) ? 'form-error error' : ''; ?>">
							
							<?= form_label( lang( $field[ 'label' ] ) . ( check_var( $field[ 'field_is_required' ] ) ? ' <span class="submit-form-required">*</span> ' . $error : '' ) ); ?>
							
							<div class="submit-form-field-control">
								
								<?php
									
									$editor = FALSE;
									
									if ( ( check_var( $params[ 'submit_forms_allow_html_tags' ] ) AND check_var( $field[ 'sf_field_type_textarea_us_use_editor' ][ 'site' ] ) ) OR ( check_var( $field[ 'sf_field_type_textarea_allow_html' ] ) AND check_var( $field[ 'sf_field_type_textarea_us_use_editor' ][ 'site' ] ) ) ){
										
										$editor = TRUE;
										
										$CI->plugins->load( NULL, 'js_text_editor' );
										
									}
									
									echo vui_el_textarea(
										
										array(
											
											'text' => lang( $field[ 'presentation_label' ] ),
											'id' => 'submit-form-' . $field_name,
											'value' => $field_value,
											'name' => $formatted_field_name,
											'class' => 'form-element submit-form submit-form-' . $field_name . ( $editor ? ' js-editor' : '' ),
											
										)
										
									);
									
								?>
								
								<?php if ( check_var( $field[ 'description' ] ) ) { ?>
								<div class="submit-form-field-description">
									
									<?= $field[ 'description' ]; ?>
									
								</div>
								<?php } ?>
								
							</div>
							
						</div><?php
						
					} else if ( $field[ 'field_type' ] == 'button' ) {
						
							?><div id="container-<?= $field_name; ?>" class="<?= ( check_var( $field[ 'form_css_class' ] ) ) ? $field[ 'form_css_class' ] : ''; ?> submit-form-field-wrapper submit-form-field-wrapper-<?= $field_name; ?> submit-form-field-wrapper-<?= $field[ 'field_type' ]; ?>">
							
							<div class="submit-form-field-control">
								
								<?php
									
									echo vui_el_button(
										
										array(
											
											'button_type' => 'button',
											'text' => lang( $field[ 'label' ] ),
											'id' => 'submit-form-' . $field_name,
											'value' => lang( $field[ 'label' ] ),
											'name' => $formatted_field_name,
											'class' => 'form-element submit-form submit-form-' . $field_name,
											
										)
										
									);
									
								?>
								
								<?php if ( check_var( $field[ 'description' ] ) ) { ?>
									
									<div class="submit-form-field-description">
										
										<?= $field[ 'description' ]; ?>

									</div>
									
								<?php } ?>
								
							</div>
							
						</div><?php
						
					}
					
					if ( check_var( $field[ 'validation_rule' ] ) AND in_array( 'mask', $field[ 'validation_rule' ] ) ) {
						
						$this->plugins->load( 'jquery_maskedinput' );
						
						if ( check_var( $field[ 'ud_validation_rule_parameter_mask_type' ] ) ) {
							
							echo '<script type="text/javascript">';
							
							if ( $field[ 'ud_validation_rule_parameter_mask_type' ] == 'custom_mask' AND check_var( $field[ 'ud_validation_rule_parameter_mask_custom_mask' ] ) ) {
								
								?>
									
									$( document ).bind( 'ready', function(){
										
										$( '#submit-form-<?= $field_name; ?>' ).mask( '<?= $field[ 'ud_validation_rule_parameter_mask_custom_mask' ]; ?>' );
										
									});
									
								<?php
								
							}
							else if ( $field[ 'ud_validation_rule_parameter_mask_type' ] == 'zip_brazil' ) {
								
								?>
									
									$( document ).bind( 'ready', function(){
										
										$( '#submit-form-<?= $field_name; ?>' ).mask( '00000-000' );
										
									});
									
								<?php
								
							}
							else if ( $field[ 'ud_validation_rule_parameter_mask_type' ] == 'phone_brazil' ) {
								
								?>
									
									$( document ).bind( 'ready', function(){
										
										var $pb_mask_behavior = function (val) {
											
											return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
											
										},
										$pb_options = {
											
											onKeyPress: function( val, e, field, options ) {
												
												field.mask( $pb_mask_behavior.apply( {}, arguments ), options );
												
											}
											
										};
										
										$( '#submit-form-<?= $field_name; ?>' ).mask( $pb_mask_behavior, $pb_options );
										
									});
									
								<?php
								
							}
							else if ( $field[ 'ud_validation_rule_parameter_mask_type' ] == 'money' ) {
								
								?>
									
									$( document ).bind( 'ready', function(){
										
										$( '#submit-form-<?= $field_name; ?>' ).mask( '#.##0,00', { reverse: true } );
										
									});
									
								<?php
								
							}
							
							echo '</script>';
							
						}
						
					}
					
					if ( check_var( $field[ 'conditional_field' ] ) ) {
						
						$target_field_name = $this->sfcm->make_field_name( $field[ 'conditional_target_field' ], '-', TRUE );
						$target_formatted_field_name = 'form[' . $target_field_name . ']';
						$target_field_id = 'container-' . $field_name;
						$show_function_name = 'show_field_' . url_title( $field[ 'key' ], '_', TRUE );
						
						$field_name_js = '$targetFieldName_' . url_title( $field[ 'key' ], '_', TRUE );
						
						if ( check_var( $field[ 'conditional_field_function' ] ) AND $field[ 'conditional_field_function' ] === 'show' ) {
						
						?><script type="text/javascript">
							
							function <?= $show_function_name; ?>(){
								
								<?php if ( $field[ 'conditional_field_cond' ] === 'equal' ) { ?>
									
									<?php if ( in_array( $fields[ $field[ 'conditional_target_field' ] ][ 'field_type' ], array( 'checkbox', ) ) ) { ?>
										
										if ( $( '[name="<?= $target_formatted_field_name; ?>[]"][value="<?= $field[ 'conditional_field_values' ]; ?>"]:checked').length ) {
										
									<?php } else if ( in_array( $fields[ $field[ 'conditional_target_field' ] ][ 'field_type' ], array( 'radiobox', ) ) ) { ?>
										
										if ( $( '[name="<?= $target_formatted_field_name; ?>"][value="<?= $field[ 'conditional_field_values' ]; ?>"]:checked').length ) {
										
									<?php } else { ?>
										
										if ( $( '[name="<?= $target_formatted_field_name; ?>"]' ).val() === '<?= $field[ 'conditional_field_values' ]; ?>' ) {
										
									<?php } ?>
									
								<?php } else if ( $field[ 'conditional_field_cond' ] === 'different' AND ( ! isset( $field[ 'conditional_field_values' ] ) OR $field[ 'conditional_field_values' ] === '' ) ) { ?>
									
									<?php if ( in_array( $fields[ $field[ 'conditional_target_field' ] ][ 'field_type' ], array( 'checkbox', ) ) ) { ?>
										
										if ( $( '[name="<?= $target_formatted_field_name; ?>[]"]:checked').length ) {
										
									<?php } else if ( in_array( $fields[ $field[ 'conditional_target_field' ] ][ 'field_type' ], array( 'radiobox', ) ) ) { ?>
										
										if ( $( '[name="<?= $target_formatted_field_name; ?>"]:checked').length ) {
										
									<?php } else { ?>
										
										if ( $.trim( $( '[name="<?= $target_formatted_field_name; ?>"]' ).val() ).length > 0 ) {
										
									<?php } ?>
									
								<?php } else if ( $field[ 'conditional_field_cond' ] === 'different' ) { ?>
									
									<?php if ( in_array( $fields[ $field[ 'conditional_target_field' ] ][ 'field_type' ], array( 'checkbox', ) ) ) { ?>
										
										if ( $( '[name="<?= $target_formatted_field_name; ?>[]"][value="<?= $field[ 'conditional_field_values' ]; ?>"]:checked').length == 0 ) {
										
									<?php } else if ( in_array( $fields[ $field[ 'conditional_target_field' ] ][ 'field_type' ], array( 'radiobox', ) ) ) { ?>
										
										if ( $( '[name="<?= $target_formatted_field_name; ?>"][value="<?= $field[ 'conditional_field_values' ]; ?>"]:checked').length == 0 ) {
										
									<?php } else { ?>
										
										if ( $( '[name="<?= $target_formatted_field_name; ?>"]' ).val() !== '<?= $field[ 'conditional_field_values' ]; ?>' ) {
										
									<?php } ?>
										
								<?php } ?>
									
									$( '#<?= $target_field_id; ?>' ).show();
									$( '#<?= $target_field_id; ?>' ).find( '[name="no_validation_fields[<?= $field_name; ?>]"]' ).remove();
									
								}
								else {
									
									$( '#<?= $target_field_id; ?>' ).hide();
									
									<?php if ( in_array( $fields[ $field[ 'conditional_target_field' ] ][ 'field_type' ], array( 'checkbox', 'radiobox', ) ) ) { ?>
										
										$( '#<?= $target_field_id; ?> .form-element' ).attr( 'checked', '' );
										
									<?php } else if ( $fields[ $field[ 'conditional_target_field' ] ][ 'field_type' ] != 'button' ) { ?>
										
										$( '#<?= $target_field_id; ?> .form-element' ).val( '' );
										
									<?php } ?>
									
									$( '#<?= $target_field_id; ?> .form-element' ).change();
									
									if ( ! $( '[name="fields_ignore_validation[<?= $field_name; ?>]"]' ).length ) {
										
										$( '#<?= $target_field_id; ?>' ).append( '<input type="hidden" name="no_validation_fields[<?= $field_name; ?>]" value="<?= $field_name; ?>" />' );
										
									}
									
								}
								
							};
							
							$( document ).bind( 'ready', function(){
								
								<?php if ( in_array( $fields[ $field[ 'conditional_target_field' ] ][ 'field_type' ], array( 'checkbox', ) ) ) { ?>
									
									$( '[name="<?= $target_formatted_field_name; ?>[]"]' ).bind( 'change keyup', function(){
										
										<?= $show_function_name; ?>();
										
									});
									
								<?php } else { ?>
									
									$( '[name="<?= $target_formatted_field_name; ?>"]' ).bind( 'change keyup', function(){
										
										<?= $show_function_name; ?>();
										
									});
									
								<?php } ?>
								
								<?= $show_function_name; ?>();
								
							});
							
						</script><?php
						
						}
						
					}
					
				}
				
			} ?>
			
		<?= form_close(); ?>
		
		<div class="clear">&nbsp;</div>
		
	</div>
	
</section>

<script type="text/javascript" >
	
	$( document ).ready( function(){
		
		$( document ).on( 'click', '.submit-form.form-element.vui-button', function( e ){
			
			e.preventDefault(); //STOP default action
			
			var jthis = $( this );
			var form = null;
			
			if ( jthis.attr( 'form' ) ) {
				
				formIdString = '#' + jthis.attr( 'form' );
				form = $( formIdString );
				
			}
			else if ( jthis.closest('form').length > 0 ) {
				
				form = jthis.closest('form');
				formIdString = '#' + form.attr( 'id' );
				
			}
			
			if ( form != null ){
				
				$( 'body' ).append( '<div class="full-screen-loading loading"></div>' );
				
				form.submit();
				
			}
			
		});
		
		<?php if ( check_var( $this->current_component[ 'params' ][ 'users_fields' ] ) ) { ?>
		
		// Verifica se CPF existe no BD
		$('.submit-form-cpf').on('change','',function()
		{
			var sCPF = $('.submit-form-cpf');
			if($.isNumeric(sCPF.val()) && sCPF.val().length ==11)
			{
				
				console.log( 'CPF: ' + sCPF.val() );
				
				$.ajax({
					type: 'post',
					url: 'ajax/check_cpf',
					data:
					{
						value:sCPF.val(),
						field:sCPF.attr('name'),
						alias:sCPF.attr('placeholder')
					},
					dataType: 'json'
				}).done(function( retorno ){
					
					console.log( 'Retorno ajax: ' + retorno );
					
					console.log( 'user_id: ' + retorno.user_id );
					
					if ( retorno.user_id ) {
					
						console.log( retorno.email );
						
						<?php
							
							foreach( $users_fields as $uf_alias => $user_field ) {
								
								foreach ( $submit_form[ 'fields' ] as $key => $field ) {
									
									if ( check_var( $field[ 'is_user_field' ] ) AND check_var( $field[ 'user_field' ] ) AND $field[ 'user_field' ] == $uf_alias ) {
										
										echo '$( \'#submit-form-' . $field[ 'alias' ] . '\' ).val( retorno.' . $uf_alias . ' );';
										
									}
									
								}
								
							}
							
						?>
						
						if(retorno.birthday)
						{
							var birthday = retorno.birthday.split('-');
							$('#submit-form-birthday-d').val(birthday[2]);
							$('#submit-form-birthday-d').attr('disabled','disabled');
							$('input#submit-form-birthday-d').remove();
							$('<input>').attr(
							{
								type: 'hidden',
								id: 'submit-form-birthday-d',
								name: 'form[birthday][d]',
								value: birthday[2]
							}).appendTo('#container-birthday');
							
							$('#submit-form-birthday-m').val(birthday[1]);
							$('#submit-form-birthday-m').attr('disabled','disabled');
							$('input#submit-form-birthday-m').remove();
							$('<input>').attr(
							{
								type: 'hidden',
								id: 'submit-form-birthday-m',
								name: 'form[birthday][m]',
								value: birthday[1]
							}).appendTo('#container-birthday');
							
							$('#submit-form-birthday-y').val(birthday[0]);
							$('#submit-form-birthday-y').attr('disabled','disabled');
							$('input#submit-form-birthday-y').remove();
							$('<input>').attr(
							{
								type: 'hidden',
								id: 'submit-form-birthday-y',
								name: 'form[birthday][y]',
								value: birthday[0]
							}).appendTo('#container-birthday');
						}
						$('#submit-form-genre').val(retorno.genre);
						$('#submit-form-genre').attr('disabled','disabled');
						$('#genre').remove();
						$('<input>').attr(
						{
							type: 'hidden',
							id: 'genre',
							name: 'form[genre]',
							value: retorno.genre
						}).appendTo('#container-genre');
						
						$('#submit-form-place_of_birth').val(retorno.place_of_birth);
						$('#submit-form-place_of_birth').attr('readonly','readonly');
						
						$('#user_id').remove();
						$('<input>').attr(
						{
							type: 'hidden',
							id: 'user_id',
							name: 'user_id',
							value: retorno.user_id
						}).appendTo('#user-submit-form');
					}
				});
			}
		});
		
		<?php } ?>
		
	});
	
</script>
