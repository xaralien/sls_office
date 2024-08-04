<style>
  .btn-file {
    position: relative;
    overflow: hidden;
  }

  .btn-file input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
  }

  #img-upload {
    width: 100%;
  }

  .col-xs-3 {
    width: 25%;
    background-color: #008080;
  }

  .row {
    margin-left: 0px;
  }

  .container-fluid {
    padding-right: 0px;
    padding-left: 0px
  }

  .btn_footer_panel .tag_ {
    padding-top: 37px;
  }

  body {}
</style>
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Change Password
        </h3>
      </div>
    </div>
    <div class="clearfix">
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Input Password
              <small>Please fill below
              </small>
            </h2>
            <ul class="nav navbar-right panel_toolbox">
              <li>
                <a class="collapse-link">
                  <i class="fa fa-chevron-up">
                  </i>
                </a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                  <i class="fa fa-wrench">
                  </i>
                </a>
                <ul class="dropdown-menu" role="menu">
                  <li>
                    <a href="#">Settings 1
                    </a>
                  </li>
                  <li>
                    <a href="#">Settings 2
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <a class="close-link">
                  <i class="fa fa-close">
                  </i>
                </a>
              </li>
            </ul>
            <div class="clearfix">
            </div>
          </div>
          <!--<div class="x_content">
                           <br/>
							<?php //echo form_open_multipart('upload_ktp/do_upload', 'class="form-horizontal form-label-left"');
              ?>
							 <div class="form-group">
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identity">Identity Numbers 
                                 <span class="required">*
                                 </span>
                                 </label>
                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="identity" name="identity" required="required" class="form-control col-md-7 col-xs-12">
                                 </div>
                              </div>
							 <div class="form-group">
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12" for="identity_file">Upload File Identity 
                                 <span class="required">*
                                 </span>
                                 </label>
                                 <div class="col-md-6 col-sm-6 col-xs-12">
                                   <input type="file" name="userfile" class="form-control col-md-7 col-xs-12"/>
									<input type="submit" value="Upload" class="btn btn-primary"/>
                                 </div>
                              </div>
							</form> 
						</div> -->

          <div class="x_content">
            <br />
            <?php echo form_open_multipart('login/ubah_password', 'class="form-horizontal form-label-left" name="form_input" id="form_input"'); ?>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer_name">Old Password
                <span class="required">*
                </span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="password" name="password_old" id="password_old" required="required" class="form-control col-md-7 col-xs-12" data-validate-length-range="1" data-validate-words="1">
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer_name">New Password
                <span class="required">*
                </span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="password" name="password_new" id="password_new" required="required" class="form-control col-md-7 col-xs-12" data-validate-length-range="1" data-validate-words="1">
              </div>
            </div>
            <div class="item form-group">
              <label class="control-label col-md-3 col-sm-3 col-xs-12" for="customer_name">verified Password
                <span class="required">*
                </span>
              </label>
              <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="password" name="password_v" id="password_v" required="required" class="form-control col-md-7 col-xs-12" data-validate-length-range="1" data-validate-words="1">
              </div>
            </div>

            <div class="ln_solid">
            </div>
            <div class="form-group">
              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <button class="btn btn-primary" type="button" onclick="window.location.href='<?php echo base_url(); ?>home';">Cancel
                </button>
                <button class="btn btn-primary" type="reset" onclick="reset_form()">Reset
                </button>
                <!--<button type="submit" id="save_project" name="save_project" class="btn btn-success" onclick="return clicked();">Submit</button>-->
                <button name="save_password" id="btn-submit" type="submit" class="btn btn-success">Save</button><br><br><br>
                <!--<input type="submit" value="Save Customer" class="btn btn-success"/><br><br><br>-->
                <?php //echo form_submit('save_customer', 'Save Customer', 'onclick="return clicked();", class="btn btn-success"'); 
                ?>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    // Format mata uang.
    $('.uang').mask('000.000.000', {
      reverse: true
    });
  })
</script>
<script>
  $('#myDatepicker').datetimepicker();
  $('#myDatepicker2').datetimepicker({
    format: 'YYYY-MM-DD'
  });
  $('#myDatepicker3').datetimepicker({
    format: 'hh:mm A'
  });
  $('#myDatepicker4').datetimepicker({
    ignoreReadonly: true,
    allowInputToggle: true
  });
  $('#datetimepicker6').datetimepicker();
  $('#datetimepicker7').datetimepicker({
    useCurrent: false
  });
  $("#datetimepicker6").on("dp.change", function(e) {
    $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
  });
  $("#datetimepicker7").on("dp.change", function(e) {
    $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
  });
  //currency
  $("input[data-type='currency']").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() {
      formatCurrency($(this), "blur");
    }
  });

  function clicked() {
    return confirm('Are you sure to save new Customer?');
  }

  function reset_form() {
    document.getElementById("form_input").reset();
  }

  function formatNumber(n) {
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
  }

  function formatCurrency(input, blur) {
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.
    // get input value
    var input_val = input.val();
    // don't validate empty input
    if (input_val === "") {
      return;
    }
    // original length
    var original_len = input_val.length;
    // initial caret position 
    var caret_pos = input.prop("selectionStart");
    // check for decimal
    if (input_val.indexOf(".") >= 0) {
      // get position of first decimal
      // this prevents multiple decimals from
      // being entered
      var decimal_pos = input_val.indexOf(".");
      // split number by decimal point
      var left_side = input_val.substring(0, decimal_pos);
      var right_side = input_val.substring(decimal_pos);
      // add commas to left side of number
      left_side = formatNumber(left_side);
      // validate right side
      right_side = formatNumber(right_side);
      // On blur make sure 2 numbers after decimal
      if (blur === "blur") {
        right_side += "00";
      }
      // Limit decimal to only 2 digits
      right_side = right_side.substring(0, 2);
      // join number by .
      input_val = "Rp " + left_side + "." + right_side;
    } else {
      // no decimal entered
      // add commas to number
      // remove all non-digits
      input_val = formatNumber(input_val);
      input_val = "Rp " + input_val;
      // final formatting
      if (blur === "blur") {
        input_val += ".00";
      }
    }
    // send updated string to input
    input.val(input_val);
    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
  }
</script>
<script>
  $(document).ready(function() {
    $(document).on('change', '.btn-file :file', function() {
      var input = $(this),
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
      input.trigger('fileselect', [label]);
    });

    $('.btn-file :file').on('fileselect', function(event, label) {

      var input = $(this).parents('.input-group').find(':text'),
        log = label;

      if (input.length) {
        input.val(log);
      } else {
        if (log) alert(log);
      }

    });

    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#img-upload').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#imgInp").change(function() {
      readURL(this);
    });
  });

  //sweet alert
  $('#btn-submit').on('click', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    swal({
      title: "Are you sure?",
      text: "Password wil be save!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, save it!",
      closeOnConfirm: false
    }, function(isConfirm) {
      if (isConfirm) form.submit();
    });
  });
</script>