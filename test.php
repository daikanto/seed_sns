<?php 

//sprintf関数
	$str=sprintf('私は%sで%sす。','プログラマ','hahha');
	echo $str;


 	$sql =sprintf('INSERT INTO `members` SET `nick_name`="%s",`email`="%s",`passward`="%s"',"nexseed","nex@nexseed","nexnex");
 	echo $sql;
 ?>