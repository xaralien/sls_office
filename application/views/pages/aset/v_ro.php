<style>
  .select2-container--default .select2-selection--multiple,
  .select2-container--default .select2-selection--single {
    min-height: 34px;
    height: 34px;
  }

  .padding-0 {
    padding: 0;
  }

  @media screen and (max-width:991px) {
    table#item {
      width: 1200px !important;
      max-width: none !important;
    }

  }
</style>

<!-- page content -->
<div class="right_col" role="main">
  <!--div class="pull-left">
				<font color='Grey'>Create New E-Memo </font>
			</div-->
  <div class="clearfix"></div>

  <!-- Start content-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel card">
        <div class="x_title">
          <h2>Form Release Order</h2>
        </div>
        <div class="x_content">
          <?php if (!$this->uri->segment(3)) { ?>
            <form class="form-horizontal form-label-left input_mask" method="POST" action="<?= base_url('asset/save_release_order') ?>" enctype="multipart/form-data" id="form-po">
              <div class="row" style="margin-bottom: 30px">
                <div class="col-md-3 col-sm-6 col-xs-12 padding-0">
                  <label for="tanggal" class="form-label">Tanggal</label>
                  <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12 padding-0">
                  <label for="teknisi" class="form-label">Nama Teknisi</label>
                  <input type="text" class="form-control" name="teknisi" id="teknisi">
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered" id="item">
                  <div class="items">
                    <tr class="baris-out">
                      <input type="hidden" name="row[]" id="row">
                      <td width="250px">
                        <div class="form-group">
                          <div>
                            <label for="asset" class="form-label">Asset</label>
                          </div>
                          <select name="asset[]" id="asset-0" class="form-control select2">
                            <option value=""> :: Pilih Asset :: </option>
                            <?php
                            $asset = $this->db->get('asset_list')->result_array();
                            foreach ($asset as $row) {
                            ?>
                              <option value="<?= $row['Id'] ?>"><?= $row['nama_asset'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <div>
                            <label for="item" class="form-label">Item</label>
                          </div>
                          <select name="item[]" id="item-0" class="form-control item-out" width="100%">
                            <option value=""> :: Pilih Item :: </option>
                            <?php foreach ($item_list->result_array() as $il) { ?>
                              <option value="<?= $il['Id'] ?>"><?= $il['nama'] ?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </td>
                      <td>
                        <div class="form-group">
                          <div>
                            <label for="uoi" class="form-label">QTY</label>
                          </div>
                          <input type="text" class="form-control uang" name="qty_out[]" id="qty_out-0">
                        </div>
                        <div class="form-group">
                          <div>
                            <label for="uoi" class="form-label">UOI</label>
                          </div>
                          <select name="uoi_out[]" id="uoi" class="form-control">
                            <option value="PCS">PCS</option>
                            <option value="SET">SET</option>
                            <option value="LITER">LITER</option>
                            <option value="TABUNG">TABUNG</option>
                            <option value="DRUM">DRUM</option>
                          </select>
                        </div>
                      </td>
                      <td>
                        <label for="harga_out" class="form-label">Harga</label>
                        <input type="text" class="form-control uang" name="harga_out[]" id="price_out-0" readonly>
                      </td>
                      <td>
                        <label for="total" class="form-label">TOTAL</label>
                        <input type="text" class="form-control uang" name="total_out[]" id="total_out-0" readonly>
                      </td>
                      <td>
                        <label for="ket" class="form-label">Keterangan</label>
                        <textarea name="ket[]" id="ket-0" class="form-control"></textarea>
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger remove-form-out" style="margin-top: 20px;"><i class="fa fa-trash" aria-hidden="true"></i></button>
                      </td>
                    </tr>
                  </div>
                  <tr align="right">
                    <td colspan="3">TOTAL</td>
                    <td>
                      <input type="text" class="form-control" readonly name="nominal" id="nominal">
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="5">
                      <button type="button" class="btn btn-success btn-sm" id="add-more-form-out">Add new row</button>
                    </td>
                  </tr>
                </table>
              </div>
              <div class="row">
                <div class="col-lg-12 text-end padding-0">
                  <a href="<?= base_url('asset/ro_list') ?>" class="btn btn-warning">Back</a>
                  <button type="submit" class="btn btn-primary btn-submit">Save</button>
                </div>
              </div>
            </form>
          <?php } else { ?>
            <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('pengajuan/update/' . $this->uri->segment(3)) ?>" enctype="multipart/form-data" id="form-pengajuan">
              <div class="row" style="margin-bottom: 30px">
                <div class="col-md-2">
                  <label for="tanggal" class="form-label">Tanggal</label>
                  <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d', strtotime($pengajuan['created_at'])); ?>">
                </div>
                <div class="col-md-3">
                  <label for="no_rekening" class="form-label">No. Rekening</label>
                  <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $pengajuan['no_rekening'] ?>">
                </div>
                <div class="col-md-3">
                  <label for="metode" class="form-label">Metode Pembayaran</label>
                  <select name="metode" id="metode" class="form-control">
                    <option value=""> -- Pilih Metode Pembayaran -- </option>
                    <option value="Reimburse" <?= $pengajuan['metode_pembayaran'] == 'Reimburse' ? 'selected' : '' ?>>Reimburse</option>
                    <option value="Transfer" <?= $pengajuan['metode_pembayaran'] == 'Transfer' ? 'selected' : '' ?>>Transfer</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label for="bukti" class="form-label">File Bukti</label>
                  <input type="file" class="form-control" name="bukti" id="bukti">
                  <span>Attacment : <?= $pengajuan['bukti_pengajuan'] ?></span>
                </div>
                <div class="col-md-12">
                  <label for="catatan" class="form-label">Catatan</label>
                  <textarea name="catatan" id="catatan" class="form-control"><?= $pengajuan['catatan'] ?></textarea>
                </div>
              </div>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $detail = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $pengajuan['no_pengajuan']])->result_array();
                  foreach ($detail as $data) {
                  ?>
                    <tr class="baris">
                      <td>
                        <input type="hidden" name="row[]" id="row">
                        <input type="hidden" class="form-control" name="id_item[]" id="id_item" value="<?= $data['Id'] ?>" readonly>
                        <input type="text" class="form-control" name="item[]" id="item" value="<?= $data['item'] ?>">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="qty[]" id="qty" value="<?= $data['qty'] ?>">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="harga[]" id="price" value="<?= number_format($data['price'], 0, ',', '.') ?>">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="total[]" id="total" readonly value="<?= number_format($data['total'], 0, ',', '.') ?>">
                      </td>
                      <td>
                        <!-- <button type="button" class="btn btn-danger" onclick="deleteRow(<?= $data['Id'] ?>)">Hapus</button> -->
                        <button type="button" class="btn btn-danger hapusRow">Hapus</button>
                      </td>
                    </tr>
                  <?php } ?>
                  <tr align="right">
                    <td colspan="3">TOTAL</td>
                    <td>
                      <input type="text" class="form-control" readonly name="nominal" id="nominal">
                    </td>
                    <td></td>
                  </tr>
                  <tr>
                    <td colspan="5">
                      <button type="button" class="btn btn-success btn-sm" id="addRow">Add new row</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="row">
                <div class="col-lg-12 text-end">
                  <a href="<?= base_url('pengajuan/list') ?>" class="btn btn-warning">Back</a>
                  <button type="submit" class="btn btn-primary" id="btn-save">Update</button>
                </div>
              </div>
            </form>
          <?php } ?>
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

    get_detail_item();

    $('#item-0').select2({
      width: '100%'
    });

    $('#detail-item-0').select2({
      width: '100%'
    });

    var rowCountOut = $(".baris-out").length;
    $('#add-more-form-out').click(function() {

      var row = '<tr class="baris-out"><input type="hidden" name="row[]" id="row"><td width="250px"><div class="form-group"><div><label for="asset" class="form-label">Asset</label></div><select name="asset[]" id="asset-' + rowCountOut + '" class="form-control select2"><option value=""> :: Pilih Asset :: </option><?php $asset = $this->db->get('asset_list')->result_array();
                                                                                                                                                                                                                                                                                                                          foreach ($asset as $row) { ?><option value="<?= $row['Id'] ?>"><?= $row['nama_asset'] ?></option><?php } ?></select></div><div class="form-group"><div><label for="item" class="form-label">Item</label></div><select name="item[]" id="item-' + rowCountOut + '" class="form-control item-out" width="100%"><option value=""> :: Pilih Item :: </option><?php foreach ($item_list->result_array() as $il) { ?><option value="<?= $il['Id'] ?>"><?= $il['nama'] ?></option><?php } ?></select></div></td><td><div class="form-group"><div><label for="qty" class="form-label">QTY</label></div><input type="text" class="form-control uang" name="qty_out[]" id="qty_out-' + rowCountOut + '"></div><div class="form-group"><div><label for="uoi" class="form-label">UOI</label></div><select name="uoi_out[]" id="uoi-' + rowCountOut + '" class="form-control"><option value="PCS">PCS</option><option value="SET">SET</option><option value="LITER">LITER</option><option value="TABUNG">TABUNG</option><option value="DRUM">DRUM</option></select></div></td><td><label for="harga_out" class="form-label">Harga</label><input type="text" class="form-control uang" name="harga_out[]" id="price_out-' + rowCountOut + '" readonly></td> <td> <label for="total" class="form-label">TOTAL</label><input type="text" class="form-control uang" name="total_out[]" id="total_out-' + rowCountOut + '" readonly></td><td><label for="ket" class="form-label">Keterangan</label><textarea name="ket[]" id="ket-' + rowCountOut + '" class="form-control"></textarea></td><td><button type="button" class="btn btn-danger remove-form-out" style="margin-top: 20px;"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';

      var previousRow = $('.baris-out').last();
      rowCountOut++;
      previousRow.after(row);

      $.each($(".select2"), function(index, value) {
        $('#asset-' + index).select2({
          width: '100%'
        });

        $('#item-' + index).select2({
          width: '100%'
        });

        $('#detail-item-' + index).select2({
          width: '100%'
        });
      });

      get_detail_item()
    });

    $(document).on("click", ".remove-form-out", function() {
      rowCountOut--;
      $(this).parents(".baris-out").remove();
      updateTotalItem();
    });
  })
</script>

<script>
  function count_item_out() {
    const item_out = document.querySelectorAll('.item-out');
    return item_out;
  }

  function get_detail_item() {
    $.each($(".item-out"), function(index, value) {
      $('#item-' + index).change(function() {
        $('#qty-' + index).attr('readonly', false);
        var id = $(this).val();
        $('#qty-' + index).val(0)
        $.ajax({
          url: "<?= base_url('asset/getItemById/') ?>",
          type: "POST",
          chace: false,
          data: {
            id: id,
          },
          dataType: "JSON",
          success: function(res) {
            var qty = $('#qty_out-' + index).val().replace(/\./g, "");
            var price = res.harga;
            qty = parseInt(qty);
            price = parseInt(price);
            qty = isNaN(qty) ? 0 : qty;
            price = isNaN(price) ? 0 : price;
            var total = qty * price;
            if (res.option) {
              // $('#select-detail-' + index).show();
              $('#detail-item-' + index).html(res.option)
              $('#price_out-' + index).val(formatNumber(convertToComa(res.harga)))
              $('#total_out-' + index).val(formatNumber(convertToComa(total)));
            } else {
              // $('#select-detail-' + index).hide();
              $('#price_out-' + index).val(formatNumber(convertToComa(res.harga)))
              $('#total_out-' + index).val(formatNumber(convertToComa(total)));
            }
            updateTotalItemOut();
          }
        })
      });

      $('#detail-item-' + index).change(function() {
        var count = $(this).select2('data').length;
        var price = $('#price_out-' + index).val().replace(/\./g, "");
        var total = parseInt(count) * parseInt(price);

        $('#qty_out-' + index).val(parseInt(count));
        $('#total_out-' + index).val(formatNumber(convertToComa(total)));
        $('#qty_out-' + index).attr('readonly', true);
        updateTotalItemOut();
      })
    })
  }

  function convertToComa(number) {
    return number.toString().replace('.', ",");
  }
</script>
<!-- Finish content-->