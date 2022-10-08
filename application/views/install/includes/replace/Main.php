<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once BASE . 'Front.php';

class Main extends Front {
	public function index() {
		$this->title = $this->general['title'];

		$this->include_scripts(
			public_assets('js/inc/main.js')
		);

		$this->end('main');
	}
}
