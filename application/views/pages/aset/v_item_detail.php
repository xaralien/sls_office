<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="x_panel card">
    <div class="x_title">
      <h2>Item Detail <?= $item['nama'] ?></h2>
    </div>
    <div class="x_content">
      <a href="<?= base_url('asset/item_list') ?>" class="btn btn-warning"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal1"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Serial Number</button>
      <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapusItem"><i class="fa fa-trash" aria-hidden="true"></i> Hapus Item</button>

      <div class="row" style="margin-top: 40px;">
        <div class="col-md-6" style="padding: 0; margin:0">
          <form action="">
            <div class="input-group">
              <input type="text" class="form-control" id="search" name="search" placeholder="Cari no purchase order" value="<?= $this->input->get('search') ?>">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i> Search!</button>
              </span>
            </div><!-- /input-group -->
          </form>
        </div>
      </div>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th class="fit">No.</th>
            <th>Kode Item</th>
            <th>Serial Number</th>
            <th>Tanggal Masuk</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($detail->num_rows() > 0) {
            $no = 1;
            foreach ($detail->result_array() as $d) :
          ?>
              <tr>
                <td><?= ++$page; ?></td>
                <td><?= $item['nomor'] ?></td>
                <td><?= $d['serial_number'] ?></td>
                <td><?= tgl_indo($d['tanggal_masuk']) ?></td>
                <td><?= $d['status'] ?></td>
              </tr>
            <?php
            endforeach;
          } else { ?>
            <tr align="center">
              <td colspan="5">Tidak ada data detail</td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="row text-center">
      <?= $pagination ?>
    </div>
  </div>
</div>

<form data-parsley-validate enctype="multipart/form-data" action="<?php echo base_url(); ?>asset/add_detail_item" method="post" name="form-item" id="form-item" class="form-horizontal form-label-left">
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2 class="modal-title">Tambah Detail Item</h2>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id_item" id="id_item" value="<?= $item['Id'] ?>">
          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Kode <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="kode" class="form-control col-md-12 col-xs-12" name="kode" id="kode" placeholder="Masukkan kode item" type="text" value="<?= $item['nomor'] ?>" readonly>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Nama Item <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="kode" class="form-control col-md-12 col-xs-12" name="name" placeholder="Masukkan nama item" type="text" value="<?= $item['nama'] ?>" readonly>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Serial Number Item <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="serial" class="form-control col-md-12 col-xs-12" name="serial" placeholder="Masukkan serial number item" type="text">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Tanggal Masuk<span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="tanggal" class="form-control col-md-12 col-xs-12" name="tanggal" placeholder="Masukkan serial number item" type="date" value="<?= date('Y-m-d') ?>">
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <div>
              <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>


<div class="modal fade" id="hapusItem" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Hapus Item</h2>
      </div>
      <div class="modal-body">
        <form data-parsley-validate enctype="multipart/form-data" action="<?php echo base_url(); ?>asset/hapus_detail_item" method="post" name="form-item" id="form-item" class="form-horizontal form-label-left">
          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Kode <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="kode" class="form-control col-md-12 col-xs-12" name="kode" id="kode" placeholder="Masukkan kode item" type="text" value="<?= $item['nomor'] ?>" readonly>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Nama Item <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="kode" class="form-control col-md-12 col-xs-12" name="name" placeholder="Masukkan nama item" type="text" value="<?= $item['nama'] ?>" readonly>
              </div>
            </div>
          </div>

          <div class="form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align" for="asset">Asset <span class="required">*</span>
            </label>
            <div class="col-md-9 col-sm-9 col-xs-12">
              <select name="asset" id="asset" class="form-control col-md-12 col-xs-12 asset_select2">
                <?php
                $asset = $this->db->get('asset_list')->result_array();

                foreach ($asset as $a) {
                ?>
                  <option value="<?= $a['Id'] ?>"><?= $a['nama_asset'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Serial Number Item <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <select name="serial" id="serial" class="form-control col-md-12 col-xs-12 select2">
                  <?php
                  $sqlSerial = "SELECT * FROM item_detail WHERE kode_item = '$item[Id]' AND (item_detail.status = 'O' OR item_detail.status = 'RO')";
                  $serial = $this->db->query($sqlSerial)->result_array();

                  foreach ($serial as $s) {
                  ?>
                    <option value="<?= $s['Id'] ?>"><?= $s['serial_number'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Tanggal<span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="tanggal" class="form-control col-md-12 col-xs-12" name="tanggal" placeholder="Masukkan serial number item" type="date" value="<?= date('Y-m-d') ?>">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="bukti">Bukti Pemusnahan Barang<span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="bukti" class="form-control col-md-12 col-xs-12" name="bukti" type="file">
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Keterangan<span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <textarea name="keterangan" id="keterangan" class="form-control col-md-12 col-xs-12"></textarea>
              </div>
            </div>
          </div>

          <div class=" modal-footer">
            <div>
              <button type="submit" class="btn btn-primary btn-submit">Simpan</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('.select2').select2({
      width: "100%",
      dropdownParent: $("#hapusItem")
    })

    $('.asset_select2').select2({
      width: "100%",
      dropdownParent: $("#hapusItem")
    })
  })
</script>