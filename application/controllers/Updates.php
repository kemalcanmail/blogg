<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* ------------------------------

Updates Controller

This controller is part of the Administrator Panel.
It is used to update the Script.

Only accessible to Administrators.

------------------------------ */

require_once BASE . 'Back.php';

class Updates extends Back {
    /* This is a Controller only accessible to Administrator Accounts */
    public function __construct() {
        parent::__construct();

        $this->cache->delete('updates-info');
        $this->cache->delete('is-update-uploaded');
    }

	public function index() {
        redirect(base_url(UPDATES_CONTROLLER . '/main'));
    }
    
    // This Function is responsible for Loading and Visualizing Basic Information for the User.
    public function main() {
        $this->title = 'Updates - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'Updates';
        
        $this->include_scripts(
            admin_assets('js/includes/updates.js')
        );

        $this->end('updates/main');
    }

    public function ajax_extract_package() {
        if(file_exists(APPPATH."third_party/update/upload.zip") && file_exists(APPPATH."third_party/update/update.json")) {
            $this->load->database();
            $this->load->model('UpdatesModel');
            $host = $this->db->hostname;
            $username = $this->db->username;
            $password = $this->db->password;
            $database = $this->db->database;
            $base_url = $this->config->item('base_url');
            $encryption_key = $this->config->item('encryption_key');
            $file = APPPATH."third_party/update/upload.zip";
            $path = FCPATH;
            $zip = new ZipArchive;
            $res = $zip->open($file);
            if ($res === TRUE) {
                $zip->extractTo($path);
                $zip->close();
                $this->UpdatesModel->update_db_details($host,$username,$password,$database);
                $this->UpdatesModel->paste_config_details($base_url,$encryption_key);
                echo json_encode(array("success"=>"true"));
            } else {
                echo json_encode(array("success"=>"false"));
                }
        } else {
            echo json_encode(array("success"=>"false"));
        }
    }

    public function ajax_import_database() {
		if($this->UpdatesModel->paste_db_details()) {
		 echo json_encode(array("success"=>"true"));
		} else {
		 echo json_encode(array("success"=>"false"));
		}
	}
	
	public function ajax_finalize_settings() {
		$productInfo = $this->UpdatesModel->fetch_info();
		$updateData = json_decode(file_get_contents(APPPATH."third_party/update/update.json"),true);
        if(count($updateData['deleteFiles']) > 0) {
            foreach($updateData['deleteFiles'] as $file) {
                if(file_exists(FCPATH.$file)) {
                    unlink(FCPATH.$file);
                }
            }
        }
        
		file_put_contents(APPPATH."config/constants.php",file_get_contents(APPPATH.'views/install/includes/constants.php'));
		file_put_contents(APPPATH."config/custom.constants.php",file_get_contents(APPPATH.'views/install/includes/custom.constants.php'));
		if($this->session->has_userdata("version_latest")) {
			$this->session->unset_userdata('version_latest');
		}
		$this->cache->clean();
		echo json_encode(array("success"=>"true"));
	}
}
