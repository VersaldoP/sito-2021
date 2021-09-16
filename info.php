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
     
		<?php 
	  $con = mysqli_connect("localhost", "uWeak", "posso_leggere?", "pizzasporto"); 

	  if (mysqli_connect_errno()) 
		  echo "<p class='error'>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
	  else
	  {
		  	   
		$query ="SELECT * FROM pizze WHERE pizze.qty>0";
		$stmt = mysqli_prepare($con, $query);
		$result = mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt,$id,$ingredienti,$nome,$tipo,$prezzo,$qty);
		
		
		echo "<table >";
		$maxid=1;
		
		if(isset($_SESSION['logged'])){
			
			echo "<th>Nome</th><th >Ingredienti</th><th >Prezzo</th><th >Tipo</th><th >Quantity</th></tr><tbody>";
			while(mysqli_stmt_fetch($stmt)){
				$prezzo_float = $prezzo/100;
			echo "<tr><td >$nome</td><td >$ingredienti</td><td >".number_format($prezzo_float,2,",","")."&euro;</td><td >$tipo</td><td >$qty</td></tr>";
			$maxid++;
			}
		}else{

			echo "<tr><th>Nome</th><th>Ingredienti</th><th >Prezzo</th><th >Tipo</th></tr><tbody>";
			while(mysqli_stmt_fetch($stmt)){
				$prezzo_float = $prezzo/100;
			echo "<tr><td class='pizze'>$nome</td><td class='pizze'>$ingredienti</td><td class='pizze'>".number_format($prezzo_float,2,",","")."&euro;</td><td class='pizze'>$tipo</td></tr>";
				$maxid++;
			}
			
		}
		$_SESSION['idmax']=$maxid;
	}
		
	   echo "</tbody></table>";
	  


	 ?>
  	
    </div>
	
	<?php 
		include("footer.php");
	?>
     </main>
    </body>
  </html>