<!-- page content -->
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
                <div class="col-md-2 col-sm-4 tile_stats_count" style="background-color: green; color: white; cursor: pointer;" onclick="location.href='<?= base_url('pengajuan/approval_spv') ?>'">
                  <span class="count_top">Waiting Approval</span>
                  <div class="count"><?= $count_spv->num_rows() ?></div>
                </div>
              </div>
            <?php } ?>
            <?php if (strpos($a, '803') !== false) { ?>
              <div class="tile_count">
                <div class="col-md-2 col-sm-4 tile_stats_count" style="background-color: green; color: white; cursor: pointer;" onclick="location.href='<?= base_url('pengajuan/approval_keuangan') ?>'">
                  <span class="count_top">Waiting Approval</span>
                  <div class="count"><?= $count_keuangan->num_rows() ?></div>
                </div>
              </div>
            <?php } ?>
            <?php if (strpos($a, '804') !== false) { ?>
              <div class="tile_count">
                <div class="col-md-2 col-sm-4 tile_stats_count" style="background-color: green; color: white; cursor: pointer;" onclick="location.href='<?= base_url('pengajuan/approval_direksi') ?>'">
                  <span class="count_top">Waiting Approval</span>
                  <div class="count"><?= $count_direksi->num_rows() ?></div>
                </div>
              </div>
            <?php } ?>
          </div>
          <div class="row">
            <a href="<?= base_url('pengajuan/create') ?>" class="btn btn-primary">Create Pengajuan</a>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">No. Rekening</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Total</th>
                  <th scope="col">Posisi</th>
                  <th scope="col">#</th>
                </tr>
              </thead>
              <tbody>
                <?php if (!$pengajuan) { ?>
                  <tr align="center">
                    <td colspan="7">Belum ada data</td>
                  </tr>
                  <?php } else {
                  foreach ($pengajuan as $value) {  ?>
                    <tr>
                      <td scope="row"><?= $value['no_pengajuan'] ?></td>
                      <td scope="row"><?= $value['no_rekening'] ?></td>
                      <td scope="row"><?= $value['created_at'] ?></td>
                      <td scope="row"><?= number_format($value['total']) ?></td>
                      <td scope="row"><?= $value['posisi'] ?>
                      </td>
                      <td scope="row">
                        <?php if ($value['status_spv'] == 0 or $value['status_spv'] == 2 or $value['status_keuangan'] == 2 or $value['status_direksi'] == 2) { ?>
                          <a href="<?= base_url('pengajuan/ubah/' . $value['Id']) ?>" class="btn btn-success btn-xs">Update</a>
                        <?php } ?>
                        <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal<?= $value['Id'] ?>">View</button>
                        <!-- Modal Detail -->
                        <div class="modal fade" id="myModal<?= $value['Id'] ?>" role="dialog">
                          <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h2 class="modal-title">Pengajuan <?= $value['no_pengajuan'] ?></h2>
                              </div>
                              <div class="modal-body">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>No.</th>
                                      <th>Item</th>
                                      <th>Qty</th>
                                      <th>Price</th>
                                      <th>Total</th>
                                      <th>Realisasi</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php $detail = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $value['no_pengajuan']])->result_array();
                                    $no = 1;
                                    foreach ($detail as $row) {
                                    ?>
                                      <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['item'] ?></td>
                                        <td><?= $row['qty'] ?></td>
                                        <td><?= number_format($row['price'], 0) ?></td>
                                        <td><?= number_format($row['total'], 0) ?></td>
                                        <td><?= $row['realisasi'] ? number_format($row['realisasi'], 0) : "-" ?></td>
                                      </tr>
                                    <?php } ?>
                                    <tr>
                                      <td colspan="4" align="right"><strong>TOTAL</strong></td>
                                      <td><?= number_format($value['total']) ?></td>
                                      <td><?= $value['total_realisasi'] ? number_format($value['total_realisasi']) : "-" ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table style="margin-top: 20px; width: 70%;" class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Catatan</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><?= $value['catatan'] ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table style="margin-top: 20px; width: 70%;" class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Catatan SPV</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><?= $value['catatan_spv'] ? $value['catatan_spv'] : "Tidak ada catatan" ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table style="margin-top: 20px; width: 70%;" class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Catatan Keuangan</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><?= $value['catatan_keuangan'] ? $value['catatan_keuangan'] : "Tidak ada catatan" ?></td>
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
                                      <th>Attachment Pengajuan</th>
                                      <th>Attachment Bayar</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><a href="<?= base_url('upload/pengajuan/' . $value['bukti_pengajuan']) ?>" class="btn btn-success btn-xs" download="">Download</a></td>
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
          <div class="row text-center">
            <?= $pagination ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>