<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once BASE . 'AdminAuth.php';

class Auth extends AdminAuth {
	public function index() {        
        redirect(base_url(GENERAL_CONTROLLER));
	}

	// Logs in the User. Returns User Info if Success. Returns False on Invalid.
	public function login() {
		if($this->admin)
			redirect(base_url(GENERAL_CONTROLLER));

		$this->title = 'Login - ' . PRODUCT_NAME;
		$this->data  = array(
			'body_class' => 'login',
			'error' => false,
			'redirect_to' => $this->input->get('redirect')
		);

		if($this->input->post('submit')) {
			$this->form_validation->set_rules('identifier', 'Username / E-Mail', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');

			if($this->form_validation->run()) {
				$user = $this->AdminModel->login($this->input->post('identifier'), $this->input->post('password'), $this->input->post('remember-me'));
				if($user) {
					$this->cache->delete('updates-info');
					$this->cache->delete('is-update-uploaded');
					if($redirect_to = $this->input->post('redirect'))
						redirect(urldecode($redirect_to));
					redirect(GENERAL_CONTROLLER);
				} else {
					$this->data['error'] = 'Invalid Credentials.';
				}
			}
		}

		$this->end('auth/login');
	}

	public function logout() {
		if($this->AdminModel->adminDetails()) {
			$this->AdminModel->logout();
		}

		redirect(base_url(AUTH_CONTROLLER . '/login'));
	}
}
