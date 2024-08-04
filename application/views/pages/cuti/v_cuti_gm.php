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
<!-- page content -->
<div class="right_col" role="main">
  <div class="x_panel card">
    <div class="title">
      <h3><b>List Cuti All</b></h3>
    </div>
    <div>
      <a href="<?= site_url('cuti/view') ?>" class="btn btn-warning"><i class="fa fa-chevron-left" aria-hidden="true"></i> Kembali</a>
    </div>
    <div class="table-responsive" style="margin-top: 2em;">
      <table id="table-all-gm" class="table table-striped jambo_table bulk_action" width="100%">
        <thead>
          <tr class="headings">
            <th class="column-title">No.</th>
            <th class="column-title">Nama</th>
            <th class="column-title">Jenis Cuti</th>
            <th class="column-title">Alasan Cuti</th>
            <th class="column-title">Status HRD</th>
            <th class="column-title">Status Atasan</th>
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

<script type="text/javascript">
  $(document).ready(() => {
    $('.select2').select2();

    var myTable = $('#table-all-gm').DataTable({
      "ajax": {
        type: "POST",
        url: "<?= base_url('cuti/cuti_all_gm') ?>",
        data: function(d) {

        }
      },
    })
  })

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

  function historyCuti(nip) {
    location.href = "<?= site_url('cuti/historyCuti/') ?>" + nip;
  }

  function topFunction() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
  }
</script>