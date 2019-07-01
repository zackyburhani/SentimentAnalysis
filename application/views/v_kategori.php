<div class="content-wrapper">
<input id="url" type="hidden" value="{{ \Request::url() }}">
<input id="url_root" type="hidden" value="{{ url("") }}">
<section class="content-header">
    <h1> 
        Kategori
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('Kategori') ?>"> Kategori</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-danger">
                <div class="box-header">
                    <form id="frmKategori" name="frmKategori">
                        <div class="form-group">
                            <label class="col-sm-1 col-form-label">Kategori</label>
                            <div class="col-sm-4">
                                <input type="text" placeholder="Kategori" name="kategori"
                                    class="form-control">
                            </div>
                            <div class="col-sm-5" id="addition_button">
                                <button class="btn btn-warning btn-save" value="add" type="button"><i
                                        class="fa fa-download"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-body">
                    <hr>
                    <table id="table-kategori" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th width="30px">
                                    <center>No.</center>
                                </th>
                                <th>
                                    <center>Kategori Sentimen</center>
                                </th>
                                <th width="150px">
                                    <center>Action</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="kategori-tbody">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<script type="text/javascript">
var url = $('#url').val();
var url_root = $('#url_root').val();
kategori_table();
$('#table-kategori').DataTable();

//display data edit
$(document).on('click','.edit-kategori',function(){
    var kategori_id = $(this).val();
    
	$.ajax({
        type  : 'get',
        url   : "<?php echo base_url('Kategori/getKategoriID/')?>"+kategori_id,
        dataType : 'json',
        success : function(data){
           //success data
			if( $('#button-update').length ){
				$('[name="kategori"]').val(data.kategori);
				$('.btn-update').val(data.id_sentimen);
			} else {
				$('[name="kategori"]').val(data.kategori);
				var button = '<div id="button-update"><button type="button" class="btn btn-warning btn-update" value="' + data.id_sentimen + '"><i class="fa fa-edit"></i> Ubah</button> '+' <button type="button" class="btn btn-danger btn-close"><i class="fa fa-close"></i> Batal</button></div>';
				$('#addition_button').append(button);
			}
			$('.btn-save').hide();
        },
        error: function (data) {
            console.log('Error:', data);
            new PNotify({
                title: 'Error !',
                text: 'Terdapat Kesalahan Sistem',
                type: 'error'
            });
        }
    });

});

//close
$(document).on('click','.btn-close',function(){
    $('#frmKategori').trigger("reset");
    $('#button-update').remove();
    $('.btn-save').show();
});

//delete item
$(document).on('click','.delete-kategori',function(){
	var id = $(this).val();
    swal({
        title: "Anda Yakin Ingin Menghapus Data?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Kategori/hapus/')?>" + id,
                success: function (data) {
                    kategori_table();
                    new PNotify({
                        title: 'Sukses !',
                        text: 'Data Berhasi Dihapus',
                        type: 'success'
                    });
                },
                error: function (data) {
                    console.log('Error:', data);
                    new PNotify({
                        title: 'Error !',
                        text: 'Terdapat Kesalahan Sistem',
                        type: 'error'
                    });
                }
            });
        } else {
            swal.close();
        }
      });

    
});

//create new item
$(".btn-save").click(function (e) {
    e.preventDefault(); 

    if($('[name="kategori"]').val() == ""){
        new PNotify({
            title: 'Error !',
            text: 'Form Tidak Boleh Kosong',
            type: 'error'
        });
        return false;
    }

    var formData = {
        kategori: $('[name="kategori"]').val(),
    }

    $.ajax({
        type: "POST",
        url: "<?php echo base_url('Kategori/simpan')?>",
        data: formData,
        dataType: 'json',
        success: function (data) {
            new PNotify({
                title: 'Sukses !',
                text: 'Data Berhasi Dimasukkan',
                type: 'success'
            });
            kategori_table();
            $('#frmKategori').trigger("reset");
        },
        error: function (data) {
            console.log('Error:', data);
            new PNotify({
                title: 'Error !',
                text: 'Terdapat Kesalahan Sistem',
                type: 'error'
            });
        }
    });
});

//update new item
$(document).on('click','.btn-update',function(e) {
    e.preventDefault(); 
    var formData = {
        kategori: $('[name="kategori"]').val(),
    }

    var id = $(this).val();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url('Kategori/ubah/')?>" +id,
        data: formData,
        dataType: 'json',
        success: function (data) {
            new PNotify({
                title: 'Sukses !',
                text: 'Data Berhasi Diubah',
                type: 'success'
            });
            kategori_table();
            $('#frmKategori').trigger("reset");
            $('#button-update').remove();
            $('.btn-save').show();
        },
        error: function (data) {
            console.log('Error:', data);
            new PNotify({
                title: 'Error !',
                text: 'Terdapat Kesalahan Sistem',
                type: 'error'
            });
        }
    });
});

function kategori_table()
{
    $.ajax({
        type  : 'get',
        url   : "<?php echo base_url('Kategori/getKategori')?>",
        dataType : 'json',
        success : function(data){
            var html = '';
            var i;
            no = 1;
            for(i=0; i<data.length; i++){
                html += 
                '<tr>'+
                    '<td align="center">'+ no++ +'.'+'</td>'+
                    '<td align="center">'+data[i].kategori+'</td>'+
                    '<td style="text-align:center;">'+
                      '<button class="btn btn-warning edit-kategori" value="' + data[i].id_sentimen + '">Pilih</button>'+' '+
                      '<button class="btn btn-danger btn-delete delete-kategori" value="' + data[i].id_sentimen + '">Hapus</button></td></tr>'+
                    '</td>'+
                '</tr>';
            }
            $('#kategori-tbody').html(html);
        },
        error: function (data) {
            console.log('Error:', data);
            new PNotify({
                title: 'Error !',
                text: 'Terdapat Kesalahan Sistem',
                type: 'error'
            });
        }
    });
}
</script>