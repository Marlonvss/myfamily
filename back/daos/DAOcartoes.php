<?php

error_reporting(E_ERROR);

include_once './autoload.php';

class DAOcartoes extends DAObase {

    public function ModelValid($model) {
        return (get_class($model) == 'cartoes');
    }

}
