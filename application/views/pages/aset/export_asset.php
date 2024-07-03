<!DOCTYPE html>
<html>

<head>
    <title>Export Data Ke Excel Dengan PHP - www.malasngoding.com</title>
</head>

<body>
    <style type="text/css">
        body {
            font-family: sans-serif;
        }

        table {
            margin: 20px auto;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #3c3c3c;
            padding: 3px 8px;
        }

        a {
            background: 'blue';
            color: #fff;
            padding: 8px 10px;
            text-decoration: none;
            border-radius: 2px;
        }
    </style>
    <?php
    $jenis = $this->session->userdata('filterJenis');
    if ($jenis == true) {
        $show_jns = $jenis;
    } else {
        $show_jns = '';
    }
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data Asset " . $show_jns . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    ?>
    <center>
        <h4>Export Data Asset <?= $show_jns ?></h4>
    </center>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>Spesifikasi</th>
            <th>Ruang</th>
            <th>Lokasi</th>
            <th>Jns</th>
            <th>Jml</th>
        </tr>
        <?php
        $jenis = $this->session->userdata('filterJenis');
        if ($jenis == true) {
            $this->db->where('jenis_asset', $jenis);
        }
        $data = $this->db->get('asset_list')->result();
        $no = 1;
        foreach ($data  as $d) {
        ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo $d->kode; ?></td>
                <td><?php echo $d->nama_asset; ?></td>
                <td><?php echo $d->spesifikasi; ?></td>
                <td><?php echo $d->ruangan; ?></td>
                <td><?php echo $d->lokasi; ?></td>
                <td><?php echo $d->jenis_asset; ?></td>
                <td><?php echo $d->jumlah; ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>