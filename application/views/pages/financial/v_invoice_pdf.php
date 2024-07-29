<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_pdf; ?></title>
    <style>
        body {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            font-size: 10pt;
        }

        #table {
            /* font-family: "Trebuchet MS", Arial, Helvetica, sans-serif; */
            border-collapse: collapse;
            width: 100%;


        }

        #table td,
        #table th {
            border: 1px solid #000;
            padding: 3px;
        }

        /* #table tr:nth-child(even) {
            background-color: #f2f2f2;
        } */

        /* #table tr:hover {
            background-color: #ddd;
        } */

        #table th {
            padding-top: 3px;
            padding-bottom: 3px;
            text-align: center;
            background-color: #ddd;
            color: black;
        }

        td {
            vertical-align: middle;
            padding-top: 3px;
            padding-bottom: 3px;
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
    $year = substr($invoice['tanggal_invoice'], 0, 4);
    ?>
    <table style="margin-bottom: 30px; width: 100%">
        <tbody>
            <tr>
                <td>
                    <img src="<?= base_url(); ?>assets/img/logo-sls.png" style="width: 200px;" alt="">
                </td>
                <td style="text-align: right; vertical-align:middle">Invoice No. : <?= $invoice['no_invoice'] ?>/SLS/INV-GMG/<?= intToRoman($month) ?>/<?= $year ?></td>
            </tr>
        </tbody>
    </table>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td width="10%" style="vertical-align: top;">
                    <strong>Kepada </strong><br>
                </td>
                <td width="60%" style="vertical-align: top;">: <?= $invoice['nama_customer'] ?></td>
                <td width="10%" style="vertical-align: top;">
                    <strong>Tanggal </strong><br>
                </td>
                <td width="20%" style="vertical-align: top;">: <?= format_indo($invoice['tanggal_invoice']) ?></td>
            </tr>
            <tr>
                <td style="vertical-align: top;">
                    <strong>Alamat </strong><br>
                </td>
                <td style="vertical-align: top; white-space: pre-line; ">: <?= $invoice['alamat_customer'] ?></td>
            </tr>
        </tbody>
    </table>
    <p style="width: 450px;">
    </p>
    <h3 style="text-align: center;">INVOICE</h3>
    <table id="table">
        <thead>
            <tr>
                <th>No.</th>
                <th style="width: 40%">Description</th>
                <th>Qty</th>
                <th>Unit Price (IDR)</th>
                <th>Amount (IDR)</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;

            foreach ($details as $d) :
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $d->item ?></td>
                    <td class="text-right"><?= $d->qty ?></td>
                    <td class="text-right"><?= number_format($d->harga) ?></td>
                    <td class="text-right"><?= number_format($d->total_amount) ?></td>
                </tr>
            <?php
            endforeach;
            ?>
            <tr>
                <td class="" colspan="4"><strong>SUBTOTAL</strong></td>
                <td class="text-right"><?= number_format($invoice['subtotal']) ?></td>
            </tr>
            <tr>
                <td class="" colspan="4"><strong>DIKURANGI LOADING</strong></td>
                <td class="text-right"><?= number_format($invoice['biaya_loading']) ?></td>
            </tr>
            <tr>
                <td class="" colspan="4"><strong>BRUTO</strong></td>
                <td class="text-right"><?= number_format($invoice['bruto']) ?></td>
            </tr>
            <tr>
                <td class="" colspan="4"><strong>PPN <?= $invoice['ppn'] * 100 ?>%</strong></td>
                <td class="text-right"><?= number_format($invoice['besaran_ppn']) ?></td>
            </tr>
            <?php
            if ($invoice['opsi_pph23'] == '1') {
            ?>
                <tr>
                    <td class="" colspan="4"><strong>PPh <?= $invoice['pph'] * 100 ?>%</strong></td>
                    <td class="text-right"><?= number_format($invoice['besaran_pph']) ?></td>
                </tr>
            <?php
            } ?>
            <tr>
                <td colspan="5"></td>
            </tr>
            <tr>
                <td class="" colspan="4"><strong>Total ditransfer</strong></td>
                <td class="text-right"><strong><?= number_format($invoice['nominal_bayar']) ?></strong></td>
            </tr>
            <tr>
                <td colspan="5">Terbilang: <br><strong><?= terbilang($invoice['nominal_bayar']) ?> Rupiah</strong></td>
            </tr>
        </tbody>
    </table>

    <table style="width: 100%;">
        <tbody>
            <tr>
                <td colspan="5" style="vertical-align: top; white-space: pre-line;">
                    Keterangan:
                    <?= $invoice['keterangan'] ?>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border: 0px; vertical-align: bottom">
                    <p>
                        <strong>NOMOR REKENING BANK:</strong> <br>
                        Bank Mandiri 174-009575-9999 <br>
                        Cabang Ratulangi Makasar <br>
                        a.n PT. SULINDO LINTAS SAMUDERA
                    </p>
                </td>
                <td colspan="2" style="border: 0px; text-align: center;">
                    <p style="margin-top: 20px; font-weight: bold">PT. SULINDO LINTAS SAMUDERA</p>
                    <p style="margin-top: 100px; text-transform:uppercase; text-decoration: underline; font-weight: bold">SUGIANTO, SE</p>
                    <p style="margin-top: -10px">Direktur Utama</p>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>