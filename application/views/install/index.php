<?php
$this->load->view("install/includes/head");
?>
	<div class="installer-container">
		<?php $this->load->view('install/includes/top'); ?>
		
		<div class="thankyou-area text-center">
			<div class="thankyou-title">Thanks for Purchasing <?php echo(VENDOR_NAME); ?> Product</div>			
			<!-- /thankyou-title -->
			<div class="thankyou-w-installation alert alert-success text-dark">You are about to install version <span class="badge badge-success"><?php echo(number_format($build['version'], 1)); ?></span> of <?php echo(PRODUCT_NAME); ?></div>
		</div>
		<!-- /thankyou-area -->
		
		<div class="tabs-area">
			<?php
			$this->load->view("install/includes/tabs");
			?>
			<!-- /tabs-nav -->
			
			<div class="tabs-content">
			<div class="thankyou-w-installation">Welcome to Installation Wizard. Click Next to Continue.</div>
			<!-- /thankyou-w-installation -->
			<div class="thankyou-w-support">If you face any problem while installation then open the support ticket here : <a href="<?php echo(VENDOR_SUPPORT_URL); ?>" target="_blank">Support</a></div>
			<!-- /thankyou-w-support -->
				<!-- /tab-requirements -->
				
				<div class="tab-button-area text-right"><a class="btn btn-tabs" href="<?php echo($base_url."install/".$next_page); ?>">Next</a></div>
				<!-- /tab-button-area -->
			</div>
			<!-- /tabs-content -->
		</div>
		<!-- /tabs-area -->
<?php
$this->load->view("install/includes/footer");
$this->load->view("install/includes/footer_end");
?>