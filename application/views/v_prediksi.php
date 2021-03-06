<div class="content-wrapper">
<section class="content-header">
    <h1>
        Hasil Perhitungan
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('Hasil/HasilHitung') ?>">Hasil Perhitungan Data Data</a></li>
    </ol>
</section>

<?php if($this->Model->jumlah('data_testing') == 0) { ?>
<section class="content">
    <div class="panel panel-default">
        <div class="panel-body">
            <center>
                <h3>Data <i>Testing</i> Tidak Ditemukan</h3>
            </center>
        </div>
    </div>
</section>
<?php } else { ?>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <div class="tab-pane active" id="prediksi_sentimen">
                                <table style="table-layout:fixed" id="table-prediksi"
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
                                            <th width="65px">
                                                <center>Sentimen<center>
                                            </th>
                                            <th width="65px">
                                                <center>Klasifikasi</center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; ?>
                                        <?php foreach($collection as $key) { ?>
                                        <tr>
                                            <td align="center"><?php echo $no++ ?></td>
                                            <td align="center"><?php echo $key['username'] ?></td>
                                            <td align="left"><a data-toggle="modal"
                                                    href="#Detail_<?php echo $key['id_testing'] ?>"> <?php echo $key['tweet'] ?></a></td>
                                            <td align="center"><?php echo $key['kategori'] ?></td>
                                            <td align="center"><?php echo $key['prediksi'] ?></td>
                                        </tr>
                                        <?php } ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>
</div>

<!-- Modal -->
<?php foreach($collection as $key) { ?>
<div class="modal fade" id="Detail_<?php echo $key['id_testing'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form id="frmUpload" enctype="multipart/form-data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><i class="fa fa-xlsx"></i>Detail Data</h4>
                </div>
                <div class="modal-body">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_nbc_<?php echo $key['id_testing'] ?>" data-toggle="tab">Hasil Kategori Sentimen</a></li>
                            <li><a href="#tab_hitung_<?php echo $key['id_testing'] ?>" data-toggle="tab">Detail Perhitungan</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_nbc_<?php echo $key['id_testing'] ?>">
                                <table style="table-layout:fixed" id="table-prediksi"
                                    class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="7%">
                                                <center>No.<center>
                                            </th>
                                            <th>
                                                <center>Hasil Confidence
                                                    <center>
                                            </th>
                                            <th width="20%">
                                                <center>Kategori<center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; ?>
                                        <?php $data = $this->Model->getHasilView($key['id_testing']); ?>
                                        <?php foreach($data as $row) { ?>
                                        <tr>
                                            <td align="center"><?php echo $no++ ?></td>
                                            <td align="center"><?php echo $row->nilai ?></td>
                                            <td align="center"><?php echo $row->kategori?></td>
                                        </tr>
                                        <?php $tampung[$row->kategori] = $row->nilai; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>

                                <div style="height: 250px; overflow: scroll;">
                                    <table style="table-layout:fixed" id="table-prediksi"
                                        class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="7%">
                                                    <center>No.<center>
                                                </th>
                                                <th>
                                                    <center>Hasil <i>Preprocessing</i><center>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no=1; ?>
                                            <?php  arsort($tampung); $hasil_klasifikasi = key($tampung); ?>
                                            <?php $data = $this->Model->getFreqTest($key['id_testing'],$hasil_klasifikasi); ?>
                                            <?php foreach($data as $row) { ?>
                                            <tr>
                                                <td align="center"><?php echo $no++ ?></td>
                                                <td align="center"><?php echo $row->kemunculan_kata ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <table>
                                    <tr>
                                        <td>Hasil Klasifikasi : <b><?php echo $hasil_klasifikasi ?></b></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="tab_hitung_<?php echo $key['id_testing'] ?>">
                                <table style="table-layout:fixed" id="table-hasil"
                                    class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="7%">
                                                <center>No.<center>
                                            </th>
                                            <th>
                                                <center>Kata<center>
                                            </th>
                                            <th width="20%">
                                                <center>Kategori<center>
                                            </th>
                                            <th width="50%">
                                                <center>Hasil Perhitungan<center>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no=1; ?>
                                        <?php $data_hitung = $this->Model->getDetailHitung($key['id_testing']); ?>
                                        <?php foreach($data_hitung as $index_row => $row) { ?>
                                        <tr>
                                            <td align="center"><?php echo $no++ ?></td>
                                            <td align="center"><?php echo $row->kemunculan_kata ?></td>
                                            <td align="center"><?php echo $row->kelas_peluang ?></td>
                                            <td align="center"><?php echo $row->nilai ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-close"></i>
                        Close</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php } ?>

<script type="text/javascript">
$(document).ready(function () {
    $('#table-prediksi').DataTable();
});

$(document).on('click','.btn-danger',function(e) {
    var url = $('#url_root').val();
    var value = $(this).val();
    
    swal({
        title: "Anda Yakin Ingin Menghapus Data Testing ?",
        text: "",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            swal({
                icon: "success",
                title: "Berhasil",
                text: "Data Testing Berhasil Dihapus",
                timer: 3000
            }).then(function () {
                window.location.href = url + '/hapus-testing/' + value;
            });
        } else {
            swal.close();
        }
    });
});
</script>