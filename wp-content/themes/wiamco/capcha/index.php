<!DOCTYPE html>
<?php session_start()?>
<html lang="en">
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<a class="navbar-brand" href="https://sourcecodester.com">Sourcecodester</a>
		</div>
	</nav>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h3 class="text-primary">PHP - Simple Captcha Generator</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<form action="" method="POST">
			<img src="captcha.php" />
			<br />
			<br />
			<input type="text" name="captcha" />
			<?php
				if(ISSET($_POST['verify'])){
					if(!empty($_POST['captcha'])){
						if($_SESSION['captcha'] == $_POST['captcha']){
							echo "<label class='text-success'>Validated</label>";
						}else{
							echo "<label class='text-danger'>Invalid captcha!</label>";
						}
					}else{
						echo "<label class='text-warning'>Please fill up the required field!</label>";
					}
				}
			?>
			<br /><br />
			<button name="verify" class="btn btn-primary">Verify</button>
			
		</form>
	</div>
</body>
</html>