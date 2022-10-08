<div class="bodyMain">
<nav class="navbar navbar-expand-lg navbar-dark container-lg">
    <a class="navbar-brand" href="<?php anchor_to() ?>"><img src="<?php echo uploads('img/' . $general['logo']) ?>" alt="WHOIS Logo"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <?php foreach($pages as $page) { 
          if ($page['position'] != 2 && $page['status']) { ?>
          <li class="nav-item active">
            <a class="nav-link" href="<?php anchor_to('page/'.$page['permalink']) ?>"><?php echo esc($page['title'], true) ?></a>
          </li>
        <?php }
        } ?>
        <li class="nav-item">
          <a class="btn btn-sm nav-link btn-df py-1 px-3 mt-1 text-white shadow-md" href="<?php anchor_to('contact') ?>">Contact Us</a>
        </li>
      </ul>
    </div>
  </nav>