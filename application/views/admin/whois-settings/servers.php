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
                  <a href="<?php anchor_to(LAYOUT_CONTROLLER . '/analytics') ?>">
                  <?php echo esc($data['page_title']) ?>
                  </a>
               </li>
            </ul>
         </div>
         <?php $this->load->view('admin/includes/alert'); ?>
         <script>
            const servers = "<?php echo addslashes(json_encode($modules['whois'])) ?>";
         </script>
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">
                     <div class="card-title">Whois Servers List</div>
                  </div>
                <input id="form-data" type="hidden" name="servers" value="<?php echo addslashes(json_encode($modules['whois'])) ?>" />
					<div class="card-body">
                        <div id="dom-none-template" class="d-none">
                            <div class="mt-2 p-3 bg-light text-dark border rounded">
                                <div class="cst-table-row">
                                    <div class="row">
                                        <div class="col-12">
                                            <span>Currently WHOIS server list empty, you can add WHOIS servers from below.</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="dom-template" class="d-none">
                            <div class="mt-2 p-3 bg-light text-dark border rounded">
                                <div class="cst-table-row">
                                    <div class="row">
                                        <div class="col-2">
                                            <span>{{i}}</span>
                                        </div>
                                        <div class="col-2">
                                            <span>{{tld}}</span>
                                        </div>
                                        <div class="col-6">
                                            <span>{{server}}</span>
                                        </div>
                                        <div class="col-2">
                                            <span><button data-tld="{{tld}}" class="delete-server badge badge-danger"><i class="fas fa-trash mr-1"></i> Delete</button></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 p-3 bg-primary text-light font-weight-bold rounded">
                            <div class="cst-table-head">
                                <div class="row">
                                    <div class="col-2">
                                        <span>#</span>
                                    </div>
                                    <div class="col-2">
                                        <span>TLD</span>
                                    </div>
                                    <div class="col-6">
                                        <span>Server</span>
                                    </div>
                                    <div class="col-2">
                                        <span>Action</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="server-container">
                            <?php foreach($modules['whois'] as $i => $server) { ?>
                                <div class="page-sortable mt-2 p-3 bg-light text-dark border rounded">
                                    <div class="cst-table-row">
                                        <div class="row">
                                            <div class="col-2">
                                                <span><?php echo $i + 1 ?></span>
                                            </div>
                                            <div class="col-2">
                                                <span><?php echo $server['tld'] ?></span>
                                            </div>
                                            <div class="col-6">
                                                <span><?php echo $server['server'] ?></span>
                                            </div>
                                            <div class="col-2">
                                                <span><button data-tld="<?php echo $server['tld'] ?>" class="delete-server badge badge-danger"><i class="fas fa-trash mr-1"></i> Delete</button></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <hr>
                        <div class="insert-server mt-2">
                        
                            <h3>Add New Server</h3>
                            <div class="row">
                               
                                <div class="col-5">
                                    <input placeholder="TLD" type="text" id="new-tld" class="form-control" />
                                </div>
                                <div class="col-5">
                                    <input placeholder="WHOIS Server" type="text" id="new-server" class="form-control" />
                                </div>
                                <div class="col-2">
                                    <button id="add-server" class="btn btn-success btn-block">
                                        <i class="fa fa-plus mr-1"></i> Add
                                    </button>
                                </div>
                                <div id="alertHolder" class="col-md-12 mt-4">
                                
                                </div>
                            </div>
                        </div>
					</div>
					<div class="card-action">
						<button id="submit-change" type="submit" class="btn btn-success"><i class="fas fa-check mr-1"></i> Update Servers</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- End Page Content -->
</div>
<?php $this->load->view('admin/includes/foot'); ?>