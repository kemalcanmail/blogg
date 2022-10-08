<?php 
  $view('includes/head');
  $view('includes/head-bar');
?>

<div class="container-lg search-page">
    <div class="search-section">
      <div class="search-block row">
        <div class="wrapper col-md-12">
          <div class="SearchBar input-group">
          <form id="domainInput" class="SearchBar input-group">
            <input id="searchBox" type="text" class="form-control shadow-md" placeholder="Enter Domain Name" aria-label="Domain Name" value="<?php echo esc($data['whoisData']["domain"]) ?>">
            <button id="searchBtn" class="btn btn-df" type="submit"><span><img src="<?php $assets('imgs/Search-Icon.svg'); ?>" alt="" srcset="">  Search</span> <div id="whoisLoader" class="lds-ellipsis d-none"><div></div><div></div><div></div><div></div></div></button>
          </form>
          </div>
        </div>
      </div>
    </div>

    <div class="results">
      <div class="row mt-5">
        <div class="col-md-8 order-2 order-lg-1 order-md-2">
          <span>WHOIS search result for</span>
          <div class="domain">
            <div class="dfavicon">
              <img class="rounded" src="<?php echo ($data['whoisData']["domainFavicon"]) ?>" alt="" srcset="">
            </div>
            <div class="dname"><?php echo esc(ucfirst($data['whoisData']["domain"])) ?> <span class="shadow">Last updated: <?php echo (date_to_ago($data['whoisData']["whoisDate"])); ?></span>
            <?php if ($data['whoisData']["showUpdateBtn"]) { ?> 
              <button id="updateWhoisBtnSecondary" class='btn btn-sm btn-df shadow' ><span>Update Now</span><div id="whoisLoaderSecondary" class="lds-ellipsis d-none"><div></div><div></div><div></div><div></div></div></button>
            <?php } ?>
            </div>

            <div class="row dates">
              <div class="row col-lg-8">
              <?php if($data['whoisData']["created"][0]) { ?>
                <div class="col-md-4 dBlock">
                  <div class="subH">Registered On</div>
                  <div class="date"><?php echo ($data['whoisData']["created"][0]) ?></div>
                </div>
              <?php } ?>
              <?php if($data['whoisData']["expires"][0]) { ?>
                <div class="col-md-4 dBlock">
                  <div class="subH">Expires On</div>
                  <div class="date"><?php echo ($data['whoisData']["expires"][0]) ?></div>
                </div>
              <?php } ?>
              <?php if($data['whoisData']["updated"][0]) { ?>
                <div class="col-md-4 dBlock">
                  <div class="subH">Updated On</div>
                  <div class="date"><?php echo ($data['whoisData']["updated"][0]) ?></div>
                </div>
              <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 dThumb order-1 order-lg-2 order-md-1">
        
          <div id="WebThumb" class="thumb shadow" style="background-image: url('<?php $assets('imgs/loading.gif'); ?>');"></div>
        </div>
        
        <?php if($data['whoisData']["registrar"][0] || $data['whoisData']["registrar_url"][0] || $data['whoisData']["status"]) { ?>
        <div class="col-md-12 resultSubBlocks order-3">
          <div class="heading"><span>Registrant Information</span></div>
          <div class="wrapper shadow">
            <div class="row">
              <?php if($data['whoisData']["registrar"][0]) { ?>
              <div class="col-md-3 mt-2">Registrant:</div>
              <div class="col-md-9 mt-2"><?php echo ($data['whoisData']["registrar"][0]) ?></div>
              <?php } ?>
              <?php if($data['whoisData']["registrar_url"][0]) { ?>
              <div class="col-md-3 mt-2">Registrant Website:</div>
              <div class="col-md-9 mt-2"><?php echo ($data['whoisData']["registrar_url"][0]) ?></div>
              <?php } ?>
              <?php if($data['whoisData']["status"]) { ?>
              <div class="col-md-3 mt-2">Status:</div>
              <div class="col-md-9 mt-2">
                <?php foreach ($data['whoisData']["status"] as $value) {
                      echo esc($value)."<br />";
                  } ?>
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <?php } ?>

        <?php if($data['whoisData']["domainServerIP"] || $data['whoisData']["domainServerLocation"]["country_code"] || $data['whoisData']["domainServerLocation"]["isp"]) { ?>
        <div class="col-md-12 resultSubBlocks  order-4">
          <div class="heading"><span>Website IP Details</span></div>
          <div class="wrapper shadow">
            <div class="row">
            <?php if($data['whoisData']["domainServerIP"]) { ?>
              <div class="col-md-3 mt-2">Website IP Address:</div>
              <div class="col-md-9 mt-2"><?php echo ($data['whoisData']["domainServerIP"]); ?></div>
            <?php } ?>
            <?php if($data['whoisData']["domainServerLocation"]["country_name"]) { ?>
              <div class="col-md-3 mt-2">Website IP Location:</div>
              <div class="col-md-9 mt-2">
              <?php if($data['whoisData']["domainServerLocation"]["country_code"]) { ?><img src="https://flagcdn.com/24x18/<?php echo strtolower(($data['whoisData']["domainServerLocation"]["country_code"])); ?>.png" class="m-r-4"><?php } ?> <?php echo ($data['whoisData']["domainServerLocation"]["country_name"]); ?></div>
            <?php } ?>
            <?php if($data['whoisData']["domainServerLocation"]["isp"]) { ?>
              <div class="col-md-3 mt-2">IPS:</div>
              <div class="col-md-9 mt-2"><?php echo ($data['whoisData']["domainServerLocation"]["isp"]); ?></div>
            <?php } ?>
            </div>
          </div>
        </div>
        <?php } ?>
        
        <?php if($data['whoisData']["dns"]) { ?>
        <div class="col-md-12 resultSubBlocks order-5">
          <div class="heading"><span>Name Servers</span></div>
          <div class="wrapper shadow">
            <div class="row">
              <div class="col-md-12 mb-2">
                <div class="row">
                  <div class="col-md-3">Host</div>
                  <div class="col-md-3">IP Address</div>
                  <div class="col-md-3">Location</div>
                </div>
              </div>
              <div class="col-md-12">
                  <?php 
                    foreach ($data['whoisData']["dns"] as $dns) { ?>
                      <div class="row">
                        <div class='col-md-3'><?php echo esc($dns['domain']) ?></div>
                        <div class='col-md-3'><?php echo esc($dns['ip']) ?></div>
                        <div class='col-md-3'><img src='https://flagcdn.com/24x18/<?php echo strtolower(esc($dns['location']['country_code'])) ?>.png' class='m-r-4'> <?php echo esc($dns['location']['country_name']) ?></div>
                      </div>
                    <?php }
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
        
        <?php if($data['whoisData']["rawWhois"]) { ?>
        <div class="col-md-12 resultSubBlocks order-6">
          <div class="heading"><span>RAW WHOIS</span></div>
          <div class="wrapper shadow">
            <div class="row">
              <div class="col-md-12 mt-2">
                <?php 
                  foreach ($data['whoisData']["rawWhois"] as $whois) { 
                    echo esc($whois)."<br/>";
                  }
                ?>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
    </div>
  <script type="text/javascript">"use strict";
      let ifMain = false;
      let getWhoisUrl = '<?php echo base_url("whois/") ?>';
      let isFirstrun = <?php echo ($data['whoisData']["isfirstRun"]) ?>;
      let thumbUrl = '<?php echo esc($data['whoisData']["domainThumb"]) ?>';
      let loadingGif = '<?php $assets('imgs/loading.gif'); ?>';
      let updateThumb = '<?php echo base_url("whois/updateThumb") ?>';
      let domainName = '<?php echo esc($data['whoisData']["domain"]); ?>';
      let updateWhois =  '<?php echo base_url("whois/updateWhois") ?>';
  </script>

<?php $view('includes/foot-bar'); ?>
<?php $view('includes/foot'); ?>