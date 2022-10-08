<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once BASE . 'Front.php';

class Page extends Front {
	public function index($permalink = null) {
		$this->load->model('Modules/PageModel');
        if($permalink && $page = $this->PageModel->get_page($permalink)) {
            $this->data['page'] = $page;
            $this->end('page');
        } else
            redirect(base_url());
    }
}
