<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>集合写真検索システム</title>
    <link rel ="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
<header>
    <a class="link" href="toppage.php"><h1>人物写真検索システム</h1></a>
</header>
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
echo '<br><div class="font_size slide-bottom">検索結果は'.$result_num.'件でした。</div>';
?>
<script src="./jquery-fadethis-master/dist/jquery.fadethis.min.js"></script>
<script>
$(window).fadeThis();

$(function(){
    $('.js-modal-open').each(function(){
        $(this).on('click',function(){
            var target = $(this).data('target');
            var modal = document.getElementById(target);
            $(modal).fadeIn();
            return false;
        });
    });
    $('.js-modal-close').on('click',function(){
        $('.js-modal').fadeOut();
        return false;
    });
});

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
<footer>
    <p>Copyright 2019 by G007</p>
</footer>
</html>


