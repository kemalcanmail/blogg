<div class="footer">
    <div class="container-lg">
      <div class="row">
        <div class="col-md-4">
          <div class="web-details">
            <div class="logo-icon">
              <img src="<?php echo uploads('img/' . $general['favicon']) ?>" alt="" srcset="">
            </div>
            <div class="heading"><span class="logoF">WHOIS</span> - <span class="logoSub">Ultimate WHOIS checker Script</span></div>
            <div class="credits">Powered by XL Scripts - All Rights Reserved</div>
          </div>
        </div>
        <div class="col-md-8 footer-links">
            <?php foreach($pages as $page) { 
              if ($page['position'] != 1 && $page['status']) { ?>
                <a href="<?php anchor_to('page/'.$page['permalink']) ?>"><?php echo esc_html($page['title'], true) ?></a>
            <?php }
            } ?>
            <a class="btn btn-sm btn-df py-1 px-3 text-white shadow-md" href="<?php anchor_to('contact') ?>">Contact Us</a>
        </div>
      </div>
    </div>
</div>
