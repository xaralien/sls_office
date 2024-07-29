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
            <a href="<?= base_url('asset/sarlog') ?>" class="btn btn-success btn-sm">Approval Sarlog</a>
            <a href="<?= base_url('asset/direksi_ops') ?>" class="btn btn-success btn-sm">Approval Direktur Ops</a>
            <a href="<?= base_url('asset/dirut') ?>" class="btn btn-success btn-sm">Approval Direktur Utama</a>
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
            <a href="<?= base_url('asset/purchaseorder') ?>" class="btn btn-primary">Create PO</a>
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
                <?php if ($po->num_rows() < 1) { ?>
                  <tr align="center">
                    <td colspan="7">Tidak ada data</td>
                  </tr>
                  <?php } else {
                  foreach ($po->result_array() as $value) {
                    $vendor = $this->db->get_where('t_vendors', ['Id' => $value['vendor']])->row_array();
                  ?>
                    <tr>
                      <td scope="row"><?= $value['no_po'] ?></td>
                      <td scope="row"><?= $vendor['nama'] ?></td>
                      <td scope="row"><?= tgl_indo(date('Y-m-d', strtotime($value['tgl_pengajuan']))) ?></td>
                      <td scope="row"><?= $value['posisi'] ?></td>
                      <td scope="row">
                        <?php
                        if ($value['ppn']) {
                          $ppn = $value['total'] * 0.11;
                        } else {
                          $ppn = 0;
                        }
                        ?>
                        <?= number_format($value['total'] + $ppn) ?>
                      </td>
                      </td>
                      <td scope="row">
                        <a href="<?= base_url('asset/print/' . $value['Id']) ?>" class="btn btn-primary btn-sm" target="_blank">Print</a>
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal<?= $value['Id'] ?>">View</button>
                        <?php if ($value['status_sarlog'] == 0 or $value['status_sarlog'] == 2 or $value['status_direksi_ops'] == 2 or $value['status_dirut'] == 2) { ?>
                          <a href="<?= base_url('asset/update_po/' . $value['Id']) ?>" class="btn btn-success btn-sm">Update</a>
                        <?php } ?>
                        <?php if ($value['posisi'] == 'Sudah Dibayar' || $value['posisi'] == "Hutang") { ?>
                          <form action="<?= base_url('asset/add_item_in') ?>" method="post">
                            <input type="hidden" name="id_po" id="id_po" value="<?= $value['Id'] ?>">
                            <button class="btn btn-success btn-sm btn-submit">Add to list</button>
                          </form>
                        <?php } ?>
                        <!-- Modal Detail -->
                        <div class="modal fade" id="myModal<?= $value['Id'] ?>" role="dialog">
                          <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h2 class="modal-title">Purchase Order <?= $value['no_po'] ?></h2>
                              </div>
                              <div class="modal-body">
                                <table class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th width="20px">No.</th>
                                      <th>Item</th>
                                      <th width="25px">Qty</th>
                                      <th>UOI</th>
                                      <th>Price</th>
                                      <th>Total</th>
                                      <th>Ket</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $detail = $this->cb->get_where('t_po_detail', ['no_po' => $value['Id']])->result_array();
                                    $no = 1;
                                    foreach ($detail as $row) {
                                      $item = $this->db->get_where('item_list', ['Id' => $row['item']])->row_array();
                                    ?>
                                      <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $item['nama'] . ' | ' . $item['nomor'] ?></td>
                                        <td><?= $row['qty'] ?></td>
                                        <td><?= $row['uoi'] ?></td>
                                        <td><?= number_format($row['price'], 0) ?></td>
                                        <td><?= number_format($row['total'], 0) ?></td>
                                        <td><?= $row['keterangan'] ?></td>
                                      </tr>
                                    <?php } ?>
                                    <tr>
                                      <td colspan="5" align="right"><strong>SUB TOTAL</strong></td>
                                      <td><?= number_format($value['total']) ?></td>
                                    </tr>
                                    <tr>
                                      <td colspan="5" align="right"><strong>PPN 11%</strong></td>
                                      <td><?= number_format($ppn) ?></td>
                                    </tr>
                                    <tr>
                                      <td colspan="5" align="right"><strong>TOTAL</strong></td>
                                      <td><?= number_format($ppn + $value['total']) ?></td>
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
                                      <th>Catatan Direktur Operasional</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><?= $value['catatan_direksi_ops'] ? $value['catatan_direksi_ops'] : "Tidak ada catatan" ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table style="margin-top: 20px; width: 70%;" class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Catatan Direktur Utama</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td><?= $value['catatan_dirut'] ? $value['catatan_dirut'] : "Tidak ada catatan" ?></td>
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