<div class="right_col" role="main">

  <div class="x_panel card">
    <div class="page-title" align="center">
      <font color="brown">Upload Gaji (Monthly)</font><br>
      <div class="title_left">
        <h3></h3>
      </div>
    </div>

    <div class="row">
      <form method="POST" id="form_input" name="form_input" action="<?php echo base_url() ?>app/upload_gaji" enctype="multipart/form-data">
        <!--div class="form-group">
						<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Bulan Gaji <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class='input-group date' id='myDatepicker'>
								<input type='text' id='bulan_gaji' name='bulan_gaji' class="form-control" placeholder="yyyy-mm" data-validate-words="1" required="required"/>
								<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div-->
        <div class="col-md-12 col-sm-12 col-xs-12">
          <?php echo $this->session->flashdata('notif') ?>
          <div class="form-group">
            <label for="exampleInputEmail1">UNGGAH FILE EXCEL</label>
            <input type="file" accept=".xlsx,application/msexcel" name="userfile" class="form-control">
          </div>
          <!--button type="submit" class="btn btn-success">UPLOAD</button-->
          <button name="btn-submit" id="btn-submit" type="button" class="btn btn-success">Upload</button><br>
        </div>
      </form>
    </div>

  </div>

  <div class="x_panel card">
    <div class="page-title" align="center">
      <font color="brown">Upload Gaji (Daily)</font><br>
      <div class="title_left">
        <h3></h3>
      </div>
    </div>

    <div class="row">
      <form method="POST" id="form_input2" name="form_input2" action="<?php echo base_url() ?>app/upload_gaji2" enctype="multipart/form-data">
        <!--div class="form-group">
						<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Bulan Gaji <span class="required">*</span></label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class='input-group date' id='myDatepicker'>
								<input type='text' id='bulan_gaji' name='bulan_gaji' class="form-control" placeholder="yyyy-mm" data-validate-words="1" required="required"/>
								<span class="input-group-addon">
								<span class="glyphicon glyphicon-calendar"></span>
								</span>
							</div>
						</div>
					</div-->
        <div class="col-md-12 col-sm-12 col-xs-12">
          <?php echo $this->session->flashdata('notif2') ?>
          <div class="form-group">
            <label for="exampleInputEmail1">UNGGAH FILE EXCEL</label>
            <input type="file" accept=".xlsx,application/msexcel" name="userfile" class="form-control">
          </div>
          <!--button type="submit" class="btn btn-success">UPLOAD</button-->
          <button name="btn-submit2" id="btn-submit2" type="button" class="btn btn-success">Upload</button><br>
        </div>
      </form>
    </div>

  </div>

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
  function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
  }

  //sweet alert
  $('#btn-submit').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
      title: "Perhatian ?",
      text: "Data gaji akan diupload !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, Upload!",
      closeOnConfirm: false
    }, function(isConfirm) {
      if (isConfirm) form.submit();
      //var form  = document.getElementById('form_input');//retrieve the form as a DOM element
      //var input = document.createElement('input');//prepare a new input DOM element
      //input.setAttribute('bulan_gaji_2', 'tes');//set the param name
      //form.appendChild(input);//append the input to the form
      //form.submit();//send with added input
    });
  });
  $('#btn-submit2').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
      title: "Perhatian ?",
      text: "Data gaji akan diupload !",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, Upload!",
      closeOnConfirm: false
    }, function(isConfirm) {
      if (isConfirm) form.submit();
    });
  });
</script>