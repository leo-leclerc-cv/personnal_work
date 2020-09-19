<?php

namespace Projet\Model;

class Manager
{
    protected function dbConnect()
    {
    	try {
	        #$db = new \PDO('mysql:host=localhost;dbname=id7648551_projet;charset=utf8', 'id7648551_dawnowl444', 'cYyhp53dfh3VizL', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
	        #$db = new \PDO('mysql:host=localhost;dbname=id7648551_projet;charset=utf8', 'root', '', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
            $db = new \PDO('mysql:host=localhost;dbname=dev_old_bdd;charset=utf8', 'root', '', array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION));
    	} catch (PDOException $e) {
    		throw new Exception($e);	 
    	}
        return $db;
    }
}