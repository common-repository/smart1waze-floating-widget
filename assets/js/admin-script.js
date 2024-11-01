jQuery(document).ready(function(){
	jQuery('.enable_on_whole_site').change(function(){
		if(jQuery('.enable_on_whole_site').is(':checked') == true && jQuery(this).val() == 'No')
		{
			jQuery('.sm1waze_settings').hide();
			jQuery('.sm1waze_enable_on_all_page').hide();
			jQuery('.sm1waze_enable_on_all_posts').hide();
			jQuery('.sm1waze_enable_on_all_taxonomy').hide();
			jQuery('.sm1waze_enable_on_all_custom_post_type').hide();
			jQuery('.sm1waze_settings input[type="radio"]').prop('checked', false);
			jQuery('.sm1waze_settings input[type="checkbox"]').prop('checked', false);
		}
		else if(jQuery('.enable_on_whole_site').is(':checked') == true && jQuery(this).val() == 'custom')
		{
			jQuery('.sm1waze_settings').show();
			jQuery('.sm1waze_enable_on_all_page').show();
			jQuery('.sm1waze_enable_on_all_posts').show();
			jQuery('.sm1waze_enable_on_all_taxonomy').show();
			jQuery('.sm1waze_enable_on_all_custom_post_type').show();
		}
		else if(jQuery('.enable_on_whole_site').is(':checked') == true && jQuery(this).val() == 'Yes'){
			jQuery('.sm1waze_settings').hide();
			jQuery('.sm1waze_enable_on_all_page').hide();
			jQuery('.sm1waze_enable_on_all_posts').hide();
			jQuery('.sm1waze_enable_on_all_taxonomy').hide();
			jQuery('.sm1waze_enable_on_all_custom_post_type').hide();
		}	
	});
	
	var cptValue = jQuery("input[name='sm1waze_settings[enable_on_all_cpt]']:checked").val();
	if(jQuery('.enable_on_all_cpt').is(':checked') == true && cptValue == 'Yes')
	{	
		jQuery('.sm1waze-cpt').hide();
	}
	else if(jQuery('.enable_on_all_cpt').is(':checked') == true && cptValue == 'No')
	{
		jQuery('.sm1waze-cpt').hide();
		jQuery('.sm1waze-cpt input[type="checkbox"]').prop('checked', false);
	}
	else if(jQuery('.enable_on_all_cpt').is(':checked') == true && cptValue == 'custom')
	{
		jQuery('.sm1waze-cpt').show();
	}
	
	jQuery('.enable_on_all_cpt').change(function(){
		if(jQuery('.enable_on_all_cpt').is(':checked') == true && jQuery(this).val() == 'Yes')
		{
			jQuery('.sm1waze-cpt').hide();
		}
		else if(jQuery('.enable_on_all_cpt').is(':checked') == true && jQuery(this).val() == 'No')
		{
			jQuery('.sm1waze-cpt').hide();
			jQuery('.sm1waze-cpt input[type="checkbox"]').prop('checked', false);
		}
		else if(jQuery('.enable_on_all_cpt').is(':checked') == true && jQuery(this).val() == 'custom')
		{
			jQuery('.sm1waze-cpt').show();
		}
	});
	
	var taxValue = jQuery("input[name='sm1waze_settings[enable_on_all_taxonomy]']:checked").val();
	if(jQuery('.enable_on_all_taxonomy').is(':checked') == true && taxValue == 'Yes')
	{	
		jQuery('.sm1waze-taxonomy').hide();
	}
	else if(jQuery('.enable_on_all_taxonomy').is(':checked') == true && taxValue == 'No')
	{
		jQuery('.sm1waze-taxonomy').hide();
		jQuery('.sm1waze-taxonomy input[type="checkbox"]').prop('checked', false);
	}
	else if(jQuery('.enable_on_all_taxonomy').is(':checked') == true && taxValue == 'custom')
	{
		jQuery('.sm1waze-taxonomy').show();
	}
	
	jQuery('.enable_on_all_taxonomy').change(function(){
		if(jQuery('.enable_on_all_taxonomy').is(':checked') == true && jQuery(this).val() == 'Yes')
		{
			jQuery('.sm1waze-taxonomy').hide();
		}
		else if(jQuery('.enable_on_all_taxonomy').is(':checked') == true && jQuery(this).val() == 'No')
		{
			jQuery('.sm1waze-taxonomy').hide();
			jQuery('.sm1waze-taxonomy input[type="checkbox"]').prop('checked', false);
		}
		else if(jQuery('.enable_on_all_taxonomy').is(':checked') == true && jQuery(this).val() == 'custom')
		{
			jQuery('.sm1waze-taxonomy').show();
		}
	});

	jQuery("#api_key").change(function(){
		
		if(jQuery(this).val() == '')
		{
			jQuery('#is_valid_api_key').val(0);
			jQuery('.sm1waze_enable_on_whole_site_div').hide();
			jQuery('.sm1waze_settings').hide();
			jQuery('.sm1waze_api_key_valid_text').removeClass('valid_key').removeClass('loader').addClass('invalid_key');
			jQuery('.sm1waze_api_key_valid_text').text('Please enter valid api key');
			return;
		}
		else if(jQuery(this).val().length > 16 ||  jQuery(this).val().length < 16)
		{
			jQuery('#is_valid_api_key').val(0);
			jQuery('.sm1waze_enable_on_whole_site_div').hide();
			jQuery('.sm1waze_settings').hide();
			jQuery('.sm1waze_api_key_valid_text').removeClass('valid_key').removeClass('loader').addClass('invalid_key');
			jQuery('.sm1waze_api_key_valid_text').text('Api Key must be 16 character long');
			return;
		}else{
			jQuery('.sm1waze_enable_on_whole_site_div').show();
			jQuery('.sm1waze_api_key_valid_text').removeClass('invalid_key').removeClass('loader').addClass('valid_key');
		}

		jQuery('.sm1waze_api_key_valid_text').removeClass('valid_key').removeClass('invalid_key').addClass('loader');
		jQuery('.sm1waze_api_key_valid_text').text('');
		
		jQuery.ajax({
			url:'https://app.smart1leads.com/api/check-key/'+jQuery(this).val(),			
			type:'GET',
			success:function(data){
				if(data == 'valid')
				{
					jQuery('#is_valid_api_key').val(1);
					jQuery('.sm1waze_enable_on_whole_site_div').show();
					jQuery('.sm1waze_api_key_valid_text').removeClass('invalid_key').removeClass('loader').addClass('valid_key');
					jQuery('.sm1waze_api_key_valid_text').text('Valid Api Key');
				}
				else
				{
					jQuery('#is_valid_api_key').val(0);
					jQuery('.sm1waze_enable_on_whole_site_div').hide();
					jQuery('.sm1waze_settings').hide();
					jQuery('.sm1waze_api_key_valid_text').removeClass('valid_key').removeClass('loader').addClass('invalid_key');
					jQuery('.sm1waze_api_key_valid_text').text('Invalid Api Key');
				}
			},
			error: function()
			{
				jQuery('#is_valid_api_key').val(0);
				jQuery('.sm1waze_enable_on_whole_site_div').hide();
				jQuery('.sm1waze_api_key_valid_text').removeClass('valid_key').removeClass('loader').addClass('invalid_key');
				jQuery('.sm1waze_api_key_valid_text').text('Invalid Api Key');
			}
		});
	});

	jQuery("#api_key").trigger('change');
});