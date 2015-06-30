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
class DatabaseUserMethods {
    //put your code here
    var $connection;
    
    function DatabaseUserMethods()
    {
       $this->connection =new DatabaseConnection();
    }
    function getUserBaseCurrency($user,$query)
    {
        $baseCurrency="";
        if(isset($user) && trim($user)!="")
        {
             if(isset($query) && trim($query)!="")
            {
                 try
                {
                    $pdo = $this->connection->getConnection();
                    $pdoStatement=$pdo->prepare($query);
                    $isSuccess=$pdoStatement->execute(array($user)); 
                    if($isSuccess && $pdoStatement->rowCount()>0)
                    {
                        $rowp=$pdoStatement->fetch(PDO::FETCH_NUM);
                        if(isset($rowp) && is_array($rowp) && count($rowp)>0)
                        {
                            $baseCurrency=  strval($rowp[0]); 
                        }
                    }
                }
                catch(PDOException $f)
                {

                }
            }
        }
        return $baseCurrency;
    }
    function getUserCountryCurrencyID($user,$query)
    {
        $countryCurrency="";
        if(isset($user) && trim($user)!="")
        {
             if(isset($query) && trim($query)!="")
            {
                 try
                {
                    $pdo = $this->connection->getConnection();
                    $pdoStatement=$pdo->prepare($query);
                    $isSuccess=$pdoStatement->execute(array($user)); 
                    if($isSuccess && $pdoStatement->rowCount()>0)
                    {
                        $rowp=$pdoStatement->fetch(PDO::FETCH_NUM);
                        if(isset($rowp) && is_array($rowp) && count($rowp)>0)
                        {
                            $countryCurrency=  strval($rowp[0]); 
                        }
                    }
                }
                catch(PDOException $f)
                {

                }
            }
        }
        return $countryCurrency;
    }
    function getUserCurrencyAccountBalance($userID,$currrencyID,$query)
    {
         $amount=0;
         try
        {
            $pdo=$this->connection->getConnection();
            $pdoStatement=$pdo->prepare($query);
            $isSuccess=$pdoStatement->execute(array($userID,$currrencyID));
            if($isSuccess)
            {
                if($pdoStatement->rowCount()>0)
                {
                    $ttt=$pdoStatement->fetch(PDO::FETCH_NUM);
                    if(is_array($ttt) && count($ttt)==1)
                    {
                        $x=doubleval(str_replace(',', '',$ttt[0]));
                        if(is_double($x))
                        {
                             $amount=$x;
                        }
                       
                    }
                     else 
                     {
                        throw new PDOException();
                     }
                }
                else
                {
                    throw new PDOException();
                }
            }
            else
            {
                throw new PDOException();
            }
        }
        catch(PDOException $r)
        {
        }
        return $amount;
    }
    function getUserFundedCurrencies($userID,$query)
    {
         $currencies="";
         try
        {
            $pdo=$this->connection->getConnection();
            $pdoStatement=$pdo->prepare($query);
            $isSuccess=$pdoStatement->execute(array($userID));
//            $currencies= implode(',', $pdoStatement->errorInfo());
            if($isSuccess)
            {
                
                if($pdoStatement->rowCount()>0)
                {
                    $ttt=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                    if(is_array($ttt) && count($ttt)>0)
                    {
                        $currencies=  implode(',', $ttt);
                    }
                     else 
                     {
                        throw new PDOException();
                     }
                }
                else
                {
                    throw new PDOException();
                }
            }
            else
            {
                throw new PDOException();
            }
        }
        catch(PDOException $r)
        {
        }
        return $currencies;
    }
    function getUserFundedCurrenciesAmount($userID,$query)
    {
         $amounts="";
         try
        {
            $pdo=$this->connection->getConnection();
            $pdoStatement=$pdo->prepare($query);
            $isSuccess=$pdoStatement->execute(array($userID));
//            $currencies= implode(',', $pdoStatement->errorInfo());
            if($isSuccess)
            {
                
                if($pdoStatement->rowCount()>0)
                {
                    $ttt=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                    if(is_array($ttt) && count($ttt)>0)
                    {
                        $amounts=  implode(',', $ttt);
                    }
                     else 
                     {
                        throw new PDOException();
                     }
                }
                else
                {
                    throw new PDOException();
                }
            }
            else
            {
                throw new PDOException();
            }
        }
        catch(PDOException $r)
        {
        }
        return $amounts;
    }
    function getUserID($user,$get_user_id_from_email_address,$get_user_id_from_user_id)
    {
        $userID="";
       $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
        $o=  eregi($regexp, $user);
        $query="";
        if($o)
        {
            $query=$get_user_id_from_email_address;
        }
         else 
         {
             $query=$get_user_id_from_user_id;
         }
        try
        {
            $pdo = $this->connection->getConnection();
            $pdoStatement=$pdo->prepare($query);
            $isSuccess=$pdoStatement->execute(array($user)); 
            if($isSuccess && $pdoStatement->rowCount()>0)
            {
                $rowp=$pdoStatement->fetch(PDO::FETCH_NUM);
                if(isset($rowp) && is_array($rowp) && count($rowp)>0)
                {
                    $userID=  strval($rowp[0]); 
                }
            }
        }
        catch(PDOException $f)
        {

        }
        return $userID ; 
    }
    function getConcatUserName($userID,$get_user_name2)
    {
        $userName="";
         try
        {
            $pdo=$this->connection->getConnection();
            $pdoStatement=$pdo->prepare($get_user_name2);
            $isSuccess=$pdoStatement->execute(array($userID));
            if($isSuccess)
            {
                if($pdoStatement->rowCount()>0)
                {
                    $ttt=$pdoStatement->fetch(PDO::FETCH_NUM);
                    if(is_array($ttt) && count($ttt)==1)
                    {
                        $userName=$ttt[0];
                    }
                     else 
                     {
                        throw new PDOException();
                     }
                }
                else
                {
                    throw new PDOException();
                }
            }
            else
            {
                throw new PDOException();
            }
        }
        catch(PDOException $r)
        {
        }
        return $userName;
    }
    function getUserRoleCharge($userID,$roleID,$get_user_charge_by_role_id)
    {
        $charge=0;
        try
        {
            $pdo = $this->connection->getConnection();
            $pdoStatement=$pdo->prepare($get_user_charge_by_role_id);
            $isSuccess=$pdoStatement->execute(array($userID,$roleID));
            if($isSuccess && $pdoStatement->rowCount()>0)
            {
                $chargeArray=$pdoStatement->fetch(PDO::FETCH_NUM);
                if(isset($chargeArray) && count($chargeArray)>0)
                {
                    $charge0=$chargeArray[0];
                    if(is_numeric(doubleval($charge0)))
                    {
                        $charge=  doubleval($charge0);
                    }
                }
            }
        } catch (Exception $ex) {

        }
         return $charge;
    }
    function getUserEmailByID($user,$query)
    {
       $emailID="";
       if(isset($user) && trim($user)!="" && isset($query) && trim($query)!="")
       {
           try
            {
                $pdo = $this->connection->getConnection();
                $pdoStatement=$pdo->prepare($query);
                $isSuccess=$pdoStatement->execute(array($user)); 
                if($isSuccess && $pdoStatement->rowCount()>0)
                {
                    $rowp=$pdoStatement->fetch(PDO::FETCH_NUM);
                    if(isset($rowp) && is_array($rowp) && count($rowp)>0)
                    {
                        $emailID=  strval($rowp[0]); 
                    }
                }
            }
            catch(PDOException $f)
            {

            }
       }
        return $emailID ; 
    }
}

?>
