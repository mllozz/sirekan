<?php

class UserSatker extends User {
    protected function _init(){
        $this->_setKdAkses(User::AKSES_SATKER);
    }
}

