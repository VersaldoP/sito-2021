<?php 

	
	echo "<!doctype html>
			<html lang='it'>
				<head>
					<meta charset='utf-8'/>
					<link rel='stylesheet' type='text/css' href='stile.css'>
					<title>Pizzeria la Bun - PWR</title>
					<meta name='author' content='Pietro Versaldo'>
					<meta name='keywords' content='html'>
					<meta name='keywords' content='Progettazzione di servizi web e reti di calcolatori'>
					<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=1'>
				</head>	
				  <body>
					<main class='grid-container'>
				<div class='theheader'>
					<h1>Pizzeria che Bun</h1>
				</div>
				
				<div class='thenavigation'>
					  <h2>Men&ugrave;</h2>

					  <ul>
						<li><a href=' home.php '>Home</a></li>";
						if($_SESSION['logged']){
							echo"<li><a>Registra</a></li>";
						  }
						  else
							  echo "<li><a href='registra.php'>Registra</a></li>";
						if(!$_SESSION['gestore']){
							echo"<li><a>Cambia</a></li>";
						  }
						  else
							  echo "<li><a href='cambia.php'>Cambia</a></li>";
						
						echo"<li><a href='info.php'>Info</a></li>
						<li><a href='ordina.php'>Ordina</a></li>";
							if($_SESSION['logged']){
								echo "<li class='log'>Login</li>";
								echo "<li><a href='logout.php'>Logout</a></li></ul>";				
							}else{
								echo "<li><a href='login.php'>Login</a></li>";
								echo "<li class='log'>Logout</li></ul>";
							}
						
echo "</div>";							
					 /*Metto anche il menu che è uguale per tutti ma non il riassunto perche nella pagina riepilogo viene chiamato dopo*/
?>