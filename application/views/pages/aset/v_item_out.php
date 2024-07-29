<div class="right_col" role="main" style="height: 100%;">
  <div class="clearfix"></div>

  <div class="x_panel card">
    <!--div class="alert alert-info">Daftar Surat Kuasa </div-->
    <div align="center">
    </div>
    <!-- search -->

    <!-- <form data-parsley-validate action="<?php echo base_url(); ?>asset/item_cari" method="post" name="form_input" id="form_input">
      <label class="control-label col-md-1 col-sm-1 col-xs-4" for="cari_nama">Filter
        <span class="required">*</span>
      </label>
      <div class="col-md-6 col-sm-6 col-xs-8">
        <input type="text" id="search" name="search" class="form-control col-md-7 col-xs-12" placeholder="nama item yang akan dicari">
      </div>
      <?php echo form_submit('cari_asset', 'Cari', 'class="btn btn-primary"'); ?>
      <input type="button" class="btn btn-primary" value="Tampilkan Semua" onclick="window.location.href='<?php echo base_url(); ?>asset/item_list'" />
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal1">Tambah Item Out</button>
    </form> -->
    <!-- <form method="POST" action="<?= base_url('asset/filter_jenis_item') ?>" style="margin-bottom:20px;">
      <label class="control-label col-md-1 col-sm-1 col-xs-4">Filter Jenis</label>
      <div class="col-md-2 col-sm-2 col-xs-4">
        <select name="jenis" onchange="form.submit()" id="" class="form-control">
          <?php $jenis_item = $this->session->userdata('filterJenis') ? $this->session->userdata('filterJenis') : '' ?>
          <option selected>Pilih Jenis</option>
          <option <?= $jenis_item == '1' ? 'selected'  : '' ?> value="1">1</option>
          <option <?= $jenis_item == '2' ? 'selected'  : '' ?> value="2">2</option>
          <option <?= $jenis_item == '3' ? 'selected'  : '' ?> value="3">3</option>
          <option <?= $jenis_item == '4' ? 'selected'  : '' ?> value="4">Mobil</option>
          <option <?= $jenis_item == '5' ? 'selected'  : '' ?> value="5">ABK</option>
          <option <?= $jenis_item == '99' ? 'selected'  : '' ?> value="99">IT</option>
        </select>
      </div>
      <a class="btn btn-warning" href="<?= base_url('asset/reset_jenis_item') ?>">Reset</a>
      <a href="<?= base_url('asset/export_item') ?>" class="btn btn-success">Excel <i class="fa fa-file-excel-o"></i></a>

    </form> -->
    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama Asset</th>
            <th>Nama Item</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Status</th>
            <th>#</th>
          </tr>
        </thead>
        <?php
        if (($this->uri->segment(2) == 'asset_cari') and ($this->uri->segment(3) <> '')) {
          $no = $this->uri->segment(4) + 1;
        } else {
          $no = $this->uri->segment(3) + 1;
        }
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
                <td><?php echo $no; ?></td>
                <td><?php echo $data->nama_asset; ?></td>
                <td><?php echo $data->nama; ?></td>
                <td><?php echo $data->jml; ?></td>
                <td><?php echo number_format($data->harga); ?></td>
                <td>
                  <?php
                  if ($data->status == 1) {
                    echo "Barang diserahkan";
                  }

                  if ($data->status == 2) {
                    echo "Closed";
                  }
                  ?></td>
                <td>
                  <!-- <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal3" onclick="get_item_out(<?= $data->Id ?>)">Detail</button> -->
                  <?php if ($data->status == 1) { ?>
                    <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModal<?= $data->Id ?>">Close</button>
                    <div class="modal fade" id="myModal<?= $data->Id ?>" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title">Update Data Item Out</h2>
                          </div>
                          <div class="modal-body">
                            <form action="<?= base_url('asset/close_item_out') ?>" method="post" enctype="multipart/form-data" id="close-item-out">
                              <input type="hidden" name="id_item_out" class="form-control" value="<?= $data->Id ?>">
                              <label class="col-form-label label-align" for="last-name">Image<span class="required">*</span></label>
                              <input class="form-control" name="image_close" type="file">
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary btn-submit">Update</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </td>
              </tr>
            </tbody>
        <?php
            $no++;
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
</div>