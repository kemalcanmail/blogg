<?php

defined('BASEPATH') or exit('No direct script access allowed');

require_once BASE . 'Front.php';

class Whois extends Front {	
    public function __construct() {
        parent::__construct();

        $this->load->driver('cache', array('adapter' => 'file'));
    }

    public function index($link = null) {
        if ($link != null) {
            $this->title = 'Whois Information';
            $this->data['whoisData'] = $this->queryWhois($link);
        
            $this->include_scripts([
                public_assets('js/inc/main.js'),
                public_assets('js/inc/app.js')
            ]);
        
            $this->end('whois');
        } else {
            redirect(base_url());
        }
    }

    public function updateThumb($link = null) {
        if (($link) || ($link = $this->input->post('link'))) {
            $cacheVar = "whois_domain_$link";
            $whoisData = $this->cache->get($cacheVar);

            if ($whoisData) {
                $thumbUrl = $whoisData['domainThumb'];
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => $thumbUrl,
                    CURLOPT_USERAGENT => 'Codular Sample cURL Request'
                ));
                $img = curl_exec($curl);
                curl_close($curl);

                $thumbData = base64_encode($img); 
                if ($thumbData != "U25hcAo=") {
                    $whoisData['domainThumb'] = $thumbData; 
                    $whoisData['isfirstRun'] = 0;
                    $this->cache->save($cacheVar, $whoisData, 1296000);
                }
            }
        }
    }

    private function queryWhois($link) {
        $cacheVar = "whois_domain_" . $link;
        $whoisData = null;//$this->cache->get($cacheVar);

        if (!$whoisData) {
            $this->load->library('whois_lib');
            $whoisData = $this->whois_lib->query($link);

            if (!is_array($whoisData))
                if (mb_substr($whoisData, 0, 3) == "++[")
                    die($whoisData);

            $this->cache->save($cacheVar, $whoisData, 1296000);
            $this->updateThumb($link);
        }

        $timeStamp = strtotime($whoisData["whoisDate"]);
        $timeStampNew = strtotime('+1 Days', $timeStamp);
        $timeNow = time();
        $this->title = ucfirst($link) . ' Whois Information';
        $whoisData["showUpdateBtn"] = null;

        if ($timeNow  >=  $timeStampNew) {
            $whoisData["showUpdateBtn"] = 1;
        } else {
            $whoisData["showUpdateBtn"] = 0;
        }
        
        return $whoisData;
    }

    public function updateWhois() {
        $link = $this->input->post('link');
        $cacheVar = "whois_domain_" . $link;


        $this->load->library('whois_lib');
        $whoisData = $this->whois_lib->query($link);

        if (!is_array($whoisData))
            if (mb_substr($whoisData, 0, 3) == "++[")
                die($whoisData);

        $this->cache->save($cacheVar, $whoisData, 1296000);
        $this->updateThumb($link);
    }
}