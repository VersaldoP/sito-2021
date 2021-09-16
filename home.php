<?php
	
		
		$session = true;
    
		if( session_status() === PHP_SESSION_DISABLED  )
			$session = false;
		elseif( session_status() !== PHP_SESSION_ACTIVE )
		{
			session_start();
		}
		
	include("header.php");
?>	

	<div class="riassunto">
	<?php
	$con = mysqli_connect("localhost", "uWeak", "posso_leggere?", "pizzasporto");          
	if (mysqli_connect_errno()) 
		echo "<p>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
	else
	{   $query = "SELECT  credito,indirizzo FROM utenti WHERE username=?";
		$stmt = mysqli_prepare($con, $query);
		if($stmt){
			$nick=$_SESSION['nick'];
			mysqli_stmt_bind_param($stmt, "s",$nick);
			$result = mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$saldo,$indirizzo);
			mysqli_stmt_fetch($stmt);
												
			mysqli_stmt_close($stmt);
			$_SESSION['money']=$saldo/100;
			$_SESSION['indirizzo']=$indirizzo;
			
			

			
			
			}
	}
	mysqli_close($con);
	
		if(!isset($_SESSION['logged'])){
			echo "<p>Utente: ANONIMO<br>Saldo: 0,00 &euro;</p>";
		}else{
			echo "<p>Utente:".$_SESSION['nick']."<br>Saldo:".number_format($_SESSION['money'],2,",","")." &euro;</p>";
		}
		
			?>
	
	</div>
       

  	<div class="thecontent">
    
		
      <p>
		Benvenuto. Da questo sito &egrave; possibile ordinare scegliere e ordinare Pizze.<br>Se non ti sei ancora autenticato puoi farlo dal men&ugrave; sotto la voce Login
      </p>
  	
    </div>
	<?php 
		include("footer.php");
	?>
    </main>
  </body>
</html>