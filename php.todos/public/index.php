

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>my todos</title>
    <link rel="stylesheet" href="css/todo.css">
</head>
<script type="text/javascript">
    function confirmation(string){
        const select = alert(string+"を削除します");
        return select;
    }
</script>

<?php
require_once(__DIR__ . "/../app/function.php");
$pdo = getPDO();
$todos = Todolist($pdo);
  if($_SERVER["REQUEST_METHOD"] === "POST"){
        
        $action = filter_input(INPUT_GET,"action");
        
        switch($action){
            case "create":
                createtodo($pdo);
                break;
            case "delete":
                deleteTodo($pdo);
                break;
        }
        header("Location:https://tech-base.net/tb-230072/todo/public/index.php");
  }
?>
<body>
    <main id="cont">
    <div id="textform">
    <h1>todos</h1>
    
    <form action="?action=create"method="post">
        <input type="text"name="Todoname"placeholder="Todoを入力してください" id="text">
        <input type="submit"name="submit" id="button" value="追加"></div>
    </form>
        <ul id=Todolist>
          <?php foreach($todos as $todo):?>
        <div class="todo">
            
            <div class="tododate">
            <input type="hidden"name="id">
            <?php h($todo->Tododate);?>
            </div>
            
            <li>
                
            <from action="?action=toggle" method="post">
                <input type="checkbox" name="checktodo">
            </from>
          
            <span class ="done_todo">
              <?php h($todo->Todoname);?>
            </span>
            
            <form action="?action=delete"method="post"onsubmit="confirmation(<?php h($todo->Todoname);?>)">
            <input type="hidden"name="did"value="<?php h($todo->id);?>">
            <input type="submit"name="delete"class="kesu"value="削除">
            </form>
            
            </li>
            
            
        </div>
            <?php endforeach;?>
        
         </form>
        </ul>
  
    </main>
      <script src="js/main.js"></script>
</body>
</html>