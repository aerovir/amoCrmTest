<?php

namespace index;

use function auth\authReq;
use const n;
use function request\answerReq;

include_once 'auth.php';
include_once 'request.php';
include_once 'addContact.php';

authReq();
$res = answerReq();
$statusSuccess = 142;
$statusEnd = 143;
$currentTime = time();
?>

<br>
<br>

<?php
//
//for($i = 0; $i < count($res); $i++){
//    echo $res[$i]['status_id'].PHP_EOL;
//}
//?>

<table style="width: auto;" border="1">
    <tbody>
    <tr>
        <td>id</td>
        <td>Имя сделки</td>
        <td>Бюджет сделки</td>
    </tr>
    <?php for($i = 0; $i < count($res); $i++){ ?>
    <tr>
        <?php if(($res[$i]['status_id'] != $statusSuccess) && ($res[$i]['status_id'] != $statusEnd) && ($res[$i]['created_at'] > ($currentTime - 2592000))){?>
        <td><?= $res[$i]['id']; ?></td>
        <td><?= $res[$i]['name']; ?></td>
        <td><?= $res[$i]['sale']; }}?></td>
    </tr>
    </tbody>
</table>
<br>
<br>
<br>
<br>

 <form name="создание новой сделки" action="addSale.php" method="post">
     <h3>Новая сделка</h3><br>
            <div>
                <input type="text" name="saleName" autofocus="true" placeholder="название сделки"><br><br>
                <input type="text" name="sale" placeholder="бюджет сделки"><br><br>
                <input type="submit" value="Создать новую сделку">
            </div>
    </form>
<br>
<br>
<br>
<form name="создание новой сделки" action="addContact.php" method="post">
    <h3>Новый контакт</h3><br>
    <div>
        <input type="text" name="contactName" autofocus="true" placeholder="имя"><br><br>
        <input type="text" name="phone" placeholder="телефон"><br><br>
        <input type="text" name="email" placeholder="email"><br><br>
        <input type="submit" value="Создать новый контакт">
    </div>
</form>
