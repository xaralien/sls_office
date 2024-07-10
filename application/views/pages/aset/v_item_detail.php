<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel card">
        <div class="x_title">
          <h2>Item Detail <?= $item['nama'] ?></h2>
        </div>
        <div class="x_content">
          <a href="<?= base_url('asset/item_list') ?>" class="btn btn-warning"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal1"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Item</button>
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
                    <td><?= $no++; ?></td>
                    <td><?= $item['nomor'] ?></td>
                    <td><?= $d['serial_number'] ?></td>
                    <td><?= $d['tanggal_masuk'] ?></td>
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
      </div>
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
                <input id="tanggal" class="form-control col-md-12 col-xs-12" name="tanggal" placeholder="Masukkan serial number item" type="date">
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