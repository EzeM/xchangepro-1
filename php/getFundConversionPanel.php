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
    $sumSource="";
    $toConvertCurrencyAlias="";
    $toConvertCurrency="";
    $totalValue=0;
    $required=0.00;
    $tempVal=$_GET['handle'];
    if(!isset($tempVal) || trim($tempVal)=="")
    {
        $tempVal=$_POST['handle'];
    }
    if(isset($tempVal) && trim($tempVal)!="")
    {
        $transactionIndex="$tempVal";
    }
    $tempVal=$_GET['required'];
    if(!isset($tempVal) || trim($tempVal)=="")
    {
        $tempVal=$_POST['required'];
    }
    if(isset($tempVal) && trim($tempVal)!="")
    {
        $required=  doubleval($tempVal);
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
             
             $temp->registerFiles(1, "../page_segments/fundConversionPanelRow.html");
             $temp->registerFiles(2, "../page_segments/fundConversionPanel.html");
             $temp->registerVariables(2, "transactionIndex,toConvertCurrencyAlias,totalValue,sumSource");
             $replacementVariable=array("initValue","convertedValue","convertCurrencyAlias","toConvertCurrency", "convertCurrency","currencyConversion","value","rate");
             $returnedValue=$temp->parseSQLAndVariable(2, "currencies", "get_exhange_information_1=>$userID:$toConvertCurrency", 1, array("toConvertCurrencyID","convertCurrencyID","xRate","maxValue"), "", "", "", "", $replacementVariable, $replacementVariable, 1, "", "", array(1,2,3), "", "");
             $selectCurrencyMax=0;
             $initSelectCurrencyNeeded=true;
             if(is_array($returnedValue))
             {
                 for($t=0;$t<count($returnedValue);$t++)
                 {
                     $inner=$returnedValue[$t];
                     if(is_array($returnedValue) && count($inner)==3)
                     {
                         $convertID=$inner[0];
                         $sumSource.="value$convertID$transactionIndex:";
                         $exchangeRate=$inner[1];
                         $max=$inner[2];
                         if($convertID==$toConvertCurrency)
                        {
                            $selectCurrencyMax=doubleval($max);
                        }
                         {
                            $currencyAlias=$currencyMethods->getCurrencyElement($convertID, $get_currency_alias);
                            if(isset($currencyAlias) && trim($currencyAlias)!="")
                            {
                                $temp->replaceString(2, "convertCurrencyAlias$convertID", $currencyAlias);
                            }
                            $tempVal=$_GET["currencyConversion$convertID$transactionIndex"];
                            if(!isset($tempVal) || trim($tempVal)=="")
                            {
                               $tempVal=$_POST["currencyConversion$convertID$transactionIndex"];
                            }
                           
                            if(isset($tempVal) && trim($tempVal)!="")
                            {
                                
                                $tempVal=doubleval($tempVal);
                                $exchangeRate=doubleval($exchangeRate);
                                $max=doubleval($max);
                                $initSelectCurrencyNeeded=false;
                                
                                if($tempVal<$max)
                                {
                                     $temp->replaceString(2, "initValue$convertID", number_format($tempVal, 2, '.',""));
                                     $temp->replaceString(2, "convertedValue$convertID", number_format($tempVal*$exchangeRate,2,'.',''));
                                     $totalValue+=$tempVal*$exchangeRate;
                                }
                                else
                                {
                                    $temp->replaceString(2, "initValue$convertID", "0.00");
                                    $temp->replaceString(2, "convertedValue$convertID", "0.00");
                                }
                            }
                            else
                            {
                                if($convertID!=$toConvertCurrency)
                                {
                                    $temp->replaceString(2, "initValue$convertID", "0.00");
                                    $temp->replaceString(2, "convertedValue$convertID", "0.00");
                                }
                            }
                        } 
                     }
                 }
             }
             if($initSelectCurrencyNeeded)
             {
                 $t=0;
                
                 if($required>$selectCurrencyMax)
                 {
                     $t=$selectCurrencyMax;
                 }
                 else
                 {  
                     $t=$required;
                 }
                 $temp->replaceString(2, "initValue$toConvertCurrency", number_format($t, 2, '.',""));
                 $temp->replaceString(2, "convertedValue$toConvertCurrency", number_format($t,2,'.',''));
                 $totalValue+=$t;
             }
             else
             {
                 $temp->replaceString(2, "initValue$toConvertCurrency", "0.00");
                 $temp->replaceString(2, "convertedValue$toConvertCurrency", "0.00");
             }
             $totalValue=  number_format($totalValue, 2, '.', '');
             $temp->parseFile(2);
             $temp->printFile(2, true);
         }
     }
}
?>