<div class="right_col" role="main">

    <div class="x_panel card">
        <!--div class="alert alert-info">Daftar Surat Kuasa </div-->
        <div align="center">
            <?php
            if (($this->uri->segment(2) == 'send_memo') or ($this->uri->segment(2) == 'send_cari')) {
            ?><font color="brown">Send Memo</font><br><br>
        </div>
        <!-- search -->
        <form data-parsley-validate action="<?php echo base_url(); ?>task/send_cari" method="post" name="form_input" id="form_input">
            <label class="control-label col-md-1 col-sm-1 col-xs-4" for="cari_nama">Filter
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-8">
                <input type="text" id="search" name="search" class="form-control col-md-7 col-xs-12" placeholder="isi dengan task name yang akan dicari">
            </div>
            <?php echo form_submit('cari_memo', 'Cari', 'class="btn btn-primary"'); ?>
            <input type="button" class="btn btn-primary" value="Tampilkan Semua" onclick="window.location.href='<?php echo base_url(); ?>task/task'" />
        </form>
    <?php } else { ?>
        <font color="brown">Task</font><br><br>
    </div>
    <!-- search -->
    <form data-parsley-validate action="<?php echo base_url(); ?>task/task_cari" method="post" name="form_input" id="form_input">
        <label class="control-label col-md-1 col-sm-1 col-xs-4" for="cari_nama">Filter
            <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-8">
            <input type="text" id="search" name="search" class="form-control col-md-7 col-xs-12" placeholder="isi dengan task name yang akan dicari">
        </div>
        <?php echo form_submit('cari_memo', 'Cari', 'class="btn btn-primary"'); ?>
        <input type="button" class="btn btn-primary" value="Tampilkan Semua" onclick="window.location.href='<?php echo base_url(); ?>task/task'" />
    </form>

<?php } ?>

<div class="">
    <table class="table table-stripped">
        <thead>
            <tr>
                <th bgcolor="#008080">
                    <font color="white">No.</font>
                </th>
                <th width="300" bgcolor="#008080">
                    <font color="white">Task Name</font>
                </th>
                <!-- <th width="300" bgcolor="#008080">
                <font color="white">Member Name</font>
              </th> -->
                <th bgcolor="#008080">
                    <font color="white">PIC</font>
                </th>
                <th bgcolor="#008080">
                    <font color="white">Created</font>
                </th>
                <th bgcolor="#008080">
                    <font color="white">#</font>
                </th>
                <!--th bgcolor="#008080"><font color="white">Status</font></th-->
            </tr>
        </thead>
        <?php
        if ($this->uri->segment(3) == '') {
            $no = 1;
        } else {
            $no = $this->uri->segment(4);
        }
        if (empty($users_data)) {
        ?>

            <?php
        } else {
            foreach ($users_data as $data) :
                $cek_detail = $this->db->get_where('task_detail', ['id_task' => $data->id])->result();
                $cek_num = $this->db->get_where('task_detail', ['id_task' => $data->id])->num_rows();
                if ($cek_num == true) {
                    foreach ($cek_detail as $k) {
                        if ($k->due_date > date('Y-m-d')) {
                            $cek_task = 1;
                        } else {
                            $cek_task = 0;
                        }
                    }
                } else {
                    $cek_task = 0;
                }

                if ($data->activity == '1' && $cek_task == 1) {
                    $color = '#00b894';
                } else if ($data->activity == '3') {
                    $color = '#636e72';
                } else {
                    $color = '#ff7675';
                }


            ?>
                <!--content here-->
                <tbody>
                    <?php
                    $nip = $this->session->userdata('nip');
                    $this->db->where('id_task', $data->id);
                    $task_detail = $this->db->get('task_detail')->row_array();
                    if (!is_null($task_detail)) {
                    ?>
                        <tr style="background-color: <?= $color ?>;color:white;">
                            <?php
                            $nip = $this->session->userdata('nip'); ?>
                            <td><?php echo ++$page; ?></td>
                            <td><a href="<?= base_url() . "task/task_view/" . $data->id ?>" style="text-decoration: none; color:white !important"><?php echo $data->name; ?></a></td>
                            <!-- <td>
                      <?php
                        $data_nip = explode(';', $data->member);
                        foreach ($data_nip as $x) {

                            if ($x != '') {
                                $this->db->where('nip', $x);

                                $get = $this->db->get('users')->row_array();
                                echo $get['nama'] . ', ';
                            }
                        }
                        ?>

                    </td> -->
                            <td><?php
                                $this->db->where('nip', $data->pic);
                                $get = $this->db->get('users')->row_array();
                                ?>
                                <a href="<?= base_url() . "task/task_view/" . $data->id ?>" style="text-decoration: none; color:white !important"><?= $get['nama'] ?></a>
                            </td>
                            <td><a href="<?= base_url() . "task/task_view/" . $data->id ?>" style="text-decoration: none; color:white !important"><?php echo date('d/m/y', strtotime($data->date_created)); ?></a></td>
                            <td>
                                <!-- <a href="<?= base_url() . "task/task_view/" . $data->id ?>" class="btn btn-xs" style="background-color: white;color:black;">Open</a> -->
                                <?php if ($data->pic == $this->session->userdata('nip')) { ?>
                                    <a href="<?= base_url('task/create_task/' . $data->id) ?>" class="btn btn-xs" style="background-color: black;color:white;"><i class="fa fa-pencil"></i></a>
                                <?php } ?>
                                <?php
                                $read = "SELECT id FROM task WHERE task.read LIKE '%$nip%' AND task.id = $data->id";
                                $read = $this->db->query($read)->row();

                                if (!$read) {
                                ?>
                                    <i style="color: #fff;" class="fa fa-circle"></i>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } else { ?>
                        <tr style="background-color: <?= $color ?>;color:white;">
                            <?php
                            $nip = $this->session->userdata('nip');
                            ?>
                            <td><?php echo ++$page; ?></td>
                            <td><a href="<?= base_url() . "task/task_view/" . $data->id ?>" style="text-decoration: none; color:white !important"><?php echo $data->name; ?></a></td>
                            <!-- <td>
                      <?php
                        $data_nip = explode(';', $data->member);
                        foreach ($data_nip as $x) {

                            if ($x != '') {
                                $this->db->where('nip', $x);
                                $get = $this->db->get('users')->row_array();
                                echo $get['nama'] . ', ';
                            }
                        }
                        ?>
                    </td> -->
                            <td>
                                <?php
                                $this->db->where('nip', $data->pic);
                                $get = $this->db->get('users')->row_array();
                                ?>
                                <a href="<?= base_url() . "task/task_view/" . $data->id ?>" style="text-decoration: none; color:white !important"><?= $get['nama'] ?></a>
                            </td>
                            <td><a href="<?= base_url() . "task/task_view/" . $data->id ?>" style="text-decoration: none; color:white !important"><?php echo date('d/m/y', strtotime($data->date_created)); ?></a></td>
                            <td>
                                <!-- <a href="<?= base_url() . "task/task_view/" . $data->id ?>" class="btn btn-xs" style="background-color: white;color:black;">Open</a> -->
                                <?php if ($data->pic == $this->session->userdata('nip')) { ?>
                                    <a href="<?= base_url('task/create_task/' . $data->id) ?>" class="btn btn-xs" style="background-color: black;color:white;"><i class="fa fa-pencil"></i></a>
                                <?php } ?>

                                <i style="color: #fff;" class="fa fa-circle"></i>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
        <?php
                $no++;
            endforeach;
        }
        ?>
    </table>
</div>

<!--pagination-->
<div class="row col-12 text-center">
    <?php echo $pagination; ?>
</div>