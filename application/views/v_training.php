<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Data Training
        </h1>
        <ol class="breadcrumb">
            <li><a href="/crawling">Data Training</a></li>
        </ol>
    </section> 

    <?php if($validasi == 0){ ?>
        <section class="content">
            <div class="panel panel-default">
                <div class="panel-body">
                <center><h3>Data Training Tidak Ditemukan</h3></center>
                </div>
            </div>           
        </section>
    <?php } else { ?>
        <section class="content">
            <?php $n=0; ?>
            <?php foreach($data_training as $key => $val){ ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                        <?php if(COUNT($val) != 0) { ?>
                            <h4 class="title">Data <?php echo $key ?> <div class="pull-right"> <?php echo "Prior : ".round($prior[$n]["nilai"],5) ?> / <?php echo "Frekuensi : ".round($data_sum[$n]["jumlah"],5) ?></div> </h4>
                            <hr>
                            <table style="table-layout:fixed" id="table_<?php echo $key ?>" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="5px"><center>No.<center></th>
                                        <th width="100px"><center>Kata<center></th>
                                        <th width="100px"><center>Frequency</center></th>
                                        <th width="100px"><center>Nilai Perhitungan</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $no=1; ?>
                                    <?php foreach($val as $row => $content) { ?>
                                    <tr>
                                        <td align="center"><?php echo $no++ ?></td>
                                        <td align="center"><?php echo $content->kata?></td>
                                        <td align="center"><?php echo $content->jumlah?></td>
                                        <td align="center"><?php echo $content->nilai_hitung?></td>
                                    </tr>           
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <p><b><center>Data <?php echo $key ?> Tidak Ditemukan</center></b></p>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php $n++ ?>
            <?php } ?>

        </section>
    <?php } ?>
</div>

<script text="text/javascript">
$(document).ready( function () {
    $.ajaxSetup({
        beforeSend: function(xhr, type) {
            if (!type.crossDomain) {
                xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
            }
        },
    });
    var url = $('#url_root').val();
    $.ajax({
        type: 'GET',   
        url: "<?php echo base_url('Training/data_sentimen')?>",
        cache: false,
        contentType: false,
        processData: false,
        success: function(data){
            $.each( JSON.parse(data), function( key, value ) {
                var id = '#table_'+value.kategori;
                $(id).DataTable();
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
});

$(document).on('click','.btn-danger',function(e) {
    var value = $(this).val();
    
    swal({
        title: "Anda Yakin Ingin Menghapus Data Training "+ value + " ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            window.location.href = "<?php echo base_url() ?>" + 'Training/hapus_training/' + value;
        } else {
            swal.close();
        }
    });
});
</script>