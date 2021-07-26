  
<!DOCTYPE html>
<html lang="ja">
    
<head>
    <meta chaeset="UTF-8">
    <title>lesson</title>
</head>

<body>
    
    <?php
           $editnum = "";
           $editname = "";
           $editcomment = "";
    
    
        //4-1 DB設定
     $dsn = 'mysql:dbname=;host=localhost';
    $user = '';
    $password = '';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        
     $sql = "CREATE TABLE IF NOT EXISTS tbw"
     ." ("
       
       
     . "id INT AUTO_INCREMENT PRIMARY KEY,"
       
     . "name char(32),"
       
     . "comment TEXT,"
    
     . "date DATETIME,"
    
     ."password varchar(8)"
     .");";
    
     $stmt = $pdo->query($sql);
 
    
   
    // 新規入力
    if(!empty($_POST['name']) && !empty($_POST['comment'] && empty($_POST["editnum"]))){
       $name = $_POST["name"];
       $comment = $_POST["comment"];
       $date = date("Y/m/d H:i:s");
       $password = $_POST["password"];
       
       if(!empty($_POST["password"])){
       $sql = $pdo -> prepare("INSERT INTO tbw (name,comment ,date,password ) VALUES (:name, :comment ,:date,:password)");
   
       $sql -> bindParam(':name', $name, PDO::PARAM_STR);
       $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
       $sql -> bindParam(':date', $date, PDO::PARAM_STR);
       $sql -> bindParam(':password', $password, PDO::PARAM_STR);
       $sql -> execute();  
       }
    }elseif(!empty($_POST["delete"])){
        $delete = $_POST["delete"];
        $id = $delete;
       
        $sql = "SELECT * FROM tbw WHERE id=:id";
        $stmt = $pdo->prepare($sql);     
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll();
        
   foreach ($results as $row){
    if($_POST["passwordn"] == $row["password"]){
       $sql = 'delete from tbw where id=:id';
       $stmt = $pdo->prepare($sql);
       $stmt->bindParam(':id', $id, PDO::PARAM_INT);
       $stmt->execute();
    }
}
}
    elseif(!empty($_POST["edit"])){
        $edit = $_POST["edit"];
        $id = $edit;
        
        $sql = "SELECT * FROM tbw WHERE id=:id";
        $stmt = $pdo->prepare($sql);     
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll();
        
        foreach ($results as $row){
            if($_POST["passworde"] == $row["password"]){
  
                  $editnum = $row["id"];
                  $editname = $row['name'];
                  $editcomment = $row['comment'];
            }
             }
       //変更したい名前、変更したいコメントは自分で決めること
}
if(!empty($_POST['name']) && !empty($_POST['comment'] && !empty($_POST["editnum"]))){
        // 入力フォームからデータを取得
       $name = $_POST["name"];
       $comment = $_POST["comment"];
       $date = date("Y/m/d H:i:s");
       $password = $_POST["password"];
       $id = $_POST["editnum"];

       $sql  = 'UPDATE tbw SET name=:name,comment=:comment,date=:date,password=:password WHERE id=:id';
       $stmt = $pdo -> prepare($sql);
       
       $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
       $stmt -> bindParam(':name', $name, PDO::PARAM_STR);
       $stmt -> bindParam(':comment', $comment, PDO::PARAM_STR);
       $stmt -> bindParam(':date', $date, PDO::PARAM_STR);
       $stmt -> bindParam(':password', $password, PDO::PARAM_STR);
       $stmt -> execute();  
}
        
   ?>
   <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_1-20</title>
</head>
<body>
    
      <form action="" method="post">
        【投稿フォーム】<br>
        <input type="hidden" name= "editnum" value ="<?php echo $editnum?>">
        <input type="text" name="comment" placeholder="コメント"value ="<?php echo $editcomment?>"> <br>
        <input type="text" name="name" placeholder="name"value ="<?php echo $editname?>"><br>
        <input type="password" name="password" placeholder="パスワード">
        <input type="submit" name="submit"><br>
        【削除フォーム】<br>
        <input type="number" name="delete" placeholder ="削除対象番号"><br>
        <input type="password" name="passwordn"placeholder="パスワード">
        <input type="submit" name="submi" value="削除"><br>
        【編集フォーム】<br>
        <input type="number" name="edit" placeholder="編集対象番号"><br>
        <input type="password" name="passworde"placeholder="パスワード">
        <input type="submit" name="submi" value="編集">
        
    </form>
      <p>SQL版掲示板</p>
      <hr>
            <?php
            $sql = 'SELECT * FROM tbw';
            $stmt = $pdo->query($sql);
            $results = $stmt->fetchAll();
             foreach ($results as $row){
  //$rowの中にはテーブルのカラム名が入る
                echo "番号:".$row['id'].'<br>';
                echo "名前:"    .$row['name'].'<br>';
                echo "コメント:". $row['comment'].'<br>';
                echo "日時:" .$row['date'].'<br>';
   
                echo "<hr>";
             }
    ?>
</body>
 </html>