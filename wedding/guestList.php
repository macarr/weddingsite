<?php
	session_start();
	if($_SESSION["login"] == true) {
?>
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
            <li><a href="rsvp.php">RSVP</a></li>
            <li><a href="registry.html">Registry</a></li>
            <li><a href="admin.php">Admin</a></li>
            <li class="active"><a href="#">Guest List</a></li>
            <li><a href="whoscoming.php">Completed RSVPs</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
    	<h1> Guest List! </h1>

    	<table class="table">
    		<thead>
    			<td>Invite code</td>
    			<td>Invitees</td>
    			<td>Guests</td>
    		</thead>
    		<tbody>
<?php
	include("includes/db.php");
	//get all invites;
	$result = $mysqli->query("SELECT INVITE_CODE, INVITE_ID, PLUS_ONES from INVITES");
	while($row = $result->fetch_assoc()) {
		echo "<tr><td>" . $row["INVITE_CODE"] . "</td><td>";
		//get all invitees for invite
		if(!($stmt2 = $mysqli->prepare("SELECT INVITEE_NAME from INVITEES where INVITE_ID = ?"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}

		if (!$stmt2->bind_param("s", $row["INVITE_ID"])) {
			echo "Binding parameters failed: (" . $stmt2->errno . ") " . $stmt2->error;
		}

		if(!$stmt2->execute()) {
			echo "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error;
		}
		$stmt2->bind_result($name);
		while($stmt2->fetch()) {
			echo $name . ", ";
		}
		$stmt2->close();
		if(!($stmt2 = $mysqli->prepare("SELECT COUNT(*) from PLUS_ONES where INVITE_ID = ?"))) {
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}

		if (!$stmt2->bind_param("s", $row["INVITE_ID"])) {
			echo "Binding parameters failed: (" . $stmt2->errno . ") " . $stmt2->error;
		}
		if(!$stmt2->execute()) {
			echo "Execute failed: (" . $stmt2->errno . ") " . $stmt2->error;
		}
		$stmt2->bind_result($count);
		$stmt2->fetch();
		echo "</td><td>".$count."/".$row["PLUS_ONES"]."</tr>";
		$stmt2->close();
	}
?>
			</tbody>
		</table>
	</div>

<?php
	} else {
?>
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
            <li><a href="#contact">Registry</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
	    <div class="row">
	        <div class="col-md-offset-5 col-md-3">
	            <div class="form-login">
	            <h4>Login to access Admin functions.</h4>
		            <form id="loginForm" action="includes/logon.php" method="post">
		            <input type="text" id="userName" class="form-control input-sm chat-input" placeholder="username" />
		            </br>
		            <input name="password" type="text" id="password" class="form-control input-sm chat-input" placeholder="password" />
		            </br>
			            <div class="wrapper">
				            <span class="group-btn">     
				                <a class="btn btn-primary btn-md" onclick="document.getElementById('loginForm').submit();">login <i class="fa fa-sign-in"></i></a>
				            </span>
			            </div>
		        	</form>
	        	</div>
	        </div>
	    </div>
	</div>
	<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <script src="scripts/admin.js"></script>
	</body>	
<?php
	}
?>