<script type="text/javascript" src="<?php echo base_url(); ?>assets/ckeditor/ckeditor.js"></script>
<div class="right_col" role="main">
    <div class="clearfix"></div>

    <!-- Start content-->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
                <div class="x_title">
                    <h2>Create New Digital Memo
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
                <div class="x_content">
                    <br />
                    <?php echo form_open_multipart('app/simpan_memo', 'class="form-horizontal form-label-left" name="form_input" id="form_input" enctype="multipart/form-data"'); ?>
                    <!-- <form action="<?= base_url('app/simpan_memo') ?>" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data"> -->
                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tujuan BOC <span class="required"> *</span></label>
                        <?php if (!empty($this->uri->segment(4))) { ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php if (!empty($memo->nip_kpd)) { ?>
                                    <select class="form-control js-example-basic-multiple" name="tujuan_memo[]" id="tujuan_memo" multiple="multiple" required>
                                        <?php foreach ($sendto as $data) : ?>
                                            <?php
                                            if (($data->nip == $memo->nip_dari)) { ?>
                                                <option selected="selected" value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    </select>
                                <?php } else { ?>
                                    <select class="form-control js-example-basic-multiple" required="required" name="tujuan_memo[]" id="tujuan_memo" multiple="multiple" required>
                                        <?php foreach ($sendto as $data) : ?>
                                            <option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <!--select class="form-control" required="required" multiple="multiple" name="tujuan_memo[]" id="tujuan_memo">
									<?php foreach ($sendto as $data) : ?>        
										<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option> 
									<?php endforeach; ?>
								  </select-->

                                <?php if (!empty($memo->nip_kpd)) { ?>
                                    <select class="form-control js-example-basic-multiple" name="tujuan_memo[]" id="tujuan_memo" multiple="multiple">
                                        <?php foreach ($sendto as $data) : ?>
                                            <?php
                                            if (($data->nip == $memo->nip_dari)) { ?>
                                                <option selected="selected" value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    </select>
                                <?php } else { ?>
                                    <select class="form-control js-example-basic-multiple" required="required" name="tujuan_memo[]" id="tujuan_memo" multiple="multiple">
                                        <?php foreach ($sendto as $data) : ?>
                                            <option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?> (<?php echo $data->nama_jabatan; ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>

                    <?php if (!empty($this->uri->segment(4))) { ?>
                        <div class="item form-group">
                            <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">CC BOC</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <select class="form-control js-example-basic-multiple" name="cc_memo[]" id="cc_memo" multiple="multiple">
                                    <?php foreach ($sendto as $data) : ?>
                                        <option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="item form-group">
                            <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">CC BOC</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <!--select class="form-control" multiple="multiple" name="cc_memo[]" id="cc_memo">
									<?php foreach ($sendto as $data) : ?>        
										<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option> 
									<?php endforeach; ?>
								  </select-->

                                <?php if (!empty($memo->nip_cc)) { ?>
                                    <!-- <?= $memo->nip_kpd ?>       -->
                                    <?php foreach ($sendto as $data) : ?>
                                    <?php
                                    // $o = explode(';',$memo->nip_kpd);
                                    // echo  var_dump($o);
                                    // echo $data->nip;
                                    // if (strpos($memo->nip_cc,$data->nip) !== false) {
                                    // 	// if($data->nip<>$this->session->userdata('nip')){
                                    // 		echo $data->nama;
                                    // 	// }
                                    // }else if(strpos($memo->nip_cc,$data->nip) !== false){
                                    // 	echo $data->nama;
                                    // } 
                                    endforeach;
                                    ?>
                                    <select class="form-control js-example-basic-multiple" name="cc_memo[]" id="cc_memo" multiple="multiple">
                                        <?php foreach ($sendto as $data) : ?>
                                            <?php if (strpos($memo->nip_cc, $data->nip) !== false) {
                                                if ($data->nip <> $this->session->userdata('nip')) { ?>
                                                    <option selected="selected" value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                                <?php } ?>
                                                <?php } elseif (strpos($memo->nip_kpd, $data->nip) !== false) {
                                                if ($data->nip <> $this->session->userdata('nip')) { ?>
                                                    <option selected="selected" value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                    </select>
                                <?php } else if (empty($memo->nip_cc) && $this->uri->segment(3)) { ?>
                                    <select class="form-control js-example-basic-multiple" name="cc_memo[]" id="cc_memo" multiple="multiple">
                                        <?php foreach ($sendto as $data) : ?>
                                            <?php if (strpos($memo->nip_kpd, $data->nip) !== false) {
                                                if ($data->nip <> $this->session->userdata('nip')) {
                                            ?>
                                                    <option selected="selected" value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                            <?php }
                                            } ?>
                                            <option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?> (<?php echo $data->nama_jabatan; ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php } else { ?>
                                    <select class="form-control js-example-basic-multiple" name="cc_memo[]" id="cc_memo" multiple="multiple">
                                        <?php foreach ($sendto as $data) : ?>
                                            <option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?> (<?php echo $data->nama_jabatan; ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php } ?>

                                <!--select class="form-control js-example-basic-multiple" name="cc_memo[]" id="cc_memo" multiple="multiple">
									<?php foreach ($sendto as $data) : ?>        
										<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option> 
									<?php endforeach; ?>
								  </select-->

                            </div>
                        </div>
                    <?php } ?>

                    <hr>

                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Judul E-Memo<span class="required"> *</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="subject_memo" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="subject_memo" placeholder="Judul E-Memo" required="required" type="text" value="<?= !empty($memo->judul) ? $memo->judul : set_value('subject_memo') ?>">
                            <span class="text-danger"></span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Attachment</label>
                        <?php if (!empty($memo->attach_name)) { ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="attch_exist" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="attch_exist" type="text" value="<?php echo $memo->attach_name; ?>" readonly>
                                <input id="attch_exist_nm" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="1" name="attch_exist_nm" type="hidden" value="<?php echo $memo->attach; ?>">
                                <input type="file" name="file[]" id="file" multiple>
                            </div>
                        <?php } else { ?>
                            <input type="file" name="file[]" id="file" multiple>
                        <?php } ?>
                    </div>
                </div>

                <div class="item form-group">
                    <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Isi E-Memo<span class="required"> *</span>
                    </label>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <textarea class="ckeditor" name="ckeditor" id="ckeditor">
								<?php
                                if ($this->uri->segment(3) == true) {
                                    $array_bln = array(1 => "I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII");
                                    $bln = $array_bln[date('n', strtotime($memo->tanggal))];
                                }
                                if (!empty($memo->isi_memo)) {
                                    echo ('<br><hr/>');
                                    echo ('<br> created by. ');
                                    $nip = $memo->nip_dari;

                                    $query = $this->db->query("SELECT nama,nama_jabatan FROM users WHERE nip='$nip';")->row()->nama;
                                    echo $query;
                                    if ($this->uri->segment(3) == true) {
                                        echo "<br>";
                                        echo "No Memo : " . sprintf("%03d", $memo->nomor_memo) . '/E-MEMO/' . $memo->kode_nama . '/' . $bln . '/' . date('Y', strtotime($memo->tanggal));
                                    }
                                    echo $memo->isi_memo;
                                }

                                echo set_value('ckeditor');
                                ?>
								
							</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label style="text-align: left; font-size:12px;" for="informasi" class="control-label col-md-3 col-sm-3 col-xs-12">
                        <font color="red">* Pastikan pembuatan memo sudah benar sebelum memo dikirim</font>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <button type="button" class="btn btn-warning" onclick="history.back()">Back</button>
                        <button class="btn btn-primary" type="button" onclick="window.location.href='<?php echo base_url(); ?>home';">Cancel
                        </button>
                        <button class="btn btn-primary" type="reset" onclick="reset_form()">Reset
                        </button>
                        <!--<button type="submit" id="save_project" name="save_project" class="btn btn-success" onclick="return clicked();">Submit</button>-->
                        <button id="submit-memo" type="button" class="btn btn-success">Send</button><br>
                        <!--<input type="submit" value="Save Customer" class="btn btn-success"/><br><br><br>-->
                        <?php //echo form_submit('save_customer', 'Save Customer', 'onclick="return clicked();", class="btn btn-success"'); 
                        ?>
                    </div>
                </div>

                </form>
            </div>
            </br>
            </br>
            </br>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/select2/js/select2.min.js"></script>

<script>
    function reset_form() {
        document.getElementById("form_input").reset();
        document.getElementById("ckeditor").value = '';
    }
    $(document).ready(function() {
        <?php if ($this->session->userdata('msg') == 'error2') { ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Error Input!',
            })
        <?php
            $this->session->unset_userdata('msg');
        } else if ($this->session->userdata('msg_memo')) { ?>
            Swal.fire({
                icon: 'success',
                title: 'Success input',
                text: 'Create & Send Success to ID <?php echo $this->session->userdata('msg_memo') ?>',
            })
        <?php
            $this->session->unset_userdata('msg_memo');
        } ?>

        $("#submit-memo").on('click', function(e) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to submit the form?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#form_input").submit();
                } else {
                    e.preventDefault();
                }
            })
        });

        $("#form_input").on('submit', () => {
            $("#submit-memo").attr('disabled', true);
            $("#submit-memo").html('Sending...');
            Swal.fire({
                title: 'Sending...',
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                },
            })
        });

    });

    function simpan() {
        if (!confirm("Yes, send it!")) {
            alert('Canceled!');
            return false;
        } else {
            form.submit();
        }
    }

    $('#save_memo1').on('click', function(e) {
        e.preventDefault();
        var form = $(this).parents('form');
        swal({
            title: "Are you sure?",
            text: "Send Memo!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, send it!",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (isConfirm) form.submit();
        });
    });

    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>