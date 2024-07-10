<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel card">
        <div class="x_title">
          <h2>List Purchase Order</h2>
        </div>
        <div class="x_content">
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">User</th>
                  <th scope="col">Vendor</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Status Pembayaran</th>
                  <th scope="col">Status Sarlog</th>
                  <th scope="col">Pembayaran</th>
                  <th scope="col">#</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($po->num_rows() < 1) { ?>
                  <tr align="center">
                    <td colspan="7">Belum ada data</td>
                  </tr>
                  <?php } else {
                  foreach ($po->result_array() as $value) {
                    $user = $this->db->get_where('users', ['nip' => $value['user']])->row_array();
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
                      <td scope="row"><?= $value['no_po'] ?></td>
                      <td scope="row"><?= $user['nama'] ?></td>
                      <td scope="row"><?= $value['nama'] ?></td>
                      <td scope="row"><?= $value['tgl_pengajuan'] ?></td>
                      <td scope="row"><?= $value['status_pembayaran'] == 0 ? 'Belum bayar' : 'Sudah bayar' ?></td>
                      <td scope="row" style="color: <?= $color ?>;"><?= $status ?></td>
                      <td scope="row"><?= $value['jenis_pembayaran'] ?></td>
                      </td>
                      <td scope="row">
                        <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal<?= $value['Id'] ?>">View</button>
                        <?php if ($value['status_direksi'] == 1 && $value['posisi'] == 'diarahkan ke pembayaran') { ?>
                          <a href="<?= base_url('asset/process/' . $value['Id']) ?>" class="btn btn-success btn-sm">Process</a>
                        <?php } ?>
                        <?php if ($value['status_pembayaran'] == 0 && $value['status_direksi'] == 1 && $value['jenis_pembayaran'] == 'hutang') { ?>
                          <a href="<?= base_url('asset/bayar/' . $value['Id']) ?>" class="btn btn-success btn-sm">Bayar</a>
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
                                      <th>No.</th>
                                      <th>Item</th>
                                      <th>Qty</th>
                                      <th>Price</th>
                                      <th>Total</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $detail = $this->cb->get_where('t_po_detail', ['no_po' => $value['no_po']])->result_array();
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
                                      </tr>
                                    <?php } ?>
                                    <tr>
                                      <td colspan="4" align="right"><strong>TOTAL</strong></td>
                                      <td><?= number_format($value['total']) ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                                <table style="margin-top: 20px;" class="table table-bordered">
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
                                <?php if ($value['status_sarlog'] == 0) { ?>
                                  <form action="<?= base_url('asset/update_sarlog') ?>" method="post" id="update-sarlog-<?= $value['Id'] ?>">
                                    <input type="hidden" name="id_po" id="id_po" value="<?= $value['Id'] ?>">
                                    <div class="row">
                                      <div class="col-md-3">
                                        <label for="tanggal" class="form-label">Tanggal</label>
                                        <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                                      </div>
                                      <div class="col-md-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" id="status" class="form-control">
                                          <option value=""> :: Pilih Status ::</option>
                                          <option value="1">Disetujui</option>
                                          <option value="2">Ditolak</option>
                                        </select>
                                      </div>
                                      <div class="col-md-6" id="select-direksi">
                                        <label for="direksi" class="form-label">Direksi</label>
                                        <select name="direksi" id="direksi" class="form-control">
                                          <option value=""> :: Pilih Direksi ::</option>
                                          <?php foreach ($direksi as $d) { ?>
                                            <option value="<?= $d['nip'] ?>"><?= $d['nama'] ?></option>
                                          <?php } ?>
                                        </select>
                                      </div>
                                      <div class="col-md-12">
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