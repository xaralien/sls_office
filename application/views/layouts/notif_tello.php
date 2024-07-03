<li role="presentation" class="dropdown">
    <a href="<?php echo base_url() . "task/task"; ?>" class="dropdown-toggle info-number">
        <img width="30px" src="<?= base_url('assets/img/tello.png') ?>" alt="">
        <?php if ($count_inbox2 == 0) { ?>
            <span class="badge bg-green"><?php echo $count_inbox2; ?></span>
        <?php } else { ?>
            <span class="badge bg-red"><?php echo $count_inbox2; ?></span>
        <?php } ?>
    </a>

</li>