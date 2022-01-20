<?php
require_once(__DIR__ . "/../app/config.php");
 
 createToken();
 

     $pdo = getPDO2();
     $token = $_SESSION["token"];
     $errors = array();

    if(isset($_POST["submit"])){
		//POSTされたデータを各変数に入れる
		$name = isset($_POST['name']) ? $_POST['name'] : NULL;
		$password = isset($_POST['password']) ? $_POST['password'] : NULL;
		$mail = isset($_POST['mail']) ? $_POST['mail'] : NULL;
		//セッションに登録
		$_SESSION['name'] = $name;
		$_SESSION['password'] = $password;
		$_SESSION['mail'] = $mail;


		//アカウント入力判定
		//パスワード入力判定
		if ($password == ''){
		    $errors['password'] = "パスワードが入力されていません。";
		}
		if ($name == ''){
		   	$errors['name'] = "氏名が入力されていません。"; 
		}
		if ($mail == ""){
		    $errors['mail'] = "メールアドレスが入力されていません。"; 
		}
    		try{
    		
			// DB接続	
			//flagが0の未登録者 or 仮登録日から24時間以内
			$sql = "SELECT * FROM user_date WHERE status =1 AND name=:name AND mail=:mail AND password=:password";
            $stm = $pdo->prepare($sql);
            $stm->bindValue(':mail', $mail, PDO::PARAM_STR);
            $stm->bindValue(':name', $name, PDO::PARAM_STR);
            $stm->bindValue(':password', $password, PDO::PARAM_STR);
			$stm->execute();
			
			//レコード件数取得
			$row_count = $stm->rowCount();
			
			//24時間以内に仮登録され、本登録されていないトークンの場合
			if($row_count == 0){
				$errors['urltoken_timeover'] = "ログインに失敗しました。入力内容に誤りがあります";
			}
			//データベース接続切断
			$stm = null;
		}catch (PDOException $e){
			print('Error:'.$e->getMessage());
			die();
		}
	}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>my todos</title>
</head>
<body>
    <?php if (isset($_POST['submit']) && count($errors) === 0):?>
    <p>ログイン成功</p>
    <form action="https://tech-base.net/tb-230072/todo/public/index.php">
        <input type="submit"name="gotoTodoapp" value="todoアプリへ">
    </form>
    <?php else:?>
    	<?php if(count($errors) > 0): ?>
       <?php
       foreach($errors as $value){
           echo "<p class='error'>".$value."</p>";
       }
       ?>
       <?php endif;?>
        <?php endif;?>
   <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
     メールアドレス:<input type="text"name="mail"size="50" value="<?php if( !empty($_POST['mail']) ){ echo $_POST['mail']; } ?>"><br>
     氏名:<input type="text"name="name"><br>
     パスワード:<input type="password"name="password"><br>
     <input type="submit"name="submit"placeholder="送信">
   </form>
</body>
</html>