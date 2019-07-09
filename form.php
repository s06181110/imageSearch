<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <p>
        検索キーワード：<input type="text" name="keyword" size=20/><br>
        条件を選択：
        <select name = "term">
            <option value="">選択してください</option>
            <option value="1">のみ</option>
            <option value="2">以上</option>
            <option value="3">以下</option>
            <option value="4">から</option>
        </select>
        <input type="text" name="number" size=5/>・・・
        <input type="text" name="number2" size=5/><br>
        *~からの場合範囲を指定してください* 
        <input type="submit" value="Search!" />
    </p>
</form>

<?php $_POST["number"] = mb_convert_kana($_POST["number"], "n", "utf-8"); ?>
