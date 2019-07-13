<?php

function search_result($tf_data, $fc_data){
    if(!isset($_POST["keyword"]) || @$_POST["keyword"] === ""){ message_print('keyword_error'); return 0; }
    if(!isset($_POST["number"])  || @$_POST["number"] === "") { message_print('number_error'); return 0;}
    $result_num = 0;
    $keyword = $_POST["keyword"];
    $number = $_POST["number"];
    $number2 = isset($_POST["number2"]) ? $_POST["number2"] : null;

    if(array_key_exists($keyword, $tf_data)){
        if (is_invalid_number($_POST['number'])) {
            message_print('number_error');
        } else {
            switch ($_POST['term']){
                case 'only':
                    message_print('only');
                    break;
                case 'more':
                    message_print('more');
                    break;
                case 'less':
                    message_print('more');
                    break;
                case 'from_to':
                    if (is_invalid_number($number2)) message_print('number_error');
                    else message_print('from_to');
                    break;
            }
        }
    }else{
        message_print('photo_is_none');
        return 0;
    }

    if($_POST['term']=='only'){
        arsort($tf_data[@$keyword]);
        foreach($tf_data[@$keyword] as $key => $val ) {
            if (@$number == @$fc_data[$key] && @$number<>null){
                print_photo($key, $val, $fc_data[$key]);
                $result_num++;
            }
        }
    }
    if($_POST['term']=='more'){//以上
        arsort($tf_data[@$_POST['keyword']]);
        foreach($tf_data[@$_POST['keyword']] as $key => $val ) {
            for($i = $_POST['number'];$i <= 50;$i++){
                if (@$i == @$fc_data[$key] && @$i<>null){
                    print_photo($key, $val, $fc_data[$key]);
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
                    print_photo($key, $val, $fc_data[$key]);
                    $result_num++;
                }
            }
        }
    }
    if($_POST['term']=='from_to'){//から・まで
        arsort($tf_data[@$_POST['keyword']]);
        foreach($tf_data[@$_POST['keyword']] as $key => $val ) {
            for($i = $number;$i <= $number2;$i++){
                if (@$i == @$fc_data[$key] && @$i<>null){
                    print_photo($key, $val, $fc_data[$key]);
                    $result_num++;
                }
            }
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

function message_print($key){
    // $messageを見やすくするための変数
    $keyword_template = "キーワード「".$_POST['keyword']."」　人数「".$_POST['number']."人」";
    //　キーによって返すメッセージを変更する
    $message = [
        'keyword_error'=>'<div class="font_size">検索キーワードを入力して下さい。</div>',
        'number_error'=>'<div class="font_size">人数を正しく入力して下さい。</div>',
        'photo_is_none'=>'<div class="font_size">検索キーワードに合致する写真はありません。</div>',
        'only'=>'<div class="font_size">'.$keyword_template.'での検索結果<br></div>',
        'more'=>'<div class="font_size">'.$keyword_template.'以上の検索結果<br></div>',
        'less'=>'<div class="font_size">'.$keyword_template.'以下の検索結果<br></div>',
        'from_to'=>'<div class="font_size">'.$keyword_template.'から「'.$_POST['number2'].'人」の検索結果<br></div>',
    ];

    echo $message[$key];
    echo "<hr><br>\n";
}

function print_photo($key, $val, $data){
    echo "<div class=\"p_box\">\n";
    echo "<a href='$key'><img src='$key' alt=''></a><br>\n";
    echo "<ul>\n";
    echo "<li class=\"tag_area\">"."キーワード:".$val."回</li>\n";
    echo "<li class=\"title_area\">"."人数:".$data."人</li>\n";
    echo "</ul>\n";
    echo "</div>\n";
}
