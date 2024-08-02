<div class="right_col" role="main">
  <div class="clearfix"></div>

  <div class="x_panel">
    <div class="x_title">
      <h2>
        <button class="btn btn-success collapse-link" type="button">Image</button>
        <a href="<?= base_url('app/asset_list') ?>" class="btn btn-success">Go Back</a>
        <!--button class="btn btn-primary" type="button" onclick="window.location.href='<?php echo base_url(); ?>home';">Lihat Surat Kuasa</button-->
        <br>
        <!--small>Silahkan isi form dibawah &raquo;</small-->
      </h2>
      <div class="clearfix">
      </div>
    </div>

    <div class="x_content collapse" style="width:100%;">
      <br />
      <img src="<?= base_url('upload/asset/' . $asset_list->pic) ?>" alt="">
      <!-- <?php echo "<img src='upload/asset/" . $asset_list->pic . "'>"; ?> -->
    </div>
  </div>

  <div class="x_panel">
    <div class="x_title">
      <h2>Asset Detail <small> Dataset</small></h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <br />
      <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
        <div class="">
          <table class="" width="100%">
            <tr>
              <td class="fitwidth">
                <label class="" for="first-name">Kode Asset <span class="required">*</span>
                </label>
              </td>
              <td>
                <?php echo $asset_list->kode; ?>
              </td class="fitwidth">
              <td rowspan="6" class="fitwidth qr-code">
                <div class="polaroid">
                  <img src="<?php echo base_url(); ?>app/qrcode_view/<?php echo $asset_list->Id; ?>" alt="5 Terre" style="width:100%">
                </div>
              </td>
            <tr>
              <td class="fitwidth">
                <label class="" for="last-name">Nama Asset <span class="required">*</span>
                </label>
              </td>
              <td class="fitwidth"><?php echo $asset_list->nama_asset; ?></td>
            </tr>
            <tr>
              <td class="fitwidth">
                <label for="middle-name" class="">Spesifikasi</label>
              </td>
              <td class="fitwidth">
                <?php echo $asset_list->spesifikasi; ?>
              </td>
            </tr>
            <tr>
              <td class="fitwidth">
                <label for="middle-name" class="">Lokasi</label>
              </td>
              <td class="fitwidth">
                <?php echo $asset_list->lokasi; ?>
              </td>
            </tr>
            <tr>
              <td class="fitwidth">
                <label for="middle-name" class="">Ruangan</label>
              </td>
              <td class="fitwidth">
                <?php echo $asset_list->ruangan; ?>
              </td>
            </tr>
            <tr>
              <td class="fitwidth">
                <label class="">
                  Tanggal Perolehan <span class="required">*</span>
                </label>
              </td>
              <td class="fitwidth">
                <?php $tgl = $asset_list->tgl_perolehan;
                echo $newDate = date("d F Y", strtotime($tgl)); ?>
              </td>
            </tr>
            <tr>
              <td class="fitwidth">
                <label class="">
                  Update Terakhir <span class="required">*</span>
                </label>
              </td>
              <td class="fitwidth">
                <?php $date = $asset_list->last_update;
                echo $newDate = date("d F Y", strtotime($date)); ?>
              </td>
            </tr>
            <tr>
              <td class="fitwidth">
                <label class="">
                  Kondisi <span class="required">*</span>
                </label>
              </td>
              <td class="fitwidth">
                <?php
                if ($asset_list->kondisi == 1) {
                  echo "Baik";
                } elseif ($asset_list->kondisi == 2) {
                  echo "Rusak";
                } elseif ($asset_list->kondisi == 3) {
                  echo "Dalam Perbaikan";
                } else {
                  echo "";
                }
                ?>
              </td>
            </tr>
          </table>

          <div class="item form-group">
            <div class="">
              <!--button class="btn btn-primary" type="button">Cancel</button>
										<button class="btn btn-primary" type="reset">Reset</button-->
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal1">Update</button>
              <a href="<?= base_url('asset/report_item/') . $this->uri->segment(3) ?>" class="btn btn-success" target="_blank">Pemakaian Item</a>
            </div>
          </div>
          <!--div class="ln_solid"></div-->

        </div>
      </form>
    </div>
    <div class="x_panel">
      <div class="x_title">
        <h2>Asset History <small> Movement</small></h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th bgcolor="#008080">
                  <font color="white">No.</font>
                </th>
                <th bgcolor="#008080">
                  <font color="white">Kode</font>
                </th>
                <th bgcolor="#008080">
                  <font color="white">Ruangan</font>
                </th>
                <th bgcolor="#008080">
                  <font color="white">Lokasi</font>
                </th>
                <th bgcolor="#008080">
                  <font color="white">Tanggal</font>
                </th>
                <th bgcolor="#008080">
                  <font color="white">Remarks</font>
                </th>
              </tr>
            </thead>
            <?php
            $no = 1;
            foreach ($asset_history as $data) :
            ?>
              <!--content here-->
              <tbody>
                <tr>
                  <td><?php echo $no; ?></td>
                  <td><?php echo $data->kode; ?></td>
                  <td><?php echo $data->ruangan; ?></td>
                  <td><?php echo $data->lokasi; ?></td>
                  <td><?php echo $data->tanggal; ?></td>
                  <td><?php echo $data->remark; ?></td>
                </tr>
              </tbody>

            <?php
              $no++;
            endforeach;
            ?>
          </table>
        </div>

      </div>
    </div>
  </div>


  <!-- Table -->
</div>


<!-- /page content -->
<form data-parsley-validate enctype="multipart/form-data" action="<?php echo base_url(); ?>app/simpan_update" method="post" name="form_fullpayment" id="form_fullpayment" class="form-horizontal form-label-left">
  <div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h2 class="modal-title">Update Data Asset</h2>
        </div>
        <div class="modal-body">
          <h4>
            <font color="Grey"><Strong>
          </h4><br>
          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Nama
                Asset <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="nama_asset" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="nama_asset" placeholder="" required="required" type="text" value="<?php echo $asset_list->nama_asset; ?>">
              </div>
              <br><br>
            </div>
          </div>
          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Foto
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="nama_asset" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="foto_asset" placeholder="" type="file">
              </div>
              <br><br>
            </div>
          </div>
          <?php if (!file_exists(base_url('upload/asset/' . $asset_list->pic))) { ?>
            <div class="form-group">
              <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Foto
                  View <span class="required">*</span>
                </label>
                <div class="col-md-9 col-sm-9 col-xs-12">
                  <img src="<?= base_url('upload/asset/' . $asset_list->pic) ?>" alt="" width="100%">
                </div>
                <br><br>
              </div>
            </div>
          <?php } ?>
          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Spesifikasi <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <input id="spesifikasi" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="spesifikasi" placeholder="" required="required" type="text" value="<?php echo $asset_list->spesifikasi; ?>">
              </div>
              <br><br>
            </div>
          </div>
          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Ruangan <span class="required">*</span>
              </label>
              <!--div class="col-md-9 col-sm-9 col-xs-12">
					  <input id="ruangan" class="form-control col-md-7 col-xs-12" name="ruangan" placeholder="" required="required" type="text" value="<?php echo $asset_list->ruangan; ?>">
					</div-->

              <div class="col-md-9 col-sm-9 col-xs-12">
                <select class="js-example-basic-single" style="width:100%;" name="ruangan" id="ruangan" required="required">
                  <?php foreach ($asset_ruang as $data) :
                    if ($data->keterangan == $asset_list->ruangan) { ?>
                      <option value="<?php echo $data->keterangan; ?>" selected>
                        <?php echo $data->keterangan; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $data->keterangan; ?>">
                        <?php echo $data->keterangan; ?></option>
                    <?php } ?>
                  <?php endforeach; ?>
                </select>
              </div>

              <br><br>
            </div>
          </div>
          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Lokasi <span class="required">*</span>
              </label>
              <!--div class="col-md-9 col-sm-9 col-xs-12">
					  <input id="lokasi" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="lokasi" placeholder="" required="required" type="text" 
					  value="<?php echo $asset_list->lokasi; ?>">
					</div-->

              <div class="col-md-9 col-sm-9 col-xs-12">
                <select class="form-control js-example-basic-single" style="width:100%;" name="lokasi" id="lokasi" required="required">
                  <?php foreach ($asset_lokasi as $data) :
                    if ($data->keterangan == $asset_list->lokasi) { ?>
                      <option value="<?php echo $data->keterangan; ?>" selected>
                        <?php echo $data->keterangan; ?></option>
                    <?php } else { ?>
                      <option value="<?php echo $data->keterangan; ?>">
                        <?php echo $data->keterangan; ?></option>
                    <?php } ?>
                  <?php endforeach; ?>
                </select>
              </div>

              <br><br>
            </div>
          </div>
          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Kondisi <span class="required">*</span>
              </label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <select class="form-control js-example-basic-single" style="width:100%;" name="kondisi" id="kondisi" required="required">
                  <option value=""> -- Pilih Kondisi -- </option>
                  <option value="1" <?= $asset_list->kondisi == 1 ? 'selected' : '' ?>>Baik</option>
                  <option value="2" <?= $asset_list->kondisi == 2 ? 'selected' : '' ?>>Rusak</option>
                </select>
              </div>

              <br><br>
            </div>
          </div>
          <div class="form-group">
            <div class="item form-group">
              <label class="col-form-label col-md-3 col-sm-3 label-align" for="last-name">Detail Perubahan <span class="required">*</span></label>
              <div class="col-md-9 col-sm-9 col-xs-12">
                <textarea name="remark" class="form-control" rows="3" placeholder="Please write your information" required="required"></textarea>
              </div>
              <br><br><br><br>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div style="text-align: center;">
            <input id="id_postf" name="id_postf" type="hidden" required="required" value="<?php echo $asset_list->Id; ?>">
            <input id="kode" name="kode" type="hidden" required="required" value="<?php echo $asset_list->kode; ?>">
            <?php
            echo form_submit('Submit', 'Simpan', 'onclick="return clicked();", class="btn btn-primary"');
            ?>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>

    </div>
    <br><br><br>
  </div>
</form>