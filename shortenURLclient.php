<? 
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	require_once $_SERVER["DOCUMENT_ROOT"] ."/functions.php"; 
	require_once $_SERVER["DOCUMENT_ROOT"] ."/views/header.php";
	require_once $_SERVER["DOCUMENT_ROOT"] ."/views/footer.php";



?>
<form id="urlForm">
	<input type="text" id="URLINPUT">
	<button type="submit">Submit</button>
</form>
<br>
<br>
verify form
<form id="verifyForm">
	<input type="text" id="username">
	<button type="submit">Submit</button>
</form>
<script>
	$("#urlForm").submit(function(e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "https://spillthetea.social/shortenURL.php",
			data: "longURL=" + $("#URLINPUT").val(),
			success: function (data) {
				console.log(data);
			}
		})
	})

	$("#verifyForm").submit(function(e) {
		e.preventDefault();
		$.ajax({
			type: "POST",
			url: "https://spillthetea.social/verifyUser.php",
			data: "username=" + $("#username").val(),
			success: function (data) {
				console.log(data);
			}
		})
	})


</script>