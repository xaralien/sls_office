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
  $vendor = $this->db->get_where('t_vendors', ['Id' => $po['vendor']])->row_array();
  $detail = $this->cb->get_where('t_po_detail', ['no_po' => $po['Id']])->result_array();
  $user = $this->db->get_where('users', ['nip' => $po['user']])->row_array();
  $sarlog = $this->db->get_where('users', ['nip' => $po['sarlog']])->row_array();
  $dirops = $this->db->get_where('users', ['nip' => $po['direksi_ops']])->row_array();
  $dirut = $this->db->get_where('users', ['nip' => $po['dirut']])->row_array();
  ?>
  <table id="item" class="box">
    <tr class="box">
      <td colspan="2" class="border-none"><img src="<?= base_url('assets/images/logo-sls.png') ?>" alt="logo-sls" width="100px"></td>
      <td colspan="3" class="border-none">PURCHASING ORDER</td>
      <td colspan="3" class="text-center border-none">
        <b>PT. SOLUSINDO LINTAS SAMUDERA</b><br>
        <span>Jl. Toddopulli X Griya Puspita Sari Block B8 No. 2 Makassar</span><br>
        <span>Tlp: 0411-442717</span><br>
        <span>Email: SLSulindo@gmail.com</span>
      </td>
    </tr>
    <tr>
      <td colspan="2" class="border-none">Kepada</td>
      <td colspan="4" class="border-none"><b><?= $vendor['nama'] ?></b></td>
      <td class="border-none">Tanggal :</td>
      <td class="text-right border-none"><?= tgl_indo(date('Y-m-d', strtotime($po['tgl_pengajuan']))) ?></td>
    </tr>
    <tr>
      <td colspan="2" class="border-none"></td>
      <td colspan="4" class="border-none"><?= $vendor['alamat'] ?></td>
      <td class="border-none">No. PO :</td>
      <td class="text-right border-none"><?= $po['no_po'] ?></td>
    </tr>
    <tr>
      <td colspan="2" class="border-none">No. Tlp</td>
      <td colspan="4" class="border-none"><?= $vendor['no_telpon'] ?></td>
      <td class="border-none">Ref :</td>
      <td class="text-right border-none"><?= $po['referensi'] ?></td>
    </tr>
    <tr class="border-none">
      <td rowspan="1" colspan="7" class="border-none"></td>
    </tr>
    <tr>
      <th width="10px">NO.</th>
      <th>PART NUMBER</th>
      <th>NAMA BARANG</th>
      <th width="10px">QTY</th>
      <th width="10px">UOI</th>
      <th>HARGA SATUAN</th>
      <th>JUMLAH</th>
      <th>KETERANGAN</th>
    </tr>

    <?php
    $no = 1;
    $total = 0;
    foreach ($detail as $val) {
      $item = $this->db->get_where('item_list', ['Id' => $val['item']])->row_array();
      $total += $val['total'];
      if ($po['ppn']) {
        $ppn = ($total * 0.11);
      } else {
        $ppn = 0;
      }
    ?>
      <tr>
        <td><?= $no++ ?></td>
        <td><?= $item['nomor'] ?></td>
        <td><?= $item['nama'] ?></td>
        <td class="text-right"><?= $val['qty'] ?></td>
        <td class="text-right"><?= $val['uoi'] ?></td>
        <td class="text-right"><?= number_format($val['price']) ?></td>
        <td class="text-right"><?= number_format($val['total']) ?></td>
        <td><?= $val['keterangan'] ?></td>
      </tr>
    <?php } ?>
    <tr>
      <td colspan="6" class="text-right border-none">SUBTOTAL</td>
      <td class="text-right"><?= number_format($total) ?></td>
    </tr>
    <tr>
      <td colspan="6" class="text-right border-none">PPN 11%</td>
      <td class="text-right"><?= number_format($ppn) ?></td>
    </tr>
    <tr>
      <td colspan="6" class="text-right border-none">TOTAL HARGA</td>
      <td class="text-right"><?= number_format($total + $ppn) ?></td>
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
      <td colspan="2" class="border-none">Dibuat Oleh,</td>
      <td colspan="2" class="border-none">Diketahui Oleh,</td>
      <td colspan="2" class="border-none">Diketahui Oleh,</td>
      <td colspan="2" class="border-none">Disetujui Oleh,</td>
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
      <td colspan="2" class="border-none"><b><u><?= $user['nama'] ?></u></b></td>
      <td colspan="2" class="border-none"><b><u><?= $sarlog['nama'] ?></u></b></td>
      <td colspan="2" class="border-none"><b><u><?= $dirops['nama'] ?></u></b></td>
      <td colspan="2" class="border-none"><b><u><?= $dirut['nama'] ?></u></b></td>
    </tr>
    <tr class="border-none text-center">
      <td colspan="2" class="border-none"><?= $user['nama_jabatan'] ?></td>
      <td colspan="2" class="border-none"><?= $sarlog['nama_jabatan'] ?></td>
      <td colspan="2" class="border-none"><?= $dirops['nama_jabatan'] ?></td>
      <td colspan="2" class="border-none"><?= $dirut['nama_jabatan'] ?></td>
    </tr>
  </table>

</body>

</html>