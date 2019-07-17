<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>集合写真検索システム</title>
    <link rel ="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<?php
//require 'ProenDB.php';
require 'form.php'
?>

<?php
//$db = new ProenDB();
//$db->showHotWord();
//?>

<?php
require 'read.php';
$tf_data = tf_read();
$fc_data = fc_read();
?>

<?php
require 'search.php';
$result_num = search_result($tf_data, $fc_data);
echo "<br>";
echo '<div class="font_size slide-left slide-top">';
echo "検索結果は".$result_num."件でした。";
echo "</div>";
?>
<script src="./jquery-fadethis-master/dist/jquery.fadethis.min.js"></script>
<script>
$(window).fadeThis();
</script>
<a href="toppage.php" class="link">>>トップへ</a>
</body>
</html>
