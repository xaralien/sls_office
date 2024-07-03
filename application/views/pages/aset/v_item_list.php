<!-- Start content-->
<div class="right_col" role="main" style="height: 100%;">
    <div class="clearfix"></div>
    <div class="x_panel card">
        <!--div class="alert alert-info">Daftar Surat Kuasa </div-->
        <div align="center">
        </div>
        <!-- search -->
        <form data-parsley-validate action="" method="get" name="form_input" id="form_input">
            <label class="control-label col-md-1 col-sm-1 col-xs-4" for="cari_nama">Filter
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-8">
                <input type="text" id="search" name="search" class="form-control col-md-7 col-xs-12" placeholder="nama item yang akan dicari" value="<?= $this->input->get('search') ?>">
            </div>
            <button type="submit" class="btn btn-primary">Cari</button>
            <input type="button" class="btn btn-primary" value="Tampilkan Semua" onclick="window.location.href='<?php echo base_url(); ?>asset/item_list'" />
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal1">Tambah Item</button>
        </form>
        <form method="POST" action="<?= base_url('asset/filter_jenis_item') ?>" style="margin-bottom:20px;">
            <a href="<?= base_url('asset/export_item') ?>" class="btn btn-success">Excel <i class="fa fa-file-excel-o"></i></a>
        </form>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                        <th>Jenis</th>
                    </tr>
                </thead>
                <?php
                if (empty($users_data)) {
                ?>
                    <tbody>
                        <tr align="center">
                            <td colspan="7"><b>Belum ada data</b></td>
                        </tr>
                    </tbody>
                    <?php
                } else {
                    foreach ($users_data as $data) :
                    ?>
                        <!--content here-->
                        <tbody>
                            <tr>
                                <td><?php echo ++$page; ?></td>
                                <td><?php echo $data->nomor; ?></td>
                                <td><?php echo $data->nama; ?></td>
                                <td><?php echo $data->stok; ?></td>
                                <td><?php echo number_format($data->harga_sat); ?></td>
                                <td><?php echo number_format($data->harga_sat * $data->stok); ?></td>
                                <td><?php echo $data->nama_jenis; ?></td>
                            </tr>
                        </tbody>
                <?php
                    endforeach;
                }
                ?>
            </table>
        </div>

        <div class="clearfix"></div>

        <!--pagination-->
        <div class="row col-12 text-center">
            <?php echo $pagination; ?>
        </div>
    </div>

    <!-- Finish content-->


    <!-- /page content -->
    <form data-parsley-validate enctype="multipart/form-data" action="<?php echo base_url(); ?>asset/add_item" method="post" name="form-item" id="form-item" class="form-horizontal form-label-left">
        <div class="modal fade" id="myModal1" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2 class="modal-title">Tambah Data Item</h2>
                    </div>
                    <div class="modal-body">
                        <h4>
                            <font color="Grey"><Strong>
                        </h4><br>
                        <div class="form-group">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Kode <span class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input id="kode" class="form-control col-md-12 col-xs-12" name="kode" id="kode" placeholder="Masukkan kode item" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Nama Item <span class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <input id="kode" class="form-control col-md-12 col-xs-12" name="name" placeholder="Masukkan nama item" type="text">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="item form-group">
                                <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Jenis Item <span class="required">*</span>
                                </label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <select name="jenis_item" class="form-control select22" style="width: 100%;">
                                        <option value="">Pilih Jenis Item</option>
                                        <?php
                                        $jenis = $this->db->get('item_jenis')->result_array();
                                        foreach ($jenis as $value) {
                                        ?>
                                            <option value="<?= $value['Id'] ?>"><?= $value['nama_jenis'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <div style="text-align: center;">
                                <button type="submit" class="btn btn-primary" id="simpan-item">Simpan</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </form>
</div>