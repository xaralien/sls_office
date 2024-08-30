<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel card">
        <div class="x_title">
          <?php if ($this->uri->segment(2) == 'ubah_vendor') { ?>
            <h2>Ubah Data Vendor <?= $vendor['nama'] ?></h2>
          <?php } ?>

          <?php if ($this->uri->segment(2) == 'add_vendor') { ?>
            <h2>Tambah Data Vendor</h2>
          <?php } ?>
        </div>
        <div class="x_content">
          <div class="row">
            <?php if ($this->uri->segment(2) == 'ubah_vendor') { ?>
              <form action="<?= base_url('asset/update_vendor/' . $vendor['Id']) ?>" method="post">
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label for="nama">Nama Vendor</label>
                    <input type="text" class="form-control" name="nama" id="nama" value="<?= $vendor['nama'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="nama">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control"><?= $vendor['alamat'] ?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="nama">Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="<?= $vendor['email'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="nama">No. Telpon</label>
                    <input type="text" class="form-control" name="tlp" id="tlp" value="<?= $vendor['no_telpon'] ?>">
                  </div>
                  <div class="form-group">
                    <label for="nama">Kode Vendor</label>
                    <input type="text" class="form-control" name="kode" id="kode" value="<?= $vendor['kode'] ?>">
                  </div>
                  <div class="row">
                    <a href="<?= base_url('asset/vendors') ?>" class="btn btn-warning"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
                    <button class="btn btn-primary btn-submit" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                  </div>
                </div>
              </form>
            <?php } else { ?>
              <form action="<?= base_url('asset/insert_vendor') ?>" method="post">
                <div class="col-md-6 col-sm-12 col-xs-12">
                  <div class="form-group">
                    <label for="nama">Nama Vendor</label>
                    <input type="text" class="form-control" name="nama" id="nama">
                  </div>
                  <div class="form-group">
                    <label for="nama">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="nama">Email</label>
                    <input type="text" class="form-control" name="email" id="email">
                  </div>
                  <div class="form-group">
                    <label for="nama">No. Telpon</label>
                    <input type="text" class="form-control" name="tlp" id="tlp">
                  </div>
                  <div class="form-group">
                    <label for="nama">Kode Vendor</label>
                    <input type="text" class="form-control" name="kode" id="kode">
                  </div>
                  <div class="row">
                    <a href="<?= base_url('asset/vendors') ?>" class="btn btn-warning"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
                    <button class="btn btn-primary btn-submit" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                  </div>
                </div>
              </form>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>