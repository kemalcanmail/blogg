<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/* ------------------------------

Layout Controller

This controller is part of the Administrator Panel.
It is used to update Basic Settings for the Website.

Settings like Ads, Analytics, Header/Footer scripts, Meta Tags, Page Content are managed by this controller.

Only accessible to Administrators.

------------------------------ */

require_once BASE . 'Back.php';

class Layout extends Back {
	public function index() {
        redirect(base_url(LAYOUT_CONTROLLER . '/pages'));
    }
    
    public function whois() {
        $this->add_module('whois');

        $this->title              = 'WHOIS Settings - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'WHOIS Settings';

        if($this->input->post('submit') && !$this->admin['disabled']) {
            $servers = $this->input->post('servers');
            $servers = json_decode($servers, true);

            if(count($servers) > 0) {
                $this->load->model('Settings/WhoisModel');

                $filtered = array_filter(array_map(function($arr) {
                    if(isset($arr['tld']) && isset($arr['server']))
                        return [
                            'id'     => NULL,
                            'tld'    => $arr['tld'],
                            'server' => $arr['server']
                        ];
                }, $servers), function($var) {
                    return isset($var) && !empty($var);
                });

                $this->WhoisModel->set($filtered);
            } else {
                $this->WhoisModel->set([]);
            }
        }

        $this->include_scripts(
            admin_assets('js/includes/whois.js')
        );

        $this->end('layout/whois');
    }

    // Used to update Header / Footer scripts of the website.
    public function scripts() {
        $this->title = 'Header / Footer Scripts - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'Header / Footer Scripts';

        if($this->input->post('submit') && !$this->admin['disabled']) {
            $header = $this->input->post('site-header-scripts');
            $footer = $this->input->post('site-footer-scripts');

            $this->load->model('Modules/ScriptsModel');
            
            $this->ScriptsModel->set(array(
                'header' => htmlentities($header),
                'footer' => htmlentities($footer)
            ));

            $this->refresh_module('scripts'); // Refresh the Scripts;
            $this->data['alert'] = array(
                'type' => 'alert alert-success',
                'msg' => 'Scripts updated successfully'
            );
        }

        $this->end('layout/scripts');
    }

    // Used to Update analytics settings.
    public function analytics() {
        $this->title = 'Analytics Settings - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'Analytics Settings';

        if($this->input->post('submit') && !$this->admin['disabled']) {
            $analytics = $this->input->post('site-analytics');

            $this->load->model('Modules/AnalyticsModel');
            
            $this->AnalyticsModel->set(array(
                'code' => htmlentities($analytics),
            ));

            $this->refresh_module('analytics');
            $this->data['alert'] = array(
                'type' => 'alert alert-success',
                'msg' => 'Analytics Code updated successfully'
            );
        }

        $this->end('layout/analytics');
    }

    // Used to Update recaptcha settings.
    public function recaptcha() {
        $this->title              = 'Recaptcha Settings - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'Recaptcha Settings';

        if($this->input->post('submit') && !$this->admin['disabled']) {
            $site = $this->input->post('site-key');
            $secret = $this->input->post('secret-key');
            $status = $this->input->post('site-status');

            $this->load->model('Modules/RecaptchaModel');
            
            $rules = array();
            if($status) {
                $rules = array(
                    array(
                        'field' => 'site-key',
                        'label' => 'Site Key',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'secret-key',
                        'label' => 'Secret Key',
                        'rules' => 'required'
                    ),
                );
            }

            $this->form_validation->set_rules($rules);
            $validation = (count($rules) > 0) ? $this->form_validation->run() : true;
            if($validation) {
                $to_update = array(
                    'status' => ($status) ? true : false
                );

                if($site)   $to_update['site_key'] = $site;
                if($secret) $to_update['secret_key'] = $secret;

                $this->RecaptchaModel->set($to_update);

                $this->refresh_module('recaptcha');
                $this->data['alert'] = array(
                    'type' => 'alert alert-success',
                    'msg' => 'Recaptcha Settings updated successfully'
                );
            }
        }

        $this->end('layout/recaptcha');
    }
    
    // Used to Update analytics settings.
    public function email() {
        $this->title = 'E-Mail Settings - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'E-Mail & SMTP Settings';

        $this->include_scripts(
            admin_assets('js/includes/email_settings.js')
        );

        if($this->input->post('submit') && !$this->admin['disabled']) {
            $email      = $this->input->post('site-smtp-email');
            $status     = $this->input->post('site-smtp-status');
            $host       = $this->input->post('site-smtp-host');
            $port       = $this->input->post('site-smtp-port');
            $username   = $this->input->post('site-smtp-username');
            $password   = $this->input->post('site-smtp-password');

            $rules = array();
            if($status) {
                $rules = array(
                    array(
                        'field' => 'site-smtp-host',
                        'label' => 'Host',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'site-smtp-port',
                        'label' => 'host',
                        'rules' => 'required|numeric'
                    ),
                    array(
                        'field' => 'site-smtp-username',
                        'label' => 'Username',
                        'rules' => 'required'
                    ),
                    array(
                        'field' => 'site-smtp-password',
                        'label' => 'Password',
                        'rules' => 'required'
                    )
                );
            }

            array_push($rules, array(
                'field' => 'site-smtp-email',
                'label' => 'E-Mail Address',
                'rules' => 'required|valid_email',
            ));

            $this->form_validation->set_rules($rules);
            $validation = $this->form_validation->run();

            if($validation) {
                $to_update = array(
                    'email' => strtolower($email)
                );

                if($status) {
                    $to_update['status']   = true;
                    $to_update['host']     = strtolower($host);
                    $to_update['port']     = $port;
                    $to_update['username'] = $username;
                    $to_update['password'] = $password;
                }

                $this->load->model('Modules/SmtpModel');

                $this->SmtpModel->set($to_update);
                $this->refresh_module('email');
                $this->data['alert'] = array(
                    'type' => 'alert alert-success',
                    'msg' => 'E-Mail settings updated successfully'
                );
            } else {
                $this->data['alert'] = array(
                    'type' => 'alert alert-danger',
                    'msg' => 'Please fix the following errors below.'
                );
            }
        }

        $this->end('layout/email');
    }
    
    // Used to update Meta Tags.
    public function meta_tags() {
        $this->title = 'Meta Tags Settings - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'Meta Tags Settings';

        if($this->input->post('submit') && !$this->admin['disabled']) {
            $tags = $this->input->post('site-meta-tags');

            $this->load->model('Modules/MetaModel');

            $tags = $this->security->xss_clean($tags);

            $this->MetaModel->set(array(
                'meta_tags' => htmlentities($tags),
            ));

            $this->refresh_module('meta_tags');
            $this->data['alert'] = array(
                'type' => 'alert alert-success',
                'msg' => 'Meta Tags updated successfully'
            );
        }

        $this->end('layout/meta_tags');
    }

    // Used to update Ads settings
    public function ads() {
        $this->title = 'Ad Settings - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'Ad Settings';

        if($this->input->post('submit') && !$this->admin['disabled']) {
            // Fetch the Statuses of Ad settings.
            $top_status     = $this->input->post('site-top-ad-status');
            $bottom_status  = $this->input->post('site-bottom-ad-status');
            $pop_status     = $this->input->post('site-pop-ad-status');

            // Top Ad Code is required if Status is enabled.
            if($top_status)
                $this->form_validation->set_rules('site-top-ad-code', 'Top Ad Code', 'required');

            // Bottom Ad Code is required if Status is enabled.
            if($bottom_status)
                $this->form_validation->set_rules('site-bottom-ad-code', 'Bottom Ad Code', 'required');

            // Pop Ad Code is required if status is enabled.
            if($pop_status)
                $this->form_validation->set_rules('site-pop-ad-code', 'Pop Ad Code', 'required');

            
            // Fetch Ad codes
            $top_code       = $this->input->post('site-top-ad-code');
            $bottom_code    = $this->input->post('site-bottom-ad-code');
            $pop_code       = $this->input->post('site-pop-ad-code');

            // $to_update fields, True or False based on statuses
            $to_update = array(
                'top_ad_status'     => ($top_status) ? true : false,
                'bottom_ad_status'  => ($bottom_status) ? true : false,
                'pop_ad_status'     => ($pop_status) ? true : false,
            );
        
            // If they exist, then convert to htmlentities and add ad codes into $to_update.
            if($top_code)       $to_update['top_ad']    = htmlentities($top_code);
            if($bottom_code)    $to_update['bottom_ad'] = htmlentities($bottom_code);
            if($pop_code)       $to_update['pop_ad']    = htmlentities($pop_code);

            // Load Ads Model
            $this->load->model('Modules/AdsModel');

            if($this->form_validation->run()) {
                $this->AdsModel->set($to_update);

                $this->data['alert'] = array(
                    'type'  => 'alert alert-success',
                    'msg'   => 'Ad settings updated successfully.'
                );
            } else if(!$top_status && !$bottom_status && !$pop_status) {
                $this->AdsModel->set($to_update);

                $this->data['alert'] = array(
                    'type'  => 'alert alert-success',
                    'msg'   => 'Ad settings updated successfully.'
                );
            }

            // Refresh Ads settings.
            $this->refresh_module('ads');                
        }

        $this->end('layout/ads');
    }

    // Function responsible for changing Page Settings.
    public function pages() {
        $this->load->model('Modules/PageModel');

        $this->title = 'Pages - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'Pages';
        $this->data['all_pages']  = $this->PageModel->get();

        $this->include_scripts([
            admin_assets('js/includes/sortables.min.js'),
            admin_assets('js/includes/sortable_list.js'),
        ]);

        $this->end('layout/pages/main');
    }

    // Responsible for editing a specific page.
    public function edit_page($permalink = null) {
        $this->load->model('Modules/PageModel');
        if($permalink && $page = $this->PageModel->get_page($permalink)) {
            $this->title = 'Editing ' . html_entity_decode($page['title']) . ' - ' . PRODUCT_NAME;
            $this->data['page_title'] = 'Editing ' . html_entity_decode($page['title']);
            $this->data['page'] = $page;

            $this->include_scripts([
                admin_assets('js/plugin/summernote/summernote-bs4.min.js'),
                admin_assets('js/includes/editor.js')
            ]);

            if($this->input->post('submit') && !$this->admin['disabled']) {
                $title      = $this->input->post('page-title');
                $content    = $this->input->post('page-content');
                $permalink  = $this->input->post('page-permalink');
                $position   = $this->input->post('page-position');
                $status     = $this->input->post('page-status');
                
                $rules = array(
                    array(
                        'field'     => 'page-title',
                        'label'     => 'Title',
                        'rules'     => 'required'
                    ),
                    array(
                        'field'     => 'page-content',
                        'label'     => 'Content',
                        'rules'     => 'required'
                    ),
                    array(
                        'field'     => 'page-position',
                        'label'     => 'Position',
                        'rules'     => 'required|in_list[1,2,3]'
                    )
                );

                if($permalink != $page['permalink']) {
                    $this->load->database();
                    array_push($rules, array(
                        'field'     => 'page-permalink',
                        'label'     => 'Permalink',
                        'rules'     => 'required|is_unique[pages.permalink]|alpha_dash',
                        'errors'    => array(
                            'is_unique' => 'That permalink is already in use.',
                            'alpha_dash' => 'Please only use Alphanumeric characters, undescrores & dashes.'
                        )
                    ));
                }

                $this->form_validation->set_rules($rules);
                $validation = $this->form_validation->run();

                if($validation) {
                    $to_update = array(
                        'title' => htmlentities($title),
                        'content' => htmlentities($content),
                        'permalink' => strtolower($permalink),
                        'position'  => $position,
                        'status' => $status ? true : false
                    );

                    $this->PageModel->set_page($page['permalink'], $to_update);

                    $this->session->set_flashdata('alert', array(
                        'type' => 'alert alert-success',
                        'msg'  => 'Successfully updated Page.'
                    ));

                    redirect(LAYOUT_CONTROLLER . '/edit_page/' . $to_update['permalink']);
                }
            }

            $this->end('layout/pages/edit_page');
        } else
            redirect(base_url(LAYOUT_CONTROLLER . '/pages'));
    }

    // Function responsible for Creating Page.
    public function create_page() {
        $this->title = 'Create New Page - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'Create New Page';

        $this->include_scripts([
            admin_assets('js/plugin/summernote/summernote-bs4.min.js'),
            admin_assets('js/includes/editor.js')
        ]);


        if($this->input->post('submit') && !$this->admin['disabled']) {
            $title      = $this->input->post('page-title');
            $content    = $this->input->post('page-content');
            $permalink  = $this->input->post('page-permalink');
            $position   = $this->input->post('page-position');

            $this->load->database();
            $rules = array(
                array(
                    'field'     => 'page-title',
                    'label'     => 'Title',
                    'rules'     => 'required'
                ),
                array(
                    'field'     => 'page-content',
                    'label'     => 'Content',
                    'rules'     => 'required'
                ),
                array(
                    'field'     => 'page-position',
                    'label'     => 'Position',
                    'rules'     => 'required|in_list[1,2,3]'
                )
            );

            if($permalink) {
                array_push($rules, array(
                    'field'     => 'page-permalink',
                    'label'     => 'Permalink',
                    'rules'     => 'required|is_unique[pages.permalink]|alpha_dash',
                    'errors'    => array(
                        'is_unique' => 'That permalink is already in use.',
                        'alpha_dash' => 'Please only use Alphanumeric characters, undescrores & dashes.'
                    )
                ));
            } else {
                $permalink = securePermalink($title);
            }

            $this->form_validation->set_rules($rules);
            $validation = $this->form_validation->run();

            if($validation) {
                $this->load->model('Modules/PageModel');

                $order = $this->PageModel->get_new_page_order();

                $new_page = array(
                    'title'         => htmlentities($title),
                    'content'       => htmlentities($content),
                    'permalink'     => strtolower($permalink),
                    'position'      => $position,
                    'status'        => true,
                    'page_order'    => $order
                );

                $this->PageModel->create_page($new_page);

                $this->session->set_flashdata('alert', array(
                    'type' => 'alert alert-success',
                    'msg'  => 'New page created successfully.'
                ));

                redirect(base_url(LAYOUT_CONTROLLER . '/edit_page/' . strtolower($permalink)));
            }
        }

        $this->end('layout/pages/create_page');
    }
    
    // Used as the Confirmation for deleting a page.
    public function delete_page($permalink = null, $confirm = false) {
        $this->load->model('Modules/PageModel');
        if($permalink && $page = $this->PageModel->get_page($permalink)) {
            $this->title              = 'Delete ' . html_entity_decode($page['title']) . ' - ' . PRODUCT_NAME;
            $this->data['page_title'] = 'Delete ' . html_entity_decode($page['title']);
            $this->data['page']       = $page;

            if($confirm && !$this->admin['disabled']) {
                $this->PageModel->delete_page($permalink);
                redirect(base_url(LAYOUT_CONTROLLER . '/pages'));
            }

            $this->end('layout/pages/delete_page.php');
        } else
            redirect(base_url(LAYOUT_CONTROLLER . '/pages'));
    }

    // AJAX Route for Updating Page Order.
    public function update_page_order() {
        $data = $this->input->post('order');

        if($data && $this->input->post('ref')) {
            $this->load->model('Modules/PageModel');
            $res = $this->PageModel->set_order(json_decode($data, true));

            if($res) {
                echo json_encode(array(
                    'success' => true
                ));
                return true;
            }
        }

        echo json_encode(array(
            'success' => false
        ));

        return false;
    }
}
