<div class="content-wrapper">

<section class="content-header">
    <h1>
        Akurasi Sistem
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo site_url('Hasil/Confusion_Matrix') ?>">Akurasi Sistem</a></li>
    </ol>
</section>

<?php if($testing_data == 0) { ?>
<section class="content">
    <div class="panel panel-default">
        <div class="panel-body">
            <center>
                <h3>Data <i>Testing</i> Tidak Ditemukan</h3>
            </center>
        </div>
    </div>
</section>
<?php } else {  ?>
<section class="content">
<div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="title">
                        <center>Tabel Confusion Matrix </center>
                    </h4>
                    <table style="table-layout:fixed" id="table-negatif"
                        class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th style="background-color:#676a6e"></th>
                                <?php foreach($th as $index_th => $head) { ?>
                                <th>
                                    <center>Pred. <?php echo $head ?><center>
                                </th>
                                <?php } ?>
                                <th>
                                    <center>CLASS RECALL</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; ?>
                            <?php foreach($matrix as $index_matrix => $value_m) { ?>
                            <tr>
                                <td align="center"><b>True. <?php echo $index_matrix ?></b></td>
                                <?php foreach($value_m as $index_value => $value_v) { ?>
                                <td align="center"><?php echo $value_v ?></td>
                                <?php } ?>
                                <td align="center"><?php echo round($recall[$index_matrix],2) ?>%</td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <td align="center"><b>CLASS PRECISION</b></td>
                                <?php foreach($precision as $index_p => $value_p) { ?>
                                <td align="center"><?php echo round($value_p,2) ?> %</td>
                                <?php } ?>
                                <td style="background-color:#676a6e"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <div class="container-fluid">
        <div class="row">
            <div class="row">
                <div class="col-md-12">
                    <div class="nav-tabs-custom">
                        <div class="tab-content">
                            <div class="tab-pane active" id="confusion_matrix">
                                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
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
<script type="text/javascript">
    $(document).ready(function () {
        var url = $('#url_root').val();
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('Hasil/column_drilldown')?>",
            success: function (data) {
                var data = JSON.parse(data);
                let precision = Object.entries(data[0].precision)
                let recall = Object.entries(data[0].recall)
                // Create the chart
                Highcharts.chart('container', {
                    chart: {
                        type: 'column'
                    },
                    title: {
                        text: 'Persentase Data'
                    },
                    subtitle: {
                        text: ''
                    },
                    xAxis: {
                        type: 'category'
                    },
                    yAxis: {
                        title: {
                            text: ''
                        }
                
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: true,
                                format: '{point.y:.2f}%'
                            }
                        }
                    },
                
                    tooltip: {
                        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
                    },

                    "series": [
                        {
                            "name": "Confusion Matrix",
                            "colorByPoint": true,
                            "data": [
                                {
                                    "name": "Accuracy",
                                    "y": data[0].accuracy,
                                },
                                {
                                    "name": "Precision",
                                    "y": data[0].total_precision,
                                },
                                {
                                    "name": "Recall",
                                    "y": data[0].total_recall,
                                },
                            ]
                        }
                    ],
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

</script>