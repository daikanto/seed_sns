<?php 
//Db接続処理をまとめたファイル
$db=mysqli_connect('localhost','root','mysql','seed_sns') or  die(mysqli_connect_error());
mysqli_set_charset($db,'utf8');

//PDOのメリット
//DBの種類に関係なく使用できる
//オブジェクト指向でかける

//mysqli関数のメリット
//プログラムが若干読みやすい
//初心者向け
//*上級者はPDO



 ?>