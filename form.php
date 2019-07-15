<?php
$option_data = [
    'none'=>"指定しない",
    'only'=>'のみ',
    'more'=>'以上',
    'less'=>'以下',
    'from_to'=>'から'
];

foreach($option_data as $option_data_key =>  $option_data_value){
    $option_data .= "<option value='".$option_data_key;
    $option_data .= "'>".$option_data_value."</option>";
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <label>検索キーワード：<input type="text" name="keyword" size=20/></label>
    <label><input type="radio" name="match_type" value="complete" checked>完全一致</label>
    <label><input type="radio" name="match_type" value="partial">部分一致</label>
    <br>
    <label>人数：<select name="term" id="term"><?php echo $option_data; ?></select></label>

    <script>
        $(function () {
            $('#term').change(function () {
                const val = $(this).val();
                if (val === "none") {
                    $('#from').remove();
                } else {
                    $('#from').remove();
                    $('#term').before('<label><input type="text" name="number" id="from" size=5 /></label>');
                }
                if (val === "from_to") {
                    $('#term').after('<label><input type="text" name="number2" size="5" id="second_input" /></label>');
                } else {
                    $('#second_input').remove();
                }
            })
        })
    </script>

    <input type="submit" name="send" value="Search!" />
</form>
