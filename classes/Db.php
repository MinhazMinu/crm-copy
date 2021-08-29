<?php
class DB extends PDO
{   // DB connection
    protected $dbhost, $dbname, $dbuser, $dbpass, $db;
    protected $msg = "Error updating info";
    public function __construct()
    {
        $this->getCon();
    }

    public function getCon()
    {
        $this->setConProp();
        try {
            $con = new PDO("mysql:host=" . $this->dbhost . ";dbname=" . $this->dbname, $this->dbuser, $this->dbpass);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db = $con;
        } catch (PDOException $e) {
            return $this->getResp(1, $e->getMessage());
        }
    }

    public function setConProp()
    {
        $db_config = require_once __DIR__ . '/../config/config.php';
        foreach ($db_config as $k => $v) $this->$k = $v;
    }
    //Db connection end

    //Query

    public function getData($sql, $params = [])
    {
        $data = (object) ['data' => ''];
        $query = $this->getQuery($sql, $params);
        $data->cnt = $query->rowCount();

        if ($data->cnt == 0) $this->getResp(1, "No Data found");

        if ($query) {
            $data->$data = $query->fetchAll(PDO::FETCH_OBJ);
        }
        return $data;
    }

    public function getQuery($sql, $params = [])
    {
        try {
            $query = $this->db->prepare($sql);
            $query->execute($params);
            return $query;
        } catch (PDOException $e) {
            return $this->getResp(1, $e->getMessage());
        }
    }




    //Query End



    public function getResp($code, $msg)
    {
        $obj = new stdClass();
        $obj->err = $code;
        $obj->msg = $msg;
        return $obj;
    }
}
