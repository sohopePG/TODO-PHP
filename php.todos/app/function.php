<?php

  function getPDO(){
      $dsn = 'mysql:dbname=tb230072db;host=localhost';
      $user = 'tb-230072';
      $password = 'LnLBsdMTF6';
  try{
      $pdo = new PDO(
      $dsn, 
      $user,
      $password,
      array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
      PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_EMULATE_PREPARES => false,
      PDO::ATTR_DEFAULT_FETCH_MODE =>PDO::FETCH_OBJ,
     )
    );
         return $pdo;
       }catch(PDOException $e){
          echo $e ->getMessage();
          exit;
     }
   }
   function getPDO2(){
        $dsn = 'mysql:dbname=tb230072db;host=localhost';
        $user = 'tb-230072';
        $password = 'LnLBsdMTF6';
    try{
        $pdo = new PDO(
        $dsn, 
        $user,
        $password,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES => false,
        )
        );
        return $pdo;
        }catch(PDOException $e){
           echo $e ->getMessage();
           exit;
       }
     }
   
   function createToken(){
        if(!isset($_SESSION["token"])){
            $_SESSION["token"] = bin2hex(random_bytes(32));
        }
    }
    
   function validateToken(){
        if(empty($_SESSION["token"])||$_SESSION["token"]!== filter_input(INPUT_POST,"token")){
           exit("Invalid post request");
        }
    }
    
   function h($str){
      echo htmlspecialchars($str,ENT_QUOTES,"utf-8");
    }
 
   function toggletodo($pdo){
        $id = filter_input(INPUT_POST,"id");
        if(empty($id)){
            return;
        }
        $stmt = $pdo->prepare("UPDATE todos SET done = NOT done WHERE id =:id");
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $stmt->execute();
    }
    
   function createTodo($pdo){
       $Todoname = trim(filter_input(INPUT_POST,"Todoname"));
           if($Todoname === ""){
               return;
           }
        $Tododate = date("Y/m/d H:i:s");
        $stmt = $pdo->prepare("INSERT into todos (Todoname,Tododate) VALUE(:Todoname,:Tododate)");
        $stmt->bindValue(":Todoname",$Todoname,PDO::PARAM_STR);
        $stmt->bindValue(":Tododate",$Tododate,PDO::PARAM_STR);
        $stmt->execute();
    }

   function deleteTodo($pdo){
       
        $id = filter_input(INPUT_POST,"did");
         if(empty($id)){
             return;
          }
        
        $todos = Todolist($pdo);
    
        $stmt = $pdo->prepare("DELETE FROM todos WHERE id=:id");
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $stmt->execute();
    }

   function Todolist($pdo){
        $stmt = $pdo ->query("SELECT * FROM todos ORDER BY id DESC");
        $todos = $stmt->fetchAll();
       return $todos;
}
?>