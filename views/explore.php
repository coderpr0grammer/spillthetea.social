<div class="container" style="margin: 0 auto; padding-bottom:50px;">
	<br>
	<?php

		if (isset($_GET["group"])) {
			$groupid = mysqli_real_escape_string($link, $_GET["group"]);
			
			if (isset($_COOKIE["id"])) {
            	explorePage($link, $groupid, $_COOKIE["id"]);
        	} else {
        		explorePage($link, $groupid, null);
        	}

		} else {

            if (isset($_COOKIE["id"])) {
            	$userid = mysqli_real_escape_string($link, $_COOKIE["id"]);
				showGeneralTea($link, $userid);
			} else {
				showGeneralTea($link, null);
			}
			
		}

		
				



	?>

</div>