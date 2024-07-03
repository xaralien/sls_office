<!-- Start content-->
<div class="right_col" role="main">

    <div class="x_panel card">
        <!--div class="alert alert-info">Daftar Surat Kuasa </div-->
        <div align="center">
            <?php
            if (($this->uri->segment(2) == 'send_memo') or ($this->uri->segment(2) == 'send_cari')) {
            ?><font color="brown">Send Memo</font><br><br>
                <!-- search -->
                <form data-parsley-validate action="<?php echo base_url(); ?>app/send_cari" method="post" name="form_input" id="form_input">
                    <label class="control-label col-md-1 col-sm-1 col-xs-4" for="cari_nama">Filter
                        <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-8">
                        <input type="text" id="search" name="search" class="form-control col-md-7 col-xs-12" placeholder="isi dengan judul yang akan dicari">
                    </div>
                    <?php echo form_submit('cari_memo', 'Cari', 'class="btn btn-primary"'); ?>
                    <input type="button" class="btn btn-primary" value="Tampilkan Semua" onclick="window.location.href='<?php echo base_url(); ?>app/inbox'" />
                </form>
        </div>
    <?php } else { ?>
        <font color="brown">Inbox Memo</font><br><br>
    </div>
    <!-- search -->
    <form data-parsley-validate action="<?php echo base_url(); ?>app/inbox_cari" method="post" name="form_input" id="form_input">
        <label class="control-label col-md-1 col-sm-1 col-xs-4" for="cari_nama">Filter
            <span class="required">*</span>
        </label>
        <div class="col-md-6 col-sm-6 col-xs-8">
            <input type="text" id="search" name="search" class="form-control col-md-7 col-xs-12" placeholder="isi dengan judul yang akan dicari">
        </div>
        <?php echo form_submit('cari_memo', 'Cari', 'class="btn btn-primary"'); ?>
        <input type="button" class="btn btn-primary" value="Tampilkan Semua" onclick="window.location.href='<?php echo base_url(); ?>app/inbox'" />
    </form>

<?php } ?>


<div class="">
    <table class="table table-striped" width="100%">
        <thead>
            <tr>
                <th bgcolor="#008080">
                    <font color="white">No.</font>
                </th>
                <!-- <th bgcolor="#008080">
								<font color="white">No.Memo</font>
							</th> -->
                <th bgcolor="#008080">
                    <font color="white">Judul</font>
                </th>
                <th bgcolor="#008080">
                    <font color="white">Tanggal</font>
                </th>
                <?php if ($this->uri->segment(2) == 'send_memo' or $this->uri->segment(2) == 'send_cari') { ?>
                    <th bgcolor="#008080">
                        <font color="white">Kepada</font>
                    </th>
                <?php } else { ?>
                    <th bgcolor="#008080">
                        <font color="white">Dari</font>
                    </th>
                <?php } ?>
                <!--th bgcolor="#008080"><font color="white">Status</font></th-->
                <!-- <th bgcolor="#008080">
								<font color="white">Detail</font>
							</th> -->
            </tr>
        </thead>
        <?php
        // if ($this->uri->segment(3) == '') {
        // 	$no = 1;
        // } else {
        // 	$no = $this->uri->segment(4);
        // }
        if (empty($users_data)) {
        ?>

            <?php
        } else {
            foreach ($users_data as $data) :
            ?>
                <!--content here-->
                <tbody>
                    <tr>
                        <?php
                        $nip = $this->session->userdata('nip');
                        $kalimat = $data->read;
                        if (preg_match("/$nip/i", $kalimat)) { ?>
                            <p style="font-weight: normal;">
                                <td><a href="<?= base_url('app/memo_view/' . $data->id) ?>"><?= ++$page ?></a></td>
                                <td><a href="<?= base_url('app/memo_view/' . $data->id) ?>"><?= $data->judul ?></a></td>
                                <td><a href="<?= base_url('app/memo_view/' . $data->id) ?>"><?= date('d/m/y | H:i:s', strtotime($data->tanggal)) ?></a></td>
                                <td><?php
                                    if ($this->uri->segment(2) == 'send_memo' or $this->uri->segment(2) == 'send_cari') {
                                        $string = substr($data->nip_kpd, 0, -1);
                                        $arr_kpd = explode(";", $string);
                                        $last = $arr_kpd[0];
                                        $sql = "SELECT nama FROM users WHERE nip='$last';";
                                        $query = $this->db->query($sql);
                                        $result = $query->row();
                                        // echo $result->nama;
                                        echo '<a href=' . base_url("app/memo_view/" . $data->id) . '>' . $result->nama . '</a>';
                                    } else {
                                        // echo $data->nama;
                                        echo '<a href=' . base_url("app/memo_view/" . $data->id) . '>' . $data->nama . '</a>';
                                    } ?>
                                </td>
                            </p>
                        <?php } else { ?>
                            <td>
                                <p style="font-weight: bold;"><a href="<?= base_url('app/memo_view/' . $data->id) ?>"><?= ++$page ?></a></p>
                            </td>
                            <td>
                                <p style="font-weight: bold;"><a href="<?= base_url('app/memo_view/' . $data->id) ?>"><?= $data->judul ?></a></p>
                            </td>
                            <td>
                                <p style="font-weight: bold;"><a href="<?= base_url('app/memo_view/' . $data->id) ?>"><?= date('d/m/y | H:i:s', strtotime($data->tanggal)) ?></a></p>
                            </td>
                            <td>
                                <p style="font-weight: bold;">
                                    <?php
                                    if ($this->uri->segment(2) == 'send_memo' or $this->uri->segment(2) == 'send_cari') {
                                        $string = substr($data->nip_kpd, 0, -1);
                                        $arr_kpd = explode(";", $string);
                                        $last = $arr_kpd[0];
                                        $sql = "SELECT nama FROM users WHERE nip='$last';";
                                        $query = $this->db->query($sql);
                                        $result = $query->row();
                                        // echo $result->nama;
                                        echo '<a href=' . base_url("app/memo_view/" . $data->id) . '>' . $result->nama . '</a>';
                                    } else {
                                        // echo $data->nama;
                                        echo '<a href=' . base_url("app/memo_view/" . $data->id) . '>' . $data->nama . '</a>';
                                    } ?>
                                </p>
                            </td>
                        <?php } ?>
                    </tr>
                </tbody>
        <?php
            // $no++;
            endforeach;
        }
        ?>
    </table>
</div>

<!--pagination-->
<div class="row col-12 text-center">
    <?php echo $pagination; ?>
</div>