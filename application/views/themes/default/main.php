<?php 
  $view('includes/head');
  $view('includes/head-bar');
?>

<div class="container-lg main-page">
    <div class="search-section">
      <div class="search-block row">
        <div class="wrapper col-md-6">
          <h2>WHOIS Search Tool</h2>
          <div class="subHeading">
            Ultimate WHOIS search tool to check out real identity behind a domain name also check DNS record.
          </div>

          <form id="domainInput" class="SearchBar input-group">
            <input id="searchBox" type="text" class="form-control shadow-md" placeholder="Enter Domain Name" aria-label="Domain Name" required>
            <button id="searchBtn" class="btn btn-df" type="submit"><span><img src="<?php $assets('imgs/Search-Icon.svg'); ?>" alt="" srcset=""> Search</span> <div id="whoisLoader" class="lds-ellipsis d-none"><div></div><div></div><div></div><div></div></div></button>
          </form>

        </div>
      </div>
    </div>

    <div class="main-page-blocks row">
      <div class="col-md-4">
        <img src="<?php $assets('imgs/fast-clock.svg'); ?>" alt="Fast Speed" srcset="">
        <h4>
          Fast WHOIS Lookup
        </h4>
        <div class="subH-block">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
        </div>
      </div>
      <div class="col-md-4">
        <img src="<?php $assets('imgs/secure-lock.svg'); ?>" alt="Secure" srcset="">
        <h4>
          Secure WHOIS Lookup
        </h4>
        <div class="subH-block">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
        </div>
      </div>
      <div class="col-md-4">
        <img src="<?php $assets('imgs/all-plus.svg'); ?>" alt="All TLDs Supported" srcset="">
        <h4>
          Most TLDs Supported
        </h4>
        <div class="subH-block">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">'use strict'
    let ifMain = true;
    let getWhoisUrl = '<?php anchor_to("whois/") ?>';
</script>
<?php 
  $view('includes/foot-bar');
  $view('includes/foot');
?>