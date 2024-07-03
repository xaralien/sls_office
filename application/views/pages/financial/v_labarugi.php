<div class="right_col" role="main">
    <div class="clearfix"></div>

    <!-- Start content-->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
                <div class="x_title">
                    <h2>Tabel</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <form method="post" action="<?php echo base_url('financial/simpanLR'); ?>">
                                <button type="submit" class="btn btn-primary" name="simpan_lr" value="1">Simpan LR</button>
                            </form>
                            <!-- <button type="button" id="simpan_neraca" class="btn btn-primary">Simpan Neraca</button> -->
                        </li>
                    </ul>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <h5>
                                <?php
                                $total_pendapatan = $sum_pendapatan - $sum_biaya; ?>
                                Laba berjalan: <strong>Rp <?= number_format($total_pendapatan) ?></strong>
                            </h5>
                        </div>
                        <div class="col-md-6 col-12">
                            <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/showReport') ?>">

                                <div class="form-group row">
                                    <!-- <div class="input-group"> -->
                                    <select name="jenis_laporan" id="jenis_laporan" class="form-control" onchange="this.form.submit()">
                                        <option <?= ($this->input->post('jenis_laporan') == "neraca") ? "selected" : "" ?> value="neraca">Neraca</option>
                                        <option <?= ($this->input->post('jenis_laporan') == "laba_rugi") ? "selected" : "" ?> value="laba_rugi">Laba Rugi</option>
                                        <!-- <option <?= ($this->input->post('jenis_laporan') == "invoice_nol") ? "selected" : "" ?> value="invoice_nol">Invoice Nol</option> -->
                                    </select>
                                    <!-- <span class="input-group-btn">
                                                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                                                    </span> -->
                                    <!-- </div> -->
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="row justify-content-between">
                                <h2 class="text-center">Pendapatan</h2>
                                <p class="text-right">Total: <strong><?= number_format($sum_pendapatan) ?></strong></p>
                            </div>
                            <table id="datatable" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Coa</th>
                                        <th>Nama Coa</th>
                                        <th>Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($pendapatan as $p) :
                                    ?>
                                        <tr>
                                            <td><?= $p->no_lr_sbb ?></td>
                                            <td><?= $p->nama_perkiraan ?></td>
                                            <td class="text-right"><?= number_format($p->nominal) ?></td>
                                        </tr>
                                    <?php
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6 col-12">
                            <h2 class="text-center">Biaya</h2>
                            <p class="text-right">Total: <strong><?= number_format($sum_biaya) ?></strong></p>
                            <table id="datatable" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No. Coa</th>
                                        <th>Nama Coa</th>
                                        <th>Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($biaya as $a) :
                                    ?>
                                        <tr>
                                            <td><?= $a->no_lr_sbb ?></td>
                                            <td><?= $a->nama_perkiraan ?></td>
                                            <td class="text-right"><?= number_format($a->nominal) ?></td>
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