<?php

	include("functions.php");

	// Get search term 
	// print_r($_GET);
// $searchTerm = $_GET['term'];
 

// $query = "SELECT * FROM `groups` WHERE `name` LIKE '%".$searchTerm."%' ORDER BY name ASC"; 

// $result = mysqli_query($link, $query);
 
// // Generate array with skills data 
// $groupNames = array(); 
// if(mysqli_num_rows($result) > 0){ 
//     while($row = mysqli_fetch_assoc($result)){ 
//         $data['id'] = $row['id']; 
//         $data['value'] = $row['name']; 
//         array_push($groupNames, $data); 
//     } 
// } 

$query = "SELECT `name` FROM `groups` ORDER BY `name` ASC"; 

$result = mysqli_query($link, $query);

$groupNames = array();

while($row = mysqli_fetch_assoc($result)){ 
    $data['id'] = $row['id']; 
    $data['value'] = $row['name']; 
    array_push($groupNames, $data); 
} 

 
// Return results as json encoded array 
echo json_encode($groupNames); 


?>
