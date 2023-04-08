<?php echo loadModalUpload(); ?>
<script>
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	  return new bootstrap.Tooltip(tooltipTriggerEl)
	})

	function showMenu() {
		if($('.mm-container-menu').hasClass('active')) {
			$('.mm-container-menu').removeClass('active');
		} else {
			$('.mm-container-menu').addClass('active');
		}
	}
</script>
</html>
