<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once BASE . 'Front.php';

class Contact extends Front {
	public function index() {
		$this->title = "Contact Us - " . $this->general['title'];
		$this->add_module('smtp');
		$this->add_module('recaptcha');

		if($this->input->post('submit')) {
			$name    = $this->input->post('full-name');
			$address = $this->input->post('email');
			$message = $this->input->post('message');

			$this->form_validation->set_rules([
				[
					'field' => 'full-name',
					'label' => 'Full Name',
					'rules' => 'required'
				],
				[
					'field' => 'email',
					'label' => 'E-Mail Address',
					'rules' => 'required|valid_email'
				],
				[
					'field' => 'message',
					'label' => 'Message',
					'rules' => 'required'
				]
			]);

			if($this->form_validation->run()) {
				$this->load->library('xl_mailer', $this->smtp);
				
				$mail = array(
					'to' 		=> $this->smtp['email'],
					'from'  	=> array($address, 'Contact Message'),
					'reply_to' 	=> array($address, $name),
					'subject'  	=> 'New message from ' . esc($name),
					'message'  	=> '<p>Message from: ' . esc($name) . '</p><p>' . nl2br($message) . '</p>'
				);

				$res = $this->xl_mailer->send_mail($mail);
				if(!$res) 
					$this->data['alert'] = array(
						'type'  => 'danger',
						'msg'	=> 'There was an error sending your message. Please try again later.'
					);
				else 
					$this->data['alert'] = array(
						'type'	=> 'success',
						'msg'	=> 'Your message has been sent!'
					);
			} else {
				$this->data['alert'] = [
					'type' => 'danger',
					'msg'  => 'Some errors were found.'
				];
			}
		}

		$this->end('contact');
	}
}
