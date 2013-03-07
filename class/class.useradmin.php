<?php

class UserAdmin extends User {
    protected function _init(){
        $this->_setKdAkses(User::AKSES_ADMIN);
    }
}

