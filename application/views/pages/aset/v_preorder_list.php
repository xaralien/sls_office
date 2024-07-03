<div class="right_col" role="main">
  <div class="clearfix"></div>



  <!-- Start content-->

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">

      <div class="x_panel card">

        <div class="x_title">

          <h2>List Pengajuan</h2>

        </div>

        <div class="x_content">
          <div class="row">
            <?php $a = $this->session->userdata('level');
            if (strpos($a, '802') !== false) { ?>
              <div class="tile_count">
                <div class="col-md-2 col-sm-4 tile_stats_count" style="background-color: green; color: white; cursor: pointer;" onclick="location.href='<?= base_url('pengajuan/approval_spv') ?>'"> <span class="count_top">Waiting Approval</span>
                  <div class="count"><?= $count_spv->num_rows() ?></div>
                </div>
              </div>
            <?php } ?>
            <div class="tile_count">
              <div class="col-md-2 col-sm-4 tile_stats_count" style="background-color: green; color: white; cursor: pointer;" onclick="location.href='<?= base_url('asset/sarlog') ?>'"> <span class="count_top">Waiting Approval Sarlog</span>
                <div class="count"><?= $count_sarlog ?></div>
              </div>
            </div>

            <div class="tile_count">
              <div class="col-md-2 col-sm-4 tile_stats_count" style="background-color: green; color: white; cursor: pointer;" onclick="location.href='<?= base_url('asset/direksi') ?>'"> <span class="count_top">Waiting Approval Direksi</span>
                <div class="count"><?= $count_direksi ?></div>
              </div>
            </div>
            <?php if (strpos($a, '803') !== false) { ?>
              <div class="tile_count">
                <div class="col-md-2 col-sm-4 tile_stats_count" style="background-color: green; color: white; cursor: pointer;" onclick="location.href='<?= base_url('pengajuan/approval_keuangan') ?>'"> <span class="count_top">Waiting Approval</span>
                  <div class="count"><?= $count_keuangan->num_rows() ?></div>
                </div>
              </div>
            <?php } ?>
            <?php if (strpos($a, '804') !== false) { ?>
              <div class="tile_count">
                <div class="col-md-2 col-sm-4 tile_stats_count" style="background-color: green; color: white; cursor: pointer;" onclick="location.href='<?= base_url('pengajuan/approval_direksi') ?>'"> <span class="count_top">Waiting Approval</span>
                  <div class="count"><?= $count_direksi->num_rows() ?></div>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="row">
            <a href="<?= base_url('asset/preorder') ?>" class="btn btn-primary">Create Preorder</a>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Vendor</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Posisi</th>
                  <th scope="col">Total</th>
                  <th scope="col">#</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!$preorder) { ?> <tr align="center">
                    <td colspan="7">Belum ada data</td>
                  </tr> <?php } else {
                        foreach ($preorder->result_array() as $value) {  ?>
                    <tr>
                      <td scope="row"><?= $value['no_po'] ?></td>
                      <td scope="row"><?= $value['nama'] ?></td>
                      <td scope="row"><?= $value['tgl_pengajuan'] ?></td>
                      <td scope="row"><?= $value['posisi'] ?></td>
                      <td scope="row"><?= number_format($value['total']) ?></td>
                      </td>
                      <td scope="row">
                        <?php if ($value['status_sarlog'] == 0 or $value['status_sarlog'] == 2 or $value['status_direksi'] == 2) { ?>
                          <a href="<?= base_url('pengajuan/ubah/' . $value['Id']) ?>" class="btn btn-success btn-sm">Update</a>
                        <?php } ?>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal<?= $value['Id'] ?>">View</button>
                        <!-- Modal Detail -->
                        <div class="modal fade" id="myModal<?= $value['Id'] ?>" role="dialog">
                          <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h2 class="modal-title">Preorder <?= $value['no_po'] ?></h2>
                              </div>
                              <div class="modal-body">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th width="20px">No.</th>
                                      <th>Item</th>
                                      <th width="25px">Qty</th>
                                      <th>Price</th>
                                      <th>Total</th>
                                      <th width="30px">#</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $detail = $this->cb->get_where('t_preorder_detail', ['no_po' => $value['no_po']])->result_array();
                                    $no = 1;
                                    foreach ($detail as $row) {
                                      $item = $this->db->get_where('item_list', ['Id' => $row['item']])->row_array();
                                    ?>
                                      <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $item['nama'] . ' | ' . $item['nomor'] ?></td>
                                        <td><?= $row['qty'] ?></td>
                                        <td><?= number_format($row['price'], 0) ?></td>
                                        <td><?= number_format($row['total'], 0) ?></td>
                                        <td><a href="<?= base_url('asset/add_item/' . $item['Id']) ?>" class="btn btn-success btn-xs">Add to list</a></td>
                                      </tr>
                                    <?php } ?>
                                    <tr>
                                      <td colspan="4" align="right"><strong>TOTAL</strong></td>
                                      <td><?= number_format($value['total']) ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table style="margin-top: 20px; width: 70%;" class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Keterangan</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><?= $value['keterangan'] ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table style="margin-top: 20px; width: 70%;" class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Catatan Sarlog</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><?= $value['catatan_sarlog'] ? $value['catatan_sarlog'] : "Tidak ada catatan" ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table style="margin-top: 20px; width: 70%;" class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Catatan Direksi</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><?= $value['catatan_direksi'] ? $value['catatan_direksi'] : "Tidak ada catatan" ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table style="margin-top: 20px; width:50%" class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Attachment Bayar</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <?php if ($value['bukti_bayar']) { ?>
                                          <a href="<?= base_url('upload/pengajuan/' . $value['bukti_bayar']) ?>" class="btn btn-success btn-xs" download="">Download</a>
                                        <?php } else { ?>
                                          <span> -</span>
                                        <?php } ?>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                        </div>
                      </td>
                    </tr>
                <?php }
                      } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>