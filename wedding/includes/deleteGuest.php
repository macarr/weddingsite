<?php
	//deleteGuest.php?guestId=# -> deletes the selected guest from the database
	//TODO: add check to ensure provided guest is part of the invitee's party
	include('db.php');
	$q = intval($_GET['guestId']);
	
	if(!($stmt = $mysqli->prepare("DELETE FROM PLUS_ONES WHERE PLUS_ONES_ID = ?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("i", $q)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if(!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	echo json_encode(array("rows" => $stmt->num_rows), JSON_FORCE_OBJECT);
?>