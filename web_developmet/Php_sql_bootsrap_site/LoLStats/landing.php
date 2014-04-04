<html>
<head>
	<!--<link rel="stylesheet" type="text/css" href="loginstyle.css">
	<script src="jquery.validate.js"></script>-->
	<script src="jquery.js"></script>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/starter-template.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">
	<meta charset="UTF-8">
	<title>LoL-DB : Landing</title>
</head>
<body>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="#">League of Legends Match Tracker</a>
		</div>
		<div class="collapse navbar-collapse">
		  <ul class="nav navbar-nav">
            <li><a href="#">Home</a></li>
            <li><a href="#">LoL Blog</a></li>
            <li class="active"><a href="landing.php">Stat Tracker</a></li>
            <li><a href="#t">Sign In</a></li>
            <li><a href="#">Create Account</a></li>
            <li><a href="#">About</a></li>
          </ul>
		</div><!--/.nav-collapse -->
	</div>
</div>
<!-- end of navigation bar -->    
<br>
<br>
<div class="container" style="text-align: center"> <!-- Instructions -->
	<h1>Select An Item to Enter or View Stats</h1>
	<br>
	<br>
	<br>
</div> <!-- ends instructions -->

<div class="container" style="text-align: center">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		<h2 class="dropdown"><!-- dropdown -->
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Custom Stats <span class="caret"></span>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<li><a tabindex="-1" href="custom.php">Filter Custom</a></li>
				</ul><!-- ends dropdown -->
		</h2>
		</div>
	</div>
</div>

<div class="container" style="text-align: center">
<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"
		<h2 class="dropdown"> <!-- created dropdown menu -->
		<a href="#" class="dropdown-toggle" data-toggle="dropdown">Matches <span class="caret"></span>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
				<li><a tabindex="-1" href='viewmatches.php'>View Matches</a></li>
				<li><a tabindex="-1" href='addmatch.php'>Add Match</a></li>
			</ul>  <!-- ends dropdown menu -->
		</h2>
	</div><!--ends column-->
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"
		<h2 class="dropdown"> <!-- players dropdown menu -->
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Player <span class="caret"></span>
				<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
					<li><a tabindex="-1" href='viewplayers.php'>View People</a></li>
					<li><a tabindex="-1" href='addperson.php'>Add Person</a></li>
				</ul>
		</h2> <!-- ends dropdown -->
	</div><!--ends column-->
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"
		<h2 class="dropdown"><!-- teams dropdown -->
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Teams <span class="caret"></span>
			<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
				<li><a tabindex="-1" href='viewteams.php'>View Teams</a></li>
				<li><a tabindex="-1" href='addteam.php'>Add Team</a></li>
	
		</h2> <!-- ends teams dropdown -->
	</div><!--ends column-->

</div><!--ends row-->
</div><!--ends container-->
<div class='container' style='text-align:center'>
	
	
	<script src="bootstrap.min.js"></script>
</div>

<!-- footer container -->
      <section class="container">
        <footer class="row">
          <nav class="col-lg-12"> <!-- start of breadcrumb navigation -->
            <ul class="breadcrumb">
              <li><a href=""> </a></li>
              <li><a href=""> </a></li>
              <li><a href=""> </a></li>
            </ul>
          </nav>
        </footer> <!-- end footer -->
      </section><!-- close footer section -->

</body>
</html>