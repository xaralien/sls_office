<!-- page content -->
<div class="right_col" role="main">
  <div class="clearfix"></div>
  <!-- Start content-->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel card">
        <div class="x_title">
          <h2>Detail Pengajuan <?= $detail['no_pengajuan'] ?></h2>
        </div>
        <div class="x_content">
          <a href="<?= base_url('pengajuan/approval_keuangan') ?>" class="btn btn-warning">Back</a>
          <?php if ($detail['posisi'] == "Diarahkan ke pembayaran" && $this->uri->segment(2) == 'bayar') { ?>
            <form action="<?= base_url('pengajuan/update_bayar') ?>" method="post" enctype="multipart/form-data" id="update-bayar">
              <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $detail['Id'] ?>">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Total</th>
                      <th>COA Credit</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['no_pengajuan']])->result_array();
                    foreach ($item as $i) {
                    ?>
                      <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                      <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                      <tr>
                        <td><?= $i['item'] ?></td>
                        <td>
                          <input type="text" class="form-control" name="total_item[]" id="total_item<?= $i['Id'] ?>" value="<?= number_format($i['total']) ?>" readonly>
                        </td>
                        <td>
                          <select name="coa_credit[]" id="coa_credit<?= $i['Id'] ?>" class="form-control select2" style="width: 100%;">
                            <option value=""> -- Pilih COA Credit -- </option>
                            <?php foreach ($coa_credit as $c) { ?>
                              <option value="<?= $c['no_sbb'] ?>"><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>
                          <div style="margin: 5px 0;"></div>
                          <input type="text" class="form-control" name="anggaran_credit[]" id="anggaran_credit<?= $i['Id'] ?>" readonly>
                        </td>
                      </tr>
                      <script>
                        $(document).ready(function() {
                          $('#coa_debit<?= $i['Id'] ?>').select2();
                          $('#coa_credit<?= $i['Id'] ?>').select2();

                          $('#coa_debit<?= $i['Id'] ?>').change(function() {
                            var id = $(this).val();
                            $.ajax({
                              url: '<?= base_url('pengajuan/getDataCoa/') ?>' + id,
                              method: 'GET',
                              dataType: 'JSON',
                              success: function(res) {
                                if (res.anggaran) {
                                  $('#anggaran<?= $i['Id'] ?>').val(formatNumber(res.anggaran));
                                } else {
                                  $('#anggaran<?= $i['Id'] ?>').val(0);
                                }
                              }
                            })
                          })

                          $('#coa_credit<?= $i['Id'] ?>').change(function() {
                            var id = $(this).val();
                            $.ajax({
                              url: '<?= base_url('pengajuan/getDataCoa/') ?>' + id,
                              method: 'GET',
                              dataType: 'JSON',
                              success: function(res) {
                                if (res.nominal) {
                                  $('#anggaran_credit<?= $i['Id'] ?>').val(formatNumber(res.nominal));
                                } else {
                                  $('#anggaran_credit<?= $i['Id'] ?>').val(0);
                                }
                              }
                            })
                          })

                        })
                      </script>
                    <?php } ?>
                    <tr>
                      <td><b>Total</b></td>
                      <td>
                        <input type="text" class="form-control" name="total_pengajuan[]" id="total_pengajuan" value="<?= number_format($detail['total']) ?>" readonly>
                      </td>
                      <td colspan="2"><?= terbilang($detail['total']) ?></td>
                    </tr>
                    <tr>
                      <td><b>Lampiran</b></td>
                      <td colspan="3"><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a></td>
                    </tr>
                    <tr>
                      <td><b>Catatan User</b></td>
                      <td colspan="4"><?= $detail['catatan'] ?></td>
                    </tr>
                  </tbody>
                </table>
                <table style="margin-top: 20px;" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Attachment Pengajuan</th>
                      <th>Attachment Bayar</th>
                      <th style="width: 40%;">Memo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-xs" target="_blank">Download</a></td>
                      <td>
                        <?php if ($detail['bukti_bayar']) { ?>
                          <a href="<?= base_url('upload/pengajuan/' . $detail['bukti_bayar']) ?>" class="btn btn-success btn-xs" target="_blank">Download</a>
                        <?php } else { ?>
                          <span>-</span>
                        <?php } ?>
                      </td>
                      <td>
                        <?php
                        $memo = $this->db->get_where('memo', ['Id' => $detail['memo']])->row_array();
                        if ($detail['memo']) {
                        ?>
                          <a href="<?= base_url('app/memo_view/') . $detail['memo'] ?>" target="_blank"><?= $detail['judul'] ?></a>
                        <?php } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="rekening" class="form-label">No. Rekening</label>
                    <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['no_rekening'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
                    <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['metode_pembayaran'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control"></textarea>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                    <?php } else { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="tanggal" class="form-label">Tanggal Bayar</label>
                    <?php if ($detail['date_bayar'] == null) { ?>
                      <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                    <?php } else { ?>
                      <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= $detail['date_bayar'] ?>">
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="status" class="form-label">Status Pengajuan</label>
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <select name="status" id="status" class="form-control">
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Disetujui </option>
                        <option value="2">Ditolak </option>
                      </select>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" selected>Disetujui </option>
                        <option value="2">Ditolak </option>
                      </select>
                    <?php } else { ?>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Disetujui </option>
                        <option value="2" selected>Ditolak </option>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="direksi" class="form-label">Approval Direksi</label>
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <select name="direksi" id="direksi" class="form-control">
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Ya </option>
                        <option value="2" selected>Tidak </option>
                      </select>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <select name="direksi" id="direksi" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                        <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                      </select>
                    <?php } else { ?>
                      <select name="direksi" id="direksi" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                        <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="nama_direksi">Direksi</label>
                    <select name="nama_direksi" id="nama_direksi" class="form-control select2" style="width: 100%;" disabled>
                      <option value=""> -- Pilih Direksi -- </option>
                      <?php
                      $direksi = $this->db->get_where('users', ['level_jabatan > ' => 4])->result_array();
                      foreach ($direksi as $d) {
                      ?>
                        <option value="<?= $d['nip'] ?>" <?= $d['nip'] == $detail['direksi'] ? 'selected' : '' ?>><?= $d['nama'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="file" class="form-label">Bukti Bayar</label>
                    <input type="file" class="form-control" name="bukti-bayar" id="bukti-bayar">
                  </div>
                </div>
              </div>
              <div class="row">
                <button class="btn btn-danger" type="reset">Reset</button>
                <button class="btn btn-primary btn-submit" type="submit">Bayar</button>
              </div>
            </form>
          <?php } ?>
          <?php if ($detail['posisi'] == 'Sudah Dibayar' && $this->uri->segment(2) == 'detail') {
          ?>
            <form action="<?= base_url('pengajuan/update_keuangan') ?>" method="post" enctype="multipart/form-data" id="update-keuangan">
              <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $detail['Id'] ?>">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Qty</th>
                      <th>Price</th>
                      <th>Total</th>
                      <th>COA</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['no_pengajuan']])->result_array();
                    foreach ($item as $i) {
                    ?>
                      <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                      <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                      <tr>
                        <td><?= $i['item'] ?></td>
                        <td><?= $i['qty'] ?></td>
                        <td><?= number_format($i['price']) ?></td>
                        <td><?= number_format($i['total']) ?></td>
                        <td>
                          <select name="coa_debit[]" id="coa_debit<?= $i['Id'] ?>" class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;" disabled>
                            <?php foreach ($coa as $c) { ?>
                              <option value="<?= $c['no_sbb'] ?>" <?= $c['no_sbb'] == $i['debit'] ? 'selected' : '' ?>><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>
                          <select name="coa_debit[]" id="coa_debit<?= $i['Id'] ?>" class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;" disabled>
                            <?php foreach ($coa as $c) { ?>
                              <option value="<?= $c['no_sbb'] ?>" <?= $c['no_sbb'] == $i['kredit'] ? 'selected' : '' ?>><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td colspan="3" align="end"><b>Total</b></td>
                      <td><input type="text" class="form-control" name="total_pengajuan[]" id="total_pengajuan" value="<?= number_format($detail['total']) ?>" readonly></td>
                    </tr>
                    <tr>
                      <td><b>Lampiran</b></td>
                      <td colspan="4"><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a></td>
                    </tr>
                    <tr>
                      <td><b>Catatan User</b></td>
                      <td colspan="4"><?= $detail['catatan'] ?></td>
                    </tr>
                  </tbody>
                </table>
                <table style="margin-top: 20px;" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Attachment Pengajuan</th>
                      <th>Attachment Bayar</th>
                      <th style="width: 40%;">Memo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-xs" target="_blank">Download</a></td>
                      <td>
                        <?php if ($detail['bukti_bayar']) { ?>
                          <a href="<?= base_url('upload/pengajuan/' . $detail['bukti_bayar']) ?>" class="btn btn-success btn-xs" target="_blank">Download</a>
                        <?php } else { ?>
                          <span>-</span>
                        <?php } ?>
                      </td>
                      <td>
                        <?php
                        $memo = $this->db->get_where('memo', ['Id' => $detail['memo']])->row_array();
                        if ($detail['memo']) {
                        ?>
                          <a href="<?= base_url('app/memo_view/') . $detail['memo'] ?>" target="_blank"><?= $memo['judul'] ?></a>
                        <?php } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="rekening" class="form-label">No. Rekening</label>
                    <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['no_rekening'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
                    <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['metode_pembayaran'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control"></textarea>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                    <?php } else { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="status" class="form-label">Status Pengajuan</label>
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <select name="status" id="status" class="form-control">
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Disetujui </option>
                        <option value="2">Ditolak </option>
                      </select>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" selected>Disetujui </option>
                        <option value="2">Ditolak </option>
                      </select>
                    <?php } else { ?>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Disetujui </option>
                        <option value="2" selected>Ditolak </option>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="direksi" class="form-label">Approval Direksi</label>
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <select name="direksi" id="direksi" class="form-control">
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Ya </option>
                        <option value="2" selected>Tidak </option>
                      </select>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <select name="direksi" id="direksi" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                        <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                      </select>
                    <?php } else { ?>
                      <select name="direksi" id="direksi" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                        <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="nama_direksi">Direksi</label>
                    <select name="nama_direksi" id="nama_direksi" class="form-control select2" style="width: 100%;" disabled>
                      <option value=""> -- Pilih Direksi -- </option>
                      <?php
                      $direksi = $this->db->get_where('users', ['level_jabatan > ' => 4])->result_array();
                      foreach ($direksi as $d) {
                      ?>
                        <option value="<?= $d['nip'] ?>"><?= $d['nama'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <?php if ($detail['status_keuangan'] == 0) { ?>
                  <button class="btn btn-danger" type="reset">Reset</button>
                  <button class="btn btn-primary" type="submit" id="btn-keuangan">Save</button>
                <?php } ?>
              </div>
            </form>
          <?php } ?>

          <?php if ($detail['posisi'] == 'Diajukan kepada keuangan' && $this->uri->segment(2) == 'detail') {
          ?>
            <form action="<?= base_url('pengajuan/update_keuangan') ?>" method="post" enctype="multipart/form-data" id="update-keuangan">
              <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $detail['Id'] ?>">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Qty</th>
                      <th>Price</th>
                      <th>Total</th>
                      <th>COA</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['no_pengajuan']])->result_array();
                    foreach ($item as $i) {
                    ?>
                      <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                      <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                      <tr>
                        <td><?= $i['item'] ?></td>
                        <td><?= $i['qty'] ?></td>
                        <td><?= number_format($i['price']) ?></td>
                        <td><?= number_format($i['total']) ?></td>
                        <td>
                          <select name="coa_debit[]" id="coa_debit<?= $i['Id'] ?>" class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;">
                            <option value=""> :: Pilih Nomor COA :: </option>
                            <?php foreach ($coa as $cd) { ?>
                              <option value="<?= $cd['no_sbb'] ?>" <?= $cd['no_sbb'] == '1109002' ? 'selected' : '' ?>><?= $cd['no_sbb'] . ' - ' . $cd['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>

                      <script>
                        $(document).ready(function() {
                          $('#coa_debit<?= $i['Id'] ?>').select2({
                            // templateSelection: formatStateDebit
                          })

                          $('#coa_debit<?= $i['Id'] ?>').change(function() {
                            console.log($(this).val());
                          })
                        })

                        function formatStateDebit(state) {
                          console.log(state);
                        }
                      </script>
                    <?php } ?>
                    <tr>
                      <td colspan="3" align="end"><b>Total</b></td>
                      <td><input type="text" class="form-control" name="total_pengajuan[]" id="total_pengajuan" value="<?= number_format($detail['total']) ?>" readonly></td>
                    </tr>
                    <tr>
                      <td><b>Lampiran</b></td>
                      <td colspan="4"><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a></td>
                    </tr>
                    <tr>
                      <td><b>Catatan User</b></td>
                      <td colspan="4"><?= $detail['catatan'] ?></td>
                    </tr>
                  </tbody>
                </table>
                <table style="margin-top: 20px;" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Attachment Pengajuan</th>
                      <th>Attachment Bayar</th>
                      <th style="width: 40%;">Memo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-xs" target="_blank">Download</a></td>
                      <td>
                        <?php if ($detail['bukti_bayar']) { ?>
                          <a href="<?= base_url('upload/pengajuan/' . $detail['bukti_bayar']) ?>" class="btn btn-success btn-xs" target="_blank">Download</a>
                        <?php } else { ?>
                          <span>-</span>
                        <?php } ?>
                      </td>
                      <td>
                        <?php
                        $memo = $this->db->get_where('memo', ['Id' => $detail['memo']])->row_array();
                        if ($detail['memo']) {
                        ?>
                          <a href="<?= base_url('app/memo_view/') . $detail['memo'] ?>" target="_blank"><?= $memo['judul'] ?></a>
                        <?php } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="rekening" class="form-label">No. Rekening</label>
                    <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['no_rekening'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
                    <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['metode_pembayaran'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control"></textarea>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                    <?php } else { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <?php if ($detail['date_keuangan'] == null) { ?>
                      <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                    <?php } else { ?>
                      <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= $detail['date_keuangan'] ?>">
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="status" class="form-label">Status Pengajuan</label>
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <select name="status" id="status" class="form-control">
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Disetujui </option>
                        <option value="2">Ditolak </option>
                      </select>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" selected>Disetujui </option>
                        <option value="2">Ditolak </option>
                      </select>
                    <?php } else { ?>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Disetujui </option>
                        <option value="2" selected>Ditolak </option>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="direksi" class="form-label">Approval Direksi</label>
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <select name="direksi" id="direksi" class="form-control">
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Ya </option>
                        <option value="2" selected>Tidak </option>
                      </select>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <select name="direksi" id="direksi" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                        <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                      </select>
                    <?php } else { ?>
                      <select name="direksi" id="direksi" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                        <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="nama_direksi">Direksi</label>
                    <select name="nama_direksi" id="nama_direksi" class="form-control select2" style="width: 100%;" disabled>
                      <option value=""> -- Pilih Direksi -- </option>
                      <?php
                      $direksi = $this->db->get_where('users', ['level_jabatan > ' => 4])->result_array();
                      foreach ($direksi as $d) {
                      ?>
                        <option value="<?= $d['nip'] ?>"><?= $d['nama'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <?php if ($detail['status_keuangan'] == 0) { ?>
                  <button class="btn btn-danger" type="reset">Reset</button>
                  <button class="btn btn-primary btn-submit" type="submit">Save</button>
                <?php } ?>
              </div>
            </form>
          <?php } ?>

          <?php if ($detail['posisi'] == 'Diarahkan ke pembayaran' && $this->uri->segment(2) == 'detail') {
          ?>
            <form action="<?= base_url('pengajuan/update_keuangan') ?>" method="post" enctype="multipart/form-data" id="update-keuangan">
              <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $detail['Id'] ?>">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Qty</th>
                      <th>Price</th>
                      <th>Total</th>
                      <th>COA</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['no_pengajuan']])->result_array();
                    foreach ($item as $i) {
                    ?>
                      <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                      <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                      <tr>
                        <td><?= $i['item'] ?></td>
                        <td><?= $i['qty'] ?></td>
                        <td><?= number_format($i['price']) ?></td>
                        <td><?= number_format($i['total']) ?></td>
                        <td>
                          <select name="coa_debit[]" id="coa_debit<?= $i['Id'] ?>" class="form-control select2" style="width: 100%;" disabled>
                            <?php foreach ($coa as $c) { ?>
                              <option value="<?= $c['no_sbb'] ?>" <?= $c['no_sbb'] == $i['debit'] ? 'selected' : '' ?>><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <script>
                        // $(document).ready(function() {
                        //   $('.coa_debit<?= $i['Id'] ?>').select2()
                        // })
                      </script>
                    <?php } ?>
                    <tr>
                      <td colspan="3" align="end"><b>Total</b></td>
                      <td><input type="text" class="form-control" name="total_pengajuan[]" id="total_pengajuan" value="<?= number_format($detail['total']) ?>" readonly></td>
                    </tr>
                    <tr>
                      <td><b>Lampiran</b></td>
                      <td colspan="4"><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a></td>
                    </tr>
                    <tr>
                      <td><b>Catatan User</b></td>
                      <td colspan="4"><?= $detail['catatan'] ?></td>
                    </tr>
                  </tbody>
                </table>
                <table style="margin-top: 20px;" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Attachment Pengajuan</th>
                      <th>Attachment Bayar</th>
                      <th style="width: 40%;">Memo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-xs" target="_blank">Download</a></td>
                      <td>
                        <?php if ($detail['bukti_bayar']) { ?>
                          <a href="<?= base_url('upload/pengajuan/' . $detail['bukti_bayar']) ?>" class="btn btn-success btn-xs" target="_blank">Download</a>
                        <?php } else { ?>
                          <span>-</span>
                        <?php } ?>
                      </td>
                      <td>
                        <?php
                        $memo = $this->db->get_where('memo', ['Id' => $detail['memo']])->row_array();
                        if ($detail['memo']) {
                        ?>
                          <a href="<?= base_url('app/memo_view/') . $detail['memo'] ?>" target="_blank"><?= $memo['judul'] ?></a>
                        <?php } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="rekening" class="form-label">No. Rekening</label>
                    <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['no_rekening'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
                    <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['metode_pembayaran'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control"></textarea>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                    <?php } else { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="status" class="form-label">Status Pengajuan</label>
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <select name="status" id="status" class="form-control">
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Disetujui </option>
                        <option value="2">Ditolak </option>
                      </select>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" selected>Disetujui </option>
                        <option value="2">Ditolak </option>
                      </select>
                    <?php } else { ?>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Disetujui </option>
                        <option value="2" selected>Ditolak </option>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="direksi" class="form-label">Approval Direksi</label>
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <select name="direksi" id="direksi" class="form-control">
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Ya </option>
                        <option value="2" selected>Tidak </option>
                      </select>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <select name="direksi" id="direksi" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                        <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                      </select>
                    <?php } else { ?>
                      <select name="direksi" id="direksi" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                        <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="nama_direksi">Direksi</label>
                    <select name="nama_direksi" id="nama_direksi" class="form-control select2" style="width: 100%;" disabled>
                      <option value=""> -- Pilih Direksi -- </option>
                      <?php
                      $direksi = $this->db->get_where('users', ['level_jabatan > ' => 4])->result_array();
                      foreach ($direksi as $d) {
                      ?>
                        <option value="<?= $d['nip'] ?>"><?= $d['nama'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <?php if ($detail['status_keuangan'] == 0) { ?>
                  <button class="btn btn-danger" type="reset">Reset</button>
                  <button class="btn btn-primary" type="submit" id="btn-keuangan">Save</button>
                <?php } ?>
              </div>
            </form>
          <?php } ?>

          <?php if ($this->uri->segment(2) == "detail" && $detail['posisi'] == 'Closed') { ?>
            <form action="<?= base_url('pengajuan/update_keuangan') ?>" method="post" enctype="multipart/form-data" id="update-keuangan">
              <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $detail['Id'] ?>">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th style="width: 2%;">Qty</th>
                      <th style="width: 15%;">Harga Satuan</th>
                      <th style="width: 15%;">Total</th>
                      <th style="width: 15%;">Realisasi</th>
                      <th style="width: 30%;">COA</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['no_pengajuan']])->result_array();
                    foreach ($item as $i) {
                    ?>
                      <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                      <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                      <tr>
                        <td><?= $i['item'] ?></td>
                        <td><?= $i['qty'] ?></td>
                        <td><input type="text" class="form-control" name="price[]" id="price<?= $i['Id'] ?>" value="<?= number_format($i['price']) ?>" readonly></td>
                        <td>
                          <input type="text" class="form-control" name="total_item[]" id="total_item<?= $i['Id'] ?>" value="<?= number_format($i['total']) ?>" readonly>
                        </td>
                        <td>
                          <input type="text" class="form-control" disabled value="<?= number_format($i['realisasi']) ?>">
                        </td>
                        <td>
                          <select class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;" disabled>
                            <?php foreach ($coa as $cd) { ?>
                              <option value="<?= $cd['no_sbb'] ?>" <?= $cd['no_sbb'] == $i['debit'] ? 'selected' : '' ?>><?= $cd['no_sbb'] . ' - ' . $cd['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>

                          <select class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;" disabled>
                            <?php foreach ($coa as $ck) { ?>
                              <option value="<?= $ck['no_sbb'] ?>" <?= $ck['no_sbb'] == $i['kredit'] ? 'selected' : '' ?>><?= $ck['no_sbb'] . ' - ' . $ck['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>

                          <select class="form-control coa_debit<?= $i['Id'] ?>" style="width: 100%;" disabled>
                            <?php foreach ($coa as $cb) { ?>
                              <option value="<?= $cb['no_sbb'] ?>" <?= $cb['no_sbb'] == $i['beban'] ? 'selected' : '' ?>><?= $cb['no_sbb'] . ' - ' . $cb['nama_perkiraan'] ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <script>
                        $(document).ready(function() {
                          $('.coa_debit<?= $i['Id'] ?>').select2();

                          $('#coa_debit<?= $i['Id'] ?>').change(function() {
                            var id = $(this).val();
                            $.ajax({
                              url: '<?= base_url('pengajuan/getDataCoa/') ?>' + id,
                              method: 'GET',
                              dataType: 'JSON',
                              success: function(res) {
                                if (res.anggaran) {
                                  $('#anggaran<?= $i['Id'] ?>').val(formatNumber(res.anggaran));
                                } else {
                                  $('#anggaran<?= $i['Id'] ?>').val(0);
                                }
                              }
                            })
                          })

                        })
                      </script>
                    <?php } ?>
                    <tr>
                      <td colspan="3" align="end"><b>Total</b></td>
                      <td><input type="text" class="form-control" value="<?= number_format($detail['total']) ?>" readonly></td>
                      <td><input type="text" class="form-control" value="<?= number_format($detail['total_realisasi']) ?>" readonly></td>
                    </tr>
                    <tr>
                      <td><b>Lampiran</b></td>
                      <td colspan="5"><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a></td>
                    </tr>
                    <tr>
                      <td><b>Catatan User</b></td>
                      <td colspan="5"><?= $detail['catatan'] ?></td>
                    </tr>
                  </tbody>
                </table>
                <table style="margin-top: 20px;" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Attachment Pengajuan</th>
                      <th>Attachment Bayar</th>
                      <th style="width: 40%;">Memo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-xs" target="_blank">Download</a></td>
                      <td>
                        <?php if ($detail['bukti_bayar']) { ?>
                          <a href="<?= base_url('upload/pengajuan/' . $detail['bukti_bayar']) ?>" class="btn btn-success btn-xs" target="_blank">Download</a>
                        <?php } else { ?>
                          <span>-</span>
                        <?php } ?>
                      </td>
                      <td>
                        <?php
                        $memo = $this->db->get_where('memo', ['Id' => $detail['memo']])->row_array();
                        if ($detail['memo']) {
                        ?>
                          <a href="<?= base_url('app/memo_view/') . $detail['memo'] ?>" target="_blank"><?= $memo['judul'] ?></a>
                        <?php } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="rekening" class="form-label">No. Rekening</label>
                    <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['no_rekening'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
                    <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['metode_pembayaran'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control"></textarea>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                    <?php } else { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="status" class="form-label">Status Pengajuan</label>
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <select name="status" id="status" class="form-control">
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Disetujui </option>
                        <option value="2">Ditolak </option>
                      </select>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" selected>Disetujui </option>
                        <option value="2">Ditolak </option>
                      </select>
                    <?php } else { ?>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Disetujui </option>
                        <option value="2" selected>Ditolak </option>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="direksi" class="form-label">Approval Direksi</label>
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <select name="direksi" id="direksi" class="form-control">
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Ya </option>
                        <option value="2" selected>Tidak </option>
                      </select>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <select name="direksi" id="direksi" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                        <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                      </select>
                    <?php } else { ?>
                      <select name="direksi" id="direksi" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                        <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="nama_direksi">Direksi</label>
                    <select name="nama_direksi" id="nama_direksi" class="form-control select2" style="width: 100%;" disabled>
                      <option value=""> -- Pilih Direksi -- </option>
                      <?php
                      $direksi = $this->db->get_where('users', ['level_jabatan > ' => 4])->result_array();
                      foreach ($direksi as $d) {
                      ?>
                        <option value="<?= $d['nip'] ?>"><?= $d['nama'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <?php if ($detail['status_keuangan'] == 0) { ?>
                  <button class="btn btn-danger" type="reset">Reset</button>
                  <button class="btn btn-primary" type="submit" id="btn-keuangan">Save</button>
                <?php } ?>
              </div>
            </form>
          <?php } ?>

          <?php if ($this->uri->segment(2) == 'close') { ?>
            <form action="<?= base_url('pengajuan/update_close') ?>" method="post" enctype="multipart/form-data" id="close-pengajuan">
              <input type="hidden" name="id_pengajuan" id="id_pengajuan" value="<?= $detail['Id'] ?>">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Total</th>
                      <th>COA</th>
                      <th>Realisasi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $item = $this->cb->get_where('t_pengajuan_detail', ['no_pengajuan' => $detail['no_pengajuan']])->result_array();
                    foreach ($item as $i) {
                    ?>
                      <input type="hidden" class="form-control" name="row_item[]" id="row<?= $i['Id'] ?>">
                      <input type="hidden" class="form-control" name="id_item[]" id="id_item<?= $i['Id'] ?>" value="<?= $i['Id'] ?>">
                      <tr>
                        <td><?= $i['item'] ?></td>
                        <td>
                          <input type="text" class="form-control" name="total_item[]" id="total_item<?= $i['Id'] ?>" value="<?= number_format($i['total']) ?>" readonly>
                        </td>
                        <td>
                          <?php if ($detail['posisi'] != 'Closed') { ?>
                            <select name="coa_beban[]" id="coa_beban<?= $i['Id'] ?>" class="form-control coa_beban<?= $i['Id'] ?>" style="width: 100%;">
                              <option value=""> -- Pilih COA Beban -- </option>
                              <?php foreach ($coa_beban as $c) { ?>
                                <option value="<?= $c['no_sbb'] ?>"><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                              <?php } ?>
                            </select>
                          <?php } else { ?>
                            <select name="coa_beban[]" id="coa_beban<?= $i['Id'] ?>" class="form-control coa_beban<?= $i['Id'] ?>" style="width: 100%;" disabled>
                              <?php foreach ($coa_beban as $c) { ?>
                                <option value="<?= $c['no_sbb'] ?>" <?= $c['no_sbb'] == $i['beban'] ? 'selected' : '' ?>><?= $c['no_sbb'] . ' - ' . $c['nama_perkiraan'] ?></option>
                              <?php } ?>
                            </select>
                          <?php } ?>
                        </td>
                        <td>
                          <?php if ($detail['posisi'] != "Closed") { ?>
                            <input type="text" class="form-control" name="realisasi[]" id="realisasi<?= $i['Id'] ?>">
                          <?php } else { ?>
                            <input type="text" class="form-control" name="realisasi[]" id="realisasi<?= $i['Id'] ?>" value="<?= number_format($i['realisasi']) ?>" disabled>
                          <?php } ?>
                        </td>
                      </tr>
                      <script>
                        $(document).ready(function() {
                          $('.coa_beban<?= $i['Id'] ?>').select2();
                        })
                      </script>
                    <?php } ?>
                    <tr>
                      <td><b>Total</b></td>
                      <td><input type="text" class="form-control" name="total_pengajuan[]" id="total_pengajuan" value="<?= number_format($detail['total']) ?>" readonly></td>
                    </tr>
                    <tr>
                      <td><b>Lampiran</b></td>
                      <td colspan="4"><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-sm" target="_blank">Lampiran Pengajuan</a></td>
                    </tr>
                    <tr>
                      <td><b>Catatan User</b></td>
                      <td colspan="4"><?= $detail['catatan'] ?></td>
                    </tr>
                  </tbody>
                </table>
                <table style="margin-top: 20px;" class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Attachment Pengajuan</th>
                      <th>Attachment Bayar</th>
                      <th style="width: 40%;">Memo</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><a href="<?= base_url('upload/pengajuan/' . $detail['bukti_pengajuan']) ?>" class="btn btn-success btn-xs" target="_blank">Download</a></td>
                      <td>
                        <?php if ($detail['bukti_bayar']) { ?>
                          <a href="<?= base_url('upload/pengajuan/' . $detail['bukti_bayar']) ?>" class="btn btn-success btn-xs" target="_blank">Download</a>
                        <?php } else { ?>
                          <span>-</span>
                        <?php } ?>
                      </td>
                      <td>
                        <?php
                        $memo = $this->db->get_where('memo', ['Id' => $detail['memo']])->row_array();
                        if ($detail['memo']) {
                        ?>
                          <a href="<?= base_url('app/memo_view/') . $detail['memo'] ?>" target="_blank"><?= $memo['judul'] ?></a>
                        <?php } ?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="rekening" class="form-label">No. Rekening</label>
                    <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['no_rekening'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <label for="pembayaran" class="form-label">Jenis Pembayaran</label>
                    <input type="text" class="form-control" name="rekening" id="rekening" value="<?= $detail['metode_pembayaran'] ?>" readonly>
                  </div>
                  <div class="form-group">
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control"></textarea>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                    <?php } else { ?>
                      <label for="catatan" class="form-label">Catatan</label>
                      <textarea name="catatan" id="catatan" class="form-control" disabled><?= $detail['catatan_keuangan'] ?></textarea>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="tanggal" class="form-label">Tanggal Close</label>
                    <?php if ($detail['date_close'] == null) { ?>
                      <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= date('Y-m-d') ?>">
                    <?php } else { ?>
                      <input type="date" class="form-control" name="tanggal" id="tanggal" value="<?= $detail('date_close') ?>">
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="status" class="form-label">Status Pengajuan</label>
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <select name="status" id="status" class="form-control">
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Disetujui </option>
                        <option value="2">Ditolak </option>
                      </select>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" selected>Disetujui </option>
                        <option value="2">Ditolak </option>
                      </select>
                    <?php } else { ?>
                      <select name="status" id="status" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Disetujui </option>
                        <option value="2" selected>Ditolak </option>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="direksi" class="form-label">Approval Direksi</label>
                    <?php if ($detail['status_keuangan'] == 0) { ?>
                      <select name="direksi" id="direksi" class="form-control">
                        <option value="">:: Pilih Status ::</option>
                        <option value="1">Ya </option>
                        <option value="2" selected>Tidak </option>
                      </select>
                    <?php } else if ($detail['status_keuangan'] == 1) { ?>
                      <select name="direksi" id="direksi" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                        <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                      </select>
                    <?php } else { ?>
                      <select name="direksi" id="direksi" class="form-control" disabled>
                        <option value="">:: Pilih Status ::</option>
                        <option value="1" <?= $detail['jenis_pengajuan'] == 1 ? 'selected' : '' ?>>Ya </option>
                        <option value="2" <?= $detail['jenis_pengajuan'] == 2 ? 'selected' : '' ?>>Tidak </option>
                      </select>
                    <?php } ?>
                  </div>
                  <div class="form-group">
                    <label for="nama_direksi">Direksi</label>
                    <select name="nama_direksi" id="nama_direksi" class="form-control select2" style="width: 100%;" disabled>
                      <option value=""> -- Pilih Direksi -- </option>
                      <?php
                      $direksi = $this->db->get_where('users', ['level_jabatan > ' => 4])->result_array();
                      foreach ($direksi as $d) {
                      ?>
                        <option value="<?= $d['nip'] ?>"><?= $d['nama'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <?php if ($detail['posisi'] != 'Closed') { ?>
                  <button class="btn btn-danger" type="reset">Reset</button>
                  <button class="btn btn-primary btn-submit" type="submit">Close</button>
                <?php } ?>
              </div>
            </form>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Finish content-->
<script>
  $(document).ready(function() {
    // $('.select2').select2();
    $("select[name='direksi']").change(function() {
      var val = $(this).val();
      if (val == 1) {
        $('#nama_direksi').attr('disabled', false);
      } else {
        $('#nama_direksi').attr('disabled', true);
      }
    })

    // $("button[id='btn-keuangan']").click(function(e) {
    //   var url = $('form[id="update-keuangan"]').attr("action");
    //   var formData = new FormData($("form#update-keuangan")[0]);
    //   e.preventDefault();
    //   Swal.fire({
    //     title: "Are you sure?",
    //     text: "You want to submit the form?",
    //     icon: "warning",
    //     showCancelButton: true,
    //     confirmButtonColor: "#3085d6",
    //     cancelButtonColor: "#d33",
    //     confirmButtonText: "Yes",
    //   }).then((result) => {
    //     if (result.isConfirmed) {
    //       $.ajax({
    //         url: url,
    //         method: "POST",
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         dataType: "JSON",
    //         beforeSend: () => {
    //           Swal.fire({
    //             title: "Loading....",
    //             timerProgressBar: true,
    //             allowOutsideClick: false,
    //             didOpen: () => {
    //               Swal.showLoading();
    //             },
    //           });
    //         },
    //         success: function(res) {
    //           if (res.success) {
    //             Swal.fire({
    //               icon: "success",
    //               title: `${res.msg}`,
    //               showConfirmButton: false,
    //               timer: 1500,
    //             }).then(function() {
    //               Swal.close();
    //               location.href = '<?= base_url('pengajuan/approval_keuangan') ?>';
    //             });
    //           } else {
    //             Swal.fire({
    //               icon: "error",
    //               title: `${res.msg}`,
    //               showConfirmButton: false,
    //               timer: 1500,
    //             }).then(function() {
    //               Swal.close();
    //             });
    //           }
    //         },
    //         error: function(xhr, status, error) {
    //           Swal.fire({
    //             icon: "error",
    //             title: `${error}`,
    //             showConfirmButton: false,
    //             timer: 1500,
    //           });
    //         },
    //       });
    //     }
    //   });
    // })
    $("button[id='btn-update-bayar']").click(function(e) {
      var url = $('form[id="update-bayar"]').attr("action");
      var formData = new FormData($("form#update-bayar")[0]);
      e.preventDefault();
      Swal.fire({
        title: "Are you sure?",
        text: "You want to submit the form?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            beforeSend: () => {
              Swal.fire({
                title: "Loading....",
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                  Swal.showLoading();
                },
              });
            },
            success: function(res) {
              if (res.success) {
                Swal.fire({
                  icon: "success",
                  title: `${res.msg}`,
                  showConfirmButton: false,
                  timer: 1500,
                }).then(function() {
                  Swal.close();
                  location.href = '<?= base_url('pengajuan/approval_keuangan') ?>';
                });
              } else {
                Swal.fire({
                  icon: "error",
                  title: `${res.msg}`,
                  showConfirmButton: false,
                  timer: 1500,
                }).then(function() {
                  Swal.close();
                });
              }
            },
            error: function(xhr, status, error) {
              Swal.fire({
                icon: "error",
                title: `${error}`,
                showConfirmButton: false,
                timer: 1500,
              });
            },
          });
        }
      });
    })

    $("button[id='btn-close']").click(function(e) {
      var url = $('form[id="close-pengajuan"]').attr("action");
      var formData = new FormData($("form#close-pengajuan")[0]);
      e.preventDefault();
      Swal.fire({
        title: "Are you sure?",
        text: "You want to submit the form?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: url,
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "JSON",
            beforeSend: () => {
              Swal.fire({
                title: "Loading....",
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                  Swal.showLoading();
                },
              });
            },
            success: function(res) {
              if (res.success) {
                Swal.fire({
                  icon: "success",
                  title: `${res.msg}`,
                  showConfirmButton: false,
                  timer: 1500,
                }).then(function() {
                  Swal.close();
                  location.href = '<?= base_url('pengajuan/approval_keuangan') ?>';
                });
              } else {
                Swal.fire({
                  icon: "error",
                  title: `${res.msg}`,
                  showConfirmButton: false,
                  timer: 1500,
                }).then(function() {
                  Swal.close();
                });
              }
            },
            error: function(xhr, status, error) {
              Swal.fire({
                icon: "error",
                title: `${error}`,
                showConfirmButton: false,
                timer: 1500,
              });
            },
          });
        }
      });
    })

    $(document).on('input', 'input[name="realisasi[]"]', function() {
      var value = $(this).val();
      var formattedValue = parseFloat(value.split('.').join(''));
      $(this).val(formattedValue);
    });

    // Tambahkan event listener untuk event keyup
    $(document).on('keyup', 'input[name="realisasi[]"]', function() {
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