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
          <form action="<?= base_url('asset/update_bayar') ?>" method="post" enctype="multipart/form-data" id="update-bayar">
            <input type="hidden" name="id_po" id="id_po" value="<?= $po['Id'] ?>">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>UOI</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Total</th>
                    <th width="300px">Ket</th>
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
                      <td><?= $detail['nama'] . ' | ' . $detail['nomor'] ?></td>
                      <td><?= $i['qty'] ?></td>
                      <td><?= $i['uoi'] ?></td>
                      <td><?= $i['satuan'] ?></td>
                      <td><?= number_format($i['price']) ?></td>
                      <td><?= number_format($i['total']) ?></td>
                      <td><?= $i['keterangan'] ?></td>
                    </tr>
                  <?php } ?>
                  <tr>
                    <td align="right" colspan="5"><b>SUB TOTAL</b></td>
                    <td><?= number_format($po['total']) ?></td>
                  </tr>
                  <tr>
                    <td align="right" colspan="5"><b>PPN 11%</b></td>
                    <td>
                      <?php if ($po['ppn']) {
                        $ppn = $po['total'] * 0.11;
                      } else {
                        $ppn = 0;
                      } ?>

                      <?= number_format($ppn) ?>
                    </td>
                  </tr>
                  <tr>
                    <td align="right" colspan="5"><b>TOTAL</b></td>
                    <td>
                      <?php
                      $total = $po['total'] + $ppn;
                      ?>
                      <?= number_format($total) ?>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="tanggal" class="form-label">Tanggal</label>
                  <?php if ($po['status_pembayaran'] == 1) { ?>
                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d', strtotime($po['date_bayar'])) ?>" disabled>
                  <?php } else { ?>
                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="coa-kas" class="form-label">COA Kas</label>
                  <select name="coa-kas" id="coa-kas" class="form-control select2">
                    <option value=""> :: PILIH COA KAS :: </option>
                    <?php foreach ($coa->result_array() as $row) { ?>
                      <option value="<?= $row['no_sbb'] ?>"><?= $row['no_sbb'] . ' - ' . $row['nama_perkiraan'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="file" class="form-label">Bukti Bayar</label>
                  <input type="file" class="form-control" name="bukti-bayar" id="bukti-bayar">
                  <?php if ($po['posisi'] == 'Sudah Dibayar') { ?>
                    <span><?= $po['bukti_bayar'] ?></span>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div class="row">
              <a href="<?= base_url('asset/sarlog') ?>" class="btn btn-warning">Back</a>
              <?php if ($po['status_pembayaran'] == 0) { ?>
                <button class="btn btn-primary btn-submit" type="submit">Bayar</button>
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
    $('.select2').select2({
      width: "100%"
    })
  })
</script>