<html>
	<head>
		<meta charset="utf-8">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	    <meta name="description" content="">
	    <meta name="author" content="">
	    <link rel="icon" href="../../favicon.ico">

	    <title>Matt and Vicky's Wedding!</title>

	    <!-- Bootstrap core CSS -->
	    <link href="css/bootstrap.min.css" rel="stylesheet">

	    <!-- Custom styles for this template -->
	    <link href="css/navbar-static-top.css" rel="stylesheet">

	    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	    <!--[if lt IE 9]>
	      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	    <![endif]-->
	</head>
	<body>
	<!-- Static navbar -->
    <nav class="navbar navbar-default navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Matt and Vicky's Wedding</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.html">Home</a></li>
            <li class="active"><a href="#">RSVP</a></li>
            <li><a href="registry.html">Registry</a></li>
            <li><a href="admin.php">Admin</a></li>
            <li><a href="guestList.php">Guest List</a></li>
            <li><a href="whoscoming.php">Completed RSVPs</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
		<h1 align="center"> RSVP </h1><br><br>
                <p>The RSVP cutoff date is Saturday, September 10th. Please ensure you have completed your information before then!</p>
		<p>Please enter the invite code you recieved inside your invitation.</p>
		<div>
			Invite code: <input type="text" name="inviteCode" id="inviteCode"><br><div id="inviteErrors"> </div><br>
			<input type="button" name="loadInvite" id="loadInvite" value="Load invitation data"> <input type="button" id="clear" value="Clear data" hidden>
		</div>

		<div id="inviteData" hidden>
			<h2> Invitees </h1><br>
			<p>Please indicate whether or not you will attend, as well as any other information we should know (dietary requirements, etc).</p>
			<table class="table">
				<thead>
					<td>Name</td>
					<td>Attending</td>
					<td>Notes</td>
				</thead>
				<tbody id="invitees" >
				</tbody>
			</table><br>
			Do you require hotel rooms? <input type="checkbox" name=requiresHotel id=requiresHotel><br><br>
			<span id="numRoomsTxt">How many hotel rooms do you require? <input type="text" name="numRooms" id="numRooms"><br><br>
                        <p>Please see the home page for information about how to book your hotel room.</p></span>
			You may bring <span id="plusOnesText">0</span> additional guests. Please indicate the names of the guests you will be bringing (if any), as well as any other information we should know (dietary requirements, etc).<br><br>
			<table class="table" id="guestTable">
				<thead>
					<td>Guest Name</td>
					<td>Notes</td>
					<td></td>
				</thead>
				<tbody id="plusOnes" >
				</tbody>
			</table>
			<br><br>
			<input type="button" id="submitInvite" value="Submit">
		</div>
		<div id="postErrors"></div>
	</div>
	
	
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="scripts/rsvp.js"></script>
	</body>
</html>