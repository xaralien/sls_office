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

    .select2-container .select2-dropdown .select2-results__option {
        text-align: left;
        /* Pastikan opsi dropdown rata kiri */
    }

    .input-group .form-control {
        width: auto;
        /* Allow the form controls to adjust width within the input group */
        flex: 1 1 auto;
        /* Flex-grow to fill available space */
    }

    .input-group select.form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        padding-right: 30px;
        /* Adjust the padding as needed */
    }

    .input-group .input-group-btn .btn {
        /* border-radius: 0; */
    }
</style>
<div class="right_col" role="main">
    <div class="clearfix"></div>

    <!-- Start content-->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
                <!-- <div class="x_title">
                    <h2>Invoices</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button class="btn btn-primary" onclick="document.location='<?= base_url('financial/create_invoice') ?>'">Create Invoice</button>
                        </li>
                    </ul>
                </div> -->
                <div class="x_content">
                    <div class="row">
                        <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/invoice') ?>">
                            <div class="col-md-3 col-xs-12">

                                <div class="form-group">
                                    <select name="customer_id" id="customer_id" class="form-control">
                                        <option value="">:: Semua customer</option>
                                        <?php
                                        foreach ($customers as $c) :
                                        ?>
                                            <option <?= ($this->input->post('customer_id') == $c->id) ? "selected" : "" ?> value="<?= $c->id ?>"><?= $c->nama_customer ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5 col-xs-12">
                                <div class="form-group">
                                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Masukkan nomor invoice">
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-12">
                                <button type="submit" class="btn btn-success">Cari</button>
                                <a href="<?= base_url('financial/invoice') ?>" class="btn btn-warning">Reset</a>
                            </div>
                            <div class="col-md-2 col-xs-12 text-right">
                                <a href="<?= base_url('financial/create_invoice') ?>" class="btn btn-primary">Create Invoice</a>
                            </div>
                        </form>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Tanggal</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>User</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($invoices) {
                                    foreach ($invoices as $i) :
                                        $month = substr($i['tanggal_invoice'], 5, 2);
                                        $year = substr($i['tanggal_invoice'], 0, 4); ?>
                                        <tr>

                                            <td><a href="<?= base_url('financial/show/' . $i['no_invoice']) ?>"><?= $i['no_invoice'] ?>/SLS/INV-GMG/<?= intToRoman($month) ?>/<?= $year ?></a></td>
                                            <td><?= format_indo($i['tanggal_invoice']) ?></td>
                                            <td><?= $i['nama_customer'] ?></td>
                                            <td class="text-right"><?= number_format($i['total_nonpph'], 0) ?></td>
                                            <td><?= isset($i['created_by_name']) ? $i['created_by_name'] : 'N/A' ?></td>
                                            <!-- <td><?= ($i['status_bayar'] == "1") ? "Sudah dibayar" : "Belum dibayar" ?></td> -->
                                            <td>
                                                <a href="<?= base_url('financial/print_invoice/' . $i['no_invoice']) ?>" class="badge bg-orange" target="_blank" style="vertical-align: top;">
                                                    Cetak
                                                </a>
                                                <?php
                                                if ($i['status_void'] == "1") {
                                                ?>
                                                    <span class="badge bg-red" data-toggle="tooltip" data-placement="right" title="" data-original-title="Alasan: <?= $i['alasan_void'] ?>">Sudah divoid</span>
                                                <?php
                                                }

                                                if ($i['status_bayar'] == "1") {
                                                ?>
                                                    <span class="badge bg-green">Sudah dibayar</span>
                                                <?php
                                                }

                                                if ($i['status_bayar'] == "0" and $i['status_void'] != "1") {
                                                    $piutang = $i['total_denganpph'] - $i['total_termin']; ?>
                                                    <!-- <?php
                                                            if ($i['status_void'] == '0') {
                                                            } ?>
                                                            <button class="badge bg-red" data-toggle="modal" data-target="#void<?= $i['Id'] ?>">Void</button> -->
                                                    <button class="badge bg-blue" data-toggle="modal" data-target="#modal<?= $i['Id'] ?>">Bayar</button>

                                                    <div class="modal fade" id="modal<?= $i['Id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel">
                                                                        <?= $i['no_invoice'] ?>
                                                                    </h4>
                                                                </div>
                                                                <form action="<?= base_url('financial/paid/' . $i['no_invoice']) ?>" method="post">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-4 col-xs-12">
                                                                                <div class="form-group">
                                                                                    <label for="nominal_invoice" class="form-label">Nominal Invoice</label>
                                                                                    <input type="text" name="nominal_invoice" id="nominal_invoice<?= $i['Id'] ?>" class="form-control" value="<?= number_format($i['total_denganpph']) ?>" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4 col-xs-12">
                                                                                <div class="form-group">
                                                                                    <label for="piutang" class="form-label">Belum bayar</label>
                                                                                    <input type="text" name="piutang" id="piutang<?= $i['Id'] ?>" class="form-control" value="<?= number_format($piutang) ?>" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4 col-xs-12">
                                                                                <div class="form-group">
                                                                                    <label for="nominal_bayar" class="form-label">Nominal bayar</label>
                                                                                    <input type="text" name="nominal_bayar" id="nominal_bayar<?= $i['Id'] ?>" class="form-control" value="<?= number_format(($i['opsi_termin'] == 0) ? $piutang : '0', 0, ',', '.') ?>" <?= ($i['opsi_termin'] == 0) ? 'readonly' : '' ?> required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group">
                                                                                    <label for="no_coa" class="form-label">CoA Kas</label>
                                                                                    <select name="no_coa" id="no_coa<?= $i['Id'] ?>" class="form-control select2" style="width: 100%" required>
                                                                                        <option value="">:: Pilih CoA Kas</option>
                                                                                        <?php
                                                                                        foreach ($coa_kas as $c) :
                                                                                        ?>
                                                                                            <option value="<?= $c->no_sbb ?>"><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?></option>
                                                                                        <?php
                                                                                        endforeach; ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6 col-xs-12">
                                                                                <div class="form-group">
                                                                                    <label for="coa_pendapatan" class="form-label">CoA Kas</label>
                                                                                    <select name="coa_pendapatan" id="no_coa<?= $i['Id'] ?>" class="form-control select2" style="width: 100%" required>
                                                                                        <option value="">:: Pilih CoA Pendapatan</option>
                                                                                        <?php
                                                                                        foreach ($coa_pendapatan as $cp) :
                                                                                        ?>
                                                                                            <option value="<?= $cp->no_sbb ?>"><?= $cp->no_sbb . ' - ' . $cp->nama_perkiraan ?></option>
                                                                                        <?php
                                                                                        endforeach; ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-4 col-xs-12">
                                                                                <div class="form-group">
                                                                                    <label for="tanggal_bayar" class="form-label">Tanggal bayar</label>
                                                                                    <input type="date" name="tanggal_bayar" id="tanggal_bayar" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-2 col-xs-12">
                                                                                <div class="form-group">
                                                                                    <label for="Lunas" class="form-label">Lunas</label>
                                                                                    <div class="checkbox text-end">
                                                                                        <input type="checkbox" class="flat" name="status_bayar" id="status_bayar<?= $i['Id'] ?>" value="1" <?= ($i['opsi_termin'] == 0) ? 'checked ' : '' ?>> Ya
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-12 col-xs-12">
                                                                                <div class="form-group">
                                                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                                                    <textarea name="keterangan" id="keterangan" class="form-control" oninput="this.value = this.value.toUpperCase()" required></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                            Close
                                                                        </button>
                                                                        <button type="submit" class="btn btn-primary">
                                                                            Process
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="void<?= $i['Id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel">
                                                                        <?= $i['no_invoice'] ?>
                                                                    </h4>
                                                                </div>
                                                                <form action="<?= base_url('financial/void_invoice/' . $i['no_invoice']) ?>" method="post">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-sm-12 col-xs-12">
                                                                                <div class="form-group">
                                                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                                                    <textarea name="keterangan" id="keterangan" class="form-control" oninput="this.value = this.value.toUpperCase()" required></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                            Close
                                                                        </button>
                                                                        <button type="submit" class="btn btn-primary">
                                                                            Process
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                } ?>
                                            </td>
                                        </tr>

                                    <?php
                                    endforeach;
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="7">Tidak ada data yang ditampilkan</td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>*klik nomor invoice untuk lihat detail invoice</h6>
                        </div>
                        <div class="col-md-6 text-right">
                            <?= $this->pagination->create_links() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/vendors/jquery/dist/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="<?= base_url(); ?>assets/select2/css/select2.min.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/select2/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('.select3').select2();
    })
</script>