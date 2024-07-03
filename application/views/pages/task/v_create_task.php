<link rel="stylesheet" href="<?php echo base_url(); ?>assets/select2/css/select2.min.css">
<div class="right_col" role="main">
    <!--div class="pull-left">
					<font color='Grey'>Create New E-Memo </font>
				</div-->
    <div class="clearfix"></div>

    <!-- Start content-->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
                <div class="x_title">
                    <h2>Create Task
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

                    <?php
                    if ($this->uri->segment(3) == true) {
                        echo form_open_multipart('task/update_task', 'class="form-horizontal form-label-left" name="form_input" id="form_input" enctype="multipart/form-data"');
                    } else {
                        echo form_open_multipart('task/save_task', 'class="form-horizontal form-label-left" name="form_input" id="form_input" enctype="multipart/form-data"');
                    }
                    ?>
                    <!-- <form action="<?= base_url('app/simpan_memo') ?>" method="POST" class="form-horizontal form-label-left" enctype="multipart/form-data"> -->
                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Task Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php if ($this->uri->segment(3) == true) { ?>
                                <input type="text" class="form-control" value="<?= $task_edit['name'] ?>" name="project_name" required style="border-radius: 5px;">
                            <?php } else { ?>
                                <input type="text" class="form-control" value="" name="project_name" required style="border-radius: 5px;">
                            <?php } ?>
                        </div>
                    </div>
                    <hr>
                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Task Member</label>
                        <!-- <div class="col-md6 col-sm-6 col-xs-12"> -->
                        <?php if (!empty($this->uri->segment(4))) { ?>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <?php if (!empty($memo->nip_kpd)) { ?>
                                    <select class="js-example-basic-multiple" name="member_task[]" id="member_task" multiple="multiple" style="width: 100%;">
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
                                    <select class="js-example-basic-multiple" required="required" name="member_task[]" id="member_task" multiple="multiple" style="width: 100%;">
                                        <?php foreach ($sendto as $data) : ?>
                                            <option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php } ?>
                            </div>
                        <?php } else { ?>
                            <div class="col-md-6 col-sm-8 col-xs-12">
                                <!--select class="form-control" required="required" multiple="multiple" name="member_task[]" id="member_task">
									<?php foreach ($sendto as $data) : ?>        
										<option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option> 
									<?php endforeach; ?>
								  </select-->

                                <?php if ($this->uri->segment(3) == true) { ?>
                                    <input type="hidden" name="id_edit" value="<?= $this->uri->segment(3) ?>">
                                    <select class="form-control js-example-basic-multiple" required="required" name="member_task[]" id="member_task" multiple="multiple" style="width: 100%;">
                                        <?php
                                        foreach ($sendto as $data) :
                                            if (strpos($task_edit['member'], $data->nip) !== false) {
                                        ?>
                                                <option selected value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?>
                                                    (<?php echo $data->nama_jabatan; ?>)</option>
                                            <?php
                                            } else { ?>
                                                <option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?>
                                                    (<?php echo $data->nama_jabatan; ?>)</option>

                                        <?php }
                                        endforeach; ?>
                                    </select>
                                <?php } else { ?>
                                    <select class="form-control js-example-basic-multiple" required="required" name="member_task[]" id="member_task" multiple="multiple" style="width: 100%;">
                                        <?php foreach ($sendto as $data) : ?>
                                            <option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?>
                                                (<?php echo $data->nama_jabatan; ?>)</option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        <!-- </div> -->
                    </div>
                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Task Activity</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php if ($this->uri->segment(3) == true) { ?>
                                <select name="activity" id="" class="form-control" style="border-radius: 5px;">
                                    <option <?= $task_edit['activity'] == '1' ? 'selected' : '' ?> value="1">Open</option>
                                    <option <?= $task_edit['activity'] == '2' ? 'selected' : '' ?> value="2">Pending</option>
                                    <option <?= $task_edit['activity'] == '3' ? 'selected' : '' ?> value="3">Close</option>
                                </select>
                            <?php } else { ?>
                                <select name="activity" id="" class="form-control" style="border-radius: 5px;">
                                    <option value="1">Open</option>
                                    <option value="2">Pending</option>
                                    <option value="3">Close</option>
                                </select>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">
                            Description</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php if ($this->uri->segment(3) == true) { ?>
                                <textarea name="comment" id="comment" style="border-radius: 5px;" rows="4" class="form-control"><?= $task_edit['comment'] ?></textarea>
                            <?php } else { ?>
                                <textarea name="comment" id="comment" style="border-radius: 5px;" rows="4" class="form-control"></textarea>
                            <?php } ?>

                            <!-- <input style="border-radius: 5px;" type="text" class="form-control" name="comment"> -->
                        </div>
                    </div>



                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <?php
                            if ($this->uri->segment(3) == true) {
                            ?>
                                <a class="btn btn-warning" href="<?= base_url('task/task') ?>">Back
                                </a>
                                <button id="submit-memo" type="submit" class="btn btn-success">Update Task</button><br>
                            <?php } else { ?>
                                <button class="btn btn-primary" type="reset" onclick="reset_form()">Reset
                                </button>
                                <button id="submit-memo" type="submit" class="btn btn-success">Submit Task</button><br>
                            <?php } ?>
                        </div>
                    </div>
                    <br>
                    </form>
                </div>
                </br>
                </br>
                </br>
            </div>
        </div>
    </div>
    <br><br>
    <!-- Finish content-->

</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/select2/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>