<div class="wrap">
	<h1>Smart1Waze Floating Widget Settings</h1>
	<?php
		settings_errors();
	?>
	<form action="options.php" method="post" id="sm1waze-settings-form" class="sm1waze-settings-form">
		<?php
			settings_fields( 'sm1waze_settings' );
			do_settings_sections( 'sm1waze_settings' );
		?>
		<div class="general-settings">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label><?php _e('Smart1Waze API Key:','sm1waze'); ?></label>
						</th>
						<td>
							<input type="password" name="sm1waze_settings[api_key]" id="api_key" value="<?php echo $sm1waze_setting_values['api_key'] ?>" class="regular-text code">
							<span class="sm1waze_api_key_valid_text"></span>
							<input type="hidden" name="sm1waze_settings[is_valid_api_key]" id="is_valid_api_key" value="<?php echo $sm1waze_setting_values['is_valid_api_key'] ?>" class="regular-text code">
							<p class="description"><a href="https://app.smart1leads.com/user/getcode" target="_blank">Click here</a> to get Smart1Waze API Key.</p>
						</td>
					</tr>
				</tbody>
			</table>
			<div class="sm1waze_enable_on_whole_site_div" style="<?php echo $sm1waze_setting_values['is_valid_api_key'] != '1' ? 'display: none;'  : '' ; ?>">
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row">
								<label><?php _e('Enable Smart1Waze Widget on Whole Site :','sm1waze'); ?></label>
							</th>
							<td>
								<div><input type="radio" name="sm1waze_settings[enable_on_whole_site]" value="Yes" class="enable_on_whole_site" <?php checked('Yes', $sm1waze_setting_values['enable_on_whole_site']);?>>Yes, Please enable on whole site</div>
								<div><input type="radio" name="sm1waze_settings[enable_on_whole_site]" value="No" class="enable_on_whole_site" <?php checked('No', $sm1waze_setting_values['enable_on_whole_site']);?>>No, will select manually wherever needed</div>
								<div><input type="radio" name="sm1waze_settings[enable_on_whole_site]" value="custom" class="enable_on_whole_site" <?php checked('custom', $sm1waze_setting_values['enable_on_whole_site']);?>>Limited access, will configure manually</div>
								<span class="custom-access"></span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="sm1waze_settings" style="<?php echo $sm1waze_setting_values['enable_on_whole_site'] == 'Yes' || $sm1waze_setting_values['enable_on_whole_site'] == 'No' ? 'display: none;'  : '' ; ?>">
				<div class="sm1waze_enable_on_all_page" style="<?php echo $sm1waze_setting_values['is_valid_api_key'] != '1' ? 'display: none;'  : '' ; ?>">
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row">
									<label><?php _e('Enable Smart1Waze Widget on all Pages :','sm1waze'); ?></label>
								</th>
								<td>
									<input type="radio" name="sm1waze_settings[enable_on_all_page]" value="Yes" class="enable_on_all_page" <?php checked('Yes', $sm1waze_setting_values['enable_on_all_page']);?>>Yes
									<input type="radio" name="sm1waze_settings[enable_on_all_page]" value="No" class="enable_on_all_page" <?php checked('No', $sm1waze_setting_values['enable_on_all_page']);?>>No
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="sm1waze_enable_on_all_posts" style="<?php echo $sm1waze_setting_values['is_valid_api_key'] != '1' ? 'display: none;'  : '' ; ?>">
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row">
									<label><?php _e('Enable Smart1Waze Widget on all Posts :','sm1waze'); ?></label>
								</th>
								<td>
									<input type="radio" name="sm1waze_settings[enable_on_all_post]" value="Yes" class="enable_on_all_post" <?php checked('Yes', $sm1waze_setting_values['enable_on_all_post']);?>>Yes
									<input type="radio" name="sm1waze_settings[enable_on_all_post]" value="No" class="enable_on_all_post" <?php checked('No', $sm1waze_setting_values['enable_on_all_post']);?>>No
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="sm1waze_enable_on_all_taxonomy" style="<?php echo $sm1waze_setting_values['is_valid_api_key'] != '1' ? 'display: none;'  : '' ; ?>">
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row">
									<label><?php _e('Enable Smart1Waze Widget on all Taxonomy :','sm1waze'); ?></label>
								</th>
								<td>
									<input type="radio" name="sm1waze_settings[enable_on_all_taxonomy]" value="Yes" class="enable_on_all_taxonomy" <?php checked('Yes', $sm1waze_setting_values['enable_on_all_taxonomy']);?>>Yes
									<input type="radio" name="sm1waze_settings[enable_on_all_taxonomy]" value="No" class="enable_on_all_taxonomy" <?php checked('No', $sm1waze_setting_values['enable_on_all_taxonomy']);?>>No
									<input type="radio" name="sm1waze_settings[enable_on_all_taxonomy]" value="custom" class="enable_on_all_taxonomy" <?php checked('custom', $sm1waze_setting_values['enable_on_all_taxonomy']);?>>Limited access
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="sm1waze-taxonomy" style="display: none;">
				<table class="form-table">
					<thead>
						<th>Taxonomy</th>
						<th>Detail Page</th>
					</thead>
					<tbody>
						<?php
							foreach ($sm1waze_registered_taxonomies as $k => $v )
							{
								$sm1waze_taxonomy_obj = get_taxonomy($v);
									
							 	if (!empty($sm1waze_taxonomy_obj->publicly_queryable))
							 	{
						?>
									<tr>
										<th scope="row"><?php echo $sm1waze_taxonomy_obj->label; ?></th>
										<td>
											<?php 
												if(!empty($sm1waze_taxonomy_obj->publicly_queryable))
												{
											?>
													<input type="checkbox" name="sm1waze_settings[single_taxonomy_<?php echo $v; ?>]" id="sm1waze_single_taxonomy_<?php echo $v; ?>" value="1" <?php checked('1', $sm1waze_setting_values['single_taxonomy_'.$v.'']);?>>
											<?php
												}
											?>
										</td>		
									</tr>
						<?php
								}
							}
						?>
					</tbody>
				</table>
				</div>
				<div class="sm1waze_enable_on_all_custom_post_type" style="<?php echo $sm1waze_setting_values['is_valid_api_key'] != '1' ? 'display: none;'  : '' ; ?>">
					<table class="form-table">
						<tbody>
							<tr>
								<th scope="row">
									<label><?php _e('Enable Smart1Waze Widget on all Custom Post Type :','sm1waze'); ?></label>
								</th>
								<td>
									<input type="radio" name="sm1waze_settings[enable_on_all_cpt]" value="Yes" class="enable_on_all_cpt" <?php checked('Yes', $sm1waze_setting_values['enable_on_all_cpt']);?>>Yes
									<input type="radio" name="sm1waze_settings[enable_on_all_cpt]" value="No" class="enable_on_all_cpt" <?php checked('No', $sm1waze_setting_values['enable_on_all_cpt']);?>>No
									<input type="radio" name="sm1waze_settings[enable_on_all_cpt]" value="custom" class="enable_on_all_cpt" <?php checked('custom', $sm1waze_setting_values['enable_on_all_cpt']);?>>Limited access
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="sm1waze-cpt" style="display: none;">
				<table class="form-table">
					<thead>
						<th>Post Type</th>
						<th>Listing Page</th>
						<th>Detail Page</th>
					</thead>
					<tbody>
						<?php
							foreach ($sm1waze_registered_post_types as $k => $v )
							{
								$sm1waze_post_obj = get_post_type_object($v);
								if ((!empty($sm1waze_post_obj->publicly_queryable) || !empty($sm1waze_post_obj->has_archive)) && $sm1waze_post_obj->label != 'Posts')
							 	{
						?>
									<tr>
										<th scope="row"><?php echo $sm1waze_post_obj->label; ?></th>
										<td>
											<?php 
												if(!empty($sm1waze_post_obj->has_archive))
												{
											?>
													<input type="checkbox" name="sm1waze_settings[archive_post_<?php echo $v; ?>]" id="sm1waze_archive_post_<?php echo $v; ?>" value="1" <?php checked('1', $sm1waze_setting_values['archive_post_'.$v.'']);?>>
											<?php
												}
											?>
										</td>		
										<td>
											<?php 
												if(!empty($sm1waze_post_obj->publicly_queryable))
												{
											?>
													<input type="checkbox" name="sm1waze_settings[single_post_<?php echo $v; ?>]" id="sm1waze_single_post_<?php echo $v; ?>" value="1" <?php checked('1', $sm1waze_setting_values['single_post_'.$v.'']);?>>
											<?php
												}
											?>
										</td>		
									</tr>
						<?php
								}
							}
						?>
					</tbody>
				</table>
				</div>
			</div>	
			
			<?php  
				submit_button( __( 'Save', 'sm1waze' ) ); 
			?>
		</div>
	</form>
</div>