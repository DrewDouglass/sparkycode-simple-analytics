<?php
/*
Plugin Name:  SparkyCode Simple Analytics
Plugin URI:   https://savedove.com
Description:  SparkyCode Simple Analytics. Paste code. Done.
Version:      1.0
Author:       Drew Douglass - SparkyCode LLC
Author URI:   https://sparkycode.com/
*/
add_action( 'admin_menu', 'sparkycode_add_admin_menu' );
add_action( 'admin_init', 'sparkycode_settings_init' );


function sparkycode_add_admin_menu(  ) { 

	add_options_page( 'SparkyCode Simple Analytics', 'SparkyCode Simple Analytics', 'manage_options', 'sparkycode_simple_analytics', 'sparkycode_options_page_simple_analytics' );

}


function sparkycode_settings_init(  ) { 

	register_setting( 'pluginPage', 'sparkycode_settings' );

	add_settings_section(
		'sparkycode_pluginPage_section', 
		__( 'Paste in your Analytics GA Number. Done.', 'wordpress' ), 
		'sparkycode_settings_section_callback', 
		'pluginPage'
	);

	add_settings_field( 
		'sparkycode_text_field_analytics', 
		__( 'Full Analytics Text/Code', 'wordpress' ), 
		'sparkycode_text_field_analytics_render', 
		'pluginPage', 
		'sparkycode_pluginPage_section' 
	);


}


function sparkycode_text_field_analytics_render(  ) { 

	$options = get_option( 'sparkycode_settings' );
	?>
	<input type="text" name='sparkycode_settings[sparkycode_text_field_analytics]' value='<?php echo $options['sparkycode_text_field_analytics']; ?>' required>
	<?php

}


function sparkycode_settings_section_callback(  ) { 

	echo __( 'Generate your GA number at <a target="_blank" href="https://analytics.google.com">https://analytics.google.com</a><div><em>Example code =</em> <code>UA-52136111-1</code></div>', 'wordpress' );

}


function sparkycode_options_page_simple_analytics(  ) { 

	?>
	<form action='options.php' method='post'>

		<h2>SparkyCode Simple Analytics</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php }?>
<?php 
	if(!is_admin() && get_option('sparkycode_settings') !== false):
		function sparky_code_embed_GA_code() {
?>
			<!-- Global site tag (gtag.js) - Google Analytics -->
			<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo get_option('sparkycode_settings')["sparkycode_text_field_analytics"];?>"></script>
			<script>
			  window.dataLayer = window.dataLayer || [];
			  function gtag(){dataLayer.push(arguments);}
			  gtag('js', new Date());
			
			  gtag('config', "<?php echo get_option('sparkycode_settings')["sparkycode_text_field_analytics"];?>");
			</script>


<?php   } add_action('wp_footer','sparky_code_embed_GA_code'); 
	endif;?>