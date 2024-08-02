<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel card">
        <div class="x_title">
          <h2>Detail Purchase Order <?= $po['no_po'] ?></h2>
        </div>
        <div class="x_content">
          <form action="<?= base_url('asset/update_process') ?>" method="post" enctype="multipart/form-data" id="update-process">
            <input type="hidden" name="id_po" id="id_po" value="<?= $po['Id'] ?>">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>COA Persediaan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $item = $this->cb->get_where('t_po_detail', ['no_po' => $po['Id']])->result_array();
                  foreach ($item as $i) {
                    $detail = $this->db->get_where('item_list', ['Id' => $i['item']])->row_array();
                  ?>
                    <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                    <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                    <tr>
                      <td><?= $detail['nama'] ?></td>
                      <td><?= $i['qty'] ?></td>
                      <td><?= number_format($i['price']) ?></td>
                      <td><?= number_format($i['total']) ?></td>
                      <td>
                        <?php if ($po['posisi'] == 'Sudah Dibayar' || $po['posisi'] == "Hutang") { ?>
                          <select name="coa_debit[]" id="coa_debit<?= $i['Id'] ?>" class="form-control select2" style="width: 100%;" disabled>
                            <?php foreach ($coa->result_array() as $row) { ?>
                              <option value="<?= $row['no_sbb'] ?>" <?= $row['no_sbb'] == $i['debit'] ? 'selected' : '' ?>><?= $row['no_sbb'] . ' - ' . $row['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>
                        <?php } else { ?>
                          <select name="coa_debit[]" id="coa_debit<?= $i['Id'] ?>" class="form-control select2" style="width: 100%;">
                            <option value=""> -- Pilih COA Persediaan -- </option>
                            <?php foreach ($coa->result_array() as $cd) { ?>
                              <option value="<?= $cd['no_sbb'] ?>"><?= $cd['no_sbb'] . ' - ' . $cd['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>
                          <div style="margin: 5px 0;"></div>
                          <input type="text" class="form-control" name="anggaran_debit[]" id="anggaran_debit<?= $i['Id'] ?>" readonly>
                        <?php } ?>
                      </td>
                    </tr>
                    <script>
                      $(document).ready(function() {
                        $('#coa_debit<?= $i['Id'] ?>').select2({
                          width: "100%"
                        })
                        $('#coa_debit<?= $i['Id'] ?>').change(function() {
                          var id = $(this).val();
                          $.ajax({
                            url: '<?= base_url('asset/getDataCoa/') ?>' + id,
                            method: 'GET',
                            dataType: 'JSON',
                            success: function(res) {
                              if (res.anggaran) {
                                $('#anggaran_debit<?= $i['Id'] ?>').val(formatNumber(res.nominal));
                              } else {
                                $('#anggaran_debit<?= $i['Id'] ?>').val(0);
                              }
                            }
                          })
                        })
                      })
                    </script>
                  <?php } ?>
                  <tr>
                    <td colspan="3"><b>Total</b></td>
                    <td colspan="3"><?= number_format($po['total']) ?></td>
                  </tr>
                  <tr>
                    <td colspan="3"><b>Terbilang</b></td>
                    <td colspan="3"><?= terbilang($po['total']) ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="tanggal" class="form-label">Tanggal</label>
                  <?php if ($po['posisi'] == 'Sudah Dibayar' || $po['posisi'] == "Hutang") { ?>
                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d', strtotime($po['date_proses'])) ?>" disabled>
                  <?php } else { ?>
                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                  <?php } ?>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="jenis-pembayaran" class="form-label">Jenis Pembayaran</label>
                  <?php if ($po['posisi'] == 'Sudah Dibayar' || $po['posisi'] == "Hutang") { ?>
                    <select name="jenis-pembayaran" id="jenis-pembayaran" class="form-control" disabled>
                      <option value=""> :: Pilih Jenis Pembayaran :: </option>
                      <option value="kas" <?= $po['jenis_pembayaran'] == 'kas' ? 'selected' : '' ?>>Kas</option>
                      <option value="hutang" <?= $po['jenis_pembayaran'] == 'hutang' ? 'selected' : '' ?>>Hutang</option>
                    </select>
                  <?php } else { ?>
                    <select name="jenis-pembayaran" id="jenis-pembayaran" class="form-control">
                      <option value=""> :: Pilih Jenis Pembayaran :: </option>
                      <option value="kas">Kas</option>
                      <option value="hutang">Hutang</option>
                    </select>
                  <?php } ?>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="coa-kredit" class="form-label">COA Kredit</label>
                  <?php if ($po['posisi'] == 'Sudah Dibayar' || $po['posisi'] == "Hutang") { ?>
                    <select name="coa-kredit" id="coa-kredit" class="form-control" disabled>
                      <option value=""> :: Pilih COA :: </option>
                      <?php foreach ($coa->result_array() as $row) { ?>
                        <option value="<?= $row['no_sbb'] ?>" <?= $row['no_sbb'] == $i['kredit'] ? 'selected' : '' ?>><?= $row['no_sbb'] . ' - ' . $row['nama_perkiraan'] ?></option>
                      <?php } ?>
                    </select>
                  <?php } else { ?>
                    <select name="coa-kredit" id="coa-kredit" class="form-control">
                      <option value=""> :: Pilih COA :: </option>
                      <?php foreach ($coa->result_array() as $row) { ?>
                        <option value="<?= $row['no_sbb'] ?>"><?= $row['no_sbb'] . ' - ' . $row['nama_perkiraan'] ?></option>
                      <?php } ?>
                    </select>
                  <?php } ?>
                </div>
              </div>
              <div class="col-md-6 col-sm-12 col-xs-12" id="upload-bayar">
                <div class="form-group">
                  <label for="file" class="form-label">Bukti Bayar</label>
                  <input type="file" class="form-control" name="bukti-bayar" id="bukti-bayar">
                  <?php if ($po['posisi'] == 'Sudah Dibayar') { ?>
                    <span><?= $po['bukti_bayar'] ?></span>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="row" style="margin-bottom: 30px;">
              <?php if ($po['posisi'] == 'Sudah Dibayar' || $po['posisi'] == "Hutang") { ?>
                <div class="col-md-6">
                  <label for="ppn" class="form-label">PPN 11%</label>
                  <input type="checkbox" class="icheckbox_flat-green" style="margin-left: 0px;" name="opsi_ppn" id="opsi_ppn" value="1" checked readonly>
                </div>
              <?php } else { ?>
                <div class="col-md-6">
                  <label for="ppn" class="form-label">PPN 11%</label>
                  <input type="checkbox" class="icheckbox_flat-green" style="margin-left: 0px;" name="opsi_ppn" id="opsi_ppn" value="1">
                </div>
              <?php } ?>

            </div>
            <div class="row">
              <a href="<?= base_url('asset/sarlog') ?>" class="btn btn-warning">Back</a>
              <?php if ($po['posisi'] != 'Sudah Dibayar' && $po['posisi'] != 'Hutang') { ?>
                <button class="btn btn-primary btn-submit" type="submit">Process</button>
              <?php } ?>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#coa-kredit').select2({
      width: "100%"
    })
  })
</script>