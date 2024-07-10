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
                <div class="x_title">
                    <h2>Customer Invoice</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahCustomer">
                                Tambah
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="x_content">
                    <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Status</th>
                                <!-- <th>Aksi</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($customers) {
                                foreach ($customers as $i) : ?>
                                    <tr>
                                        <td><?= $i->nama_customer ?></td>
                                        <td style="white-space: pre-line;"><?= $i->alamat_customer ?></td>
                                        <td><?= ucfirst($i->status_customer) ?></td>
                                        <!-- <td> -->
                                        <!-- <a href="<?= base_url('financial/print_invoice/' . $i->id) ?>" class="btn btn-info btn-sm" target="_blank">
                                                            <i class="fa fa-file-pdf-o"></i>
                                                        </a> -->
                                        <!-- </td> -->
                                    </tr>

                                <?php
                                endforeach;
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">Tidak ada data yang ditampilkan</td>
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="tambahCustomer">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    Tambah customer
                </h4>
            </div>
            <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('customer/store') ?>">
                <div class="modal-body">
                    <div class="form-group row" style="display: none;">
                        <div class="col-12">
                            <label for="no_invoice" class="form-label">Jenis jurnal</label>
                            <select name="status_customer" id="status_customer" class="form-control">
                                <!-- <option value="">:: Pilih jenis customer</option> -->
                                <option value="reguler" selected>Reguler</option>
                                <!-- <option value="khusus">Khusus</option> -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="nama_customer" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama_customer" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="alamat_customer" class="form-label">Alamat</label>
                            <textarea name="alamat_customer" id="alamat_customer" class="form-control" placeholder="Masukkan alamat customer..."></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="telepon_customer" class="form-label">No. Kontak</label>
                            <input type="text" class="form-control" name="telepon_customer" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="no_npwp" class="form-label">No. NPWP</label>
                            <input type="text" class="form-control" name="no_npwp" value="">
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