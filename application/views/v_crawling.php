<div class="content-wrapper">
	<section class="content-header">
		<h1>
		Data Tweet
			<!-- <small>Control panel</small> -->
		</h1>
		<ol class="breadcrumb">
			<li><a href="/crawling">Data Tweet</a></li>
		</ol>
	</section>

	<section class="content">

		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<button class="btn btn-success btn-warning" value="xlsx">
							Export</button>
						<button class="btn btn-info" data-toggle="modal" data-target="#myModal">
							Import</button>
						<button class="btn btn-danger btn-refresh" value="xlsx">
							Hapus Data</button>
					</div>
					<div class="panel-body">
						<table style="table-layout:fixed" id="table-crawling"
							class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th width="7%">
										<center>No.<center>
									</th>
									<th width="14%">
										<center>Username<center>
									</th>
									<th width="55%">
										<center>Tweet<center>
									</th>
									<th>
										<center>Class<center>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php $no=1; ?>
								<?php foreach($data as $key) { ?>
								<tr>
									<td align="center"><?php echo $no++ ?></td>
									<td><?php echo $key->username ?></td>
									<td><?php echo $key->tweet?></td>
									<td align="center">
                                    <?php echo $key->kategori?>
									</td>
								</tr>
                                <?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<form id="frmUpload" enctype="multipart/form-data">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="myModalLabel"><i class="fa fa-xlsx"></i>Import XLSX</h4>
					</div>
					<div class="modal-body">
						<div class="input-group">
							<input type="text" class="form-control file-upload-text" disabled
								placeholder="select a file..." />
							<span class="input-group-btn">
								<button type="button" class="btn btn-warning file-upload-btn">
									Browse...
									<input type="file" class="file-upload" name="data_crawling" />
								</button>
							</span>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"></i>
							Close</button>
						<button type="submit" class="btn btn-warning btn-upload">Import Data</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
$(document).ready( function () {
    $('#table-crawling').DataTable();
});

$(document).on('click','.btn-export',function(e) {
    window.location.href = 'Crawling/export';
});

$(document).on('click','.btn-refresh',function(e) {
    var url = $('#url_root').val();
    swal({
        title: "Anda Yakin Ingin Membersihkan Data ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            window.location.href = 'Crawling/hapus';
        } else {
            swal.close();
        }
      });
});
    
$('#frmUpload').submit( function(e) {
    e.preventDefault();

    var data = new FormData(this); 
    $.ajax({
        type: 'POST',   
        url: "<?php echo base_url('Crawling/upload')?>",
        data: data,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            console.log(data);
            $('#frmUpload').trigger("reset");
            $('#myModal').modal('hide');
            // new PNotify({
            //     title: 'Sukses !',
            //     text: 'Data Berhasil Diupload',
            //     type: 'success'
            // });
            window.location.href = 'Crawling';
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

</script>