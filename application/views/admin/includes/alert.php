<?php if(isset($data['alert']) || $data['alert'] = $this->session->flashdata('alert')) { ?>
    <div class="<?php echo esc($data['alert']['type']) ?> alert-dismissible fade show rounded">
        <span><?php echo esc($data['alert']['msg']); ?></span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php } ?>