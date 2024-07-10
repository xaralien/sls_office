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
                </div>
                <div class="x_content">
                    <table id="datatable" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal simpan</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($neraca) {
                                $no = 1;
                                foreach ($neraca as $i) : ?>
                                    <tr>
                                        <td><a href="<?= base_url('financial/showLRTersimpan/' . $i['Id']) ?>"><?= $no++ ?>.</a></td>
                                        <td><a href="<?= base_url('financial/showLRTersimpan/' . $i['Id']) ?>"><?= format_indo($i['tanggal_simpan']) ?></a></td>
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