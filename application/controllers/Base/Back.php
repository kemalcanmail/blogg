<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Back extends CI_Controller {
    public $modules_data;
    public $title;
    public $modules;
    public $admin;
    public $includes = [
        'styles'  => [],
        'scripts' => [],
    ];
    public $data;

    public function __construct() {
        parent::__construct();

        $this->load->model('ModuleLoader');
        $this->load->model('Authentication/AdminModel');
    
        $this->modules = $this->ModuleLoader->pageData(); 
        $this->admin   = $this->AdminModel->adminDetails(); 
        
        if(!$this->admin)
            redirect(base_url(AUTH_CONTROLLER . '/login?redirect='.urlencode(current_url())));

        $this->add_module('recaptcha');
        $this->add_module('smtp');

        $this->add_module('updates');

        $this->load->helper('language');
    }

    public function register_module($name, $alias = null) {
        if($alias) {
            $this->modules[$alias] = $this->ModuleLoader->$name();
        } else {
            $this->modules[$name]  = $this->ModuleLoader->$name();
        }

        return true;
    }

    public function add_module($name, $alias = null) {
        if(is_array($name)) {
            if(is_assoc($name)) {
                foreach($name as $module => $a) {
                    $this->register_module($module, $a);
                }   
            } else {
                foreach($name as $n) {
                    $this->register_module($n);
                }
            }
        } else
            $this->register_module($name, $alias);
    }

    public function register_style($url, $pos) {
        array_push(
            $this->includes['styles'],
            [
                'href' => $url,
                'position' => $pos
            ]
        );
    }

    public function include_styles($url, $position = 'header') {
        if(is_array($url)) {
            if(is_assoc($url)) {
                foreach($url as $pos => $src) {
                    $this->register_style($src, $pos);
                }
            } else {
                foreach($url as $src) {
                    $this->register_style($src, $position);
                }
            }
        } else {
            $this->register_style($url, $position);
        }
    }

    public function register_script($url, $pos) {
        array_push(
            $this->includes['scripts'],
            [
                'src' => $url,
                'position' => $pos
            ]
        );
    }

    public function include_scripts($url, $position = 'footer') {
        if(is_array($url)) {
            if(is_assoc($url)) {
                foreach($url as $pos => $src) {
                    $this->register_script($src, $pos);
                }
            } else {
                foreach($url as $src) {
                    $this->register_script($src, $position);
                }
            }
        } else {
            $this->register_script($url, $position);
        }
    }

    public function end($name) {
        $scripts = $this->includes['scripts'];
        $styles  = $this->includes['styles'];

        $view_data = [
            'title'           => $this->title,
            'modules'         => $this->modules,
            'admin'           => $this->admin,
            'data'            => $this->data,
            'includes'        => $this->includes,
            'include_styles'  => function($pos = "header")  use ($styles) { foreach( $styles as $style ) { if($style['position'] == $pos) echo '<link rel="stylesheet" href="' . $style['href'] . '" />'; } },
            'include_scripts' => function($pos = "footer")  use ($scripts) { foreach( $scripts as $script ) { if($script['position'] == $pos) echo '<script type="text/javascript" src="' . $script['src'] . '"></script>'; } },
            'view'            => function($view, $data = null) { return $this->load->view('admin/' . $view, $data); }
        ]; 

        if(is_array($name)) {
            foreach($name as $n) {
                $this->load->view('admin/' . $n, $view_data);
            }
            return true;
        } else
            return $this->load->view('admin/' . $name, $view_data);
    }

    public function refresh_module($name) {
        $this->modules[$name] = $this->ModuleLoader->$name();
        return true;
    }

    public function overwrite_module($name, $val) {
        $this->modules[$name] = $val;
        return true;
    }
}