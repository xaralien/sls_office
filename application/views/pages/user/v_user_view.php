<style>
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

  table,
  th,
  td {
    border: 0px solid black;
  }

  table.center {
    margin-left: auto;
    margin-right: auto;
  }

  .button1 {
    background-color: #4CAF50;
  }

  table,
  table {
    border-collapse: separate;
    border-spacing: 0 1em;
  }

  /* Green */
</style>
<div class="right_col" role="main">
  <div class="clearfix"></div>

  <div class="x_panel card">
    <strong>
      <font style="color:blue;font-size:24px;">BANDES</font>
      <font style="color:green;font-size:24px;">LOGISTIK</font>
    </strong></br>
    <font style="font-size:17px;">PT. Bangun Desa Logistindo</font></br></br>

    <div align="center">
      <font style="font-size:17px;">
        <?php if ($this->uri->segment(4) == 'e') {
          echo 'User Edit';
        } else {
          echo 'User View';
        } ?>
        <hr />
      </font>
    </div>
    <font style="font-size:14px;">
      <?php if ($this->uri->segment(4) != 'e' && $this->uri->segment(3) == true) { ?>
        </br>
        <table>
          <tr>
            <th width="200">Usernamee</th>
            <td>: <?= $user->username ?></td>
          </tr>
          <tr>
            <th>Nama</th>
            <td>: <?= $user->nama ?></td>

          </tr>
          <tr>
            <th>Level</th>
            <td>: <?= $user->level ?></td>
          </tr>
          <tr>
            <th>Status</th>
            <td>:<?php if ($user->status == 1) { ?>
              <span style="cursor: default;" class="btn btn-primary">Active</span>
            <?php } else { ?>
              <span style="cursor: default;" class="btn btn-danger">Not Active</span>
            <?php } ?>
            </td>
          </tr>
          <tr>
            <th>Email</th>
            <td>: <?= $user->email ?></td>
          </tr>
          <tr>
            <th>Phone</th>
            <td>: <?= $user->phone ?></td>
          </tr>
          <tr>
            <th>Code Agent</th>
            <td>: <?= $user->kd_agent ?></td>
          </tr>
          <tr>
            <th>Nip</th>
            <td>: <?= $user->nip ?></td>
          </tr>
          <tr>
            <th>Level</th>
            <td>: <?= $user->level_jabatan ?></td>
          </tr>
          <tr>
            <th>Bagian</th>
            <td>: <?= $user->bagian ?></td>
          </tr>
          <tr>
            <th>TMT</th>
            <td>: <?= date('d F Y', strtotime($user->tmt)) ?></td>
          </tr>
          <tr>
            <th>Cuti Reguler</th>
            <td>: <?= $user->cuti ?></td>
          </tr>
          <tr>
            <th>Nama Jabatan</th>
            <td>: <?= $user->nama_jabatan ?></td>
          </tr>

          <tr>
            <th>Supervisi</th>
            <td>:
              <?php
              if ($user->supervisi != null || $user->supervisi != "") {
                $sv = $this->db->get_where('users', ['nip' => $user->supervisi])->row();
                echo $sv->nama_jabatan;
              } else {
                echo "";
              }
              // if ($user->level_jabatan < 3 && $user->bagian != null) {
              // 	$sv = $this->db->get_where('users', [
              // 		'bagian' => $user->bagian,
              // 		'level_jabatan' => 3
              // 	])->row();
              // 	echo $sv->nama_jabatan;
              // } else {
              // 	echo "";
              // }

              // if ($user->level_jabatan >= 3) {
              // 	$sv = $this->db->get_where('users', [
              // 		'nip' => $user->supervisi
              // 	])->row();
              // 	echo $sv->nama_jabatan;
              // }
              ?>
            </td>
          </tr>
          <tr>
            <th><a href="<?= base_url('app/user') ?>" class="btn btn-warning"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></th>
          </tr>
        </table>
        <br>
      <?php } elseif ($this->uri->segment(3) == false) { ?> <!-- add user -->
        <?= $this->session->flashdata('msg') ?>
        <form action="<?= base_url('app/add_user') ?>" method="POST">
          <input type="hidden" value="add" name="add">
          <input type="hidden" value="<?= $this->uri->segment('3') ?>" name="id">
          <table>
            <tr>
              <th width="300">Username</th>
              <td width="300"> <input type="text" value="<?php echo set_value('username'); ?>" name="username" class="form-control"></td>
            </tr>
            <tr>
              <th width="300">Password</th>
              <td width="300"> <input type="text" name="password" class="form-control"></td>
            </tr>
            <tr>
              <th width="300">Password Confirmation</th>
              <td width="300"> <input type="text" name="password_confirmation" class="form-control"></td>
            </tr>
            <tr>
              <th width="200">Name</th>
              <td> <input type="text" name="nama" class="form-control">
              </td>
            </tr>
            <tr>
              <th width="200">Date of birth</th>
              <td>
                <div class='input-group date' id='myDatepicker2'>
                  <input type='text' id='date_pic' name='tgl_lahir' class="form-control" placeholder="yyyy-mm-dd" data-validate-words="1" required="required" />
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </td>
            </tr>
            <tr>
              <th width="200">Level</th>
              <td>
                <select class="form-control js-example-basic-multiple" name="level[]" multiple="multiple">
                  <?php
                  $level_x = explode(',', $user->level);
                  $x = $this->db->get('menu')->result();
                  foreach ($x as $k) {
                    // foreach($level_x as $o) {
                    if (strpos($user->level, $k->level) !== false) {
                  ?>
                      <option selected="selected" value="<?= $k->level ?>"><?= $k->nama ?>
                      </option>
                    <?php } else { ?>
                      <option value="<?= $k->level ?>"><?= $k->nama ?></option>

                  <?php }
                    //}
                  } ?>
                </select>
              </td>
            </tr>

            <tr>
              <th>Status</th>
              <td>
                <input name="status" value="1" type="radio" id="active">
                <label for="active">Active</label>
                <input name="status" value="0" type="radio" id="noactive">
                <label for="noactive">Not Active</label>
              </td>
            </tr>
            <tr>
              <th width="200">Email</th>
              <td> <input type="text" name="email" class="form-control"></td>
            </tr>
            <tr>
              <th>Phone</th>
              <td><input type="text" name="phone" class="form-control"></td>
            </tr>
            <tr>
              <th>Code Agent</th>
              <td><input type="text" name="kd_agent" class="form-control"></td>
            </tr>
            <tr>
              <th>Nip</th>
              <td><input type="text" name="nip" class="form-control"></td>
            </tr>
            <tr>
              <th>Level Jabatan</th>
              <td>
                <select name="level_jabatan" id="" class="form-control">
                  <option value="">Pilih Jabatan</option>
                  <option value="1">Staff</option>
                  <option value="2">Supervisor</option>
                  <option value="3">Manajer</option>
                  <option value="4">General Manajer</option>
                  <option value="5">Direktur</option>
                  <option value="6">Direktur Utama</option>

                </select>
              </td>
            </tr>
            <tr>
              <th>Bagian</th>
              <td>
                <select name="bagian" class="form-control" id="">
                  <?php $xx = $this->db->get('bagian')->result();
                  foreach ($xx as $k) {
                    if (!empty($user)) {
                  ?>
                      <option <?= $k->Id == $user->bagian ? 'selected' : '' ?> value="<?= $k->Id ?>"><?= $k->nama ?></option>
                    <?php } else { ?>
                      <option value="<?= $k->Id ?>"><?= $k->nama ?></option>
                  <?php }
                  } ?>
                </select>
              </td>
            </tr>
            <tr>
              <th>Nama Jabatan</th>
              <td><input type="text" name="nama_jabatan" class="form-control"></td>
            </tr>
            <tr>
              <th>Supervisi</th>
              <td>
                <select name="supervisi" id="" class="form-control js-example-basic-multiple">
                  <?php
                  $supervisi = $this->db->get_where('users', ['level_jabatan >=' => 3])->result();
                  foreach ($supervisi as $data) { ?>
                    <option value="<?= $data->nip ?>"><?= $data->nama_jabatan ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <th>TMT</th>
              <td>
                <div class='input-group date' id='myDatepicker2'>
                  <input type='text' name='tmt' class="form-control" placeholder="yyyy-mm-dd" data-validate-words="1" required="required" />
                  <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                  </span>
                </div>
              </td>
            </tr>
            <tr>
              <th>Cuti Reguler</th>
              <td><input type="number" name="cuti" class="form-control"></td>
            </tr>
            <tr>
              <th>
                <a class="btn btn-warning" href="<?= base_url('app/user') ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
              </th>
              <td><button type="submit" class="btn btn-primary">Submit</button></td>
            </tr>
          </table>
        </form>
      <?php  } else if ($this->uri->segment(4) == 'e') { ?>
        </br>
        <?= $this->session->flashdata('msg') ?>
        <form action="<?= base_url('app/user_edit/' . $this->uri->segment('3')) ?>" method="POST">
          <input type="hidden" value="edit" name="edit">
          <input type="hidden" value="<?= $this->uri->segment('3') ?>" name="id">
          <table>
            <tr>
              <th width="300">Username</th>
              <td width="300"> <input readonly type="text" name="username" class="form-control" value="<?= $user->username ?>"></td>
            </tr>
            <tr>
              <th width="200">Name</th>
              <td> <input type="text" name="nama" class="form-control" value="<?= $user->nama ?>">
              </td>
            </tr>
            <tr>
              <th width="200">Level</th>
              <td width="100%">
                <select class="form-control js-example-basic-multiple" name="level[]" multiple="multiple">
                  <?php
                  $level_x = explode(',', $user->level);
                  $x = $this->db->get('menu')->result();
                  foreach ($x as $k) {
                    // foreach($level_x as $o) {
                    if (strpos($user->level, $k->level) !== false) {
                  ?>
                      <option selected="selected" value="<?= $k->level ?>"><?= $k->nama ?>
                      </option>
                    <?php } else { ?>
                      <option value="<?= $k->level ?>"><?= $k->nama ?></option>

                  <?php }
                    //}
                  } ?>
                </select>
              </td>
            </tr>

            <tr>
              <th>Status</th>
              <td>
                <input <?= $user->status ? 'checked' : '' ?> name="status" type="radio" value="1" id="active">
                <label for="active">Active</label>
                <input <?= $user->status ? '' : 'checked' ?> name="status" type="radio" value="0" id="noactive">
                <label for="noactive">Not Active</label>
              </td>
            </tr>
            <tr>
              <th width="200">Email</th>
              <td> <input type="text" name="email" class="form-control" value="<?= $user->email ?>"></td>
            </tr>
            <tr>
              <th>Phone</th>
              <td><input type="text" name="phone" class="form-control" value="<?= $user->phone ?>"></td>
            </tr>
            <tr>
              <th>Code Agent</th>
              <td><input type="text" name="kd_agent" class="form-control" value="<?= $user->kd_agent ?>"></td>
            </tr>
            <tr>
              <th>Nip</th>
              <td><input readonly type="text" name="nip" class="form-control" value="<?= $user->nip ?>"></td>
            </tr>
            <tr>
              <th>Level Jabatan</th>
              <td><input type="text" name="level_jabatan" class="form-control" value="<?= $user->level_jabatan ?>"></td>
            </tr>
            <tr>
              <th>TMT</th>
              <td><input type="date" name="tmt" class="form-control" value="<?= $user->tmt ?>"></td>
            </tr>
            <tr>
              <th>Bagian</th>
              <td>
                <select name="bagian" class="form-control js-example-basic-multiple" id="">
                  <option value=""> -- Pilih Bagian --</option>
                  <?php $xx = $this->db->get('bagian')->result();
                  foreach ($xx as $k) { ?>
                    <option <?= $k->Id == $user->bagian ? 'selected' : '' ?> value="<?= $k->Id ?>"><?= $k->nama ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <th>Nama Jabatan</th>
              <td><input type="text" name="nama_jabatan" class="form-control" value="<?= $user->nama_jabatan ?>"></td>
            </tr>
            <tr>
              <th>Supervisi</th>
              <td>
                <select name="supervisi" class="form-control js-example-basic-multiple">
                  <option value=""> -- Pilih Supervisi --</option>
                  <?php
                  $supervisi = $this->db->get_where('users', ['level_jabatan >=' => 3])->result();
                  foreach ($supervisi as $data) {
                    if ($user->supervisi != null || $user->supervisi != "") {
                      $super_visi = $this->db->get_where('users', ['nip' => $user->supervisi])->row();
                      $selected = $super_visi->nip == $data->nip ? "selected" : "";
                    } else {
                      $selected = "";
                    }
                  ?>
                    <option <?= $selected ?> value="<?= $data->nip ?>"><?= $data->nama_jabatan ?></option>
                  <?php } ?>
                </select>
              </td>
            </tr>
            <tr>
              <th>Cuti</th>
              <td>
                <input type="number" name="cuti" class="form-control" value="<?= $user->cuti ?>">
              </td>
            </tr>
            <tr>
              <th>
                <a class="btn btn-warning" href="<?= base_url('app/user') ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                <button type="submit" class="btn btn-primary">Update</button>
              </th>
            </tr>
          </table>
        </form>
        <br>
      <?php } ?>
    </font>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('select.js-example-basic-multiple').select2();
    $('div#myDatepicker2').datetimepicker({
      format: 'YYYY-MM-DD',
      maxDate: Date.now() + 90000000
    });
  });

  window.setTimeout(function() {
    $(".alert-success").fadeTo(500, 0).slideUp(500, function() {
      $(this).remove();
    });
  }, 3000);

  window.setTimeout(function() {
    $(".alert-danger").fadeTo(500, 0).slideUp(500, function() {
      $(this).remove();
    });
  }, 3000);
</script>