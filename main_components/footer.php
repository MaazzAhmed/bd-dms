<!--start overlay-->
<div class="overlay toggle-icon"></div>
<!--end overlay-->
<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
<!--End Back To Top Button-->
<footer class="page-footer">
	<p class="mb-0">Copyright © <span id="year"></span>. All right reserved.</p>
</footer>
</div>

<!--end wrapper-->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<!-- Include Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="assets/plugins/select2/js/select2.min.js"></script>
<script>
	$('.single-select').select2({
		theme: 'bootstrap4',
		width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
		placeholder: $(this).data('placeholder'),
		allowClear: Boolean($(this).data('allow-clear')),
	});
	$('.multiple-select').select2({
		theme: 'bootstrap4',
		width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
		placeholder: $(this).data('placeholder'),
		allowClear: Boolean($(this).data('allow-clear')),
	});
</script>
<script src="assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
<script src="assets/js/app.js"></script>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>



<script>
	$(document).ready(function() {
		$('.single-select').select2();

		$('#newEmail').on('change', function() {
			var newEmail = $(this).val();
			var select = $('.single-select');
			var optionExists = ($('#employee\\[\\] option[value="' + newEmail + '"]').length > 0);
			if (newEmail.trim() !== '' && !optionExists) {
				var newOption = new Option(newEmail, newEmail, true, true);
				select.append(newOption).trigger('change');
			}
			$(this).val('');
		});
	});
</script>

<script src="summernote"></script>

<script>
	var $j = jQuery.noConflict();

	$j(document).ready(function() {

		$j('#textsss').summernote({

			height: 200,



		});

	});
</script>
<script>
	$(document).ready(function() {
		$('#example').DataTable()
	});
</script>


<script>
	$(document).ready(function() {
		var table = $('#example2').DataTable({
			lengthChange: false,
			buttons: ['copy', 'excel', 'pdf', 'print']
		});

		table.buttons().container()
			.appendTo('#example2_wrapper .col-md-6:eq(0)');
	});
</script>

<script>
	const currentYear = new Date().getUTCFullYear();
	const year = document.getElementById("year");
	year.textContent = currentYear;
</script>

<script>
	// tooltip
	const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
	const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
<!--app JS-->



</body>

</html>
<?php

?>