<?php

	include("functions.php");
	ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	if ($_GET["action"] == "loginSignup") {
		// print_r($_POST);

		$error = "";

		if (!$_POST["username"]) {
			$error = "A username is required";
		} else if (!$_POST["password"]) {
			$error = "A password is required";
		}


		if ($error != "") {
			echo $error;
			exit;
		}

		if ($_POST["isLoggingIn"] == "0") {
			$query = "SELECT `id` FROM `users` WHERE `username`='" . mysqli_real_escape_string($link, $_POST["username"]) . "'";
			$result = mysqli_query($link, $query);

			if (mysqli_num_rows($result) == 1) {
				$error = "Sorry, that username has already been taken.";
			} else {
				
                $sHash = password_hash(mysqli_real_escape_string($link, $_POST['password']), PASSWORD_DEFAULT);

                $query = "INSERT INTO `users` (`username`, `password`) VALUES ('".mysqli_real_escape_string($link, $_POST['username'])."', '".$sHash."')";

                if (mysqli_query ($link, $query)) {
                	//user has been signed up
                	setcookie ("id", mysqli_insert_id($link), time() + (10 * 365 * 24 * 60 * 60));
					echo 1;
				} else {
					$error = "Sorry, there was an error creating your account. Please try again later or contact support.";
				}
			}

		} else {
			$query = "SELECT * FROM `users` WHERE `username`='" . mysqli_real_escape_string($link, $_POST["username"]) . "'";

			$result = mysqli_query($link, $query);

			if ($row = mysqli_fetch_assoc($result)) {
				if (password_verify ($_POST["password"], $row["password"])) {
					//user is verified, can be logged in.

					echo 2;
					setcookie ("id", $row["id"], time() + (10 * 365 * 24 * 60 * 60));

				} else {
					$error = "Sorry, that password doesn't match the username you have entered.";
				}

			} else {
				$error = "Sorry, we couldn't find an account with that username.";
			}
			



		}


		if ($error != "") {
			echo $error;
			exit;
		}


	}

	//logout 
	if ($_GET["action"] == "logout") {
		logout();
		echo 1;

	}

	//registering groups

	if ($_GET["action"] == "registerGroup") {

		// $output = array(
		// 	"response" => null,
		// 	"error" => null,
		// 	"name" => null,
		// 	"description" => null,
		// 	"id" => null
		// );

		$error = "";

		if (!$_POST["name"]) {
			$error = "Sorry, a Group Name is required";
		} else if (!$_POST["description"]) {
			$error = "Sorry, a description is required";
		}


		if ($error != "") {
			$output = array(
				"response" => 0,
				"error" => $error,
				"name" => null,
				"description" => null,
				"id" => null
			);
		}

		$query = "SELECT `id` FROM `groups` WHERE `name`='" . mysqli_real_escape_string($link, $_POST["name"]) . "'";
		$result = mysqli_query($link, $query);

		if (mysqli_num_rows($result) == 1) {
				$error = "Sorry, that Community Name has already been taken.";
				$output = array(
					"response" => 0,
					"error" => $error,
					"name" => null,
					"description" => null,
					"id" => null
					);
			} else {

				$query = "INSERT INTO `groups` (`name`, `description`) VALUES ('".mysqli_real_escape_string($link, $_POST['name'])."', '". mysqli_real_escape_string($link, $_POST['description']) ."')";

                if (mysqli_query ($link, $query)) {
                	//group successfully created
                	$output = array(
						"response" => 1,
						"error" => null,
						"name" => $_POST['name'],
						"description" => $_POST['description'],
						"id" => mysqli_insert_id($link)
					);
                } else {
                	$error = "Sorry, there was an error on our end with creating this Community. Please try again later or contact support.";
                	$output = array(
						"response" => 0,
						"error" => $error,
						"name" => null,
						"description" => null,
						"id" => null
					);
                }

			}

			echo json_encode($output);


	}

	//posting Tea

	if ($_GET["action"] == "postTea") {

		$error = "";
		$group = "";

		if ($_POST["group"] == "") {
			$group = "Tea of the World";
		} else {
			$group = mysqli_real_escape_string($link, $_POST["group"]);
		}
		if (!$_POST["content"]) {
			$error = "Don't forget to write the tea! ☕";
		}

		if ($error != "") {
			echo $error;
			exit;
		}

		$findGroupId = "SELECT * FROM `groups` WHERE `name`='". $group . "'";
		$result1 = mysqli_query($link, $findGroupId);
		if ($row = mysqli_fetch_assoc($result1)) {
			$groupid = $row["id"]; 
			$query = "INSERT INTO `tea` (`groupid`, `content`, `date`, `likes`, `downvotes`, `comments`) VALUES ('" . $groupid . "', '" . mysqli_real_escape_string($link, $_POST["content"]) . "', NOW(), 0, 0, '" . json_encode(array()). "')";
			if (mysqli_query($link, $query)) {
				echo 1;
			} else {
				$error = mysqli_error($link);
			}
		} else {
			$error = "Sorry, that group does not exist. Please select one of the available groups.";
		}

		
		if ($error != "") {
			echo $error;
			exit;
		}

	}

	// if ($_GET["action"] == "getTea") {
	// 	echo $_GET["id"];
	// }

	if ($_GET["action"] == "followUnfollowGroup") {

		$usernameQuery = "SELECT * FROM `users` WHERE `username`='" . $_POST["username"] . "'";
		$result1 = mysqli_query($link, $usernameQuery);
		$row = mysqli_fetch_assoc($result1);

		$query = "SELECT * FROM `groupfollowers` WHERE `userid`='" . $row["id"] . "' AND `groupid`='". $_POST["group"] . "'";
		$result = mysqli_query($link, $query);

		if (mysqli_num_rows($result) > 0) {
			$query = "DELETE FROM `groupfollowers` WHERE `userid`='" . $row["id"] . "' AND `groupid`='". $_POST["group"] . "'";
			if (mysqli_query($link, $query)) {
				echo 2;
			}
		} else {

			$insertQuery = "INSERT INTO `groupfollowers` (`userid`, `groupid`) VALUES ('" . $row["id"] . "', '" . $_POST["group"] . "')";

			if (mysqli_query ($link, $insertQuery)) {
				echo 1;
			} else {
				echo "Sorry, we ran into an issue trying to add you to this group. Please try again later or contact support.";
			}

		}
		
		
	}

	//add likes

	if ($_GET["action"] == "like") {

		$usernameQuery = "SELECT * FROM `users` WHERE `username`='" . $_POST["username"] . "'";
		$result1 = mysqli_query($link, $usernameQuery);
		$row = mysqli_fetch_assoc($result1);

		$userid = $row["id"];

		$postid = mysqli_real_escape_string($link, $_POST["postid"]);

		//find if user has liked the post already

		$likeQuery = "SELECT * FROM `likes` WHERE `postid`='" . $postid . "' AND `userid`='" . $userid . "'";

		$likeResult = mysqli_query($link, $likeQuery);

		if (mysqli_num_rows($likeResult) > 0) {
			//user has liked the post previously, so we must remove the like
			$deleteLike = "DELETE FROM `likes` WHERE `postid`='" . $postid . "' AND `userid`='" . $userid . "'";
			if (mysqli_query($link, $deleteLike)) {

				// //also update like count on post itself

				$updateLikeCount = "UPDATE `tea` SET `likes`=`likes`-1 WHERE `id`='" . $postid . "'";
				$result = mysqli_query($link, $updateLikeCount);

				echo "2";
			} else {
				echo "Server error";
			}

		
		} else {

			//user has not liked the post, so add the like
			$addLike = "INSERT INTO `likes` (`userid`, `postid`) VALUES('" . $userid . "', '" . $postid . "')";
			
			if (mysqli_query($link, $addLike)) {

				//also update like count on post itself
				// $postQuery = "SELECT * FROM `tea` WHERE `id`='" . $postid . "'";
				// $postResult = mysqli_query($link, $postQuery);
				// $row2 = mysqli_fetch_assoc($postResult);

				// $newLikeCount = $row2["likes"] + 1;

				$updateLikeCount = "UPDATE `tea` SET `likes`=`likes`+1 WHERE `id`='" . $postid . "'";
				$result = mysqli_query($link, $updateLikeCount);

				$downvoteQuery = "SELECT * FROM `downvotes` WHERE `postid`='" . $postid . "' AND `userid`='" . $userid . "'";

				$downvoteResult = mysqli_query($link, $downvoteQuery);

				if (mysqli_num_rows($downvoteResult) > 0) {
					$removeDownvote = "UPDATE `tea` SET `downvotes`=`downvotes`-1 WHERE `id`='" . $postid . "'";
					$downvoteResult = mysqli_query($link, $removeDownvote);
					$deleteDownvoteFromTable = "DELETE FROM `downvotes` WHERE `userid`='" . $userid . "' AND `postid`='" . $postid . "'";
					$deleteResult = mysqli_query($link, $deleteDownvoteFromTable);
				}


				echo "1";
			} else {
				echo "Server error";
			}

		}
	}

	//downvotes 

	if ($_GET["action"] == "downvote") {

		$usernameQuery = "SELECT * FROM `users` WHERE `username`='" . $_POST["username"] . "'";
		$result1 = mysqli_query($link, $usernameQuery);
		$row = mysqli_fetch_assoc($result1);

		$userid = $row["id"];

		$postid = mysqli_real_escape_string($link, $_POST["postid"]);

		//find if user has downvoted the post already

		$downvoteQuery = "SELECT * FROM `downvotes` WHERE `postid`='" . $postid . "' AND `userid`='" . $userid . "'";

		$downvoteResult = mysqli_query($link, $downvoteQuery);

		if (mysqli_num_rows($downvoteResult) > 0) {
			//user has downvoted the post previously, so we must remove the downvote
			$deleteDownvote = "DELETE FROM `downvotes` WHERE `postid`='" . $postid . "' AND `userid`='" . $userid . "'";
			if (mysqli_query($link, $deleteDownvote)) {

				// //also update like count on post itself

				$updateDownvoteCount = "UPDATE `tea` SET `downvotes`=`downvotes`-1 WHERE `id`='" . $postid . "'";
				$result = mysqli_query($link, $updateDownvoteCount);

				echo "2";
			} else {
				echo "Server error";
			}

		
		} else {

			//user has not downvoted the post, so add the downvote
			$addDownvote = "INSERT INTO `downvotes` (`userid`, `postid`) VALUES('" . $userid . "', '" . $postid . "')";
			
			if (mysqli_query($link, $addDownvote)) {

				//also update like count on post itself
				// $postQuery = "SELECT * FROM `tea` WHERE `id`='" . $postid . "'";
				// $postResult = mysqli_query($link, $postQuery);
				// $row2 = mysqli_fetch_assoc($postResult);

				// $newLikeCount = $row2["likes"] + 1;

				$updateDownvoteCount = "UPDATE `tea` SET `downvotes`=`downvotes`+1 WHERE `id`='" . $postid . "'";
				$result = mysqli_query($link, $updateDownvoteCount);


				$likeQuery = "SELECT * FROM `likes` WHERE `postid`='" . $postid . "' AND `userid`='" . $userid . "'";

				$likeResult = mysqli_query($link, $likeQuery);

				if (mysqli_num_rows($likeResult) > 0) {
					$removeLike = "UPDATE `tea` SET `likes`=`likes`-1 WHERE `id`='" . $postid . "'";
					$result = mysqli_query($link, $removeLike);
					$deleteLikeFromTable = "DELETE FROM `likes` WHERE `userid`='" . $userid . "' AND `postid`='" . $postid . "'";
					$deleteResult = mysqli_query($link, $deleteLikeFromTable);
				}

				echo "1";
			} else {
				echo "Server error";
			}

		}
	}

	if ($_GET["action"] == "search") {
		$error = "";
		if (isset($_GET["searchQuery"])) {
			$query = "SELECT * FROM `groups` WHERE `name`='" . mysqli_real_escape_string($link, $_GET["searchQuery"]) . "' LIMIT 1";
			$result = mysqli_query($link, $query);
			if (mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_assoc($result);
				$output = array(
					"response" => 1, 
					"groupid" => $row["id"]
				);
				echo json_encode($output);
			} else {
				$error = "Oops! Please choose from one of the search results";
			}

		} else {
			$error = "Please enter a search term";
		}

		if ($error != "") {
			$output = array(
				"response" => 0,
				"groupid" => null
			);
			echo json_encode($output);
		}
	}

	if ($_GET["action"] == "getGroup") {
		$query = "SELECT * FROM `groups` WHERE `id`='" . $_GET["groupid"] . "' LIMIT 1";
		$result = mysqli_query($link, $query);
		if (mysqli_num_rows($result) > 0) {
			echo mysqli_fetch_assoc($result)["name"];
		} else {
			echo 0;
		}
	}

	function newTLComment($username, $content, $link) {
		$newComment = array(
			"id" => uniqid(),
			"username" => $username,
			"verified" => 0,
			"comment" => $content,
			"date" => date('Y-m-d H:i:s'),
			"replies" => array()
		);

		$query = "SELECT * FROM `users` WHERE `username`='" . $username . "' LIMIT 1";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_assoc($result);
		if ($row["verified"] == 1) {
			$newComment["verified"] = 1;
		}

		return $newComment;
	}

	function newReply($username, $content, $link) {
		$newReply = array(
			"id" => uniqid(),
			"username" => $username,
			"verified" => 0,
			"comment" => $content,
			"date" => date('Y-m-d H:i:s')
		);
		$query = "SELECT * FROM `users` WHERE `username`='" . $username . "' LIMIT 1";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_assoc($result);
		if ($row["verified"] == 1) {
			$newComment["verified"] = 1;
		}

			
		return $newReply;
	}

	if ($_GET["action"] == "postComment") {
		$comment = $_POST["content"];
		$username = $_POST["username"];

		//check if there are comments on this post

		$query = "SELECT * FROM `tea` WHERE `id`='" . $_POST["postid"] . "'";
		$result = mysqli_query($link, $query);
		$row = mysqli_fetch_assoc($result);

		$commentsInDB = json_decode($row["comments"], JSON_UNESCAPED_UNICODE);

		if ($commentsInDB == NULL) {
			$updateComments = array();
		} else {
			$updateComments = $commentsInDB;
		}

		if ($_POST["replyingTo"] != "") {
			foreach ($updateComments as $key => $value) {
				if ($value["id"] == $_POST["replyingTo"]) {

					array_push($updateComments[$key]["replies"], newReply($username, $comment, $link));

				}
			}
		} else {
			// newTLComment($username, $comment);
			array_push($updateComments, newTLComment($username, $comment, $link));

		}

		//insert array as JSON into db
		$jsonToInsert = json_encode($updateComments, JSON_UNESCAPED_UNICODE);

		$query2 = "UPDATE `tea` SET `comments`='" . $jsonToInsert . "' WHERE `id`='" . $_POST["postid"] . "'";
		if (mysqli_query($link, $query2)) {
			echo "sucess";
		} else {
			echo 0;
		}
	
	}

	if ($_GET["action"] == "getComments") {
		$postid = $_GET["postid"];
		$query = "SELECT * FROM `tea` WHERE `id`='" . $postid . "' LIMIT 1";
		$result = mysqli_query($link, $query);
		$comments = mysqli_fetch_assoc($result)["comments"];
		print_r($comments);

	}


?>