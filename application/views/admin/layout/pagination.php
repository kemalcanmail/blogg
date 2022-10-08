<?php

$p_prev  = $data['pagination']['page'] - 1;
$p_next  = $data['pagination']['page'] + 1;
$p_total = $data['pagination']['pages'];
$p_curr  = $data['pagination']['page'];
$p_url   = $data['pagination']['url'];

?>
<nav class="d-inline-block">
    <ul class="data['pagination']">
        <li class="page-item">
            <a class="page-link" href="<?= $p_url . '/1' ?>">First</a>
        </li>
        <li class="page-item <?= $p_curr < 2 ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $p_url . '/' . $p_prev ?>" tabindex="-1"><i class="fas fa-angle-left"></i></a>
        </li>
        <?php if($p_curr > 1) { ?>
            <?php for($i = 1; $i < $p_cur; $i++) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $p_url . '/' . $i ?>"><?= $i ?></a>
                </li>
            <?php } ?>
        <?php } ?>
        <li class="page-item active">
            <a class="page-link" href="<?= $p_url . '/' . $p_curr ?>"><?= $p_curr ?></a>
        </li>
        <?php if($p_curr < $p_total) { ?>
            <?php for($i = $p_curr + 1; $i <= $p_total; $i++) { ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $p_url . '/' . $i ?>"><?= $i ?></a>
                </li>
            <?php } ?>
        <?php } ?>
        <li class="page-item <?= $p_curr >= $p_total ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $p_url . '/' . $p_next ?>"><i class="fas fa-angle-right"></i></a>
        </li>
        <li class="page-item">
            <a class="page-link" href="<?= $p_url . '/' . $p_total ?>">Last</a>
        </li>
    </ul>
</nav>