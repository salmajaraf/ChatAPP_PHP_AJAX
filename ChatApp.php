<?php 
    $conn = mysqli_connect('localhost','root','','tp6') ;
    
    if(!$conn) {
      echo 'connection error: ' . mysqli_connect_error();
    }
    $result=array();
    $message=isset($_POST['message'])?$_POST['message']:null;
    $User=isset($_POST['User'])?$_POST['User']:null;
    if(!empty($message)&& !empty($User)){
      $sql="Insert INTO `conversation` (`User`,`Message`) VALUES ('".$User."','".$message."')";
      $result['send_status']=$conn->query($sql);// Le statut de l'opération d'insertion est stocké dans la clé 'send_status' du tableau $result.
    }
    //print messages
    $start=isset($_GET['start'])? intval($_GET['start']):0;
    $items=$conn->query("SELECT * FROM `conversation` WHERE `idMessage` >" . $start);
    while($row=$items->fetch_assoc()){
      $result['items'][]=$row;
    }
    $conn->close();
    //ces en-têtes CORS indiquent au navigateur que les requêtes AJAX venant de n'importe quelle origine sont autorisées, et que la réponse du serveur est au format JSON. 
    header('Access-Control-Allow-Origin:*');//Lorsque cette ligne est incluse, le serveur indique explicitement qu'il autorise l'accès à ses ressources depuis n'importe quelle origine.
    header('Content-Type: application/json');//indique le type de données que le serveur envoie dans la réponse.
    
    echo json_encode($result);
?>