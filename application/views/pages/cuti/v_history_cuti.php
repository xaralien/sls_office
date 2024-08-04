<style>
  .btn_on {
    position: fixed;
    bottom: 20px;
    right: 0;
    z-index: 1000;
  }

  .col-xs-3 {
    width: 25%;
    background-color: #008080;
  }

  .container-fluid {
    padding-right: 0px;
    padding-left: 0px
  }

  .btn_footer_panel .tag_ {
    padding-top: 37px;
  }

  .colored-toast.swal2-icon-error {
    background-color: #f27474 !important;
    color: white;
  }

  .colored-toast.swal2-icon-success {
    background-color: #a5dc86 !important;
    color: white;
  }

  .colored-toast.swal2-icon-info {
    background-color: #3fc3ee !important;
  }

  span.aksi {
    cursor: pointer;
  }

  .badge-success {
    background-color: green;
  }

  .badge-danger {
    background-color: red;
  }

  .badge-warning {
    background-color: orange;
  }

  th,
  td {
    padding: 5px;
  }
</style>
<div class="right_col" role="main">
  <div class="x_panel card">
    <div>
      <?php
      $nip = $this->session->userdata('nip');
      $user = $this->db->get_where('users', ['nip' => $nip])->row();

      ?>
      <button onclick="history.back()" class="btn btn-warning"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali</button>
    </div>
    <div class="title">
      <h3>History Cuti <b><?= $users['nama'] ?></b></h3>
    </div>
    <div class="data-history">
      <table class="table jambo_table bulk_action">
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Jenis Cuti</th>
            <th>Detail Cuti</th>
            <th>Tanggal Pengajuan</th>
            <th>Mulai Cuti</th>
            <th>Jumlah Cuti</th>
            <th>Status Atasan</th>
            <th>Status Hrd</th>
            <th>Status Dirsdm</th>
            <th>Status Dirut</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 1;
          foreach ($historyCuti as $hs) :
            // Nama User
            $this->db->select('nama');
            $users = $this->db->get_where('users', ['nip' => $hs['nip']])->row_array();

            // Nama Jenis Cuti
            $this->db->select('nama_jenis');
            $jenis = $this->db->get_where('jenis_cuti', ['Id' => $hs['jenis']])->row_array();

            // Nama Sub Jenis Cuti
            $this->db->select('nama_sub_jenis');
            $detail = $this->db->get_where('sub_jenis_cuti', ['Id' => $hs['detail_cuti']])->row_array();
          ?>
            <tr>
              <td><?= $i; ?></td>
              <td><?= $users['nama'] ?></td>
              <td><?= $jenis['nama_jenis'] ?></td>
              <td><?= $hs['detail_cuti'] == 0 || $hs['detail_cuti'] == null ? "-" : $detail['nama_sub_jenis'] ?></td>
              <td><?= date('d F Y', strtotime($hs['date_created'])) ?></td>
              <td><?= date('d F Y', strtotime($hs['tgl_cuti'])) ?></td>
              <td><?= $hs['jumlah_cuti'] . " hari" ?></td>
              <td><?= $hs['status_atasan'] == null ? "Menunggu Proses" : $hs['status_atasan'] ?></td>
              <td><?= $hs['status_hrd'] == null ? "Menunggu Proses" : $hs['status_atasan'] ?></td>
              <td><?= $hs['status_dirsdm'] == null ? "-" : $hs['status_dirsdm'] ?></td>
              <td><?= $hs['status_dirut'] == null ? "-" : $hs['status_dirut'] ?></td>
            </tr>
          <?php
            $i++;
          endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
  $(document).ready(() => {
    $('.table').dataTable();
  })
</script>