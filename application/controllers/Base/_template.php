<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once BASE . 'Front.php';

class _template extends Front {
	public function index() {
		$this->end('main');
	}
}