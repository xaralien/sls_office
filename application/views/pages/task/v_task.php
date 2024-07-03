<div class="right_col" role="main">
    <div class="clearfix"></div>

    <div class="x_panel card">
        <!-- <strong>
						<font style="color:blue;font-size:24px;">BANDES</font>
							<font style="color:green;font-size:24px;">LOGISTIK</font>
						</strong></br>
						<font style="font-size:17px;">PT. Bangun Desa Logistindo</font></br></br>
						<br>
					-->

        <?php if ($this->uri->segment(4) == false) { ?>
            <div align="center">
                <font style="font-size:17px;">
                    Card List
                    <div style="width: fit-content;">
                        <p style="font-size: 15px; margin-top:5px; background-color: #449d44; color: white; padding:5px 10px; border-radius: 5px; display:;"><?php echo $task->name; ?></p>
                    </div>
                    <span style="font-size: 15px; text-align:center"><?= $task->comment ?></span>
                    <p>
                        Member Name :<?php
                                        $data_nip = explode(';', $task->member);
                                        foreach ($data_nip as $x) {
                                            if ($x != '') {
                                                $this->db->where('nip', $x);
                                                $get = $this->db->get('users')->row_array();
                                                echo $get['nama'] . ', ';
                                            }
                                        }
                                        ?>
                    </p>

                    <hr>
                </font>
            </div>

            <div class="col-md-4">
                <a href="<?= base_url('task/task') ?>" class="btn btn-warning"> <i class="fa fa-arrow-left"></i> Back</a>
                <?php
                $this->db->where('a.pic', $this->session->userdata('nip'));
                $this->db->join('task_detail as b', 'a.id=b.id_task');
                $cek_role = $this->db->get('task as a')->num_rows();

                $cek_status = $this->db->get_where('task', ['id' => $this->uri->segment(3)])->row_array();

                if ($cek_role == true && $cek_status['activity'] == '1') { ?>
                    <a href="<?= base_url('task/detail_task/' . $this->uri->segment(3)) ?>" class="btn btn-primary"> <i class="fa fa-plus"></i> Add Card</a>
                <?php } ?>
                <?php
                if ($cek_status['activity'] == '1' && $cek_role == true) { ?>
                    <a href="<?= base_url('task/close_task/' . $this->uri->segment(3)) ?>" class="btn btn-danger" id="btn-close-task"> Close Task</a>
                <?php } ?>
            </div>
        <?php } ?>
        <font style="font-size:14px;">
            <?php if ($this->uri->segment(3) == true && $this->uri->segment(4) == false) { ?>
                <div class="table-responsive">
                    <table class="center table table-striped">
                        <thead>
                            <th>Card Name</th>
                            <th>Responsible</th>
                            <!-- <th>Description</th> -->
                            <th>Start Date</th>
                            <th>Due Date</th>
                            <!-- <th>Attachment</th>  -->
                            <th>Activity</th>
                            <!-- <th>Comment</th> -->
                            <th width="200">Action</th>
                        </thead>
                        <?php foreach ($task_detail as $x) {
                            $nip = $this->session->userdata('nip');
                            $kalimat = $x->read;
                            if (preg_match("/$nip/i", $kalimat)) {
                                if ($x->activity == '1' && $x->due_date > date('Y-m-d')) {
                                    $color = '#00b894';
                                } else if ($x->activity == '3') {
                                    $color = '#636e72';
                                } else {
                                    $color = '#ff7675';
                                }

                                if ($x->activity == '1') {
                                    $activity = 'Open';
                                } else if ($x->activity == '2') {
                                    $activity = 'Pending';
                                } else {
                                    $activity = 'Closed';
                                }
                        ?>
                                <tr style="background-color: <?= $color ?>;color:azure">
                                    <td> <?= $x->task_name ?></td>
                                    <td> <?= $x->nama ?></td>
                                    <td> <?= $x->start_date ?></td>
                                    <td> <?= $x->due_date ?></td>
                                    <td> <?= $activity ?></td>
                                    <td>
                                        <a href="<?= base_url('task/task_view/' . $this->uri->segment(3) . '/' . $x->id_detail) ?>" class="btn btn-xs" style="background-color: white;">Detail</a>
                                        <a href="<?= base_url('task/card_edit/' . $this->uri->segment(3) . '/' . $x->id_detail) ?>" class="btn btn-xs" style="background-color: black;color:white;">Edit</a>
                                    </td>
                                </tr>
                            <?php } else {
                                if ($x->activity == '1') {
                                    $color = '#00b894';
                                } else if ($x->activity == '2') {
                                    $color = '#0984e3';
                                } else {
                                    $color = '#ff7675';
                                }
                                if ($x->activity == '1') {
                                    $activity = 'Open';
                                } else if ($x->activity == '2') {
                                    $activity = 'Pending';
                                } else {
                                    $activity = 'Closed';
                                }
                            ?>
                                <tr style="background-color: <?= $color ?>;color:azure">
                                    <td> <?= $x->task_name ?></td>
                                    <td> <?= $x->nama ?></td>
                                    <!-- <td> <?= $x->description ?></td> -->
                                    <td> <?= $x->start_date ?></td>
                                    <td> <?= $x->due_date ?></td>
                                    <!-- <td> <?= $x->attachment ?></td> -->
                                    <td> <?= $activity ?></td>
                                    <!-- <td> <?= $x->comment ?></td> -->
                                    <td>
                                        <a href="<?= base_url('task/task_view/' . $this->uri->segment(3) . '/' . $x->id_detail) ?>" class="btn btn-xs" style="background-color: white;">Detail</a>
                                        <i style="color: red;" class="fa fa-circle"></i>
                                    </td>
                                </tr>
                        <?php }
                        } ?>

                    </table>
                </div>
            <?php } else if ($this->uri->segment(4)) { ?>
                <div align="center">
                    <font style="font-size:17px;">
                        Card Detail</br>
                    </font>
                    <div style="margin-top:5px; width: fit-content;">
                        <p style="font-size: 15px; background-color: #449d44; color: white; padding:5px 8px; border-radius: 5px;"><?php echo $task_comment['task_name']; ?></p>
                    </div>
                    <br>
                    <hr>
                </div>

                <div class="item form-group" style="margin-bottom: 40px;">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?= base_url('task/task_view/' . $this->uri->segment(3)) ?>" class="btn btn-warning"><i class="fa fa-arrow-left"></i> Back</a>
                        </div>
                    </div>
                </div>
                <div class="item form-group">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-4">
                            <span>Card Name</span>
                        </div>
                        <div class="col-md-4">
                            <b>: <?= $task_comment['task_name'] ?></b>
                        </div>
                    </div>
                </div>
                <div class="item form-group">
                    <div class="row">
                        <div class="col-md-2 col-sm-2  col-xs-4">
                            <span>Responsible</span>
                        </div>
                        <div class="col-md-4 col-sm-6">
                            <b>: <?= $task_comment['nama'] ?></b>
                        </div>
                    </div>
                </div>
                <div class="item form-group">
                    <div class="row">
                        <div class="col-md-2 col-sm-2 col-xs-4">
                            <span>Description</span>
                        </div>
                        <div class="col-md-6">
                            <b style="white-space: pre-line;">: <?= $task_comment['description'] ?></b>
                        </div>
                    </div>
                </div>
                <div class="item form-group">
                    <div class="row">
                        <div class="col-md-2 col-sm-2  col-xs-4">
                            <span>Start Date</span>
                        </div>
                        <div class="col-md-4">
                            <b>: <?= $task_comment['start_date'] ?></b>
                        </div>
                    </div>
                </div>
                <div class="item form-group">
                    <div class="row">
                        <div class="col-md-2 col-sm-2  col-xs-4">
                            <span>Due Date</span>
                        </div>
                        <div class="col-md-4">
                            <b>: <?= $task_comment['due_date'] ?></b>
                        </div>
                    </div>
                </div>
                <?php if (count(explode(';', $task_comment['attachment'])) == true) { ?>
                    <div class="item form-group">
                        <div class="row">
                            <div class="col-md-2 col-sm-2  col-xs-4">
                                <span>Attachment</span>
                            </div>
                            <div class="col-md-8">
                                :
                                <?php $att_xx = explode(';', $task_comment['attachment']);
                                foreach ($att_xx as $x) {
                                    if (file_exists('upload/task_comment/' . $x)) {
                                        $url = base_url('upload/task_comment/' . $x);
                                    } else {
                                        $url = base_url('upload/card_task/' . $x);
                                    }
                                ?>
                                    <a download href="<?= $url ?>"> <?= $x ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($task_comment['responsible'] == $this->session->userdata('nip') || $task_comment['pic'] == $this->session->userdata('nip')) { ?>
                    <?php if ($task_comment['activity'] != '3') { ?>
                        <div class="item form-group">
                            <div class="row">
                                <div class="col-md-2 col-sm-2  col-xs-4">
                                    <span>Activity</span>
                                </div>
                                <div class="col-md-4 col-sm-8">
                                    <form action="<?= base_url('task/status_activity') ?>" method="POST" class="row" id="form-change-status">
                                        <input type="hidden" name="id_task" value="<?= $this->uri->segment(3) ?>">
                                        <input type="hidden" name="id_detail" value="<?= $this->uri->segment(4) ?>">
                                        <div class="col-md-5 col-sm-3">
                                            <select name="activity" id="" class="form-control">
                                                <?php if ($task_comment['activity'] === '1') { ?>
                                                    <option selected value="1">Open</option>
                                                    <option value="2">Pending</option>
                                                    <option value="3">Closed</option>
                                                <?php } else if ($task_comment['activity'] == '2') { ?>
                                                    <option value="1">Open</option>
                                                    <option selected value="2">Pending</option>
                                                    <option value="3">Closed</option>
                                                <?php } else if ($task_comment['activity'] == '3') { ?>
                                                    <option value="1">Open</option>
                                                    <option value="2">Pending</option>
                                                    <option selected value="3">Closed</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="submit" class="btn btn-primary" id="btn-change-status">Change</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                <?php } ?>
                <hr>
                <div class="item form-group">
                    <div class="row text-center">
                        <h4> Activity</h4>
                    </div>
                </div>
                <!-- <div class="item form-group"> -->
                <?php if ($task_comment['activity'] == "1") { ?>
                    <form action="<?= base_url('task/activity_comment') ?>" method="POST" enctype="multipart/form-data" id="form-comment-activity">
                        <div class="row justify-content-center">
                            <input type="hidden" name="id_task" value="<?= $this->uri->segment(3) ?>">
                            <input type="hidden" name="id_detail" value="<?= $this->uri->segment(4) ?>">
                            <div class="col-md-8">
                                <input style="border-radius: 20px;" type="file" name="file[]" class="form-control" multiple>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <textarea style="border-radius: 10px;" required name="commentt" type="text" class="form-control" placeholder="comment" rows="3"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="row justify-content-center">
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-warning" style="width: 100%;border-radius:20px;" id="btn-comment-activity">Add Activity</button>
                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                    </form>
                <?php } ?>

                <?php foreach ($task_comment_member as $x) {
                    if ($x->member == $task_comment['responsible']) {
                ?>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div style="margin-left: 20px;">
                                    <span style="font-size:14px;"> <?= date('d M Y H:i:s', strtotime($x->date_created)) ?></span>
                                </div>
                                <div class="x_panel tile fixed_height_300" style="background-color: #4CAF50;color:aliceblue;border-radius:20px;">
                                    <span>
                                        <div>
                                            <?= $x->nama ?> :
                                            <p style="white-space: pre-line;">
                                                <b> <?= $x->comment_member ?></b>
                                            </p>
                                        </div>
                                    </span>
                                    <?php if ($x->attachment != null) { ?>
                                        <hr>
                                        Attachment :
                                        <b> <?php foreach (explode(';', $x->attachment_name) as $xx) {
                                                if (file_exists('upload/task_comment/' . $xx)) {
                                                    $url2 = base_url('upload/task_comment/' . $xx);
                                                } else {
                                                    $url2 = base_url('upload/card_task/' . $xx);
                                                }
                                            ?>
                                                <a style="color: white;" href="<?= $url2 ?>" download>
                                                    <?= $xx . " || " ?>
                                                </a>
                                        <?php }
                                        } ?>

                                        </b>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div style="margin-left: 20px;">
                                    <span style="font-size:14px;"> <?= date('d M Y H:i:s', strtotime($x->date_created)) ?></span>
                                </div>
                                <div class="x_panel tile fixed_height_300" style="background-color: #4287f5;color:aliceblue;border-radius:20px;">
                                    <span>
                                        <?= $x->nama ?> :
                                        <p style="white-space: pre-line;">
                                            <b> <?= $x->comment_member ?></b>
                                        </p>
                                    </span>
                                    <?php if ($x->attachment != null) { ?>
                                        <hr>
                                        Attachment : <b> <?php foreach (explode(';', $x->attachment_name) as $x) {
                                                                if (file_exists('upload/task_comment/' . $x)) {
                                                                    $url3 = base_url('upload/task_comment/' . $x);
                                                                } else {
                                                                    $url3 = base_url('upload/card_task/' . $x);
                                                                }
                                                            ?>
                                                <a style="color: white;" href="<?= $url3 ?>" download>
                                                    <?= $x . " || " ?>
                                                </a>
                                        <?php }
                                                        } ?>
                                        </b>
                                </div>
                            </div>
                        </div>
                <?php }
                } ?>
            <?php } ?>
            </br></br>
        </font>


    </div>
</div>