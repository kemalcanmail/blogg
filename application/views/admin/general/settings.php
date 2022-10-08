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
                  <a href="<?php anchor_to(GENERAL_CONTROLLER . '/settings') ?>">
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
                     <div class="card-title">Update your General Settings</div>
                  </div>
				  <form enctype="multipart/form-data" action="<?php anchor_to(GENERAL_CONTROLLER . '/settings') ?>" method="POST">
					<div class="card-body">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="site-title">Title</label>
									<?php echo form_error('site-title', '<br><span class="text-danger">', '</span>'); ?>
									<input type="text" name="site-title" class="form-control form-control-lg py-3 px-5" id="title" value="<?php echo esc($modules['general']['title']) ?>" placeholder="Choose your Website's title">
									<small>This will be used as the title across the entire application.</small>
								</div>
								<div class="form-group">
									<label for="site-description">Description</label>
									<textarea rows="4" name="site-description" class="form-control resize-none" id="description" placeholder="Enter the Website Description"><?php echo esc($modules['general']['description']) ?></textarea>
									<small>This will automatically be included in the <code>&lt;head&gt;</code> tag as Meta Description.</small>
								</div>
								<div class="form-group">
									<label for="site-keywords">Keywords</label>
									<input type="text" name="site-keywords" value="<?php echo esc($modules['general']['keywords']) ?>" class="form-control form-control-lg resize-none" id="keywords" placeholder="Enter the Website Keywords">
								</div>
							</div>
							<div class="col-lg-6">
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<label>Logo</label>
											<?php echo isset($data['logo_error']) ? '<div class="alert alert-danger">' . $data['logo_error'] . '</div>' : '' ?>
											<span class="br-b-0 alert d-block mb-0 text-center bg-imager"><img id="logo-visualize" for="logo" src="<?php echo uploads('img/'.$modules['general']['logo']) ?>" alt="Logo" class="img-responsive image-visualizer" height="56"></span>
											<input class="br-t-0 basic-file alert d-block w-100" type="file" id="logo" name="site-logo">
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group">
											<label>Favicon</label>
											<?php echo isset($data['favicon_error']) ? '<div class="alert alert-danger">' . $data['favicon_error'] . '</div>' : '' ?>
											<span class="br-b-0 alert d-block mb-0 text-center bg-imager"><img id="favicon-visualize" src="<?php echo uploads('img/'.$modules['general']['favicon']) ?>" alt="Favicon" class="img-responsive image-visualizer" height="56"></span>
											<input class="br-t-0 basic-file alert d-block w-100" type="file" id="favicon" name="site-favicon">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-action">
						<input type="hidden" name="submit" value="Submit">
						<button type="submit" class="btn btn-success"><i class="fas fa-check mr-1"></i> Update Settings</button>
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