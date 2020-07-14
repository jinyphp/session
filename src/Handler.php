<?php
namespace Jiny\Session;

interface Handler {
    public function open($save_path, $session_name);
    public function close();
    public function read($id);
    public function write($id, $data);
    public function destroy($id);
    public function gc($exp);
}