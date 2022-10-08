<?php

defined('BASEPATH') || exit('Direct script access is prohibited.');

class WhoisModel extends CI_Model {
    private $cache_var;

    public function __construct() {
        parent::__construct();
        $this->cache_var = 'whois-server-settings';
		$this->load->driver('cache', array('adapter' => 'file'));
	}

    public function get() {
        if(!$res = $this->cache->get($this->cache_var)) {
            $this->load->database();
        
            $res = $this->db
            ->select('tld,server')
            ->get('whois-servers')
            ->result_array();

            $this->cache->save($this->cache_var, $res, 86400);
        }

        return $res;
    }
    
    public function set($servers) {
        $this->load->database();

        $this->db->empty_table('whois-servers');
        if(count($servers) > 0)
            $this->db->insert_batch('whois-servers', $servers);

        $this->cache->delete($this->cache_var);
    }
}