<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Hasil Data
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('Hasil') ?>"> Analisa Data</a></li>
        </ol>
    </section>

    <?php if($testing == 0) { ?>
    <section class="content">
        <div class="panel panel-default">
            <div class="panel-body">
            <center><h3>Data Testing Tidak Ditemukan</h3></center>
            </div>
        </div>           
    </section>
    <?php } else {  ?>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="box-body">
                                <div id="container" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php } ?>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        // Radialize the colors
        Highcharts.setOptions({
            colors: Highcharts.map(Highcharts.getOptions().colors, function (color) {
                return {
                    radialGradient: {
                        cx: 0.5,
                        cy: 0.3,
                        r: 0.7
                    },
                    stops: [
                        [0, color],
                        [1, Highcharts.Color(color).brighten(-0.3).get('rgb')] // darken
                    ]
                };
            })
        });

        var url = $('#url_root').val();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Hasil/getKlasifikasi')?>",
            success: function (datas) {
                var i;
                Highcharts.chart('container', {
                    chart: {
                        type: 'pie',
                        options3d: {
                            enabled: true,
                            alpha: 45,
                            beta: 0
                        }
                    },
                    title: {
                        text: 'Hasil Data'
                    },
                    tooltip: {
                        pointFormat: '{series.name}: <b>{point.persentase}</b>'
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            depth: 35,
                            dataLabels: {
                                enabled: true,
                                format: '<b>{point.name}</b>: {point.persentase}'
                            }
                        }
                    },
                    series: [{
                        type: 'pie',
                        name: 'Jumlah',
                        data: JSON.parse(datas)
                    }]
                });
            },
            error: function (data) {
                console.log('Error:', data);
                new PNotify({
                    title: 'Error !',
                    text: 'Tidak Ada Yang Diproses',
                    type: 'error'
                });
            }
        });
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
window.setTimeout(function() {
    $(".alert-danger").fadeTo(500, 0).slideUp(500, function(){ $(this).remove(); }); 
    $(".alert-success").fadeTo(500, 0).slideUp(500, function(){ $(this).remove(); }); 
}, 3000); 
</script>