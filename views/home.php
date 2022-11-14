<div class="container" style="margin: 0 auto; padding-bottom:50px;">

	<?php

		//display posts

		if (isset($_COOKIE['id'])) {
			$userid = $_COOKIE['id'];
			getTea($link, true, $userid);
		} else {
			getTea($link, false, null);
		}

	?>

	<script>

		

		// function refreshPosts() {
		// 	$.ajax({
		//         type: "GET",
		//         url: "actions.php?action=getTea",
		//         data: "userid=" + id + "&content=" + $("#teaTextarea").val(),
		//         success: function(result) {
		//           $(".container").html($(".container").html() + result);
		//         }
		//       })
		// }

	</script>
	
</div>