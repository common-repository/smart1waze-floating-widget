<?php
class Smart1Waze_Widget_Frontend
{
	public function __construct()
	{
		/*
		* Actions
		*/
		add_action( 'wp_enqueue_scripts', array($this,'enqeue_scripts') );	
	}

	public function enqeue_scripts(){
		
		global $post;
		$enqueue_sm1_script = false;

		$sm1waze_setting_values = get_option( 'sm1waze_settings' );

		if($sm1waze_setting_values['is_valid_api_key'] == "1")
		{
			
			if($sm1waze_setting_values['enable_on_whole_site'] == "Yes")
			{
				$enqueue_sm1_script = true;
			}
			elseif(is_front_page() && $sm1waze_setting_values['enable_on_all_page'] == "Yes"){
				$enqueue_sm1_script = true;
			}	
			else
			{
				if(is_archive())
				{	
					$query_object = get_queried_object();

					if(isset($query_object->ID))
					{
						if(isset($sm1waze_setting_values['enable_on_user_archive_page']) && $sm1waze_setting_values['enable_on_user_archive_page'] == 1)
						{
							$enqueue_sm1_script = true;
						}
						else if(isset($query_object->ID) && get_user_meta($query_object->ID, 'enable_sm1waze_widget', true) == 1)
						{
							$enqueue_sm1_script = true;
						}
					}
					
					else if(!empty($query_object->taxonomy))
					{
						if(isset($sm1waze_setting_values['single_taxonomy_'.$query_object->taxonomy]) && $sm1waze_setting_values['single_taxonomy_'.$query_object->taxonomy]=='1')
						{
							$enqueue_sm1_script = true;
						}
						else if(isset($query_object->term_id) && get_term_meta($query_object->term_id,'enable_sm1waze_widget',true) == '1')
						{
							$enqueue_sm1_script = true;
						}
						else if (isset($sm1waze_setting_values['enable_on_all_taxonomy']) && $sm1waze_setting_values['enable_on_all_taxonomy']=='Yes') {
							$enqueue_sm1_script = true;	
						}
					}

					else if(isset($sm1waze_setting_values['archive_post_'.$query_object->name]) && $sm1waze_setting_values['archive_post_'.$query_object->name]=='1')
					{
						$enqueue_sm1_script = true;
					}

					else if (isset($sm1waze_setting_values['enable_on_all_cpt']) && $sm1waze_setting_values['enable_on_all_cpt']=='Yes') {
						$enqueue_sm1_script = true;	
					}

				}
				else if(is_page()){
					if(isset($sm1waze_setting_values['enable_on_all_page']) && $sm1waze_setting_values['enable_on_all_page']=='Yes'){
						$enqueue_sm1_script = true;	
					}
				}

				else if(is_singular())
				{	
					if(is_singular($post->post_type)){
						if(isset($sm1waze_setting_values['single_post_'.$post->post_type]) && $sm1waze_setting_values['single_post_'.$post->post_type]=='1')
						{
							$enqueue_sm1_script = true;
						}
						else if(get_post_meta($post->ID,'enable_sm1waze_widget',true) == '1')
						{
							$enqueue_sm1_script = true;
						}
					}
					
					if($post->post_type == 'post'){
						if(isset($sm1waze_setting_values['enable_on_all_post']) && $sm1waze_setting_values['enable_on_all_post']=='Yes'){
							$enqueue_sm1_script = true;	
						}
						else if(get_post_meta($post->ID,'enable_sm1waze_widget',true) == '1')
						{
							$enqueue_sm1_script = true;
						}	
					}

					if (isset($sm1waze_setting_values['enable_on_all_cpt']) && $sm1waze_setting_values['enable_on_all_cpt']=='Yes') {
						$enqueue_sm1_script = true;	
					}
				}

				else if(is_front_page() && $sm1waze_setting_values['enable_on_front_page']=='1')
				{
					$enqueue_sm1_script = true;
				}
			}
		}	

		if(!empty($enqueue_sm1_script))
		{
			wp_register_script('sm1waze-api-js','https://app.smart1leads.com/api/script?apikey='.$sm1waze_setting_values['api_key'],array('jquery'), null);
			wp_enqueue_script('sm1waze-api-js');

			wp_register_script('sm1waze-frontend-js',  SM1WAZE_ASSETS.'js/frontend-script.js',array('jquery', 'sm1waze-api-js'), null, true);
			wp_enqueue_script('sm1waze-frontend-js');
		}
	}
}