<!DOCTYPE html>
<!--[if IE 7]><html class="ie ie7" lang="en"><![endif]-->
<!--[if IE 8]><html class="ie ie8" lang="en"><![endif]-->
<!--[if IE 9]><html class="ie ie9" lang="en"><![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="author" content="Title">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <link rel="stylesheet" href="battle.css">
    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="static/css/ie.css" />
    <![endif]-->

    <script src="static/js/lib/modernizr.js"></script>

    <title>Battle!</title>
</head>

<body>

    <nav>
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="#">My Profile</a></li>
            <input id="search-bar" name="search" type="text" placeholder="Search...">
            <input id="search-button" name="search_submit" type="submit" value="Go">
            <li class="logout"><a href="#">Logout</a></li>
        </ul>
    </nav>

    <div id="container">
		
		<section class="enemy-info">
			<h1>Enemy Team</h1>
			<ul class="enemy_team">
				<li class="enemy_petimg"><img src="images/dariushead.png" width="50" height="50" />Darius</li>
				<li class="enemy_petimg"><img src="images/arcanine.png" width="50" height="50" />Arcanine</li>
				<li class="enemy_petimg"><img src="images/poliwhirl.png" width="50" height="50" />Poliwhirl</li>
			</ul>
			<ul class="enemy_stat">
				<li><h2>Enemy Battler: Nega_Scoot</h2></li>
				<li><h2>Enemy Pet: Darius</h2></li>
				<li class="enemy_petimg"><h2>Enemy Health:</h2> <img src="images/healthbar.png" /></li>
			</ul>
		</section>
		
		<section class="battlefield">
			<img src="images/pika.png" width="350" height="350" style="position: absolute; top: 70px; left: 300px;" />
			<img src="images/darigan.gif" width="350" height="350" style="position: relative; top: 70px; left: 200px;" />
			<img src="images/field.png" style="position: relative; top: 0; left: 0; z-index: -1;" />
		</section>
		
		<p class="game_alert"><strong>Critical</strong> Hit for <strong>200</strong> damage!!</p>
		
		<section class="player_stats">
			<ul>
				<li><h2>Pet: Pikachoo</h2></li>
				<li><h2>Health:</h2> <img src="images/healthbar2.png" /></li>
				<li><h2>Experience</h2> <img src="images/experience.png" /></li>
			</ul>
		</section>
		
		<section class="player_actions">
			<table>
				<tr>
					<td><div class="btn">Attack</div></td>
					<td><div class="btn">Magic Attack</div></td>
					<td><div class="btn">Defend</div></td>
				</tr>
				<tr>
					<td><h2>Switch Pet:</h2></td>
					<td><img src="images/pikachu.png" /></td>
					<td><img src="images/bulba.png" height="50" width="50" /></td>
					<td><img src="images/char.png" /></td>
				</tr>
			</table>
		</section>
	
	</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        window.jQuery || document.write('<script src="static/js/lib/jquery.js"><\/script>')
    </script>
    <script src="static/js/plugins.js"></script>
    <script src="static/js/base.js"></script>

</body>

</html>