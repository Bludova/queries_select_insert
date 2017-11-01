<?php
include './config.php';
$connection = new mysqli($host, $user, $password, $db);
$connection->set_charset('utf8');
if(!$connection) 
{
  echo 'Не удолось подключится к базе данных!<br>';
  echo mysqli_connect_error();
  exit();
} 
    //$news->execute(['id']);
// var_dump($news);
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="UTF-8">
    <title>Запросы SELECT, INSERT, UPDATE и DELETE</title>
        <style>
    table { 
        border-spacing: 0;
        border-collapse: collapse;
    }

    table td, table th {
        border: 1px solid #ccc;
        padding: 5px;
    }
    
    table th {
        background: #eee;
    }
</style>
</head>
 <body>
 <?php
if(isset($_GET["action"]) ==='edit'){
    echo $_POST['saves'];
mysqli_query($connection, "UPDATE `tasks`SET `description`='".$_POST['saves']."'  WHERE `id` = '".$_GET['id']."' ");
     ?>
        <form method="POST">
        <input type="text" name="saves" placeholder="" value="<?php $_POST['saves']?>">
        <input type="submit" name="save" value="Сохранить">
    </form>
    <?php
}else {
?>
   <form method="POST">
        <input type="text" name="description" placeholder="Описание задачи" value="">
        <input type="submit" name="save" value="Добавить">
    </form>
<?php }?>
<hr>
<!--  <form method="POST">
        <label for="sort">Сортировать по:</label>
        <select name="sort_by">
            <option value="date_created">Дате добавления</option>
            <option value="is_done">Статусу</option>
            <option value="description">Описанию</option>
        </select>
        <input type="submit" name="sort" value="Отсортировать" />
    </form> -->
    <hr>

<table>
    <tr>
        <th>Описание задачи</th>
        <th>Дата добавления</th>
        <th>Статус</th>
        <th>Изменить</th>
    </tr>
 <?php
 $sql = "SELECT * FROM tasks";
$result = $connection ->query($sql);
foreach ($result as $row) {
    $id=$row['id'];
    if($row['is_done'] == 0){
       $is_done = 'В процессе';
    } else{
        $is_done = 'Выполнено';
    }

    ?>
<tr> <td><?php echo $row['description'] . "</td><td>". $row['date_added'] . "</td><td>". $is_done ;?>
 </td> </td> <td> <a href="?id=<?=$row['id'];?>&action=edit">Изменить</a> <a href="?id=<?=$row['id'];?>&action=done">Выполнить</a> <a href="?id=<?=$row['id'];?>&action=delete">Удалить</a></td></tr>
<?php
}

?>
</table>
<?php

var_dump($_POST);
if (isset($_POST['save']) ){
      if($_POST['description'] == '')
       {
            echo'Введите описание задачи';
       } else {
   $description = $_POST['description'];

    mysqli_query($connection, "INSERT INTO `tasks` (`id`, `description`, `is_done`, `date_added`) VALUES (NULL,'".$_POST['description']."', '0', CURRENT_TIMESTAMP)");
}
    // "INSERT INTO `tasks` (`id`, `description`, `is_done`, `date_added`) VALUES (NULL, '".$_POST['description']."', '0', CURRENT_TIMESTAMP)";
   // $add = "INSERT INTO tasks (`id`, `description`, `is_done`, `date_added`) VALUES (NULL, 'dfd', '0')";
   // $resultadd = $connection ->query($add);
   // $add = "INSERT INTO tasks (`id`, `description`, `is_done`, `date_added`) VALUES (NULL," .$description.", '0', CURRENT_TIMESTAMP");
   // echo "$description <hr>";
}
// $gets_del = $_GET;
$id = $_GET["id"];
foreach ($gets_del as $key => $value) {
}
if($_GET["action"] ==='delete'){
     mysqli_query($connection, "DELETE FROM `tasks` WHERE `id` = '".$_GET['id']."' ");
}

if($_GET["action"] ==='done'){
     echo 'don';
      mysqli_query($connection, "UPDATE `tasks`SET `is_done`='1' WHERE `id` = '".$_GET['id']."' ");
}
?>
<a href="index.php?id=<?=$items["id"]?>">Удалить </a>` 
</body>
</html>