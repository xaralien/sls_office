<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Penggunaan Item Asset <?= $asset['nama_asset'] . ' | ' . $asset['kode'] ?></title>

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
  <div class="judul">Penggunaan Item Asset <?= $asset['nama_asset'] . ' | ' . $asset['kode'] ?></div>
  <table width="100%" id="item">
    <thead>
      <tr>
        <th>No.</th>
        <th>Item</th>
        <th>Jumlah</th>
        <th>Harga Satuan</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      foreach ($report as $r) {
        $item = $this->db->get_where('item_list', ['Id' => $r['item_id']])->row_array();
      ?>
        <tr>
          <td><?= $no++; ?></td>
          <td><?= $item['nama'] . ' | ' . $item['nomor']; ?></td>
          <td><?= $r['jml'] ?></td>
          <td><?= number_format($r['harga']) ?></td>
          <td><?= number_format($r['harga'] * $r['jml']) ?></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</body>

</html>