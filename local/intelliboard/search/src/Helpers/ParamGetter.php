<?php

namespace Helpers;

class ParamGetter {

    private $columns = array();
    private $tables = array();
    private $filters = array();
    private $params = array();

    public function add($type, $data)
    {
        if (isset($this->$type) && !in_array($data, $this->$type)) {
            $this->$type[] = $data;
        }
    }

    public function release() {
        $sql = 'SELECT ' . implode(',', $this->columns);
        $sql .= ' FROM ' . implode(' ', $this->tables);

        if ($this->filters) {
            $sql .= ' WHERE ' . implode(' AND ', $this->filters);
        }

        return array('sql' => $sql, 'params' => $this->params);
    }

    public function setParam($name, $value) {
        $this->params[$name] = $value;
    }

}