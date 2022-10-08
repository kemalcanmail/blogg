<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once BASE . 'Back.php';

class Admin extends Back {
    public function index() {
        redirect(base_url(GENERAL_CONTROLLER));
    }
}
