<?php
$this->load->view("install/includes/head");
?>
	<div class="installer-container">
		<?php $this->load->view('install/includes/top'); ?>
		
		<?php if(!isset($license_response["response"]["type"])) { ?>
		<div class="text-center">
			<div class="alert alert-info">Enter Your License Details Below & Click Verify</div>
		</div>
		<?php } ?>
		<div class="tabs-area">
			<?php
			$this->load->view("install/includes/tabs");
			?>
			<!-- /tabs-nav -->
			
			<div class="tabs-content">
			<form method="post">
			<?php if(isset($license_response["response"]["type"])) { ?>
			<div class="alert alert-<?php echo($license_response["response"]["type"]=="error" ? "danger" : "success"); ?> text-center"><i class="fa fa-<?php echo($license_response["response"]["type"]=="error" ? "exclamation-triangle" : "check"); ?>"></i> <?php echo esc($license_response["response"]["msg"]); ?></div>
			<?php } else { ?>
			<div class="alert alert-success text-center">If you don't have license you can get one from <a href="<?php echo(API_URL."product_unique_id/".PRODUCT_ID) ?>" target="_blank"><span class="badge badge-primary"><?php echo(VENDOR_NAME); ?></span></a></div>
			<?php } ?>
					<label class="label-tabs">Purchase Code</label>
					<div class="text-fld-div">
						<input type="text" name="license_key" placeholder="Enter your Purchase Code" value="<?php echo esc(isset($license_response["response"]['license_key']) ? $license_response["response"]['license_key']:""); ?>" class="form-control text-fld" required>
						<?php echo form_error('license_key', '<div class="m-t-5 text-danger"><small>', '</small></div>'); ?>
					</div>
					<label>
					Click on this URL <a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-" target="_blank">https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-</a> to learn how to get your purchase code.</label>
					<label class="label-tabs">Envato Token</label>
					<div class="text-fld-div">
						<input type="text" name="token" placeholder="Enter your Envao Token" value="<?php echo esc(isset($license_response["response"]['token']) ? $license_response["response"]['token']:""); ?>" class="form-control text-fld" required>
						<?php echo form_error('token', '<div class="m-t-5 text-danger"><small>', '</small></div>'); ?>
					</div>
					<label>
					Click on this URL <a href="https://xlscripts.com/support/envato-token" target="_blank">https://xlscripts.com/support/envato-token</a> learn how to generate envato token.
					</label>
					<div class="tab-button-area text-right">
					<?php if(isset($license_response["response"]["type"]) && $license_response["response"]["type"]=="success") { ?>
					<a class="btn btn-tabs" href="<?php echo($base_url."install/".$next_page); ?>">Next</a>
					<?php } else { ?>
					<input type="hidden" name="submit" value="submit">
					<button class="btn btn-tabs btn-submit" type="submit">Verify</button>
					<?php } ?>
					</div>
			</form>
				<!-- /tab-button-area -->
			</div>
			<!-- /tabs-content -->
		</div>
		<!-- /tabs-area -->
<?php
$this->load->view("install/includes/footer");
$this->load->view("install/includes/footer_end");
?>