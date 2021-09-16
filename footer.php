<?php
	echo "<div class='thefooter'>
        <p>Autore: Pietro Versaldo</p>
        <address>e-mail:    <a href='mailto:s264590@studenti.polito.it'>s264590@studenti.polito.it</a></address>
        
		<p>Nome file:".basename($_SERVER['PHP_SELF'])."</p>"; //.basename($_SERVER['PHP_SELF'],'.php'); con basename tolgo il .php
    echo "</div>";
?>