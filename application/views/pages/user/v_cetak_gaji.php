<div class="right_col" role="main">
  <div class="x_panel card">
    <div class="page-title" align="center">
      <font color="brown">Pilih Bulan Gaji</font><br>
      <div class="title_left">
        <h3></h3>
      </div>
    </div>
    <!--?php echo form_open_multipart('app/slip_gaji_pdf', 'class="form-horizontal form-label-left" name="form_input" id="form_input" target="_blank"');?-->
    <?php echo form_open_multipart('app/cari_gaji', 'class="form-horizontal form-label-left" name="form_input" id="form_input" target=""'); ?>
    <div class="row">
      <div class="item form-group">
        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Bulan Gaji <span class="required">*</span></label>
        <div class="col-md-6 col-sm-6 col-xs-12">
          <div class='input-group date' id='myDatepicker2'>
            <input type='text' id='date_pic' name='date_pic' class="form-control" placeholder="yyyy-mm" data-validate-words="1" required="required" />
            <span class="input-group-addon">
              <span class="glyphicon glyphicon-calendar"></span>
            </span>
          </div>
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
          <button class="btn btn-primary" type="button" onclick="window.history.back();">Cancel
          </button>
          <button class="btn btn-primary" type="reset" onclick="reset_form()">Reset
          </button>
          <!--<button type="submit" id="save_project" name="save_project" class="btn btn-success" onclick="return clicked();">Submit</button>-->
          <button name="save_customer" id="btn-submit" type="submit" class="btn btn-success">Search</button><br>
          <!--<input type="submit" value="Save Customer" class="btn btn-success"/><br><br><br>-->
          <?php //echo form_submit('save_customer', 'Save Customer', 'onclick="return clicked();", class="btn btn-success"'); 
          ?>
        </div>
      </div>
    </div>
    </form>

  </div>
  <div class="x_panel card">
    <div class="x_title">
      <p>
        <font size="4"><strong>List Gaji</font></strong>
      </p>
      <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
          <thead>
            <tr class="headings">
              <th class="column-title">No.</th>
              <th class="column-title">Nama</th>
              <th class="column-title">Jabatan</th>
              <th class="column-title">Bulan Gaji</th>
              <th class="column-title">Hari Kerja</th>
              <th class="column-title">Periode</th>
              <th class="column-title">Tidak Hadir</th>
              <th class="column-title">Gaji Net</th>
              <th class="column-title">View</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            if (empty($slip)) { ?>
              <div class="alert alert-info">Tidak ditemukan</div>
              <?php } else {
              foreach ($slip as $data) :
              ?>
                <tr>
                  <td class=" "><?php echo $no; ?></td>
                  <td class=" "><?php echo $data->nama; ?></td>
                  <td class=" "><?php echo $data->jabatan; ?></td>
                  <td class=" "><?php echo date("m-Y", strtotime(date($data->bulan_gaji))); ?></td>
                  <td class=" "><?php echo $data->hari_kerja; ?></td>
                  <td class=" "><?php
                                if (!empty($data->periode_gaji)) {
                                  echo $data->periode_gaji;
                                } ?></td>
                  <td class=" "><?php echo $data->tidak_hadir; ?></td>
                  <td class=" "><?php $number = $data->net_gaji;
                                $nom = number_format($number);
                                echo $nom; ?>.-</td>
                  <td>
                    <a href="<?php echo base_url() . 'app/slip_gaji_pdf/' . $data->Id; ?>" class="alert-success tile-stats" style="text-align: center;" target="_blank">review</a>
                  </td>
                </tr>
            <?php
                $no++;
              endforeach;
            }
            ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <br><br><br><br><br>

  <!-- Table -->
</div>

<script type="text/javascript">
  $("#tujuan").select2({
    placeholder: "Destination",
    allowClear: true
  });

  $('#myDatepicker').datetimepicker({
    format: 'YYYY-MM'
  });
</script>
<script>
  $('#myDatepicker2').datetimepicker({
    format: 'YYYY-MM',
  });

  function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
  }

  //sweet alert
  $('#btn-submit1').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
      title: "Perhatian ?",
      text: "Cetak Slip Gaji !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "iYes!",
      closeOnConfirm: false
    }, function(isConfirm) {
      if (isConfirm) form.submit();
      swal.close();
      //var form  = document.getElementById('form_input');//retrieve the form as a DOM element
      //var input = document.createElement('input');//prepare a new input DOM element
      //input.setAttribute('bulan_gaji_2', 'tes');//set the param name
      //form.appendChild(input);//append the input to the form
      //form.submit();//send with added input
    });
  });
</script>