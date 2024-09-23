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
                    <h2>Tabel</h2>
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
                                <button class="btn btn-success" onclick="document.location='<?= base_url('financial/lr_tersimpan') ?>'">L/R tersimpan</button>
                            </li>
                            <li>
                                <button class="btn btn-primary" data-toggle="modal" data-target="#simpanLR">Simpan L/R</button>
                            </li>
                        <?php
                        } ?>
                    </ul>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <h5>
                                <?php
                                $total_pendapatan = $sum_pendapatan - $sum_biaya; ?>
                                Laba berjalan: <strong>Rp <?= number_format($total_pendapatan) ?></strong>
                            </h5>
                        </div>
                        <div class="col-md-2 col-xs-12"></div>
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
                        <div class="col-md-12 col-xs-12">
                            <div class="row justify-content-between">
                                <h2 class="text-center">Pendapatan</h2>
                                <p class="text-right">Total: <strong><?= number_format($sum_pendapatan) ?></strong></p>
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
                                    if ($pendapatan) {

                                        foreach ($pendapatan as $p) :
                                    ?>
                                            <tr>
                                                <td><?= $p->no_lr_sbb ?></td>
                                                <td><?= $p->nama_perkiraan ?></td>
                                                <td class="text-right"><?= number_format($p->nominal) ?></td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    } else {
                                        ?>
                                        <tr>
                                            <td colspan="3">Tidak ada data pendapatan yang ditampilkan.</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12 col-xs-12">
                            <h2 class="text-center">Biaya</h2>
                            <p class="text-right">Total: <strong><?= number_format($sum_biaya) ?></strong></p>
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
                                    if ($biaya) {
                                        foreach ($biaya as $a) : ?>
                                            <tr>
                                                <td><?= $a->no_lr_sbb ?></td>
                                                <td><?= $a->nama_perkiraan ?></td>
                                                <td class="text-right"><?= number_format($a->nominal) ?></td>
                                            </tr>
                                        <?php
                                        endforeach;
                                    } else { ?>
                                        <tr>
                                            <td colspan="3">Tidak ada data biaya yang ditampilkan.</td>
                                        </tr>
                                    <?php
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="simpanLR">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    Simpan Laba Rugi
                </h4>
            </div>
            <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/simpanLR') ?>">
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