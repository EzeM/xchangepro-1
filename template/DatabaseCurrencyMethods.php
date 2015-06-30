<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DatabaseCurrencyMethods
 *
 * @author meze
 */
class DatabaseCurrencyMethods {
    //put your code here
    var $connection;
    
    function DatabaseCurrencyMethods()
    {
       $this->connection =new DatabaseConnection();
    }
    function getCurrencyElement($currencyID,$getCurrencyElementQuery)
    {
        $currencyElement="";
        try 
        {
            $pdo = $this->connection->getConnection();
            if(isset($currencyID) && trim($currencyID)!="")
            {
                $pdoStatement=$pdo->prepare($getCurrencyElementQuery);
                $isSuccess=$pdoStatement->execute(array($currencyID));
                     if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                         {   
                            $rowp=$pdoStatement->fetch(PDO::FETCH_NUM);
                            if(isset($rowp) && is_array($rowp) && count($rowp)>0)
                            {
                                $currencyElement=  strval($rowp[0]); 
                            }
                        }
                    }
                    else
                    {
                        throw new PDOException();
                    }
            }
           
        }
        catch(PDOException $t)
        {
            
        }
        return $currencyElement;   
    }
    function addUserCurrency($currency,$userID,$addUserCurrency,$databaseError)
    {
        $ok=0;
        $error="";
        try 
        {
            $pdo = $this->connection->getConnection();
            $pdoStatement=$pdo->prepare($addUserCurrency);
            $isSuccess=$pdoStatement->execute(array($userID,$currency));
            if($isSuccess)
            {
                if($pdoStatement->rowCount()>0)
                 {   
                    $ok++;
                }
            }
            else
            {
                throw new PDOException();
            }
        }
        catch(PDOException $t)
        {
            $error.=$databaseError;
        }
        return array($ok,$error) ;   
    }
    function verifyCurrencyID($currencyID,$verifyCurrencyID)
    {
        $currencyExist=false;
        try 
        {
            $pdo = $this->connection->getConnection();
            if(isset($currencyID) && trim($currencyID)!="")
            {
                $pdoStatement=$pdo->prepare($verifyCurrencyID);
                $isSuccess=$pdoStatement->execute(array($currencyID));
                     if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                         {   
                            $rowp=$pdoStatement->fetch(PDO::FETCH_NUM);
                            if(isset($rowp) && is_array($rowp) && count($rowp)>0)
                            {
                                if(intval($rowp[0])>0)
                                {
                                    $currencyExist=TRUE;
                                }
                            }
                        }
                    }
                    else
                    {
                        throw new PDOException();
                    }
            }
           
        }
        catch(PDOException $t)
        {
            
        }
        return $currencyExist;   
    }
}

?>
