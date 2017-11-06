<?php
  include './config.php';
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
// подключение к db
      try {
        $pdo = new PDO(
        'mysql:host=localhost;dbname=global',
        $user,
        $password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
      }
      catch (PDOException $e) {
        echo "Невозможно установить соединение с базой данных";
        exit();
      }
    ?>

    <form method="POST">
      <input type="text" name="description" placeholder="Описание задачи" value="">
      <input type="submit" name="save" value="Добавить">
    </form>

    <table>
      <tr>
        <th>Описание задачи</th>
        <th>Дата добавления</th>
        <th>Статус</th>
        <th>Изменить</th>
      </tr>
      <?php
 //вывод всех данных
        $sql = "SELECT * FROM tasks";
        $statement = $pdo->prepare($sql);
        $statement->execute();

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
          $result[] = $row;
        }
    
        foreach ($result as $key => $value) {
          $id = $value['id'];
          $id = intval($id);

          if($value['is_done'] == 0){
            $is_done = 'В процессе';
          } else{
            $is_done = 'Выполнено';
          }
      ?>

          <tr>
            <td><?=$value['description'];?></td>
            <td><?=$value['date_added'];?></td>
            <td><?=$is_done;?></td>
            <td><a href="?id=<?="$id";?>&action=done">Выполнить</a> <a href="?id=<?=$id;?>&action=delete">Удалить</a></td>
            <!-- <a href="?id=<?=$id;?>&action=edit">Изменить</a> -->
          </tr>

      <?php
        }

        if(count($_POST > 0)){
          $description = trim($_POST['description']);
          $description = htmlspecialchars($description);
          $is_done = 0;
          $is_done = intval($is_done);

          if($description != ''){
            $query = $pdo->prepare("INSERT INTO `tasks` (`id`, `description`, `is_done`, `date_added`) VALUES (NULL, ?, ?, CURRENT_TIMESTAMP)");
            $params = [$description, $is_done];
            $query->execute($params);
            //header("Location: index.php");
            //exit();
          }
        }

        $idEdit = $_GET["id"];
        //$idEdit = trim($idEdit);
        $idEdit = intval($idEdit);
// Удалить
        if($_GET["action"] ==='delete'){
          $queryEdit = $pdo->prepare("DELETE FROM `tasks` WHERE `id` = ? ");
          $paramsEdit = [$idEdit];
          $queryEdit->execute($paramsEdit);
        }
// Выполнить
        if($_GET["action"] ==='done'){
          $queryEdit = $pdo->prepare("UPDATE `tasks`SET `is_done`='1' WHERE `id` = ?" );
          $paramsEdit = [$idEdit];
          $queryEdit->execute($paramsEdit);
        }

      ?>
      
    </table>
  </body>
</html>
