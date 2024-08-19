<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel card">
        <div class="x_title">
          <h2>Ubah Data Item <?= $item['nama'] ?></h2>
        </div>
        <div class="x_content">
          <div class="row">
            <form action="<?= base_url('asset/update_item/' . $item['Id']) ?>" method="post">
              <div class="col-md-6 col-sm-12 col-xs-12">
                <div class="form-group">
                  <label for="kode">Kode Item</label>
                  <input type="text" class="form-control" name="kode" id="kode" value="<?= $item['nomor'] ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="nama">Nama Item</label>
                  <input type="text" class="form-control" name="nama" id="nama" value="<?= $item['nama'] ?>">
                </div>
                <div class="form-group">
                  <label for="stok">Stok</label>
                  <input type="text" class="form-control" name="stok" id="stok" value="<?= $item['stok'] ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="harga">Harga Satuan</label>
                  <input type="text" class="form-control" name="harga" id="harga" value="<?= number_format($item['harga_sat']) ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="jenis">Jenis Item</label>
                  <select name="jenis" id="jenis" class="form-control select2">
                    <option value="">:: Pilih jenis item ::</option>
                    <?php foreach ($jenis_item->result_array() as $j) : ?>
                      <option value="<?= $j['Id'] ?>" <?= $j['Id'] == $item['jenis_item'] ? 'selected' : '' ?>><?= $j['nama_jenis'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="coa">Coa Item</label>
                  <select name="coa" id="coa" class="form-control select2">
                    <option value="">:: Pilih coa item ::</option>
                    <?php foreach ($coa as $c) : ?>
                      <option value="<?= $c['no_sbb'] ?>" <?= $c['no_sbb'] == $item['coa'] ? 'selected' : '' ?>><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                    <?php endforeach ?>
                  </select>
                </div>
                <div class="row">
                  <a href="<?= base_url('asset/item_list') ?>" class="btn btn-warning"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
                  <button class="btn btn-primary btn-submit" type="submit"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    var selects = document.querySelectorAll('.select2');
    for (let index = 0; index < selects.length; index++) {
      $("#" + selects[index].id + "").select2({
        width: "100%"
      })
    }
  })
</script>