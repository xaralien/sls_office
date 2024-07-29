<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="x_panel card">
    <div class="x_title">
      <h2>List Purchase Order</h2>
    </div>
    <div class="x_content">
      <div class="row">
        <div class="col-md-3 sol-sm-6 col-xs-12" style="padding: 0 !important; margin: 0 !important">
          <a href="<?= base_url('asset/po_list') ?>" class="btn btn-warning">Back</a>
          <div class="panel panel-default">
            <div class="panel-heading">Total Hutang Vendor</div>
            <div class="panel-body">
              <?php
              $jml_hutang = 0;
              foreach ($hutang as $h) {
                if ($h['ppn'] == 1) {
                  $total = $h['total'] + ($h['total'] * 0.11);
                } else {
                  $total = $h['total'];
                }

                $jml_hutang += $total;
              } ?>
              <p style="font-weight: bolder; font-size: 20px"><?= "Rp." . number_format($jml_hutang) ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6" style="padding: 0 !important; margin: 0 !important">
          <form action="">
            <div class="input-group">
              <input type="text" class="form-control" id="search" name="search" placeholder="Cari no purchase order" value="<?= $this->input->get('search') ?>">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Search!</button>
              </span>
            </div><!-- /input-group -->
          </form>
        </div>
        <div class="col-md-6" style="padding: 0 !important; margin: 0 !important">
          <form method="get" id="form-filter">
            <!-- <label for="filter" class="form-label">Filter berdasarkan</label> -->
            <select name="vendor" id="vendor" class="form-control">
              <option value="">:: Pilih vendor</option>
              <?php
              $vendor = $this->db->get('t_vendors')->result_array();
              foreach ($vendor as $v) {
              ?>
                <option value="<?= $v['Id'] ?>" <?= $this->input->get('vendor') == $v['Id'] ? 'selected' : '' ?>><?= $v['nama'] ?></option>
              <?php } ?>
            </select>
          </form>
        </div>
      </div>
      <div class="table-responsive" style="margin-top: 20px;">
        <table class="table table-bordered">
          <thead>
            <tr>
              <th scope="col">No.</th>
              <th scope="col">User</th>
              <th scope="col">Vendor</th>
              <th scope="col">Tanggal</th>
              <th scope="col">Status Pembayaran</th>
              <th scope="col">Status Sarlog</th>
              <th scope="col">Posisi</th>
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
                $vendor = $this->db->get_where('t_vendors', ['Id' => $value['vendor']])->row_array();
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
                  <td scope="row"><?= $vendor['nama'] ?></td>
                  <td scope="row"><?= tgl_indo(date('Y-m-d', strtotime($value['tgl_pengajuan']))) ?></td>
                  <td scope="row"><?= $value['status_pembayaran'] == 0 ? 'Belum bayar' : 'Sudah bayar' ?></td>
                  <td scope="row" style="color: <?= $color ?>;"><?= $status ?></td>
                  <td scope="row"><?= $value['posisi'] ?></td>
                  <td scope="row"><?= $value['jenis_pembayaran'] ?></td>
                  </td>
                  <td scope="row">
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#myModal<?= $value['Id'] ?>">View</button>
                    <a href="<?= base_url('asset/print/' . $value['Id']) ?>" class="btn btn-primary btn-sm" target="_blank">Print</a>
                    <?php if ($value['status_dirut'] == 1 && $value['posisi'] == 'disetujui untuk diproses') { ?>
                      <a href="<?= base_url('asset/process/' . $value['Id']) ?>" class="btn btn-success btn-sm">Process</a>
                      <a href="<?= base_url('asset/revisi/' . $value['Id']) ?>" class="btn btn-danger btn-sm">Revisi</a>
                    <?php } ?>
                    <?php if ($value['status_pembayaran'] == 0 && $value['status_dirut'] == 1 && $value['jenis_pembayaran'] == 'hutang') { ?>
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
                            <div class="table-responsive">
                              <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th>No.</th>
                                    <th>Item</th>
                                    <th>Qty</th>
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
                                      <td><?= number_format($row['price'], 0) ?></td>
                                      <td><?= number_format($row['total'], 0) ?></td>
                                      <td><?= $row['keterangan'] ?></td>
                                    </tr>
                                  <?php } ?>
                                  <tr>
                                    <td colspan="4" align="right"><strong>SUB TOTAL</strong></td>
                                    <td><?= number_format($value['total']) ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="4" align="right"><strong>PPN 11%</strong></td>
                                    <td>
                                      <?php if ($value['ppn']) {
                                        $ppn = $value['total'] * 0.11;
                                      } else {
                                        $ppn = 0;
                                      } ?>

                                      <?= number_format($ppn) ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td colspan="4" align="right"><strong>TOTAL</strong></td>
                                    <td><?= number_format($value['total'] + $ppn) ?></td>
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
                                  <td><?= $value['catatan_sarlog'] ? $value['catatan_sarlog'] : 'Tidak ada catatan' ?></td>
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
                                  <td><?= $value['catatan_direksi_ops'] ? $value['catatan_direksi_ops'] : 'Tidak ada catatan' ?></td>
                                </tr>
                              </tbody>
                            </table>
                            <table style="margin-top: 20px;" class="table table-bordered">
                              <thead>
                                <tr>
                                  <th>Catatan Direktur Utama</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><?= $value['catatan_dirut'] ? $value['catatan_dirut'] : 'Tidak ada catatan' ?></td>
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
                                      <option value="2">Revisi</option>
                                      <option value="3">Ditolak</option>
                                    </select>
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col-md-6">
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
<script>
  $(document).ready(function() {
    $("#status").change(function() {
      var value = $(this).val();
      if (value == 3) {
        $('.btn-submit').removeClass('btn-primary')
        $('.btn-submit').addClass('btn-danger')
        $('.btn-submit').html('Reject')
      } else if (value == 2) {
        $('.btn-submit').removeClass('btn-primary')
        $('.btn-submit').addClass('btn-danger')
        $('.btn-submit').html('Revisi')
      } else {
        $('.btn-submit').removeClass('btn-danger')
        $('.btn-submit').addClass('btn-primary')
        $('.btn-submit').html('Approve')
      }
    })

    $("select[name='vendor']").change(function() {
      $("form[id='form-filter']").submit();
    })
  })
</script>