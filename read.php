<?php

// tfファイルの読み込み　１行ずつ　最後まで
function tf_read(){
    $tf_data = array(array());
    $tffile = "tfimg.all";
    $f1 = fopen($tffile, "r");
    while (!feof($f1)) {
        $line = fgets($f1);
        $tf_line = preg_split("/\t/", $line);
        @$tf_line[2] = preg_replace("/\r|\n/", "", $tf_line[2]);
        @$tf_data[$tf_line[0]][$tf_line[2]] = $tf_line[1];
    }
    fclose($f1);
    return $tf_data;
}
// tfファイルの読み込み　ここまで

// fcファイルの読み込み　１行ずつ　最後まで
function fc_read(){
    $fc_data = array();
    $fcfile = "fcimg.all";
    $f2 = fopen($fcfile, "r");
    while (!feof($f2)) {
        $line = fgets($f2);
        $fc_line = preg_split("/\t/", $line);
        @$fc_line[1] = preg_replace("/\r|\n/", "", $fc_line[1]);
        $fc_data[$fc_line[1]] = $fc_line[0];
    }
    fclose($f2);
    return $fc_data;
}
// fcファイルの読み込み　ここまで
