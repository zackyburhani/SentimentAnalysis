<div class="content-wrapper">
	<section class="content-header">
		<h1>
			Bobot Kata
			<!-- <small>Control panel</small> -->
		</h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url('Hasil/Word_Cloud') ?>"> Bobot Kata</a></li>
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
	<?php } else { ?>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12">
					<div class="nav-tabs-custom">
						<div class="tab-content">
							<div class="tab-pane active" id="matriks">
								<?php foreach($klasifikasi as $class => $val) { ?>
								<div class="panel panel-default">
									<div class="panel-body">
										<div id="container_<?php echo $val->kategori ?>"></div>
									</div>
								</div>
                                <?php } ?>
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
			url: "<?php echo base_url('Hasil/jumlah_kategori_cloud')?>", 
			success: function (data) {
				$.each(JSON.parse(data), function (key, value) {
                    console.log(value)
					$.ajax({
						type: "GET",
						url: "<?php echo base_url('Hasil/data_cloud/')?>" + value.id_sentimen,
						success: function (string) {
                            var string = JSON.parse(string);
							var chart = 'container_' + value.kategori
							var text = string;
							var lines = text.split(/[,\. ]+/g);
							data = Highcharts.reduce(lines, function (arr, word) {
								var obj = Highcharts.find(arr, function (
									obj) {
									return obj.name === word;
								});
								if (obj) {
									obj.weight += 1;
								} else {
									obj = {
										name: word,
										weight: 1
									};
									arr.push(obj);
								}
								return arr;
							}, []);

							Highcharts.chart(chart, {
								series: [{
									type: 'wordcloud',
									data: data,
									name: 'Jumlah',
									style: {"fontFamily":"calibri", "fontWeight": "200"},
									colors: ['#4572A7', '#AA4643', '#89A54E', '#80699B', '#3D96AE','#DB843D', '#92A8CD', '#A47D7C', '#B5CA92']
								}],
								title: {
									text: 'Kategori ' + value.kategori
								},
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
		// var text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean bibendum erat ac justo sollicitudin, quis lacinia ligula fringilla. Pellentesque hendrerit, nisi vitae posuere condimentum, lectus urna accumsan libero, rutrum commodo mi lacus pretium erat. Phasellus pretium pretium pretium pretium ultrices mi sed semper. Praesent ut tristique magna. Donec nisl tellus, sagittis ut tempus sit amet, consectetur eget erat. Sed ornare gravida lacinia. Curabitur iaculis metus purus, eget pretium est laoreet ut. Quisque tristique augue ac eros malesuada, vitae facilisis mauris sollicitudin. Mauris ac molestie nulla, vitae facilisis quam. Curabitur placerat ornare sem, in mattis purus posuere eget. Praesent non condimentum odio. Nunc aliquet, odio nec auctor congue, sapien justo dictum massa, nec fermentum massa sapien non tellus. Praesent luctus eros et nunc pretium hendrerit. In consequat et eros nec interdum. Ut neque dui, maximus id elit ac, consequat pretium tellus. Nullam vel accumsan lorem.';    
	});
</script>