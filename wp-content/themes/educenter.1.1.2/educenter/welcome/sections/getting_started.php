<div class="getting-started-top-wrap clearfix">
	<div class="theme-steps-list">
		<div class="theme-steps">
			<h3><?php echo esc_html__('Step 1 - Enable "Front or Home Page"', 'educenter'); ?></h3>
			<ol>
				<li><?php echo esc_html__('Go to Appearance >> Customize >> HomePage Block Section >> Enable Front Page', 'educenter'); ?></li>
				<li><?php echo esc_html__('Check to Enable Front Page or Home Page "A Static Page"', 'educenter'); ?></li>
				<li><?php echo esc_html__('Save changes', 'educenter'); ?></li>
			</ol>
		</div>

		<div class="theme-steps">
			<img src="<?php echo esc_url(get_template_directory_uri() .'/welcome/css/30c2hi.gif'); ?>" alt="<?php echo esc_html__('Enable Front Page', 'educenter'); ?>">
		</div>

		<div class="theme-steps">
			<h3><?php echo esc_html__('Step 3 - Customizer Options Panel', 'educenter'); ?></h3>
			<p><?php echo esc_html__('Now go to Customizer Page. Using the WordPress Customizer you can easily set up the home page and customize the theme.', 'educenter'); ?></p>
			<a class="button button-primary" href="<?php echo esc_url(admin_url('customize.php')); ?>"><?php echo esc_html__('Go to Customizer Panels', 'educenter'); ?></a>
		</div>

	</div>

	<div class="theme-image">
		<h3><?php echo esc_html__('Import Sample Demo', 'educenter'); ?></h3>
		<img src="<?php echo esc_url(get_template_directory_uri(). '/screenshot.png'); ?>" alt="<?php echo esc_html__('Buzzstore Demo', 'educenter'); ?>">

		<div class="theme-import-demo">
			<?php 
			$educenter_demo_importer_slug = 'one-click-demo-import';
			$educenter_demo_importer_filename ='one-click-demo-import';
			$educenter_import_url = '#';

			if ( $this->educenter_check_installed_plugin( $educenter_demo_importer_slug, $educenter_demo_importer_filename ) && !$this->educenter_check_plugin_active_state( $educenter_demo_importer_slug, $educenter_demo_importer_filename ) ) :
				$educenter_import_class = 'button button-primary educenter-activate-plugin';
				$educenter_import_button_text = esc_html__('Activate Importer Plugin', 'educenter');
			elseif( $this->educenter_check_installed_plugin( $educenter_demo_importer_slug, $educenter_demo_importer_filename ) ) :
				$educenter_import_class = 'button button-primary';
				$educenter_import_button_text = esc_html__('Go to Importer Page >>', 'educenter');
				$educenter_import_url = admin_url('themes.php?page=pt-one-click-demo-import');
			else :
				$educenter_import_class = 'button button-primary educenter-install-plugin';
				$educenter_import_button_text = esc_html__('Install Importer Plugin', 'educenter');
			endif;
			?>
			<p><?php echo sprintf(esc_html__('Or you can import the demo with just one click. It is recommended to import the demo on a fresh WordPress install. Or you can reset the website using %s plugin.', 'educenter'), '<a target="_blank" href="https://wordpress.org/plugins/wordpress-reset/">WordPress Reset</a>'); ?></p>

			<p><?php echo esc_html__('Note: First Install All Theme Recommended Plugins.', 'educenter'); ?></p>

			<p><?php echo esc_html__('Click on the button below to install and activate demo importer plugin.', 'educenter'); ?></p>
			<a data-slug="<?php echo esc_attr($educenter_demo_importer_slug); ?>" data-filename="<?php echo esc_attr($educenter_demo_importer_filename); ?>" class="<?php echo esc_attr($educenter_import_class); ?>" href="<?php echo esc_url( $educenter_import_url ); ?>"><?php echo esc_html($educenter_import_button_text); ?></a>
		</div>
	</div>
</div>

<div class="getting-started-bottom-wrap">
	<h3><?php echo esc_html__('Check our premium demos. You might be interested in purchasing premium version.', 'educenter'); ?></h3>
	<p><?php echo esc_html__('Check out the websites that you can create with the premium version of the Educenter Pro theme. These demos can be imported with just one click in the premium version.', 'educenter'); ?></p>

	<div class="recomended-plugin-wrap clearfix">

		<div class="recom-plugin-wrap">
			<div class="plugin-img-wrap">
				<img src="<?php echo esc_url(get_template_directory_uri() .'/welcome/css/educenterpro.jpg'); ?>" alt="<?php echo esc_html__('Educenter Pro Demo One', 'educenter'); ?>">
			</div>

			<div class="plugin-title-install clearfix">
				<span class="title"><?php esc_html_e('Educenter Pro Demo One','educenter'); ?></span>
				<span class="plugin-btn-wrapper">
					<a target="_blank" href="http://demo.sparklewpthemes.com/educenterpro/" class="button button-primary"><?php echo esc_html__('Preview', 'educenter'); ?></a>
				</span>
			</div>
		</div>

		<div class="recom-plugin-wrap">
			<div class="plugin-img-wrap">
				<img src="<?php echo esc_url(get_template_directory_uri() .'/welcome/css/educenterproone.jpg'); ?>" alt="<?php echo esc_html__('Educenter Pro Demo Two', 'educenter'); ?>">
			</div>

			<div class="plugin-title-install clearfix">
				<span class="title"><?php esc_html_e('Educenter Pro Demo Two','educenter'); ?></span>
				<span class="plugin-btn-wrapper">
					<a target="_blank" href="http://demo.sparklewpthemes.com/educenterpro/demo1/" class="button button-primary"><?php echo esc_html__('Preview', 'educenter'); ?></a>
				</span>
			</div>
		</div>

		<div class="recom-plugin-wrap">
			<div class="plugin-img-wrap">
				<img src="<?php echo esc_url(get_template_directory_uri() .'/welcome/css/educenterprotwo.jpg'); ?>" alt="<?php echo esc_html__('Educenter Pro Demo Three', 'educenter'); ?>">
			</div>

			<div class="plugin-title-install clearfix">
				<span class="title"><?php esc_html_e('Educenter Pro Demo Three','educenter'); ?></span>
				<span class="plugin-btn-wrapper">
					<a target="_blank" href="http://demo.sparklewpthemes.com/educenterpro/dem2/" class="button button-primary"><?php echo esc_html__('Preview', 'educenter'); ?></a>
				</span>
			</div>
		</div>

	</div>
</div>

<div class="upgrade-box">
	<div class="upgrade-box-text">
		<h3><?php echo esc_html__('Upgrade To Premium Version (Educenter Pro)', 'educenter'); ?></h3>
		<p><?php echo esc_html__('Educenter Pro Theme you can create a beautiful website. if you want to unlock more possibilites then upgrade to premium version.', 'educenter'); ?></p>
		<p><?php echo esc_html__('Try the Premium version and check if it fits to your need or not.', 'educenter'); ?></p>
	</div>

	<a class="upgrade-button" href="https://sparklewpthemes.com/wordpress-themes/educenterpro/" target="_blank"><?php esc_html_e('Upgrade Now', 'educenter'); ?></a>
</div>