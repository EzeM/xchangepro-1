<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DatabaseConnection
{
    
    var  $pdo;
    var $userName="";
    var $password="";
    var $databaseName="";
    function DatabaseConnection() {
        
        include '../template/database_parameters.php';
        $this->databaseName=$dsn;
        $this->userName=$username;
        $this->password=$password;
        
    }
    function getConnection() {
        if(!isset($this->pdo))
        {
            $this->pdo=new PDO($this->databaseName,  $this->userName,  $this->password) or die("Cannot connect to the database");
//            $d=  $this->pdo->prepare($statement);
//            $this->pdo->beginTransaction
           
//            $r=$this->pdo->query($statement);
//            $r->errorInfo();
            
            
        }
        return $this->pdo;
    }
}
?>
