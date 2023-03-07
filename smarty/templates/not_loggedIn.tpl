<!DOCTYPE HTML>
<html>

<head>
	<title>Anmelden</title>
	<meta charset="utf-8">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
		integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link href="css/not_loggedIn.css" rel="stylesheet" type="text/css">
</head>

<body>

	<div class="container alertcontainer">
		{if !isset($errors) &&!isset($messages)}
			<div class="alert alert-hidden">leer</div>
		{/if}

		{if (isset($errors))}
			{foreach item=error from=$errors}
				{if ($error != false)}
					<div class="alert alert-secondary">{$error}</div>
				{/if}
			{/foreach}
		{/if}
		{if (isset($messages))}
			{foreach item=message from=$messages}
				<div class="alert alert-secondary">{$message}</div>
			{/foreach}
		{/if}
	</div>

	<div class="container logincontainer">
		<div class="row">
			<div class="col-md-5 mx-auto">
				<div id="first">
					<div class="myform form ">
						<div class="logo mb-3">
							<div class="col-md-12 text-center">
								<h1>Anmelden</h1>
							</div>
						</div>
						<form action="index.php" method="post" name="login">
							<input type="hidden" name="csrfToken" value="{$csrfToken}" />
							<div class="form-group">
								<label>Email Addresse</label>
								<input type="email" name="email" class="form-control" id="email"
									aria-describedby="emailHelp" placeholder="Eingabe Email" required>
							</div>
							<div class="form-group">
								<label>Passwort</label>
								<input type="password" name="password" id="password" class="form-control"
									aria-describedby="passwordHelp" placeholder="Eingabe Passwort" required>
							</div>
							<div class="col-md-12 text-center ">
								<button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm"
									name="login">Login</button>
							</div>
							<div class="col-md-12 ">
								<div class="login-or">
									<hr class="hr-or">
									<span class="span-or">oder</span>
								</div>
							</div>
							<div class="form-group">
								<p class="text-center">Noch kein Konto? <a href="#" id="signup">Hier registrieren</a>
								</p>
							</div>
						</form>

					</div>
				</div>
				<div id="second">
					<div class="myform form ">
						<div class="logo mb-3">
							<div class="col-md-12 text-center">
								<h1>Registrieren</h1>
							</div>
						</div>
						<form action="#" name="registration">
							<input type="hidden" name="csrfToken" value="{$csrfToken}" />
							<div class="form-group">
								<label>Benutzername</label>
								<input type="text" name="username" class="form-control" id="username"
									aria-describedby="usernameHelp" placeholder="Eingabe Benutzername" required>
							</div>
							<div class="form-group">
								<label>Email Addresse</label>
								<input type="email" name="email" class="form-control" id="email"
									aria-describedby="emailHelp" placeholder="Eingabe Email" required>
							</div>
							<div class="form-group">
								<label>Passwort</label>
								<input type="password" name="password" id="password1" class="form-control"
									aria-describedby="passwordHelp" placeholder="Einagbe Passwort" required>
							</div>
							<div class="form-group">
								<label>Passwort wiederholen</label>
								<input type="password" name="password_repeat" id="password2" class="form-control"
									aria-describedby="passwordHelp" placeholder="Einagbe Passwort" required>
							</div>
							<div class="col-md-12 text-center mb-3">
								<button type="submit" class=" btn btn-block mybtn btn-primary tx-tfm"
									name="register">Registrieren</button>
							</div>
							<div class="col-md-12 ">
								<div class="form-group">
									<p class="text-center"><a href="#" id="signin">Du hast bereits ein Konto?</a></p>
								</div>
							</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>


	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="js/not_loggedIn.js"></script>


</body>




</html>