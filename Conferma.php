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
<script>
		"use strict";
		function validaForm(indirizzo,orario,oraAttualeNascosta,oraMinimaNascosta) {
			// Controllo indirizzo
			var err=false;
			var errIndirizzo=""; // Stringa che mi dice quale errore si è verificato
			var regexpIndirizzo= /^(Via|Corso|Largo|Piazza|Vicolo)\s([A-Za-z\s]+)\s(\d{1,4})$/;

			if(indirizzo=="") {
				err=true;
				errIndirizzo="Non hai inserito l'indirizzo di consegna!";
			}
			else if(indirizzo.length>50) {
				err=true;
				errIndirizzo="L'indirizzo deve contenere non più di 50 caratteri!";
			}
			else if(!regexpIndirizzo.test(indirizzo)) {
				err=true;
				errIndirizzo="Il formato dell'indirizzo non è corretto!\nRicorda: l'indirizzo deve essere nella forma 'Via/Corso/Largo/Piazza/Vicolo' 'nome' 'numeroCivico', dove nome puo contenere caratteri alfabetici e spazi mentre  numeroCivico è un numero naturale composto da 1 a 4 cifre decimali.";
			}

			if(err==true) {
				window.alert(errIndirizzo);
				var bottoneSubmit = document.getElementById("sub");
				bottoneSubmit.disabled=true;
				return false;
			}

			// Controllo orario
			var regexpOrario = /^(\d{2}:\d{2})$/;
			var oraInserita = orario.split(":");
			var errOra = false;
			var errOrario = ""; // Stringa che mi dice quale errore si è verificato

			var oraAttuale = new Date();
			var oreAttuali = parseInt(oraAttuale.getHours());
			var minutiAttuali = parseInt(oraAttuale.getMinutes());

			var oraMinima = new Date(oraAttuale.getTime()+2700000); // tempo attuale in ms + 45 min (2700000 ms)
			var ora = oraMinima.getHours();
			var minuti = oraMinima.getMinutes();

			oraAttualeNascosta.value=oreAttuali+":"+minutiAttuali; // serve per passare al server l'ora attuale
			oraMinimaNascosta.value=ora+":"+minuti; // serve per passare al server l'ora minima prima della quale non si riesce a consegnare l'ordine

			if(ora<10)
				ora = "0" +ora;
			if(minuti<10)
				minuti = "0" +minuti;

			var oraMin = ora+":"+minuti;
			
			if(orario=="") {
				errOra = true;
				errOrario="Non hai inserito l'orario!";
			}
			else if(!regexpOrario.test(orario) || parseInt(oraInserita[0])>=24 || parseInt(oraInserita[1])>59) {
				errOra = true;
				errOrario="Hai inserito un orario di consegna non valido oppure il formato non è corretto! L'unico formato accettabile è: HH:MM.";
			}
			else if(parseInt(oraInserita[0])<12 || parseInt(oraInserita[0])>=24) {
				errOra = true;
				errOrario="Hai inserito un orario di consegna non valido! La pizzeria consegna solo tra le 12:00 e le 23:59.";
			}
			else if(oreAttuali==23 && minutiAttuali>14) {
				errOra = true;
				errOrario="Spiacenti! La pizzeria non fa più consegne per oggi";
			}
			else if(parseInt(oraInserita[0])<parseInt(ora) || (parseInt(oraInserita[0])==parseInt(ora) && parseInt(oraInserita[1])<parseInt(minuti))) {
				errOra = true;
				errOrario="Per motivi organizzativi non è possibile consegnare prima delle "+oraMin;
			}

			if(errOra==true) {
				window.alert(errOrario);
				var bottoneSubmit = document.getElementById("sub");
				bottoneSubmit.disabled=true;
				return false;
			}

			return true;			
		}
		

	</script>

	<div class="riassunto">
	<?php 
		if(!isset($_SESSION['logged'])){
			echo "<p>Utente: ANONIMO<br>Saldo: 0,00 &euro;</p>";
            $logged=false;
		}else{
            $logged=true;
			echo "<p>Utente:".$_SESSION['nick']."<br>Saldo:".number_format($_SESSION['money'],2,",","")." &euro;</p>";
		}
	?>
	
	</div>
    <noscript>
        Attenzione! Questo sito utilizza javascript. Il tuo browser non supporta javascript oppure ne &egrave; stata disabilitata l'esecuzione. Tale funzionalit&agrave; non sar&agrave; quindi disponibile.
    </noscript>
       

  	<div class="thecontent">
     
		<?php
        if(!$logged){
            echo "<p class='errore'>ERRORE , NON SEI LOGGATO</p>";

        } else{
			$_SESSION['invio'] = uniqid();
			echo"<h2 class='sottotitolo'>Riepilogo ordine</h2><table class='elenco'><tr><th class='pizze'>Nome</th><th class='pizze'>Quantit&agrave;</th><th class='pizze'>Prezzo unitario</th><th class='pizze'>Costo parziale</th></tr><tbody>";
        
		$con = mysqli_connect("localhost", "uWeak", "posso_leggere?", "pizzasporto"); 

		if (mysqli_connect_errno()) 
			echo "<p class='error'>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
		else
		{
			$c=1;
			$sommaprz=0;
			$m=$_SESSION['idmax'];	
			while($c<=$m){
			$quantita=0;
			
				$quantita=$_REQUEST['quantita'.$c];
			
				if($quantita>0){
					$_SESSION[ 'quantita'.$c]=$quantita;
					$qtypz=$quantita;
					$query ="SELECT pizze.nome,pizze.prezzo,pizze.qty FROM pizze WHERE pizze.id=? ";
					$stmt = mysqli_prepare($con, $query);
					mysqli_stmt_bind_param( $stmt, "i",$c);
					$result = mysqli_stmt_execute($stmt);
					$nome;$prz_;$qty;
					mysqli_stmt_bind_result($stmt,$nome,$prz_,$qty);
					mysqli_stmt_fetch($stmt);
					if(!$result)
					$s = mysqli_stmt_error();
					$prezzo=$prz_/100;
					$przpizze=$qtypz*$prezzo;
					$sommaprz += $przpizze;
					echo"<tr><td class='pizze'>$nome</td><td class='pizze'>$qtypz</td> <td class='pizze'>".number_format($prezzo,2,",","")."&euro;</td><td class='pizze'>".number_format($przpizze,2,",","")."&euro;</td></tr>";
					mysqli_stmt_close($stmt);
				}
        
			
			
			$c++;
			
		}
        echo"</tbody></table><p id='importo'>Importo totale dell'ordine: ".number_format($sommaprz,2,",","")."&euro;</p>";
		$money=$_SESSION['money']/1;
		$invio=$_SESSION[ 'invio'];
		$_SESSION[ 'sommaprz']=$sommaprz;
		if($money<$sommaprz){

		echo"<p> Il tuo saldo non è succiciente, (attuale ".number_format($money,2,",","").") necessario ".number_format($sommaprz,2,",","")."&euro;</p>";
		}
		else{
			$con = mysqli_connect("localhost", "uWeak", "posso_leggere?", "pizzasporto");          
		if (mysqli_connect_errno()) 
			echo "<p>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
		else
		{   $query = "SELECT indirizzo FROM utenti WHERE username =?";
			$stmt = mysqli_prepare($con, $query);
			if($stmt){
				$nick=$_SESSION['nick'];
				mysqli_stmt_bind_param($stmt, "s",$nick);
				$result = mysqli_stmt_execute($stmt);
				mysqli_stmt_bind_result($stmt,$ind);
				mysqli_stmt_fetch($stmt);
													
				mysqli_stmt_close($stmt);
				
				}
		}
		mysqli_close($con);
	echo"	<!-- Delivery address e delivery hour -->";
	echo"	<p>Completa il form sottostante inserendo i dati di consegna:</p><table><tbody><form name='f' action='Finale.php' method='POST' onsubmit='return validaForm(indirizzo.value,orario.value,document.f.orarioAttuale,document.f.oraMinima);'><tr><td>Indirizzo di consegna: </td><td><input required type='text' name='indirizzo' value='$ind'></td></tr><tr><td>Orario di consegna:* </td><td><input required type='text' name='orario' placeholder='HH-MM'></td></tr><tr><td><input type='submit' id='sub' value='OK'><input type='hidden' name='invio'  value='$invio'><input type='hidden' name='orarioAttuale'><input type='hidden' name='oraMinima'></form></td><td><form name='f2' action='home.php'><input type='submit' value='Annulla'></form></td></tr></tbody></table><p>*L’ora di consegna deve essere almeno 45 minuti dopo il momento dell’ordine.</p>";
		}	
}
}
  	?>
    </div>
	<?php 
		include("footer.php");
	?>
    </main>
  </body>
</html>