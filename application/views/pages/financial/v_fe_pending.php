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
                        <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/fe_pending') ?>">
                            <!-- <div class="col-md-2">
                                <h2>Invoices</h2>
                            </div> -->
                            <div class="col-md-5 col-12">
                                <div class="form-group">
                                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Masukkan nomor FE / keterangan">
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <button type="submit" class="btn btn-success">Cari</button>
                                <a href="<?= base_url('financial/fe_pending') ?>" class="btn btn-warning">Reset</a>
                            </div>
                        </form>
                        <div class="col-md-1"></div>
                    </div>
                    <table id="datatable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>User input</th>
                                <th>Nominal</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($fes) {
                                foreach ($fes as $i) :
                                    $status = ($i['status_approval'] == '0') ? "Butuh persetujuan" : (($i['status_approval'] == '1' ? "Disetujui" : "Ditolak"));
                                    $bg = ($i['status_approval'] == '0') ? "bg-blue" : (($i['status_approval'] == '1' ? "bg-green" : "bg-red")); ?>
                                    <tr>
                                        <td><a href="<?= base_url('financial/show/' . $i['slug']) ?>"><?= $i['slug'] ?></a></td>
                                        <td><?= format_indo($i['tanggal_transaksi']) ?></td>
                                        <td><?= isset($i['created_by_name']) ? $i['created_by_name'] : 'N/A' ?></td>
                                        <td class="text-right"><?= number_format($i['nominal'], 0) ?></td>
                                        <td><?= $i['keterangan'] ?></td>
                                        <td>
                                            <?php
                                            if ($i['status_approval'] == '0') {
                                            ?>
                                                <button href="#" class="badge bg-green btn-process" data-url="<?= base_url('financial/approve_fe/' . $i['slug']) ?>">Setujui</button>
                                                <button class="badge bg-red" data-toggle="modal" data-target="#reject<?= $i['Id'] ?>">Tolak</button>
                                            <?php
                                            } else if ($i['status_approval'] == '1') {
                                            ?>
                                                <span class="badge bg-green">Disetujui</span>
                                            <?php
                                            } else if ($i['status_approval'] == '2') {
                                            ?>
                                                <span class="badge bg-red" data-toggle="tooltip" data-placement="right" title="<?= $i['alasan_ditolak'] ?>">Ditolak</span>
                                            <?php
                                            } ?>

                                            <button class="badge bg-blue" data-toggle="modal" data-target="#modal<?= $i['Id'] ?>">Lihat</button>
                                            <div class="modal fade" id="modal<?= $i['Id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                <?= $i['slug'] ?>
                                                            </h4>
                                                        </div>
                                                        <!-- <form action="<?= base_url('financial/approve/' . $i['slug']) ?>" method="post"> -->
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="no_coa" class="form-label">CoA Debit</label>
                                                                        <select name="no_coa" id="no_coa<?= $i['Id'] ?>" class="form-control" style="" required>
                                                                            <!-- <option value="">:: Pilih CoA Debit</option> -->
                                                                            <?php
                                                                            foreach ($coa as $c) :
                                                                                if ($i['coa_debit'] == $c->no_sbb) {
                                                                            ?>
                                                                                    <option value="<?= $c->no_sbb ?>" selected><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                                <!-- <option <?= ($i['coa_debit'] == $c->no_sbb) ? "selected" : "" ?> value="<?= $c->no_sbb ?>"><?= $c->no_sbb . ' - ' . $c->nama_perkiraan ?></option> -->
                                                                            <?php
                                                                            endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="coa_pendapatan" class="form-label">CoA Kredit</label>
                                                                        <select name="coa_pendapatan" id="no_coa<?= $i['Id'] ?>" class="form-control" style="" required>
                                                                            <!-- <option value="">:: Pilih CoA Kredit</option> -->
                                                                            <?php
                                                                            foreach ($coa as $cp) :
                                                                                if ($i['coa_kredit'] == $cp->no_sbb) {
                                                                            ?>
                                                                                    <option value="<?= $cp->no_sbb ?>" selected><?= $cp->no_sbb . ' - ' . $cp->nama_perkiraan ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                                <!-- <option <?= ($i['coa_kredit'] == $cp->no_sbb) ? "selected" : "" ?> value="<?= $cp->no_sbb ?>"><?= $cp->no_sbb . ' - ' . $cp->nama_perkiraan ?></option> -->
                                                                            <?php
                                                                            endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="nominal_invoice" class="form-label">Nominal invoice</label>
                                                                        <input type="text" name="nominal_invoice" id="nominal_invoice<?= $i['Id'] ?>" class="form-control" value="<?= number_format($i['nominal']) ?>" readonly>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 col-12">
                                                                    <div class="form-group">
                                                                        <label for="tanggal_transaksi" class="form-label">Tanggal transaksi</label>
                                                                        <input type="date" name="tanggal_transaksi" id="tanggal_transaksi" class="form-control" value="<?= $i['tanggal_transaksi'] ?>">
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="keterangan" class="form-label">Keterangan</label>
                                                                        <textarea name="keterangan" id="keterangan" class="form-control" oninput="this.value = this.value.toUpperCase()" required><?= $i['keterangan'] ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-12">
                                                                    <div class="form-group">
                                                                        <label for="lampiran" class="form-label">Lampiran</label>
                                                                        <p>
                                                                            <?= ($i['file_path']) ? '<a href="' . base_url($i['file_path']) . '">' . $i['slug'] . '</a>' : 'Tidak ada' ?>
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-12 col-12">
                                                                    <?php
                                                                    if ($i['status_approval'] == '1') {
                                                                    ?>
                                                                        <span class="badge bg-green">Disetujui</span>
                                                                    <?php
                                                                    } else if ($i['status_approval'] == '2') {
                                                                    ?>
                                                                        <span class="badge bg-red" data-toggle="tooltip" data-placement="right" title="<?= $i['alasan_ditolak'] ?>">Ditolak</span>
                                                                    <?php
                                                                    }  ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <?php
                                                            if ($i['status_approval'] == '0') {
                                                            ?>
                                                                <button href="#" class="btn bg-green btn-process" data-url="<?= base_url('financial/approve_fe/' . $i['slug']) ?>">Setujui</button>
                                                                <div class="btn btn-danger" data-toggle="modal" data-target="#reject<?= $i['Id'] ?>">Tolak</div>
                                                            <?php
                                                            } ?>
                                                        </div>
                                                        <!-- </form> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="reject<?= $i['Id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel">
                                                                <?= $i['slug'] ?>
                                                            </h4>
                                                        </div>
                                                        <form action="<?= base_url('financial/reject_fe/' . $i['slug']) ?>" method="post">
                                                            <div class="modal-body">
                                                                <div class="row">

                                                                    <div class="col-sm-12 col-12">
                                                                        <div class="form-group">
                                                                            <label for="alasan_ditolak" class="form-label">Alasan ditolak</label>
                                                                            <textarea name="alasan_ditolak" id="alasan_ditolak" class="form-control" oninput="this.value = this.value.toUpperCase()" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit" class="btn btn-danger">
                                                                    Tolak
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <?= $this->pagination->create_links() ?>
                        </div>
                    </div>
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
        $('.select3').select2();
    })

    const flashdata = $(".flash-data").data("flashdata");
    if (flashdata) {
        Swal.fire({
            title: "Success!! ",
            text: '<?= $this->session->flashdata('message_name') ?>',
            type: "success",
            icon: "success",
        });
    }
    // const flashdata_error = $('<?= $this->session->flashdata("message_error") ?>').data("flashdata");
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
    // $(document).ready(function() {
    $(".btn-process").on("click", function(e) {
        e.preventDefault();
        const url = $(this).data("url");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, process it!",
        }).then((result) => {
            if (result.isConfirmed) {
                document.location.href = url;
            }
        });
    });
    // });
</script>