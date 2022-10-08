<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* ------------------------------

General Controller

This controller is part of the Administrator Panel.
It is used to update General Settings, View Dashboard, and Update Themes for the Website.

Only accessible to Administrators.

------------------------------ */

require_once BASE . 'Back.php';

class General extends Back {
	public function index() {
        redirect(base_url(GENERAL_CONTROLLER . '/settings'));
    }

    // This method is used to update General Settings.
    public function settings() {
        $this->title = 'General Settings - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'General Settings';

        // If the User Submits the Form.
        if($this->input->post('submit') && !$this->admin['disabled']) {
            // Retrieve POST fields
            $title          = $this->input->post('site-title');
            $description    = $this->input->post('site-description');
            $keywords       = $this->input->post('site-keywords');

            // Load GeneralModel
            $this->load->model('Modules/GeneralModel');

            $this->form_validation->set_rules('site-title', 'Title', 'required');
            if($this->form_validation->run()) {
                // Fields to Update
                $to_update = array(
                    'title' => $title,
                    'description' => $description,
                    'keywords' => $keywords
                );

                // Check if Logo or Favicon was uploaded by User. - is_uploaded & is_image are functions from the 'upload' helper.
                if(is_uploaded('site-logo') || is_uploaded('site-favicon')) {

                    // Load the Uploader Class if true.
                    $this->load->library('upload', array(
                        'upload_path' => APPPATH.'uploads/img/',
                        'allowed_types' => '*',
                        'overwrite' => false,
                    ));

                    // This block of code runs for both Favicon & Logo. It will upload the Logo. If there is an error, It will push that error inside $data
                    if(is_uploaded('site-logo')) {
                        if(is_image('site-logo')) {
                            $success = $this->upload->do_upload('site-logo');
                            if($success) {
                                $res = $this->upload->data();
                                $name = $res['file_name'];
                                $to_update['logo'] = $name;
                            } else {
                                $this->data['logo_error'] = 'An unexpected error occured.';
                            }
                        } else {
                            $this->data['logo_error'] = 'Only .gif, .jpg, .jpeg, .png, .svg Files are allowed.';
                        }
                    }

                    if(is_uploaded('site-favicon')) {
                        if(is_image('site-favicon')) {
                            $success = $this->upload->do_upload('site-favicon');
                            if($success) {
                                $res = $this->upload->data();
                                $name = $res['file_name'];
                                $to_update['favicon'] = $name;
                            } else {
                                $this->data['logo_error'] = 'An unexpected error occured.';
                            }
                        } else {
                            $this->data['logo_error'] = 'Only .gif, .jpg, .jpeg, .png, .svg Files are allowed.';
                        }
                    }
                        
                }

                // GenralModel is a Getter & Setter model. Passing an array of Fields to Update.
                $this->GeneralModel->set($to_update);
                $this->modules['general'] = $this->GeneralModel->get(); // Refresh General Settings after the Update.
                $this->data['alert'] = array('type' => 'alert alert-success', 'msg' => 'General settings updated successfully.');
            }
        }

        $this->end('general/settings');
    }

    // This method lets the user choose the theme for their website.
    public function themes() {
        $this->load->model('Modules/ThemesModel');

        $this->title = 'Theme Settings - ' . PRODUCT_NAME;
        $this->data['page_title']    = 'Theme Settings';
        $this->data['current_theme'] = $this->ThemesModel->get();
        $this->data['themes']        = $this->ThemesModel->getAvailableThemes();
    

        $this->end('general/themes/main');
    }

    // This method lets the user upload a theme.
    public function upload_theme() {
        $this->load->model('Modules/ThemesModel');

        $this->title = 'Theme Upload - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'Theme Upload';

        // If Submitted.
        if($this->input->post('submit')) {
            // If file uploaded.
            if(file_exists($_FILES['theme']['tmp_name'])) {
                $this->load->library('upload', array(
                    'upload_path' => APPPATH.'uploads/themes/',
                    'allowed_types' => 'zip|rar',
                    'overwrite' => false,
                ));

                $success = $this->upload->do_upload('theme');
                if($success && !$this->admin['disabled']) {
                    $file = $this->upload->data();

                    // Set up a ZipArchive and open up the newly uploaded zip file.
                    $zip = new ZipArchive;
                    $res = $zip->open($file['full_path']);

                    if($res) {
                        // If successful, Extract the Theme to it's own folder inside /views/themes - And Close the Zip archive.
                        $zip->extractTo(APPPATH.'views/themes/' . str_replace('.zip', '', strtolower($file['file_name'])));
                        $zip->close();
                        $this->session->set_flashdata('alert', array(
                            'type' => 'alert alert-success',
                            'msg'  => 'Theme Installed successfully. To use the new theme, Activate it from the list below.'
                        ));

                        // Redirect to Themes page.
                        redirect(base_url(GENERAL_CONTROLLER . '/themes'));
                    }

                    // Delete the uploaded file.
                    unlink($file['full_path']);
                } else 
                    // Show an error if anything other than .zip was uploaded.
                    $this->data['alert'] = array(
                        'type' => 'alert alert-danger',
                        'msg'  => !$this->admin['disabled'] ? 'Unknown file format. Please only upload .zip files.' : 'Disabled in Demo Mode.'
                    );
            }
        }

        $this->end('general/themes/upload');
    }

    // This function is a middleware function. This function checks if the Theme exists using the method provided by ThemesModel, and applies the theme if it exists.
    public function set_theme($theme = null) {
        if($theme) {
            // Check if Theme exists. If yes, load it's manifest.
            if($manifest = $this->ThemesModel->doesThemeExist($theme)) {
                // Set the Website theme to the theme.
                if(!$this->admin['disabled'])
                    $this->ThemesModel->set(array(
                        'theme' => trim(strtolower($theme))
                    ));

                // Set an alert.
                $this->session->set_flashdata('alert', array(
                    'type' => 'alert alert-success',
                    'msg' => $manifest['name'] . ' was applied successfully.'
                ));
            }
        }

        // Redirect back to Themes.
        redirect(base_url(GENERAL_CONTROLLER . '/themes'));
    }

    // This function is also a middleware function. It is used to clean the cache entirely.
    public function purge_cache() {
        // Load cache driver & Clean it.
        $this->load->driver('cache', array('adapter' => 'file'));
        $this->cache->clean();

        // Set an Alert.
        $this->session->set_flashdata('alert', array(
            'type' => 'alert alert-success',
            'msg' => 'Destroyed all cache successfully.'
        ));

        // Redirect to Dashboard.
        redirect(base_url(GENERAL_CONTROLLER . '/settings'));
    }
}
