<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel card">
        <div class="x_title">
          <h2>List Item Repair</h2>
        </div>
        <div class="x_content">
          <div class="row">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal1"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Item</button>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Item</th>
                  <th scope="col">Serial Number</th>
                  <th scope="col">Keterangan</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($list_repair->num_rows() < 1) { ?>
                  <tr align="center">
                    <td colspan="7">Tidak ada data</td>
                  </tr>
                  <?php } else {
                  $no = 1;
                  foreach ($list_repair->result_array() as $value) {
                    $item = $this->db->get_where('item_list', ['Id' => $value['item']])->row_array();
                    $item_detail = $this->db->get_where('item_detail', ['Id' => $value['serial_number']])->row_array();
                    $user = $this->db->get_where('users', ['nip' => $value['user']])->row_array();
                  ?>
                    <tr>
                      <td scope="row"><?= $no++ ?></td>
                      <td scope="row"><?= $value['tgl_pengajuan'] ?></td>
                      <td scope="row"><?= $item['nama'] ?></td>
                      <td scope="row"><?= $item_detail['serial_number'] ?></td>
                      <td scope="row"><?= $value['keterangan'] ?></td>
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

<form data-parsley-validate enctype="multipart/form-data" action="<?php echo base_url(); ?>asset/add_repair" method="post" name="form-item" id="form-item" class="form-horizontal form-label-left">
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2 class="modal-title">Tambah Item Repair</h2>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="form-group">
              <label for="tanggal" class="form-label">Tanggal</label>
              <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
            </div>
            <div class="form-group">
              <label for="item" class="form-label">Item</label>
              <select name="item" id="item" class="form-control select2">
                <option value=""> :: Pilih Item :: </option>
                <?php foreach ($item_list as $il) { ?>
                  <option value="<?= $il['Id'] ?>"><?= $il['nama'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="serial-number" class="form-label">Serial Number</label>
              <select name="serial-number" id="serial-number" class="form-control select2">
                <option value=""> :: Pilih Serial Number :: </option>
              </select>
            </div>
            <div class="form-group">
              <label for="keterangan" class="form-label">Keterangan</label>
              <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
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
</form>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      width: "100%"
    })

    $('select[name="item"]').change(function() {
      var value = $(this).val();
      $.ajax({
        url: "<?= base_url('asset/getSerialNumber') ?>",
        type: "POST",
        chace: false,
        data: {
          id: value,
        },
        dataType: "JSON",
        success: function(res) {
          $('select[name="serial-number"]').html(res)
        }
      })
    })
  })
</script>