<?php

class Model extends Conexion {

    public $table;
    public $tableAlias = '';
    protected $primaryKey = 'id';

    protected $select = '*';
    protected $joins = [];
    protected $whereBuilder = [];
    protected $whereParams = [];

    protected $orderBy = '';
    protected $limit = '';

    public function __construct() {
        parent::__construct();
    }

    public function all() {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->conect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = "SELECT * FROM $this->table WHERE $this->primaryKey = :id";
        $stmt = $this->conect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE $this->primaryKey = :id";
        $stmt = $this->conect()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function insert($data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $this->table ($columns) VALUES ($placeholders)";
        $stmt = $this->conect()->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
    }

    public function update($id, $data) {
        $setClause = "";
        foreach ($data as $key => $value) {
            $setClause .= "$key = :$key, ";
        }
        $setClause = rtrim($setClause, ", ");
        $sql = "UPDATE $this->table SET $setClause WHERE $this->primaryKey = :id";
        $stmt = $this->conect()->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function where($conditions, $params = []) {
        if (is_array($conditions)) {
            foreach($conditions as $condition) {
                $this->whereBuilder[] = $condition;
            }
        } else {
            $this->whereBuilder[] = $conditions;
        }
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $this->whereParams[$key] = $value;
            }
        }
        return $this;
    }

    public function select($fields) {
        $this->select = implode(", ", $fields);
        return $this;
    }

    public function join($table, $condition, $type = 'INNER') {
        $this->joins[] = "$type JOIN $table ON $condition";
        return $this;
    }

    public function orderBy($field, $direction = 'ASC') {
        $this->orderBy = "ORDER BY $field $direction";
        return $this;
    }

    public function limit($limit) {
        $this->limit = "LIMIT $limit";
        return $this;
    } 

    public function get() {
        $from = !empty($this->tableAlias) ? "$this->table $this->tableAlias" : $this->table;
        $sql = "SELECT $this->select FROM $from ";
        //Joins
        if (!empty($this->joins)) {
            $sql .= implode(" ", $this->joins) . " ";
        }
        //Where
        if (!empty($this->whereBuilder)) {
            $sql .= "WHERE " . implode(" AND ", $this->whereBuilder) . " ";
        }
        //orderBy
        if (!empty($this->orderBy)) {
            $sql .= $this->orderBy . " ";
        }
        //limit
        if (!empty($this->limit)) {
            $sql .= $this->limit;
        }
        $stmt = $this->conect()->prepare($sql);
        if (!empty($this->whereParams)) {
            foreach ($this->whereParams as $key => $value) {
                $stmt->bindValue($key, $value);
            }
        }
        $stmt->execute();
        $this->resetQuery();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function resetQuery() {
        $this->select = '*';
        $this->tableAlias = '';
        $this->joins = [];
        $this->whereBuilder = [];
        $this->whereParams = [];
        $this->orderBy = '';
        $this->limit = '';
    }

    public function first() {
        $this->limit(1);
        $result = $this->get();
        return $result[0] ?? null;
    }
}