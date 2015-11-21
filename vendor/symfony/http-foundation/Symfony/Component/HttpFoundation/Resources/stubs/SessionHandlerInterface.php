<?php

interface SessionHandlerInterface
{
  
    public function open($savePath, $sessionName);

    public function close();

    public function read($sessionId);

    public function write($sessionId, $data);

    public function destroy($sessionId);

    public function gc($maxlifetime);
}
