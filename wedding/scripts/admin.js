document.getElementById("addRow").addEventListener("click", function() {
	addRow()
});
document.getElementById("submit").addEventListener("click", function() {
	submitInvite()
});

function reset() {
	console.log("reset");
	var guestList = document.getElementById("guestList");
	for(i=1; i < guestList.rows.length; i++) {
		guestList.deleteRow(i);
	}
	guestList.rows[0].cells[0].firstChild.value = "";
	document.getElementById("plusOnes").value = 0;
}

function addRow() {
	console.log("addRow");
	var guestList = document.getElementById("guestList");
	var row = guestList.insertRow(guestList.rows.length);
	var col1 = row.insertCell(0);
	var guest = document.createElement('input');
	guest.type = "text";
	col1.appendChild(guest);
	var col2 = row.insertCell(1);
	var minus = document.createElement('span');
	minus.className = "glyphicon glyphicon-minus";
	minus.setAttribute("aria-hidden", "true");
	minus.addEventListener("click", function(event) { 
		var targetElement = event.target || event.srcElement;
		deleteRow(targetElement) 
	});
	col2.appendChild(minus);

}

function submitInvite() {
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
			}
			reset();
		}
	};
	console.log("submitInvite");
	var guestList = document.getElementById("guestList");
	var request = {};
	var guests = [];
	for(rownum = 0; rownum < guestList.rows.length; rownum++) {
		if(guestList.rows[rownum].cells[0].firstChild.value.trim() != '') {
			guests.push(guestList.rows[rownum].cells[0].firstChild.value);
		}
	}
	request["guests"] = guests;
	request["plusOnes"] = document.getElementById("plusOnes").value;
	xmlhttp.open("POST", "includes/createInvite.php",true);
	xmlhttp.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
	xmlhttp.send(JSON.stringify(request));

}

function deleteRow(element) {
	console.log("deleteRow");
	parentRow = element.parentNode.parentNode;
	parentRow.parentNode.removeChild(parentRow);
}