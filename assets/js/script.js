//dom ready
var table;
$(document).ready(function () 
{
	//start
	$(".alert-message").alert().delay(10000).slideUp("slow");
	//end

	$("#form").validate();
	$('#form-user').validate({
		rules: 
		{
			password2:
		  	{
				equalTo: "#password1"
		  	}
		},
		messages:
		{
		  	password2:
		  	{
				equalTo: "Password tidak sama"
		  	}
		}
	});
	
	//start
	$("#check-all").click(function () {
		// Ketika user men-cek checkbox all
		if ($(this).is(":checked"))
			// Jika checkbox all diceklis
			$(".check-item").prop("checked", true);
		// ceklis semua checkbox siswa dengan class "check-item"
		// Jika checkbox all tidak diceklis
		else $(".check-item").prop("checked", false); // un-ceklis semua checkbox siswa dengan class "check-item"
	});
	//end

	//start
	$(".sepasi").on({
		keydown: function (e) {
			if (e.which === 32) return false;
		},
		change: function () {
			this.value = this.value.replace(/\s/g, "");
		},
	});
	//end

	//start
	$("#konfirmasi_hapus").on("show.bs.modal", function (e) {
		$(this).find(".btn-ok").attr("href", $(e.relatedTarget).data("href"));
	});
	//end

	//start
	$(function () {
		$("#datatable").DataTable();
	});
	//end

	//start
	$("#id_tagihan").change(function () {
		var id = $(this).val();
		$.ajax({
			url: base_url + "backend/cek_tagihan",
			method: "GET",
			data: { id: id },
			async: false,
			dataType: "json",
			success: function (data)
			{	
				if(data == 'persiswa')
				{
					$("#id_semester").fadeOut(500);
				}else if(data == 'kelulusan')
				{
					$("#id_semester").fadeOut(500);
				}else
				{
					if(data.length > 0)
					{
						$("#id_semester").fadeIn(500);
					}else
					{
						$("#id_semester").fadeOut(500);
					}
				}
			},
		});
	});
	//end

	//start
	table = $("#table-kelas").DataTable({
		processing: true,
		serverSide: true,
		order: [],

		ajax: {
			url: base_url + "backend/get_data_kelas",
			type: "POST",
		},

		columnDefs: [
			{
				targets: [0],
				orderable: false,
			},
		],
	});
	//end

	//start
	table = $("#table-guru").DataTable({
		processing: true,
		serverSide: true,
		order: [],

		ajax: {
			url: base_url + "backend/get_data_guru",
			type: "POST",
		},

		columnDefs: [
			{
				targets: [0],
				orderable: false,
			},
		],
	});
	//end

	//start
	table = $("#table-kelas-wali").DataTable({
		processing: true,
		serverSide: true,
		order: [],

		ajax: {
			url: base_url + "backend/get_data_kelas_wali",
			type: "POST",
		},

		columnDefs: [
			{
				targets: [0],
				orderable: false,
			},
		],
	});
	//end

	//start
	table = $("#table-siswa").DataTable({
		processing: true,
		serverSide: true,
		order: [],

		ajax: {
			url: base_url + "backend/get_data_siswa",
			type: "POST",
		},

		columnDefs: [
			{
				targets: [0],
				orderable: false,
			},
		],
	});
	//end

	//start
	table = $("#table-transaksi-semester").DataTable({
		processing: true,
		serverSide: true,
		order: [],

		ajax: {
			url: base_url + "backend/get_data_transaksi_semester",
			type: "POST",
		},

		columnDefs: [
			{
				targets: [0],
				orderable: false,
			},
		],
	});
	//end
	
	//start
	table = $("#table-tagihan-tahunan").DataTable({
		processing: true,
		serverSide: true,
		order: [],

		ajax: {
			url: base_url + "backend/get_data_tagihan_tahunan",
			type: "POST",
		},

		columnDefs: [
			{
				targets: [0],
				orderable: false,
			},
		],
	});
	//end

	//start
	table = $("#table-pembayaran").DataTable({
		processing: true,
		serverSide: true,
		order: [],

		ajax: {
			url: base_url + "backend/get_data_pembayaran",
			type: "POST",
		},

		columnDefs: [
			{
				targets: [0],
				orderable: false,
			},
		],
	});
	//end

	//start
	table = $("#table-tabungan").DataTable({
		processing: true,
		serverSide: true,
		order: [],

		ajax: {
			url: base_url + "backend/get_data_tabungan",
			type: "POST",
		},

		columnDefs: [
			{
				targets: [0],
				orderable: false,
			},
		],
	});
	//end	
});
//end dom

//start
function readURL(input)
{
	// Mulai membaca inputan gambar
	if(input.files && input.files[0])
	{
		var reader = new FileReader(); // Membuat variabel reader untuk API FileReader
		reader.onload = function (e)
		{
			// Mulai pembacaan file
			$("#preview_gambar") // Tampilkan gambar yang dibaca ke area id #preview_gambar
				.attr("src", e.target.result);
			//.width(300); // Menentukan lebar gambar preview (dalam pixel)
			//.height(200); // Jika ingin menentukan lebar gambar silahkan aktifkan perintah pada baris ini
		};
		reader.readAsDataURL(input.files[0]);
	}
}
//end

//start
function VerifyUploadSizeIsOK()
{
  	var UploadFieldID = "file-upload";
  	var MaxSizeInBytes = 1048576;
  	var fld = document.getElementById(UploadFieldID);
  	if( fld.files && fld.files.length == 1 && fld.files[0].size > MaxSizeInBytes )
  	{
    	setTimeout(function () { 
			swal({
				position: 'top-end',
				icon: 'error',
				title: 'Ukuran gambar/foto terlalu besar!!',
				showConfirmButton: false,
				timer: 5000
			});
		},2000); 
    	window.setTimeout(function(){ 
    	} ,5000);
    	return false;
  	}
  	return true;
} 
// end 

// fungsi ketika user men scroll ke bawah 20 px maka tombol back to top akan muncul
window.onscroll = function() {scrollFunction()};
function scrollFunction() {
    if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
    }else{
        document.getElementById("myBtn").style.display = "none";
    }
}

// fungsi ketika user meng klik tombol back to top maka halaman akan menscroll ke atas
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}