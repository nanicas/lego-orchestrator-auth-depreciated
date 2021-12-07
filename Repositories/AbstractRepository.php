<?php

namespace App\Libraries\Annacode\Repositories;

abstract class AbstractRepository
{
    protected $model;

    public function getConnectionDB()
    {
        //return PDOConnection::getCon(PDOConnection::getType());
    }

    public function __call($name, $arguments)
    {
        return $this->getModel()->{$name}(...$arguments);
    }

    protected function setModel($model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getClassModel()
    {
        return get_class($this->model);
    }

    public function getTable()
    {
        return $this->model->getTable();
    }

    public function getPrimaryKey()
    {
        return $this->model::getPrimaryKey();
    }

    public function queryAll(string $query, array $params = [])
    {
        $sth = $this->getConnectionDB()->prepare($query);

        $this->_execute($sth, $params);

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM ".$this->getTable();

        return $this->queryAll($sql);
    }

    public function countRows()
    {
        $sql = "SELECT COUNT(*) FROM ".$this->getTable();
        $res = $this->getConnectionDB()->query($sql);

        return $res->fetchColumn();
    }

    public function getColumnsObject()
    {
        $sth = $this->getConnectionDB()->prepare("DESCRIBE ".$this->getTable());

        $this->_execute($sth);

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function _query($connection, string $sql)
    {
        try {
            return $connection->query($sql);
        } catch (\PDOException $exc) {
            $this->newException($exc);
        } catch (\Exception $exc) {
            $this->newException($exc);
        }
    }

    protected function _execute($sth, array $params = [])
    {
        try {
            $exe = (!empty($params)) ? $sth->execute($params) : $sth->execute();
            if (!$exe) {
                $this->newException($exc);
                //dd($this->dbConnection->errorInfo());
            }

            if (hasPrintDebug()) {
                dd($sth->debugDumpParams());
            }
        } catch (\PDOException $exc) {
            $this->newException($exc);
        } catch (\Exception $exc) {
            $this->newException($exc);
        }

        return true;
    }

    public function newException($exc)
    {
        throw $exc;
    }
}