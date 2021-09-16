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
		if(!isset($_SESSION['logged'])){
			echo "<p>Utente: ANONIMO<br>Saldo: 0,00 &euro;</p>";
		}else{
			echo "<p>Utente:".$_SESSION['nick']."<br>Saldo:".number_format($_SESSION['money'],2,",","")." &euro;</p>";
		}
	?>
	
	</div>
	<script>
		"use strict";
		function validaForm(name,surname,birthday,address,money,nick,password) {

			// Controllo se tutti i campi sono stati inseriti
			var errCampiMancanti = false;
			var campiMancanti = "Non hai inserito i seguenti campi:\n";

			if(name=="") {
				campiMancanti = campiMancanti +"Nome\n";
				errCampiMancanti = true;
			}
			if(surname=="") {
				campiMancanti = campiMancanti +"Cognome\n";
				errCampiMancanti = true;
			}
			if(birthday=="") {
				campiMancanti = campiMancanti +"Data di nascita\n";
				errCampiMancanti = true;
			}
			if(address=="") {
				campiMancanti = campiMancanti +"Domicilio\n";
				errCampiMancanti = true;
			}
			if(money=="") {
				campiMancanti = campiMancanti +"Credito\n";
				errCampiMancanti = true;
			}
			if(nick=="") {
				campiMancanti = campiMancanti +"Username\n";
				errCampiMancanti = true;
			}
			if(password=="") {
				campiMancanti = campiMancanti +"Password\n";
				errCampiMancanti = true;
			}

			if(errCampiMancanti==true) {
				window.alert(campiMancanti);
				return false;
			}

			// Se tutti i campi sono stati inseriti, controllo se sono corretti
			var errCampiErrati = false;
			var campiErrati = "I seguenti campi sono errati:\n";

			var regexpNome = /^[A-Za-z]((\s)?[^\s]+)+$/;
			var regexpCognome = /^[A-Za-z]((\s)?[^\s]+)+$/;
			var regexpData = /((^((19(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96))|(20(00|04|08|12|16|20)))[\-](02|2)[\-]29$)|(^(\d{4})[-]((((0?[13578])|(1[02]))[-]((0?[1-9])|1[0-9]|2[0-9]|3[01]))|((0?[469])|11)[-]((0?[1-9])|1[0-9]|2[0-9]|30)|(0?[2])[-]((0?[1-9])|1[0-9]|2[0-8]))$))/;
			var regexpDomicilio = /^(Via|Corso|Largo|Piazza|Vicolo)\s([A-Za-z\s]+)\s(\d{1,4})$/;
			var regexpCredito = /^(\d)+(\.(\d){2})$/;
			var regexpUsername = /^(([A-Za-z]){1}([A-Za-z0-9\-\_]){2,7})$/;
			var regexpPwdLunghezza = /^[A-Za-z0-9.,;:!?()\-"\\/*_]{6,12}$/;
			var regP= /^(?=(.*[\d]){2})(?=(.*[!.,;:?]){2})(?=.*[A-Z])(?=.*[a-z])[A-Za-z\d!.:,;?]{6,12}$/;

			if(!regexpNome.test(name) || !/^[A-Za-z\s]{2,25}$/.test(name)) {
				campiErrati = campiErrati +"Nome\n";
				errCampiErrati=true;
			}

			if(!regexpCognome.test(surname) || !/^[A-Za-z\s]{2,30}$/.test(surname)) {
				campiErrati = campiErrati +"Cognome\n";
				errCampiErrati=true;
			}

			if(!regexpData.test(birthday)) {
				campiErrati = campiErrati +"Data di nascita\n";
				errCampiErrati=true;
			}

			if(!regexpDomicilio.test(address) || address.length>50) {
				campiErrati = campiErrati +"Domicilio\n";
				errCampiErrati=true;
			}

			if(!regexpCredito.test(money)) {
				campiErrati = campiErrati +"Credito\n";
				errCampiErrati=true;
			}

			if(!regexpUsername.test(nick)) {
				campiErrati = campiErrati +"Username\n";
				errCampiErrati=true;
			}

	
			if(!regP.test(password) ) {
				campiErrati = campiErrati +"Password\n";
				errCampiErrati=true;
			}
			

			if(errCampiErrati==true) {
				window.alert(campiErrati+"Puoi visualizzare i formati corretti nella tendina in basso (FORMATI ACCETTABILI).");
				return false;
			}
			return true;
		}
	</script>
       

  	<div class="thecontent">
      
		
	  <p>Se sei un nuovo utente e vuoi registrarti per acquistare i nostri prodotti, compila tutti i campi richiesti!</p>

<form name="f" action="confermaRegistrazione.php" method="GET" onsubmit="return validaForm(name.value, surname.value, birthday.value, address.value, money.value, nick.value, password.value);">
	<table>
		<tbody>
			<tr><td>Nome</td> <td><input required type="text" name="name" size="30"></td></tr>
			<tr><td>Cognome</td> <td><input required type="text" name="surname" size="30"></td></tr>
			<tr><td>Data di nascita</td> <td><input required type="text" name="birthday" size="30" placeholder="AAAA-MM-GG"></td></tr>
			<tr><td>Domicilio</td> <td><input required type="text" name="address" size="30" placeholder="Via/Corso/Largo/Piazza/Vicolo"></td></tr>
			<tr><td>Credito</td> <td><input required type="text" name="money" size="30"> (&euro;)</td></tr>
			<tr><td>Username</td> <td><input required type="text" name="nick" size="30"></td></tr>
			<tr><td>Password</td> <td><input required type="password" name="password" size="30"></td></tr>
		</tbody>
	</table>
	<p><input type="submit" value="Conferma"> <input type="reset" value="Azzera"></p>
</form>

<details class="guida">
	<summary>FORMATI ACCETTABILI</summary>
		<ul>
			<li>Nome: minimo 2 e massimo 25 caratteri, con solo lettere ed il carattere spazio come caratteri accettabili. Deve iniziare e terminare con un caratttere alfabetico e non sono accettate sequenze di spazi.</li>
			<li>Cognome: minimo 2 e massimo 30 caratteri, con solo lettere ed il carattere spazio come caratteri accettabili. Deve iniziare e terminare con un caratttere alfabetico e non sono accettate sequenze di spazi.</li>
			<li>Data di nascita: deve essere nella forma “aaaa-mm-gg” (dove il valore 0 in posizione pi&ugrave; significativa nel mese e nel giorno pu&ograve; eventualmente essere omesso).</li>
			<li>Domicilio: deve essere nella forma “Via/Corso/Largo/Piazza/Vicolo nome numeroCivico”, dove nome pu&ograve; contenere caratteri alfabetici e spazi mentre numeroCivico e un numero naturale composto da 1 a 4 cifre decimali (Massimo 50 caratteri).</li>
			<li>Credito: deve essere un valore numerico positivo espresso con la precisione dei centesimi(parte intera e decimale separati da punto, non virgola).</li>
			<li>Username: minimo 3 e massimo 8 caratteri, con solo lettere, numeri e ‘-’ o ‘_’ come valori ammessi e deve cominciare con un carattere alfabetico.</li>
			<li>Password: minimo 6 e massimo 12 caratteri, pu&ograve; contenere lettere, numeri e segni di interpunzione(come!?.:,;), e deve contenere almeno 1 lettera maiuscola, 1 lettera minuscola, 2 numeri, e 2 caratteri di interpunzione.</li>
		</ul>
</details>
  	
    </div>
	<?php 
		include("footer.php");
	?>
    </main>
  </body>
</html>