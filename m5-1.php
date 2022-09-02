<?php
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $dbpassword = 'パスワード';
    $pdo = new PDO($dsn, $user, $dbpassword, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブル作成
    $sql = "CREATE TABLE IF NOT EXISTS keijiban"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "time TEXT,"
    . "pass char(32)"
    .");";
    $stmt = $pdo->query($sql);
?>
<?PHP
//編集機能
$date=date("Y/m/d H:i:s");

            

    if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["hensyusitei"]) && !empty($_POST["pass"])){

    $id = $_POST["hensyusitei"]; //変更する投稿番号
    $name = $_POST["name"];
    $comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
    $pass=$_POST["pass"];
    $time=$date;
    $sql = 'UPDATE keijiban SET name=:name,comment=:comment,time=:time,pass=:pass WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':time', $time, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    

    }
    //投稿機能

elseif(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"])){
    $name1 = $_POST["name"];
    $comment1 = $_POST["comment"]; 
    $pas= $_POST["pass"];
    
    $sql = $pdo -> prepare("INSERT INTO keijiban (name, comment, time, pass) VALUES (:name, :comment, :time, :pass)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':time', $time, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
    $name = $name1;
    $comment = $comment1;
    $time=$date;
    $pass = $pas;
    $sql -> execute();
    
}

//編集が押されたとき
if (!empty($_POST["hensyu"])&&!empty($_POST["pass2"])) {
 $hensyu= $_POST["hensyu"];
 $pass = $_POST["pass2"];
 $newname="";
 $newcomment="";
 $id2 = "";
 
 $sql = 'SELECT * FROM keijiban';
 $stmt = $pdo->query($sql);
 $results = $stmt->fetchAll();
 
 foreach ($results as $row){
        if($hensyu == $row['id']){
            if($pass == $row['pass']){
                $newname = $row['name'];
                $newcomment = $row['comment'];
                $id2 = $row['id'];  
            }
        }
    }
}
    //削除機能

    
if(!empty($_POST["delnumber"]) && !empty($_POST["pass1"])){
            $id = $_POST["delnumber"];
            $pass = $_POST["pass1"];
            $sql = 'delete from keijiban WHERE id=:id && pass=:pass';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
            $stmt->execute();
}    

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>mission_5-1</title>
</head>
<body>
<form action=""   method="post">
<input type="text" name="name" placeholder="名前" value="<?php if(!empty($_POST["hensyu"])){echo $newname;}?>">
<br>
<input type="text" name="comment" placeholder="コメント" value="<?php if(!empty($_POST["hensyu"])){echo $newcomment;}?>">
<br>
<input type="text" name="pass" placeholder="パスワード" >
<?php echo"　";
?>
<input type="submit" name="submit">
<br>
<br>
<input type="hidden" name="hensyusitei" value="<?php if(!empty($_POST["hensyu"])){echo $id2;}?>">
<br>
</form>

<form action-"" method= "post">
<input type="number" name="delnumber" placeholder="削除対象番号">
<br>
<input type="text" name="pass1" placeholder="パスワード">
<?php echo"　";
?>
<input type="submit" value="削除">
<br>
<br>
</form>

<form action="" method="post">
<input type="number" name="hensyu" placeholder="編集対象番号">
<br>
<input type="text" name="pass2" placeholder="パスワード">
<?php echo"　";
?>
<input type="submit" value="編集">
<br>
</form>
</body>
</html>
<?php
   $sql = 'SELECT * FROM keijiban';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['time'].'<br>';
    echo "<hr>";
    }
?>