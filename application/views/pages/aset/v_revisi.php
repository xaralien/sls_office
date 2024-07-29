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
          <form action="<?= base_url('asset/update_revisi') ?>" method="post" enctype="multipart/form-data" id="update-process">
            <input type="hidden" name="id_po" id="id_po" value="<?= $po['Id'] ?>">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th style="width: 250px">Item</th>
                    <th>Qty</th>
                    <th style="width: 80px">Satuan</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $item = $this->cb->get_where('t_po_detail', ['no_po' => $po['Id']])->result_array();
                  foreach ($item as $i) {
                    $detail = $this->db->get_where('item_list', ['Id' => $i['item']])->row_array();
                  ?>
                    <tr class="baris">
                      <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                      <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                      <td><?= $detail['nama'] ?></td>
                      <td>
                        <input type="text" name="qty[]" id="qty" class="form-control uang" value="<?= $i['qty'] ?>">
                        <div class="form-group">
                          <label for="uoi" class="form-label">UOI</label>
                          <select name="uoi[]" id="uoi" class="form-control">
                            <option value="PCS" <?= $i['uoi'] == 'PCS' ? 'selected' : '' ?>>PCS</option>
                            <option value="SET" <?= $i['uoi'] == 'SET' ? 'selected' : '' ?>>SET</option>
                            <option value="LITER" <?= $i['uoi'] == 'LITER' ? 'selected' : '' ?>>LITER</option>
                            <option value="TABUNG" <?= $i['uoi'] == 'TABUNG' ? 'selected' : '' ?>>TABUNG</option>
                            <option value="DRUM" <?= $i['uoi'] == 'DRUM' ? 'selected' : '' ?>>DRUM</option>
                          </select>
                        </div>
                      </td>
                      <td>
                        <input type="text" class="form-control uang" name="satuan[]" id="satuan" value="<?= $i['satuan'] ?>">
                      </td>
                      <td>
                        <input type="text" name="harga[]" id="harga" class="form-control uang" value="<?= number_format($i['price']) ?>">
                      </td>
                      <td>
                        <input type="text" name="total[]" id="total" class="form-control uang" value="<?= number_format($i['total']) ?>" readonly>
                      </td>
                      <td>
                        <textarea name="ket[]" id="ket" class="form-control"><?= $i['keterangan'] ?></textarea>
                      </td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td colspan="4"><b>Total</b></td>
                    <td>
                      <input type="text" name="nominal" id="nominal" class="form-control uang" readonly>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row">
              <a href="<?= base_url('asset/sarlog') ?>" class="btn btn-warning">Back</a>
              <?php if ($po['posisi'] != 'Sudah Dibayar' && $po['posisi'] != 'Hutang') { ?>
                <button class="btn btn-primary btn-submit" type="submit">Revisi</button>
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