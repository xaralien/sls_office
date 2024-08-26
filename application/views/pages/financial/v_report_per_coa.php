<div class="right_col" role="main">
    <div class="clearfix"></div>

    <!-- Start content-->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
                <!-- <div class="x_title">
                    <h2>Tabel</h2>

                </div> -->
                <div class="x_content">
                    <?php
                    if ($this->input->post('no_coa')) { ?>
                        <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/coa_report') ?>">
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group">
                                    <label for="" class="form-label">No. CoA</label>
                                    <select name="no_coa" id="no_coa" class="form-control select2" style="width: 100%;">
                                        <option value="">:: Pilih nomor coa</option>
                                        <?php
                                        foreach ($coas as $c) {
                                        ?>
                                            <option <?= ($this->input->post('no_coa') == $c->no_sbb) ? "selected" : "" ?> value="<?= $c->no_sbb ?>"><?= $c->no_sbb ?> - <?= $c->nama_perkiraan ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <label for="tgl_dari" class="form-label">Dari</label>
                                <input type="date" class="form-control" name="tgl_dari" value="<?= $this->input->post('tgl_dari') ?>">
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <label for="tgl_sampai" class="form-label">Sampai</label>
                                <input type="date" class="form-control" name="tgl_sampai" value="<?= $this->input->post('tgl_sampai') ?>">
                            </div>
                            <div class="col-md-1 col-xs-12">
                                <button type="submit" class="btn btn-primary" style="margin-top: 24px;">Lihat</button>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table id="" class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-right" colspan="2">Total:</th>
                                        <th class="text-right"><?= number_format($sum_debit) ?></th>
                                        <th class="text-right"><?= number_format($sum_kredit) ?></th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Tanggal</th>
                                        <th class="text-center">Debit</th>
                                        <th class="text-center">Kredit</th>
                                        <th class="text-center">Saldo Akhir</th>
                                        <th class="text-center">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($coa as $a) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= format_indo($a->tanggal) ?></td>
                                            <!-- <td><?= ($a->akun_debit == $detail_coa['no_sbb']) ? $a->akun_debit : $a->akun_kredit ?></td> -->
                                            <td class="text-right"><?= ($a->akun_debit == $detail_coa['no_sbb']) ? (($a->jumlah_debit) ? number_format($a->jumlah_debit) : '0') : '0' ?></td>
                                            <!-- <td class="text-right"><?= ($a->akun_debit == $detail_coa['no_sbb']) ? (($a->saldo_debit) ? number_format($a->saldo_debit) : '0') : '0' ?></td> -->
                                            <td class="text-right"><?= ($a->akun_kredit == $detail_coa['no_sbb']) ? (($a->jumlah_kredit) ? number_format($a->jumlah_kredit) : '0') : '0' ?></td>
                                            <!-- <td class="text-right"><?= ($a->akun_kredit == $detail_coa['no_sbb']) ? (($a->saldo_kredit) ? number_format($a->saldo_kredit) : '0') : '0' ?></td> -->
                                            <td class="text-right"><?= ($a->akun_kredit == $detail_coa['no_sbb']) ? (($a->saldo_kredit) ? number_format($a->saldo_kredit) :  '0') : (($a->saldo_debit) ? number_format($a->saldo_debit) : '0') ?></td>
                                            <td style="white-space: pre-line;"><?= $a->keterangan ?></td>
                                        </tr>
                                    <?php
                                    endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="row">

                            <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/coa_report') ?>">
                                <div class="col-md-5 col-xs-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">No. CoA </label>
                                        <select name="no_coa" id="no_coa" class="form-control select2" style="width: 100%;">
                                            <option value="">:: Pilih nomor coa</option>
                                            <?php
                                            foreach ($coas as $c) {
                                            ?>
                                                <option value="<?= $c->no_sbb ?>"><?= $c->no_sbb ?> - <?= $c->nama_perkiraan ?></option>
                                            <?php
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <label for="tgl_invoice" class="form-label">Dari</label>
                                    <input type="date" class="form-control" name="tgl_dari" value="">
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <label for="tgl_invoice" class="form-label">Sampai</label>
                                    <input type="date" class="form-control" name="tgl_sampai" value="<?= date('Y-m-d') ?>">
                                </div>
                                <div class="col-md-1 col-xs-12">
                                    <button type="submit" class="btn btn-primary" style="margin-top: 24px;">Lihat</button>
                                </div>
                            </form>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <h4>Tidak ada nomor coa yang dipilih</h4>
                            </div>
                        </div> -->
                    <?php
                    } ?>
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