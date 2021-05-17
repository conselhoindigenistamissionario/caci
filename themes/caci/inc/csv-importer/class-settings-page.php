<?php
/**
 * Generated by the WordPress Option Page generator
 * at http://jeremyhixon.com/wp-tools/option-page/
 */

class Hacklab_CSV_Settings {
	private $hacklab_csv_deploy_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'hacklab_csv_deploy_add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'hacklab_csv_deploy_page_init' ) );
	}
       
	public function hacklab_csv_deploy_add_plugin_page() {
		add_management_page(
			'Importar casos via CSV', // page_title
			'Importar casos via CSV', // menu_title
			'manage_options', // capability
			'hacklab-csv-import', // menu_slug
			array( $this, 'hacklab_csv_deploy_create_admin_page' ) // function
		);
	}

	public function hacklab_csv_deploy_create_admin_page() {
		$this->hacklab_csv_deploy_options = get_option( 'hacklab_csv_deploy_option_name' ); ?>

		<div class="wrap">
			<h2>Importar casos via arquivo .CSV</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php
					settings_fields( 'hacklab_csv_deploy_option_group' );
					do_settings_sections( 'hacklab-json-deploy-admin' );
					submit_button( 'Enviar' );
				?>
			</form>
		</div>
	<?php }

	public function hacklab_csv_deploy_page_init() {
		register_setting(
			'hacklab_csv_deploy_option_group', // option_group
			'hacklab_csv_deploy_option_name', // option_name
			array( $this, 'hacklab_csv_deploy_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'hacklab_csv_deploy_setting_section', // id
			'Settings', // title
			array( $this, 'hacklab_csv_deploy_section_info' ), // callback
			'hacklab-json-deploy-admin' // page
		);

		add_settings_field(
			'csv_file', // id
			'Arquivo .CSV', // title
			array( $this, 'csv_file_callback' ), // callback
			'hacklab-json-deploy-admin', // page
			'hacklab_csv_deploy_setting_section' // section
		);
	}

	public function hacklab_csv_deploy_sanitize($input) {
        $GLOBALS[ 'hacklab_csv' ]->import_from_csv( $input );
        return $input;
    }
    public function hacklab_csv_deploy_section_info() {
		
	}

	public function csv_file_callback() {
		echo '<input class="regular-text" type="file" accept=".csv" name="hacklab_csv_file" id="json_file" required>';
	}

}
if ( is_admin() ) {
    $hacklab_csv_settings_page = new Hacklab_CSV_Settings();
}