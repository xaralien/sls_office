$(document).ready(function () {
	$(".uang").mask("000.000.000.000.000", {
		reverse: true,
	});

	updateTotalItem();

	// Saat input qty atau harga diubah
	$(document).on(
		"input",
		'input[name="qty[]"], input[name="harga[]"]',
		function () {
			var value = $(this).val();
			var row = $(this).closest(".baris");
			hitungTotal(row);
			updateTotalItem();
			updateTotal();
		}
	);

	// Tambahkan event listener untuk event keyup
	$(document).on(
		"keyup",
		'input[name="qty[]"], input[name="harga[]"]',
		function () {
			var value = $(this).val().trim(); // Hapus spasi di awal dan akhir nilai
			var row = $(this).closest(".baris");
			hitungTotal(row);
			updateTotalItem();
			updateTotal();
		}
	);

	function hitungTotal(row) {
		var qty = row.find('input[name="qty[]"]').val().replace(/\./g, ""); // Hapus tanda titik
		var harga = row.find('input[name="harga[]"]').val().replace(/\./g, ""); // Hapus tanda titik
		qty = parseInt(qty); // Ubah string ke angka float
		harga = parseInt(harga); // Ubah string ke angka float

		qty = isNaN(qty) ? 0 : qty;
		harga = isNaN(harga) ? 0 : harga;

		var total = qty * harga;
		row.find('input[name="total[]"]').val(formatNumber(total));
		updateTotalItem();
	}

	function updateTotalItem() {
		var total_pos_fix = 0;
		$(".baris").each(function () {
			var total = $(this)
				.find('input[name="total[]"]')
				.val()
				.replace(/\./g, ""); // Ambil nilai total dari setiap baris
			total = parseFloat(total); // Ubah string ke angka float
			if (!isNaN(total)) {
				// Pastikan total adalah angka
				total_pos_fix += total; // Tambahkan nilai total ke total_pos_fix
			}
		});
		$("#nominal").val(formatNumber(total_pos_fix)); // Atur nilai input #nominal dengan total_pos_fix
	}

	function formatNumber(number) {
		return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
	}

	$("form").on("submit", function () {
		Swal.fire({
			title: "Loading...",
			timerProgressBar: true,
			allowOutsideClick: false,
			didOpen: () => {
				Swal.showLoading();
			},
		});
	});

	$("button[id='btn-save']").click(function (e) {
		var url = $('form[id="form-preorder"]').attr("action");
		var formData = new FormData($("form#form-preorder")[0]);
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
					success: function (res) {
						if (res.success) {
							Swal.fire({
								icon: "success",
								title: `${res.msg}`,
								showConfirmButton: false,
								timer: 1500,
							}).then(function () {
								Swal.close();
								location.reload();
							});
						} else {
							Swal.fire({
								icon: "error",
								title: `${res.msg}`,
								showConfirmButton: false,
								timer: 1500,
							}).then(function () {
								Swal.close();
							});
						}
					},
					error: function (xhr, status, error) {
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
	});
});

$(document).on("click", ".hapusRow", function () {
	$(this).closest(".baris").remove();
	updateTotalItem(); // Perbarui total belanja setelah menghapus baris
	updateTotal();
});
