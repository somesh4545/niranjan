<?php
include '../../db.php';
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<!-- Favicon -->
	<link rel="shortcut icon" href="/images/logo.png" type="image/png" />
	<title>Niranjan</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
	<!-- ======== Swiper Js ======= -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.7.5/swiper-bundle.min.css" />

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.8/css/boxicons.min.css' rel='stylesheet'>

	<!-- MATERIAL DESIGN ICONIC FONT -->
	<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
	<!-- Nav style -->
	<link rel="stylesheet" href="../../styles.css">
	<!-- STYLE CSS -->
	<link rel="stylesheet" href="css/style.css">

	<!-- snackbar -->
	<link rel="stylesheet" href="../../css/snackbar.css">
</head>

<body>

	<!--Nav bar -->
	<?php
	include "../../components/nav.php"
	?>
	<!-- Nav bar end -->

	<div class="authwrapper" style="background-image: url('images/bg-registration-form-2.jpg');">
		<div class="inner">
			<form action="" onsubmit="signin(event)">
				<h3>Login Form</h3>

				<div class="form-wrapper">
					<label for="">Email</label>
					<input type="email" id="email" value="" class="form-control" required>
				</div>
				<div class="form-wrapper">
					<div class="form-group">
						<label for="">Password</label>
						<!-- <a href="//auth/SignUp/" style="text-decoration:underline">Forgot?</a> -->
					</div>
					<input type="password" id="password" value="" class="form-control" required>
				</div>

				<!-- <div class="checkbox">
                        <label>
                            <input type="checkbox"> .
                            <span class="checkmark"></span>
                        </label>
                    </div> -->
				<button class="login-btn">Login</button>
				<h4 style="text-align:center; padding:10px;">New to Niranjan?<a href="../SignUp/" style="text-decoration:underline"> Create account</a></h4>
			</form>
		</div>
	</div>
	<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-auth.js"></script>
	<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>

	<script>
		// Your web app's Firebase configuration
		// For Firebase JS SDK v7.20.0 and later, measurementId is optional
		const firebaseConfig = {
			apiKey: "AIzaSyAKAyCEpD1kK0PXLh8vyi-Rjqqu4pnCuC8",
			authDomain: "niranjan-ed345.firebaseapp.com",
			projectId: "niranjan-ed345",
			storageBucket: "niranjan-ed345.appspot.com",
			messagingSenderId: "736749189078",
			appId: "1:736749189078:web:9ad94a2f5ca34039689677",
			measurementId: "G-3W4168D1LB"
		};

		// Initialize Firebase
		firebase.initializeApp(firebaseConfig)
	</script>
	<script src="./main.js"></script>
</body>

</html>