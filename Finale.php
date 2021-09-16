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
      <h2> Esito Ordine</h2>
      <?php
   
              if(isset($_REQUEST['invio']) && isset($_SESSION['invio']) && $_REQUEST['invio']==$_SESSION['invio'])
        {
            $con = mysqli_connect("localhost", "uStrong", "SuperPippo!!!", "pizzasporto");               
            if (mysqli_connect_errno()) 
                echo "<p>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
            else
            {    
                $c=1;
                    $sommaprz=0;
                    $m=$_SESSION['idmax'];	
                    while($c<=$m){
                    $quantita=0;
                    
                        $quantita=$_SESSION['quantita'.$c];
                        
                        if($quantita>0){
                            $qtypz=$quantita;
                            $query ="SELECT pizze.qty FROM pizze WHERE pizze.id=? ";
                            $stmt = mysqli_prepare($con, $query);
                            mysqli_stmt_bind_param( $stmt, "i",$c);
                            $result = mysqli_stmt_execute($stmt);
                            $qty;
                            mysqli_stmt_bind_result($stmt,$qty);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_close($stmt);
                           
                            $query= "UPDATE  pizze AS p SET p.qty = ? WHERE p.id= ?;";
                            $newqty= $qty-$qtypz;
                            $stmt = mysqli_prepare($con, $query);
                            mysqli_stmt_bind_param( $stmt, "ii",$newqty,$c);
                            $result = mysqli_stmt_execute($stmt);
                            
                            mysqli_stmt_close($stmt);
                        }
                
                    
                    
                    $c++;
                    
                }
                $query= "UPDATE  utenti AS p SET p.credito = ? WHERE p.username= ?;";
                $newmoney= ($_SESSION[ 'money']-$_SESSION['sommaprz'])*100;
                $nick = $_SESSION['nick'];
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param( $stmt, "is",$newmoney,$nick);
                $result = mysqli_stmt_execute($stmt);

            
                        
                        if($result)
                        { 
                            echo "<h1>Risultato ordine</h1>\n";
                            echo "<div>L'ordine &egrave; avvenuto con successo!</div>";
                        }
                       
                    else
                    {
                        echo "<h1>Risultato ordine</h1>\n";
       