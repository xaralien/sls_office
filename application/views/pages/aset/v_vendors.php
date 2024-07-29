<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel card">
        <div class="x_title">
          <h2>List Vendors</h2>
        </div>
        <div class="x_content">
          <div class="row">
            <a href="<?= base_url('asset/add_vendor') ?>" class="btn btn-primary">Tambah Vendor</a>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Vendor</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">Email</th>
                  <th scope="col">No. Telpon</th>
                  <th scope="col">#</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($vendors->num_rows() < 1) { ?>
                  <tr align="center">
                    <td colspan="6">Tidak ada data</td>
                  </tr>
                  <?php } else {
                  $no = 1;
                  foreach ($vendors->result_array() as $value) {  ?>
                    <tr>
                      <td scope="row"><?= $no++; ?></td>
                      <td scope="row"><?= $value['nama'] ?></td>
                      <td scope="row"><?= $value['alamat'] ?></td>
                      <td scope="row"><?= $value['email'] ?></td>
                      <td scope="row"><?= $value['no_telpon'] ?></td>
                      </td>
                      <td scope="row">
                        <a href="<?= base_url('asset/ubah_vendor/' . $value['Id']) ?>" class="btn btn-success btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
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
  </div>
</div>