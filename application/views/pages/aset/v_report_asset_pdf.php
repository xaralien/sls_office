<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Penggunaan Asset</title>

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

    .judul {
      margin-bottom: 30px;
      text-align: center;
      font-weight: 800;
      text-transform: uppercase;
    }
  </style>
</head>

<body>
  <div class="judul">Penggunaan Asset <?= $asset['nama_asset'] ?></div>
  <table width="100%" id="item">
    <thead>
      <tr>
        <th>No.</th>
        <th>Tanggal</th>
        <th>Keterangan</th>
        <th>Item</th>
        <th>Jumlah</th>
        <!-- <th>Stok Awal</th>
        <th>Stok Akhir</th> -->
        <th>Harga Satuan</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      $total = 0;
      foreach ($report as $r) {
        $item = $this->db->get_where('item_list', ['Id' => $r['item_id']])->row_array();
        $total += $r['harga'] * $r['jml'];
      ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= tgl_indo(date('Y-m-d', strtotime($r['tanggal']))); ?></td>
          <td><?= $r['jenis'] ?></td>
          <td><?= $item['nama'] . ' | '; ?></td>
          <td><?= $r['jml'] ?></td>
          <!-- <td><?= $r['stok_awal'] ?></td>
          <td><?= $r['stok_akhir'] ?></td> -->
          <td><?= number_format($r['harga']) ?></td>
          <td><?= number_format($r['harga'] * $r['jml']) ?></td>
        </tr>
      <?php } ?>
      <tr>
        <td colspan="6" class="text-right">TOTAL</td>
        <td><?= number_format($total) ?></td>
      </tr>
    </tbody>
  </table>
</body>

</html>