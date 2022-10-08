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

class Whois_settings extends Back {
	public function index() {
        redirect(base_url(whois_settings . '/servers'));
    }
    
    //WHOIS Servers Function
    public function servers() {
        $this->add_module('whois');

        $this->title              = 'WHOIS Servers - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'WHOIS Servers';

        if($this->input->post('submit') && !$this->admin['disabled']) {
            $servers = $this->input->post('servers');
            $servers = json_decode($servers, true);

            if(count($servers) > 0) {
                $this->load->model('Modules/WhoisModel');

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

        $this->end('whois-settings/servers.php');
    }

    //WHOIS Servers Responce Signatures Match Function
    public function signatures() {
        $this->add_module('whois');

        $this->title              = 'WHOIS Signatures - ' . PRODUCT_NAME;
        $this->data['page_title'] = 'WHOIS Signatures';

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

        $this->end('whois-settings/signatures.php');
    }

}
