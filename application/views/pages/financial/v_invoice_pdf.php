<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_pdf; ?></title>
    <style>
        body {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            font-size: 8pt;
        }

        #table {
            /* font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; */
            border-collapse: collapse;
            width: 100%;


        }

        #table td,
        #table th {
            border: 1px solid #000;
            padding: 2px;
        }

        /* #table tr:nth-child(even) {
            background-color: #f2f2f2;
        } */

        /* #table tr:hover {
            background-color: #ddd;
        } */

        #table th {
            padding-top: 1px;
            padding-bottom: 1px;
            text-align: center;
            background-color: #ddd;
            color: black;
        }

        td {
            vertical-align: middle;
            padding-top: 1px;
            padding-bottom: 1px;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    $month = substr($invoice['tanggal_invoice'], 5, 2);
    $year = substr($invoice['tanggal_invoice'], 2, 2);
    ?>
    <table style="margin-bottom: 30px; width: 100%">
        <tbody>
            <tr>
                <td>
                    <img src="<?= base_url(); ?>img/logo_ppm.png" style="width: 200px;" alt="">
                </td>
                <td style="text-align: right; vertical-align:middle">Invoice No. : <?= $invoice['no_invoice'] ?>.PPM.UM.<?= intToRoman($month) ?>.<?= $year ?></td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%;">

        <tbody>
            <tr>
                <td>
                    <strong>Kepada </strong><br>
                </td>
                <td>: <?= $invoice['nama_customer'] ?></td>
                <td>
                    <strong>Tanggal </strong><br>
                </td>
                <td>: <?= format_indo($invoice['tanggal_invoice']) ?></td>
            </tr>
            <tr>
                <td>
                    <strong>Alamat </strong><br>
                </td>
                <td>: <?= $invoice['alamat_customer'] ?></td>
                <td>
                    <strong>Service </strong><br>
                </td>
                <td>: Port to Port</td>
            </tr>
        </tbody>
    </table>
    <p style="width: 450px;">
    </p>
    <h3 style="text-align: center;">INVOICE</h3>
    <?php
    if ($invoice['jenis_invoice'] == "reguler") {
    ?>
        <table id="table" style="width: 100%; font-size: 7pt">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Date</th>
                    <th>AWB</th>
                    <th>Flight Number</th>
                    <th>Dest.</th>
                    <th>Coly</th>
                    <th>Act.</th>
                    <th>CW</th>
                    <th>Rate</th>
                    <th>Total</th>
                    <th>AWB Fee</th>
                    <th>Total Amount</th>
                    <!-- <th>Keterangan</th> -->
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                $total_qty = 0;
                $total_actual_weight = 0;
                $total_chargeable_weight = 0;
                foreach ($details as $d) :
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?>.</td>
                        <td class="text-center"><?= format_indo($d->item_date) ?></td>
                        <td class="text-center"><?= $d->item ?></td>
                        <td class="text-center"><?= $d->flight_number ?></td>
                        <td class="text-center"><?= $d->destination ?></td>
                        <td class="text-right"><?= number_format($d->qty) ?></td>
                        <td class="text-right"><?= number_format($d->actual_weight) ?></td>
                        <td class="text-right"><?= number_format($d->chargeable_weight) ?></td>
                        <td class="text-right"><?= number_format($d->harga) ?></td>
                        <td class="text-right"><?= number_format($d->total) ?></td>
                        <td class="text-right"><?= number_format($d->awb_fee) ?></td>
                        <td class="text-right"><?= number_format($d->total_amount) ?></td>
                        <!-- <td></td> -->
                    </tr>
                <?php
                    $total_qty += $d->qty;
                    $total_actual_weight += $d->actual_weight;
                    $total_chargeable_weight += $d->chargeable_weight;
                endforeach;
                ?>
                <tr>
                    <td class="" colspan="5"><strong>SUBTOTAL</strong></td>
                    <td class="text-right"><strong><?= number_format($total_qty) ?></strong></td>
                    <td class="text-right"><strong><?= number_format($total_actual_weight) ?></strong></td>
                    <td class="text-right"><strong><?= number_format($total_chargeable_weight) ?></strong></td>
                    <td colspan="3"></td>
                    <td class="text-right"><strong><?= number_format($invoice['subtotal']) ?></strong></td>
                </tr>
                <!-- <tr>
                    <td class="" colspan="11">DISKON <?= $invoice['diskon'] * 100 ?>%</td>
                    <td class="text-right"><?= number_format($invoice['besaran_diskon']) ?></td>
                </tr> -->
                <tr>
                    <td class="" colspan="11">VAT <?= $invoice['ppn'] * 100 ?>%</td>
                    <td class="text-right"><?= number_format($invoice['besaran_ppn']) ?></td>
                </tr>
                <tr>
                    <td class="" colspan="11"><strong>GRAND TOTAL</strong></td>
                    <td class="text-right"><strong><?= number_format($invoice['total_nonpph']) ?></strong></td>
                </tr>
                <tr>
                    <td colspan="12"><strong><?= terbilang($invoice['total_nonpph']) ?> Rupiah</strong></td>
                </tr>
            </tbody>
        </table>
    <?php
    } else { ?>
        <table id="table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th style="width: 20%">Date</th>
                    <th style="width: 40%">Keterangan</th>
                    <th>Total Amount</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($details as $d) :
                ?>
                    <tr>
                        <td><?= $no++ ?>.</td>
                        <td><?= format_indo($d->item_date) ?></td>
                        <td><?= $d->item ?></td>
                        <td class="text-right"><?= number_format($d->total_amount) ?></td>
                        <td class="text-right"></td>
                    </tr>
                <?php
                endforeach;
                ?>
                <tr>
                    <td class="" colspan="3"><strong>SUBTOTAL</strong></td>
                    <td class="text-right"><?= number_format($invoice['subtotal']) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="" colspan="3"><strong>VAT <?= $invoice['ppn'] * 100 ?>%</strong></td>
                    <td class="text-right"><?= number_format($invoice['besaran_ppn']) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="" colspan="3"><strong>GRAND TOTAL</strong></td>
                    <td class="text-right"><?= number_format($invoice['total_nonpph']) ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="5"><strong><?= terbilang($invoice['total_nonpph']) ?> Rupiah</strong></td>
                </tr>
            </tbody>
        </table>
    <?php
    } ?>

    <table style="width: 100%;">
        <tbody>
            <tr>
                <td colspan="3" style="border: 0px; vertical-align: bottom">
                    <p>
                        Pembayaran Transfer ke: <br>
                        Bank BCA 375-0999009 <br>
                        PT. PERDANA PRESTIGE MAKMUR
                    </p>
                </td>
                <td colspan="2" style="border: 0px; text-align: center;">
                    <p style="margin-top: 20px;">Finance</p>
                    <p style="margin-top: 100px;"><?= $user['nama'] ?></p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>