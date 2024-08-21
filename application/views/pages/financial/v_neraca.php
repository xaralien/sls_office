<style>
    .modal {
        text-align: center;
        padding: 0 !important;
    }

    .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
    }
</style>
<div class="right_col" role="main">
    <div class="clearfix"></div>

    <!-- Start content-->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
                <div class="x_title">
                    <h2>Tabel Neraca</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <?php
                        if ($this->uri->segment(3)) {
                        ?>
                            <li>
                                <button class="btn btn-warning" onclick="document.location='<?= $_SERVER['HTTP_REFERER'] ?>'">Kembali</button>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li>
                                <button class="btn btn-success" onclick="document.location='<?= base_url('financial/neraca_tersimpan') ?>'">Neraca tersimpan</button>
                            </li>
                            <li>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#simpanNeraca">Simpan neraca</button>
                            </li>
                        <?php
                        } ?>
                    </ul>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <h5>
                                Neraca: <strong>Rp <?= number_format($neraca) ?></strong>
                            </h5>
                        </div>
                        <div class="col-md-2 col-xs-12">
                        </div>
                        <div class="col-md-4 col-xs-12">

                            <?php
                            if (!$this->uri->segment(3)) {
                            ?>
                                <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/showReport') ?>">
                                    <div class="form-group row">
                                        <select name="jenis_laporan" id="jenis_laporan" class="form-control" onchange="this.form.submit()">
                                            <option <?= ($this->input->post('jenis_laporan') == "neraca") ? "selected" : "" ?> value="neraca">Neraca</option>
                                            <option <?= ($this->input->post('jenis_laporan') == "laba_rugi") ? "selected" : "" ?> value="laba_rugi">Laba Rugi</option>
                                            <!-- <option <?= ($this->input->post('jenis_laporan') == "invoice_nol") ? "selected" : "" ?> value="invoice_nol">Invoice Nol</option> -->
                                        </select>
                                    </div>
                                </form>
                            <?php
                            } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <h2 class="text-center">Activa</h2>
                            <p class="text-right">Total: <strong><?= number_format($sum_activa) ?></strong></p>
                            <table id="" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Coa</th>
                                        <th>Nama Coa</th>
                                        <th>Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($activa as $a) :
                                    ?>
                                        <tr>
                                            <td><?= $a->no_sbb ?></td>
                                            <td><?= $a->nama_perkiraan ?></td>
                                            <td class="text-right"><?= number_format($a->nominal) ?></td>
                                        </tr>
                                    <?php
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <div class="row justify-content-between">
                                <h2 class="text-center">Pasiva</h2>
                                <p class="text-right">Total: <strong><?= number_format($sum_pasiva) ?></strong></p>
                            </div>
                            <table id="" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Coa</th>
                                        <th>Nama Coa</th>
                                        <th>Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($pasiva as $p) :
                                    ?>
                                        <tr>
                                            <td><?= $p->no_sbb ?></td>
                                            <td><?= $p->nama_perkiraan ?></td>
                                            <td class="text-right"><?= number_format(($p->no_sbb == '3201001') ? $laba : $p->nominal) ?></td>
                                        </tr>
                                    <?php
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="simpanNeraca">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    Simpan neraca
                </h4>
            </div>
            <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/simpanNeraca') ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-xs-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" oninput="this.value = this.value.toUpperCase()"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Simpan neraca
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const flashdata = $(".flash-data").data("flashdata");
    if (flashdata) {
        Swal.fire({
            title: "Success!! ",
            text: '<?= $this->session->flashdata('message_name') ?>',
            type: "success",
            icon: "success",
        });
    }

    const flashdata_error = $(".flash-data-error").data("flashdata");
    // const flashdata_error = $('.flash-data').data('flashdata');
    if (flashdata_error) {
        Swal.fire({
            title: "Error!! ",
            text: flashdata_error,
            type: "error",
            icon: "error",
        });
    }
</script>