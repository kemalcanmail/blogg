<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php echo esc($meta_tags, true); ?>
    <meta name="description" content="<?php echo esc($general['description']) ?>">
    <meta name="keywords" content="<?php echo esc($general['keywords']) ?>">
    <link rel="icon" href="<?php echo uploads('img/' . $general['favicon']) ?>">
    <link rel="stylesheet" href="<?php echo public_assets('css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?php $assets('css/style.css'); ?>">
    <title><?php echo isset($title) ? $title : PRODUCT_NAME ?></title>
    <?php 
        echo esc($scripts['header'], true);
        $include_styles('header');
        $include_scripts('header');
        echo esc($analytics, true);
    ?>
</head>
<body>