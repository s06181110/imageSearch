<?php
$option_data = ['only'=>'のみ',
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
    <label>条件を選択：<input type="text" name="number" size=5/></label>
    <select name="term" id="term">
        <?php echo $option_data; ?>
    </select>

    <script>
        $(function () {
            $('#term').change(function () {
                const val = $(this).val();
                if (val === "from_to") {
                    $('#term').after('<label><input type="text" name="number2" size="5" id="second_input" /></label>');
                } else {
                    $('#second_input').remove();
                }
            })
        })
    </script>

    <input type="submit" value="Search!" />
</form>



<?php $_POST["number"] = mb_convert_kana($_POST["number"], "n", "utf-8"); ?>
