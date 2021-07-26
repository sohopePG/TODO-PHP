    <?php
    
        $editnum = "";
        $editname = "";
        $editcoment = "";
           
        $filename="mission_3-1.txt";

            if(!empty($_POST["del"])){
               $lines = file($filename,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
               $del = $_POST["del"];
               foreach($lines as &$line){
               $linex = explode("<>",$line);
               
                 if($linex[0] == $del){
                    $line = "";
               }
               file_put_contents($filename, implode("\n", $lines));
            }
          }//削除機能

            if(!empty($_POST["edit"])){
                  $lines = file($filename,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
               for($i = 0;$i < count($lines);$i++){
                  $line = explode("<>",$lines[$i]);
         
                 if($line[0] == $_POST["edit"]){
                   $editnum = $line[0];
                   $editname = $line[1];
                   $editcoment = $line[2];
                 }
               }
             }else if(!empty($_POST["str"])){
               $lines = file($filename,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
               $date = date("Y年m月d日 H時i分s秒");
               
               if(file_exists($filename)){
                   $num = intval(end($lines))+1;
               }else{
                   $num = 1;
               }
               
               $newdate = $num."<>".$_POST["name"]."<>".$_POST["str"]."<>".$date."<>";
               //新規書き込みデータ
               $editdate = $_POST["editnum"]."<>".$_POST["name"]."<>".$_POST["str"]."<>".$date."<>";
               //編集データ
               if(!empty($_POST["editnum"])){
                   //編集番号があったら
                   foreach($lines as &$line){
                       //＆で参照渡しをしている
                      $linex = explode("<>", $line);
                       if($linex[0] == $_POST["editnum"]){
                           //編集番号が一致したら編集データに上書き
                            $line = $editdate;
                    }
                   }
               }else{
                   //新規書き込みなので($editnumがないので)配列の末尾に追加
                   $lines[] = $newdate;
               }
               //ファイルに書き込む(implodeで配列を改行で区切って文字列にしている)
               file_put_contents($filename, implode("\n", $lines));
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
        <input type="hidden" name= "editnum" value ="<?php echo $editnum;?>">
        <input type="text" name="str" placeholder="コメント"value ="<?php echo $editcoment;?>"> by
        <input type="text" name="name" placeholder="name"value ="<?php echo $editname;?>">
        <input type="submit" name="submit">
        <input type="number" name="del" placeholder ="削除対象番号">
        <input type="submit" name="submi" value="削除">
        <input type="number" name="edit" value="編集対象番号">
        <input type="submit" name="submi" value="編集">
    </form>
      <p>なにか書いてください</p>
      <hr>
            <?php
          
            $lines = file($filename,FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
             
            if(file_exists($filename)){
            foreach( $lines as $line){
            $linex = explode("<>", $line);
            
            echo "<p>".$linex[0]."---".$linex[1]."---".$linex[3]."<br>".$linex[2]."<p>";
            }
            }
    ?>
</body>
</html>
