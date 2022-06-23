<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?=base_url('assets/template/adminlte3/plugins_other/jquery/jquery.min.js')?>"></script>
<!-- jQuery UI -->
<script src="<?=base_url('assets/template/adminlte3/plugins/jquery-ui/jquery-ui.min.js')?>"></script>
<!-- Bootstrap -->
<script src="<?=base_url('assets/template/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js')?>"></script>
<!-- overlayScrollbars -->
<script src="<?=base_url('assets/template/adminlte3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')?>"></script>
<!-- AdminLTE App -->
<script src="<?=base_url('assets/template/adminlte3/dist/js/adminlte.js')?>"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?=base_url('assets/template/adminlte3/dist/js/demo.js')?>"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?=base_url('assets/template/adminlte3/plugins/jquery-mousewheel/jquery.mousewheel.js')?>"></script>
<script src="<?=base_url('assets/template/adminlte3/plugins/raphael/raphael.min.js')?>"></script>
<script src="<?=base_url('assets/template/adminlte3/plugins/jquery-mapael/jquery.mapael.min.js')?>"></script>
<script src="<?=base_url('assets/template/adminlte3/plugins/jquery-mapael/maps/usa_states.min.js')?>"></script>
<!-- ChartJS -->
<script src="<?=base_url('assets/template/adminlte3/plugins/chart.js/Chart.min.js')?>"></script>

<!-- PAGE SCRIPTS -->
<!-- <script src="<?=base_url('assets/template/adminlte3/dist/js/pages/dashboard2.js')?>"></script> -->

<!-- sweetalert2 -->
<script src="<?= base_url('assets/template/adminlte3/plugins_other/sweetalert2/dist/sweetalert2.all.min.js')?>"></script>


<!-- Pace -->
<script src="<?= base_url('assets/template/adminlte3/plugins/pace-progress/pace.min.js')?>"></script>
<!-- toastr -->
<script src="<?= base_url('assets/template/adminlte3/plugins/toastr/toastr.min.js')?>"></script>
<!-- toastr -->
<script src="<?= base_url('assets/template/adminlte3/plugins_other/intro/intro.min.js')?>"></script>
<!-- select2 -->
<script src="<?=base_url('assets/template/adminlte3/plugins/select2/js/select2.full.min.js')?>"></script>

</body>

</html>

<script type="text/javascript">
	$(document).ready(function (e) {

		$(document).ajaxStart(function () {
			Pace.restart();
		});

		$('a#btnLogout').click(function (e) {
			e.preventDefault();

			Swal.fire({
				title: 'ออกจากระบบ',
				text: "คุณต้องการออกจากระบบหรือไม่",
				showClass: {
					popup: 'animated fadeInDown faster',
					icon: 'animated heartBeat delay-1s'
				},
				hideClass: {
					popup: 'animated fadeOutUp faster',
				},
				icon: 'question',
				allowOutsideClick: false,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'ใช่ ,ฉัน ตกลง',
				cancelButtonText: 'ปิด',
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: $('body').attr('data-siteurl') + "/Main/logout",
					}).done(function ($data) {
						if ($data == "") {
							location.reload();
						} else {
							alert($data);
						}
					});
				}
			})

		});
	});

</script>
