<?php
// 오토로딩
$autoload = "../vendor/autoload.php";
if(!file_exists($autoload)) {
    echo "composer autoload가 설치되어 있지 않습니다.\n";
    exit;
} 
require $autoload;

// 데이터베이스 초기화
$dbinfo = \jiny\dbinfo();
if( !$db = new \Jiny\Mysql\Connection($dbinfo)) {
    echo "데이터 접속 실패. 상위폴더의 dbinfo.php 파일의 설정내용을 확인해 주세요.\n";
}

echo "데이터베이스 접속 성공\n";


$query = "CREATE TABLE `".$dbinfo['schema']."`.`sessions` (
  `id` varchar(255) NOT NULL,
  `data` text,
  `last_accessed` timestamp NULL DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

$db->query($query); 


// 테이블 목록출력
//print_r($db->table()->list());