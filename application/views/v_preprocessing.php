<div class="content-wrapper">
<section class="content-header">
    <h1>
        Preprocessing
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('Preprocessing') ?>">Preprocessing</a></li>
    </ol>
</section>

<section class="content-header">

    <div class="row">
        <div class="panel-heading">
            <button class="btn btn-success btn-preprocessing" value="preprocessing"><i class="fa fa-gear"></i>
                Start Preprocessing</button>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="nav-tabs-custom" id="data_preprocessing_validasi">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#casefolding" data-toggle="tab">Case Folding</a></li>
                                    <li><a href="#cleansing" data-toggle="tab">Cleansing</a></li>
                                    <li><a href="#tokenizing" data-toggle="tab">Tokenizing</a></li>
                                    <li><a href="#stopword" data-toggle="tab">Stopword</a></li>
                                    <li><a href="#stemming" data-toggle="tab">Stemming</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="casefolding">
                                        <table id="table-casefolding" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="40px">
                                                        <center>No.</center>
                                                    </th>
                                                    <th width="150px">
                                                        <center>Username</center>
                                                    </th>
                                                    <th>
                                                        <center>Tweet</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="casefolding-tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="cleansing">
                                        <table id="table-cleansing" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="40px">
                                                        <center>No.</center>
                                                    </th>
                                                    <th width="150px">
                                                        <center>Username</center>
                                                    </th>
                                                    <th>
                                                        <center>Tweet</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="cleansing-tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="tokenizing">
                                        <table id="table-tokenizing" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="40px">
                                                        <center>No.</center>
                                                    </th>
                                                    <th width="150px">
                                                        <center>Username</center>
                                                    </th>
                                                    <th>
                                                        <center>Tweet</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tokenizing-tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="stopword">
                                        <table id="table-stopword" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="40px">
                                                        <center>No.</center>
                                                    </th>
                                                    <th width="150px">
                                                        <center>Username</center>
                                                    </th>
                                                    <th>
                                                        <center>Tweet</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="stopword-tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" id="stemming">
                                        <table id="table-stemming" class="table table-striped table-bordered nowrap">
                                            <thead>
                                                <tr>
                                                    <th width="40px">
                                                        <center>No.</center>
                                                    </th>
                                                    <th width="150px">
                                                        <center>Username</center>
                                                    </th>
                                                    <th>
                                                        <center>Tweet</center>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="stemming-tbody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<script type="text/javascript">
$(document).on('click', '.btn-preprocessing', function (e) {
    parameter = $(this).val();
    e.preventDefault();
    var url = $('#url_root').val();
    $('.btn-preprocessing').attr('disabled',true);
    $('.btn-preprocessing i.fa-gear').addClass('fa-spin');
    var button1 = '<button class="btn btn-warning btn-latih" value="data-latih"><i class="fa fa-check-square-o"></i> Save Data Training</button>';
    var button2 = ' <button class="btn btn-danger btn-uji" value="data-uji"><i class="fa fa-check-square-o"></i> Save Data Testing</button>';
    var klasifikasi = $('.btn-simpan');
    $.ajax({
        type: 'POST',
        url: "<?php echo base_url('Preprocessing/preprocessing')?>",
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            console.log(data);
            var data = JSON.parse(data);
            if(data == 0){
                new PNotify({
                    title: 'Warning !',
                    text: 'Data Tidak Ditemukan',
                    type: 'warning'
                });
                $('.btn-preprocessing').attr('disabled',false);
                $('.btn-preprocessing i.fa-gear').removeClass('fa-spin');
                return false;    
            } else {
                casefolding_table(data);
                cleansing_table(data);
                stopword_table(data);
                tokenizing_table(data);
                stemming_table(data);
                $('.btn-preprocessing').attr('disabled',true);
                $('.btn-preprocessing i.fa-gear').removeClass('fa-spin');
               
                if (!klasifikasi.length){
                    if(data[0].training == 0){
                        $('.panel-heading').append(button1);
                    } else {
                        $('.panel-heading').append(button1);
                        $('.panel-heading').append(button2);
                    }
                }
                var sukses = data
                new PNotify({
                    title: 'Sukses !',
                    text: ' Data Berhasil Diproses',
                    type: 'success'
                });
            }
        },
        error: function (data) {
            var data = JSON.parse(data);
            console.log('Error:', data);
            $('.btn-preprocessing').attr('disabled',false);
            $('.btn-preprocessing i.fa-gear').removeClass('fa-spin');
            new PNotify({
                title: 'Error !',
                text: 'Terdapat Kesalahan Sistem',
                type: 'error'
            });
        }
    });
});

//simpan data latih
$(document).on('click', '.btn-latih', function (e) {
    $('.btn-latih').attr('disabled',true);
    $('.btn-latih i.fa-file-text').removeClass('fa-file-text').addClass('fa-spinner').addClass('fa-spin');
    parameter = $(this).val();
    
    e.preventDefault();
    var url = $('#url_root').val();
    
    swal({
        title: "Anda Yakin Ingin Memproses Data Latih ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Preprocessing/latih')?>",
                success: function (data) {
                    $('.btn-latih').attr('disabled',false);
                    $('.btn-latih i.fa-spinner').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-file-text');
                    window.location.href = "<?php echo base_url() ?>Training";
                },
                error: function (data) {
                    console.log('Error:', data);
                    new PNotify({
                        title: 'Error !',
                        text: 'Terdapat Kesalahan Sistem',
                        type: 'error'
                    });
                    $('.btn-latih').attr('disabled',false);
                    $('.btn-latih i.fa-spinner').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-file-text');
                }
            });
        } else {
            $('.btn-latih').attr('disabled',false);
            $('.btn-latih i.fa-spinner').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-file-text');
            swal.close();
        }
      });
});

//simpan data uji
$(document).on('click', '.btn-uji', function (e) {
    $('.btn-uji').attr('disabled',true);
    $('.btn-latih').attr('disabled',true);
    $('.btn-uji i.fa-file-text').removeClass('fa-file-text').addClass('fa-spinner').addClass('fa-spin');
    parameter = $(this).val();
    
    e.preventDefault();
    var url = $('#url_root').val();
    
    swal({
        title: "Anda Yakin Ingin Memproses Data Uji ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('Preprocessing/uji')?>",
                success: function (data) {
                    $('.btn-uji').attr('disabled',false);
                    $('.btn-latih').attr('disabled',false);
                    $('.btn-uji i.fa-spinner').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-file-text');
                    window.location.href = "<?php echo base_url() ?>Hasil";
                },
                error: function (data) {
                    console.log('Error:', data);
                    new PNotify({
                        title: 'Error !',
                        text: 'Terdapat Kesalahan Sistem',
                        type: 'error'
                    });
                    $('.btn-uji').attr('disabled',false);
                    $('.btn-uji i.fa-spinner').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-file-text');
                }
            });
        } else {
            $('.btn-uji').attr('disabled',false);
            $('.btn-uji i.fa-spinner').removeClass('fa-spinner').removeClass('fa-spin').addClass('fa-file-text');
            swal.close();
        }
      });
});

function casefolding_table(data) {
    var html = '';
    var i;
    var no = 1;
    $.each( data, function( key1, value1 ) {
        html = html + '<tr>';
        html = html + '<td align="center">'+ no++ +'.' +'</td>';
        html = html + '<td >'+value1.case_folding.screen_name+'</td>';
        html = html + '<td >'+ value1.case_folding.full_text +'</td>';
        html = html + '</tr>';
    });
    $('#casefolding-tbody').html(html);
}

function cleansing_table(data) {
    var html = '';
    var no = 1;
    $.each( data, function( key1, value1 ) {
            html = html + '<tr>';
            html = html + '<td align="center">'+ no++ +'.' +'</td>';
            html = html + '<td >'+value1.cleansing.screen_name+'</td>';
            html = html + '<td >'+ value1.cleansing.full_text +'</td>';
            html = html + '</tr>';
    });
    $('#cleansing-tbody').html(html);
}

function tokenizing_table(data) {
    var html = '';
    var no = 1;
    var rows = '';
    $.each( data, function( key1, value1 ) {
        rows = value1.tokenizing.full_text;
        $.each( rows, function( key2, value2 ) {
            html = html + '<tr>';
            if(key2 == 0){
                html = html + '<td align="center" rowspan="'+ value1.tokenizing.full_text.length +'">'+ no++ +'.' +'</td>';
                html = html + '<td rowspan="'+ value1.tokenizing.full_text.length +'">'+value1.tokenizing.screen_name+'</td>';
            }
            html = html + '<td align="center">'+value2+'</td>';
            html = html + '</tr>';
        });
    });
    $('#tokenizing-tbody').html(html);
}

function stopword_table(data) {
    var html = '';
    var no = 1;
    var rows = '';
    $.each( data, function( key1, value1 ) {
        rows = value1.stopword.full_text;
        $.each( rows, function( key2, value2 ) {
            html = html + '<tr>';
            if(key2 == 0){
                html = html + '<td align="center" rowspan="'+ value1.stopword.full_text.length +'">'+ no++ +'.' +'</td>';
                html = html + '<td rowspan="'+ value1.stopword.full_text.length +'">'+value1.stopword.screen_name+'</td>';
            }
            html = html + '<td align="center">'+value2+'</td>';
            html = html + '</tr>';
        });
    });
    $('#stopword-tbody').html(html);
}

function stemming_table(data) {
    var html = '';
    var no = 1;
    var rows = '';
    $.each( data, function( key1, value1 ) {
        rows = value1.stemming.full_text;
        $.each( rows, function( key2, value2 ) {
            html = html + '<tr>';
            if(key2 == 0){
                html = html + '<td align="center" rowspan="'+ value1.stemming.full_text.length +'">'+ no++ +'.' +'</td>';
                html = html + '<td rowspan="'+ value1.stemming.full_text.length +'">'+value1.stemming.screen_name+'</td>';
            }
            html = html + '<td align="center">'+value2+'</td>';
            html = html + '</tr>';
        });
    });
    $('#stemming-tbody').html(html);
}
</script>