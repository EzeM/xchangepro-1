<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class template {

    
    var $escape_string_open = "{";
    var $escape_string_close = "}";
    var $files = array();
    var $variables = array();
    function replaceString($fileID,$stringVariable,$replacement)
    {
        if(is_int($fileID) && array_key_exists($fileID, $this->files))
        {
            $fileContent=  $this->files[$fileID];
            if(isset($fileContent) && $fileContent!=NULL && trim($fileContent)!='')
            {
                $seachVariable = $this->escape_string_open . $stringVariable . $this->escape_string_close;
                $fileContent = str_replace($seachVariable, $replacement, $fileContent);
                $this->files[$fileID]=$fileContent;
            }
        }
    }
    function  replaceStringWithDelimitedQueryResult($fileID,$stringVariable,$queryString,$replacementPrefix,$replacementColumn,$replacementDelimiter)
{
        //method implodes the value of a specified column in the result of a query. where a replacement prefix is set it adds the prefix to each value before imploding with the delimiter. where delimiter is not set. " " is used.
    $refString="";
    if(is_int($fileID) && array_key_exists($fileID, $this->files))
    {
        if(isset($stringVariable) && $stringVariable!=NULL && trim($stringVariable)!='')
        {
            if(isset($queryString) && $queryString!=NULL && trim($queryString)!='')
            {
                if(is_int($replacementColumn))
                {
                    $z = strstr($queryString, "=>"); //=> is used to delimit between the actual varaible and the inputs to the prepared query
                    $preparedQueryInput = array();
                    if ($z) {
                        $r = strpos($queryString, "=>"); //  get the location of the delimniter =>
                        if ($r) {
                            $haystack = substr($queryString, $r + 2); // get the sub string of the queryVariable after the delimiter =>
                            $queryString = trim(substr($queryString, 0, $r));
                            $preparedQueryInput = explode(":", $haystack); // : is used to delimit between the inputs to the prepared statement
                        }
                    }
                    global $$queryString, $dsn, $username, $password;
                    $query = $$queryString;
                    $pdo = new PDO($dsn, $username, $password) or die("Cannot connect to the database");
                    $pdoStatement = $pdo->prepare($query);
                    $pdo->beginTransaction();
                    $b;
                    if (is_array($preparedQueryInput) && count($preparedQueryInput) > 0) 
                    {
                        $b = $pdoStatement->execute($preparedQueryInput);
                    } 
                    else 
                    {
                        $b = $pdoStatement->execute();
                    }
                    if ($b) 
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            if($pdoStatement->columnCount()>$replacementColumn)
                            {
                                $refColumn=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,$replacementColumn);
                                if(isset($refColumn) && is_array($refColumn) && count($refColumn)>0)
                                {
                                    if(isset($replacementPrefix) && $replacementPrefix!=NULL && trim($replacementPrefix)!='')
                                    {
                                        if(!(isset($replacementDelimiter) && $replacementDelimiter!=NULL && trim($replacementDelimiter)!=''))
                                        {
                                            $replacementDelimiter=" ";
                                        }
                                        $p=count($refColumn);
                                        for($i=0;$i<$p;$i++)
                                        {
                                            $f=$refColumn[$i];
                                             if(isset($f) && $f!=NULL && trim($f)!='')
                                             {
                                                 $refString.=$replacementPrefix.$f;
                                                 if($i<$p-1)
                                                 {
                                                     $refString.=$replacementDelimiter;
                                                 }
                                             }
                                        }
                                    }
                                    else
                                    {
                                        if(isset($replacementDelimiter) && $replacementDelimiter!=NULL && trim($replacementDelimiter)!='')
                                        {
                                            $refString=  implode($replacementDelimiter, $refColumn);
                                        }  
                                        else {
                                            $refString=  implode(" ", $refColumn);
                                        }
                                    }
                                }
                            }
                        }
                    }

                }
            }
        }
        $fileContent=  $this->files[$fileID];
        if(isset($fileContent) && $fileContent!=NULL && trim($fileContent)!='')
        {
            $seachVariable = $this->escape_string_open . $stringVariable . $this->escape_string_close;
            $fileContent = str_replace($seachVariable, $refString, $fileContent);
            $this->files[$fileID]=$fileContent;
        }
            
    }
    
}
function registerString($fileID, $string) {
        if ($string != NULL) {
            if (trim($string) != "") {
                $this->files[$fileID] = $string;
            }
        }
    }
function registerFiles($fileID, $fileName) {
        if ($fileName != NULL) {
            if (trim($fileName) != "") {
                if (file_exists($fileName)) {
                    $filePointer = fopen($fileName, "r") or die("Fill not found");
                    $r = fread($filePointer, filesize($fileName));

                    if ($r) {
                        $this->files[$fileID] = $r;
                    }
                    fclose($filePointer);
                }
            }
        }
}
function registerVariables($fileID, $variables) {
        if (is_int($fileID) and is_string($variables)) {
            $file_var = explode(",", $variables);
            if (is_array($file_var)) {
                foreach ($file_var as $value) {
                    $this->variables[$fileID][] = $value;
                }
            }
        }
}
//function removeVariables($fileID, $variables) {
//        if (is_int($fileID) and is_string($variables)) {
//            $file_var = explode(",", $variables);
//            if (is_array($file_var)) {
//                foreach ($file_var as $value) {
//                    if(in_array($value, $this->variables[$fileID]))
//                    {
//                        array_
//                    }
//                }
//            }
//        }
//}

function dropAllVariables($fileID) {
        if (is_int($fileID) && array_key_exists($fileID, $this->files)) {
            $this->variables[$fileID][] = array();
        }
}
function parseSQL($searchFileID,$searchFileVariable, $queryVariable, $updateFileID, $updateVariableArray) {
        //$searchFileID has teh original variable that would be replaced with content of $updateFileID
        //$queryVariable houses the name of actual vatiable in $searchFileID and the imput to the query to be run
        //$updateFileID contains the file whose content would be loaded into the $searchFileID
        //$updateVariableArray is the array that links the vsriable names to the resultset columns
//        ($searchFileID==$updateFileID||(is_string($searchFileVariable) && trim($searchFileVariable)!="")) condition to say that $searchFileVariable is important only when $searchFileID!=$updateFileID
        if (($searchFileID==$updateFileID||(is_string($searchFileVariable) && trim($searchFileVariable)!="")) && is_int($searchFileID) && is_int($updateFileID) && is_string($queryVariable) && trim($queryVariable) != "" && array_key_exists($searchFileID, $this->files)) {
             $resultFound=false; 
            $z = strstr($queryVariable, "=>"); //=> is used to delimit between the actual varaible and the inputs to the prepared query
            $preparedQueryInput = array();
            if ($z) {

                $r = strpos($queryVariable, "=>"); //  get the location of the delimniter =>
                if ($r) {
                    $haystack = substr($queryVariable, $r + 2); // get the sub string of the queryVariable after the delimiter =>
                    $queryVariable = trim(substr($queryVariable, 0, $r));
                    $preparedQueryInput = explode(":", $haystack); // => is used to delimit between the inputs to the prepared statement
                }
            }
            try {

                global $$queryVariable, $dsn, $username, $password;
                $query = $$queryVariable;
                $pdo = new PDO($dsn, $username, $password) or die("Cannot connect to the database");
                $pdoStatement = $pdo->prepare($query);
                $pdo->beginTransaction();
                $b;
                if (is_array($preparedQueryInput) && count($preparedQueryInput) > 0) 
                {
                    $b = $pdoStatement->execute($preparedQueryInput);
                } 
                else 
                {
                    $b = $pdoStatement->execute();
                }          
                if ($b) {
                    if ($pdoStatement->rowCount() > 0) {
                        if (array_key_exists($searchFileID, $this->files)) {
                            
                            if (is_string($updateVariableArray)) 
                            {
                                $updateVariableArray = explode(",", $updateVariableArray);
                            }
                            if ($pdoStatement->columnCount() == count($updateVariableArray)) {
                                $update = "";
                                $resultFound=true;
                                while ($row = $pdoStatement->fetch(PDO::FETCH_NUM)) 
                                    {
                                    if (is_array($row)) {
                                        $innerUpdate = $this->files[$updateFileID];
                                        $index = 0;
                                        while (list($key, $value) = each($row)) {
                                            $updateVariableAndParameters = $updateVariableArray[$index];
                                            if (strstr($updateVariableAndParameters, "=>")) {
                                                $location = strpos($updateVariableAndParameters, "=>"); //  get the location of the delimniter =>
                                                if ($location) {
                                                    $updateParameters = substr($updateVariableAndParameters, $location + 2);
                                                    $updateVariableAndParameters = trim(substr($updateVariableAndParameters, 0, $location));
                                                    $updateParameterArray = explode(",", $updateParameters); // => is used to delimit between the inputs to the prepared statement
                                                    //typical update parameter is index=>file:200,xxxx:3000
                                                    while (list($key, $parameterValuePair) = each($updateParameterArray)) {

                                                        $g = strpos($parameterValuePair, ":");
                                                        $parameter = "";
                                                        $paramVal = "";
                                                        if ($g) {
                                                            $parameter = substr($parameterValuePair, 0, $g);
                                                            $paramVal = substr($parameterValuePair, $g + 1, strlen($parameterValuePair));
                                                        } else {
                                                            $parameter = $parameterValuePair;
                                                        }
                                                        if (trim($parameter) == "file" && file_exists($value) && is_file($value)) {// get all the file content
                                                            $filePointer = fopen($value, "r");
                                                            $readSize = filesize($value);
                                                            if (trim($paramVal) != "") {
                                                                $t = intval($paramVal);
                                                                if ($t) {
                                                                    if ($readSize > $t) {
                                                                        $readSize = $t;
                                                                    }
                                                                }
                                                            }
                                                            $fileContent = fread($filePointer, $readSize);
                                                            $value = $fileContent;
                                                            fclose($filePointer);
                                                        }
                                                    }
                                                }
                                            }
                                            $innerSearchVariable = $this->escape_string_open . $updateVariableAndParameters . $this->escape_string_close;
                                            $innerUpdate = str_replace($innerSearchVariable, $value, $innerUpdate);
                                            $index++;
                                        }
                                        $update.=$innerUpdate;
                                        // when $searchFileID==$updateFileID only the first row data is replaced and the rest are ignored.                                         if($searchFileID==$updateFileID)
                                        if ($searchFileID == $updateFileID) {
                                            break;
                                        }
                                    }
                                    
                                }
                                if (trim($update) != "") {
                                    if ($searchFileID != $updateFileID) {
                                        $fileContent1 = $this->files[$searchFileID];
                                        $toReplace = $this->escape_string_open . $searchFileVariable . $this->escape_string_close;
                                        $fileContent = str_replace($toReplace, $update, $fileContent1);
                                        $this->files[$searchFileID] = $fileContent;
                                        
                                    } else {
                                        $this->files[$searchFileID] = $update;
                                    }
                                }
                            }
                        }
                    }
                }
                else
                {
//                    $e=$pdoStatement->errorInfo();
//                    print $e[2];
                }
                //replace the variables
                if(!$resultFound)
                {
                    if ($searchFileID != $updateFileID) {
                        $fileContent1 = $this->files[$searchFileID];
                        $toReplace = $this->escape_string_open . $searchFileVariable . $this->escape_string_close;
                        $fileContent = str_replace($toReplace, "", $fileContent1);
                        $this->files[$searchFileID] = $fileContent;
                    }
                    else
                    {
                        
                        if(is_array($updateVariableArray))
                        {
                            $fileContent1 = $this->files[$searchFileID];
                            while(list($key,$value)=each($updateVariableArray))
                            { 
                                if(strstr($value, "=>"))
                                {
                                    $dd=  split("=>", $value);
                                    if(is_array($dd))
                                    {
                                        $value=$dd[0];
                                    }
                                }
                                $toReplace = $this->escape_string_open . $value . $this->escape_string_close;
                                $fileContent = str_replace($toReplace, "", $fileContent1);
                                $fileContent1=$fileContent;
                            }
                            $this->files[$searchFileID] = $fileContent1;
                        }
                    }
                    
                }
                $pdo->commit();
                $pdoStatement = null;
                $pdo = null;
            } catch (PDOException $e) {
                if(isset($pdo))
                {
                    if(isset($pdo))
                    {
                        $pdo->rollBack();
                        unset($pdo);
                    }
                    if(isset($pdoStatement))
                    {
                        unset($pdoStatement);
                    }
                }
                
            }
        }
    }

function parseSQLAndVariable($searchFileID,$searchFileVariable, $queryVariable, $updateFileID, $updateVariableArray,$replacementVaraible,$innerCoverFileID,$innerCoverVariable,$innerCoverCount,$sequentailReplacementVariable,$sequentailBaseName,$sequentailBaseNameSuffixindex,$excludeArray,$excludeIndex,$returnIndex,$groupBandVariable,$bandClassNameArray) 
                {
        //$searchFileID has teh original variable that would be replaced with content of $updateFileID
        //$queryVariable houses the name of actual vatiable in $searchFileID and the imput to the query to be run
        //$updateFileID contains the file whose content would be loaded into the $searchFileID
        //$updateVariableArray is the array that links the vsriable names to the resultset columns
        //$replacementVaraible is used to add additional properties. it compares a specific column retured from 
        //the query with a value or array of values, then replaces a variable in $updateFileID a specific value. 
        //format columnIndex:compareType:compareValue:trueReplacement:falseReplacement:variableToReplace
        //=> is used to delimit multiple replacement
        if (($searchFileID==$updateFileID||(is_string($searchFileVariable) && trim($searchFileVariable)!="")) && is_int($searchFileID) && is_int($updateFileID)&& array_key_exists($searchFileID, $this->files)) 
        {
            
            $resultFound=false;
            $replacementColumnIndex;
            $replacementCompareType;
            $replacementCompareValue;
            $replacementCompareTrue;
            $replacementComparefalse;
            $replacementVariableName;
            //is_string($queryVariable) && trim($queryVariable) != "" 
            $returnElement=false;
            $returnedValues=array();
            $bandCount=0;
            if(isset($returnIndex) && is_array($returnIndex) && count($returnIndex)>0)
            {
                $returnElement=true;
            }
            if(is_string($replacementVaraible) && trim($replacementVaraible)!="")
            {
                $replacements=  split("=>", $replacementVaraible);
                if($replacements)
                {
                    while (list($key,$value)=  each($replacements)) 
                    {
                        $j=  split(":", $value);
                        
                        if($j && count($j)==6)
                        {
                            $replacementColumnIndex[]=$j[0];
                            $replacementCompareType[]=$j[1];
                            $replacementCompareValue[]=$j[2];
                            $replacementCompareTrue[]=$j[3];
                            $replacementComparefalse[]=$j[4];
                            $replacementVariableName[]=$j[5];
                        }
                    }
                }
            }
            $returnedArray=array();
            if(is_string($queryVariable) && trim($queryVariable) != "" )
            {
                $z = strstr($queryVariable, "=>"); //=> is used to delimit between the actual varaible and the inputs to the prepared query
                $preparedQueryInput = array();
                if ($z) {

                    $r = strpos($queryVariable, "=>"); //  get the location of the delimniter =>
//                    print $queryVariable;
                    if ($r) {
                        $haystack = substr($queryVariable, $r + 2); // get the sub string of the queryVariable after the delimiter =>
                        $queryVariable = trim(substr($queryVariable, 0, $r));
                        $preparedQueryInput = explode(":", $haystack); // => is used to delimit between the inputs to the prepared statement
                    }
                }
                try 
                {
                    global $$queryVariable, $dsn, $username, $password;
                    $query = $$queryVariable;
                    $pdo = new PDO($dsn, $username, $password) or die("Cannot connect to the database");
                    $pdoStatement = $pdo->prepare($query);
                    $pdo->beginTransaction();
                    $b;
                    if (is_array($preparedQueryInput) && count($preparedQueryInput) > 0) 
                    {
                        for($w=0;$w<count($preparedQueryInput);$w++)
                        {
                            $z=  explode('/', $preparedQueryInput[$w]);
                            if(is_array($z) && count($z)==2)
                            {
                                
                                if($z[1]=="int")
                                {
                                    $pdoStatement->bindValue($w+1, intval($z[0]), PDO::PARAM_INT);
                                }
                                elseif($z[1]=="str")
                                {
                                    $pdoStatement->bindValue($w+1, strval($z[0]), PDO::PARAM_STR);
                                }
                                elseif($z[1]=="bool")
                                {
                                    $pdoStatement->bindValue($w+1,  intval($z[0]) , PDO::PARAM_BOOL);
                                }
                                elseif($z[1]=="lob")
                                {
                                    $pdoStatement->bindValue($w+1, intval($z[0]), PDO::PARAM_LOB);
                                }
                                else
                                {
                                    $pdoStatement->bindValue($w+1, strval($z[0]), PDO::PARAM_STR);
                                }
                            }
                            else
                            {
                                $pdoStatement->bindValue($w+1, $preparedQueryInput[$w], PDO::PARAM_STR);
                            }
                            
                        }
//                        $b = $pdoStatement->execute($preparedQueryInput);
                    } 
                   $b = $pdoStatement->execute();
//                   $gggggg=$pdoStatement->errorInfo();
//                   print "dddddd".$gggggg[2]."<br>";
                    if ($b) 
                    {
                        
                        if ($pdoStatement->rowCount() > 0)
                        {
                            while ($row = $pdoStatement->fetch(PDO::FETCH_NUM)) 
                            {
                                $returnedArray[]=$row;
                            }
                        }
                    }
                    
                    $pdo->commit();
                    unset($pdo); 
                    unset($pdoStatement);
                    
                }
                catch (PDOException $f)
                {
                    if(isset($pdo))
                    {
                        $pdo->rollBack();
                        unset($pdo);
                    }
                    if(isset($pdoStatement))
                    {
                        unset($pdoStatement);
                    }
                    
                }    
            }
            else if(is_array($queryVariable))
            {
                $returnedArray=$queryVariable;
            }
 
            if ($b) {

                    if (array_key_exists($searchFileID, $this->files)) {
                        if (is_string($updateVariableArray)) {
                            $updateVariableArray = explode(",", $updateVariableArray);
                        }
                        if(is_array($returnedArray) && count($returnedArray)>0)
                        {


                            $rowCount=count($returnedArray);
                            if(is_array($returnedArray[0]) && count($returnedArray[0])>0)
                            {
                                $columnCount=count($returnedArray[0]);
                                if($columnCount>=count($updateVariableArray))
                                { 

                                    $update = "";
                                    $resultFound=true;
                                    $innerRequired=false;
                                    $innerCurrentCount=1;
                                    $currentRow=0;
                                    $innerUpdateHold="";
                                    $sequentailBaseNameSuffix="";
                                    $excludeRequired=false;
                                    if(isset($excludeArray) && count($excludeArray)>0 && is_int($excludeIndex))
                                    {
                                        $excludeRequired=true;
                                    }
//                                        print parse_str($innerCoverFileID)  ." kkk  $innerCoverVariable kkkk". $innerCoverCount;
                                    if(isset($innerCoverFileID) && is_int($innerCoverFileID) && isset($innerCoverVariable) && is_string($innerCoverVariable) && trim($innerCoverVariable)!="" && isset($innerCoverCount) && is_int($innerCoverCount))
                                    {
                                        $innerRequired=true;
                                    }
                                    while (list($rt,$row) = each($returnedArray)) 
                                        {
                                        $currentRow++;
                                        $excludePassed=true;
                                        if (is_array($row))
                                        {
                                            if($returnElement)
                                            {
                                                $returnRowValues=array();
                                                for($hj=0;$hj<count($returnIndex);$hj++)
                                                {
                                                    $returnIndexValue;
                                                    $pj=$returnIndex[$hj];
                                                    if($pj>=0 && $pj<count($row))
                                                    {
                                                        $returnIndexValue=  $row[$pj];
                                                    }
                                                    $returnRowValues[]=$returnIndexValue;
                                                }
                                                $returnedValues[]=$returnRowValues;
                                            }
                                            if($excludeRequired && count($row)>$excludeIndex)
                                            {
                                                if(in_array($row[$excludeIndex], $excludeArray))
                                                {
                                                    $excludePassed=false;
                                                }
                                            }
                                            if($excludePassed)
                                            {
                                                    $innerUpdate = $this->files[$updateFileID];
                                                    $index = 0;
                                                    $innerCurrentCount++;
                                                    while (list($key, $value) = each($row)) {
                                                        //compare and replace replacement variables

                                                        if(in_array($key, $replacementColumnIndex))
                                                        {
                                                            $subArray=array_keys($replacementColumnIndex, $key);
                                                            if($subArray)
                                                            {
                                                                for($r=0;$r<count($subArray);$r++)
                                                                {
                                                                    $replacementIndex=$subArray[$r];
                                                                    $comparismReturn=false;
                                                                    $rep="";
                                                                    $compValue=  split("<>", $replacementCompareValue[$replacementIndex]);
                                                                    if(is_array($compValue))
                                                                    {
                                                                        for($rrr=0;$rrr<count($compValue);$rrr++)
                                                                        {
                                                                            $comp=$compValue[$rrr];
                                                                            if($replacementCompareType[$replacementIndex]=="==")
                                                                            {
                                                                                if($value==$comp)
                                                                                {
                                                                                    $comparismReturn=true;
                                                                                    break;
                                                                                }
                                                                            }
                                                                            else if($replacementCompareType[$replacementIndex]==">=")
                                                                            {
                                                                                if($value>=$comp)
                                                                                {
                                                                                    $comparismReturn=true;
                                                                                    break;
                                                                                }
                                                                            }
                                                                            else if($replacementCompareType[$replacementIndex]=="<=")
                                                                            {
                                                                                if($value<=$comp)
                                                                                {
                                                                                    $comparismReturn=true;
                                                                                    break;
                                                                                }
                                                                            }
                                                                            else if($replacementCompareType[$replacementIndex]==">")
                                                                            {
                                                                                if($value>$comp)
                                                                                {
                                                                                    $comparismReturn=true;
                                                                                    break;
                                                                                }
                                                                            }
                                                                            else if($replacementCompareType[$replacementIndex]=="<")
                                                                            {
                                                                                if($value<$comp)
                                                                                {
                                                                                    $comparismReturn=true;
                                                                                    break;
                                                                                }
                                                                            }
                                                                            else if($replacementCompareType[$replacementIndex]=="!=")
                                                                            {
                                                                                if($value!=$comp)
                                                                                {
                                                                                    $comparismReturn=true;
                                                                                    break;
                                                                                }
                                                                            }
                                                                        }
                                                                    }

                                                                    if($comparismReturn)
                                                                    {
                                                                        $rep=$replacementCompareTrue[$replacementIndex];
                                                                    }
                                                                    else
                                                                    {
                                                                        $rep=$replacementComparefalse[$replacementIndex];
                                                                    }
                                                                    $innerSearchVariable = $this->escape_string_open . $replacementVariableName[$replacementIndex] . $this->escape_string_close;
                                                                    $innerUpdate = str_replace($innerSearchVariable, $rep, $innerUpdate);
                                                                }
                                                            }
                                                        }
                                                        //ond of compare and replace replacement variables
                                                        $updateVariableAndParameters = $updateVariableArray[$index];
                                                        if (strstr($updateVariableAndParameters, "=>")) {
                                                            $location = strpos($updateVariableAndParameters, "=>"); //  get the location of the delimniter =>
                                                            if ($location) {
                                                                $updateParameters = substr($updateVariableAndParameters, $location + 2);
                                                                $updateVariableAndParameters = trim(substr($updateVariableAndParameters, 0, $location));
                                                                $updateParameterArray = explode(",", $updateParameters); // => is used to delimit between the inputs to the prepared statement
                                                                //typical update parameter is index=>file:200,xxxx:3000
                                                                while (list($key, $parameterValuePair) = each($updateParameterArray)) {

                                                                    $g = strpos($parameterValuePair, ":");
                                                                    $parameter = "";
                                                                    $paramVal = "";
                                                                    if ($g) {
                                                                        $parameter = substr($parameterValuePair, 0, $g);
                                                                        $paramVal = substr($parameterValuePair, $g + 1, strlen($parameterValuePair));
                                                                    } else {
                                                                        $parameter = $parameterValuePair;
                                                                    }
                                                                    if (trim($parameter) == "file" && file_exists($value) && is_file($value)) {// get all the file content
                                                                        $filePointer = fopen($value, "r");
                                                                        $readSize = filesize($value);
                                                                        if (trim($paramVal) != "") {
                                                                            $t = intval($paramVal);
                                                                            if ($t) {
                                                                                if ($readSize > $t) {
                                                                                    $readSize = $t;
                                                                                }
                                                                            }
                                                                        }
                                                                        $fileContent = fread($filePointer, $readSize);
                                                                        $value = $fileContent;
                                                                        fclose($filePointer);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        $innerSearchVariable = $this->escape_string_open . $updateVariableAndParameters . $this->escape_string_close;
                                                        $innerUpdate = str_replace($innerSearchVariable, $value, $innerUpdate);
                                                        $index++;
                                                    }
                                                    //replace sequentail Varaible
                                                    if(isset($sequentailReplacementVariable) && isset($sequentailBaseName))
                                                    {
                                                        if(is_string($sequentailReplacementVariable) && is_string($sequentailBaseName) && trim($sequentailReplacementVariable)!="" && trim($sequentailBaseName)!="")
                                                        {
                                                            $sequentailReplacementVariable=array($sequentailReplacementVariable);
                                                            $sequentailBaseName=array($sequentailBaseName);
                                                        }
                                                        if(isset($sequentailReplacementVariable) && is_array($sequentailReplacementVariable) && isset($sequentailBaseName)  && is_array($sequentailBaseName) && count($sequentailBaseName)==  count($sequentailReplacementVariable))
                                                        {
                                                            $sequentailBaseNameSuffix=$currentRow;
                                                            if(isset($sequentailBaseNameSuffixindex) && is_int($sequentailBaseNameSuffixindex))
                                                            {
                                                                if($sequentailBaseNameSuffixindex<count($row))
                                                                {
                                                                    $sequentailBaseNameSuffix=$row[$sequentailBaseNameSuffixindex];
                                                                }
                                                            }
                                                            for($dd=0;$dd<count($sequentailBaseName);$dd++)
                                                            {
                                                                $currentSequentailReplacementVariable=$sequentailReplacementVariable[$dd];
                                                                $currentSequentailBaseName=$sequentailBaseName[$dd];
                                                                if(isset($currentSequentailBaseName) && isset($currentSequentailReplacementVariable) && $currentSequentailBaseName!=NULL && $currentSequentailReplacementVariable!=NULL && trim($currentSequentailBaseName)!="" && trim($currentSequentailReplacementVariable)!="")
                                                                {
                                                                    $seachVariable = $this->escape_string_open . $currentSequentailReplacementVariable . $this->escape_string_close;
                                                                    if(strstr($innerUpdate, $seachVariable))
                                                                    {
                                                                        $innerUpdate = str_replace($seachVariable, $currentSequentailBaseName.$sequentailBaseNameSuffix, $innerUpdate);
                                                                    }
                                                                }
                                                            }

                                                        }
                                                    }
    //                                                if(isset($sequentailReplacementVariable) && $sequentailReplacementVariable!=NULL && trim($searchFileVariable)!="" && isset($sequentailBaseName) && $sequentailBaseName!=NULL && trim($sequentailBaseName)!="")
    //                                                {
    //                                                    $seachVariable = $this->escape_string_open . $sequentailReplacementVariable . $this->escape_string_close;
    //                                                    if(strstr($innerUpdate, $seachVariable))
    //                                                    {
    //
    //                                                        $innerUpdate = str_replace($seachVariable, $sequentailBaseName.$currentRow, $innerUpdate);
    //                                                    }
    //                                                }
                                                    // place replacement in inner elements
                                                    if($innerRequired)
                                                    {
                                                        $innerUpdateHold.=$innerUpdate;
                                                        if(($innerCurrentCount> $innerCoverCount) || $currentRow>$rowCount-1)
                                                        {
                                                            $fileContentInner = $this->files[$innerCoverFileID];
                                                            $toReplaceInner = $this->escape_string_open . $innerCoverVariable . $this->escape_string_close;
                                                            $innerUpdateHold = str_replace($toReplaceInner, $innerUpdateHold, $fileContentInner);
                                                            if(isset($groupBandVariable) && trim($groupBandVariable!=""))
                                                            {
                                                                $tp="";
                                                                if(is_array($bandClassNameArray) && count($bandClassNameArray)>0 )
                                                                {
                                                                    if($bandCount>count($bandClassNameArray)-1)
                                                                    {
                                                                        $bandCount=0;
                                                                    }
                                                                    $tp=$bandClassNameArray[$bandCount];
                                                                }  
                                                                $toReplaceInner = $this->escape_string_open . $groupBandVariable . $this->escape_string_close;
                                                                $innerUpdateHold = str_replace($toReplaceInner, $tp, $innerUpdateHold);
                                                                $bandCount++;
                                                            }
                                                                
                                                            $update.=$innerUpdateHold;
                                                            $innerCurrentCount=1;
                                                            $innerUpdateHold="";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $update.=$innerUpdate;
                                                    }

                                                    // when $searchFileID==$updateFileID only the first row data is replaced and the rest are ignored.                                         if($searchFileID==$updateFileID)
                                                    if ($searchFileID == $updateFileID) {
                                                        break;
                                                    }
                                            }
                                        }
                                    }
                                    if (trim($update) != "") {
                                        if ($searchFileID != $updateFileID) {
                                            $fileContent1 = $this->files[$searchFileID];
                                            $toReplace = $this->escape_string_open . $searchFileVariable . $this->escape_string_close;
                                            $fileContent = str_replace($toReplace, $update, $fileContent1);
                                            $this->files[$searchFileID] = $fileContent;

                                        } else {
                                            $this->files[$searchFileID] = $update;
                                        }
                                    }

                                }
                            }
                        }
                    }
            }
            if(!$resultFound)
            {
                if ($searchFileID != $updateFileID) {
                    $fileContent1 = $this->files[$searchFileID];
                    $toReplace = $this->escape_string_open . $searchFileVariable . $this->escape_string_close;
                    $fileContent = str_replace($toReplace, "", $fileContent1);
                    $this->files[$searchFileID] = $fileContent;
                }
                else
                {

                    if(is_array($updateVariableArray))
                    {
                        $fileContent1 = $this->files[$searchFileID];
                        while(list($key,$value)=each($updateVariableArray))
                        { 
                            if(strstr($value, "=>"))
                            {
                                $dd=  split("=>", $value);
                                if(is_array($dd))
                                {
                                    $value=$dd[0];
                                }
                            }
                            $toReplace = $this->escape_string_open . $value . $this->escape_string_close;
                            $fileContent = str_replace($toReplace, "", $fileContent1);
                            $fileContent1=$fileContent;
                        }
                        $this->files[$searchFileID] = $fileContent1;
                    }
                }

            }
            if($returnElement)
            {
                return $returnedValues;
            }
        } 
    }
function returnDynamicQuery($query,$replacementArray)
{
    //$replacementArray key is variable to be replaced value is replacement.
    if(isset($query) && is_string($query) && trim($query)!="")
    {
        if(isset($replacementArray) && count($replacementArray)>0)
        {
            while(list($key,$value)=  each($replacementArray))
            {
                if(isset($key) && is_string($key) && trim($key)!="")
                {
                    if(!isset($value) || !is_string($value))
                    {
                        $value="";
                    }
                    $seachVariable = $this->escape_string_open . $key . $this->escape_string_close;
                    $query = str_replace($seachVariable, $value, $query);
                }
                
            }
        }
    }
    return $query;
}
function parseFile($fileID) {
        $fileContent = $this->files[$fileID];
        
        
        if (is_string($fileContent)) {
            $variablesCount = sizeof($this->variables[$fileID]);
            for ($r = 0; $r < $variablesCount; $r++) {
                $varaiableName = $this->variables[$fileID][$r];
                GLOBAL $$varaiableName;
                $seachVariable = $this->escape_string_open . $varaiableName . $this->escape_string_close;
                $fileContent = str_replace($seachVariable, $$varaiableName, $fileContent);
            }
            $this->files[$fileID] = $fileContent;
        }
    }
function insertFile($mainFileID, $variableName, $subFileID) {
        if (is_int($mainFileID) && is_string($variableName) && trim($variableName) != "" && is_int($subFileID)) {
            if (array_key_exists($mainFileID, $this->files) && array_key_exists($subFileID, $this->files)) {
                $seachVariable = $this->escape_string_open . $variableName . $this->escape_string_close;
                $fileContent = str_replace($seachVariable, $this->files[$subFileID], $this->files[$mainFileID]);
                $this->files[$mainFileID] = $fileContent;
            }
        }
    }
function deleteVariable($fileID, $variableName) {
        if (is_int($fileID) && is_string($variableName)) {
            if (array_key_exists($fileID, $this->files)) {
                $seachVariable = $this->escape_string_open . $variableName . $this->escape_string_close;
                $fileContent = str_replace($seachVariable, "", $this->files[$fileID]);
                $this->files[$fileID] = $fileContent;
            }
        }
    }
function printFile($fileID,$leaveUnparsed) {
        if (is_int($fileID)) {
            $f=$this->files[$fileID];
            if(!$leaveUnparsed)
            {
                $e=  $this->escape_string_open."[a-z A-Z 0-9 !@#$%^*()_+]*".  $this->escape_string_close;
                $f=ereg_replace($e, "", $f);
            }
            print($f);
//             print($this->files[$fileID]);
        }
       
    }
function returnFile($fileID)
{
    if (is_int($fileID)) {
            return ($this->files[$fileID]);
        }
}
function returnSequentialFileUpdateWithRange($fileID,$start,$end,$interval,$default,$valueVariableName,$displayVaraibleName,$defaultVariable,$defaultVariableReplacement,$otherVariables)
{
    if (is_int($fileID) && array_key_exists($fileID, $this->files)) 
    {
        $trueStart=$start;
        $trueEnd=$end;
        $flipRequire=false;
        $seqencialData=array();
        if(!is_int($interval)|| $interval<=0)
        {
            $interval=1;
        }
        if($start>$end)
        {
            $trueStart=$end;
            $trueEnd=$start;
            $flipRequire=TRUE;
        }
        $returnedContent="";
        $fileContent=$this->files[$fileID];
        $s=strstr($fileContent, $valueVariableName);
        if($s)
        {
            {
                $intervalStart=$trueStart;
                $intervalEnd=0;
                while(true)
                {
                    $intervalEnd=$interval+$intervalStart-1;
                    if($intervalEnd>$trueEnd)
                    {
                        $intervalEnd=$trueEnd;
                    }
                    if($intervalStart==$intervalEnd)
                    {
                        $seqencialData[$intervalStart]=  strval($intervalStart);
                    }
                    else
                    {
                        $seqencialData[$intervalStart]=  strval($intervalStart)." - ".strval($intervalEnd);
                    }
                    $intervalStart=$intervalEnd+1;
                    if($intervalStart>$trueEnd)
                    {
                        if(is_array($seqencialData) && count($seqencialData)>0)
                        {
                            if($flipRequire)
                            {
                                $seqencialData=array_reverse($seqencialData, TRUE);
                            }
                        }
                        break;
                    }
                }
            } 
            while(list($key,$value)=  each($seqencialData))
            {
                
                $temp=$fileContent;
                $r=  str_replace($this->escape_string_open.$valueVariableName.$this->escape_string_close, $key, $temp);
                if(isset($displayVaraibleName) && trim($displayVaraibleName)!="")
                {
                    $r=  str_replace($this->escape_string_open.$displayVaraibleName.$this->escape_string_close,$value, $r);
                }
                if (isset($otherVariables) && is_array($otherVariables))
                {
                    while(list($key2,$value2)=  each($otherVariables))
                    {
                        $r=  str_replace($this->escape_string_open.$key2.$this->escape_string_close, $value2, $r);
                    }
                }
                if($key==$default)
                {
                    $r=  str_replace($this->escape_string_open.$defaultVariable.$this->escape_string_close, $defaultVariableReplacement, $r);
                }
                else
                {
                    $r=  str_replace($this->escape_string_open.$defaultVariable.$this->escape_string_close, "", $r);
                }
                $returnedContent.=$r;
            }
        }
        return $returnedContent;
    }
}
function returnArrayFileUpdate($fileID,$contentArray,$replacementTextArray,$replacementIndexArray,$defaultValue,$defaultValueText,$defaultValueReplacement)
{
    $returnedText="";
    if (is_int($fileID) && array_key_exists($fileID, $this->files)) 
    {
        if(is_array($contentArray) && count($contentArray)>0)
        {
            if(is_array($replacementTextArray) && is_array($replacementIndexArray) && count($replacementIndexArray)>0 && count($replacementTextArray)==count($replacementIndexArray))
            {
                $fileContent=$this->files[$fileID];
                while(list($key,$value)=each($contentArray))
                {
                    if(isset($value))
                    {
                         $tempUpdate="$fileContent";
                         $repFound=false;
                         for($l=0;$l<count($replacementTextArray);$l++)
                         {
                             $repText=$replacementTextArray[$l];
                             $repVal="";
                             if(isset($repText) && trim($repText)!="")
                             {
                                 $repFound=true;
                                 $valIndex=$replacementIndexArray[$l];
                                 if(isset($valIndex))
                                 {
                                     $valIndex=  intval($valIndex);
                                     if($valIndex==1)
                                     {
                                         $repVal=$value;
                                     }
                                     else if($valIndex==0)
                                     {
                                         $repVal=$key;
                                     }
                                 }
                                $tempUpdate=  str_replace($this->escape_string_open.$repText.$this->escape_string_close, $repVal, $tempUpdate);
                             }
                         }
                         if($repFound)
                         {
                             if(isset($defaultValueText) && trim($defaultValueText)!="")
                             {
                                 $defaultRep="";
                                 if(isset($defaultValue) && trim($defaultValue)==  strval($value))
                                 {
                                     if(isset($defaultValueReplacement) && trim($defaultValueReplacement)!="")
                                     {
                                         $defaultRep=$defaultValueReplacement;
                                     }
                                 }
                                $tempUpdate=  str_replace($this->escape_string_open.$defaultValueText.$this->escape_string_close, $defaultRep, $tempUpdate); 
                             }
                              $returnedText.=$tempUpdate;
                         }
                        
                    }
                }
            }
        }
    }
    return $returnedText;
}
function returnSequentialFileUpdate($fileID,$start,$end,$default,$serialVariable,$otherSerailVaraibleName,$otherSerialArray,$defaultVariable,$defaultVariableReplacement,$otherVariables,$prefix,$suffix,$showSign)
{
    // $serialVariable is the variable to be updated each time the count moves from star to end
    //$otherSerailVaraibleName would be updated by $otherSerialArray when pressent and updated by count if $otherSerialArray is null
    //$otherSerialArray used to replace other $otherSerailVaraibleName if available
    //$otherVariables key of this array is repalced by the value for all elements of the array
    if (is_int($fileID) && array_key_exists($fileID, $this->files)) 
    {
        $step=1;
        $x=$start;
        $k=0;
        if($start>$end)
        {
            $step=-1;
        }
        $returnedContent="";
        $fileContent=$this->files[$fileID];
        $s=strstr($fileContent, $serialVariable);
        $isSerialArray=is_array($otherSerialArray);
        if(!isset($suffix))
        {
            $suffix="";
        }
        if(!isset($prefix))
        {
            $prefix="";
        }
        
        if($s)
        {
            while(true)
            {
                $temp=$fileContent;
                $r=  str_replace($this->escape_string_open.$serialVariable.$this->escape_string_close, $x, $temp);
                $z=$x;
                if($showSign)
                {
                    if($x>0)
                    {
                        $z="+".$x;
                    }
                    else  if($x<0)
                    {
                        $z=$x;
                    }
                    else
                    {
                        $z="";
                    }
                }
                if(isset($otherSerailVaraibleName) && trim($otherSerailVaraibleName)!="")
                {
                    if($isSerialArray && $k<count($otherSerialArray))
                    {
                        $r=  str_replace($this->escape_string_open.$otherSerailVaraibleName.$this->escape_string_close, $prefix.$otherSerialArray[$k].$suffix, $r);
                    }
                    else 
                    {
                        $r=  str_replace($this->escape_string_open.$otherSerailVaraibleName.$this->escape_string_close, $prefix.$z.$suffix, $r);
                    }
                }
                else
                {
                    $r=  str_replace($this->escape_string_open.$otherSerailVaraibleName.$this->escape_string_close, $prefix.$z.$suffix, $r);
                    
                }
                
                if (isset($otherVariables) && is_array($otherVariables))
                {
                    while(list($key,$value)=  each($otherVariables))
                    {
                        $r=  str_replace($this->escape_string_open.$key.$this->escape_string_close, $value, $r);
                    }
                }
                if($x==$default)
                {
                    $r=  str_replace($this->escape_string_open.$defaultVariable.$this->escape_string_close, $defaultVariableReplacement, $r);
                }
                else
                {
                    $r=  str_replace($this->escape_string_open.$defaultVariable.$this->escape_string_close, "", $r);
                }
                $returnedContent.=$r;
                if($step==1)
                {
                    $x++;
                    if($x>$end)
                    {
                        break;
                    }
                    
                }
                else if($step==-1)
                {
                    $x--;
                    if($x<$end)
                    {
                        break;
                    }
                }
                $k++;
            }
        }
        return $returnedContent;
    }
}
    }
?>
