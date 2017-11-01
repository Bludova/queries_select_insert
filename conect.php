<?php
include './config.php';
// Подключаемся к MySQL серверу
// $link = mysql_connect($host, $user, $password, $db);
$link = mysqli_connect($host, $user, $password, $db) 
    or die("Ошибка " . mysqli_error($link));
 
$query ="CREATE Table tasks
(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `is_done` tinyint(4) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)";
$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
if($result)
{
    echo "Создание таблицы прошло успешно";
}
 
mysqli_close($link);
?>

