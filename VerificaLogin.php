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

$regexpUsername = '/^(([A-Za-z]){1}([A-Za-z0-9\-\_]){2,7})\$/';
$regP= '/^(?=(.*[\d]){2})(?=(.*[!.,;:?]){2})(?=.*[A-Z])(?=.*[a-z])[A-Za-z\d!.:,;?]{6,12}\$/';   
 
        
        if(preg_match($regexpUsername,$_REQUEST['nick']))
        $errore .="<p class='error'> Il campo 'Username' &egrave; mancante o errato.".$_REQUEST['nick']."</p>";
        
        if(preg_match($regP,$_REQUEST['password']))
        $errore .="<p class='error'> Il campo 'Password' &egrave; mancante o errato.</p>";

    if(isset($errore)){
        echo "<div class='thecontent'>";
    echo $errore ;
    
        }

    else{
        $con = mysqli_connect("localhost", "uWeak", "posso_leggere?", "pizzasporto");                
        if (mysqli_connect_errno()) 
            echo "<p class='error'>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
        else
        {    
            
                $nick;
                $query = "SELECT u.username,u.credito,u.gestore  FROM utenti u WHERE u.username=? and u.pwd=? ";   
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param( $stmt, "ss",$_REQUEST['nick'],$_REQUEST['password']);
                $result = mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt,$nick,$money,$gestore);
                
                    if(!mysqli_stmt_fetch($stmt))
                    {
                        include("header.php");
                        echo "<p class='error'>Errore query fallita: ".mysqli_error($con)." lo username o Password non sono corretti</p>\n";
                    }
                    else
                    {
                   
                        $money= $money*10000;
                       
                        $_SESSION['logged'] = true;
                        $_SESSION['nick']=$_REQUEST['nick'];
                        $_SESSION['money']=number_format($money,2,',','.');
                        $_SESSION['gestore'] =$gestore;
                        setcookie($cookie_name, $nick , time() + (86400 * 3), "/"); // 86400 = 1 day
                        if(!$gestore)
                        header('location: info.php');
                        else{
                            header('location: cambia.php');
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