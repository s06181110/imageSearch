<?php

function search_result($tf_data, $fc_data){
    $result_num = 0;
    if (isset($_POST["keyword"]) && isset($_POST["number"])) {
        if(array_key_exists($_POST["keyword"], $tf_data)){
            if ($_POST["number"]==null || !preg_match("/^[0-9]+$/", $_POST["number"])) {
                echo search_message('person_num_error');
            } elseif($_POST['term']=='only'){
                echo search_message('only');
            } elseif($_POST['term']=='more'){
                echo search_message('more');
              echo "</div>";
            } elseif($_POST['term']=='less'){
                echo search_message('less');
            } elseif($_POST['term']=='from_to'){
              if($_POST["number2"]==null || !preg_match("/^[0-9]+$/", $_POST["number2"])){
                  echo search_message('person_num_error');
              } else {
                  echo search_message('from_to');
              }
            }
          }
            echo "<hr><br>\n";

            if($_POST['term']=='only'){
            arsort($tf_data[@$_POST["keyword"]]);
            foreach($tf_data[@$_POST["keyword"]] as $key => $val ) {
                if (@$_POST["number"] == @$fc_data[$key] && @$_POST["number"]<>null){
                    echo "<div class=\"p_box\">\n";
                    echo "<a href='$key'><img src='$key' alt=''></a><br>\n";
                    echo "<ul>\n";
                    echo "<li class=\"tag_area\">"."キーワード:".$val."回</li>\n";
                    echo "<li class=\"title_area\">"."人数:".$fc_data[$key]."人</li>\n";
                    echo "</ul>\n";
                    echo "</div>\n";
                    $result_num++;
                }
            }
          }
          if($_POST['term']=='more'){//以上
            arsort($tf_data[@$_POST['keyword']]);
            foreach($tf_data[@$_POST['keyword']] as $key => $val ) {
              for($i = $_POST['number'];$i <= 50;$i++){
                if (@$i == @$fc_data[$key] && @$i<>null){
                  echo "<div class=\"p_box\">\n";
                  echo "<a href='$key'><img src='$key' alt=''></a><br>\n";
                  echo "<ul>\n";
                  echo "<li class=\"tag_area\">"."キーワード:".$val."回</li>\n";
                  echo "<li class=\"title_area\">"."人数:".$fc_data[$key]."人</li>\n";
                  echo "</ul>\n";
                  echo "</div>\n";
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
                  echo "<div class=\"p_box\">\n";
                  echo "<a href='$key'><img src='$key' alt=''></a><br>\n";
                  echo "<ul>\n";
                  echo "<li class=\"tag_area\">"."キーワード:".$val."回</li>\n";
                  echo "<li class=\"title_area\">"."人数:".$fc_data[$key]."人</li>\n";
                  echo "</ul>\n";
                  echo "</div>\n";
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
                      echo "<div class=\"p_box\">\n";
                      echo "<a href='$key'><img src='$key' alt=''></a><br>\n";
                      echo "<ul>\n";
                      echo "<li class=\"tag_area\">"."キーワード:".$val."回</li>\n";
                      echo "<li class=\"title_area\">"."人数:".$fc_data[$key]."人</li>\n";
                      echo "</ul>\n";
                      echo "</div>\n";
                      $result_num++;
                    }
                  }
                }
              }
            }
          }

        } elseif (@$_POST["keyword"]==null) {
            echo "<div class=\"font_size\">\n";
            echo '検索キーワードを入力して下さい。';
            echo "</div>";
        } else {
            echo "<div class=\"font_size\">\n";
            echo '検索キーワードに合致する写真はありません。';
            echo "</div>";
        }
    return $result_num;
}

function search_message($key){
    // $messageを見やすくするための変数
    $keyword_template = "キーワード「".$_POST['keyword']."」　人数「".$_POST['number']."人」";
    //　キーによって返すメッセージを変更する
    $message = [
        'person_num_error'=>'<div class="font_size">人数を正しく入力して下さい。</div>',
        'only'=>'<div class="font_size">'.$keyword_template.'での検索結果<br></div>',
        'more'=>'<div class="font_size">'.$keyword_template.'以上の検索結果<br></div>',
        'less'=>'<div class="font_size">'.$keyword_template.'以下の検索結果<br></div>',
        'from_to'=>'<div class="font_size">'.$keyword_template.'から「'.$_POST['number2'].'人」の検索結果<br></div>',
    ];

    return $message[$key];
}
