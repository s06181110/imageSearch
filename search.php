<?php

function search_result($tf_data, $fc_data){
    $keyword = null;
    $number = null;
    $number2 = null;
    $match_type = null;
    if(isset($_GET["keyword"])) {
        $keyword = $_GET["keyword"];
        $_POST['term'] = "none";
        $match_type = "complete";
    } elseif(!isset($_POST["keyword"]) || @$_POST["keyword"] === "" ){
        message_print('keyword_error');
        return 0;
    } else {
        $keyword = $_POST["keyword"];
        $number = isset($_POST["number"]) ? mb_convert_kana($_POST["number"], "n", "utf-8") : "";
        $number2 = isset($_POST["number2"]) ? mb_convert_kana($_POST["number2"], "n", "utf-8") : "";
        $match_type = $_POST["match_type"];
    }

    if(!array_key_exists($keyword, $tf_data)){
        message_print('photo_is_none');
        return 0;
    }

    if (is_invalid_number($number) && isset($_POST["number"])) { // 送信されているのに有効でない
        message_print('number_error');
        return 0;
    } else { //　OK
        switch ($_POST['term']){
            case 'none':
                message_print('none', $keyword);
                break;
            case 'only':
                message_print('only', $keyword);
                break;
            case 'more':
                message_print('more', $keyword);
                break;
            case 'less':
                message_print('more', $keyword);
                break;
            case 'from_to':
                if (is_invalid_number($number2)) message_print('number_error');
                else message_print('from_to', $keyword);
                break;
        }
    }

//    $db = new ProenDB($keyword);
//    if($db->getByKeyword()){
//        $db->updateKeyCount();
//    }else{
//        $db->insertKeyword();
//    }

    arsort($tf_data[@$keyword]);
    $result_num = 0;
    if($match_type == "complete"){      //完全一致
        $result_num = image_output($tf_data, $fc_data, $keyword, $number, $number2);
    }else if($match_type == "partial"){ //部分一致
        $tf_keys = array_keys($tf_data);
        $pattern = "/".$keyword."/";
        $target_keys = preg_grep($pattern, $tf_keys);
        foreach ($target_keys as $target_key){
            $result_num = image_output($tf_data, $fc_data, $target_key, $number, $number2);
        }
    }

    return $result_num;
}

// numberは不正である
function is_invalid_number($number){
    $invalid = false;
    // 何もない または 数値でないのは正しくない -> invalid : true
    if ($number==="" || !preg_match("/^[0-9]+$/", $number)) $invalid = true;
    return $invalid;
}

function message_print($key, $keyword = null){
    // $messageを見やすくするための変数
    $keyword_template = "キーワード「".$keyword."」　人数「".$_POST["number"]."人」";
    //　キーによって返すメッセージを変更する
    $message = [
        'keyword_error'=>'<div class="font_size">検索キーワードを入力して下さい。</div>',
        'number_error'=>'<div class="font_size">人数を正しく入力して下さい。</div>',
        'photo_is_none'=>'<div class="font_size">検索キーワードに合致する写真はありません。</div>',
        'none'=>'<div class="font_size">キーワード「'.$keyword.'」での検索結果<br></div>',
        'only'=>'<div class="font_size">'.$keyword_template.'での検索結果<br></div>',
        'more'=>'<div class="font_size">'.$keyword_template.'以上の検索結果<br></div>',
        'less'=>'<div class="font_size">'.$keyword_template.'以下の検索結果<br></div>',
        'from_to'=>'<div class="font_size">'.$keyword_template.'から「'.$_POST['number2'].'人」の検索結果<br></div>',
    ];

    echo $message[$key];
}

function image_output($tf_data, $fc_data,  $keyword, $number, $number2){
    $result_num = 0;
    if($_POST['term']=='none') {
        foreach ($tf_data[$keyword] as $key => $val) {
            print_photo($key, $val, $fc_data[$key]);
            $result_num++;
        }
    }
    if($_POST['term']=='only'){
        foreach($tf_data[$keyword] as $key => $val ) {
            if ($number == @$fc_data[$key]){
                print_photo($key, $val, $fc_data[$key]);
                $result_num++;
            }
        }
    }
    if($_POST['term']=='more'){//以上
        foreach($tf_data[$keyword] as $key => $val ) {
            for($i = $number; $i <= 50; $i++){
                if (@$i == @$fc_data[$key]){
                    print_photo($key, $val, $fc_data[$key]);
                    $result_num++;
                }
            }
        }
    }
    if($_POST['term']=='less'){//以下
        foreach($tf_data[$keyword] as $key => $val ) {
            for($i = $number; $i > 0; $i--){
                if (@$i == @$fc_data[$key]){
                    print_photo($key, $val, $fc_data[$key]);
                    $result_num++;
                }
            }
        }
    }
    if($_POST['term']=='from_to'){//から・まで
        foreach($tf_data[$keyword] as $key => $val ) {
            for($i = $number; $i <= $number2; $i++){
                if (@$i == @$fc_data[$key]){
                    print_photo($key, $val, $fc_data[$key]);
                    $result_num++;
                }
            }
        }
    }
    return $result_num;
}

function print_photo($key, $val, $data){
    echo '<div class="p_box slide-bottom" data-plugin-options=\'{"reverse":false}\'';
    echo "<a href='$key'><img src='$key' alt=''></a><br>\n";
    echo "<ul>\n";
    echo "<li class=\"tag_area\">"."キーワード:".$val."回</li>\n";
    if ($data != null) echo "<li class=\"title_area\">"."人数:".$data."人</li>\n";
    else echo "<li class=\"title_area\">人数不明</li>\n";
    echo "</ul>\n";
    echo "</div></div>\n";
}

