<div class="right_col" role="main">
    <div class="clearfix"></div>

    <!-- Start content-->
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel card">
                <div class="x_title">
                    <h2>Create Invoice</h2>
                </div>
                <div class="x_content">
                    <form class="form-horizontal form-label-left" method="POST" action="<?= base_url('financial/store_invoice') ?>">
                        <div class="form-group row">
                            <div class="col-md-2 col-12">
                                <label for="no_invoice" class="form-label">Number</label>
                                <input type="text" class="form-control" name="no_invoice" value="<?= $no_invoice ?>" readonly>
                            </div>
                            <div class="col-md-3 col-12">
                                <label for="tgl_invoice" class="form-label">Date</label>
                                <input type="date" class="form-control" name="tgl_invoice" value="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-4 col-12">
                                <label for="customer" class="form-label">Bill to</label>
                                <select name="customer" id="customer" class="form-control select2" style="width: 100%" required>
                                    <option value="">:: Pilih customer</option>
                                    <?php
                                    foreach ($customers as $c) : ?>
                                        <option value="<?= $c->id ?>"><?= $c->nama_customer ?></option>
                                    <?php
                                    endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2 col-12" style="display: none">
                                <label for="ppn" class="form-label">PPN</label>
                                <select name="ppn" id="ppn" class="form-control">
                                    <option value="0.11">11%</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-8 col-12">
                                <label for="keterangan" class="form-label">Notes</label>
                                <!-- <input name="keterangan" id="keterangan" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="Enter notes here..." required> -->
                                <textarea name="keterangan" id="keterangan" class="form-control" oninput="this.value = this.value.toUpperCase()" placeholder="Enter notes here" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row" style="display: none;">
                            <div class="col-md-2 col-12">
                                <label for="nominal" class="form-label">Subtotal</label>
                                <!-- <input type="text" class="form-control" name="nominal" id="nominal" value="0" readonly> -->
                            </div>
                            <div class="col-md-2 col-12">
                                <label for="biaya_loading" class="form-label">Biaya Loading</label>
                                <!-- <input type="text" class="form-control" name="biaya_loading" id="biaya_loading" value="0"> -->
                            </div>
                            <div class="col-md-2 col-12">
                                <label for="bruto" class="form-label">Bruto</label>
                                <!-- <input type="text" class="form-control" name="bruto" id="bruto" value="0" readonly> -->
                            </div>
                            <div class="col-md-2 col-12">
                                <label for="besaran_ppn" class="form-label">PPN</label>
                                <!-- <input type="text" class="form-control" name="besaran_ppn" id="besaran_ppn" value="0" readonly> -->
                            </div>
                            <div class="col-md-2 col-12">
                                <label for="besaran_pph" class="form-label">PPh 23</label>
                                <!-- <input type="text" class="form-control" name="besaran_pph" id="besaran_pph" value="0" readonly> -->
                            </div>
                            <div class="col-md-2 col-12" style="display: none;">
                                <label for="total_nonpph" class="form-label">Total (non PPh)</label>
                                <input type="text" class="form-control" name="total_nonpph" id="total_nonpph" value="0" readonly>
                            </div>
                            <div class="col-md-2 col-12">
                                <label for="total_denganpph" class="form-label">Total</label>
                            </div>
                            <div class="col-md-2 col-12" style="display: none;">
                                <label for="total_denganpph" class="form-label">Pendapatan</label>
                                <input type="text" class="form-control" name="nominal_pendapatan" id="nominal_pendapatan" value="0" readonly>
                            </div>
                            <div class="col-md-2 col-12" style="display: none;">
                                <label for="nominal_bayar" class="form-label">Nominal bayar</label>
                                <input type="text" class="form-control" name="nominal_bayar" id="nominal_bayar" value="0" readonly>
                            </div>
                        </div>
                        <div class="form-group row justify-content-end" style="display: none;">
                            <div class="col-md-9 d-none"></div>
                            <div class="col-md-1 col-12">
                                <label for="termin" class="form-label">Termin</label>
                                <div class="checkbox text-end">
                                    <!-- <input type="checkbox" class="icheckbox_flat-green" style="margin-left: 0px;" name="opsi_termin" value="1"> -->
                                </div>
                            </div>
                            <div class="col-md-2 col-12 text-right">
                                <label for="keterangan" class="form-label">&nbsp;</label>
                                <div class="mt-2">
                                    <!-- <a href="<?= base_url('financial/invoice') ?>" class="btn btn-sm btn-warning"><i class="bi bi-arrow-return-left"></i> Back</a>
                                    <button type="submit" class="btn btn-primary btn-sm">Save <i class="bi bi-save"></i></button> -->
                                </div>
                            </div>
                        </div>
                        <table class="table mt-5 table-responsive">
                            <thead>
                                <tr>
                                    <!-- <th>Tgl.</th> -->
                                    <th>Ket.</th>
                                    <th>Qty</th>
                                    <th>Harga</th>
                                    <th>Amount</th>
                                    <th>Del.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="baris">
                                    <td>
                                        <input type="text" class="form-control" name="item[]" oninput="this.value = this.value.toUpperCase()">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="qty[]" value="0">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control total" name="harga[]" value="0">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="total_amount[]" value="0" readonly>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm hapusRow">Hapus</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">Subtotal</td>
                                    <td>
                                        <input type="text" class="form-control" name="nominal" id="nominal" value="0" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">Biaya loading</td>
                                    <td>
                                        <input type="text" class="form-control" name="biaya_loading" id="biaya_loading" value="0">
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">Bruto</td>
                                    <td>
                                        <input type="text" class="form-control" name="bruto" id="bruto" value="0" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">PPN 11%</td>
                                    <td>
                                        <input type="text" class="form-control" name="besaran_ppn" id="besaran_ppn" value="0" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">PPh 2%
                                        <input type="checkbox" class="icheckbox_flat-green" style="margin-left: 0px;" name="opsi_pph" id="opsi_pph" value="1" disabled checked>

                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="besaran_pph" id="besaran_pph" value="0" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">Total</td>
                                    <td>
                                        <input type="text" class="form-control" name="total_denganpph" id="total_denganpph" value="0" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right">Termin
                                        <input type="checkbox" class="icheckbox_flat-green" style="margin-left: 0px;" name="opsi_termin" value="1">
                                    </td>
                                    <td>
                                        <a href="<?= base_url('financial/invoice') ?>" class="btn btn-sm btn-warning"><i class="bi bi-arrow-return-left"></i> Back</a>
                                        <button type="submit" class="btn btn-primary btn-sm">Save <i class="bi bi-save"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <button type="button" class="btn btn-secondary btn-sm" id="addRow">Add new row</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="<?= base_url(); ?>assets/select2/css/select2.min.css">
<script type="text/javascript" src="<?= base_url(); ?>assets/select2/js/select2.min.js"></script>
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
    });

    function formatNumber(number) {
        // Pisahkan bagian integer dan desimal
        let parts = number.toString().split(".");

        // Format bagian integer dengan pemisah ribuan
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        // Gabungkan bagian integer dan desimal dengan koma sebagai pemisah desimal
        return parts.join(",");
    }

    // <?php
        // if ($this->session->flashdata('message_name')) {
        // 
        ?>
    //     Swal.fire({
    //         title: "Success!! ",
    //         text: '<?= $this->session->flashdata('message_name') ?>',
    //         type: "success",
    //         icon: "success",
    //     });
    // <?php
        //     // $this->session->sess_destroy('message_name');
        //     unset($_SESSION['message_name']);
        // } 
        ?>

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


    $(document).ready(function() {
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
            newRow.find('input[name="harga[]"]').val('0');
            newRow.find('input[name="total_amount[]"]').val('0');
            rowCount++;

            // Tambahkan baris baru setelah baris terakhir
            previousRow.after(newRow);
        });

        $('#biaya_loading').on('input keyup', function() {
            var value = $(this).val().trim(); // Hapus spasi di awal dan akhir nilai
            var formattedValue = parseFloat(value.split('.').join(''));

            if (!isNaN(formattedValue)) {
                var formattedNumber = formatNumber(formattedValue);
                $(this).val(formattedNumber);
            } else {
                $(this).val('');
            }

            updateTotal();
        });


        $(document).on('input keyup', 'input[name="qty[]"], input[name="harga[]"]', function() {
            var value = $(this).val().trim(); // Hapus spasi di awal dan akhir nilai
            var formattedValue = parseFloat(value.split('.').join(''));

            if (!isNaN(formattedValue)) {
                var formattedNumber = formatNumber(formattedValue);
                $(this).val(formattedNumber);
            } else {
                $(this).val('');
            }

            var row = $(this).closest('.baris');
            hitungTotal(row);
            updateTotalBelanja();
            updateTotal();
        });


        function hitungTotal(row) {
            var harga = row.find('input[name="harga[]"]').val().replace(/\./g, '');
            var qty = row.find('input[name="qty[]"]').val().replace(/\./g, '');

            harga = parseInt(harga); // Ubah string ke angka float
            qty = parseInt(qty); // Ubah string ke angka float

            harga = isNaN(harga) ? 0 : harga;
            qty = isNaN(qty) ? 0 : qty;

            var total_amount = harga * qty;

            row.find('input[name="total_amount[]"]').val(formatNumber(total_amount));
            updateTotalBelanja();
        }

        function updateTotalBelanja() {
            var total_pos_fix = 0;

            $(".baris").each(function() {
                var total = $(this).find('input[name="total_amount[]"]').val().replace(/\./g, ''); // Ambil nilai total dari setiap baris
                total = parseFloat(total); // Ubah string ke angka float

                if (!isNaN(total)) { // Pastikan total adalah angka
                    total_pos_fix += total; // Tambahkan nilai total ke total_pos_fix
                }
            });
            $('#nominal').val(formatNumber(total_pos_fix));
        }

        // Tambahkan event listener untuk tombol hapus row
        $(document).on('click', '.hapusRow', function() {
            $(this).closest('.baris').remove();
            updateTotalBelanja(); // Perbarui total belanja setelah menghapus baris
            updateTotal();
        });

        // Saat opsi diskon berubah
        $('#diskon').on('change', function() {
            // Panggil fungsi untuk mengupdate besaran diskon dan total
            updateTotal();
        });
        $('#ppn').on('change', function() {
            // Panggil fungsi untuk mengupdate besaran diskon dan total
            updateTotal();
        });
        $('#opsi_pph').on('change', function() {
            updateTotal();
        });

        // Fungsi untuk mengupdate besaran diskon dan total
        function updateTotal() {
            var diskon = parseFloat($('#diskon').val());
            var ppn = parseFloat($('#ppn').val());
            var pph = 0.02;
            // var opsi_pph = document.getElementById("opsi_pph").value;
            var besaranpph = parseFloat($('#besaran_pph').val());
            var biaya_loading = parseFloat($('#biaya_loading').val().replace(/\./g, '') || 0);
            // biaya_loading = $('#biaya_loading').val();
            console.log(biaya_loading)

            var subtotal = 0;

            // Hitung subtotal dari total setiap baris
            $('.baris').each(function() {
                var totalBaris = parseInt($(this).find('input[name="total_amount[]"]').val().replace(/\./g, '') || 0);
                subtotal += totalBaris;
            });

            // Hitung besaran diskon
            var besaranDiskon = subtotal * diskon;
            var besaranDiskon = subtotal;

            // Hitung total setelah diskon
            var total = subtotal;
            var bruto = total - biaya_loading;

            // Jika opsi_pph dicentang
            if ($('#opsi_pph').is(':checked')) {
                besaranpph = bruto * pph;
            } else {
                besaranpph = 0;
            }

            // console.log(besaranpph)
            var besaranppn = bruto * ppn;
            var total_nonpph = bruto + besaranppn;
            var total_denganpph = bruto + besaranppn - besaranpph;
            var pendapatan = bruto - besaranpph;
            var nominal_bayar = bruto + besaranppn - besaranpph;

            // Atur nilai input besaran_diskon dan bruto dengan format angka yang sesuai
            $('#besaran_ppn').val(formatNumber(besaranppn.toFixed(0)));
            $('#besaran_pph').val(formatNumber(besaranpph.toFixed(0)));
            $('#besaran_diskon').val(formatNumber(besaranDiskon));
            $('#total_nonpph').val(formatNumber(total_nonpph.toFixed(0)));
            $('#total_denganpph').val(formatNumber(total_denganpph.toFixed(0)));
            $('#nominal_pendapatan').val(formatNumber(pendapatan.toFixed(0)));
            $('#nominal_bayar').val(formatNumber(nominal_bayar.toFixed(0)));
            $('#bruto').val(formatNumber(bruto.toFixed(0)));
        }

        function updateTotalEdit() {
            var diskon = parseFloat($('#diskonEdit').val());

            var subtotal = parseInt($('#nominal').val().replace(/\./g, '') || 0);

            // Hitung besaran diskon
            var besaranDiskon = subtotal * diskon;
            // Hitung total setelah diskon
            var total = subtotal - besaranDiskon;
            // Atur nilai input besaran_diskon dan total dengan format angka yang sesuai
            $('#besaran_diskon').val(formatNumber(besaranDiskon));
            $('#total_nonpph').val(formatNumber(total));
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
            console.log(qty)

            var total = qty * harga;
            row.find('input[name="harga"]').val(formatNumber(harga));
            row.find('input[name="total_amount"]').val(formatNumber(total));
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
            newRow.find('input[name="newHarga[]"]').val('0');

            // Perbarui tag <h4> pada baris baru dengan nomor urut yang baru
            rowCount++;

            // Tambahkan baris baru setelah baris terakhir
            previousRow.after(newRow);
        });


        $(document).on('click', '.hapusRowAddItem', function() {
            $(this).closest('.barisEdit').remove();
        });

        $(document).on('input', 'input[name="newHarga[]"]', function() {
            var value = $(this).val();
            var formattedValue = parseFloat(value.split('.').join(''));
            $(this).val(formattedValue);

            var row = $(this).closest('.barisEdit');
            hitungTotalNewItem(row);
        });

        // Tambahkan event listener untuk event keyup
        $(document).on('keyup', 'input[name="newHarga[]"]', function() {
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
            var harga = row.find('input[name="newHarga[]"]').val().replace(/\./g, ''); //
            harga = parseInt(harga);

            harga = isNaN(harga) ? 0 : harga;

            // var total = qty * harga;
            // row.find('input[name="newharga[]"]').val(formatNumber(total));
        }
    });
</script>
<script>
    $(function() {

        $("#addRow").click(function() {
            var newRow = '<div class="autocomplete-row"><input type="text" class="form-control autocomplete" name="item[]" oninput="this.value = this.value.toUpperCase()"></div>';
            $("#invoiceForm").append(newRow);
        });
    });
</script>