<?php
//データベースハンドラ
   // $dsn = 'mysql:dbname=tb210902db;host=localhost';
//	$user = 'tb-210902';
  //  $password = 'w5AXhaMSvU';
  $dsn = 'データベース名';
	$user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING) ) ;


    //テーブル作成
    $sql = "CREATE TABLE tbtestt"
 ." ("
 . "id INT AUTO_INCREMENT PRIMARY KEY,"
 . "name char(32),"
 . "comment TEXT,"
 ."pass char(32)"
 .");";
 //$stmt = $pdo->query($sql);///////////////////////////////////////
    

//編集ボタンが押されたとき、編集対象の投稿の名前、コメント、パスを変数に代入。

if(!empty($_POST["pass2"]) && !empty($_POST["editnum"])){
 
    $sql = 'SELECT * FROM tbtestt';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach($results as $row){
        if($_POST["editnum"]==$row["id"] && $_POST["pass2"]==$row["pass"]){
            $Epass=$row["pass"];
            $Ename=$row["name"];
            $Ecomment=$row["comment"];
            $Enumber=$row["id"];
        }

}
}


?>


<html>
	<head>
        <title>大喜利大会【お題】○○さん～らしいよ。</title>
		<meta charset = "utf-8">
	</head>
	<body>
        <h1>大喜利大会【お題】○○さん～らしいよ。</h1>

		<form method = "post">
            
			<input type = "text" name = "name" value = "<?php if(!empty($Ename)){ echo $Ename; } ?>" placeholder="暴露したい人の名前"><br>
			<input type = "text" name = "comment" value = "<?php if(!empty($Ecomment)){ echo $Ecomment; } ?>" placeholder = "暴露すること"><br>
			<input type = "hidden" name = "hidnum" value = "<?php if(!empty($Enumber)){ echo $Enumber; } ?>" >
            <input type = "text" name = "pass_given" value = "<?php if(!empty($Epass)){ echo $Epass; } ?>" placeholder = "パスワード">
			<input type = "submit" value = "投稿"><br><br>
            
            <input type = "text" name = "delenum" placeholder = "削除対象番号"><br>
			<input type = "text" name = "pass1" placeholder = "パスワード">
			<input type = "submit" name = "delete" value = "削除"><br><br>
			<input type = "text" name = "editnum" placeholder = "編集対象番号"><br>
			<input type = "text" name = "pass2" placeholder = "パスワード">
			<input type = "submit" name = "edit" value = "編集"><br>
		</form>
	</body>
</html>

<?php

//通常投稿

if( empty($_POST["hidnum"]) && !empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass_given"])){
 
    $sql = $pdo -> prepare("INSERT INTO tbtestt (name, comment,pass) VALUES (:name, :comment,:pass)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':pass',$pass,PDO::PARAM_STR);
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $pass = $_POST["pass_given"];
    $sql -> execute();
    

//編集投稿

}elseif( !empty($_POST['hidnum']) && !empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass_given"])){

            $id=$_POST["hidnum"];
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $pass=$_POST["pass_given"];
            $sql = 'update tbtestt set name=:name,comment=:comment,pass=:pass where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':pass',$pass,PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

//削除機能

}elseif( !empty($_POST["delenum"]) && !empty($_POST["pass1"])){
    $sql = 'SELECT * FROM tbtestt';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach($results as $row){
        if($_POST["delenum"]==$row["id"] && $_POST["pass1"]==$row["pass"]){
            $id =$row["id"];
	        $sql = 'delete from tbtestt where id=:id';
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	        $stmt->execute();
    }
    }
}

    $sql = 'SELECT * FROM tbtestt';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach($results as $row){
		echo $row['id']."  ";
		echo $row['name']."さん、実は";
		echo $row['comment']."らしいよ。".'<br>';
	echo "<hr>";
	}

    //テーブル作成チェック
    //$sql ='SHOW TABLES';
    //$result = $pdo -> query($sql);
    //foreach ($result as $row){
     //echo $row[0];
     //echo '<br>';
    //}
    //echo "<hr>";
   