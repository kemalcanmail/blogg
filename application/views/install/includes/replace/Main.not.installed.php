<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {
	public function index() { ?>
			<p>
				<span>You have not installed the script yet.</span>
				<a href="install">Click here to Install</a>.
			</p> <?php
		
		return true;
	}
}