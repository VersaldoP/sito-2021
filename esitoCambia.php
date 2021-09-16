<?php
	
	$session = true;
   
    
	if( session_status() === PHP_SESSION_DISABLED  )
		$session = false;
	elseif( session_status() !== PHP_SESSION_ACTIVE )
	{
		session_start();
	}
	
   include("header.php");
   echo"<div class='riassunto'>";
		if(!isset($_SESSION['logged'])){
			echo "<p>Utente: ANONIMO<br>Saldo: 0,00 &euro;</p>";
		}else{
			echo "<p>Utente:".$_SESSION['nick']."<br>Saldo:".number_format($_SESSION['money'],2,",","")." &euro;</p>";
		}
	
	echo"</div>";


 $errore;
 $regexpQta = '/^\d+\$/';
$regexpPrezzo = '/^(\d)+(\.(\d){2})\$/';
    
    

        if(preg_match($regexpQta,$_REQUEST['quantita']))
        $errore .="<p class='error'> Il campo 'Quantita' &egrave; mancante o errato.</p>";
        
        if(preg_match($regexpPrezzo,$_REQUEST['prezzo']))
        $errore .="<p class='error'> Il campo 'Prezzo' &egrave; mancante o errato.</p>";
    if(isset($errore)){
        echo "<div class='thecontent'>";
    echo $errore ;
    
        }

    else{
        $con = mysqli_connect("localhost", "uStrong", "SuperPippo!!!", "pizzasporto");                
        if (mysqli_connect_errno()) 
            echo "<p class='error'>Errore connessione al DBMS: ".mysqli_connect_error()."</p>\n";
        elseif (isset($_REQUEST['submitProdotto'])){
            $name=$_REQUEST['nome'];
               
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
        if($GLOBALS['Prodotto Aggiunto']){
            echo"<p>Nuova pizza inserita Corretamente</p>";
        }
    
  echo "</div>";
    ?>
	<?php 
		include("footer.php");
	?>