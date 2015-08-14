
	<script type="text/javascript">
		$(function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-Token': $('meta[name="_token"]').attr('content')
				}
			});
		});
	</script>
	</body>
</html>
