<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel card">
        <div class="x_title">
          <h2>Detail Permintaan Barang <?= $po['no_po'] ?></h2>
        </div>
        <div class="x_content">
          <a href="<?= base_url('asset/sarlog_out') ?>" class="btn btn-warning">Back</a>
          <form action="<?= base_url('asset/update_serahItem') ?>" method="post" enctype="multipart/form-data" id="update-bayar">
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
                    <th>COA Beban</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $item = $this->cb->get_where('t_po_out_detail', ['no_po' => $po['Id']])->result_array();
                  foreach ($item as $key => $i) {
                    $detail = $this->db->get_where('item_list', ['Id' => $i['item']])->row_array();
                    $this->db->where(['kode_item' => $detail['Id'], 'status' => 'A']);
                    $this->db->order_by('tanggal_masuk', 'ASC');
                    // $this->db->limit($i['qty']);
                    $item_detail = $this->db->get('item_detail')->result_array();
                  ?>
                    <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                    <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                    <tr>
                      <td>
                        <?= $detail['nama'] . ' | ' . $detail['nomor'] ?>
                        <div style="margin-top: 10px;" class="row">
                          <label for="label" class="form-label" class="form-label">Select Detail</label>
                          <select name="detail_item[<?= $key ?>][]" id="detail-item-<?= $i['Id'] ?>" class="form-control" multiple>
                            <?php if (!$item_detail) { ?>
                              <option value="0" selected>Tidak Ada Serial Number</option>
                            <?php } ?>
                            <?php foreach ($item_detail as $id) { ?>
                              <option value="<?= $id['Id'] ?>"><?= $id['serial_number'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </td>
                      <td><?= $i['qty'] ?></td>
                      <td><?= number_format($i['price']) ?></td>
                      <td><?= number_format($i['total']) ?></td>
                      <td>
                        <?php if ($po['posisi'] == 'Barang sudah diserahkan!') { ?>
                          <select name="coa_persediaan[]" id="coa_persediaan<?= $i['Id'] ?>" class="form-control select2" style="width: 100%;" disabled>
                            <?php foreach ($coa->result_array() as $row) { ?>
                              <option value="<?= $row['no_sbb'] ?>" <?= $row['no_sbb'] == $i['persediaan'] ? 'selected' : '' ?>><?= $row['no_sbb'] . ' - ' . $row['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>
                        <?php } else { ?>
                          <select name="coa_persediaan[]" id="coa_persediaan<?= $i['Id'] ?>" class="form-control select2" style="width: 100%;">
                            <option value=""> -- Pilih COA Persediaan -- </option>
                            <?php foreach ($coa->result_array() as $cp) { ?>
                              <option value="<?= $cp['no_sbb'] ?>"><?= $cp['no_sbb'] . ' - ' . $cp['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>
                          <div style="margin: 5px 0;"></div>
                          <input type="text" class="form-control" name="anggaran_persediaan[]" id="anggaran_persediaan<?= $i['Id'] ?>" readonly>
                        <?php } ?>
                      </td>
                      <td>
                        <?php if ($po['posisi'] == 'Barang sudah diserahkan!') { ?>
                          <select name="coa_beban[]" id="coa_beban<?= $i['Id'] ?>" class="form-control select2" style="width: 100%;" disabled>
                            <?php foreach ($coa->result_array() as $row) { ?>
                              <option value="<?= $row['no_sbb'] ?>" <?= $row['no_sbb'] == $i['beban'] ? 'selected' : '' ?>><?= $row['no_sbb'] . ' - ' . $row['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>
                        <?php } else { ?>
                          <select name="coa_beban[]" id="coa_beban<?= $i['Id'] ?>" class="form-control select2" style="width: 100%;">
                            <option value=""> -- Pilih COA Beban -- </option>
                            <?php foreach ($coa->result_array() as $cb) { ?>
                              <option value="<?= $cb['no_sbb'] ?>"><?= $cb['no_sbb'] . ' - ' . $cb['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>
                          <div style="margin: 5px 0;"></div>
                          <input type="text" class="form-control" name="anggaran_beban[]" id="anggaran_beban<?= $i['Id'] ?>" readonly>
                        <?php } ?>
                      </td>
                    </tr>
                    <script>
                      $(document).ready(function() {
                        $('#detail-item-<?= $i['Id'] ?>, #coa_beban<?= $i['Id'] ?>, #coa_persediaan<?= $i['Id'] ?>').select2({
                          width: "100%"
                        })
                        $('#coa_beban<?= $i['Id'] ?>').change(function() {
                          var id = $(this).val();
                          $.ajax({
                            url: '<?= base_url('asset/getDataCoa/') ?>' + id,
                            method: 'GET',
                            dataType: 'JSON',
                            success: function(res) {
                              if (res.anggaran) {
                                $('#anggaran_beban<?= $i['Id'] ?>').val(formatNumber(res.nominal));
                              } else {
                                $('#anggaran_beban<?= $i['Id'] ?>').val(0);
                              }
                            }
                          })
                        })

                        $('#coa_persediaan<?= $i['Id'] ?>').change(function() {
                          var id = $(this).val();
                          $.ajax({
                            url: '<?= base_url('asset/getDataCoa/') ?>' + id,
                            method: 'GET',
                            dataType: 'JSON',
                            success: function(res) {
                              if (res.anggaran) {
                                $('#anggaran_persediaan<?= $i['Id'] ?>').val(formatNumber(res.nominal));
                              } else {
                                $('#anggaran_persediaan<?= $i['Id'] ?>').val(0);
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
            <?php if ($po['posisi'] != 'Barang sudah diserahkan!') { ?>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <?php if ($po['posisi'] == 'Sudah Dibayar') { ?>
                      <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d', strtotime($po['date_bayar'])) ?>" disabled>
                    <?php } else { ?>
                      <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                    <?php } ?>
                  </div>
                </div>
                <!-- <div class="col-md-6">
                  <div class="form-group">
                    <label for="file" class="form-label">Bukti Serah</label>
                    <input type="file" class="form-control" name="bukti-serah" id="bukti-serah">
                    <?php if ($po['posisi'] == 'Barang sudah diserahkan!') { ?>
                      <span><?= $po['bukti_serah'] ?></span>
                    <?php } ?>
                  </div>
                </div> -->
              </div>
              <div class="row">
                <?php if ($po['posisi'] != 'Barang sudah diserahkan') { ?>
                  <button class="btn btn-danger" type="reset">Reset</button>
                  <button class="btn btn-primary btn-submit" type="submit">Serahkan</button>
                <?php } ?>
              </div>
            <?php } ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>