<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title><?php echo $title ? $title : PRODUCT_NAME ?></title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?php echo uploads('img/'.$modules['general']['favicon']) ?>" />
	<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
	<meta content="utf-8" http-equiv="encoding">
	<script type="text/javascript">
		"use strict";
		const base = '<?php echo esc(base_url()) ?>';
		const layout = '<?php echo esc(LAYOUT_CONTROLLER); ?>';
		const updates = '<?php echo esc(UPDATES_CONTROLLER); ?>';
		const fonts = '<?php echo public_assets('css/fonts.min.css'); ?>';
	</script>
	<script type="text/javascript" src="<?php echo admin_assets('js/plugin/webfont/webfont.min.js') ?>"></script>
	<script type="text/javascript" src="<?php echo admin_assets('js/includes/font-loader.js'); ?>"></script>
	<link rel="stylesheet" href="<?php echo public_assets("css/bootstrap.min.css") ?>">
	<link rel="stylesheet" href="<?php echo admin_assets("css/xladmin.css") ?> ">
	<?php 
		$include_styles('header');
		$include_scripts('header'); 
	?>
</head>
<body class="<?php echo esc(isset($data['body_class']) ? $data['body_class'] : '') ?>">