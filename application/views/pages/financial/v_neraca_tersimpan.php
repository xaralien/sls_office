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
                    <h2>Neraca tersimpan</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button class="btn btn-primary" onclick="document.location='<?= base_url('financial/showReport') ?>'">Neraca L/R</button>
                        </li>
                    </ul>
                </div>
                <div class="x_content">
                    <div class="table-responsive">
                        <table id="" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kode</th>
                                    <th>Tanggal simpan</th>
                                    <th>Keterangan</th>
                                    <th>User</th>
                                    <!-- <th>Cetak</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($neraca) {
                                    $no = 1;
                                    foreach ($neraca as $i) : ?>
                                        <tr>
                                            <td><?= $no++ ?>.</td>
                                            <td><a href="<?= base_url('financial/showNeracaTersimpan/' . $i['slug']) ?>"><?= $i['slug'] ?></a></td>
                                            <td><?= format_indo($i['tanggal_simpan']) ?></td>
                                            <td style="white-space: pre-line;"><?= ($i['keterangan']) ?></td>
                                            <td><?= isset($i['created_by_name']) ? $i['created_by_name'] : 'N/A' ?></td>
                                            <!-- <td>
                                                <a href="<?= base_url('financial/showNeracaTersimpan/' . $i['slug'] . '/print') ?>" class="btn btn-success btn-xs"><i class="fa fa-print"></i> Cetak</a>
                                            </td> -->
                                        </tr>

                                    <?php
                                    endforeach;
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="5">Tidak ada data yang ditampilkan</td>
                                    </tr>
                                <?php
                                } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-xs-12">
                            <h6>*klik kode untuk lihat neraca tersimpan</h6>
                        </div>
                        <div class="col-md-6 col-xs-12 text-right">
                            <?= $this->pagination->create_links() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>