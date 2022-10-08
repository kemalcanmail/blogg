<?php

defined('BASEPATH') || exit('Direct script access is prohibited.');

class ModuleLoader extends CI_Model {
    private $language;

    public function __construct() {
        parent::__construct();
        $this->load->model('Modules/ThemesModel');
        $this->language = get_language();
    }

    public function general() {
        $this->load->model('Modules/GeneralModel');
        return $this->GeneralModel->get();
    }

    public function scripts() {
        $this->load->model('Modules/ScriptsModel');
        return $this->ScriptsModel->get();
    }
    
    public function ads() {
        $this->load->model('Modules/AdsModel');
        return $this->AdsModel->get();
    }
    
    public function meta_tags() {
        $this->load->model('Modules/MetaModel');
        return $this->MetaModel->get();
    }
    
    public function analytics() {
        $this->load->model('Modules/AnalyticsModel');
        return $this->AnalyticsModel->get();
    }
    
    public function smtp() {
        $this->load->model('Modules/SmtpModel');
        return $this->SmtpModel->get();
    }
    
    public function pages() {
        $this->load->model('Modules/PagesModel');
        return $this->PagesModel->get();
    }
    
    public function recaptcha() {
        $this->load->model('Modules/RecaptchaModel');
        return $this->RecaptchaModel->get();
    }
    
    public function whois() {
        $this->load->model('Modules/WhoisModel');
        return $this->WhoisModel->get();
    }

    public function updates() {
        $this->load->model('Modules/UpdatesModel');
        return $this->UpdatesModel->update_info();
    }
    
    public function theme() {
        return $this->ThemesModel->get();
    }

    public function theme_view() {
        $theme = $this->ThemesModel->get();
        return function($view, $data = null) use ($theme) { return $this->load->view('themes/'.$theme.'/'.$view, $data); };
    }
    
    public function assets() {
        $theme = $this->ThemesModel->get();
        return function($path) use ($theme) { echo base_url('application/views/themes/'.$theme.'/assets/'.$path); return true; };
    }
    
    public function language() {
        return $this->language;
    }

    public function language_mode() {
        return $this->config->item('idioms')[$this->language];
    }

    public function pageData() {
        $this->load->model('Modules/GeneralModel');
        $this->load->model('Modules/ScriptsModel');
        $this->load->model('Modules/MetaModel');
        $this->load->model('Modules/AdsModel');
        $this->load->model('Modules/RecaptchaModel');
        $this->load->model('Modules/AnalyticsModel');
        $this->load->model('Modules/ThemesModel');
        $this->load->model('Modules/PageModel');
        $this->load->model('Modules/SmtpModel');
        $this->load->model('UpdatesModel');

        $this->config->load('languages');
        
        $idiom = get_language();
        $settings = array(
            'general'   => $this->GeneralModel->get(),
            'scripts'   => $this->ScriptsModel->get(),
            'meta_tags' => $this->MetaModel->get(),
            'ads'       => $this->AdsModel->get(),
            'analytics' => $this->AnalyticsModel->get(),
            'pages'     => $this->PageModel->get(),
            'theme'     => $this->ThemesModel->get(),
            'language'  => [
                'idiom' => $idiom,
                'mode'  => $this->config->item('idioms')[$idiom]
            ]
        );

        $theme = $settings['theme'];

        return $settings;
    }
}
