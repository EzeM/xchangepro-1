<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();                
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
include '../template/passwordVerificationFunctions.php';
include '../template/DatabaseConnection.php';
include '../template/ManageGenericInput.php';
include '../template/DatabaseCurrencyMethods.php';
$userID=$_SESSION["userID"];
if(isset($userID) && trim($userID)!="")
{
    $temp=new template();
    $databaseConnection=new DatabaseConnection();
    $currencyMethods=new DatabaseCurrencyMethods();
    $pdo=$databaseConnection->getConnection();
    $transactionIndex="0";
    $toConvertCurrencyAlias="";
    $toConvertCurrency="";
    $totalValue=0;
    $tempVal=$_GET['tempID'];
    if(!isset($tempVal) || trim($tempVal)=="")
    {
        $tempVal=$_POST['tempID'];
    }
    if(isset($tempVal) && trim($tempVal)!="")
    {
        $transactionIndex="$tempVal";
    }
    $tempVal=$_GET['toCurrency'];
    if(!isset($tempVal) || trim($tempVal)=="")
    {
        $tempVal=$_POST['toCurrency'];
    }
     if(isset($tempVal) && trim($tempVal)!="")
     {
         //verify currency
         $toConvertCurrency="$tempVal";
         if($currencyMethods->verifyCurrencyID($toConvertCurrency, $verify_currency))
         {
             $toConvertCurrencyAlias=$currencyMethods->getCurrencyElement($toConvertCurrency, $get_currency_alias);
             
             $temp->registerFiles(1, "../page_segments/fundConversionPanelRowNotEditable.html");
             $temp->registerFiles(2, "../page_segments/fundConversionPanelNotEditable.html");
             $temp->registerVariables(2, "toConvertCurrencyAlias,totalValue");
             $replacementVariable=array("convertedValue","convertCurrencyAlias");
             $returnedValue=$temp->parseSQLAndVariable(2, "currencies", "get_temp_condition_exchange_info=>$transactionIndex", 1, array("toConvertCurrencyID","convertCurrencyID","xRate","initValue"), "", "", "", "", $replacementVariable, $replacementVariable, 1, "", "", array(1,2,3), "", "");
             $onlyOneCurrencySubmited=false;
             if(is_array($returnedValue))
             {
                 for($t=0;$t<count($returnedValue);$t++)
                 {
                     $inner=$returnedValue[$t];
                     if(is_array($returnedValue) && count($inner)==3)
                     {
                         $convertID=$inner[0];
                         $exchangeRate=$inner[1];
                         $currentVal=$inner[2];
                         if($convertID==$toConvertCurrency)
                         {
                             if(count($returnedValue)==1)
                             {
                                 $onlyOneCurrencySubmited=true;
                                 break;
                             }
                         }
                         {
                            $currencyAlias=$currencyMethods->getCurrencyElement($convertID, $get_currency_alias);
                            if(isset($currencyAlias) && trim($currencyAlias)!="")
                            {
                                $temp->replaceString(2, "convertCurrencyAlias$convertID", $currencyAlias);
                            }
                                $exchangeRate=doubleval($exchangeRate);
                                $currentVal=doubleval($currentVal);
                                $temp->replaceString(2, "convertedValue$convertID", number_format($currentVal*$exchangeRate,2,'.',''));
                                $totalValue+=$currentVal*$exchangeRate;
                        } 
                         
                     }
                 }
                 
             }
             if($totalValue>0 && !$onlyOneCurrencySubmited)
             {
                 $totalValue=  number_format($totalValue, 2, '.', '');
                 $temp->parseFile(2);
                 $temp->printFile(2, true);
             }
             else
             {
                 
             }
                 
         }
     }
}
?>