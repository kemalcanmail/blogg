<?php $view('includes/head'); ?>
<div class="wrapper fullheight-side">
<?php $view('includes/header');
$view('includes/sidebar'); 
$view('includes/navbar'); ?>

<div class="main-panel">
   <div class="container">
      <div class="page-inner">
         <div class="page-header">
            <h4 class="page-title"><?php echo esc($data['page_title']) ?></h4>
            <ul class="breadcrumbs">
               <li class="nav-home">
                  <a href="<?php anchor_to(GENERAL_CONTROLLER . '/dashboard') ?>">
                  <i class="flaticon-home"></i>
                  </a>
               </li>
               <li class="separator">
                  <i class="flaticon-right-arrow"></i>
               </li>
               <li class="nav-home">
                  <a href="<?php anchor_to(LAYOUT_CONTROLLER . '/ads') ?>">
                  <?php echo esc($data['page_title']) ?>
                  </a>
               </li>
            </ul>
         </div>
         <?php $this->load->view('admin/includes/alert'); ?>
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">
                     <div class="card-title">Add your Analytics Code</div>
                  </div>
				  <form action="<?php anchor_to(LAYOUT_CONTROLLER . '/ads') ?>" method="POST">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6 col-lg-4">
								<div class="form-group">
									<label for="header-scripts">Top Ad</label>
                           <div class="custom-control custom-switch">
                              <input <?php echo_if($modules['ads']['top']['status'], esc('checked')) ?> name="site-top-ad-status" type="checkbox" class="custom-control-input" id="switch-1">
                              <label class="custom-control-label" for="switch-1">Status</label>
                           </div>
                           <?php echo form_error('site-top-ad-code', '<div class="alert alert-danger">', '</div>'); ?>
                           <textarea rows="4" name="site-top-ad-code" class="form-control form-control-lg resize-none" id="top-ad" placeholder="Enter your Top Ad code right here."><?php echo esc($modules['ads']['top']['code'], true) ?></textarea>
                           <small>This code will be placed before the <code>&lt;/head&gt;</code> tag.</small>
								</div>
							</div>
                     <div class="col-md-6 col-lg-4">
								<div class="form-group">
									<label for="header-scripts">Bottom Ad</label>
									   <div class="custom-control custom-switch">
                                 <input <?php echo_if($modules['ads']['bottom']['status'], esc('checked')) ?> name="site-bottom-ad-status" type="checkbox" class="custom-control-input" id="switch-2">
                                 <label class="custom-control-label" for="switch-2">Status</label>
                              </div>
                              <?php echo form_error('site-bottom-ad-code', '<div class="alert alert-danger">', '</div>'); ?>
                              <textarea rows="4" name="site-bottom-ad-code" class="form-control form-control-lg resize-none" id="bottom-ad" placeholder="Enter your Bottom Ad code right here."><?php echo esc($modules['ads']['bottom']['code'], true) ?></textarea>
									<small>This code will be placed before the <code>&lt;/head&gt;</code> tag.</small>
								</div>
							</div>
                     <div class="col-md-6 col-lg-4">
								<div class="form-group">
									<label for="header-scripts">Pop Ad</label>
									<div class="custom-control custom-switch">
                              <input <?php echo_if($modules['ads']['pop']['status'], esc('checked')) ?> name="site-pop-ad-status" type="checkbox" class="custom-control-input" id="switch-3">
                              <label class="custom-control-label" for="switch-3">Status</label>
                           </div>
                           <?php echo form_error('site-pop-ad-code', '<div class="alert alert-danger">', '</div>'); ?>
                           <textarea rows="4" name="site-pop-ad-code" class="form-control form-control-lg resize-none" id="pop-ad" placeholder="Enter your Pop Ad code right here."><?php echo esc($modules['ads']['pop']['code'], true) ?></textarea>
									<small>This code will be placed before the <code>&lt;/head&gt;</code> tag.</small>
                        </div>
							</div>
						</div>
					</div>
					<div class="card-action">
						<input type="hidden" name="submit" value="Submit">
						<button type="submit" class="btn btn-success"><i class="fas fa-check mr-1"></i> Update Ads</button>
					</div>
				  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- End Page Content -->
</div>
<?php $this->load->view('admin/includes/foot'); ?>