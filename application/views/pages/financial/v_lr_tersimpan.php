<div class="right_col" role="main">
    <div class="clearfix"></div>

    <!-- Start content-->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
                <div class="x_title">
                    <h2>Laba rugi tersimpan</h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li>
                            <button class="btn btn-primary" onclick="document.location='<?= base_url('financial/showReport') ?>'">Neraca L/R</button>
                        </li>
                    </ul>
                </div>
                <div class="x_content">
                    <table id="datatable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Tanggal simpan</th>
                                <th>Keterangan</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($neraca) {
                                $no = 1;
                                foreach ($neraca as $i) : ?>
                                    <tr>
                                        <td><?= $no++ ?>.</td>
                                        <td><a href="<?= base_url('financial/showLRTersimpan/' . $i['slug']) ?>"><?= $i['slug'] ?></a></td>
                                        <td><?= format_indo($i['tanggal_simpan']) ?></td>
                                        <td style="white-space: pre-line;"><?= ($i['keterangan']) ?></td>
                                        <td><?= isset($i['created_by_name']) ? $i['created_by_name'] : 'N/A' ?></td>
                                    </tr>

                                <?php
                                endforeach;
                            } else {
                                ?>
                                <tr>
                                    <td colspan="3">Tidak ada data yang ditampilkan</td>
                                </tr>
                            <?php
                            } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>*klik kode untuk lihat L/R tersimpan</h6>
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