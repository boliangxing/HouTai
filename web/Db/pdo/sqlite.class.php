<?php


class db_sqlite  
{  
    private $config;  
  
    private $db;  
  
    public $querynum;  
  
    public function mysql($host, $user, $password, $dbname, $tablepre = '', $charset = 'GBK')  
    {  
        $this->config['type'] = 'mysql';  
        $this->config['tablepre'] = $tablepre;  
        $this->config['mysql']['host'] = $host;  
        $this->config['mysql']['user'] = $user;  
        $this->config['mysql']['password'] = $password;  
        $this->config['mysql']['dbname'] = $dbname;  
        $this->config['mysql']['charset'] = $charset;  
    }  
  
    public function sqlite($datafile,$tablepre = '')  
    {  
        $this->config['type'] = 'sqlite';  
        $this->config['sqlite']['file'] = $datafile;  
                $this->config['tablepre'] = $tablepre;  
    }  
  
    private function connect()  
    {  
        if (isset($this->db)) {  
            return true;  
        }  
        if ($this->config['type'] == 'mysql') {  
            try{  
                $this->db = new PDO('mysql:host='.$this->config['mysql']['host'].';dbname='.$this->config['mysql']['dbname'], $this->config['mysql']['user'], $this->config['mysql']['password'], array(PDO::ATTR_PERSISTENT => true));  
                $this->db->query('SET NAMES '.$this->config['mysql']['charset']);  
            } catch (PDOException $e) {  
                exit('数据库连接失败：'.$e->getMessage());  
            }  
        }  
        if ($this->config['type'] == 'sqlite') {  
            !file_exists($this->config['sqlite']['file']) && exit('没有找到SQLITE数据库');  
            $this->db = new PDO('sqlite:'.$this->config['sqlite']['file']);  
        }  
        !isset($this->db) && exit('不支持该数据库类型 '.$this->config['type']);  
    }  
  
    public function table($table)  
    {  
        return '`'.$this->config['tablepre'].$table.'`';       
    }  
  
    public function strescape($str)  
    {  
        if ($this->config['type'] === 'mysql') {  
            return !get_magic_quotes_gpc() ? addslashes($str) : $str;  
        }  
        if ($this->config['type'] === 'sqlite') {  
            return str_replace('\'', '\'\'', $str);  
        }  
        return $str;  
    }  
  
    public function format_condition($condition)  
    {  
        if (is_array($condition)) {  
            foreach ($condition as $key => $value) {  
                $join[] = $key.' = \''.$this->strescape($value).'\'';  
            }  
            return ' WHERE '.join(' AND ', $join);  
        }  
        return $condition ? ' WHERE '.$condition : '';  
    }  
  
    private function error()  
    {  
        if ($this->db->errorCode() != '00000') {  
            $error = $this->db->errorInfo();  
            exit('SQL语句错误：'.$error['2']);  
        }  
    }  
  
    public function query($sql)  
    {  
        $this->connect();  
        $result = $this->db->query($sql);  
        $this->error();  
        $result->setFetchMode(PDO::FETCH_ASSOC);  
        $this->querynum++;  
        return $result;  
    }  
  
    public function exec($sql)  
    {  
        $this->connect();  
        $result = $this->db->exec($sql);  
        $this->error();  
        $this->querynum++;  
        return $result;  
    }  
  
    public function lastinsertid()  
    {  
        return $this->db->lastInsertId();  
    }  
  
    public function fetchall($table, $field, $condition = '', $sort = '', $limit = '')  
    {  
        $condition = $this->format_condition($condition);  
        $sort && $sort = ' ORDER BY '.$sort;  
        $limit && $limit = ' LIMIT '.$limit;  
        $sql = 'SELECT '.$field.' FROM '.$this->table($table).$condition.$sort.$limit;  
        return $this->query($sql)->fetchall();  
    }  
  
    public function fetch($table, $field, $condition = '', $sort = '')  
    {  
        $condition = $this->format_condition($condition);  
        $sort && $sort = ' ORDER BY '.$sort;  
        $sql = 'SELECT '.$field.' FROM '.$this->table($table).$condition.$sort.' LIMIT 1';  
        return $this->query($sql)->fetch();  
    }  
  
    public function rowcount($table, $condition = '')  
    {  
        $condition = $this->format_condition($condition);  
        $sql = 'SELECT COUNT(*) FROM '.$this->table($table).$condition;  
        $result = $this->query($sql)->fetch();  
        return $result['COUNT(*)'];  
    }  
  
    public function get_fields($table)  
    {  
        if ($this->config['type'] == 'mysql') {  
            $sql = 'DESCRIBE '.$this->table($table);  
            $key = 'Field';  
        } else if ($this->config['type'] == 'sqlite') {  
            $sql = 'PRAGMA table_info('.$this->table($table).')';  
            $key = 'name';  
        }  
        $fields = $this->query($sql)->fetchall();  
        foreach ($fields as $value) {  
            $result[] = $value[$key];  
        }  
        return $result;  
    }  
  
    public function insert($table, $array)  
    {  
        if (!is_array($array)) {  
            return false;  
       }  
        foreach ($array as $key => $value) {  
            $cols[] = $key;  
            $vals[] = '\''.$this->strescape($value).'\'';  
        }  
        $col = join(',', $cols);  
        $val = join(',', $vals);  
        $sql = 'INSERT INTO '.$this->table($table).' ('.$col.') VALUES ('.$val.')';  
        return $this->exec($sql);  
    }  
  
    public function update($table, $array, $condition)  
    {  
        if (!is_array($array)) {  
            return false;  
        }  
        $condition = $this->format_condition($condition);  
        foreach ($array as $key => $value) {  
            $vals[] = $key.' = \''.$this->strescape($value).'\'';  
        }  
        $values = join(',', $vals);  
        $sql = 'UPDATE '.$this->table($table).' SET '.$values.$condition;  
        return $this->exec($sql);  
    }  
  
    public function delete($table, $condition)  
    {  
        $condition = $this->format_condition($condition);  
        $sql = 'DELETE FROM '.$this->table($table).$condition;  
        return $this->exec($sql);  
    }  
}
