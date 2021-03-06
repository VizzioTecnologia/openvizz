<?php if ( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' ); ?>

<div id="ud-d-search-results-wrapper" class="users-submits-wrapper results">
	
	<?php if ( check_var( $users_submits ) ) { ?>
		
		<?php if ( check_var( $params[ 'show_results_count' ] ) ) { ?>
		
		<div class="ud-d-list-results-title-wrapper ud-d-list-results-count-wrapper">
			
			<h3 class="ud-d-list-results-title">
				
				<?php
					
					if ( $users_submits_total_results > 1 ) {
						
						if ( check_var( $params[ 'ud_d_list_search_results_string' ] ) ) {
							
							echo sprintf( $params[ 'ud_d_list_search_results_string' ], '<span class="ud-d-list-results-count">' . $users_submits_total_results . '</span>' );
							
						}
						else {
							
							echo sprintf( lang( 'ud_d_list_search_results_string' ), '<span class="ud-d-list-results-count">' . $users_submits_total_results . '</span>' );
							
						}
						
					}
					else {
						
						if ( check_var( $params[ 'users_submits_search_single_result_string' ] ) ) {
							
							echo sprintf( $params[ 'users_submits_search_single_result_string' ], '<span class="ud-d-list-results-count">' . $users_submits_total_results . '</span>' );
							
						}
						else {
							
							echo sprintf( lang( 'users_submits_search_single_result_string' ), '<span class="ud-d-list-results-count">' . $users_submits_total_results . '</span>' );
							
						}
						
					}
					
				?>
				
			</h3>
			
		</div>
		
		<?php } ?>
		
		<?php
		
		foreach ( $users_submits as $key => $user_submit ) {
			
			$_us_wrapper_class = array();
			
			$us_fields = $_titles_fields = $_contents_fields = $_ud_other_info_prop = array();
			
			// Getting the titles fields
			
			if ( check_var( $params[ 'ud_title_prop' ] ) ) {
				
				if ( check_var( $params[ 'ud_title_prop' ] ) AND in_array( 'id', $params[ 'ud_title_prop' ] ) ) {
					
					$_titles_fields[ 'id' ][ 'label' ] = lang( 'id' );
					$_titles_fields[ 'id' ][ 'value' ] = $user_submit[ 'id' ];
					
				}
				
				if ( check_var( $params[ 'ud_title_prop' ] ) AND in_array( 'submit_datetime', $params[ 'ud_title_prop' ] ) ) {
					
					$_titles_fields[ 'submit_datetime' ][ 'label' ] = lang( 'submit_datetime' );
					$_titles_fields[ 'submit_datetime' ][ 'value' ] = ov_strftime( lang( 'sf_us_dt_ft_pt_ymd_1' ), strtotime( $user_submit[ 'submit_datetime' ] ) );
					
				}
				
				if ( check_var( $params[ 'ud_title_prop' ] ) AND in_array( 'mod_datetime', $params[ 'ud_title_prop' ] ) ) {
					
					$_titles_fields[ 'mod_datetime' ][ 'label' ] = lang( 'mod_datetime' );
					$_titles_fields[ 'mod_datetime' ][ 'value' ] = ov_strftime( lang( 'sf_us_dt_ft_pt_ymd_1' ), strtotime( $user_submit[ 'mod_datetime' ] ) );
					
				}
				
			}
			
			if ( check_var( $params[ 'ud_content_prop' ] ) ) {
				
				if ( check_var( $params[ 'ud_content_prop' ] ) AND in_array( 'id', $params[ 'ud_content_prop' ] ) ) {
					
					$_contents_fields[ 'id' ][ 'label' ] = lang( 'id' );
					$_contents_fields[ 'id' ][ 'value' ] = $user_submit[ 'id' ];
					
				}
				
				if ( check_var( $params[ 'ud_content_prop' ] ) AND in_array( 'submit_datetime', $params[ 'ud_content_prop' ] ) ) {
					
					$_contents_fields[ 'submit_datetime' ][ 'label' ] = lang( 'submit_datetime' );
					$_contents_fields[ 'submit_datetime' ][ 'value' ] = ov_strftime( lang( 'sf_us_dt_ft_pt_ymd_1' ), strtotime( $user_submit[ 'submit_datetime' ] ) );
					
				}
				
				if ( check_var( $params[ 'ud_content_prop' ] ) AND in_array( 'mod_datetime', $params[ 'ud_content_prop' ] ) ) {
					
					$_contents_fields[ 'mod_datetime' ][ 'label' ] = lang( 'mod_datetime' );
					$_contents_fields[ 'mod_datetime' ][ 'value' ] = ov_strftime( lang( 'sf_us_dt_ft_pt_ymd_1' ), strtotime( $user_submit[ 'mod_datetime' ] ) );
					
				}
				
			}
			
			if ( check_var( $params[ 'ud_other_info_prop' ] ) ) {
				
				if ( check_var( $params[ 'ud_other_info_prop' ] ) AND in_array( 'id', $params[ 'ud_other_info_prop' ] ) ) {
					
					$_ud_other_info_prop[ 'id' ][ 'label' ] = lang( 'id' );
					$_ud_other_info_prop[ 'id' ][ 'value' ] = $user_submit[ 'id' ];
					
				}
				
				if ( check_var( $params[ 'ud_other_info_prop' ] ) AND in_array( 'submit_datetime', $params[ 'ud_other_info_prop' ] ) ) {
					
					$_ud_other_info_prop[ 'submit_datetime' ][ 'label' ] = lang( 'submit_datetime' );
					$_ud_other_info_prop[ 'submit_datetime' ][ 'value' ] = ov_strftime( lang( 'sf_us_dt_ft_pt_ymd_1' ), strtotime( $user_submit[ 'submit_datetime' ] ) );
					
				}
				
				if ( check_var( $params[ 'ud_other_info_prop' ] ) AND in_array( 'mod_datetime', $params[ 'ud_other_info_prop' ] ) ) {
					
					$_ud_other_info_prop[ 'mod_datetime' ][ 'label' ] = lang( 'mod_datetime' );
					$_ud_other_info_prop[ 'mod_datetime' ][ 'value' ] = $user_submit[ 'mod_datetime' ];
					$_ud_other_info_prop[ 'mod_datetime' ][ 'value' ] = ov_strftime( lang( 'sf_us_dt_ft_pt_ymd_1' ), strtotime( $user_submit[ 'mod_datetime' ] ) );
					
				}
				
			}
			
			foreach ( $user_submit[ 'data' ] as $key_2 => $field_value ) {
				
				if ( check_var( $fields[ $key_2 ][ 'field_type' ] ) ){
					
					if ( $fields[ $key_2 ][ 'field_type' ] == 'date' ){
						
						$format = '';
						
						$format .= $fields[ $key_2 ][ 'sf_date_field_use_year' ] ? 'y' : '';
						$format .= $fields[ $key_2 ][ 'sf_date_field_use_month' ] ? 'm' : '';
						$format .= $fields[ $key_2 ][ 'sf_date_field_use_day' ] ? 'd' : '';
						
						$format = 'sf_us_dt_ft_pt_' . $format . '_' . $fields[ $key_2 ][ 'sf_date_field_presentation_format' ];
						
						$field_value =  ov_strftime( lang( $format ), strtotime( $field_value ) );
						
					}
					else if ( in_array( $fields[ $key_2 ][ 'field_type' ], array( 'checkbox', 'combo_box', 'radiobox', ) ) ){
						
						if ( get_json_array( $field_value ) ) {
							
							$field_value = json_decode( $field_value, TRUE );
							
						}
						
						$_field_value = array();
						
						if ( is_array( $field_value ) ) {
							
							foreach ( $field_value as $k => $value ) {
								
								if ( is_string( $value ) ) {
									
									if ( check_var( $fields[ $key_2 ][ 'options_from_users_submits' ] ) AND ( check_var( $fields[ $key_2 ][ 'options_title_field' ] ) OR check_var( $fields[ $key_2 ][ 'options_title_field_custom' ] ) ) AND is_numeric( $value ) AND $_user_submit = $this->sfcm->get_user_submit( $value ) ) {
										
										$value = isset( $_user_submit[ 'data' ][ $fields[ $key_2 ][ 'options_title_field' ] ] ) ? $_user_submit[ 'data' ][ $fields[ $key_2 ][ 'options_title_field' ] ] : $_user_submit[ 'id' ];
										
										$_field_value[] = $value;
										
									}
									else {
										
										$_field_value[] = $value;
										
									}
									
								}
								
							}
							
							$field_value = join( ', ', $_field_value );
							
						}
						else {
							
							if ( check_var( $fields[ $key_2 ][ 'options_from_users_submits' ] ) AND ( check_var( $fields[ $key_2 ][ 'options_title_field' ] ) OR check_var( $fields[ $key_2 ][ 'options_title_field_custom' ] ) ) AND is_numeric( $field_value ) AND $_user_submit = $this->sfcm->get_user_submit( $field_value ) ) {
								
								$field_value = isset( $_user_submit[ 'data' ][ $fields[ $key_2 ][ 'options_title_field' ] ] ) ? $_user_submit[ 'data' ][ $fields[ $key_2 ][ 'options_title_field' ] ] : $_user_submit[ 'id' ];
								
							}
							
						}
						
					}
					
					// do not use empty field values
					if ( $field_value ) {
						
						$us_fields[ $key_2 ][ 'label' ] = isset( $fields[ $key_2 ][ 'presentation_label' ] ) ? $fields[ $key_2 ][ 'presentation_label' ] : $fields[ $key_2 ][ 'label' ];
						$us_fields[ $key_2 ][ 'value' ] = $field_value;
						
						if ( check_var( $params[ 'ud_title_prop' ] ) AND in_array( $fields[ $key_2 ][ 'alias' ], $params[ 'ud_title_prop' ] ) ) {
							
							$_titles_fields[ $fields[ $key_2 ][ 'alias' ] ][ 'label' ] = $us_fields[ $key_2 ][ 'label' ];
							$_titles_fields[ $fields[ $key_2 ][ 'alias' ] ][ 'value' ] = $us_fields[ $key_2 ][ 'value' ];
							
						}
						
						if ( check_var( $params[ 'ud_content_prop' ] ) AND in_array( $fields[ $key_2 ][ 'alias' ], $params[ 'ud_content_prop' ] ) ) {
							
							$_contents_fields[ $fields[ $key_2 ][ 'alias' ] ][ 'label' ] = $us_fields[ $key_2 ][ 'label' ];
							$_contents_fields[ $fields[ $key_2 ][ 'alias' ] ][ 'value' ] = $us_fields[ $key_2 ][ 'value' ];
							
						}
						
						if ( check_var( $params[ 'ud_other_info_prop' ] ) AND in_array( $fields[ $key_2 ][ 'alias' ], $params[ 'ud_other_info_prop' ] ) ) {
							
							$_ud_other_info_prop[ $fields[ $key_2 ][ 'alias' ] ][ 'label' ] = $us_fields[ $key_2 ][ 'label' ];
							$_ud_other_info_prop[ $fields[ $key_2 ][ 'alias' ] ][ 'value' ] = $us_fields[ $key_2 ][ 'value' ];
							
						}
						
						$_us_wrapper_class[] = $key_2 . '-' . url_title( $field_value, '-', TRUE );
						
					}
					
				}
				
			}
			
			$_us_wrapper_class = join( ' ', $_us_wrapper_class );
			
			$modal_title = array();
			
			foreach ( $_titles_fields as $key_2 => $_title_field ) {
				
				$modal_title[] = $_title_field[ 'value' ];
				
			}
			
			$modal_title = join( '<br/>', $modal_title );
			
			$us_hash = $unique_hash . md5( uniqid( rand(), true ) );
			
			$_full_title = '';
			$_full_content = '';
			$_full_other_info = '';
			
			?><div href="#<?= $us_hash; ?>" class="user-submit-wrapper modal <?= $_us_wrapper_class ?>" data-fancybox-title="<?= $modal_title; ?>" data-fancybox-type="inline" data-fancybox-group="users-submits-<?= $unique_hash; ?>" >
				
				<div class="contents">
				<?php foreach ( $_contents_fields as $key_2 => $_content_field ) {
					
					$_full_content .= '<div class="item"><span class="value">' . $_content_field[ 'label' ] . '</span>';
					$_full_content .= '<span class="value">' . $_content_field[ 'value' ] . '</span></div>';
					
					require( $_default_path . 'contents.php' );
					
				} ?>
				</div>
				
				<div class="titles">
				<?php foreach ( $_titles_fields as $key_2 => $_title_field ) {
					
					$_full_title .= '<span class="value">' . $_title_field[ 'value' ] . '</span>';
					
					require( $_default_path . 'titles.php' );
					
				} ?>
				</div>
				
				<div class="other-info">
				<?php foreach ( $_ud_other_info_prop as $key_2 => $_other_info ) {
					
					$_full_other_info .= '<div class="item"><span class="value">' . $_other_info[ 'label' ] . '</span>';
					$_full_other_info .= '<span class="value">' . $_other_info[ 'value' ] . '</span></div>';
					
					require( $_default_path . 'other_info.php' );
					
				} ?>
				</div>
				
				<div id="<?= $us_hash; ?>" style="display: none">
					
					<div class="title">
						
						<?= $_full_title; ?>
						
					</div>
					
					<div class="content">
						
						<?= $_full_content; ?>
						
					</div>
					
					<div class="other-info">
						
						<?= $_full_other_info; ?>
						
					</div>
					
				</div>
					
			</div><?php
			
		} ?>
		
	<?php } else { ?>
		
		<?php if ( $this->input->post( NULL, TRUE ) OR ! check_var( $users_submits ) ) { ?>
			
			<div class="ud-d-list-no-search-results-desc-wrapper no-results">
			
				<span class="ud-d-list-no-search-results-desc">
					
					<?= lang( 'no_results' ); ?>
					
				</span>
				
			</div>
			
		<?php } else { ?>
			
			<div class="ud-d-list-no-search-results-desc-wrapper no-results">
			
				<span class="ud-d-list-no-search-results-desc">
					
					<?= lang( 'users_submits_description_no_search_results' ); ?>
					
				</span>
				
			</div>
			
		<?php } ?>
		
	<?php } ?>
	
</div>
	
