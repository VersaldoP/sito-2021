<?php
		$session = true;
    
		if( session_status() === PHP_SESSION_DISABLED  )
			$session = false;
		elseif( session_status() !== PHP_SESSION_ACTIVE )
		{
			session_start();
		}
		
if(isset($_REQUEST['id'])){
	$qty=$_REQUEST['qta'];
	$id=$_REQUEST['id'];
	
	$con = mysqli_connect("localhost", "uStrong", "SuperPippo!!!", "pizzasporto");                
	if (mysqli_connect_errno()) 
		echo "<p class='error'>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
	else
	{    
			$query ="UPDATE  pizze AS p SET p.qty = ? WHERE p.id= ?;"  ; 
			$stmt = mysqli_prepare($con, $query);
			mysqli_stmt_bind_param( $stmt, "ii",$qty,$id);
			$result = mysqli_stmt_execute($stmt);
			if(isset($result)){
				
			}
			else{
				echo"<p> Errore nella query</p>";
			}

    }
} 
elseif (isset($_REQUEST['submitProdotto'])){
	$name=$_REQUEST['nome'];
	$con = mysqli_connect("localhost", "uStrong", "SuperPippo!!!", "pizzasporto");                
	if (mysqli_connect_errno()) 
		echo "<p class='error'>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
	else
	{      
			$res=$_SESSION['idmax'];
			$tipo=$_REQUEST['tipo'];
			
			$prez=$_REQUEST['prezzo']*100;

			if($_REQUEST['tipo']=='NULL'){
				$query ="INSERT INTO pizze (pizze.id,pizze.ingredienti,pizze.nome,pizze.prezzo,pizze.qty) VALUES (?,?,?,?,?)"  ; 
				$stmt = mysqli_prepare($con, $query);
				mysqli_stmt_bind_param( $stmt, "issii",$res,$_REQUEST['ingredienti'],$_REQUEST['nome'],$prez,$_REQUEST['quantita']);}
			else{
			$tipo=$_REQUEST['tipo'];
			$query ="INSERT INTO pizze (pizze.id,pizze.ingredienti,pizze.nome,pizze.tipo,pizze.prezzo,pizze.qty) VALUES (?,?,?,?,?,?)"  ; 
			
			$stmt = mysqli_prepare($con, $query);
			mysqli_stmt_bind_param( $stmt, "isssii",$res,$_REQUEST['ingredienti'],$_REQUEST['nome'],$tipo,$prez,$_REQUEST['quantita']);
			}
			$result = mysqli_stmt_execute($stmt);
			if(isset($result)){
			
				$GLOBALS['Prodotto Aggiunto']=true;
			}
			else{
				echo"<p> Errore nella query</p>";
			}
			
    }
	
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
	<script>
		"use strict";
		function validaNuovoProdotto(nome,ingr,tipo,prezzo,qta) {
			var errorCampiMancanti = false;
			var errorCampiErrati = false;
			var campiMancanti="Non hai inserito i seguenti campi:\n";
			var campiErrati="I seguenti campi sono errati:\n"
			var regexpQta = /^\d+$/;
			var regexpPrezzo = /^(\d)+(\.(\d){2})$/;

			if(nome=="") {
				campiMancanti += "Nome\n";
				errorCampiMancanti = true;
			}

			if(ingr=="") {
				campiMancanti += "Ingredienti\n";
				errorCampiMancanti = true;
			}
			
			if(prezzo=="") {
				campiMancanti += "Costo Unitario\n";
				errorCampiMancanti = true;
			}
			
			if(qta=="") {
				campiMancanti += "Quantità";
				errorCampiMancanti = true;
			}

			if(errorCampiMancanti)  {
				window.alert(errorCampiMancanti);
				return false;
			}
			
			if(!regexpQta.test(qta)) {
				campiErrati += "Quantità\n";
				errorCampiErrati = true;
			}

			if(!regexpPrezzo.test(prezzo)) {
				campiErrati += "Costo unitario\n";
				errorCampiErrati = true;
			}

			if(errorCampiErrati) {
				window.alert(campiErrati);
				return false;
			}
			
			return true;
		}

		function validazione(qta) {
			var regexpQta = /^\d+$/;
			if(qta=="") {
				window.alert("Non è stata inserita nessuna quantità nella casella di testo!");
				return false;
			}
			if(!regexpQta.test(qta)) {
				window.alert("La quantità inserita non rispetta il formato corretto. Inserire un numero intero!");
				return false;
			}
			return true;
		}
	</script>

       

  	<div class="thecontent">
      
	  <?php

			if($GLOBALS['Prodotto Aggiunto']){
				echo"<p>Nuova pizza inserita Corretamente</p>";
			}
	 
		  echo"<h2 >Aggiorna la quantit&agrave; disponibile</h2>";
		  $con = mysqli_connect("localhost", "uWeak", "posso_leggere?", "pizzasporto"); 

		  if (mysqli_connect_errno()) 
			  echo "<p class='error'>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
		  else
		  {
					 
			$query ="SELECT pizze.id,pizze.nome,pizze.prezzo,pizze.qty FROM pizze";
			$stmt = mysqli_prepare($con, $query);
			$result = mysqli_stmt_execute($stmt);
			mysqli_stmt_bind_result($stmt,$id,$nome,$prezzo,$qty);
			
			
			echo "<table>";
			
			
			$maxid=1;
				
				echo "<th class='pizze'>Nome</th><th class='pizze'>Prezzo</th><th class='pizze'>Quantity</th><th class='pizze'>Aggiorna quantita*</th></tr><tbody>";
				while(mysqli_stmt_fetch($stmt)){
					$prezzo_float = $prezzo/100;
				echo "<tr><form name='f$id' action='#' method='POST' onsubmit='return validazione(qta.value)'><td class='pizze'>$nome</td><td class='pizze'>".number_format($prezzo_float,2,",","")."&euro;</td><td class='pizze'>$qty</td><td class='pizze'><input  type='text' name='qta'><input  type='submit' value='Aggiorna prodotto'><input type='hidden' name='id' value=$id></td></form></tr>";
				$maxid++;
			}
			$_SESSION['idmax']=$maxid;
			
			}
		
			
		   echo "</tbody></table>";
		   echo "<h2>Aggiungi un nuovo prodotto</h2>";
		   echo"<form name='fb1' action='esitoCambia.php' method='POST' onSubmit=' return validaNuovoProdotto(nome.value,ingredienti.value,tipo.value,prezzo.value,quantita.value);'>
		   <table><tbody>
			   <tr><td>Nome: </td><td><input required type='text' name='nome' size=30></td></tr>
			   <tr><td>Ingredienti: </td><td><textarea required name='ingredienti'></textarea></td></tr>
			   <tr><td>Tipo: </td><td><input type='radio' name='tipo' value='Vegan'>Vegan<input type='radio' name='tipo' value='Veggy'>Veggy<input type='radio' name='tipo' value='NULL' checked>NULL</td></tr>
			   <tr><td>Costo unitario:* </td><td><input required type='text' name='prezzo' size=30> (&euro;)</td></tr>
			   <tr><td>Quantit&agrave; disponibile:** </td><td><input required type='text' name='quantita' size=30></td></tr>
			   <tr><td colspan=2><input type='submit'  value='Aggiungi prodotto'> <input type='reset' value='Cancella'><input type='hidden' name='submitProdotto' value=1></td></tr>
		   </tbody></table>
	   </form>";
	   echo "<p>* Il campo \"Costo unitario\" richiede un prezzo in euro, quindi un numero decimale (parte intera e decimale separate da punto).</p>
	   <p>** Il campo \"Quantit&agrave; disponibile\" richiede un numero intero.</p>";




	  
	 
	 
	 
	 ?>
  	
    </div>
	<?php 
		include("footer.php");
	?>
    </main>
  </body>
</html>