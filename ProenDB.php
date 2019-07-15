<?php


class ProenDB{
    private $db;
    private $keyword;

    public function __construct($keyword=null){
        $dsn = 'mysql:host=localhost;dbname=test;charset=utf8;unix_socket=/tmp/mysql.sock';
        $username = 'proen';
        $password = 'ProjectEnshu';
        $this->db = new PDO($dsn, $username, $password);
        $this->keyword = $keyword;
    }


    public function getByKeyword(){
        $stmt = $this->db->prepare("SELECT keyword FROM search_count WHERE keyword = :keyword");
        $this->execute($stmt);

        $result = $stmt->fetch();
        return $result['keyword'];
    }

    public function insertKeyword(){
        $stmt = $this->db->prepare("INSERT INTO search_count (keyword) VALUES (:keyword)");
        $this->execute($stmt);
    }

    public function updateKeyCount(){
        $stmt = $this->db->prepare("UPDATE search_count SET scount = scount+1, updated_at = now() WHERE keyword = :keyword");
        $this->execute($stmt);
    }

    private function execute($stmt){
        $stmt->bindParam(':keyword', $this->keyword, PDO::PARAM_STR);
        $stmt->execute();
    }
}