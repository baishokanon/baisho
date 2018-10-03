<?php
		//接続
		$dsn='データーベース名';
		$user='ユーザー名';
		$password='パスワード';
		$pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
		
		//テーブルの作成
		/*$sql="CREATE TABLE keijibann"
		."("
		."id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,"
		."name char(32),"
		."message TEXT,"
		."date DATETIME,"
		."password INT"
		.");";
		$stmt=$pdo->query($sql);*/
?>

<html>
<body>
	<?php
		$day=date("Y/m/d H:i:s");
		$name=$_POST["name"];
		$message=$_POST["message"];
		$password=$_POST["pass1"];
	//データを入力する
		$text=$_POST['text'];
		if(!(empty($text)) ){
			$sql="UPDATE keijibann SET name=:name,message=:message,date=:day,password=:password WHERE id=:text";
			$stmt=$pdo->prepare($sql);
			$stmt->bindParam(':name',$name,PDO::PARAM_STR);
			$stmt->bindParam(':message',$message,PDO::PARAM_STR);
			$stmt->bindParam(':day',$day,PDO::PARAM_STR);
			$stmt->bindParam(':password',$password,PDO::PARAM_STR);
			$stmt->bindParam(':text',$text,PDO::PARAM_STR);
			$stmt->execute();
		}
		elseif(!empty($_POST["name"])&&!empty($_POST["message"])&&!empty($_POST["pass1"])){
		$sql=$pdo->prepare("INSERT INTO keijibann(name,message,date,password)VALUES(:name,:message,:date,:password)");
		$sql->bindParam(':name',$name,PDO::PARAM_STR);
		$sql->bindParam(':message',$message,PDO::PARAM_STR);
		$sql->bindParam(':date',$day,PDO::PARAM_STR);
		$sql->bindParam(':password',$password,PDO::PARAM_STR);
		$sql->execute();
		}
	//削除機能
 		$delete=$_POST['delnum'];
		$pass2=$_POST['pass2'];
 		if(!(empty($delete))&&!(empty($pass2)) ){
			$sql="delete from keijibann where id=$delete and password=$pass2";
			$result=$pdo->query($sql);
		}
	//編集機能
		$edit=$_POST['editnum'];
		$pass3=$_POST['pass3'];
		if(!(empty($edit))&&!(empty($pass3)) ){
			$sql="SELECT*FROM keijibann where id=$edit";
			$results=$pdo->query($sql);
			foreach ($results as $row){
				if($edit==$row['id']){
				$edit_count=$row['id'];
				$edit_name=$row['name'];
				$edit_message=$row['message'];
				}
			}
		}
	?>
	<form action="mission_4.php" method="post">
		<p><input type="text" placeholder="名前" name="name" value="<?php echo $edit_name;?>"><br>
 		<input type="text" placeholder="コメント" name="message" value="<?php echo $edit_message;?>"><br>
 		<input type="text" name="text" value="<?php echo $edit_count;?>">
		<input type="password" placeholder="パスワード" name="pass1">
		<input type="submit"><p/>
 		<p><input type="text" placeholder="削除対象番号" name="delnum"><br>
		<input type="password" placeholder="パスワード" name="pass2">
		<input type="submit" value="削除"><p/>
		<p><input type="text" placeholder="編集対象番号" name="editnum"><br>
		<input type="password" placeholder="パスワード" name="pass3">
		<input type="submit" value="編集"><p/>
	</form>

	<?php
		$sql="SELECT*FROM keijibann order by id";
		$results=$pdo->query($sql);
		foreach($results as $row){
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['message'].',';
		echo $row['date'].',';
		echo $row['password'].'<br>';
		}
	?>
	