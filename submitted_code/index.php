<!DOCTYPE html>
<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Metasearch</title>
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
                <script src="../js/jquery-1.11.3.min.js"></script>
                <script type="text/javascript">
                $(window).load(function() {
                        $(".loader").fadeOut("slow");
                })
                </script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-66586428-1', 'auto');
  ga('send', 'pageview');

</script>                
                <noscript>
                <link rel="stylesheet" href="../css/skel.css" />
                <link rel="stylesheet" href="../css/style3.css" />
                <link rel="stylesheet" href="../css/style-xlarge.css" />
                </noscript>
	</head>
	<body>
<div class="loader"></div>
 <!--Header--> 
        <header id="header">
                <h1><a href="../index.php">David Foy</a></h1>
                <nav id="nav">
                        <ul>
                                <li><a href="../index.php">Home</a></li>
                                <li><a href="../cv.html">CV</a></li>
                                <!--<li><a href="elements.html">Elements</a></li>-->
                                <li>Projects
                                    <ul class="fallback">
                                        <li><a href="index.php">Metasearch</a><li>
                                        <li><a href="../viz.html">VMware Virtualization</a></li>
                                        <li><a href="../law.html">Online Anonymity</a></li>
                                        <li><a href="../systems.html">Windows and Linux Systems</a><li>
                                    </ul>
                                </li><!--<li><a href="elements.html">Metasearch</a></li>-->
                                <!--<li><a href="#" class="button special">Sign Up</a></li>-->
                        </ul>
                </nav>
        </header>

<section id="main" class="wrapper">
<div class="container">
<!--search form original metasearch-->
<div id="Form" align="center">
    <h1>Metasearch</h1>
<form action="index.php" method="post" >
  <p>
  <br/> 
	  <input name="query" type="text" maxlength="60" value="" placeholder="Enter your query here..." required />	
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
	<!--<p><a href="database.php">Please write a review...</a></p>
	<p><a href="tests.php">Testing</a></p>-->
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
                                                <h3>Projects</h3>
                                                <ul class="unstyled">
                                                        <li><a href="index.php">Metasearch Engine</a></li>
                                                        <li><a href="../viz.html">Virtualization, VmWare vSphere ESXI vCenter</a></li>
                                                        <li><a href="../systems.html">Systems Managagement, Windows Server 2008/2003, Linux Debian, Active Directory</a></li>
                                                        <li><a href="../law.html">IT Law, Pseudonymous Internet Users</a></li>
                                                </ul>
                                        </section>
                                        <section class="3u 6u$(medium) 12u$(small)">
                                                <h3>&nbsp;</h3>
                                                <ul class="unstyled">
                                                        <li><a href="#">&nbsp;</a></li>
                                                        <li><a href="#">&nbsp;</a></li>
                                                        <li><a href="#">&nbsp;</a></li>
                                                        <li><a href="#">&nbsp;</a></li>
                                                        <li><a href="#">&nbsp;</a></li>
                                                </ul>-->
                                        </section>
                                        <section class="3u 6u(medium) 12u$(small)">
                                                <h3>Contact Details</h3>
                                                <ul class="unstyled">
                                                    <li>Phone: <a href="tel:+447542975981">+44 (0) 75 429 75981</a></li>
                                                    <li>Email: <a href="mailto:davidfoy@ymail.com?Subject=davidfoy.info" target="_top">davidfoy@ymail.com</a></li>
                                                    <li><a href="https://ie.linkedin.com/in/david-foy-89a32528">Linkedin</a></li>
                                                    <li><a href="#">&nbsp;</a></li>
                                                    <li><a href="#">&nbsp;</a></li>
                                                </ul>-->
                                        </section>
                                        <section class="3u$ 6u$(medium) 12u$(small)">
                                                <h3>Location</h3>
                                                <ul class="unstyled">
                                                     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2480.6650176256458!2d-0.1414375847025614!3d51.55604126496721!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48761b006ec6bd17%3A0x50f884cbb56ce448!2sFortess+Rd%2C+London+NW5+2HR!5e0!3m2!1sen!2suk!4v1459644316549" width="300" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>
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
