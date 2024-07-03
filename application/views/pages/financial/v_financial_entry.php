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
                    <h2>Financial entry
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
                    <!-- <div class="clearfix">
                                </div> -->
                </div>
                <div class="x_content">
                    <!-- <br> -->
                    <form class="form-label-left input_mask" method="POST" action="<?= base_url('financial/process_financial_entry') ?>">
                        <div class="col-md-6 col-12 form-group has-feedback">
                            <label for="" class="form-label">Nominal</label>
                            <!-- <input type="text" class="form-control" name="input_nominal" id="input_nominal" placeholder="Nominal" oninput="format_angka()" onkeypress="return onlyNumberKey(event)" autofocus required> -->
                            <input type="text" class="form-control uang" name="input_nominal" id="input_nominal" placeholder="Nominal" autofocus required>
                        </div>
                        <div class="col-md-6 col-12 form-group has-feedback">
                            <label for="" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="input_keterangan" id="input_keterangan" placeholder="Keterangan" oninput="this.value = this.value.toUpperCase()" required>
                        </div>
                        <div class="col-md-6 col-12 form-group has-feedback">
                            <label for="" class="form-label">Debit</label>
                            <select name="neraca_debit" id="neraca_debit" class="form-control select2" required>
                                <option value="">-- Pilih pos neraca debit</option>
                                <?php
                                foreach ($coa as $c) :
                                ?>
                                    <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>" data-posisi="<?= $c->posisi ?>"><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?></option>
                                <?php
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-12 form-group has-feedback">
                            <label for="" class="form-label">Kredit</label>
                            <select name="neraca_kredit" id="neraca_kredit" class="form-control select2" required>
                                <option value="">-- Pilih pos neraca kredit</option>
                                <?php
                                foreach ($coa as $c) :
                                ?>
                                    <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>" data-posisi="<?= $c->posisi ?>"><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?> </option>
                                <?php
                                endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-12 form-group has-feedback">
                            <label for="" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" class="form-control" required>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-9 col-sm-9  offset-md-3">
                                <button type="button" class="btn btn-primary">Cancel</button>
                                <button class="btn btn-primary" type="reset">Reset</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?= base_url(); ?>assets/select2/css/select2.min.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/select2/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();

        $("form").on("submit", function() {
            Swal.fire({
                title: "Loading...",
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading()
                },
            });
        });
    });
</script>