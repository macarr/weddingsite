<?php
	//getrsvp.php?invite=4g5h9273846g5io8nh987g59 -> given the provided invite code, retrieve the invite data
	include('db.php');

	$q = $_GET['invite'];
	
	if(!($stmt = $mysqli->prepare("SELECT INVITE_ID, PLUS_ONES, REQUIRES_HOTEL_IND, HOTEL_ROOMS_REQUIRED from INVITES WHERE INVITE_CODE = ?"))) {
		echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
	}

	if (!$stmt->bind_param("s", $q)) {
		echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	if(!$stmt->execute()) {
		echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
	}

	$stmt->bind_result($inviteId, $plusOnes, $requiresHotel, $roomsRequired);
	$stmt->fetch();
	$stmt->close();
	if($inviteId == null) {
		http_response_code(404);
	} else {

		if(!($stmt = $mysqli->prepare("SELECT INVITEE_ID, INVITEE_NAME, ATTENDING_IND, NOTES from INVITEES WHERE INVITE_ID = ?"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}

		if (!$stmt->bind_param("i", $inviteId)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		if(!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		$stmt->bind_result($inviteeId, $inviteeName, $attendingInd, $inviteeNotes);

		$invitees = array();

		while($stmt->fetch()) {
			$invitee = array("id" => $inviteeId, "name" => $inviteeName, "attendingInd" => $attendingInd, "notes" => $inviteeNotes);
			array_push($invitees, $invitee);
		}

		if(!($stmt = $mysqli->prepare("SELECT PLUS_ONE_ID, PLUS_ONE_NAME, NOTES from PLUS_ONES WHERE INVITE_ID = ?"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}

		if (!$stmt->bind_param("i", $inviteId)) {
			echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		if(!$stmt->execute()) {
			echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		$stmt->bind_result($plusOneId, $plusOneName, $plusOneNotes);

		$guests = array();

		while($stmt->fetch()) {
			$plusOne = array("id" => $plusOneId, "name" => $plusOneName, "notes" => $plusOneNotes);
			array_push($guests, $plusOne);
		}

		$rsvp = array("inviteCode" => $q, "invitees" => $invitees, "requiresHotel" => $requiresHotel, "numRooms" => $roomsRequired, "plusOnes" => $plusOnes, "guests" => $guests);
		echo json_encode($rsvp, JSON_HEX_APOS);
	}
?>