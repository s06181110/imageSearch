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
    <p>
        検索キーワード：<input type="text" name="keyword" size=20/><br>
        条件を選択：
        <input type="text" name="number" size=5/>
        <select name="term" id="term">
            <?php echo $option_data; ?>
        </select>
        <input type="text" name="number2" size="5" id="second_input">
        <script>
            $('#second_input').hide();
            $(function () {
                $('#term').change(function () {
                    var val = $(this).val();
                    if (val == "from_to")  $('#second_input').show();
                    else $('#second_input').hide();
                })
            })
        </script>

        <input type="submit" value="Search!" />
    </p>
</form>



<?php $_POST["number"] = mb_convert_kana($_POST["number"], "n", "utf-8"); ?>
