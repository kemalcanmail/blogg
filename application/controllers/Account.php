<?php

defined('BASEPATH') || exit('Direct script access is blocked.');

require_once BASE . 'Back.php';

class Account extends Back {
    public function me() {
        $this->data['page_title'] = 'My Account';

        // If submit.
        if($this->input->post('submit')) {
            $username       = $this->input->post('admin-username');
            $email          = $this->input->post('admin-email');
            $new_password   = $this->input->post('admin-new-password'); // New Pass
            $password       = $this->input->post('admin-password'); // Current Pass

            // By default, Form Validation only checks for Current Password field.
            $rules = array(
                array(
                    'field' => 'admin-password',
                    'label' => 'Current Password',
                    'rules' => 'required'
                )
            );

            // Fields to Update. Empty by default.
            $to_update = array();

            // If username exists & username is not equal to current username. Then add Form Validation rules, and add it in $to_update;
            if($username != $this->admin_user['username']) {
                array_push($rules, array(
                    'field' => 'admin-username',
                    'label' => 'Username',
                    'rules' => 'required|is_unique[admin-users.username]',
                    'errors' => array(
                        'is_unique' => 'That Username is already in use by another Administrator account.'
                    )
                ));
                $to_update['username'] = strtolower($username);
            }
            
            // If email exists, and it's not equal to current email. Add Validation rules and also add it to $to_update;
            if($email != $this->admin_user['email']) {
                array_push($rules, array(
                    'field' => 'admin-email',
                    'label' => 'E-Mail',
                    'rules' => 'required|valid_email|is_unique[admin-users.email]',
                    'errors' => array(
                        'is_unique' => 'That E-Mail is already in use by another Administrator account.'
                    )
                ));
                $to_update['email'] = strtolower($email);
            }
            
            // Same as the above 2 fields, but We're using password_hash() to hash the password before submitting. 
            // The model will not hash the password. SO we have to do it in the controller
            if($new_password) {
                array_push($rules, array(
                    'field' => 'admin-new-password',
                    'label' => 'New Password',
                    'rules' => 'min_length[8]|max_length[48]'
                ));
                $to_update['password'] = password_hash($new_password, PASSWORD_DEFAULT);
            }
            
            $this->load->database();
            $this->form_validation->set_rules($rules);
            $validation = $this->form_validation->run();

            if($validation) {
                // If success, then Verify the user's current password.
                if($this->AdminModel->verifyPassword($this->admin_user['id'], $password)) {
                    // If $to_update includes any fields, then update the user account.
                    if(count($to_update) > 0 && !$this->admin_user['disabled'])
                        $this->AdminModel->updateAccount($this->admin_user['id'], $to_update);

                    // Recreate the session based on newly updated data.
                    $this->admin_user = $this->AdminModel->recreateSession();
                    $this->data['alert'] = array(
                        'type' => 'alert alert-success',
                        'msg'  => 'Account details updated successfully.'
                    );
                } else
                    $this->data['alert'] = array( // Else show an error.
                        'type' => 'alert alert-danger',
                        'msg'  => 'Invalid current Password provided.'
                    );
            }
        }

        $this->end('account/me');
    }
}