<div class="right_col" role="main">
    <div class="clearfix"></div>

    <!-- Start content-->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
                <div class="x_title">
                    <h2>Financial entry
                        <small>Please fill below</small>
                    </h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button class="btn btn-primary btn-sm" onclick="document.location='<?= base_url('financial/financial_entry') ?>'">Single</button>
                            <!-- <a href="<?= base_url('financial/financial_entry') ?>" class="btn btn-primary dropdown-toggle">Single</a> -->
                        </li>
                        <li class="dropdown">
                            <button class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="color: white;">
                                Input Multiple
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="<?= base_url('financial/financial_entry/debit') ?>">Multi Kredit
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= base_url('financial/financial_entry/kredit') ?>">Multi Debit
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="x_content">
                    <!-- <br> -->
                    <form class="form-label-left input_mask" method="POST" action="<?= base_url('financial/store_financial_entry/multi_kredit') ?>" enctype="multipart/form-data">


                        <div class="col-md-6 col-xs-12 form-group has-feedback">
                            <label for="" class="form-label">Coa Debit</label>
                            <select name="neraca_debit" id="neraca_debit" class="form-control select2" style="width: 100%" required>
                                <option value="">:: Pilih pos neraca debit</option>
                                <?php foreach ($coa as $c) : ?>
                                    <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>" data-posisi="<?= $c->posisi ?>">
                                        <?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Coa Kredit</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody id="journal-entries">
                                <tr>
                                    <td>
                                        <select name="accounts[]" class="form-control select2" style="width: 100%" required>
                                            <option value="">:: Pilih akun</option>
                                            <?php foreach ($coa as $c) : ?>
                                                <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>"><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control uang nominal-input" name="nominals[]" placeholder="Nominal" required>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr>
                                    <td colspan="2" class="text-right">
                                        <button type="button" class="btn btn-secondary" id="add-row">Tambah Baris</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- <div class="col-md-6 col-xs-12 form-group has-feedback">
                            <label for="" class="form-label">Kredit</label>
                            <select name="neraca_kredit" id="neraca_kredit" class="form-control select2" required>
                                <option value="">:: Pilih pos neraca kredit</option>
                                <?php
                                foreach ($coa as $c) :
                                ?>
                                    <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>" data-posisi="<?= $c->posisi ?>"><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?> </option>
                                <?php
                                endforeach; ?>
                            </select>
                        </div> -->
                        <!-- <div class="col-md-6 col-xs-12 form-group has-feedback">
                            <label for="" class="form-label">Nominal</label>
                            <input type="text" class="form-control uang" name="input_nominal" id="input_nominal" placeholder="Nominal" autofocus required>
                        </div> -->
                        <div class="col-md-6 col-xs-12 form-group has-feedback">
                            <label for="" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>" class="form-control" required>
                        </div>
                        <div class="col-md-6 col-xs-12 form-group has-feedback">
                            <label for="" class="form-label">Keterangan</label>
                            <textarea name="input_keterangan" id="input_keterangan" class="form-control" placeholder="Keterangan" oninput="this.value = this.value.toUpperCase()" rows="3" required></textarea>
                        </div>
                        <div class="col-md-6 col-xs-12 form-group has-feedback">
                            <label for="file_upload" class="form-label">Upload file (opsional)</label>
                            <input type="file" name="file_upload" id="file_upload" class="form-control">
                        </div>
                        <div class="form-group row">
                            <div class="col-md-9 col-sm-9  offset-md-3">
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
<script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/select2/css/select2.min.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/select2/js/select2.min.js"></script>

<script src="<?= base_url(); ?>assets/js/jquery.mask.js"></script>
<script>
    $(document).ready(function() {
        $('.uang').mask('000.000.000.000.000', {
            reverse: true
        });
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

        // Fungsi untuk menambahkan baris baru
        $('#add-row').click(function() {
            let newRow = `
            <tr>
                <td>
                    <select name="accounts[]" class="form-control select2" style="width: 100%" required>
                        <option value="">:: Pilih akun</option>
                        <?php foreach ($coa as $c) : ?>
                            <option value="<?= $c->no_sbb ?>" data-nama="<?= $c->nama_perkiraan ?>"><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control uang nominal-input" name="nominals[]" placeholder="Nominal" required>
                </td>
            </tr>`;
            $('#journal-entries').append(newRow);
            $('.select2').select2();
            $('.uang').mask('000.000.000.000.000', {
                reverse: true
            });
        });

        function formatState(state, colorAktiva, colorPasiva, signAktiva, signPasiva) {
            // console.log(state)
            if (!state.id) {
                return state.text;
            }

            var color = state.element.dataset.posisi == "AKTIVA" ? colorAktiva : colorPasiva;
            var sign = state.element.dataset.posisi == "AKTIVA" ? signAktiva : signPasiva;

            var $state = $('<span style="background-color: ' + color + ';"><strong>' + state.text + ' ' + sign + '</strong></span>');

            return $state;
        };

        function formatStateDebit(state) {
            // console.log(state)
            return formatState(state, '#2ecc71', '#ff7675', '(+)', '(-)');
        }

        function formatStateKredit(state) {
            return formatState(state, '#ff7675', '#2ecc71', '(-)', '(+)');
        }
        $('#neraca_debit').select2({
            // templateResult: formatStateDebit,
            templateSelection: formatStateDebit
        });

        $('#neraca_kredit').select2({
            // templateResult: formatStateKredit,
            templateSelection: formatStateKredit
        });
    });

    // const flashdata = $(".flash-data").data("flashdata");
    // if (flashdata) {
    //     Swal.fire({
    //         title: "Success!! ",
    //         text: '<?= $this->session->flashdata('message_name') ?>',
    //         type: "success",
    //         icon: "success",
    //     });
    // }

    // const flashdata_error = $(".flash-data-error").data("flashdata");
    // // const flashdata_error = $('.flash-data').data('flashdata');
    // if (flashdata_error) {
    //     Swal.fire({
    //         title: "Error!! ",
    //         text: flashdata_error,
    //         type: "error",
    //         icon: "error",
    //     });
    // }
</script>