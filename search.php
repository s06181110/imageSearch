<?php
function search_result($tf_data, $fc_data){
    $result_num = 0;
    if (isset($_POST["keyword"]) && isset($_POST["number"])) {
        if(array_key_exists($_POST["keyword"], $tf_data)){
            if ($_POST["number"]==null || !preg_match("/^[0-9]+$/", $_POST["number"])) {
                echo "人数を正しく入力して下さい。";
            } elseif($_POST['term']=='only'){
              echo "キーワード「".$_POST['keyword']."」　人数「";
              echo $_POST['number']."人」での検索結果<br>\n";
            } elseif($_POST['term']=='more'){
              echo "キーワード「".$_POST['keyword']."」　人数「";
              echo $_POST['number']."人」以上の検索結果<br>\n";
            } elseif($_POST['term']=='less'){
              echo "キーワード「".$_POST['keyword']."」　人数「";
              echo $_POST['number']."人」以下の検索結果<br>\n";
            } elseif($_POST['term']=='from_to'){
              if(!$_POST["number2"]==null || preg_match("/^[0-9]+$/", $_POST["number2"])){
                echo "キーワード「".$_POST['keyword']."」　人数「";
                echo $_POST['number']."人から".$_POST['number2']."人」での検索結果<br>\n";
              } else {
              echo "人数の範囲を入力してください。<br>\n";
            }
          }
            echo "<hr><br>\n";

            if($_POST['term']=='only'){
            arsort($tf_data[@$_POST["keyword"]]);
            foreach($tf_data[@$_POST["keyword"]] as $key => $val ) {
                if (@$_POST["number"] == @$fc_data[$key] && @$_POST["number"]<>null){
                    echo "<a href='$key'><img src='$key' alt=''></a><br>\n";
                    echo "キーワード出現回数＝".$val."回<br>\n";
                    echo "写真中の人の数＝".@$fc_data[$key]."人<br>\n";
                    echo "$key<br><br><br>\n";
                    $result_num++;
                }
            }
          }
          if($_POST['term']=='more'){//以上
            arsort($tf_data[@$_POST['keyword']]);
            foreach($tf_data[@$_POST['keyword']] as $key => $val ) {
              for($i = $_POST['number'];$i <= 50;$i++){
                if (@$i == @$fc_data[$key] && @$i<>null){
                  echo "<a herf='$key'><img src='$key' alt=''></a><br>\n";
                  echo "キーワード出現回数＝".$val."回<br>\n";
                  echo "写真中の人の数＝".@$fc_data[$key]."人<br>\n";
                  echo "$key<br><br><br>\n";
                  $result_num++;
                }
              }
            }
          }
          if($_POST['term']=='less'){//以下
            arsort($tf_data[@$_POST['keyword']]);
            foreach($tf_data[@$_POST['keyword']] as $key => $val ) {
              for($i = $_POST['number'];$i > 0;$i--){
                if (@$i == @$fc_data[$key] && @$i<>null){
                  echo "<a herf='$key'><img src='$key' alt=''></a><br>\n";
                  echo "キーワード出現回数＝".$val."回<br>\n";
                  echo "写真中の人の数＝".@$fc_data[$key]."人<br>\n";
                  echo "$key<br><br><br>\n";
                  $result_num++;
                }
              }
            }
          }
          if(!$_POST["number"]==null || preg_match("/^[0-9]+$/", $_POST["number"])){
            if(!$_POST["number2"]==null || preg_match("/^[0-9]+$/", $_POST["number2"])){
              if($_POST['term']=='from_to'){//から・まで
                $min = $_POST['number'];
                $max = $_POST['number2'];
                arsort($tf_data[@$_POST['keyword']]);
                foreach($tf_data[@$_POST['keyword']] as $key => $val ) {
                  for($i = $min;$i <= $max;$i++){
                    if (@$i == @$fc_data[$key] && @$i<>null){
                      echo "<a herf='$key'><img src='$key' alt=''></a><br>\n";
                      echo "キーワード出現回数＝".$val."回<br>\n";
                      echo "写真中の人の数＝".@$fc_data[$key]."人<br>\n";
                      echo "$key<br><br><br>\n";
                      $result_num++;
                    }
                  }
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
    return $result_num;
}
