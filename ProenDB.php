<?php


class ProenDB{
    private $db;
    private $keyword;

    public function __construct(){
        $dsn = 'mysql:host=localhost;dbname=test;charset=utf8;unix_socket=/tmp/mysql.sock';
        $username = 'proen';
        $password = 'ProjectEnshu';
        $this->db = new PDO($dsn, $username, $password);
    }

    public function setKeyword($keyword){
        $this->keyword = $keyword;
    }


    public function getByKeyword(){
        $stmt = $this->db->prepare("SELECT keyword FROM search_count WHERE keyword = :keyword");
        $this->executeWithKeyword($stmt);

        $result = $stmt->fetch();
        return $result['keyword'];
    }

    public function insertKeyword(){
        $stmt = $this->db->prepare("INSERT INTO search_count (keyword) VALUES (:keyword)");
        $this->executeWithKeyword($stmt);
    }

    public function updateKeyCount(){
        $stmt = $this->db->prepare("UPDATE search_count SET scount = scount+1, updated_at = now() WHERE keyword = :keyword");
        $this->executeWithKeyword($stmt);
    }

    private function executeWithKeyword($stmt){
        $stmt->bindParam(':keyword', $this->keyword, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function showHotWord(){
        $stmt = $this->db->prepare("SELECT keyword FROM search_count ORDER BY scount LIMIT 0, 8;");
        $stmt->execute();
        $items = array();
        foreach ($stmt as $item){
            array_push($items, $item['keyword']);
        }
        if($items){
            $items = array_reverse($items);
            echo '<div class="hot_word"><p>人気ワード：</p>';
            echo '<ul>';
            foreach ($items as $key){
                $href = "?keyword=".$key;
                echo '<li><a href="'.$href.'">'.$key.'</a></li>';
            }
            echo '</ul></div>';
        }
    }
}
?>

