<?php settings_errors() ?>
<div class="wrap">
	<div id="icon-tools" class="icon32"><br /></div>
	<h1><?= __( 'WPSID Config', 'wpsid-shortcode') ?></h1>
	<form method="post" action="options.php">
	<?php
	settings_fields( 'wpsid_option_group' );
	do_settings_sections( 'wpsid-setting-admin' );
	submit_button();
	?>
	</form>
</div>
