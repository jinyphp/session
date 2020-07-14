<?php

namespace Jiny\Session;

class File implements Handler
{
    private $_path="./sessions";
    /**
     * 사용자 단계 세션 저장 함수를 설장합니다. 
     * PHP 세션에 제공하기 않는 방법으로 데이터를 저장하고 복구합니다. ex) 세션db저장
     */
    public function __construct($path=null)
    {
        if ($path) $this->_path = $path;
        if(!\is_dir(".".$this->_path)) mkdir(".".$this->_path);

        // 파일 세션
        session_set_save_handler(
            array($this, 'open'),
            array($this, 'close'),
            array($this, 'read'),
            array($this, 'write'),
            array($this, 'destroy'),
            array($this, 'gc')
        );
    }


    // 열기 함수 : 세션이 열릴 때 실행됩니다.
    // 열기 함수는 두 인수를 받습니다. 첫번째는 저장 경로이고 두번째는 세션 이름입니다.
    
    function open($save_path, $session_name)
    {
        $save_path = $this->_path;
        return true;
    }

    // 닫기 함수
    // 세션 연산이 끝났을 때 실행됩니다.
    function close()
    {
        return true;
    }

    // 읽기 함수는 저장 핸들러가 정상적으로 작동하기 위해 항상 문자열 값을 반환해야 합니다. 
    // 읽을 데이터가 없으면 빈 문자열을 반환합니다. 다른 핸들러에서 오는 값은 논리 표현으로 변환하여 반환합니다. 
    // 성공시엔 TRUE, 실패시엔 FALSE입니다.
    function read($id)
    {
        $sess_file = $this->_path."/sess_$id";
        return (string) @file_get_contents($sess_file);
    }

    // Note: "쓰기" 핸들러는 출력 스트림이 닫힐 때까지 실행되지 않습니다. 
    // 그러므로, "쓰기" 핸들러에서 디버그 구문 출력은 브라우저에서 볼 수 없습니다. 
    // 디버그 출력이 필요하면, 디버그 출력을 파일로 쓰십시오.
    function write($id, $sess_data)
    {
        $sess_file = $this->_path."/sess_$id";   
        if ($fp = @fopen($sess_file, "w")) {
            $return = fwrite($fp, $sess_data);
            fclose($fp);
            return true;
        } else {
            return false;
        }
    }

    // 파괴 핸들러, session_destroy()로 세션이 파괴될 때 실행되며, 세션 id를 인수로 받습니다.
    function destroy($id)
    {
        $sess_file = $this->_path."/sess_$id";
        return @unlink($sess_file);
    }

    // 쓰레기 수거자, 세션 쓰레기 수거가 실행될 때 실행되며, 최대 세션 수명을 인수로 받습니다.
    function gc($maxlifetime)
    {
        foreach (glob($this->_path."/sess_*") as $filename) {
            if (filemtime($filename) + $maxlifetime < time()) {
                @unlink($filename);
            }
        }
        return true;
    }

}