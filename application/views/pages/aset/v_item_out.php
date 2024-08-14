<div class="right_col" role="main" style="height: 100%;">
  <div class="clearfix"></div>

  <div class="x_panel card">
    <!--div class="alert alert-info">Daftar Surat Kuasa </div-->
    <div class="x_title">
      <h2>Item Out</h2>
    </div>
    <div class="row">
      <div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 form-group" style="margin: 0; padding:0;">
        <form class="form-horizontal form-label-left" method="get" action="<?= base_url('asset/item_out') ?>">
          <div class="input-group">
            <input type="text" class="form-control" placeholder="input nama asset, item atau keterangan" name="keyword" id="keyword" value="<?= $this->input->get('keyword') ?>">
            <span class="input-group-btn">
              <button class="btn btn-default" type="submit">Search</button>
              <a href="<?= base_url('asset/item_out') ?>" class="btn btn-warning" style="color:white;">Reset</a>
            </span>
          </div><!-- /input-group -->
        </form>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>No.</th>
            <th>User</th>
            <th>Nama Asset</th>
            <th>Nama Item</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Status</th>
            <th>Ket</th>
            <th>#</th>
          </tr>
        </thead>
        <?php
        if (empty($users_data)) {
        ?>
          <tbody>
            <tr align="center">
              <td colspan="9"><b>Belum ada data</b></td>
            </tr>
          </tbody>
          <?php
        } else {
          foreach ($users_data as $data) :
          ?>
            <!--content here-->
            <tbody>
              <tr>
                <td><?= ++$page ?></td>
                <td><?= $data->nama_user ?></td>
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
                  ?>
                </td>
                <td><?= $data->keterangan ?></td>
                <td>
                  <!-- <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal3" onclick="get_item_out(<?= $data->Id ?>)">Detail</button> -->
                  <?php if ($data->status == 1) { ?>
                    <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal<?= $data->Id ?>">Close</button>
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

                  <?php if ($data->status == 2) { ?>
                    <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myDetail<?= $data->Id ?>">View</button>
                    <div class="modal fade" id="myDetail<?= $data->Id ?>" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h2 class="modal-title">Detail</h2>
                          </div>
                          <div class="modal-body">
                            <table style="margin-top: 20px;" class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Bukti Serah Terima Barang</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <?php if ($data->bukti_serah) { ?>
                                      <a href="<?= base_url('upload/bukti-serah/') . $data->bukti_serah ?>" class="btn btn-success btn-xs" target="_blank">Lihat Bukti Serah Terima Barang</a>
                                    <?php } else { ?>
                                      -
                                    <?php } ?>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <table style="margin-top: 20px;" class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Bukti Close</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>
                                    <?php if ($data->image_close) { ?>
                                      <a href="<?= base_url('upload/bukti-close/') . $data->image_close ?>" class="btn btn-success btn-xs" target="_blank">Lihat Bukti Close</a>
                                    <?php } else { ?>
                                      -
                                    <?php } ?>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                </td>
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
</div>