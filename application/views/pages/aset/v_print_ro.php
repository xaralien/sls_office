<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 8pt;
    }

    body {
      margin: 30px;
    }

    #item {
      border-collapse: collapse;
      width: 100%;
    }

    #item td,
    #item th {
      border: 1px solid black;
      padding: 5px;
    }

    /* #item tr:nth-child(even) {
      background-color: #f2f2f2;
    } */

    /* #item tr:hover {
      background-color: #ddd;
    } */

    #item th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: blue;
      color: white;
    }

    .text-right {
      text-align: right;
    }

    .text-center {
      text-align: center;
    }

    .border-none {
      border: none !important;
    }

    .box {
      padding: 5px;
      border-bottom: 2px solid black;
      border-left: 2px solid black;
      border-right: 2px solid black;
      border-top: 2px solid black;
    }
  </style>
</head>

<body>
  <?php
  $detail = $this->cb->get_where('t_ro_detail', ['no_ro' => $ro['Id']])->result_array();
  ?>

  <table id="item" class="box">
    <tr class="box">
      <td colspan="2" class="border-none"><img src="<?= base_url('assets/images/logo-sls.png') ?>" alt="logo-sls" width="100px"></td>
      <td colspan="3" class="border-none">PERMINTAAN BARANG KELUAR</td>
      <td colspan="3" class="text-center border-none">
        <b>PT. SOLUSINDO LINTAS SAMUDERA</b><br>
        <span>Jl. Toddopulli X Griya Puspita Sari Block B8 No. 2 Makassar</span><br>
        <span>Tlp: 0411-442717</span><br>
        <span>Email: SLSulindo@gmail.com</span>
      </td>
    </tr>
    <tr>
      <td class="border-none">No. Permintaan Barang</td>
      <td class="border-none">:</td>
      <td class="border-none"><?= $ro['no_ro'] ?></td>
    </tr>
    <tr>
      <td class="border-none">No. Referensi</td>
      <td class="border-none">:</td>
      <td class="border-none"><?= $ro['referensi'] ?></td>
    </tr>
    <tr>
      <td class="border-none">Tanggal</td>
      <td class="border-none">:</td>
      <td class="border-none"><?= tgl_indo(date('Y-m-d', strtotime($ro['tgl_pengajuan']))) ?></td>
    </tr>
    <tr class="border-none">
      <td rowspan="1" colspan="7" class="border-none"></td>
    </tr>
    <tr>
      <th>Teknisi</th>
      <th>Unit</th>
      <th>Item</th>
      <th>Serial Number</th>
      <th>Qty</th>
      <th>UOI</th>
      <th>Harga Satuan</th>
      <th>Total</th>
    </tr>
    <?php
    $sarlog = $this->db->get_where('users', ['nip' => $ro['user_serah']])->row_array();
    foreach ($detail as $val) {
      $item = $this->db->get_where('item_list', ['Id' => $val['item']])->row_array();
      $asset = $this->db->get_where('asset_list', ['Id' => $val['asset']])->row_array();

    ?>
      <tr>
        <td><?= $ro['teknisi'] ?></td>
        <td><?= $asset['nama_asset'] ?></td>
        <td><?= $item['nama'] ?></td>
        <td>
          <?php
          if ($val['detail']) {
            foreach (json_decode($val['detail']) as $s) {
              if ($s == 0) {
                echo "Tidak ada serial number";
              } else {
                $serial = $this->db->get_where('item_detail', ['Id' => $s])->row_array();
          ?>
                <div>
                  <?= $serial['serial_number'] ?> <br>
                </div>
          <?php }
            }
          } else {
            echo "-";
          } ?>

        </td>
        <td class="text-right"><?= $val['qty'] ?></td>
        <td><?= $val['uoi'] ?></td>
        <td class="text-right"><?= number_format($val['price']) ?></td>
        <td class="text-right"><?= number_format($val['total']) ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td colspan="7" class="text-right">
        <b>Total</b>
      </td>
      <td class="text-right"><b><?= number_format($ro['total']) ?></b></td>
    </tr>
    <tr class="border-none">
      <td rowspan="1" colspan="7" class="border-none"></td>
    </tr>
    <tr class="border-none">
      <td rowspan="1" colspan="7" class="border-none"></td>
    </tr>
    <tr class="border-none" style="margin-top: 30px;">
      <td class="border-none" colspan="3">Lellilef, Rabu 10 Juli 2024</td>
    </tr>
    <tr class="border-none">
      <td rowspan="1" colspan="7" class="border-none"></td>
    </tr>
    <tr class="border-none text-center">
      <td colspan="2" class="border-none">Diserahkan Oleh,</td>
      <td colspan="2" class="border-none"></td>
      <td colspan="2" class="border-none"></td>
      <td colspan="2" class="border-none">Diterima Oleh,</td>
    </tr>
    <tr class="border-none">
      <td rowspan="1" colspan="7" class="border-none"></td>
    </tr>
    <tr class="border-none">
      <td rowspan="1" colspan="7" class="border-none"></td>
    </tr>
    <tr class="border-none">
      <td rowspan="1" colspan="7" class="border-none"></td>
    </tr>
    <tr class="border-none">
      <td rowspan="1" colspan="7" class="border-none"></td>
    </tr>
    <tr class="border-none">
      <td rowspan="1" colspan="7" class="border-none"></td>
    </tr>
    <tr class="border-none text-center">
      <td colspan="2" class="border-none"><b><u><?= $sarlog['nama'] ?></u></b></td>
      <td colspan="2" class="border-none"></td>
      <td colspan="2" class="border-none"></b></td>
      <td colspan="2" class="border-none"><b><u><?= $ro['teknisi'] ?></u></b></td>
    </tr>
    <tr class="border-none text-center">
      <td colspan="2" class="border-none"></td>
      <td colspan="2" class="border-none"></td>
      <td colspan="2" class="border-none"></td>
      <td colspan="2" class="border-none"></td>
    </tr>
  </table>

</body>

</html>