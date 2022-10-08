</div>
</body>
<footer>

<script type="text/javascript" src="<?php echo public_assets('js/jquery.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_assets('js/popper.min.js') ?>"></script>
<script type="text/javascript" src="<?php echo public_assets('js/bootstrap.min.js') ?>"></script>
<script type="text/javascript" src="<?php $assets('js/app.js') ?>"></script>

<?php 
    echo esc($scripts['footer'], true);
    $include_scripts('footer');

    if($ads['pop']['status'])
        echo esc($ads['pop']['code'], true);
?>
</footer>
</html>