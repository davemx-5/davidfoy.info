<!DOCTYPE html>
<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>CV</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
                <script>
                $(function () {
                        $('nav li ul').hide().removeClass('fallback');
                        $('nav li').hover(function () {
                                $('ul', this).stop().slideToggle(200);
                        });
                });
                </script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
	</head>
	<body>

		 <!--Header--> 
			<header id="header">
				<h1><a href="../index.html">David Foy</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.php">Home</a></li>
                                                <li><a href="cv.html">CV</a></li>
                                                <li><a href="elements.html">Elements</a></li>
                                                <li><a href="submitted_code/index.php">Projects</a>
                                                    <ul class="fallback">
                                                        <li><a href="../submitted_code/index.php">Metasearch</a><li>
                                                        <li><a href="#">VMware Virtualization</a></li>
                                                    </ul>
                                                </li><!--<li><a href="elements.html">Metasearch</a></li>-->
                                                <li><a href="#" class="button special">Sign Up</a></li>
					</ul>
				</nav>
			</header>

<section id="main" class="wrapper">
<div class="container">
<!--search form original metasearch-->
<div id="Form" align="center">
<form method="POST" action=""> 
  <p>
  <br/> 
	  <input name="query" type="text" size="60" maxlength="60" value="" placeholder="Enter your query here..." required />	
  </p>
	<p>
	  <label for="Format">View:</label>
                <select name="Format" id="Format">
                    <option value="aggregation">Aggregated</option>
                    <option value="non-aggregation">Non-Aggregated</option>
                </select>
          <label for="MaxResults">MaxResults:</label>
                <select name="MaxResults" id="MaxResults">
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
	</p>
	<p>
	  <input name="bt_search" type="submit" value="Search" /> 
    </p>
	<p><a href="database.php">Please write a review...</a></p>
	<p><a href="tests.php">Testing</a></p>
</form> 
</div>
<!--search form original metasearch-->
<div id="results">
<?php
include "search.php";
function main() 
{
	error_reporting(E_ERROR);
    // take in the parameters
	$query = urlencode("'{$_POST['query']}'");  
	$MaxResults = intval($_POST['MaxResults']);
	$method = $_POST['Format'];
	$normalisedArray = search( $query, $MaxResults, $method );
	if($method == "aggregation")
	{
		echoStartHtmlTableAggregated();									   
		echoResultsAsTableRowsAggregated( $normalisedArray , $MaxResults);
		echoEndHtmlTableAggregated();
	}
	else if($method == "non-aggregation")
	{
		echoStartHtmlTableNON();									   
		echoResultsAsTableRowsNON( $normalisedArray , $MaxResults);
		echoEndHtmlTableNON();
	}
	unset($normalisedArray);
}

if(isset($_POST['bt_search']))
{
	main();
}

?>
    </section>
</div>		
<!--search form original metasearch-->
<h2></h2>
<!-- Footer -->
        <footer id="footer">
                <div class="container">
                        <section class="links">
                                <div class="row">
                                        <section class="3u 6u(medium) 12u$(small)">
                                                <h3>Lorem ipsum dolor</h3>
                                                <ul class="unstyled">
                                                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                                                        <li><a href="#">Nesciunt itaque, alias possimus</a></li>
                                                        <li><a href="#">Optio rerum beatae autem</a></li>
                                                        <li><a href="#">Nostrum nemo dolorum facilis</a></li>
                                                        <li><a href="#">Quo fugit dolor totam</a></li>
                                                </ul>
                                        </section>
                                        <section class="3u 6u$(medium) 12u$(small)">
                                                <h3>Culpa quia, nesciunt</h3>
                                                <ul class="unstyled">
                                                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                                                        <li><a href="#">Reiciendis dicta laboriosam enim</a></li>
                                                        <li><a href="#">Corporis, non aut rerum</a></li>
                                                        <li><a href="#">Laboriosam nulla voluptas, harum</a></li>
                                                        <li><a href="#">Facere eligendi, inventore dolor</a></li>
                                                </ul>
                                        </section>
                                        <section class="3u 6u(medium) 12u$(small)">
                                                <h3>Neque, dolore, facere</h3>
                                                <ul class="unstyled">
                                                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                                                        <li><a href="#">Distinctio, inventore quidem nesciunt</a></li>
                                                        <li><a href="#">Explicabo inventore itaque autem</a></li>
                                                        <li><a href="#">Aperiam harum, sint quibusdam</a></li>
                                                        <li><a href="#">Labore excepturi assumenda</a></li>
                                                </ul>
                                        </section>
                                        <section class="3u$ 6u$(medium) 12u$(small)">
                                                <h3>Illum, tempori, saepe</h3>
                                                <ul class="unstyled">
                                                        <li><a href="#">Lorem ipsum dolor sit</a></li>
                                                        <li><a href="#">Recusandae, culpa necessita nam</a></li>
                                                        <li><a href="#">Cupiditate, debitis adipisci blandi</a></li>
                                                        <li><a href="#">Tempore nam, enim quia</a></li>
                                                        <li><a href="#">Explicabo molestiae dolor labore</a></li>
                                                </ul>
                                        </section>
                                </div>
                        </section>
                        <div class="row">
                                <div class="8u 12u$(medium)">
                                        <ul class="copyright">
                                                <li>&copy; Untitled. All rights reserved.</li>
                                                <li>Design: <a href="http://templated.co">TEMPLATED</a></li>
                                                <li>Images: <a href="http://unsplash.com">Unsplash</a></li>
                                        </ul>
                                </div>
                                <div class="4u$ 12u$(medium)">
                                        <ul class="icons">
                                                <li>
                                                        <a class="icon rounded fa-facebook" href="https://www.facebook.com/daithi.ofeich/"><span class="label">Facebook</span></a>
                                                </li>
                                                <li>
                                                        <a class="icon rounded fa-twitter"><span class="label">Twitter</span></a>
                                                </li>
                                                <li>
                                                        <a class="icon rounded fa-google-plus" href="https://plus.google.com/u/0/110622391014889410985/posts"><span class="label">Google+</span></a>
                                                </li>
                                                <li>
                                                        <a class="icon rounded fa-linkedin" href="https://ie.linkedin.com/pub/david-foy/28/325/89a"><span class="label">LinkedIn</span></a>
                                                </li>
                                        </ul>
                                </div>
                        </div>
                </div>
        </footer>
</body> 
</html> 
