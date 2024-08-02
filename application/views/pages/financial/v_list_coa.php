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
    <div class="page-title">
        <!-- <div class="title_left" style="width: 30%;">
            <h3>List of CoA</h3>
        </div> -->

        <div class="title_right" style="width: 100%;">
            <div class="col-md-12 col-sm-12 form-group pull-right top_search">
                <form class="form-horizontal form-label-left" method="post" action="<?= base_url('financial/list_coa') ?>">
                    <div class="input-group">
                        <input type="text" class="form-control" name="keyword" placeholder="Search for..." value="<?= $keyword ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-secondary" type="submit">Go!</button>
                            <a href="<?= base_url('financial/reset/coa') ?>" class="btn btn-warning" style="color:white;">Reset</a>
                            <button class="btn btn-primary text-white" data-toggle="modal" data-target="#tambahCoa" type="button" style="color: white;">Tambah CoA</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <!-- Start content-->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
                <div class="x_content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>BB</th>
                                    <th>Sub BB</th>
                                    <th>Nama Perkiraan</th>
                                    <th class="text-center">Nominal</th>
                                    <!-- <th class="text-center">Aksi</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($coa) {
                                    $no = ($this->uri->segment(3)) ? ((($this->uri->segment(3) - 1) * 10) + 1) : '1';

                                    foreach ($coa as $i) : ?>
                                        <tr>
                                            <td><?= $no++ ?>.</td>
                                            <td><?= $i['no_bb'] ?></td>
                                            <td><?= $i['no_sbb'] ?></td>
                                            <td><?= ($i['nama_perkiraan']) ?></td>
                                            <td class="text-right"><?= number_format($i['nominal']) ?></td>
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
                        <div class="col-md-6">
                            <h6>*klik kode untuk lihat neraca tersimpan</h6>
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="tambahCoa">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    Tambah CoA Baru
                </h4>
            </div>
            <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/tambahCoa') ?>">
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-12">
                            <label for="no_bb" class="form-label">No. BB</label>
                            <input type="text" name="no_bb" id="no_bb" class="form-control">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="no_sbb" class="form-label">No. SBB</label>
                            <input type="text" name="no_sbb" id="no_sbb" class="form-control">
                        </div>
                        <div class="col-12 mt-3">
                            <label for="nama_coa" class="form-label">Nama CoA</label>
                            <input type="text" name="nama_coa" id="nama_coa" class="form-control" oninput="this.value = this.value.toUpperCase()">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
                        Tambah CoA
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>