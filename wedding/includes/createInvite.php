<?php
	//createInvite.php -> takes POSTed JSON guestlist object and creates an invite in the database
	include('db.php');

	$data = json_decode(file_get_contents('php://input'), true);
	$inviteCode = substr(hash("sha1", file_get_contents('php://input')), 0, 6);

	//create invite
	
	if(!($stmt = $mysqli->prepare("INSERT INTO INVITES (INVITE_CODE, PLUS_ONES) VALUES (?, ?)"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("sd", $inviteCode, $data["plusOnes"])) {
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

	if (!$stmt->bind_param("s", $inviteCode)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if(!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		die();
	}

	$stmt->bind_result($inviteId);
	$stmt->fetch();
	$stmt->close();

	//create invitees
	for($i = 0; $i < count($data["guests"]); $i++) {
		if(!($stmt = $mysqli->prepare("INSERT INTO INVITEES(INVITEE_NAME, INVITE_ID) VALUES (?, ?)"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		if (!$stmt->bind_param("ss", $data["guests"][$i], $inviteId)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		if(!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
			die();
		}
		$stmt->close();
	}
?>