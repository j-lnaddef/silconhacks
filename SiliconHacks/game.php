<?php
		$servername = "db680777377.db.1and1.com";
		$username = "dbo680777377";
		$password = "siliconhacks";
		$dbname = "db680777377";

		// Create connection
		mysql_connect($servername, $username, $password);
		@mysql_select_db($dbname) or die ("Problème à la connexion");

		$id = $_GET["id"];
		
		$query = "SELECT * FROM `match` WHERE `time` = '" . $id . "'";
				
		$result = mysql_query($query);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>SiliconHacks May 6-7 2017</title>
	</head>

	<body>
		<h1 style="text-align:center;">Do we match?</h1>

		<canvas id ="game_canvas" style="border:1px solid black; margin:auto; display: block;" width="680" height="680"> </canvas> 
		<script type="text/javascript">
			var c = document.getElementById("game_canvas");
			var canvas = c.getContext("2d");

			var CANVAS_WIDTH = c.offsetWidth;
			var CANVAS_HEIGHT = c.offsetHeight; 

			var imgPingouin = new Image();
			imgPingouin.src = "images/door_penguin.png";
			var imgGiraffe = new Image();
			imgGiraffe.src = "images/door_giraffe.png";
			var imgLion = new Image();
			imgLion.src = "images/door_lion.png";
			var imgBaseball = new Image();
			imgBaseball.src = "images/door_baseball.png";
			var imgBasket = new Image();
			imgBasket.src = "images/door_basket.png";
			var imgSoccer = new Image();
			imgSoccer.src = "images/door_soccer.png";
			var imgSki = new Image();
			imgSki.src = "images/door_ski.png";
			var imgHiking = new Image();
			imgHiking.src = "images/door_hiking.png";
			var imgDiving = new Image();
			imgDiving.src = "images/door_diving.png";
			var imgJaeger = new Image();
			imgJaeger.src = "images/door_jaeger.png";
			var imgVodka = new Image();
			imgVodka.src = "images/door_vodka.png";
			var imgRhum = new Image();
			imgRhum.src = "images/door_rhum.png";
			var imgGot = new Image();
			imgGot.src = "images/door_got.png";
			var imgFriends = new Image();
			imgFriends.src = "images/door_friends.png";
			var imgMalcolm = new Image();
			imgMalcolm.src = "images/door_malcolm.png";
			

			var enPingouin = new Image();
			enPingouin.src = "images/penguin.png";
			var enGiraffe = new Image();
			enGiraffe.src = "images/giraffe.png";
			var enLion = new Image();
			enLion.src = "images/lion.png";
			var enBaseball = new Image();
			enBaseball.src = "images/baseball.png";
			var enBasket = new Image();
			enBasket.src = "images/basket.png";
			var enSoccer = new Image();
			enSoccer.src = "images/soccer.png";
			var enSki = new Image();
			enSki.src = "images/ski.png";
			var enHiking = new Image();
			enHiking.src = "images/hiking.png";
			var enDiving = new Image();
			enDiving.src = "images/diving.png";
			var enJaeger = new Image();
			enJaeger.src = "images/jaeger.png";
			var enVodka = new Image();
			enVodka.src = "images/vodka.png";
			var enRhum = new Image();
			enRhum.src = "images/Rhum.png";
			var enGot = new Image();
			enGot.src = "images/got.png";
			var enFriends = new Image();
			enFriends.src = "images/friends.png";
			var enMalcolm = new Image();
			enMalcolm.src = "images/malcolm.png";

			var background_1 = new Image();
			background_1.src = <?php $pref_url_1 = mysql_result($result, 0, "pref_url_1"); echo "\"$pref_url_1\""; ?>;
			var background_2 = new Image();
			background_2.src = <?php $pref_url_2 = mysql_result($result, 0, "pref_url_2"); echo "\"$pref_url_2\""; ?>;
			var background_3 = new Image();
			background_3.src = <?php $pref_url_3 = mysql_result($result, 0, "pref_url_3"); echo "\"$pref_url_3\""; ?>;
			var background_4 = new Image();
			background_4.src = <?php $pref_url_4 = mysql_result($result, 0, "pref_url_4"); echo "\"$pref_url_4\""; ?>;
			var background_5 = new Image();
			background_5.src = <?php $pref_url_5 = mysql_result($result, 0, "pref_url_5"); echo "\"$pref_url_5\""; ?>;

			var heroImage = new Image();
			heroImage.src = <?php $profile_url = mysql_result($result, 0, "profile_url"); echo "\"$profile_url\""; ?>;

			var myImage = new Image();
			myImage.src = "my_avatar.jpeg";

			var imgExit = new Image();
			imgExit.src = "images/exit.jpeg";

			var StatesEnum = Object.freeze({STOPPED: {}, RUNNING: {}, FINISHED: {}});
			
			var state = StatesEnum.STOPPED;

			Number.prototype.clamp = function(min, max) {
				return Math.min(Math.max(this, min), max);
			};

			function collides(a, b) {
				return a.x < b.x + b.width &&
					a.x + a.width > b.x &&
					a.y < b.y + b.height &&
					a.y + a.height > b.y;
			}

			var enemyImg;

			var hero = { 
				width: 80,
				height: 80,
				x: (CANVAS_WIDTH - 80) / 2,
				y: CANVAS_HEIGHT - 80,
									
				update: function() {
					if (39 in keysDown) {
						this.x += 1.5;
						walls.forEach(function(wall) {
							if (collides(hero, wall))
								hero.x = wall.x - hero.width;
						});
					}
					if (37 in keysDown) {
						this.x -= 1.5;
						walls.forEach(function(wall) {
							if (collides(hero, wall))
								hero.x = wall.x + wall.width;
						});
					}
					if (38 in keysDown) {
						this.y -= 1.5;
						walls.forEach(function(wall) {
							if (collides(hero, wall))
								hero.y = wall.y + wall.height;
						});
					}
					if (40 in keysDown) {
						this.y += 1.5;
						walls.forEach(function(wall) {
							if (collides(hero, wall))
								hero.y = wall.y - hero.height;
						});
					}
									
					if (32 in keysDown) {
						var i = fireBalls.length;
						if (i == 0 || fireBalls[i - 1].y < hero.y - 120) {
							hero.shoot();
						}
					}
					this.x = this.x.clamp(0, CANVAS_WIDTH - this.width);
					this.y = this.y.clamp(0, CANVAS_HEIGHT - this.height);
				}, 
				shoot: function() {
					var fireBallPosition = this.midpoint();
					fireBalls.push(FireBall({
						x: fireBallPosition.x,
						y: fireBallPosition.y
					}));
				},
				midpoint: function() {
					return {
						x: this.x + this.width/2 - 10,
						y: this.y - 50
					};
				},
				draw: function() {
					 //canvas.fillStyle = "#00A";
					 //canvas.fillRect(this.x, this.y, this.width, this.height);
					 //var heroImage = new Image();
					 //heroImage.src = 
					 <?php #$profile_url = mysql_result($result, 0, "profile_url"); echo "\"$profile_url\""; ?>
					 canvas.drawImage(heroImage, this.x, this.y, this.width, this.height);
				},
				init: function() {
					this.x = CANVAS_WIDTH / 2 - this.width / 2;
					this.y = CANVAS_HEIGHT - this.height;
				}
			}

			var fireBalls = [];

			function FireBall(I) {
				I.active = true;
				I.width = 40;
				I.height = 40;

				I.draw = function() {
					var imageFireBall = new Image();
					imageFireBall.src = "images/flame.png";
					canvas.drawImage(imageFireBall, this.x, this.y, this.width, this.height);
				}

				I.update = function() {
					I.y -= 4 * delta * 60;
					I.active = I.active && I.inBounds();
				}
								
				I.inBounds = function() {
					return I.x >= 0 && I.x <= CANVAS_WIDTH && I.y + I.height >= 0 && I.y <= CANVAS_HEIGHT;
				}
				return I;
			}

			var doors = [];

			function Door(I) {
				I.width = 80;
				I.height = 120;
				I.active = true;

				I.draw = function() {
					canvas.drawImage(this.image, this.x, this.y, this.width, this.height);
				}
				return I;
			}

			var walls = [];

			function Wall(I) {
				I.width = 80;
				I.height = 80;
				I.active = true;

				I.draw = function() {
					var imageWall = new Image();
					if (this.breakable == false)
						imageWall.src = "images/Wall.png";
					else
						imageWall.src = "images/Wall_b.png";
					canvas.drawImage(imageWall, this.x, this.y, this.width, this.height);
				}
				return I;
			}

			var stormTroopers = [];

			function StormTrooper(I) {
				I.active = true;
				I.width = 50;
				I.height = 50;
				
				I.draw = function() {
					canvas.drawImage(enemyImg, this.x, this.y, this.width, this.height);
				}

				I.update = function() {
					var x_dist = hero.x - I.x;
					var y_dist = hero.y - I.y;
					var alpha = Math.sqrt(1/((x_dist * x_dist) + (y_dist * y_dist)));
					
					I.x += x_dist * alpha * delta * 100;
					I.y += y_dist * alpha * delta * 100;
					
					I.active = I.active;
				}
				
				return I;
			}

			var startTime;

			function showMenuScreen() {
				canvas.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
				canvas.fillStyle = "#d3d3d3";
				canvas.fillRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
				canvas.fillStyle = "#000";
				canvas.font = '25pt Calibri';
				canvas.fillText("Press ENTER to start the game", 120, CANVAS_HEIGHT / 2);
			}

			function initWall(_x, _y, _breakable) {
				walls.push(Wall({
					x: _x,
					y: _y,
					breakable: _breakable
				}));
			}

			function initializeGame()
			{
				nextLevel = 1;
				initializeLevel(nextLevel);
			}

			function initializeLevel(level_id) {
				stormTroopers = [];
				enemyPopping = false;
				hero.init();
				keysDown = [];
				walls = [];
				fireBalls = [];
				doors = [];

				switch (level_id)
				{
					case 1:
						doors.push(Door({
							x: 150,
							y: 0,
							correct: true,
							image: imgPingouin,
							enemyImage: enPingouin
						}));
						doors.push(Door({
							x: 300,
							y: 0,
							correct: false,
							image: imgGiraffe,
							enemyImage: enGiraffe
						}));
						doors.push(Door({
							x: 450,
							y: 0,
							correct: false,
							image: imgLion,
							enemyImage: enLion
						}));
					break;
					case 2:
						doors.push(Door({
							x: 150,
							y: 0,
							correct: false,
							image: imgSoccer,
							enemyImage: enSoccer
						}));
						doors.push(Door({
							x: 300,
							y: 0,
							correct: true,
							image: imgBaseball,
							enemyImage: enBaseball
						}));
						doors.push(Door({
							x: 450,
							y: 0,
							correct: false,
							image: imgBasket,
							enemyImage: enBasket
						}));
					break;
					case 3:
						doors.push(Door({
							x: 150,
							y: 0,
							correct: true,
							image: imgSki,
							enemyImage: enSki
						}));
						doors.push(Door({
							x: 300,
							y: 0,
							correct: false,
							image: imgDiving,
							enemyImage: enDiving
						}));
						doors.push(Door({
							x: 450,
							y: 0,
							correct: false,
							image: imgHiking,
							enemyImage: enHiking
						}));
					break;
					case 4:
						doors.push(Door({
							x: 150,
							y: 0,
							correct: false,
							image: imgMalcolm,
							enemyImage: enMalcolm
						}));
						doors.push(Door({
							x: 300,
							y: 0,
							correct: false,
							image: imgFriends,
							enemyImage: enFriends
						}));
						doors.push(Door({
							x: 450,
							y: 0,
							correct: true,
							image: imgGot,
							enemyImage: enGot
						}));
					break;
					case 5:
						doors.push(Door({
							x: 150,
							y: 0,
							correct: false,
							image: imgJaeger,
							enemyImage: enJaeger
						}));
						doors.push(Door({
							x: 300,
							y: 0,
							correct: false,
							image: imgVodka,
							enemyImage: enVodka
						}));
						doors.push(Door({
							x: 450,
							y: 0,
							correct: true,
							image: imgRhum,
							enemyImage: enRhum
						}));
					break;
				}

				initWall(160, 600, false);
				initWall(440, 600, false);
				initWall(160, 520, false);
				initWall(440, 520, false);
				initWall(160, 440, false);
				initWall(440, 440, false);
				initWall(160, 360, false);
				initWall(440, 360, false);
				initWall(80, 360, false);
				initWall(520, 360, false);
				initWall(0, 360, false);
				initWall(600, 360, false);
				initWall(258, 360, true);
				initWall(342, 360, true);
				initWall(0, 280, false);
				initWall(600, 280, false);
				initWall(0, 200, false);
				initWall(600, 200, false);
				initWall(0, 120, false);
				initWall(600, 120, false);
				initWall(0, 40, false);
				initWall(600, 40, false);
				initWall(0, -40, false);
				initWall(600, -40, false);
				initWall(80, 38, false);
				initWall(520, 38, false);
				initWall(80, -40, false);
				initWall(520, -40, false);
				initWall(160, 38, false);
				initWall(440, 38, false);
				initWall(160, -40, false);
				initWall(460, -40, false);
				initWall(240, 38, false);
				initWall(380, 38, false);
				initWall(240, -40, false);
				initWall(380, -40, false);

				
			}

			var enemyPopping = false;

			function initializeWrongLevel(enemyImage) {
				enemyPopping = true;
				enemyImg = enemyImage;
				hero.init();
				keysDown = [];
				walls = [];
				fireBalls = [];
				doors = [];
				nextLevel--;
				doors.push(Door({
					x: 300,
					y: 0,
					correct: true,
					image: imgExit,
					enemyImage: enMalcolm
				}));
			}

			function drawBackground()
			{
				
				switch (nextLevel)
				{
					case 1:
						canvas.drawImage(background_1, 0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
					break;
					case 2:
						canvas.drawImage(background_2, 0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
					break;
					case 3:
						canvas.drawImage(background_3, 0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
					break;
					case 4:
						canvas.drawImage(background_4, 0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
					break;
					case 5:
						canvas.drawImage(background_5, 0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
					break;
				}
			}

			// Screen update.
			function draw() {
				switch (state) {
					case StatesEnum.RUNNING :
						canvas.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
						drawBackground();
						hero.draw();
						fireBalls.forEach(function(fireBall) {
							fireBall.draw();
						});
						walls.forEach(function(wall) {
							wall.draw();
						});
						doors.forEach(function(door) {
							door.draw();
						});
						stormTroopers.forEach(function(stormTrooper) {
							stormTrooper.draw();
						});
						break;
					case StatesEnum.STOPPED :
						showMenuScreen();
						break;
					case StatesEnum.FINISHED :
						showMatchScreen();
						break;
				}
			}

			function showMatchScreen()
			{
				canvas.clearRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
				canvas.fillStyle = "#d3d3d3";
				canvas.fillRect(0, 0, CANVAS_WIDTH, CANVAS_HEIGHT);
				canvas.fillStyle = "#000";
				canvas.font = '35pt Calibri';
				canvas.fillText("It's a Match !", 250, 200);
				canvas.drawImage(heroImage, 120, 300, 200, 200);
				canvas.drawImage(myImage, 400, 300, 200, 200);
			}

			// Apparition des storm troopers
			function createStormTrooper() {
				if(Math.random() < 0.03 * delta * 60) {
					stormTroopers.push(StormTrooper( {
						x : Math.random() * (CANVAS_WIDTH - 25),
						y : 0
					}));
				}
			}

			// Objects update.
			function update() {
				switch (state) {
					case StatesEnum.RUNNING:
						setDelta();
						hero.update();
						fireBalls.forEach(function(fireBall) {
							fireBall.update();
						});
						stormTroopers.forEach(function(stormTrooper) {
							stormTrooper.update();
						});
						handleCollisions();
						if (enemyPopping)
						{
							createStormTrooper();
						}
						fireBalls = fireBalls.filter(function(fireBall) {
							return fireBall.active;
						});
						walls = walls.filter(function(wall) {
							return wall.active;
						});
						stormTroopers = stormTroopers.filter(function(stormTrooper) {
							return stormTrooper.active;
						});
						break;
					case StatesEnum.STOPPED :
						if (13 in keysDown) {
							initializeGame();
							state = StatesEnum.RUNNING;
						}
						break;
					case StatesEnum.FINISHED :
						if (13 in keysDown) {
							initializeGame();
							state = StatesEnum.RUNNING;
						}
				}
			}

			function handleCollisions() {
				for (var i = 0; i < fireBalls.length; i++) {
					for (var j = 0; j < stormTroopers.length; j++)
					{
						if (collides(fireBalls[i], stormTroopers[j])) {
							fireBalls[i].active = false;
							stormTroopers[j].active = false;
						}
					}
					for (var j = 0; j < walls.length; j++) {
						if (collides(fireBalls[i], walls[j])) {
							fireBalls[i].active = false;
							if (walls[j].breakable)
								walls[j].active = false;
						}
					}
					for (var j = 0; j < doors.length; j++)
					{
						if (collides(fireBalls[i], doors[j])) {
							fireBalls[i].active = false;
						}
					}
				}

				for (var j = 0; j < doors.length; j++)
				{
					if (collides(hero, doors[j]) && Math.abs(hero.x - doors[j].x) < 20) {
						if (doors[j].correct == true)
						{
							if (nextLevel == 5)
							{
								state = StatesEnum.FINISHED;
							}
							else
							{
								nextLevel++;
								initializeLevel(nextLevel);
							}
						}
						else
						{
							initializeWrongLevel(doors[j].enemyImage);
						}
					}
				}
							
				for (var i = 0; i < stormTroopers.length; i++) {
					if (collides(hero, stormTroopers[i])) {
						state = StatesEnum.STOPPED;
					}
				}
			}

			// Getting user input
			var keysDown = {};
						
			document.addEventListener("keydown", function (e) {
				keysDown[e.keyCode] = true;
			}, false);

			document.addEventListener("keyup", function (e) {
             	delete keysDown[e.keyCode];
			}, false);


			var FPS = 60;
			
			delta = 0;
			then = 0; 
			
			function setDelta() {
				var now = Date.now();
				delta = (now - then) /1000;
				then = now;
			}

			var animatedFrame = requestAnimationFrame(frame);

			function frame() {
				update();
				draw();
				requestAnimationFrame(frame);
			}

			frame();

		</script>
	</body>
</html> 