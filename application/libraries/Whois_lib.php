<?php
error_reporting(E_ALL & ~E_NOTICE);

class Whois_lib {
  private $whoisServers = [];

  private $returnType = "";
  public $rawWHOIS = [];
  private $CI;

  public function __construct() {
    $this->CI = &get_instance();
    $this->CI->load->model('Modules/WhoisModel');
    $additionalServers = $this->CI->WhoisModel->get();
    foreach($additionalServers as $whoisServer) {
      if(!array_key_exists($whoisServer['tld'], $this->whoisServers)) {
        $this->whoisServers[$whoisServer['tld']] = $whoisServer['server'];
      }
    }
  }

  public function query($domain, $type = 'array', $raw = false) {

    $this->returnType = $type;

    $domain = strip_tags($domain);

    $explodedDomain = explode(".", $domain);
    $explodedCount = count($explodedDomain);
    if (empty($explodedDomain[$explodedCount - 1])) {
      return "++[ERROR_NOT_A_DOMAIN]++";
    }

    $domainArr = array_slice($explodedDomain, -2);
    $domain = implode(".", $domainArr);
    //$domain = $explodedDomain[$explodedCount-2].".".$explodedDomain[$explodedCount-1];

    if ($explodedCount >= 3) {
      if (array_key_exists($explodedDomain[$explodedCount - 1], $this->whoisServers)) {
        if (array_key_exists($explodedDomain[$explodedCount - 2], $this->whoisServers)) {
          //$domain = $explodedDomain[$explodedCount-3].".".$explodedDomain[$explodedCount-2].".".$explodedDomain[$explodedCount-1];
          $domainArr = array_slice($explodedDomain, -3);
          $domain = implode(".", $domainArr);
        }
      }
    }

    $tld = substr($domain, strrpos($domain, '.') + 1);

    $data = [];

    $data = $this->getWhoisResult($domain, $tld);

    if (mb_substr($data[0], 0, 3) == "++[") {
      return $data[0];
    } else {
      $whoisServerFromWhois = $this->parse($data, $domain, 'Domain Name:', ['Whois Server' => 'whois_server'], true);
      if (!empty($whoisServerFromWhois['whois_server'][0])) {
        $data = $this->getWhoisResult($domain, $tld, $whoisServerFromWhois['whois_server'][0]);
      }

      $parsedResult = $this->parseDomain($data, $domain, $tld);

      if (!empty($parsedResult[0])) {
        if (mb_substr($parsedResult[0], 0, 3) == "++[") {
          return $parsedResult[0];
        }
      } else {
        if ($this->returnType == "text") {
          return trim(implode("\n", $data));
        } else {
          return $parsedResult;
        }
      }
    }
  }

  public function getRaw() {
    return $this->rawWHOIS;
  }
  private function getWhoisResult($domain = '', $tld = '', $serverUrl = '') {

    if (empty($domain)) {
      return ["++[ERROR_NOTHING_ENTERED]++"];
    }
    if (strpos($domain, ".") == false) {
      return ["++[ERROR_NOT_A_DOMAIN]++"];
    }

    if (!array_key_exists($tld, $this->whoisServers)) {
      return ["++[ERROR_UNSUPPORTED_TLD]++"];
    }

    if (empty($serverUrl)) {
      $serverUrl = $this->whoisServers[$tld];
    }
    $f = fsockopen($serverUrl, 43);

    $needToBeAddEqual = ["whois.verisign-grs.com", "whois.verisign-grs.net"];

    if (in_array($serverUrl, $needToBeAddEqual)) {
      fputs($f, "=" . $domain . "\r\n");
    } else {
      fputs($f, $domain . "\r\n");
    }

    /*else if($tld == "中文"){
    $domain = str_replace(".中文", ".xn--fiq228c", $domain);
    fputs($f, $domain . "\r\n");
    }*/

    $data = [];

    while (!feof($f)) {
      $data[] = rtrim(fgets($f), "\n");
    }

    if ($this->returnType != "text") {
      $stringsExistToMeanAvailable = ["No Match", "No match", "No match for", "Status: AVAILABLE", "NOT FOUND", "Not found", "No Found", "No information available about domain name", "No matching record.", "No entries found in the AFNIC Database.", "The domain has not been registered.", "Status: free", "No entries found for the selected source(s).", " is free"];
      $stringsExistToMeanErrorInput = ["Incorrect input, please try again.", "Error for \""];
      $stringsExistToMeanWaitSomeTime = ["Please maintain at least " => "Please maintain at least %d-second time before starting another enquiry."];

      $this->rawWHOIS = $data;

      foreach ($data as $eachLine) {
        foreach ($stringsExistToMeanAvailable as $stringExistToMeanAvailable) {
          if (strpos($eachLine, $stringExistToMeanAvailable) !== false) {
            return ["++[ERROR_NO_MATCH]++"];
          }
        }
        foreach ($stringsExistToMeanErrorInput as $stringExistToMeanErrorInput) {
          if (strpos($eachLine, $stringExistToMeanErrorInput) !== false) {
            return ["++[ERROR_INPUT]++"];
          }
        }
        foreach ($stringsExistToMeanWaitSomeTime as $stringExistToMeanWaitSomeTime => $sscanfFullString) {
          if (strpos($eachLine, $stringExistToMeanWaitSomeTime) !== false) {
            if ($sscanfFullString == "N/A") {
              return ["++[PLZ_WAIT_SOME_TIME]++"];
            } else {
              sscanf($eachLine, $sscanfFullString, $second);
                return ["++[PLZ_WAIT_SOME_TIME]++"];
              
            }
          }
        }
      }
    }

    //print_r($data);

    /*if ($raw === true)
    {
    return $data;
    }*/

    return $data;
  }

  private function parse($data, $domain, $domainWord, $keywords, $breakOnEnter) {
    $found = false;
    $domainWordLen = strlen($domainWord);

    $res = [];

    foreach ($data AS $d) { 
      $d = trim($d);

      //if ($d == '') {
        //if ($breakOnEnter) {
          //$found = false;
        //}
        //continue;
      //}

      $pos = strpos($d, $domainWord);

      if ($pos !== false) {
        $dom = strtolower(trim(substr($d, $pos + $domainWordLen)));
        if ($dom == $domain) {
          $found = true;
        }
      }

      if ($found) {
        $pos = strpos($d, ':');
        if ($pos !== false) {
          $keyword = substr($d, 0, $pos);

          if (isset($keywords[$keyword])) {
            $t = trim(substr($d, $pos + 1));
            if ($t != '') {
              $res[$keywords[$keyword]][] = $t;
            }
          } else {
            $keyword = '';
          }
        } else if ($keyword) {
          $res[$keywords[$keyword]][] = $d;
        }
      }
    }
    return $res;
  }

  private function parseDomain($data, $domain, $tld) {
    $domainWords = [
      'Domain Name:', 'Domain name:' , 'DOMAIN NAME:', 'Domain:', 'Domain:', 'domain:',
    ];

    $domainsKeywords = [
      ['id' => ['Domain ID', 'Domain Name ID', 'Registry Domain ID', 'ROID']],
      ['domain' => ['Domain name', 'Domain Name', 'DOMAIN NAME', 'Domain', 'domain']],
      ['bundled_domain' => ['Bundled Domain Name']],
      ['dns' => ['Name Server', 'Nameservers', 'Name servers', 'Name Servers Information', 'Domain servers in listed order', 'nserver', 'nameservers']],
      ['registrar' => ['Registrar', 'registrar', 'Registrant', 'Registrar Name', 'Created by Registrar']],
      ['registrar_url' => ['Registrar URL', 'Registrar URL (registration services)']],
      ['sponsoring_registrar' => ['Sponsoring Registrar']],
      ['whois_server' => ['Whois Server', 'WHOIS SERVER', 'Registrar WHOIS Server']],
      ['created' => ['Creation Date', 'Created On', 'Registration Time', 'Domain Create Date', 'Domain Registration Date', 'Domain Name Commencement Date', 'created']],
      ['updated' => ['last-update', 'Updated Date', 'Domain Last Updated Date', 'last modified', 'Last updated on']],
      ['expires' => ['Expiry Date', 'Expiration Date', 'Expiration Time', 'Domain Expiration Date', 'Registrar Registration Expiration Date', 'Record expires on', 'Registry Expiry Date', 'renewal date', 'paid-till']],
      ['status' => ['Status', 'status', 'Domain Status', 'state']],
    ];

    $toBeParseKeywords = [];

    foreach ($domainsKeywords as $domainKeywords) {
      foreach ($domainKeywords as $var => $keywords) {
        foreach ($keywords as $keyword) {
          $toBeParseKeywords[$keyword] = $var;
        }
      }
    }

    $contactInfoCategories = [
      ['id' => ['ID']],
      ['name' => ['Name']],
      ['organization' => ['Organization']],
      ['city' => ['City']],
      ['country' => ['Country', 'Country/Economy']],
      ['address' => ['Street', 'Address', 'Address1', 'Address2', 'Address3', 'Address4']],
      ['state_province' => ['State/Province']],
      ['postal_code' => ['Postal Code']],
      ['email' => ['Email']],
      ['phone' => ['Phone', 'Phone Number']],
      ['phone_ext' => ['Phone Ext', 'Phone Ext.']],
      ['fax' => ['Fax', 'FAX', 'Facsimile Number']],
      ['fax_ext' => ['Fax Ext', 'FAX Ext.']],
    ];

    $contactInfoKeywords = [
      ['admin' => ['Admin', 'Administrative', 'Administrative Contact']],
      ['registrant' => ['Registrant']],
      ['tech' => ['Tech', 'Technical', 'Technical Contact']],
      ['billing' => ['Bill', 'Billing', 'Billing Contact']],
    ];

    foreach ($contactInfoKeywords as $contactInfoKeyword) {
      foreach ($contactInfoKeyword as $contactKey => $contactKeywords) {
        foreach ($contactKeywords as $contactKeyword) {
          foreach ($contactInfoCategories as $contactInfoCategory) {
            foreach ($contactInfoCategory as $var => $keywords) {
              foreach ($keywords as $keyword) {
                $toBeParseKeywords[$contactKeyword . " " . $keyword] = $contactKey . "_" . $var;
              }
            }
          }
        }
      }
    }
    
    foreach ($domainWords as $sig) {
      foreach ($data as $d) {
        $re = "/$sig/m";
        if (preg_match_all($re, $d, $matches, PREG_SET_ORDER, 0)) $domainWord = $matches[0][0];
      }
    }

    $data = array_filter(array_map("Whois_lib::ifWhiteSpace", $data));
    $parseResult = $this->parse($data, $domain, $domainWord, $toBeParseKeywords, true);

    $needToBeSingles = ["domain", "id"];
    foreach ($needToBeSingles as $needToBeSingle) {
      if (!empty($parseResult[$needToBeSingle])) {
        $parseResult[$needToBeSingle] = $parseResult[$needToBeSingle][0];
      }
    }
    if (!empty($parseResult['domain'])) {
      $parseResult['domain'] = strtolower($parseResult['domain']);
      $parseResult['domainServerIP'] = gethostbyname($parseResult['domain']);
      $parseResult['domainServerLocation'] = $this->ip2Location($parseResult['domainServerIP']);
    }

    $needToBeParsedTimeKeys = ['created', 'expires', 'updated'];
    foreach ($needToBeParsedTimeKeys as $needToBeParsedTimeKey) {
      if (!empty($parseResult[$needToBeParsedTimeKey])) {
        $domainTime = $parseResult[$needToBeParsedTimeKey][0];
        //if ( (date_parse($domainTime)['warning_count'] == 0) && (date_parse($domainTime)['error_count'] == 0) ) {
        if (date_parse($domainTime)['error_count'] == 0) {
          $parsed_date = strtok($domainTime, 'T');
          $parseResult[$needToBeParsedTimeKey][0] = $parsed_date;
        } else {
          $formatedTime = $domainTime;
          $formatedTime = trim($formatedTime);
        }
      }
    }

    foreach ($parseResult as $eachParseResultKey => $eachParseResult) {
      if (substr($eachParseResultKey, 0, 6) == "admin_") {
        unset($parseResult[$eachParseResultKey]);
        $key = substr($eachParseResultKey, 6);
        if ($key != "address") {
          $eachParseResult = $eachParseResult[0];
        }
        $parseResult['admin'][$key] = $eachParseResult;
      }
      if (substr($eachParseResultKey, 0, 11) == "registrant_") {
        unset($parseResult[$eachParseResultKey]);
        $key = substr($eachParseResultKey, 11);
        if ($key != "address") {
          $eachParseResult = $eachParseResult[0];
        }
        $parseResult['registrant'][$key] = $eachParseResult;
      }
      if (substr($eachParseResultKey, 0, 5) == "tech_") {
        unset($parseResult[$eachParseResultKey]);
        $key = substr($eachParseResultKey, 5);
        if ($key != "address") {
          $eachParseResult = $eachParseResult[0];
        }
        $parseResult['tech'][$key] = $eachParseResult;
      }
      if (substr($eachParseResultKey, 0, 8) == "billing_") {
        unset($parseResult[$eachParseResultKey]);
        $key = substr($eachParseResultKey, 8);
        if ($key != "address") {
          $eachParseResult = $eachParseResult[0];
        }
        $parseResult['bill'][$key] = $eachParseResult;
      }
    }

    $needToBeLowerCasedValueFathers = ['registrant', 'admin', 'tech', 'billing'];
    foreach ($needToBeLowerCasedValueFathers as $needToBeLowerCasedValueFather) {
      if (!empty($parseResult[$needToBeLowerCasedValueFather])) {
        $needToBeLowerCasedValue = $parseResult[$needToBeLowerCasedValueFather]['email'];
        if (!empty($needToBeLowerCasedValue)) {
          $parseResult[$needToBeLowerCasedValueFather]['email'] = strtolower($parseResult[$needToBeLowerCasedValueFather]['email']);
        }
      }
    }

    $needToAddCompletelyAddressArrays = ['registrant', 'admin', 'tech', 'billing'];
    foreach ($needToAddCompletelyAddressArrays as $needToAddCompletelyAddressArray) {
      if (!empty($parseResult[$needToAddCompletelyAddressArray])) {
        if (!empty($parseResult[$needToAddCompletelyAddressArray]["address"])) {
          $parseResult[$needToAddCompletelyAddressArray]["completely_address"] = implode(", ", $parseResult[$needToAddCompletelyAddressArray]["address"]);
          /* WILL CITY & COUNTRY WILL BE INCLUDE IN FULL ADDRESS? */
          /*$allExtraInfomations = ["city", "country"];
          foreach($allExtraInfomations as $extraInfomation){
          if(!empty($parseResult[$needToAddCompletelyAddressArray][$extraInfomation])){
          $parseResult[$needToAddCompletelyAddressArray]["completely_address"] .= ", ".$parseResult[$needToAddCompletelyAddressArray][$extraInfomation];
          }
          }*/
          $parseResult[$needToAddCompletelyAddressArray]["completely_address"] = ucwords(strtolower($parseResult[$needToAddCompletelyAddressArray]["completely_address"]));
        }
      }
    }

    if ($this->returnType != "text") {
      if (empty($parseResult)) {
        return ["++[ERROR_NOTHING_IN_ARRAY]++"];
      }
    }

    if (array_key_exists('status', $parseResult)) {
      $pattern = "/\b((https?|ftp|file):\/\/|www\.)[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i";
      $replacement = "";
      foreach ($parseResult['status'] as $key => $status) {
        $parseResult['status'][$key] = preg_replace($pattern, $replacement, $status);
      }
    }

    if (array_key_exists('dns', $parseResult)) {
      foreach ($parseResult['dns'] as $key => $status) {
        $parseResult['dns'][$key] = [
          'domain' => $status,
          'ip' => gethostbyname($status),
          'location' => $this->ip2Location(gethostbyname($status)),
        ];
      }
    }

    $parseResult['domainFavicon'] = "https://www.google.com/s2/favicons?domain=" . $parseResult['domain'];
    $parseResult['domainThumb'] = "https://s-ssl.wordpress.com/mshots/v1/" . $parseResult['domain'] . "?w=350";
    $parseResult['whoisDate'] = date('Y-m-d H:i:s');
    $parseResult['isfirstRun'] = true;
    $parseResult['rawWhois'] = $this->getRaw();

    return $parseResult;
  }


  function ip2Location($ip) {
    $location = null;
    $queryip = null;

    $geoip_1 = 'https://tools.keycdn.com/geo.json?host='.$ip;
    $geoip_2 = 'http://ip-api.com/json/'.$ip;
    $geoip_3 = 'https://geolocation-db.com/json/'.$ip;

    if ($queryip = json_decode(file_get_contents($geoip_1), true)) {
      if ($queryip['status'] == 'success') {
        $queryData = $queryip['data']['geo'];

        $fullAddress = '';
        $fullAddress .= (isset($queryData['city'])) ? $queryData['city'] . ', ' : '';
        $fullAddress .= (isset($queryData['postal_code'])) ? $queryData['postal_code'] . ', ' : '';
        $fullAddress .= (isset($queryData['region_name'])) ? $queryData['region_name'] . ', ' : '';
        $fullAddress .= (isset($queryData['country_name'])) ? $queryData['country_name'] : '';

        $location = [
          'country_name' => (isset($queryData['country_name'])) ? $queryData['country_name'] : 'N/A',
          'country_code' => (isset($queryData['country_code'])) ? $queryData['country_code'] : 'N/A',
          'region_name' => (isset($queryData['region_name'])) ? $queryData['region_name'] : 'N/A',
          'region_code' => (isset($queryData['region_code'])) ? $queryData['region_code'] : 'N/A',
          'city' => (isset($queryData['city'])) ? $queryData['city'] : 'N/A',
          'postal_code' => (isset($queryData['postal_code'])) ? $queryData['postal_code'] : 'N/A',
          'isp' => (isset($queryData['isp'])) ? $queryData['isp'] : 'N/A',
          'full' => $fullAddress,
        ];
      }
    } elseif ($queryip = json_decode(file_get_contents($geoip_2), true)) {
      if ($queryip['status'] == 'success') {
        $fullAddress = '';
        $fullAddress .= (isset($queryData['city'])) ? $queryData['city'] . ', ' : '';
        $fullAddress .= (isset($queryData['postal_code'])) ? $queryData['postal_code'] . ', ' : '';
        $fullAddress .= (isset($queryData['regionName'])) ? $queryData['regionName'] . ', ' : '';
        $fullAddress .= (isset($queryData['country'])) ? $queryData['country'] : '';

        $location = [
          'country_name' => (isset($queryip['country'])) ? $queryip['country'] : 'N/A',
          'country_code' => (isset($queryip['countryCode'])) ? $queryip['countryCode'] : 'N/A',
          'region_name' => (isset($queryip['regionName'])) ? $queryip['regionName'] : 'N/A',
          'region_code' => (isset($queryip['region'])) ? $queryip['region'] : 'N/A',
          'city' => (isset($queryip['city'])) ? $queryip['city'] : 'N/A',
          'postal_code' => (isset($queryip['postal_code'])) ? $queryip['postal_code'] : 'N/A',
          'isp' => (isset($queryip['isp'])) ? $queryip['isp'] : 'N/A',
          'full' => $fullAddress,
        ];
      }
    } elseif ($queryip = json_decode(file_get_contents($geoip_3), true)) {
      if (!array_key_exists($queryip, $queryip['error'])) {
        $fullAddress = '';
        $fullAddress .= (isset($queryData['city'])) ? $queryData['city'] . ', ' : '';
        $fullAddress .= (isset($queryData['postal'])) ? $queryData['postal'] . ', ' : '';
        $fullAddress .= (isset($queryData['country_name'])) ? $queryData['country_name'] : '';

        $location = [
          'country_name' => (isset($queryip['country_name'])) ? $queryip['country_name'] : 'N/A',
          'country_code' => (isset($queryip['country_code'])) ? $queryip['country_code'] : 'N/A',
          'region_name' => 'N/A',
          'region_code' => 'N/A',
          'city' => (isset($queryip['city'])) ? $queryip['city'] : 'N/A',
          'postal_code' => (isset($queryip['postal'])) ? $queryip['postal'] : 'N/A',
          'isp' => 'N/A',
          'full' => $fullAddress,
        ];
      }
    } else {
      $location = [
        'country_name' => 'N/A',
        'country_code' => 'N/A',
        'region_name' => 'N/A',
        'region_code' => 'N/A',
        'city' => 'N/A',
        'postal_code' => 'N/A',
        'isp' => 'N/A',
        'full' => 'N/A',
      ];
    }

    return $location;
  }
  private function ifWhiteSpace($el) {
    return trim($el, " ");
  }
}