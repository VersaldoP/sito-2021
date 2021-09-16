<?php
	
	$session = true;
    $cookie_name = "username";
    
	if( session_status() === PHP_SESSION_DISABLED  )
		$session = false;
	elseif( session_status() !== PHP_SESSION_ACTIVE )
	{
		session_start();
	}
	
 


 $errore;
$regexpNome = '/^[A-Za-z]((\s)?[^\s]+)+\$/';
$regexpCognome = '/^[A-Za-z]((\s)?[^\s]+)+\$/';
$regexpData = '/((^((19(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96))|(20(00|04|08|12|16|20)))[\-](02|2)[\-]29$)|(^(\d{4})[-]((((0?[13578])|(1[02]))[-]((0?[1-9])|1[0-9]|2[0-9]|3[01]))|((0?[469])|11)[-]((0?[1-9])|1[0-9]|2[0-9]|30)|(0?[2])[-]((0?[1-9])|1[0-9]|2[0-8]))\$))/';
$regexpDomicilio = '/^(Via|Corso|Largo|Piazza|Vicolo)\s([A-Za-z\s]+)\s(\d{1,4})\$/';
$regexpCredito = '/^(\d)+(\.(\d){2})\$/';
$regexpUsername = '/^(([A-Za-z]){1}([A-Za-z0-9\-\_]){2,7})\$/';
$regP= '/^(?=(.*[\d]){2})(?=(.*[!.,;:?]){2})(?=.*[A-Z])(?=.*[a-z])[A-Za-z\d!.:,;?]{6,12}\$/';   
    
    $name=$_REQUEST['name'];
    

        if( preg_match($regexpNome,$_REQUEST['name']))
        $errore ="<p class='error'> Il campo 'Nome' &egrave; mancante o errato.</p>";
    
        if( preg_match($regexpCognome,$_REQUEST['surname']))
        $errore .="<p class='error'> Il campo 'Cognome' &egrave; mancante o errato.</p>";
        
        if(preg_match($regexpData,$_REQUEST['birthday']))
        $errore .="<p class='error'> Il campo 'Compleanno' &egrave; mancante o errato.</p>";
        
        if( preg_match($regexpDomicilio,$_REQUEST['address']))
        $errore .="<p class='error'> Il campo 'Indirizzo' &egrave; mancante o errato.</p>";
        
        if(preg_match($regexpCredito,$_REQUEST['money']))
        $errore .="<p class='error'> Il campo 'Saldo' &egrave; mancante o errato.</p>";
        
        if(preg_match($regexpUsername,$_REQUEST['nick']))
        $errore .="<p class='error'> Il campo 'Username' &egrave; mancante o errato.</p>";
        
        if( preg_match($regP,$_REQUEST['password']))
        $errore .="<p class='error'> Il campo 'Password' &egrave; mancante o errato.</p>";
        
    if(isset($errore)){
        echo "<div class='thecontent'>";
    echo $errore ;
    
        }

    else{
        $con = mysqli_connect("localhost", "uStrong", "SuperPippo!!!", "pizzasporto");                
        if (mysqli_connect_errno()) 
            echo "<p class='error'>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
        else
        {    
            
                $nick;
                $query = "SELECT u.username AS usr FROM utenti u WHERE u.username=? ";   
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param( $stmt, "s",$_REQUEST['nick']);
                $result = mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt,$nick);
                
                    if(mysqli_stmt_fetch($stmt))
                    {
                        include("header.php");
                        
                        echo "<p>Errore query fallita: ".mysqli_error($con)." lo username inserito non è disponibile</p>\n";
                    }
                    else
                    {
                       
                        $query = "INSERT INTO utenti 
                        (utenti.nome,utenti.cognome,utenti.`data`,utenti.indirizzo,utenti.username,utenti.pwd,utenti.credito,utenti.gestore)
                        VALUES(?,?,?,?,?,?,?,0);";   
                        $stmt = mysqli_prepare($con, $query);
                        $money = ($_REQUEST['money']*100);
                        mysqli_stmt_bind_param( $stmt, "ssssssd",$_REQUEST['name'],$_REQUEST['surname'],$_REQUEST['birthday'],$_REQUEST['address'],$_REQUEST['nick'],$_REQUEST['password'],$money);
                        $result = mysqli_stmt_execute($stmt);
                      
                        $_SESSION['logged'] = true;
                        $_SESSION['nick']=$_REQUEST['nick'];
                        $_SESSION['money']=number_format($money,2,',','.')*10;
                        
                        setcookie($cookie_name,  $_SESSION['nick'] , time() + (86400 * 3), "/"); // 86400 = 1 day
                        
                        header('Location: info.php');
                        if(!mysqli_stmt_error($stmt)){
                            echo "<p> Inserimento andato a buon fine </p>";
                        }
                        else{
                            echo "<p> Inserimento non andato a buon fine: ".mysqli_stmt_error($stmt)."  </p>";
                        }
                        }
                        
                    mysqli_stmt_close($stmt);
                    }
        mysqli_close($con);
        }
    
  echo "</div>";
    ?>
	<?php 
		include("footer.php");
	?>