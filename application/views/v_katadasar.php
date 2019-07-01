<div class="content-wrapper">
<section class="content-header">
    <h1>
        Kata Dasar
        <!-- <small>Control panel</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"> Kosa Kata</a></li>
        <li><a href="<?php echo site_url('KataDasar') ?>">Kata Dasar</a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="box-body">
                    <hr>
                    <table id="table-kata-dasar" class="table table-striped table-bordered nowrap">
                        <thead>
                            <tr>
                                <th width="10%">
                                    <center>No.</center>
                                </th>
                                <th>
                                    <center>Kata Dasar</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="katadasar-tbody">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

</div>

<script type="text/javascript">
kata_dasar_table();
$('#table-kata-dasar').DataTable();

function kata_dasar_table()
{
    $.ajax({
        type  : 'get',
        url   : "<?php echo base_url('KataDasar/getKataDasar')?>",
        async : false,
        dataType : 'json',
        success : function(data){
            var html = '';
            var i;
            no = 1;
            for(i=0; i<data.length; i++){
                html += 
                '<tr>'+
                    '<td align="center">'+ no++ +'.'+'</td>'+
                    '<td align="center">'+data[i].katadasar+'</td>'+
                '</tr>';
            }
            $('#katadasar-tbody').html(html);
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