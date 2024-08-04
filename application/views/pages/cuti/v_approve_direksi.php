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
    <div class="title">
      <h3><b>Data Approval Direksi</b></h3>
    </div>
    <div>
      <button onclick="history.back()" class="btn btn-warning"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali</button>
    </div>
    <div class="table-responsive" style="margin-top: 2em;">
      <table id="table-approve-atasan" class="table table-striped jambo_table bulk_action" width="100%">
        <thead>
          <tr class="headings">
            <th class="column-title">No.</th>
            <th class="column-title">Nama</th>
            <th class="column-title">Jenis Cuti</th>
            <th class="column-title">Alasan Cuti</th>
            <th class="column-title">Tanggal Pengajuan</th>
            <th class="column-title">Mulai Cuti</th>
            <th class="column-title">Jumlah Cuti</th>
            <th class="column-title">Atasan</th>
            <th class="column-title">Status</th>
            <th class="column-title">Aksi</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Modal Detail Cuti -->
<div class="modal fade " id="detail-cuti">
  <div class="modal-dialog modal-centered">
    <div class="modal-content">
      <!-- header-->
      <div class="modal-header">
        <button class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail Cuti</h4>
      </div>
      <!--body-->
      <div class="modal-body">
        <table class="table" width="100%" id="detail-cuti-byID">

        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Update Cuti -->
<div class="modal fade" id="modal-update-cuti-direksi">
  <div class="modal-dialog modal-centered">
    <div class="modal-content">
      <!-- header-->
      <div class="modal-header">
        <button class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Cuti</h4>
      </div>
      <!--body-->
      <div class="modal-body">
        <form action="<?= base_url('cuti/update_cuti_direksi/') ?>" id="form-update-cuti-direksi" method="post">
          <div class="form-group">
            <input type="hidden" readonly class="form-control" id="update_direksi" name="update_direksi">
            <input type="hidden" readonly class="form-control" id="id_cuti_direksi" name="id_cuti">
          </div>
          <div class="form-group" id="error_jenis">
            <label for="status_cuti">Status</label>
            <select class="form-control select2" id="status_cuti" name="status_cuti" style="width:100%;">
              <option value=""> -- Pilih Status Cuti --</option>
              <option value="Disetujui">Disetujui</option>
              <option value="Ditolak">Ditolak</option>
            </select>
            <span id="err_status_cuti" class="text-danger"></span>
          </div>
          <div class="form-group" id="select-pengganti">
            <label for="pengganti">Pengganti</label>
            <select class="form-control select2" id="pengganti" name="pengganti" style="width: 100%;">
              <option value="">-- Pilih Pengganti --</option>
            </select>
            <span class="text-danger" id="err_pengganti"></span>
          </div>
          <div class="form-group">
            <label for="catatan">Catatan (Opsional)</label>
            <textarea class="form-control" name="catatan" id="catatan" rows="3"></textarea>
          </div>
          <!--footer-->
          <div class="modal-footer">
            <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Tutup</button>
            <button type="submit" class="btn btn-primary" id="btn-update-cuti-direksi"><i class="fa fa-paper-plane" aria-hidden="true"></i> Update</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(() => {
    $('.select2').select2();

    var myTable = $('#table-approve-atasan').DataTable({
      "ajax": {
        type: "POST",
        url: "<?= base_url('cuti/data_approve_direksi') ?>",
        data: function(d) {

        }
      },
    })

    $("#select-pengganti").hide();
    $("#status_cuti").change(function() {
      var value = $(this).val();
      var id = $("#id_cuti_direksi").val();
      var direksi = $("#update_direksi").val();
      $.ajax({
        url: "<?= base_url('cuti/approveAtasan/') ?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(res) {
          if (direksi == 'dirsdm') {
            if (res.cuti.atasan == res.cuti.dirsdm) {
              $("#pengganti").html(res.option);
              if (value == "Disetujui") {
                $("#select-pengganti").show();
              } else {
                $("#select-pengganti").hide();
              }
            }
          } else {
            if (res.cuti.atasan == res.cuti.dirut) {
              $("#pengganti").html(res.option);
              if (value == "Disetujui") {
                $("#select-pengganti").show();
              } else {
                $("#select-pengganti").hide();
              }
            }
          }
        }
      })
    })

    $("#btn-update-cuti-direksi").click(function(e) {
      e.preventDefault();
      Swal.fire({
        icon: 'warning',
        title: "Apakah anda yakin data cuti sudah sesuai dan dapat dipertanggung jawabkan?",
        showCancelButton: true,
        cancelButtonText: "Batal",
        confirmButtonText: "Ya",
      }).then((result) => {
        if (result.isConfirmed) {
          var url = $("#form-update-cuti-direksi").attr('action');
          var id = $("#id_cuti_direksi").val();
          var direksi = $("#update_direksi").val();
          var status_cuti = $("#status_cuti").val();
          var catatan = $("#catatan").val();
          var pengganti = $('#pengganti').val();

          $.ajax({
            url: url + id,
            type: "POST",
            dataType: "JSON",
            data: {
              status_cuti: status_cuti,
              catatan: catatan,
              direksi: direksi,
              pengganti: pengganti
            },
            beforeSend: () => {
              Swal.fire({
                title: 'Loading...',
                timerProgressBar: true,
                allowOutsideClick: false,
                didOpen: () => {
                  Swal.showLoading()
                },
              })
            },
            success: function(res) {
              console.log(res);
              if (!res.error) {
                Swal.fire({
                    type: "success",
                    icon: "success",
                    title: `${res.msg}`,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                  },
                  setTimeout(function() {
                    window.location.reload();
                  }, 1500)
                );
              } else {
                Swal.fire({
                    icon: "error",
                    title: `${res.msg}`,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                  },
                  setTimeout(function() {
                    Swal.close();
                    res.err_status ?
                      $("span#err_status_cuti").html(
                        res.err_status
                      ) :
                      $("span#err_status_cuti").html("");
                    res.err_pengganti ?
                      $("span#err_pengganti").html(
                        res.err_pengganti
                      ) :
                      $("span#err_pengganti").html("");
                  }, 1500)
                );
              }
            }
          })
        }
      })
    })

  })

  function historyCuti(nip) {
    location.href = "<?= site_url('cuti/historyCuti/') ?>" + nip;
  }

  function confirmDirsdm(id) {
    $('#modal-update-cuti-direksi').modal('show');
    $('#id_cuti_direksi').val(id);
    $('#update_direksi').val('dirsdm')
  }

  function confirmDirut(id) {
    $('#modal-update-cuti-direksi').modal('show');
    $('#id_cuti_direksi').val(id);
    $('#update_direksi').val('dirut')
  }

  function detailCuti(id) {
    $("#detail-cuti").modal('show');
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: "<?= base_url('cuti/detailCuti/') ?>" + id,
      success: (res) => {
        $("#detail-cuti-byID").html(res);
      }
    })
  }

  function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
  }
</script>