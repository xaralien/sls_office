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
      font-size: 12pt;
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
      border: 1px solid #ddd;
      padding: 10px;
    }

    #item tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    #item tr:hover {
      background-color: #ddd;
    }

    #item th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #615e5e;
      color: white;
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
  $vendor = $this->cb->get_where('t_vendors', ['Id' => $po['vendor']])->row_array();
  $detail = $this->cb->get_where('t_po_detail', ['no_po' => $po['no_po']])->result_array();
  ?>
  <p class="text-center">Dokumen Purchase Order Item In</p>
  <table style="margin-top: 20px;">
    <tbody>
      <tr>
        <th>No. Referensi</th>
        <td>:</td>
        <td><?= $po['no_po'] ?>.IN</td>
      </tr>
      <tr>
        <th>Tanggal</th>
        <td>:</td>
        <td><?= date('d/m/Y', strtotime($po['tgl_pengajuan'])) ?></td>
      </tr>
      <tr>
        <th>Status</th>
        <td>:</td>
        <td><?= $po['status_pembayaran'] == 1 ? "Lunas" : "Belum Bayar" ?></td>
      </tr>
    </tbody>
  </table>
  <table style="width: 100%; margin-top: 30px;">
    <tbody>
      <tr style="vertical-align: top;">
        <td>
          <h4>Info Perusahaan</h4>
          <hr width="50%">
          <div style="margin-top: 20px;">
            <h4>Nama Perusahaan</h4>
            <p style="margin-top: 10px;">Alamat Perusahaan</p>
            <p>Telp. Perusahaan</p>
            <p>example@gmail.com</p>
          </div>
        </td>
        <td style="margin-left: auto;">
          <h4>Order Kepada</h4>
          <hr width="90%">
          <div style="margin-top: 20px">
            <h4><?= $vendor['nama'] ?></h4>
            <p style="margin-top: 10px;">Alamat vendor</p>
            <p>Telp. vendor</p>
            <p>Email. vendor</p>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  <table style="width: 100%; margin-top: 30px;" id="item">
    <thead>
      <tr>
        <th>Item</th>
        <th>Qty</th>
        <th>Harga Satuan</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($detail as $val) {
        $item = $this->db->get_where('item_list', ['Id' => $val['item']])->row_array();
      ?>
        <tr>
          <td><?= $item['nama'] . ' | ' . $item['nomor'] ?></td>
          <td class="text-right"><?= $val['qty'] ?></td>
          <td class="text-right"><?= number_format($val['price']) ?></td>
          <td class="text-right"><?= number_format($val['total']) ?></td>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="3" class="text-right">
          <b>Total</b>
        </td>
        <td class="text-right"><b><?= number_format($po['total']) ?></b></td>
      </tr>
    </tbody>
  </table>
</body>

</html>