<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel card">
        <div class="x_title">
          <h2>List Purchase Order Item Out</h2>
        </div>
        <div class="x_content">
          <a href="<?= base_url('asset/ro_list') ?>" class="btn btn-warning">Back</a>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">User</th>
                  <!-- <th scope="col">Asset</th> -->
                  <th scope="col">Tanggal</th>
                  <th scope="col">Posisi</th>
                  <th scope="col">Status</th>
                  <th scope="col">Total</th>
                  <th scope="col">#</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($ro->num_rows() < 1) { ?>
                  <tr align="center">
                    <td colspan="7">Belum ada data</td>
                  </tr>
                  <?php } else {
                  foreach ($ro->result_array() as $value) {
                    $user = $this->db->get_where('users', ['nip' => $value['user']])->row_array();
                    // $asset = $this->db->get_where('asset_list', ['Id' => $value['asset']])->row_array();
                    if ($value['status_sarlog'] == 0) {
                      $status = 'Belum diproses';
                      $color = "#e67e22";
                    } else if ($value['status_sarlog'] == 1) {
                      $status = 'Disetujui';
                      $color = "#2ecc71";
                    } else {
                      $status = 'Ditolak';
                      $color = "#e74c3c";
                    }
                  ?>
                    <tr>
                      <td scope="row"><?= $value['no_ro'] ?></td>
                      <td scope="row"><?= $user['nama'] ?></td>
                      <td scope="row"><?= tgl_indo(date('Y-m-d', strtotime($value['tgl_pengajuan']))) ?></td>
                      <td scope="row"><?= $value['posisi'] ?></td>
                      <td scope="row" style="color: <?= $color ?>;"><?= $status ?></td>
                      <td scope="row"><?= number_format($value['total']) ?></td>
                      </td>
                      <td scope="row">
                        <button class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal<?= $value['Id'] ?>">View</button>
                        <?php if ($value['status_sarlog'] == 1 and $value['status_direksi_ops'] == 1 and $value['user_serah'] != null) { ?>
                          <a href="<?= base_url('asset/print_ro/' . $value['Id']) ?>" class="btn btn-primary btn-xs" target="_blank">Print</a>
                        <?php }
                        if ($value['bukti_serah'] == null and $value['status_direksi_ops'] == 1 and $value['user_serah'] != null) {
                        ?>
                          <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#uploadBuktiSerah<?= $value['Id'] ?>">Upload Bukti Serah</button>
                        <?php } ?>

                        <?php if ($value['posisi'] == 'Disetujui Direktur Operasional') { ?>
                          <a href="<?= base_url('asset/serah_item/' . $value['Id']) ?>" class="btn btn-success btn-xs">Serahkan</a>
                        <?php } ?>
                        <!-- Modal Detail -->
                        <div class="modal fade" id="myModal<?= $value['Id'] ?>" role="dialog">
                          <div class="modal-dialog modal-lg">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h2 class="modal-title">Release Order <?= $value['no_ro'] ?></h2>
                              </div>
                              <div class="modal-body">
                                <div class="table-responsive">
                                  <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th>No.</th>
                                        <th>Item</th>
                                        <th>Detail</th>
                                        <th>Qty</th>
                                        <th>UOI</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                        <th>Ket</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <?php
                                      $detail = $this->cb->get_where('t_ro_detail', ['no_ro' => $value['Id']])->result_array();
                                      $no = 1;
                                      foreach ($detail as $row) {
                                        $item = $this->db->get_where('item_list', ['Id' => $row['item']])->row_array();
                                      ?>
                                        <tr>
                                          <td><?= $no++ ?></td>
                                          <td><?= $item['nama'] ?></td>
                                          <td></td>
                                          <td><?= $row['qty'] ?></td>
                                          <td><?= $row['uoi'] ?></td>
                                          <td><?= number_format($row['price'], 0) ?></td>
                                          <td><?= number_format($row['total'], 0) ?></td>
                                          <td><?= $row['keterangan'] ?></td>
                                        </tr>
                                      <?php } ?>
                                      <tr>
                                        <td colspan="6" align="right"><strong>TOTAL</strong></td>
                                        <td><?= number_format($value['total']) ?></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <table style="margin-top: 20px;" class="table table-bordered">
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
                                <table style="margin-top: 20px;" class="table table-bordered">
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
                                <table style="margin-top: 20px;" class="table table-bordered">
                                  <thead>
                                    <tr>
                                      <th>Bukti Serah Terima Barang</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>
                                        <?php if ($value['bukti_serah']) { ?>
                                          <a href="<?= base_url('upload/bukti-serah/') . $value['bukti_serah'] ?>" class="btn btn-success btn-xs" target="_blank">Lihat Bukti Serah Terima Barang</a>
                                        <?php } else { ?>
                                          -
                                        <?php } ?>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                                <?php if ($value['status_sarlog'] == 0) { ?>
                                  <form action="<?= base_url('asset/update_sarlog_out') ?>" method="post" id="update-sarlog-<?= $value['Id'] ?>">
                                    <input type="hidden" name="id_po" id="id_po" value="<?= $value['Id'] ?>">
                                    <div class="row">
                                      <div class="col-md-3 col-sm-6 col-xs-12">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                                      </div>
                                      <div class="col-md-3 col-sm-6 col-xs-12">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-control">
                                          <option value=""> :: Pilih Status ::</option>
                                          <option value="1">Disetujui</option>
                                          <option value="2">Ditolak</option>
                                        </select>
                                      </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6 col-sm-12 col-xs-12">
                                        <label for="catatan" class="form-label">Catatan</label>
                                        <textarea name="catatan" id="catatan" class="form-control"></textarea>
                                      </div>
                                    </div>
                                    <div class="row" style="margin-top: 20px;">
                                      <button type="submit" class="btn btn-primary btn-sm btn-submit">Save</button>
                                    </div>
                                  </form>
                                <?php } ?>
                              </div>
                            </div>
                          </div>
                        </div>

                        <!-- Modal Upload Bukti Serah -->
                        <div class="modal fade" id="uploadBuktiSerah<?= $value['Id'] ?>" role="dialog">
                          <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h2 class="modal-title">Release Order <?= $value['no_ro'] ?></h2>
                              </div>
                              <div class="modal-body">
                                <form action="<?= base_url('asset/update_bukti_serah') ?>" method="post" id="update-bukti-serah-<?= $value['Id'] ?>">
                                  <input type="hidden" name="id_po" id="id_po" value="<?= $value['Id'] ?>">
                                  <div class="row">
                                    <div class="">
                                      <label for="tanggal" class="form-label">Bukti Serah Terima Barang</label>
                                      <input type="file" class="form-control" name="bukti-serah" id="bukti-serah">
                                    </div>
                                  </div>
                                  <div class="row" style="margin-top: 20px;">
                                    <button type="submit" class="btn btn-primary btn-sm btn-submit">Upload</button>
                                  </div>
                                </form>
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