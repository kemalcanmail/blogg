<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AdminAuth extends CI_Controller {
    public $modules_data;
    public $title;
    public $modules;
    public $data;

    public function __construct() {
        parent::__construct();

        $this->load->model('ModuleLoader');
        $this->load->model('Authentication/AdminModel');
    
        $this->modules_data = $this->ModuleLoader->pageData(); 
        $this->admin        = $this->AdminModel->adminDetails(); 
        

        $this->load->helper('language');
    }

    public function register_module($name, $alias = null) {
        if($alias) {
            $this->modules_data[$alias] = $this->ModuleLoader->$name();
        } else {
            $this->modules_data[$name] = $this->ModuleLoader->$name();
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

    public function end($name) {
        $view_data = [
            'title'           => $this->title,
            'modules'         => $this->modules_data,
            'admin'           => $this->admin,
            'data'            => $this->data,
            'include_styles'  => function() { return true; },
            'include_scripts' => function() { return true; },
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
}