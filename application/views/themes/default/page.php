<?php $view('includes/head'); ?>
<?php $view('includes/head-bar'); ?>

<div class="container-lg main-page">
    <div class="page-section row">
        <div class="wrapper col-md-12">
          <h2><?php echo esc($data['page']['title'], true); ?></h2>
          <p>
            <?php echo esc($data['page']['content'], true); ?>
          </p>
        </div>
    </div>
</div>

<?php $view('includes/foot-bar'); ?>
<?php $view('includes/foot'); ?>