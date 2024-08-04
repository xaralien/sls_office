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