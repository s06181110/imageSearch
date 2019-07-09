<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>集合写真検索システム</title>
</head>
<body>
  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <p>
      検索キーワード：<input type="text" name="keyword" size=20/><br>
      条件を選択：
      <select name = "term">
        <option value="">選択してください</option>
        <option value="1">のみ</option>
        <option value="2">以上</option>
        <option value="3">以下</option>
        <option value="4">から</option>
      </select>
      <input type="text" name="number" size=5/>・・・
      <input type="text" name="number2" size=5/><br>
      *~からの場合範囲を指定してください*

      <?php
      /*
      if($_POST["term"] == '1'){
        echo ("<input type='text' name='number' size='5' />のみ");
      }else if($_POST["term"] == '2'){
        echo ("<input type='text' name='number' size='5' />以上 ");
      }else if($_POST["term"] == '3'){
        echo ("<input type='text' name='number' size='5' />以下 ");
      }else if($_POST["term"] == '4'){
        echo ("<input type='text' name='number' size='5' />から ");
        echo ("<input type='text' name='number2' size='5' />まで ");
      }
      */
      ?>

      <input type="submit" value="Search!" />
    </p>
  </form>





  <?php

  // tfファイルの読み込み　１行ずつ　最後まで
  $tf_data = array( array());
  $tffile = "tfimg.all";
  $f1 = fopen($tffile, "r");
  while (! feof ($f1)) {
    $line = fgets($f1);
    $tf_line = preg_split( "/\t/" , $line );
    @$tf_line[2] = preg_replace("/\r|\n/","",$tf_line[2]);
    @$tf_data[$tf_line[0]][$tf_line[2]] = $tf_line[1];
  }
  fclose($f1);
  // tfファイルの読み込み　ここまで


  // fcファイルの読み込み　１行ずつ　最後まで
  $fc_data = array();
  $fcfile = "fcimg.all";
  $f2 = fopen($fcfile, "r");
  while (! feof ($f2)) {
    $line = fgets($f2);
    $fc_line = preg_split( "/\t/" , $line );
    @$fc_line[1] = preg_replace("/\r|\n/","",$fc_line[1]);
    $fc_data[$fc_line[1]] = $fc_line[0];
  }
  fclose($f2);
  // fcファイルの読み込み　ここまで

  // 以下、検索処理
  $result_num = 0;
  $_POST["number"] = mb_convert_kana($_POST["number"], "n", "utf-8");
  if (isset($_POST["keyword"]) && isset($_POST["number"])) {
    if(array_key_exists($_POST["keyword"], $tf_data)){

      if ($_POST["number"]==null || !preg_match("/^[0-9]+$/", $_POST["number"])) {
        echo "人数を正しく入力して下さい。";
      } else if($_POST["term"]==1){
        echo "キーワード「".$_POST["keyword"]."」　人数「";
        echo $_POST["number"]."人」での検索結果<br>\n";
      } else if($_POST["term"]==2){
        echo "キーワード「".$_POST["keyword"]."」　人数「";
        echo $_POST["number"]."人」以上の検索結果<br>\n";
      }else if($_POST["term"]==3){
        echo "キーワード「".$_POST["keyword"]."」　人数「";
        echo $_POST["number"]."人」以下の検索結果<br>\n";
      }else if($_POST["term"]==4){
        echo "キーワード「".$_POST["keyword"]."」　人数「";
        echo $_POST["number"]."人から".$_POST["number2"]."人」での検索結果<br>\n";
      }
      echo "<hr><br>\n";

      if($_POST["term"]==1){//のみ
        foreach($tf_data[@$_POST["keyword"]] as $key => $val ) {
          if (@$_POST["number"] == @$fc_data[$key] && @$_POST["number"]<>null){
            echo "<img src='$key'><br>\n";
            echo "キーワード出現回数＝".$val."回<br>\n";
            echo "写真中の人の数＝".@$fc_data[$key]."人<br>\n";
            echo "$key<br><br><br>\n";
            $result_num++;
          }
        }
      }
      if($_POST["term"]==2){//以上
        foreach($tf_data[@$_POST["keyword"]] as $key => $val ) {
          for($i = $_POST["number"];$i <= 50;$i++){
            if (@$i == @$fc_data[$key] && @$i<>null){
              echo "<img src='$key'><br>\n";
              echo "キーワード出現回数＝".$val."回<br>\n";
              echo "写真中の人の数＝".@$fc_data[$key]."人<br>\n";
              echo "$key<br><br><br>\n";
              $result_num++;
            }
          }
        }
      }

      if($_POST["term"]==3){//以下
        foreach($tf_data[@$_POST["keyword"]] as $key => $val ) {
          for($i = $_POST["number"];$i > 0;$i--){
            if (@$i == @$fc_data[$key] && @$i<>null){
              echo "<img src='$key'><br>\n";
              echo "キーワード出現回数＝".$val."回<br>\n";
              echo "写真中の人の数＝".@$fc_data[$key]."人<br>\n";
              echo "$key<br><br><br>\n";
              $result_num++;
            }
          }
        }
      }
      if($_POST["term"]==4){//から・まで
        $min = $_POST["number"];
        $max = $_POST["number2"];
        if($max < $min){
          $min = $_POST["number2"];
          $max = $_POST["number"];
        }
        foreach($tf_data[@$_POST["keyword"]] as $key => $val ) {
          for($i = $min;$min <= $max;$i++){
            if (@$i == @$fc_data[$key] && @$i<>null){
              echo "<img src='$key'><br>\n";
              echo "キーワード出現回数＝".$val."回<br>\n";
              echo "写真中の人の数＝".@$fc_data[$key]."人<br>\n";
              echo "$key<br><br><br>\n";
              $result_num++;
            }
          }
        }
      }

    } elseif (@$_POST["keyword"]==null) {
      echo '検索キーワードを入力して下さい。';
    } else {
      echo '検索キーワードに合致する写真はありません。';
    }
  }

  echo "検索結果は".$result_num."件でした。";

  ?>
</body>
</html>
