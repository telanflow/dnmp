<!DOCTYPE html>
<html>

<head>
	<title>DNMP</title>
	<style type="text/css">
		html {
			font-family: sans-serif;
			-ms-text-size-adjust: 100%;
			-webkit-text-size-adjust: 100%
		}

		.mine {
			font-size: 30px;
			margin-top: 200px;
			color: #333;
		}

		.desc {
			text-align: center;
			color: #aaa;
			margin-bottom: 50px;
			line-height: 30px;
		}
		.subtitle{
			color: #aaa;
			font-size: 20px;
		}

		footer {
			text-align: center;
		}

		footer a {
			color: #fff;
			background: #F95445;
			display: block;
			width: 180px;
			margin: 0 auto;
			text-decoration: none;
			line-height: 40px;
			height: 40px;
			border-radius: 3px;
		}
	</style>
</head>

<body>

	<p align="center" class="mine">
	<span>DNMP</span>
	<span class="subtitle">v1.4</span>
	</p>

	<div class="desc" align="center">
		<div style="color:#333;"><?= date_default_timezone_get() . "&nbsp;/&nbsp;" . date("Y-m-d H:i:s"); ?></div>
		<div>PHP Version: <?php echo PHP_VERSION; ?></div>
	</div>

	<footer>
		<a href="https://github.com/telanflow/dnmp" target="_blank">Get Documentation</a>

		<p style="color:#ccc;font-size:12px;margin-top:100px;">
			&copy; <?php echo date("Y") ?>&nbsp;telan.me
		</p>
	</footer>

</body>

</html>