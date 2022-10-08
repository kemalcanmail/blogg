<?php 
    $view('includes/head');
    $view('includes/head-bar');
?>

<div class="container-lg main-page">
    <div class="search-section">
        <div class="search-block row">
            <div class="wrapper col-md-12">
                <h2>Contact Us</h2>
                <div class="subHeading">
                    Send us a message via E-Mail.
                </div>

                <form method="POST" id="domainInput" class="ContactForm mt-4">
                    <div class="row">
                        <?php if(isset($data['alert'])) { ?>
                            <div class="col-md-12 form-group">
                                <div class="alert alert-<?php echo $data['alert']['type'] ?> position-relative rounded w-100">
                                    <span><?php echo $data['alert']['msg'] ?></span>
                                    <ul>
                                        <?php echo validation_errors('<li>','</li>') ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-6">
                            <div class="col-md-12 form-group">
                                <input name="full-name" type="text" class="form-control form-control-lg shadow-md" placeholder="Enter your Name" aria-label="Name" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <input name="email" type="email" class="form-control form-control-lg shadow-md" placeholder="Enter your E-Mail Address" aria-label="Email Address" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6 form-group">
                            <div class="col-md-12">
                                <textarea name="message" rows="4" class="form-control form-control-lg shadow-md" placeholder="Your message..." aria-label="Message" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12 form-group text-right">
                            <input type="hidden" value="true" name="submit">
                            <button id="searchBtn" class="btn btn-lg btn-df" type="submit"><span>Send Message</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php 
    $view('includes/foot-bar');
    $view('includes/foot');
?>