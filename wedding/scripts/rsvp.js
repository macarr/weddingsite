document.getElementById("loadInvite").addEventListener("click", function() {
	loadInvite(document.getElementById("inviteCode").value);
});

document.getElementById("submitInvite").addEventListener("click", function() {
	submitInvite();
});

document.getElementById("clear").addEventListener("click", function() {
	location.reload();
});

$('#requiresHotel').click(function() {
    $("#numRoomsTxt").toggle(this.checked);
});

function loadInvite(str) {
	console.log("loadInvite");
	if(str == "") {
		//error
	} else {
		document.getElementById("inviteErrors").innerHTML = "";
		if (window.XMLHttpRequest) {
			//code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {
			//code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200 && xmlhttp.responseText) {
				var inviteBox = document.getElementById("inviteCode");
				inviteBox.disabled = true;
				var clearButton = document.getElementById("clear");
				clearButton.hidden = false;
				var table = document.getElementById("invitees");
				table.innerHTML = "";
				table = document.getElementById("plusOnes");
				table.innerHTML = "";
				var response;
				try {
					response = jQuery.parseJSON(xmlhttp.responseText);
					var requiresHotel = response["requiresHotel"].toUpperCase() === "Y";
					document.getElementById("requiresHotel").checked = requiresHotel;
					if(!requiresHotel) {
						document.getElementById("numRoomsTxt").hidden = true;
					} else {
						document.getElementById("numRoomsTxt").hidden = false;
						document.getElementById("numRooms").value = response["numRooms"];
					}
					populateInvitees(response["invitees"]);
					if(isNaN(response["plusOnes"]) || response["plusOnes"] == null) {
						response["plusOnes"] = 0;
					}
					document.getElementById("plusOnesText").innerHTML = response["plusOnes"];
					if(response["plusOnes"] > 0) {
						document.getElementById("guestTable").hidden = false;
					} else {
						document.getElementById("guestTable").hidden = true;
					}
					populatePlusOnes(response["guests"], response["plusOnes"]);
					document.getElementById("inviteData").hidden = false;
					
				} catch (e) {
					console.log("Bad response from server: " + e + e.message);
				}
			} else if(xmlhttp.readyState == 4 && xmlhttp.status == 404){
				document.getElementById("inviteErrors").innerHTML = "Invite code not found";
			}
		};
		xmlhttp.open("GET", "includes/getrsvp.php?invite="+str,true);
		xmlhttp.send();
	}
}

function populateInvitees(inviteesArray) {
	console.log("populate Invitees");
	var table = document.getElementById("invitees");
	for(i = 0; i < inviteesArray.length; i++) {
		var row = table.insertRow(table.rows.length);
		row.id = inviteesArray[i].id;
		var col1 = row.insertCell(0);
		col1.innerHTML = inviteesArray[i].name;
		var col2 = row.insertCell(1);
		var checkbox = document.createElement('input');
		checkbox.type = "checkbox";
		if(!(inviteesArray[i]["attendingInd"] == undefined)) {
			checkbox.checked = (inviteesArray[i]["attendingInd"].toUpperCase() === "Y");
		}
		col2.appendChild(checkbox);
		var col3 = row.insertCell(2);
		var notes = document.createElement('input');
		notes.type = "text";
		notes.value = inviteesArray[i]["notes"];
		col3.appendChild(notes);
	}

}

function populatePlusOnes(plusOnesArray, total) {

	var table = document.getElementById("plusOnes");
	for(i = 0; i < plusOnesArray.length; i++) {
		var row = table.insertRow(table.rows.length);
		row.id = plusOnesArray[i].id;
		var col1 = row.insertCell(0);
		var name = document.createElement('input');
		name.value = plusOnesArray[i].name;
		col1.appendChild(name);
		var col2 = row.insertCell(1);
		var notes = document.createElement('input');
		notes.type = "text";
		notes.value = plusOnesArray[i].notes;
		col2.appendChild(notes);
	}
	for(i = plusOnesArray.length; i < total; i++) {
		var row = table.insertRow(table.rows.length);
		var col1 = row.insertCell(0);
		var name = document.createElement('input');
		name.type = "text";
		col1.appendChild(name);
		var col2 = row.insertCell(1);
		var notes = document.createElement('input');
		notes.type = "text";
		col2.appendChild(notes);
	}
}

function submitInvite() {
	console.log("submitInvite");
	if(false) {
		//error
	} else {
		if (window.XMLHttpRequest) {
			//code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else {
			//code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				document.getElementById("postErrors").innerHTML = "";
				if(xmlhttp.responseText) {
					document.getElementById("postErrors").innerHTML = "There was an error:<br>" + xmlhttp.responseText;
				} else {
					document.getElementById("postErrors").innerHTML = "RSVP submitted!";
				}
				loadInvite(document.getElementById("inviteCode").value);

			}
		};

		var data = {};
		data["inviteId"] = document.getElementById("inviteCode").value;
		var invitees = [];
		inviteesTable = document.getElementById("invitees")
		for(var i = 0; i < inviteesTable.rows.length; i++) {
			row = inviteesTable.rows[i];
			var invitee = {};
			invitee["id"] = row.id;
			invitee["name"] = row.cells[0].innerHTML;
			invitee["attending"] = row.cells[1].firstChild.checked;
			if(invitee["attending"]) {
				invitee["attending"] = "Y";
			} else {
				invitee["attending"] = "N";
			}
			invitee["notes"] = row.cells[2].firstChild.value;
			invitees.push(invitee);
		}
		data["invitees"] = invitees;
		data["requiresHotel"] = document.getElementById("requiresHotel").checked;
		if(data["requiresHotel"]) {
			data["requiresHotel"] = "Y";
			data["numRooms"] = document.getElementById("numRooms").value;
		} else {
			data["requiresHotel"] = "N";
			data["numRooms"] = 0;
		}
		var plusOnes = [];
		plusOnesTable = document.getElementById("plusOnes");
		for(var i = 0; i < plusOnesTable.rows.length; i++) {
			row = plusOnesTable.rows[i];
			var plusOne = {};
			plusOne["id"] = row.id;
			plusOne["name"] = row.cells[0].firstChild.value;
			plusOne["notes"] = row.cells[1].firstChild.value;
			plusOnes.push(plusOne);
		}
		data["plusOnes"] = plusOnes;
		xmlhttp.open("POST", "includes/postrsvp.php",true);
		xmlhttp.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
		xmlhttp.send(JSON.stringify(data));
	}
}