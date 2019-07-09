<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>集合写真検索システム</title>
</head>
<body>
<?php require 'form.php'?>

<?php
require 'read.php';
$tf_data = tf_read();
$fc_data = fc_read();

$result_num = 0;
if (isset($_POST["keyword"]) && isset($_POST["number"])) {
    if(array_key_exists($_POST["keyword"], $tf_data)){

        if ($_POST["number"]==null || !preg_match("/^[0-9]+$/", $_POST["number"])) {
            echo "人数を正しく入力して下さい。";
        } else {
            echo "キーワード「".$_POST["keyword"]."」　人数「";
            echo $_POST["number"]."人」での検索結果<br>\n";
        }
        echo "<hr><br>\n";

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
  