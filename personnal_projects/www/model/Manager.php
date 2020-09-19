<?php

namespace Projet\Model;

class Manager
{
    protected function dbConnect()
    {
    	try {
            $db = new \PDO('mysql:host=localhost;dbname=dev_old_bdd;charset=utf8', 'root', '', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
    	} catch (PDOException $e) {
    		throw new Exception($e);	 
    	}
        return $db;
    }
}
