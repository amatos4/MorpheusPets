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

    <link rel="stylesheet" href="base.css">

    <!--[if lte IE 8]>
    <link rel="stylesheet" type="text/css" href="static/css/ie.css" />
    <![endif]-->

    <script src="static/js/lib/modernizr.js"></script>

    <title>My MorpheusPets Profile</title>
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

       <section class="profile-badge">
           <img src="images/avatar_blank.png"/>
           <article class="description">
                <h1>@John_Smith</h1>
                <p>I am considered one of the very best players in the entire game. I am out to create the best team of MorpheusPets! Battle against me and see if you have what it takes.</p>
           </article>
        </section>

        <section class="pet-container">
            <h1>My Pet Collection</h1>
            <ul>
                <li class="pet-badge">
                    <a href="#"><img src="images/bird.jpg" /></a>
                    <div class="pet-stats" />
                        <h1>Parakeet</h1>
                        <p><b>Species: </b>Charmander</p>
                        <p><b>Type: </b> Fire</p>
                        <p><b>Active: </b>Yes</p>
                    </div>
                </li>
                <li class="pet-badge">
                    <img src="images/city.jpg" />
                    <div class="pet-stats" />
                        <h1>Big City</h1>
                        <p>Species: Squirtle</p>
                        <p>Type: Water</p>
                    </div>
                </li>
                <li class="pet-badge">
                    <img src="images/frog.jpg" />
                    <div class="pet-stats" />
                        <h1>Frog Junior</h1>
                        <p>Species: Frog</p>
                        <p>Type: Amphibian</p>
                    </div>
                </li>
                <li class="pet-badge">
                    <img src="images/frog.jpg" />
                    <div class="pet-stats" />
                        <h1>Frog Senior</h1>
                        <p>Mean, Lean, and Green.</p>
                    </div>
                </li>
                <li class="pet-badge">
                    <img src="images/bird.jpg" />
                    <div class="pet-stats" />
                        <h1>Bird</h1>
                        <p>He's a big bird and he does not live on Sesame Street.</p>
                    </div>
                </li>
                <li class="pet-badge">
                    <img src="images/city.jpg" />
                    <div class="pet-stats" />
                        <h1>Little City</h1>
                        <p>Little City Still Pretty Big Dreams.</p>
                    </div>
                </li>
            </ul>
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