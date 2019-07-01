<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">MAIN NAVIGATION</li>
			<li>
				<a href="<?php echo site_url('/') ?>">
					<i class="fa fa-home"></i> <span>Dashboard</span>
					<span class="pull-right-container">
					</span>
				</a>
			</li>
			<li>
				<a href="<?php echo site_url('Kategori') ?>">
					<i class="fa fa-clone"></i> <span>Kategori</span>
				</a>
			</li>
			<li>
				<a href="<?php echo site_url('Crawling') ?>">
					<i class="fa fa-twitter-square"></i> <span>Data Tweet</span>
				</a>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-file"></i> <span>Kosa Kata</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo site_url('KataDasar') ?>"><i class="fa fa-circle-o"></i> Kata Dasar</a></li>
					<li><a href="<?php echo site_url('Stopword') ?>"><i class="fa fa-circle-o"></i> Stopwords</a></li>
				</ul>
			</li>
			<li>
				<a href="<?php echo site_url('Preprocessing') ?>">
					<i class="fa fa-server"></i> <span>Preprocessing</span>
				</a>
			</li>
			<li>
				<a href="<?php echo site_url('Training') ?>">
					<i class="fa fa-th-list"></i> <span>Data Training</span>
				</a>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-area-chart"></i> <span>Hasil Data</span>
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo site_url('Hasil') ?>"><i class="fa fa-circle-o"></i> Pie Chart</a></li>
					<li><a href="<?php echo site_url('Hasil/Hasil_Hitung') ?>"><i class="fa fa-circle-o"></i> Hasil Hitung</a></li>
					<li><a href="<?php echo site_url('Hasil/Confusion_Matrix') ?>"><i class="fa fa-circle-o"></i> Confusion Matrix</a></li>
					<li><a href="<?php echo site_url('Hasil/Word_Cloud') ?>"><i class="fa fa-circle-o"></i> Word Cloud</a></li>
				</ul>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>