<?php
	//postrsvp.php -> takes POSTed JSON invite object and inserts into the database
	include('db.php');
	$data = json_decode(file_get_contents('php://input'), true);

	//update invite
	if(!($stmt = $mysqli->prepare("UPDATE INVITES SET REQUIRES_HOTEL_IND = ?, HOTEL_ROOMS_REQUIRED = ? WHERE INVITE_CODE = ?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("sds", $data["requiresHotel"], $data["numRooms"], $data["inviteId"])) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if(!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		die();
	}

	$stmt->close();

	//get inviteId;
	if(!($stmt = $mysqli->prepare("SELECT INVITE_ID from INVITES WHERE INVITE_CODE = ?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("s", $data["inviteId"])) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if(!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		die();
	}

	$stmt->bind_result($inviteId);
	$stmt->fetch();
	$stmt->close();

	//update invitees
	for($i = 0; $i < count($data["invitees"]); $i++) {
		if(!($stmt = $mysqli->prepare("UPDATE INVITEES SET ATTENDING_IND = ?, NOTES = ? WHERE INVITE_ID = ? AND INVITEE_ID = ?"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if (!$stmt->bind_param("ssss", $data["invitees"][$i]["attending"], $data["invitees"][$i]["notes"], $inviteId, $data["invitees"][$i]["id"])) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		if(!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			die();
		}

		$stmt->close();
	}

	//update plus ones

	for($i = 0; $i < count($data["plusOnes"]); $i++) {
		if($data["plusOnes"][$i]["id"] == null && !($data["plusOnes"][$i]["name"] == null)) {
			if(!($stmt = $mysqli->prepare("INSERT INTO PLUS_ONES (PLUS_ONE_NAME, NOTES, INVITE_ID) VALUES (?, ?, ?)"))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			if (!$stmt->bind_param("sss", $data["plusOnes"][$i]["name"], $data["plusOnes"][$i]["notes"], $inviteId)) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}
		} else if (!($data["plusOnes"][$i]["id"] == null) && $data["plusOnes"][$i]["name"] == null) {
			if(!($stmt = $mysqli->prepare("DELETE FROM PLUS_ONES WHERE PLUS_ONE_ID = ?"))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			if (!$stmt->bind_param("s", $data["plusOnes"][$i]["id"])) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}
		} else {
			if(!($stmt = $mysqli->prepare("UPDATE PLUS_ONES SET PLUS_ONE_NAME = ?, NOTES = ? WHERE INVITE_ID = ? AND PLUS_ONE_ID = ?"))) {
				echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
			}
			if (!$stmt->bind_param("ssss", $data["plusOnes"][$i]["name"], $data["plusOnes"][$i]["notes"], $inviteId, $data["plusOnes"][$i]["id"])) {
				echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
			}
		}

		if(!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			die();
		}
		$stmt->close();
	}

?>