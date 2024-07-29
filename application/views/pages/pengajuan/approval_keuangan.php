<div class="right_col" role="main">

  <div class="clearfix"></div>

  <!-- Start content-->

  <div class="row">

    <div class="col-md-12 col-sm-12 col-xs-12">

      <div class="x_panel card">

        <div class="x_title">

          <h2>List Approval Keuangan</h2>

        </div>

        <div class="x_content">
          <!-- <a href="<?= base_url('pengajuan/list') ?>" class="btn btn-warning">Back</a> -->
          <div class="row" style="margin: 10px 0 20px;">
            <form method="get" id="form-filter">
              <label for="filter" class="form-label">Filter berdasarkan</label>
              <select name="filter" id="filter" class="form-control">
                <option value="">:: Pilih filter</option>
                <option value="1" <?= $this->input->get('filter') == 1 ? 'selected' : '' ?>>Belum bayar</option>
                <option value="2" <?= $this->input->get('filter') == 2 ? 'selected' : '' ?>>Sudah bayar</option>
                <option value="3" <?= $this->input->get('filter') == 3 ? 'selected' : '' ?>>Tanggal pengajuan</option>
                <option value="4" <?= $this->input->get('filter') == 4 ? 'selected' : '' ?>>Belum Diproses</option>
              </select>
            </form>
          </div>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">No.</th>
                  <th scope="col">User</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Rekening</th>
                  <th scope="col">Total</th>
                  <th scope="col">Status</th>
                  <th scope="col">Posisi</th>
                  <th scope="col">#</th>
                </tr>
              </thead>
              <tbody>
                <?php if ($approval_keuangan->num_rows() < 1) {  ?>

                  <tr align="center">

                    <td colspan="7">Belum ada data</td>

                  </tr>

                  <?php } else {

                  foreach ($approval_keuangan->result_array() as $value) {

                    $user = $this->db->get_where('users', ['nip' => $value['user']])->row_array();

                    if ($value['status_keuangan'] == 0) {

                      $color = "orange";
                    } else if ($value['status_keuangan'] == 1) {

                      $color = "green";
                    } else {

                      $color = "red";
                    }

                  ?>

                    <tr>

                      <td><?= $value['no_pengajuan'] ?></td>

                      <td><?= $user['nama'] ?></td>

                      <td><?= $value['created_at'] ?></td>

                      <td><?= $value['no_rekening'] ?></td>

                      <td><?= number_format($value['total']) ?></td>

                      <td style="color: <?= $color ?>;">

                        <?php if ($value['status_keuangan'] == 1) {

                          echo "Disetujui";
                        } elseif ($value['status_keuangan'] == 2) {

                          echo "Ditolak";
                        } else {

                          echo "Belum diproses";
                        } ?>

                      </td>

                      <td><?= $value['posisi'] ?></td>

                      <td>

                        <a href="<?= base_url('pengajuan/detail/' . $value['Id']) ?>" class="btn btn-warning btn-sm">View</a>

                        <?php if ($value['posisi'] == 'Diarahkan ke pembayaran') { ?>

                          <a href="<?= base_url('pengajuan/bayar/' . $value['Id']) ?>" class="btn btn-success btn-sm">Bayar</a>

                        <?php } ?>

                        <?php if ($value['status'] == 1) { ?>

                          <!-- <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModalClose<?= $value['Id'] ?>">Close</button> -->

                          <a href="<?= base_url('pengajuan/close/' . $value['Id']) ?>" class="btn btn-success btn-sm">Close</a>

                        <?php } ?>

                      </td>

                    </tr>

                <?php }
                } ?>

              </tbody>

            </table>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

<script>
  $(document).ready(function() {

    $(document).on('input', 'input[name="realisasi"]', function() {

      var value = $(this).val();

      var formattedValue = parseFloat(value.split('.').join(''));

      $(this).val(formattedValue);

    });



    // Tambahkan event listener untuk event keyup

    $(document).on('keyup', 'input[name="realisasi"]', function() {

      var value = $(this).val().trim(); // Hapus spasi di awal dan akhir nilai

      var formattedValue = formatNumber(parseFloat(value.split('.').join('')));

      $(this).val(formattedValue);

      if (isNaN(value)) { // Jika nilai input kosong

        $(this).val(''); // Atur nilai input menjadi 0

      }

      var row = $(this).closest('.baris');

    });



    $("select[name='filter']").change(function() {

      // var val = $(this).val();

      $("form[id='form-filter']").submit();

    })

  })
</script>

<script>
  function formatNumber(number) {

    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

  }
</script>