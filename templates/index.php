<!doctype html>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/stylesheets/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
	<link href="/stylesheets/styles.css" rel="stylesheet" type="text/css" />
	<link href="/stylesheets/main.css" rel="stylesheet" type="text/css" />
	<title>Cat Search | enjoy cat pics</title>

</head>
<body id="backimage">
	<div class="container">
		<div class="hd-color">
			<div class="page-header">
				<img src="/images/neco_logo.svg" width="261" height="254" alt="logo" />
				<h1>Cat Search <small>enjoy cat pics!!</small></h1>
				<form class="navbar-form" role="search" id="form">
					<div class="form-group">
						<input type="text" id="search" class="form-control" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">Submit</button>
				</form>
			</div>
		</div>

		<?php
		$i = 0;
		foreach ($photos as $key => $photo) {
			$i++;
			if( $i % 4  == 1 ) { ?>
			<div class="row">
				<?php
			}
			?>
			<div class="col-xs col-md-3">
				<a href="<?php echo $photo["url"];?>" target="_blank"><img class="img-responsive photo" src="<?php echo $photo["data"]->url;?>" alt="" width="<?php echo $photo["data"]->width;?>" height="<?php echo $photo["data"]->height;?>"></a>
			</div>

			<?php
			if($i % 4 == 0) { ?>
		</div>
		<?php
	}

}?>
</div>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script src="/javascripts/location.js"></script>
<script src="/javascripts/geo.js"></script>
</body>
</html>
