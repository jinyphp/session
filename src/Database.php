<?php

namespace Jiny\Session;

class Database implements Handler
{
    private $_db;
    /**
     * 사용자 단계 세션 저장 함수를 설장합니다. 
     * PHP 세션에 제공하기 않는 방법으로 데이터를 저장하고 복구합니다. ex) 세션db저장
     */
    public function __construct($db=null)
    {
        if ($db) {
            $this->_db = $db;
            session_set_save_handler(
                array($this, 'open'),
                array($this, 'close'),
                array($this, 'read'),
                array($this, 'write'),
                array($this, 'destroy'),
                array($this, 'gc')
            );
        }
           
    }

    public function open($save_path, $session_name) {
        //echo "session open : $save_path, name: $session_name <br>";
        return true;    
    }

    public function close()
    {
        return true;
    }

    public function read($id) 
    {
        $session = "";
        $stmt = $this->_db->prepare("SELECT * FROM sessions where id = ?");
        $stmt->execute([$id]);
        if ($stmt->rowCount() > 0) {
            //echo "세션값 존재 ".$stmt->rowCount();
            $session = $stmt->fetch()['data'];
        } else {
            //echo "DB에 세션값이 없습니다.";
        }
        return $session;
    }

    public function write($id, $data) 
    {
        $stmt = $this->_db->prepare("REPLACE INTO sessions (id, data) VALUE (?, ?)");
        $stmt->execute([$id, $data]);
        if ($stmt->rowCount() >0) {
            return true;
        } else {
            return false;
        }
    }

    public function destroy($id) 
    {
        $stmt = $this->_db->prepare("DELETE FROM sessions where id=?");
        $stmt->execute([$id]);
        return true;
    }

    public function gc($exp) 
    {
        $stmt = $this->_db->prepare("DELETE FROM sessions where DATE_ADD(last_access, INTERVAL ? SECOND) < NOW");
        $stmt->execute([$exp]);
        return true;
    }

    /**
     * 
     */
}