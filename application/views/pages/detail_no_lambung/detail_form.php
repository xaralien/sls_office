<style>
    @media screen and (max-width:991px) {
        table.table.table-bbm {
            width: 1200px !important;
            max-width: none !important;
        }

    }
</style>

<!-- page content -->
<div class="right_col" role="main">
    <!--div class="pull-left">
				<font color='Grey'>Create New E-Memo </font>
			</div-->
    <div class="clearfix"></div>

    <!-- Start content-->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
                <div class="x_title">
                    <div class="row">
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <h2>Create Bbm</h2>
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12" style="text-align: right;">
                            <a class="btn btn-primary" href="<?= base_url('bbm/list') ?>">
                                &lt; Back</a>
                        </div>
                    </div>
                </div>
                <div class="x_content">
                    <?php if ($this->uri->segment(2) == 'ubah_harga_bbm') { ?>
                        <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('bbm/update_harga/') ?>" enctype="multipart/form-data" id="form-bbm">
                            <div class="row" style="margin-bottom: 30px">
                                <!-- <div class="col-md-2 col-sm-4 col-xs-12">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>">
                                </div> -->
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label for="bbm" class="form-label">Harga BBM</label>
                                    <input type="number" class="form-control" name="bbm" id="bbm" value="<?= $bbm['bbm'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-end">
                                    <a href="<?= base_url('bbm/list') ?>" class="btn btn-warning">Back</a>
                                    <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                                </div>
                            </div>
                        </form>
                    <?php } else if (!$this->uri->segment(3)) { ?>
                        <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('bbm/insert') ?>" enctype="multipart/form-data" id="form-bbm">
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label for="metode" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal">
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 30px">
                                <!-- <div class="col-md-2 col-sm-4 col-xs-12">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>">
                                </div> -->
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label for="no_rekening" class="form-label">No. Lambung</label>
                                    <input type="text" class="form-control" name="nomor_lambung" id="nomor_lambung">
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label for="metode" class="form-label">Total Harga</label>
                                    <input type="text" class="form-control" name="total_harga" id="total_harga">
                                </div>
                                <!-- <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label for="metode" class="form-label">Total Liter</label>
                                    <input type="text" class="form-control" name="total_liter" id="total_liter">
                                </div> -->
                                <!-- <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label for="metode" class="form-label">Harga per Liter</label>
                                    <input type="text" class="form-control" name="harga_per_liter" id="harga_per_liter">
                                </div> -->
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-end">
                                    <a href="<?= base_url('bbm/list') ?>" class="btn btn-warning">Back</a>
                                    <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                                </div>
                            </div>
                        </form>
                    <?php } else { ?>
                        <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('bbm/update/' . $this->uri->segment(3)) ?>" enctype="multipart/form-data" id="form-bbm">
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label for="metode" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= $bbm['tanggal'] ?>">
                                </div>
                            </div>
                            <div class="row" style="margin-bottom: 30px">
                                <!-- <div class="col-md-2 col-sm-4 col-xs-12">
                                    <label for="tanggal" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>">
                                </div> -->
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label for="no_rekening" class="form-label">No. Lambung</label>
                                    <input type="text" class="form-control" name="nomor_lambung" id="nomor_lambung" value="<?= $bbm['nomor_lambung'] ?>">
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label for="metode" class="form-label">Total Harga</label>
                                    <input type="text" class="form-control" name="total_harga" id="total_harga" value="<?= $bbm['total_harga'] ?>">
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label for="metode" class="form-label">Total Liter</label>
                                    <input type="text" class="form-control" name="total_liter" id="total_liter" value="<?= $bbm['total_liter'] ?>">
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <label for="metode" class="form-label">Harga per Liter</label>
                                    <input type="text" class="form-control" name="harga_per_liter" id="harga_per_liter" value="<?= $bbm['harga_per_liter'] ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 text-end">
                                    <a href="<?= base_url('bbm/list') ?>" class="btn btn-warning">Back</a>
                                    <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Finish content-->
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
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

        $("button[id='btn-save']").click(function(e) {
            var url = $('form[id="form-bbm"]').attr("action");
            var formData = new FormData($("form#form-bbm")[0]);
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You want to submit the form?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType: "JSON",
                        beforeSend: () => {
                            Swal.fire({
                                title: "Loading....",
                                timerProgressBar: true,
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                            });
                        },
                        success: function(res) {
                            if (res.success) {
                                Swal.fire({
                                    icon: "success",
                                    title: `${res.msg}`,
                                    showConfirmButton: false,
                                    timer: 1500,
                                }).then(function() {
                                    Swal.close();
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: `${res.msg}`,
                                    showConfirmButton: false,
                                    timer: 1500,
                                }).then(function() {
                                    Swal.close();
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: "error",
                                title: `${error}`,
                                showConfirmButton: false,
                                timer: 1500,
                            });
                        },
                    });
                }
            });
        })
    });

    function formatNumber(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function format_angka() {
        var nominal = document.getElementById('input_nominal').value;

        var formattedValue = formatNumber(parseFloat(nominal.split('.').join('')));

        document.getElementById('input_nominal').value = formattedValue;
    }

    const flashdata_error = $(".flash-data-error").data("flashdata");

    if (flashdata_error) {
        Swal.fire({
            title: "Error!! ",
            text: flashdata_error,
            type: "error",
            icon: "error",
        });
    }
</script>
<script>
    $(document).ready(function() {
        updateTotalItem()
        var rowCount = 1; // Inisialisasi row
        $('#addRow').on('click', function() {
            // Periksa apakah ada input yang kosong di baris sebelumnya
            var previousRow = $('.baris').last();
            var inputs = previousRow.find('input[type="text"], input[type="datetime-local"]');
            var isEmpty = false;

            inputs.each(function() {
                if ($(this).val().trim() === '') {
                    isEmpty = true;
                    return false; // Berhenti iterasi jika ditemukan input kosong
                }
            });

            // Jika ada input yang kosong, tampilkan pesan peringatan
            if (isEmpty) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Mohon isi semua input pada baris sebelumnya terlebih dahulu!',
                });
                return; // Hentikan penambahan baris baru
            }

            // Salin baris terakhir
            var newRow = previousRow.clone();

            // Kosongkan nilai input di baris baru
            newRow.find('input').val('');
            newRow.find('input[name="qty[]"]').val('0');
            newRow.find('input[name="harga[]"]').val('0');

            // Perbarui tag <h4> pada baris baru dengan nomor urut yang baru
            rowCount++;

            // Tambahkan baris baru setelah baris terakhir
            previousRow.after(newRow);
        });

        // Saat input qty atau harga diubah
        $(document).on('input', 'input[name="qty[]"], input[name="harga[]"]', function() {
            var value = $(this).val();
            var formattedValue = parseFloat(value.split('.').join(''));
            $(this).val(formattedValue);

            var row = $(this).closest('.baris');
            hitungTotal(row);
            updateTotalItem();
            updateTotal();
        });

        // Tambahkan event listener untuk event keyup
        $(document).on('keyup', 'input[name="qty[]"], input[name="harga[]"]', function() {
            var value = $(this).val().trim(); // Hapus spasi di awal dan akhir nilai
            var formattedValue = formatNumber(parseFloat(value.split('.').join('')));
            $(this).val(formattedValue);
            if (isNaN(value)) { // Jika nilai input kosong
                $(this).val(''); // Atur nilai input menjadi 0
            }
            var row = $(this).closest('.baris');
            hitungTotal(row);
            updateTotalItem();
            updateTotal();
        });

        function hitungTotal(row) {
            var qty = row.find('input[name="qty[]"]').val().replace(/\./g, ''); // Hapus tanda titik
            var harga = row.find('input[name="harga[]"]').val().replace(/\./g, ''); // Hapus tanda titik
            qty = parseInt(qty); // Ubah string ke angka float
            harga = parseInt(harga); // Ubah string ke angka float

            qty = isNaN(qty) ? 0 : qty;
            harga = isNaN(harga) ? 0 : harga;

            var total = qty * harga;
            row.find('input[name="total[]"]').val(formatNumber(total));
            updateTotalItem();
        }

        function updateTotalItem() {
            var total_pos_fix = 0;
            $(".baris").each(function() {
                var total = $(this).find('input[name="total[]"]').val().replace(/\./g, ''); // Ambil nilai total dari setiap baris
                total = parseFloat(total); // Ubah string ke angka float
                if (!isNaN(total)) { // Pastikan total adalah angka
                    total_pos_fix += total; // Tambahkan nilai total ke total_pos_fix
                }
            });
            $('#nominal').val(formatNumber(total_pos_fix)); // Atur nilai input #nominal dengan total_pos_fix
        }

        function formatNumber(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Tambahkan event listener untuk tombol hapus row
        $(document).on('click', '.hapusRow', function() {
            $(this).closest('.baris').remove();
            updateTotalItem(); // Perbarui total belanja setelah menghapus baris
            updateTotal();
        });

        // Saat opsi diskon berubah
        $('#diskon').on('change', function() {
            // Panggil fungsi untuk mengupdate besaran diskon dan total
            updateTotal();
        });
        $('#pajak').on('change', function() {
            // Panggil fungsi untuk mengupdate besaran diskon dan total
            updateTotal();
        });

        // Fungsi untuk mengupdate besaran diskon dan total
        function updateTotal() {
            var diskon = parseFloat($('#diskon').val());
            var pajak = parseFloat($('#pajak').val());
            var subtotal = 0;
            // Hitung subtotal dari total setiap baris
            $('.baris').each(function() {
                var totalBaris = parseInt($(this).find('input[name="total[]"]').val().replace(/\./g, '') || 0);
                subtotal += totalBaris;
            });
            // Hitung besaran diskon
            var besaranDiskon = subtotal * diskon;
            // Hitung total setelah diskon
            var total = subtotal - besaranDiskon;
            var besaranPajak = total * pajak;
            var grandtotal = total + besaranPajak;
            // Atur nilai input besaran_diskon dan total dengan format angka yang sesuai
            $('#besaran_pajak').val(formatNumber(besaranPajak));
            $('#besaran_diskon').val(formatNumber(besaranDiskon));
            $('#grandtotal').val(formatNumber(grandtotal));
        }

        $('#diskonEdit').on('change', function() {
            // Panggil fungsi untuk mengupdate besaran diskon dan total
            updateTotalEdit();
        });

        function updateTotalEdit() {
            var diskon = parseFloat($('#diskonEdit').val());

            var subtotal = parseInt($('#nominal').val().replace(/\./g, '') || 0);

            // Hitung besaran diskon
            var besaranDiskon = subtotal * diskon;
            // Hitung total setelah diskon
            var total = subtotal - besaranDiskon;
            // Atur nilai input besaran_diskon dan total dengan format angka yang sesuai
            $('#besaran_diskon').val(formatNumber(besaranDiskon));
            $('#grandtotal').val(formatNumber(total));
        }

        $('#diskonEdit').on('change', function() {
            // Panggil fungsi untuk mengupdate besaran diskon dan total
            updateTotalEdit();
        });

        function updateTotalEdit() {
            var diskon = parseFloat($('#diskonEdit').val());

            var subtotal = parseInt($('#nominal').val().replace(/\./g, '') || 0);

            // Hitung besaran diskon
            var besaranDiskon = subtotal * diskon;
            // Hitung total setelah diskon
            var total = subtotal - besaranDiskon;
            // Atur nilai input besaran_diskon dan total dengan format angka yang sesuai
            $('#besaran_diskon').val(formatNumber(besaranDiskon));
            $('#grandtotal').val(formatNumber(total));
        }


        $(document).on('input', 'input[name="qty"], input[name="harga"]', function() {
            var value = $(this).val();
            var formattedValue = parseFloat(value.split('.').join(''));
            $(this).val(formattedValue);

            var row = $(this).closest('.baris');
            hitungTotalItem(row);
        });

        function hitungTotalItem(row) {
            var qty = row.find('input[name="qty"]').val().replace(/\./g, ''); // Hapus tanda titik
            var harga = row.find('input[name="harga"]').val().replace(/\./g, ''); // Hapus tanda titik
            qty = parseInt(qty); // Ubah string ke angka float
            harga = parseInt(harga); // Ubah string ke angka float

            qty = isNaN(qty) ? 0 : qty;
            harga = isNaN(harga) ? 0 : harga;

            var total = qty * harga;
            row.find('input[name="harga"]').val(formatNumber(harga));
            row.find('input[name="total"]').val(formatNumber(total));
        }

        $('#addNewRow').on('click', function() {
            // Periksa apakah ada input yang kosong di baris sebelumnya
            var previousRow = $('.barisEdit').last();
            var inputs = previousRow.find('input[type="text"], input[type="datetime-local"]');
            var isEmpty = false;

            inputs.each(function() {
                if ($(this).val().trim() === '') {
                    isEmpty = true;
                    return false; // Berhenti iterasi jika ditemukan input kosong
                }
            });

            // Jika ada input yang kosong, tampilkan pesan peringatan
            if (isEmpty) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Mohon isi semua input pada baris sebelumnya terlebih dahulu!',
                });
                return; // Hentikan penambahan baris baru
            }

            // Salin baris terakhir
            var newRow = previousRow.clone();

            // Kosongkan nilai input di baris baru
            newRow.find('input').val('');
            newRow.find('input[name="newQty[]"]').val('0');
            newRow.find('input[name="newHarga[]"]').val('0');

            // Perbarui tag <h4> pada baris baru dengan nomor urut yang baru
            rowCount++;

            // Tambahkan baris baru setelah baris terakhir
            previousRow.after(newRow);
        });


        $(document).on('click', '.hapusRowAddItem', function() {
            $(this).closest('.barisEdit').remove();
        });

        $(document).on('input', 'input[name="newQty[]"], input[name="newHarga[]"]', function() {
            var value = $(this).val();
            var formattedValue = parseFloat(value.split('.').join(''));
            $(this).val(formattedValue);

            var row = $(this).closest('.barisEdit');
            hitungTotalNewItem(row);
        });

        // Tambahkan event listener untuk event keyup
        $(document).on('keyup', 'input[name="newQty[]"], input[name="newHarga[]"]', function() {
            var value = $(this).val().trim(); // Hapus spasi di awal dan akhir nilai
            var formattedValue = formatNumber(parseFloat(value.split('.').join('')));
            $(this).val(formattedValue);
            if (isNaN(value)) { // Jika nilai input kosong
                $(this).val(''); // Atur nilai input menjadi 0
            }
            var row = $(this).closest('.barisEdit');
            hitungTotalNewItem(row);
        });

        function hitungTotalNewItem(row) {
            var qty = row.find('input[name="newQty[]"]').val().replace(/\./g, ''); // Hapus tanda titik
            var harga = row.find('input[name="newHarga[]"]').val().replace(/\./g, ''); // Hapus tanda titik
            qty = parseInt(qty); // Ubah string ke angka float
            harga = parseInt(harga); // Ubah string ke angka float

            qty = isNaN(qty) ? 1 : qty;
            harga = isNaN(harga) ? 0 : harga;

            var total = qty * harga;
            row.find('input[name="newTotal[]"]').val(formatNumber(total));
        }
    });
</script>
<script>
    $(function() {
        function initializeAutocomplete() {
            $(".autocomplete").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "<?php echo site_url('financial/autocomplete'); ?>",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                minLength: 2,

                select: function(event, ui) {
                    var $row = $(this).closest('tr.baris');
                    var harga = ui.item.harga;
                    var formattedValue = (parseInt(ui.item.harga.split('.').join('')));

                    $row.find('input[name="id_item[]"]').val(ui.item.id_item);
                    $row.find('input[name="harga[]"]').val(formatNumber(Math.round(harga)));
                }
            });
        }
    });
</script>


</body>

</html>