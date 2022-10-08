<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {
    public $title;
    public $meta;
    public $general;
    public $scripts;
    public $meta_tags;
    public $ads;
    public $analytics;
    public $pages;
    public $theme;
    public $language;
    public $theme_view;
    public $assets;
    
    public $includes = [
        'scripts' => [],
        'styles'  => []
    ];

    public $modules = [
        'general',
        'scripts',
        'meta_tags',
        'ads',
        'analytics',
        'pages',
        'theme',
        'language',
        'theme_view',
        'assets'
    ];

    public $data    = [];
    
    public function __construct() {
        parent::__construct();

        $this->load->model('ModuleLoader');

        $_page = $this->ModuleLoader->pageData();

        $this->general    = $_page['general'];
        $this->scripts    = $_page['scripts'];
        $this->meta_tags  = $_page['meta_tags'];
        $this->ads        = $_page['ads'];
        $this->analytics  = $_page['analytics'];
        $this->pages      = $_page['pages'];
        $this->theme      = $_page['theme'];
        $this->language   = $_page['language'];

        $this->load->helper('language');
        
        return $this;
    }

    public function register_module($name, $alias = null) {
        if($alias) {
            array_push($this->modules, $alias);
            $this->$alias = $this->ModuleLoader->$name();
        } else {
            array_push($this->modules, $name);
            $this->$name = $this->ModuleLoader->$name();
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

    public function add_language($names) {
        $this->lang->load($names, $this->language['idiom']);
    }

    public function view($view, $data) {
        return $this->load->view('themes/'.$this->theme.'/'.$view, $data);
    }

    public function assets($view, $data) {
        return base_url('application/views/themes/'.$theme.'/assets/'.$path); return true;
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

    public function end($view, $mode = "text/html") {
        if($mode == 'text/html') {
            $ads          = $this->ads;
            $scripts_core = $this->scripts; 
            $scripts      = $this->includes['scripts'];
            $styles       = $this->includes['styles'];
            $theme        = $this->theme;
            $modules      = $this->modules; 
    
            foreach($modules as $name) {
                $view_data[$name] = $this->$name;
            }
    
            $view_data = [
                'title'           => $this->title,
                'meta'            => $this->meta,
                'general'         => $this->general,
                'scripts'         => $this->scripts,
                'meta_tags'       => $this->meta_tags,
                'ads'             => $this->ads,
                'analytics'       => $this->analytics,
                'pages'           => $this->pages,
                'theme'           => $this->theme,
                'language'        => $this->language,
                'includes'        => $this->includes,
                'data'            => $this->data,
                'view'            => function($view, $data = null) use ($theme) {
                    return $this->load->view('themes/'.$theme.'/'.$view, $data);
                },
                'assets'          => function($path) use ($theme) {
                    echo base_url('application/views/themes/'.$theme.'/assets/'.$path); return true;
                },
                'module'          => function($name) use ($modules) {
                    return in_array($name, $modules);
                },
                'include_styles'  => function($pos = "header")  use ($styles) {
                    foreach( $styles as $style ) {
                        if($style['position'] == $pos)
                            echo '<link rel="stylesheet" href="' . $style['href'] . '" />';
                    }
                },
                'include_scripts' => function($pos = "footer")  use ($scripts) { 
                    foreach( $scripts as $script ) { 
                        if($script['position'] == $pos) 
                            echo '<script type="text/javascript" src="' . $script['src'] . '"></script>'; 
                    } 
                
                    if(isset($scripts_core[$pos]))
                        echo $scripts_core[$pos];
                },
                'include_ads'    => function($pos) use ($ads) {
                    if(isset($ads[$pos]) && $ads[$pos]['status'])
                        echo $ads[$pos]['code'];
                }
            ];
    
            if(is_array($view)) {
                foreach($view as $v) {
                    $this->view($v, $view_data);
                }
    
                return true;
            } else {
                $this->view($view, $view_data);
                return true;
            }
        } else {
            $this->set_content_type($mode);
            $this->set_output(
                (is_array($view) | is_object($view))
                ? json_encode($view)
                : $view
            );

            return true;
        }
    }
}