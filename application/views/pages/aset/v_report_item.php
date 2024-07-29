<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel card">
        <div class="x_title">
          <h2>Report Item</h2>
        </div>
        <div class="x_content">
          <form action="<?= base_url('asset/export_item') ?>" method="post" target="_blank">
            <div class="row">
              <div class="col-md-4">
                <div class="form">
                  <label for="item">Nama Item</label>
                  <select name="item" id="item" class="form-control select2" required>
                    <option value=""> :: Pilih Item :: </option>
                    <option value="all"> All Item </option>
                    <?php foreach ($item->result_array() as $a) { ?>
                      <option value="<?= $a['Id'] ?>"><?= $a['nama'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form">
                  <label for="asset">Dari</label>
                  <input type="date" class="form-control" name="dari" id="dari" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form">
                  <label for="asset">sampai</label>
                  <input type="date" class="form-control" name="sampai" id="sampai" value="<?= date('Y-m-d') ?>">
                </div>
              </div>
              <div class="col-md-2" style="margin-top: 24px;">
                <button type="submit" class="btn btn-primary">Search</button>
              </div>
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