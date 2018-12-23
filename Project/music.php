<!-- The main source for all pages -->
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

$conn = mysqli_connect($servername, $username, $password, $dbname);

$connError=mysqli_connect_error();
if (!is_null($connError)) {
    die("Connection failed: " . $connError);
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$name=mysqli_real_escape_string($conn,$_POST["name"]);
	$email=mysqli_real_escape_string($conn,$_POST["email"]);
	$passwordOf=mysqli_real_escape_string($conn,$_POST["password"]);
	$sql=0;
	if($name!=""){
		$sql = "INSERT INTO accounts(Name,Email,Password) VALUES ('$name','$email','$passwordOf')";
		if ($conn->query($sql) === TRUE) {
		} else {
		    die("Error: " . $sql . "<br>" . $conn->error);
		}
	}
	else{
		$sql = "SELECT * FROM accounts where Email like '$email' and Password like '$passwordOf'";
		$result=mysqli_query($conn,$sql);
		$count =mysqli_num_rows($result);
	      		
	    if($count > 0) {
	    	$row=mysqli_fetch_assoc($result);
	        $_SESSION['user'] = $row["Name"]; 
	    }else {
	         $error = "Your Login Name or Password is invalid";
	    }
	}
}



?> 
<html>
<!-- the main html source for all pages -->
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1" charset="utf-8">
	<!-- style css -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.5.0/css/all.css' integrity='sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU' crossorigin='anonymous'>
	<!-- script js -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
	<style type="text/css">
		body{
			background-image: url("images/zhan.jpg");
			background-repeat: repeat;
			background-size: 100%;
			background-attachment: scroll;
		}
		.vl-right{
			border-right: 1px solid #dee2e6;
		}
		#footer{
			position:fixed;
			bottom:0;
			color: #2b63f5;
		}
		#session{
			color:#007bf5;
		}
		.button,#footerMid,#footerRight{
			display: block;
		}
		#invisible{
			display: none;
		}
		@media (max-width: 650px){
			#content,#logo,.button,#footerMid,#footerRight{
				display: none;
			}
			#invisible{
				display: block;
			}
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function () {
			init();
			function init(){
				var current = 0;
				var audio = $('#audio');
				var playlist = $('#playlist');
				var tracks = playlist.find('li a');
				var len = tracks.length - 1;
				audio[0].volume = .10;
				audio[0].play();
				playlist.on('click','a', function(e){
					e.preventDefault();
					link = $(this);
					current = link.parent().index();
					run(link, audio[0]);
				});
				audio[0].addEventListener('ended',function(e){
					current++;
					if(current == len){
						current = 0;
						link = playlist.find('a')[0];
					}else{
						link = playlist.find('a')[current];    
					}
					run($(link),audio[0]);
				});
			}
			function run(link, player){
					player.src = link.attr('href');
					par = link.parent();
					par.addClass('active').siblings().removeClass('active');
					player.load();
					player.play();
			}
		});
	</script>
	<title>Music</title>
</head>
<body>
	<header> <!-- header -->
		<nav class="navbar navbar-expand bg-dark sticky-top">
			<ul class="navbar-nav" id="logo">
				<a href="music.php" class="nav-link">
					<img src="images/music-logo.png" width="100">
				</a>
			</ul>
			<ul class="navbar-nav" id="invisible">
				<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" id="logoHref">
					<img src="images/music-logo.png" width="100">
				</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="zhan.php" target="">
						Zhan Zhaksylyk
					</a>
					<a class="dropdown-item" href="alisher.php" target="">
						Alisher Zhumabissov
					</a>
					<a class="dropdown-item" href="nurzhan.php" target="">
						Nurzhan Sabit
					</a>
					<a href="music.php" class="dropdown-item">Music</a>
					<button type="button" class="dropdown-item btn btn-primary" data-toggle="modal" data-target="#myModal">

						<span class="fas fa-user-plus" style="color: red; font-size: 1.5em;"></span>
			            sign up
					</button>
					<button type="button" class="dropdown-item btn btn-primary" data-toggle="modal" data-target="#myModal1">
						<span class="fas fa-user-lock" style="color: red; font-size: 1.5em;"></span>
			            log in
					</button>
				</div>
			</ul>
			<ul class="navbar-nav nav-tabs" id="content">
				<li class="nav-item">
					<a class="nav-link" href="index.php" target="">Home</a>
				</li>
				
				<li class="nav-item">
					<a class="nav-link" href="about.php" target="">About</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" target="">
						Who?
					</a>
					<div class="dropdown-menu">
						<a class="dropdown-item" href="zhan.php" target="">
							Zhan Zhaksylyk
						</a>
						<a class="dropdown-item" href="alisher.php" target="">
							Alisher Zhumabissov
						</a>
						<a class="dropdown-item" href="nurzhan.php" target="">
							Nurzhan Sabit
						</a>
					</div>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto" id="User">
				<li class="nav-item">
					<h1 id="session">
					<?php
					if (isset($_SESSION['user']) && !is_null($_SESSION['user'])) {
						echo $_SESSION['user'];
					}
					?>
					</h1>
				</li>
			</ul>
			<ul class="navbar-nav ml-auto" id="signing">
				<li class="nav-item">
					<button type="button" class="btn btn-primary button" data-toggle="modal" data-target="#myModal">

						<span class="fas fa-user-plus" style="color: red; font-size: 1.5em;"></span>
			            sign up
					</button>

					<div class="modal" id="myModal">
						<div class="modal-dialog">
							<div class="modal-content">

								<div class="modal-header">
									<h4 class="modal-title">Registration</h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>

								<div class="modal-body">
									<form method="post" action="">
										<input type="text" name="name" placeholder="Name">
										<input type="text" name="email" placeholder="email">
										<input type="password" name="password" placeholder="password">
										<input type="submit" name="button">
									</form>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				</li>
				<li class="nav-item pl-3">
					<button type="button" class="btn btn-primary button" data-toggle="modal" data-target="#myModal1">
						<span class="fas fa-user-lock" style="color: red; font-size: 1.5em;"></span>
			            log in
					</button>
					<div class="modal" id="myModal1">
						<div class="modal-dialog">
							<div class="modal-content">

								<div class="modal-header">
									<h4 class="modal-title">Logging in</h4>
									<button type="button" class="close" data-dismiss="modal">&times;</button>
								</div>

								<div class="modal-body">
									<form method="post" action="">
										<input type="hidden" name="name" value="">
										<input type="text" name="email" placeholder="email">
										<input type="password" name="password" placeholder="password">
										<input type="submit" name="button">
									</form>
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
				</li>				
			</ul>
		</nav>
	</header>
	<div class="d-inline-flex mt-3 w-100"><!-- main content -->
		<div class="col-3 vl-right"><!-- left aside -->
			<audio id="audio" autoplay="TRUE" tabindex="0" controls="" >
				<source src="music/FisherOfMen.mp3">
			</audio> 
		</div>
		<div class="col-6 text-center vl-right"><!-- middle part -->
			<img src="images/music.gif" class="w-100">
		</div>
		<div class="col-3" ><!-- right aside -->
			<ul id="playlist">
				<li class="active">
					<a href="music/FisherOfMen.mp3">Fisher Of Men</a>
				</li>
				<li>
					<a href="music/Oogway'sAscends.mp3">Oogway's Ascends</a>
				</li>
				<li>
					<a href="music/TheArrivalOfKai.mp3">The arrival of Kai</a>
				</li>
				<li>
					<a href="music/ManOfSteel.mp3">Man of Steel</a>
				</li>
				<li>
					<a href="music/TheEnd.mp3">The End</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="jumborton bg-dark row col-12 m-0" id="footer"><!-- unchangeable footer-->
		<div class="col">
			<h3>Contacts:</h3>
			<ul type="none">
				<li>Zhan 170107105@stu.sdu.edu.kz</li>
				<li>Nurzhan 170107162@stu.sdu.edu.kz</li>
				<li>Alisher 170107077@stu.sdu.edu.kz</li>
			</ul>
		</div>
		<div class="col text-center" id="footerMid">
			<p>The site has been created for personal purposes</p>
		</div>
		<div class="col">
			<ul type="none" id="footerRight">
				<li>SDU</li>
				<li>Kaskelen</li>
				<li>Kazakhstan</li>
				<li>2018</li>
			</ul>
		</div>
	</div>
</body>
</html>