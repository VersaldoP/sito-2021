<?php
		$session = true;
    
		if( session_status() === PHP_SESSION_DISABLED  )
			$session = false;
		elseif( session_status() !== PHP_SESSION_ACTIVE )
		{
			session_start();
		}
		$_SESSION['pagamento']=false;
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
			$logged=false;
		}else{
			$logged=true;
			echo "<p>Utente:".$_SESSION['nick']."<br>Saldo:".number_format($_SESSION['money'],2,",","")." &euro;</p>";
		}
	?>
	
	</div>
       

  	<div class="thecontent">
     
	  
		<?php
		if($logged){
			echo "<h2 class='sottotitolo'>Effettua la tua ordinazione</h2><p>Scegli le pizze da ordinare, seleziona la quantit&agrave; e clicca su Procedi.</p><form name='f' action='Conferma.php' method='POST'><table class='elenco'><tr><th >Nome</th><th >Prezzo</th><th >Quantit&agrave;</th></tr><tbody>";
		 $con = mysqli_connect("localhost", "uWeak", "posso_leggere?", "pizzasporto"); 

		 if (mysqli_connect_errno()) 
			 echo "<p class='error'>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
		 else
		 {
					
		   $query ="SELECT pizze.id,pizze.nome,pizze.prezzo,pizze.qty FROM pizze WHERE pizze.qty>0";
		   $stmt = mysqli_prepare($con, $query);
		   $result = mysqli_stmt_execute($stmt);
		   mysqli_stmt_bind_result($stmt,$id,$nome,$prezzo,$qty);
		     
			   while(mysqli_stmt_fetch($stmt)){
				   $prezzo_float = $prezzo/100;
			 
			   echo"<tr><td class='pizze'>$nome</td><td class='pizze'>".number_format($prezzo_float,2,",","")."&euro;</td><td class='pizze'> <select name='quantita$id'>";
			    $d=$qty;
			
			   for($q=0; $q<=$d;$q++){
				   
				echo"<option label=$q value=$q>$q</option>";
					
			   }
			   echo"</select></td></tr>";
			  
		
		   }
		  
		   
		   }
	   
		   
		  echo "</tbody><tr><td colspan=3 id='pulsantiSubmitReset'><input type='submit' value='Procedi'> <input type='reset' value='Annulla'></td></tr></table></form>";
		}
		else{
			echo "<p class='errore'>Attenzione! Questa pagina è accessibile soltanto previa autenticazione</p>";
		}
		?>
  	
    </div>
	<?php 
		include("footer.php");
	?>
    </main>
  </body>
</html>