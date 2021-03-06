<?php

error_reporting(E_ERROR);

include_once './autoload.php';
include_once './../autoload.php';

include_once '../conexao.php';
include_once './conexao.php';

Conecta();

abstract class DAObase {

    abstract public function ModelValid($model);

    protected function Conect() {
        Conecta();
    }

    function GetByID(&$model) {

        if ($this->ModelValid($model)) {
            $this->Conect();

            $Ar = $model->getFields();
            $Fields = '';
            foreach ($Ar as $key => $val) {
                if ($Fields == '') {
                    $Fields = $key;
                } else {
                    $Fields = $Fields . ', ' . $key;
                }
            }

            $strsql = 'select ' . strtolower($Fields)
                    . '  from ' . strtolower($model->getTable())
                    . ' where id = ' . $model->id
                    . ' order by id ';
            $rs = mysql_query($strsql);

            if (!$rs) {
                return new CONSTerro(true, mysql_error(), __CLASS__, __FUNCTION__);
            } else {
                while ($row = mysql_fetch_array($rs)) {
                    $model->RefreshByRow($row);
                    break;
                }
                return new CONSTerro(false, '', __CLASS__, __FUNCTION__);
            }
        } else {
            return new CONSTerro(true, 'Modelo inválido', __CLASS__, __FUNCTION__);
        }
    }

    function GetList($model, &$list, $Where = NULL) {

        if ($this->ModelValid($model)) {
            $this->Conect();

            $Ar = $model->getFields();
            $Fields = '';
            foreach ($Ar as $key => $val) {
                if ($Fields == '') {
                    $Fields = $key;
                } else {
                    $Fields = $Fields . ', ' . $key;
                }
            }

            $strsql = 'select ' . strtolower($Fields)
                    . '  from ' . strtolower($model->getTable())
                    . ' ' . $Where
                    . ' order by id ';
            $rs = mysql_query($strsql);

            if (!$rs) {
                return new CONSTerro(true, mysql_error(), __CLASS__, __FUNCTION__);
            } else {
                // Cria ARRAY
                $list = array();
                $i = 0;

                // Loop pelo RecordSet
                while ($row = mysql_fetch_array($rs)) {
                    $model->RefreshByRow($row);
                    $list[$i] = clone $model;
                    $i++;
                }

                return new CONSTerro(false, '', __CLASS__, __FUNCTION__);
            }
        }  else {
            return new CONSTerro(true, 'Modelo inválido', __CLASS__, __FUNCTION__);
        }
    }

    function Add(&$model) {

        if ($this->ModelValid($model)) {
            $this->Conect();

            $Ar = $model->getFields();
            $Fields = '';
            $Values = '';
            foreach ($Ar as $key => $val) {
                if ($key <> 'id') {
                    if ($Fields == '') {
                        $Fields = $key;
                        $Values = $val;
                    } else {
                        $Fields = $Fields . ', ' . $key;
                        $Values = $Values . ', ' . $val;
                    }
                }
            }

            $strsql = 'insert into ' . strtolower($model->getTable()) . ' ( ' . strtolower($Fields) . ' ) '
                    . 'values (' . $Values . ')';
            
            if (!mysql_query($strsql)) {
                return new CONSTerro(true, mysql_error(), __CLASS__, __FUNCTION__);
            } else {
                $model->id = mysql_insert_id();
                return new CONSTerro(false, '', __CLASS__, __FUNCTION__);
            }
        } else {
            return new CONSTerro(true, 'Modelo inválido', __CLASS__, __FUNCTION__);
        }
    }

    function Update(&$model) {

        if ($this->ModelValid($model)) {
            $this->Conect();

            $Ar = $model->getFields();
            $FieldsAndValues = '';
            foreach ($Ar as $key => $val) {
                if ($key <> 'id') {
                    if ($FieldsAndValues == '') {
                        $FieldsAndValues = strtolower($key) . ' = ' . $val;
                    } else {
                        $FieldsAndValues = $FieldsAndValues . ', ' . $key . ' = ' . $val;
                    }
                }
            }

            $strsql = 'update ' . strtolower($model->getTable())
                    . '   set ' . $FieldsAndValues
                    . ' where id = ' . $model->id;

            if (!mysql_query($strsql)) {
                return new CONSTerro(true, mysql_error(), __CLASS__, __FUNCTION__);
            } else {
                return new CONSTerro(false, '', __CLASS__, __FUNCTION__);
            }
        } else {
            return new CONSTerro(true, 'Modelo inválido', __CLASS__, __FUNCTION__);
        }
    }

    function Delete($model) {
        if ($this->ModelValid($model)) {
            $this->Conect();

            $strsql = 'delete '
                    . '  from ' . strtolower($model->getTable())
                    . ' where id = ' . $model->id;

            if (!mysql_query($strsql)) {
                return new CONSTerro(true, mysql_error(), __CLASS__, __FUNCTION__);
            } else {
                return new CONSTerro(false, '', __CLASS__, __FUNCTION__);
            }
        } else {
            return new CONSTerro(true, 'Modelo inválido', __CLASS__, __FUNCTION__);
        }
    }

}
