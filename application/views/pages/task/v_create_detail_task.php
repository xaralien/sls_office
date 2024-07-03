<?php if ($this->uri->segment(4) != true) { ?>
    <div class="right_col" role="main">
        <!--div class="pull-left">
					<font color='Grey'>Create New E-Memo </font>
					</div-->
        <div class="clearfix"></div>

        <!-- Start content-->
        <?php echo form_open_multipart('task/save_detail_task', 'class="form-horizontal form-label-left" name="form_input" id="form_input" enctype="multipart/form-data"'); ?>

        <!-- <div class="row"> -->
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
        <div class="x_panel card">
            <div class="x_title">
                <h2>Create Card
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
                <!-- <script>alert('Unauthorize Privilage!');window.history.back();</script> -->

                <a href="javascript:history.back()" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
                <br />
                <div class="task_array">
                    <h4 class="text-center">Card</h4>
                    <br>
                    <input style="border-radius: 5px;" type="hidden" name="id_task" value="<?= $this->uri->segment(3) ?>">
                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Card Name</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input style="border-radius: 5px;" type="text" class="form-control" name="project_name">
                        </div>
                    </div>
                    <input style="border-radius: 5px;" type="hidden" value="1" name="row[]">
                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Card Responsible</label>
                        <!-- <div class="col-md6 col-sm-6 col-xs-12"> -->
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <select required style="border-radius: 5px;" class="form-control" name="member_task">
                                <option disabled selected>Select Responsible</option>
                                <?php foreach ($ss as $data) {
                                    if ($data->nip != '') {
                                ?>
                                        <option value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                <?php }
                                } ?>
                            </select>
                        </div>
                        <!-- </div> -->
                    </div>

                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                        <div class="col-md6 col-sm-6 col-xs-12">
                            <textarea style="border-radius: 5px;" type="text" class="form-control" name="description"></textarea>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Start and due
                            date</label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input style="border-radius: 5px;" type="date" class="form-control" name="start">
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input style="border-radius: 5px;" type="date" class="form-control" name="end">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Attachment</label>
                        <div class="col-md6 col-sm-6 col-xs-12">
                            <input style="border-radius: 5px;" multiple type="file" name="att[]" class="form-control">
                        </div>
                    </div>

                    <div class="item form-group">
                        <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Activity</label>
                        <div class="col-md6 col-sm-6 col-xs-12">
                            <select style="border-radius: 5px;" class="form-control" name="activity" id="">
                                <option value="1">Open</option>
                                <option value="2">Pending</option>
                                <option value="3">Close</option>
                            </select>
                        </div>
                    </div>
                    <!-- <div class="item form-group">
									<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Comment</label>
									<div class="col-md6 col-sm-6 col-xs-12">
										<textarea class="form-control" name="comment" id="comment1" style="border-radius: 5px;" type="text"></textarea>
									</div>
								</div> -->
                </div>

            </div>
            </br>
            </br>
            </br>
        </div>
        <input type="hidden" value="<?= $this->uri->segment(3) ?>" name="id_card">
        <!-- </div> -->
        <!-- </div> -->
        <div id="task_wrapper"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button class="btn btn-primary" type="reset" onclick="reset_form()">Reset</button>
                <button type="submit" class="btn btn-success">Create
                    Card</button>
                <button type="button" id="add_task" class="btn btn-warning" style="display: none;">Add Card</button>
            </div>
        </div>
        </form>
        <br><br><br><br>

        <!-- Finish content-->

    </div>
<?php } else { ?>
    <div class="right_col" role="main">
        <!--div class="pull-left">
					<font color='Grey'>Create New E-Memo </font>
					</div-->
        <div class="clearfix"></div>

        <!-- Start content-->
        <?php echo form_open_multipart('task/save_detail_task', 'class="form-horizontal form-label-left" name="form_input" id="form_input" enctype="multipart/form-data"'); ?>

        <!-- <div class="row"> -->
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
        <div class="x_panel card">
            <div class="x_title">
                <h2>Edit Card
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
                <!-- <script>alert('Unauthorize Privilage!');window.history.back();</script> -->

                <a href="javascript:history.back()" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
                <br />
                <input type="hidden" name="status" value="edit">
                <?php foreach ($row_edit as $x) { ?>
                    <div class="task_array">
                        <h4 class="text-center">Card 1 </h4>
                        <br>
                        <input style="border-radius: 5px;" type="hidden" name="id_task" value="<?= $this->uri->segment(3) ?>">
                        <div class="item form-group">
                            <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Card Name</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input value="<?= $x->task_name ?>" style="border-radius: 5px;" type="text" class="form-control" name="project_name">
                            </div>
                        </div>
                        <input style="border-radius: 5px;" type="hidden" value="1" name="row[]">
                        <div class="item form-group">
                            <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Card Responsible</label>
                            <!-- <div class="col-md6 col-sm-6 col-xs-12"> -->
                            <div class="col-md-6 col-sm-6 col-xs-12">

                                <select required style="border-radius: 5px;" class="form-control" name="member_task">
                                    <option disabled selected>Select Responsible</option>
                                    <?php foreach ($ss as $data) {
                                        if ($data->nip != '') {
                                    ?>
                                            <option <?= $x->responsible == $data->nip ? 'selected' : '' ?> value="<?php echo $data->nip; ?>"><?php echo $data->nama; ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <!-- </div> -->
                        </div>

                        <div class="item form-group">
                            <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <textarea style="border-radius: 5px;" type="text" class="form-control" name="description"><?= $x->description ?></textarea>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Start and due
                                date</label>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input style="border-radius: 5px;" type="date" value="<?= $x->start_date ?>" class="form-control" name="start">
                            </div>
                            <div class="col-md-3 col-sm-6 col-xs-12">
                                <input style="border-radius: 5px;" type="date" value="<?= $x->due_date ?>" class="form-control" name="end">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Attachment</label>
                            <div class="col-md6 col-sm-3 col-xs-12">
                                <input style="border-radius: 5px;" multiple type="file" name="att[]" class="form-control">
                            </div>
                            <div class="col-md6 col-sm-3 col-xs-12">
                                <b> <?= $x->attachment == null ? 'File tidak ada' : $x->attachment ?></b>
                            </div>

                        </div>

                        <div class="item form-group">
                            <label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Activity</label>
                            <div class="col-md6 col-sm-6 col-xs-12">
                                <select style="border-radius: 5px;" class="form-control" name="activity" id="">
                                    <option <?= $x->activity == '1' ? 'selected' : '' ?> value="1">Open</option>
                                    <option <?= $x->activity == '2' ? 'selected' : '' ?> value="2">Pending</option>
                                    <option <?= $x->activity == '3' ? 'selected' : '' ?> value="3">Close</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="item form-group">
										<label style="text-align: left;" class="control-label col-md-3 col-sm-3 col-xs-12">Comment</label>
										<div class="col-md6 col-sm-6 col-xs-12">
											<textarea name="comment" id="comment1" class="form-control" style="border-radius: 5px;"><?= $x->comment ?></textarea>
										</div>
									</div> -->
                    </div>
                <?php } ?>

            </div>
            </br>
            </br>
            </br>
        </div>
        <input type="hidden" value="<?= $this->uri->segment(3) ?>" name="id_task">
        <input type="hidden" value="<?= $this->uri->segment(4) ?>" name="id_card">
        <!-- </div> -->
        <!-- </div> -->
        <div id="task_wrapper"></div>
        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <button class="btn btn-primary" type="reset" onclick="reset_form()">Reset</button>
                <button type="submit" class="btn btn-success">Update
                    Card</button>
                <!-- <button type="button" id="add_task" class="btn btn-warning">Add Card</button> -->
            </div>
        </div>
        </form>
        <br><br><br><br>

        <!-- Finish content-->

    </div>
<?php } ?>