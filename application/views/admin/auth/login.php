<?php $view('includes/head'); ?>
<div class="wrapper wrapper-login wrapper-login-full p-0">
		<div class="login-aside w-50 d-flex flex-column align-items-center justify-content-center text-center bg-dark">
			<img class="img-responsive p-4" src="<?php echo uploads('img/'.$modules['general']['logo']) ?>">
			<h1 class="title fw-bold text-white mb-3"><?php echo esc($modules['general']['title']) ?></h1>
			<p class="subtitle text-white op-7"><?php echo esc($modules['general']['description']) ?></p>
		</div>
		<div class="login-aside w-50 d-flex align-items-center justify-content-center bg-white">
			<div class="container container-login container-transparent animated fadeIn">
				<h3 class="text-center text-dark">
          <a href="https://xlscripts.com" target="_blank"><img src="<?php echo public_assets('img/xlscripts.png') ?>"></a>
        </h3>
				<form method="POST" class="login-form">
                    <?php if($data['error']) { ?>
                        <div class="form-group">
                            <div class="alert alert-danger">
                                <span><?php echo esc($data['error']); ?></span>
                            </div>
                        </div>
                    <?php } else if($alert = $this->session->flashdata('alert')) { ?>
						<div class="<?php echo esc($alert['type']) ?> alert-dismissible fade show">
							<span><?php echo esc($alert['msg']); ?></span>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					<?php } ?>
					<div class="form-group">
						<label for="username" class="placeholder"><b>Username / E-Mail</b></label>
						<input placeholder="Your Username or E-Mail" name="identifier" id="username" type="text" class="form-control" required>
                        <?php echo form_error('identifier', '<div class="text-danger">', '</div>') ?>
					</div>
					<div class="form-group">
						<label for="password" class="placeholder"><b>Password</b></label>
						<!-- <a href="#" class="link float-right">Forget Password ?</a> -->
						<div class="position-relative">
                            <input placeholder="Your Password" id="password" name="password" type="password" class="form-control" required>
                            <?php echo form_error('password', '<div class="text-danger">', '</div>') ?>
						</div>
					</div>
					<div class="form-group form-action-d-flex mb-3">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" name="remember-me" class="custom-control-input" id="rememberme">
							<label class="custom-control-label m-0" for="rememberme">Remember Me</label>
                        </div>
                        <?php if($data['redirect_to']) { ?><input type="hidden" name="redirect" value="<?php echo esc($data['redirect_to']) ?>"><?php } ?>
						<input type="submit" name="submit" value="Sign In" class="btn btn-secondary col-md-5 float-right mt-3 mt-sm-0 fw-bold">
					</div>
      </form>
			</div>
		</div>
	</div>
<?php $view('includes/foot'); ?>