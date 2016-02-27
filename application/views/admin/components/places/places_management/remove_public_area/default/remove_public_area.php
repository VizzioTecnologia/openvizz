
		<header>
			<h1><?php echo lang('confirm_delete'); ?></h1>
		</header>
		
		<div>
			
			<?php echo form_open(get_url('admin'.$this->uri->ruri_string())); ?>
			
			<p>
				<?php echo lang('city_confirm_delete'); ?>
				<b><?php echo $public_area->title; ?> - <?php echo $neighborhood->title; ?> - <?php echo $city->title; ?> - <?php echo $state->title; ?> - <?php echo lang($country->title); ?></b>?
			</p>
				
			<?php echo form_submit(array('id'=>'submit','name'=>'submit'),lang('action_yes'),'autofocus'); ?>
			<?php echo form_submit(array('id'=>'submit-cancel','name'=>'submit_cancel'),lang('action_cancel')); ?>
				
			<?php echo form_hidden('public_area_id',$public_area->id); ?>
				
			<?php echo form_close(); ?>
			
		</div>

