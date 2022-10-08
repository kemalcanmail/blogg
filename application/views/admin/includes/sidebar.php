<?php $uri = strtolower($this->uri->segment(1).'/'.$this->uri->segment(2)); ?>
<div class="sidebar sidebar-style-2" data-background-color="white">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<ul class="nav nav-primary">
						<li class="nav-item <?php echo_if($uri == GENERAL_CONTROLLER . '/settings', 'active'); ?>">
							<a href="<?php anchor_to(GENERAL_CONTROLLER . '/settings') ?>">
								<i class="fas fa-cog"></i>
								<p>General Settings</p>
							</a>
                        </li>
						<li class="nav-item <?php echo_if($uri == GENERAL_CONTROLLER . '/themes' || $uri == GENERAL_CONTROLLER . '/upload_theme', 'active'); ?>">
							<a href="<?php anchor_to(GENERAL_CONTROLLER . '/themes') ?>">
								<i class="fas fa-brush"></i>
								<p>Themes</p>
							</a>
                        </li>
                        <li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Layout Settings</h4>
                        </li>
						<li class="nav-item <?php echo_if($uri == LAYOUT_CONTROLLER . '/pages', 'active'); ?>">
							<a href="<?php anchor_to(LAYOUT_CONTROLLER . '/pages') ?>">
								<i class="fas fa-layer-group"></i>
								<p>Page Settings</p>
							</a>
                        </li>
                        <li class="nav-item <?php echo_if($uri == LAYOUT_CONTROLLER . '/scripts', 'active'); ?>">
							<a href="<?php anchor_to(LAYOUT_CONTROLLER . '/scripts') ?>">
								<i class="fas fa-cogs"></i>
								<p>Header / Footer Scripts</p>
							</a>
                        </li>
						<li class="nav-item <?php echo_if($uri == LAYOUT_CONTROLLER . '/analytics', 'active'); ?>">
							<a href="<?php anchor_to(LAYOUT_CONTROLLER . '/analytics') ?>">
								<i class="fas fa-chart-bar"></i>
								<p>Analytics Settings</p>
							</a>
                        </li>
						<li class="nav-item <?php echo_if($uri == LAYOUT_CONTROLLER . '/meta_tags', 'active'); ?>">
							<a href="<?php anchor_to(LAYOUT_CONTROLLER . '/meta_tags') ?>">
								<i class="fas fa-code"></i>
								<p>Meta Tags Settings</p>
							</a>
                        </li>
						<li class="nav-item <?php echo_if($uri == LAYOUT_CONTROLLER . '/email', 'active'); ?>">
							<a href="<?php anchor_to(LAYOUT_CONTROLLER . '/email') ?>">
								<i class="fas fa-at"></i>
								<p>E-Mail Settings</p>
							</a>
                        </li>
						<li class="nav-item <?php echo_if($uri == LAYOUT_CONTROLLER . '/recaptcha', 'active'); ?>">
							<a href="<?php anchor_to(LAYOUT_CONTROLLER . '/recaptcha') ?>">
								<i class="fas fa-unlock"></i>
								<p>Recaptcha Settings</p>
							</a>
                        </li>
						<li class="nav-item <?php echo_if($uri == LAYOUT_CONTROLLER . '/ads', 'active'); ?>">
							<a href="<?php anchor_to(LAYOUT_CONTROLLER . '/ads') ?>">
								<i class="fas fa-expand"></i>
								<p>Ad Settings</p>
							</a>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">WHOIS Settings</h4>
            </li>
						<li class="nav-item <?php echo_if($uri == WHOIS_SETTINGS . '/servers', 'active'); ?>">
							<a href="<?php anchor_to(WHOIS_SETTINGS . '/servers') ?>">
								<i class="fas fa-question"></i>
								<p>WHOIS Servers</p>
							</a>
						</li>
						
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Users</h4>
            </li>
						<li class="nav-item <?php echo_if($uri == ACCOUNT_CONTROLLER . '/me', 'active'); ?>">
							<a href="<?php anchor_to(ACCOUNT_CONTROLLER . '/me') ?>">
								<i class="fas fa-user"></i>
								<p>My Account</p>
							</a>
						</li>
						<!--<?php if($admin['role'] == 0) { ?>
						<li class="nav-item <?php echo_if($uri == 'account/admins', 'active'); ?>">
							<a href="<?php anchor_to('general/account') ?>">
								<i class="fas fa-user-cog"></i>
								<p>Admin Accounts</p>
							</a>
						</li>
						<?php } ?> -->
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Other</h4>
                        </li>
						<li class="nav-item <?php echo_if($uri == UPDATES_CONTROLLER . '/main', 'active'); ?>">
							<a href="<?php anchor_to(UPDATES_CONTROLLER . '/main') ?>">
								<i class="fas fa-wrench"></i>
								<p>Script Updates</p>
							</a>
                        </li>
						<li class="nav-item <?php echo_if($uri == GENERAL_CONTROLLER . '/purge_cache', 'active'); ?>">
							<a href="<?php anchor_to(GENERAL_CONTROLLER . '/purge_cache') ?>">
								<i class="fas fa-trash-alt"></i>
								<p>Purge Cache</p>
							</a>
                        </li>
						<!-- <li class="nav-item">
							<a data-toggle="collapse" href="#base">
								<i class="fas fa-layer-group"></i>
								<p>Content Settings</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="base">
								<ul class="nav nav-collapse">
									<li>
										<a href="components/avatars.html">
											<span class="sub-item">Scripts</span>
										</a>
									</li>
									<li>
										<a href="components/buttons.html">
											<span class="sub-item">Buttons</span>
										</a>
									</li>
									<li>
										<a href="components/panels.html">
											<span class="sub-item">Panels</span>
										</a>
									</li>
									<li>
										<a href="components/notifications.html">
											<span class="sub-item">Notifications</span>
										</a>
									</li>
									<li>
										<a href="components/sweetalert.html">
											<span class="sub-item">Sweet Alert</span>
										</a>
									</li>
									<li>
										<a href="components/lists.html">
											<span class="sub-item">Lists</span>
										</a>
									</li>
									<li>
										<a href="components/owl-carousel.html">
											<span class="sub-item">Owl Carousel</span>
										</a>
									</li>
									<li>
										<a href="components/magnific-popup.html">
											<span class="sub-item">Magnific Popup</span>
										</a>
									</li>
									<li>
										<a href="components/font-awesome-icons.html">
											<span class="sub-item">Font Awesome Icons</span>
										</a>
									</li>
									<li>
										<a href="components/simple-line-icons.html">
											<span class="sub-item">Simple Line Icons</span>
										</a>
									</li>
									<li>
										<a href="components/flaticons.html">
											<span class="sub-item">Flaticons</span>
										</a>
									</li>
								</ul>
							</div>
                        </li> -->
                        
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->