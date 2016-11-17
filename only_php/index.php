<?php 
    //セッションの設定
    session_start();
    require('../dbconnect.php');

    //書く入力欄のvalueの初期値を定義
    $nick_name =''; 
    $email ='';
    $password='';

    //フォームからデータが送信された場合
    if(!empty($_POST)){
      $nick_name=$_POST['nick_name'];
      $email=$_POST['email'];
      $password=$_POST['password'];




      //ニックネームの未入力チェック
      if($_POST['nick_name']==''){
          $error['nick_name']='blank';
      }

       //emailの未入力チェック
      if($_POST['email']==''){
          $error['email']='blank';
      }

       //passwordの未入力チェック
      if($_POST['password']==''){
         $error['password']='blank';
      } elseif (strlen($_POST['password']) < 4) {
        $error['password']='length';
      }

      //画像ファイルの拡張子チェック
      $fileName=$_FILES['picture_path']['name'];
      //echo $fileName;
      //$_FILES['inputタグのname']['$_FILES内で決められたキー']
      if(!empty($fileName)){
        $ext=substr($fileName,-3);
        if($ext !='jpg'&&$ext !='gif'&&$ext !='png'){

          $error['picture_path']='type';
        }
      }

     //メールアドレスの重複チェック
      if (empty($error)) {

        $sql=sprintf('SELECT COUNT(*) AS cnt FROM `members` WHERE `email`="%s"',mysqli_real_escape_string($db,$email));
      // p246のコード:重複件数をカウント
        $record=mysqli_query($db,$sql) or die(mysqli_error($db));
        $table=mysqli_fetch_assoc($record);//mysqli_fetch_assocってなんぞや
        if($table['cnt']>0)
        {
          $error['email']='duplicate';
          var_dump($error);
        }
      // p247のコード (ifの条件、今までのコードと合わせる必要あり)

      // HTMLテンプレートと統合する (上級者課題)


        
         }


 
    //エラーがなかった場合の処理
    if(empty($error)){
      //画像をアップロードする
      $picture_path= date('YmdHis').$_FILES['picture_path']['name'];
      move_uploaded_file($_FILES['picture_path']['tmp_name'],'../member_picture/' .$picture_path);

      //セッションに値を保存します
      $_SESSION['join']=$_POST;
      $_SESSION['join']['picture_path']=$picture_path;
      header('Location: check.php');
      exit();

    }

    }


    //書き直し処理
    if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'rewrite') {
      $_POST=$_SESSION['join'];
      $nick_name=$_POST['nick_name'];
      $email=$_POST['email'];
      $password=$_POST['password'];

      $error['rewrite']=true;
    }
 ?>

<!--input type="file"を使用する場合はformタグにenctypeの指定が必要$_FILESが生成される条件は
１：enctypeが指定される
２：input type='file'がある-->


<FORM method="post" action="index.php" enctype="multipart/form-data">
  <input type="text" name="nick_name" value="<?php echo $nick_name; ?>"><br>
  <?php if(isset($error['nick_name'])&&$error['nick_name']=='blank'): ?>
    <p style="color: red;">*ニックネームを入力してください</p>
  <?php endif; ?>

  <input type="email" name="email" value="<?php echo $email; ?>"><br>
  <?php if(isset($error['email'])&&$error['email']=='blank'): ?>
    <p style="color: red;">*メールアドレスを入力してください</p>
  <?php endif; ?>

  <?php if(isset($error['email'])&&$error['email']=='duplicate') :?>
    <p style="color: red;">*指定されたアドレスはすでに登録されています。</p>
  <?php endif; ?> 

  <input type="password" name="password" value="<?php echo $password; ?>"><br>
  <?php if(isset($error['password'])&&$error['password']=='blank'): ?>
  <p style="color: red;">*パスワードを入力してください</p>
  <?php endif; ?>

  <?php if(isset($error['password'])&&$error['password']=='length'): ?>
  <p style="color: red;">*パスワードは4文字以上で入力してください</p>
  <?php endif; ?>

  <input type="file" name="picture_path"><br>
  <?php if(isset($error['picture_path'])&&$error['picture_path']=='type'): ?>
  <p style="color: red;">*画像は「jpg」「png」「gif」の画像を指定してください</p>
  <?php endif; ?>

  <?php if(!empty($error)): ?>
  <p style="color: red;">*画像を再度選択してください</p>
  <?php endif; ?>


  <input type="submit" value="確認画面へ">
</FORM>