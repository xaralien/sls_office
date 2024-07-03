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
          <h2>Preorder Item</h2>
        </div>
        <div class="x_content">
          <?php if (!$this->uri->segment(3)) { ?>
            <form class="form-horizontal form-label-left input_mask" method="POST" action="<?= base_url('asset/save_po') ?>" enctype="multipart/form-data" id="form-preorder">
              <div class="row" style="margin-bottom: 30px">
                <div class="col-md-2">
                  <label for="tanggal" class="form-label">Tanggal</label>
                  <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="col-md-3">
                  <label for="tanggal" class="form-label">Vendor</label>
                  <select name="vendor" id="vendor" class="form-control">
                    <option value="">:: Pilih Vendor</option>
                    <?php foreach ($vendors->result_array() as $v) { ?>
                      <option value="<?= $v['Id'] ?>"><?= $v['nama'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-7">
                  <label for="keterangan" class="form-label">Keterangan</label>
                  <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                </div>
              </div>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Item</th>
                    <th style="width: 80px">Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>#</th>
                  </tr>
                </thead>
                <tbody>
                  <div class="items">
                    <tr class="baris">
                      <td>
                        <input type="hidden" name="row[]" id="row">
                        <select name="item[]" id="item-0" class="form-control select2" width="100%">
                          <option value=""> :: Pilih Item :: </option>
                          <?php foreach ($item_list->result_array() as $il) { ?>
                            <option value="<?= $il['Id'] ?>"><?= $il['nama'] . " | " . $il['nomor'] ?></option>
                          <?php } ?>
                        </select>
                      </td>
                      <td>
                        <input type="text" class="form-control uang" name="qty[]" id="qty">
                      </td>
                      <td>
                        <input type="text" class="form-control uang" name="harga[]" id="price">
                      </td>
                      <td>
                        <input type="text" class="form-control" name="total[]" id="total" readonly>
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger hapusRow">Hapus</button>
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
                      <button type="button" class="btn btn-success btn-sm" id="add-more-form">Add new row</button>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="row">
                <div class="col-lg-12 text-end">
                  <a href="<?= base_url('asset/po_list') ?>" class="btn btn-warning">Back</a>
                  <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                </div>
              </div>
            </form>
          <?php } else { ?>
            <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('pengajuan/update/' . $this->uri->segment(3)) ?>" enctype="multipart/form-data" id="form-pengajuan">
              <div class="row" style="margin-bottom: 30px">
                <div class="col-md-2">
                  <label for="tanggal" class="form-label">Tangal</label>
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

<!-- Finish content-->