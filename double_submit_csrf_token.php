<?php
//start the session
session_start();
//check for existing session
if (!$_SESSION["logedIn"]) {
        header('Location: login.php');
        exit();
    } else {
    echo ' <div class="container">  
                <div class="alert alert-success">
                    <b> Welcome Kalani! </b> <a href="signout.php">Sign out</a> 
                </div>
            </div>';
	}
	
//check form validations
if (isset($_POST['double_sumbit_csrf_token']) && isset($_POST['account_number']) && isset($_POST['name']) && isset($_POST['amount'])) {
    //check validity of the token
    if (validateToken($_POST['double_sumbit_csrf_token'])) {
        echo '<div class="container">  
                <div class="alert alert-success">
                    Transaction successfully!!
	    		</div>
    		</div>';
		
    } else {
      echo '<div class="container">  
                <div class="alert alert-danger alert-dismissible fade in">
		    		Invalid CSRF Token!!
	    		</div>
    		</div>';
    }
}

//validating whether the retrieved token is same as the cookie token
function validateToken($token){
    return urldecode($token) ==$_COOKIE['csrf_token'];
}

?>
<!DOCTYPE html>
<html>

<head>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<style type="text/css">
	 body {
     
        background-image:url("ch3.jpeg");
    	  }
	</style> 
</head>

<body>
	<div class="container">
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title"> Fund Transfer</div>
			</div>
			<div style="padding-top:30px" class="panel-body">

				<div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
				<form id="changeForm" class="form-horizontal" role="form" method="post" action="double_submit_csrf_token.php">
					<div style="margin-bottom: 25px" class="form-group">
						<label class="col-md-4 control-label" for="textinput">Account Number</label>
						<div class="col-md-4">
							<input type="number" class="form-control" name="account_number" placeholder="15XXXXXXXXXX" required>
						</div>
					</div>
					<div style="margin-bottom: 25px" class="form-group">
						<label class="col-md-4 control-label" for="textinput">Name</label>
						<div class="col-md-4">
							<input type="text" class="form-control" name="name" placeholder="" required>
						</div>
					</div>
					<div style="margin-bottom: 25px" class="form-group">
						<label class="col-md-4 control-label" for="textinput">Amount</label>
						<div class="col-md-4">
							<input type="number" class="form-control" name="amount" placeholder="00.00" required>
							<!-- hidden field -->
							<input type="hidden" class="form-control" id="double_sumbit_csrf_token" name="double_sumbit_csrf_token">
						</div>
					</div>
					<div style="margin-top:10px" class="form-group">
						<div class="col-md-4">
						</div>
						<div class="col-sm-4 controls">
							<button id="btn-bd" class="btn btn-lg btn-primary btn-block btn-signin" value="update" type="submit">Transfer Credit</button>
						</div>
					</div>
					<span id="message"></span>
				</form>
			</div>
		</div>
	</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
	$(document).ready(function() {
		$.ajax({
			url: 'csrf_token.php',
			type: 'post',
			async: false,
			data: {
				//pass login session to validate request with the server
				'csrf_request': '<?php echo $_SESSION["logedIn"] ?>'
			},
			success: function(data) {
				console.log(data); //success message
				//set cookie value to hidden field value in the form
				document.getElementById('double_sumbit_csrf_token').value = getCSRFCookieValue('csrf_token');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				console.log("Error on Ajax call :: " + xhr.responseText); //fail message
			}
		});
	});

	function getCSRFCookieValue(token_name) {
		//get csrf cookie value from cookie
		var cookieValue = document.cookie.match('(^|;)\\s*' + token_name + '\\s*=\\s*([^;]+)');
		if (cookieValue) {
			return cookieValue.pop();
		} else {
			return '';
		}
	}
</script>

</html>