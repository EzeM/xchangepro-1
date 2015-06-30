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
class DatabaseConditionMethods {
    //put your code here
    var $connection;
    
    function DatabaseConditionMethods()
    {
       $this->connection =new DatabaseConnection();
    }
    function verifyTempCondition($conditionID,$userID,$verify_temp_condition_id2,$fakeConditionError,$databaseError)
    {
        $conditionFound=false;
        $error="";
       try 
        {
            $pdo = $this->connection->getConnection();
            if(isset($pdo))
            {
                $pdoStatement=$pdo->prepare($verify_temp_condition_id2);
                $isSuccess=$pdoStatement->execute(array($conditionID,$userID)); 
                if($isSuccess && $pdoStatement->rowCount()>0)
                {
                    $ggg=$pdoStatement->fetch(PDO::FETCH_NUM);
                    if(isset($ggg) && is_array($ggg) && count($ggg)>0)
                    {
                        $conditionCount=  intval($ggg[0]);
                        if($conditionCount>0)
                        {
                             $conditionFound=true;
                        }
                        else
                        {
                            $error=$fakeConditionError;
                        }
                    }
                    else
                    {
                        $error=$fakeConditionError;
                    }
                }
                else
                {
                    $error=$fakeConditionError;
                }

            }
            else
            {
                throw new PDOException();
            }
        }
        catch (PDOException $Y)
        {
            $error=$databaseError;
        }
        return array($conditionFound,$error) ; 
    }
    function getConditionOwner($conditionID,$get_condition_owner,$fakeConditionError,$databaseError)
    {
        $conditionOwner="";
        $error="";
       try 
        {
            $pdo = $this->connection->getConnection();
            if(isset($pdo))
            {
                $pdoStatement=$pdo->prepare($get_condition_owner);
                $isSuccess=$pdoStatement->execute(array($conditionID)); 
                if($isSuccess && $pdoStatement->rowCount()>0)
                {
                    $ownerArray=$pdoStatement->fetch(PDO::FETCH_NUM);
                    if(isset($ownerArray) && is_array($ownerArray) && count($ownerArray)>0)
                    {
                        $conditionOwner=$ownerArray[0];
                    }
                    else
                    {
                        $error=$fakeConditionError;
                    }
                }
                else
                {
                    $error=$fakeConditionError;
                }

            }
            else
            {
                throw new PDOException();
            }
        }
        catch (PDOException $Y)
        {
            $error=$databaseError;
        }
        return array($conditionOwner,$error) ; 
    }
    function getConditionCount($reqUserID,$get_user_condition_count)
    {
        $totalUserConditionCount=0;
        try 
        {
            $pdo = $this->connection->getConnection();
            if(isset($pdo))
            {
                $pdoStatement=$pdo->prepare($get_user_condition_count);
                $isSuccess=$pdoStatement->execute(array($reqUserID)); 
                if($isSuccess && $pdoStatement->rowCount()>0)
                {
                    $theCount=$pdoStatement->fetch(PDO::FETCH_NUM);
                    if(isset($theCount) && is_array($theCount) && count($theCount)>0)
                    {
                         $totalUserConditionCount=$theCount[0];
                    }
                }

            }
        }
        catch (PDOException $Y)
        {

        }
        return $totalUserConditionCount;
    }
    function getDatabaseElementCount($query,$inputArray)
    {
        $count=0;
        if(is_array($inputArray) && count($inputArray)>0)
        {
            try 
            {
                $pdo = $this->connection->getConnection();
                if(isset($pdo))
                {
                    $pdoStatement=$pdo->prepare($query);
                    $isSuccess=$pdoStatement->execute($inputArray); 
                    if($isSuccess && $pdoStatement->rowCount()>0)
                    {
                        $theCount=$pdoStatement->fetch(PDO::FETCH_NUM);
                        if(isset($theCount) && is_array($theCount) && count($theCount)>0)
                        {
                             $count=$theCount[0];
                        }
                    }

                }
            }
            catch (PDOException $Y)
            {

            }
        }
            
        return $count;
    }
}

?>
