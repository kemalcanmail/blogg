<?php

defined('BASEPATH') || exit('Access Denied.');


function is_uploaded($img) {
	return file_exists($_FILES[$img]['tmp_name']);
}

function is_image($img) {
	$mimes = array(
		'image/png',
		'image/svg+xml',
		'image/svg',
		'image/webp',
		'image/jpeg',
		'image/gif'
	);

	return in_array(mime_content_type($_FILES[$img]['tmp_name']), $mimes);
}