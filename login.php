<?php
	
	$cookie_name = "username";
	$session = true;
    
	if( session_status() === PHP_SESSION_DISABLED  )
		$session = false;
	elseif( session_status() !== PHP_SESSION_ACTIVE )
	{
		session_start();
	}
	include("header.php");
?>

  
	<script >
            function validateForm(nickname,pswd){
            if(nickname == "" || pswd == ""){
                   window.alert("Il nickname e/o la password non sono impostati.");
                   return false;
				   }
               return true;
			   }
			  
			
        </script>
	<div class="riassunto">
		<?php
			if(!isset($_SESSION['logged'])){
				echo "<p>Utente: ANONIMO<br>Saldo: 0,00 &euro;</p>";
			}else{
				echo "<p>Utente:".$_SESSION['nick']."<br>Saldo:".number_format($_SESSION['money'],2,",","")." &euro;</p>";
			}
		?>
	
	</div>
	 	
  	

  	<div class="thecontent">
	 <?php if($_SESSION['errato']==true){
				echo "<script type='text/javascript'> window.alert('Sono stati introdotti dati di autenticazione errati.');</script>";
				$_SESSION['errato']=false;
				
				}
	?>
      
	  <p>Inserire le informazioni richieste:</p>
	 
	  
     <form name="f" action="verificaLogin.php" method="GET"  onsubmit="return validateForm(nick.value,password.value);" > 
	 <p><input name="nick" type="text" class="form" style="width:50%" 
	 <?php
	 if(isset($_COOKIE[$cookie_name])) 
		echo " value =".$_COOKIE[$cookie_name].">";
	else
		echo " placeholder = 'nick'>";
	 ?>
	 
	 </p>
	 <p><input name="password"  type="password" class="form" style="width:50%" placeholder="Password" ></p>
	 <input type="Reset"  class="button" value="PULISCI" >
	 <input type="submit" class="button" value="OK" >
	 </form>
	 
	 </div>
	
       
		<?php 
		include('footer.php');
		?>
    </main>
  </body>
</html>