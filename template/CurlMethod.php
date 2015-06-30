<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CurlMethod
 *
 * @author meze
 */
class CurlMethod {
    //put your code here
    function getConditionForUse($variableArray)
    {
        
        $filePath="http://localhost/xchange-pro/php/getConditionForUse.php";
        $pathFieldsArray=array();
        while(list($key,$value)=  each($variableArray))
        {
            $pathFieldsArray[]=urlencode("$key")."=".urlencode("$value");
        }
        $pathFields=implode('&', $pathFieldsArray);
        $curlHandle=curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $filePath);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $pathFields);
        curl_setopt($curlHandle, CURLOPT_COOKIE, "PHPSESSID=".  session_id());
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        session_write_close();
        $condition=curl_exec($curlHandle);
        curl_close($curlHandle);
        return $condition;
    }
    function getTempConditionSummary($variableArray)
    {
        
        $filePath="http://localhost/xchange-pro/php/getTempConditionSummary.php";
        $pathFieldsArray=array();
        while(list($key,$value)=  each($variableArray))
        {
            $pathFieldsArray[]=urlencode("$key")."=".urlencode("$value");
        }
        $pathFields=implode('&', $pathFieldsArray);
        $curlHandle=curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $filePath);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $pathFields);
        curl_setopt($curlHandle, CURLOPT_COOKIE, "PHPSESSID=".  session_id());
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        session_write_close();
        $condition=curl_exec($curlHandle);
        curl_close($curlHandle);
        return $condition;
    }
    function getTempFundsConverionPanel($variableArray)
    {
        $filePath="http://localhost/xchange-pro/php/getNotEditableFundConversionPanel.php";
        $pathFieldsArray=array();
        while(list($key,$value)=  each($variableArray))
        {
            $pathFieldsArray[]=urlencode("$key")."=".urlencode("$value");
        }
        $pathFields=implode('&', $pathFieldsArray);
        $curlHandle=curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $filePath);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $pathFields);
        curl_setopt($curlHandle, CURLOPT_COOKIE, "PHPSESSID=".  session_id());
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        session_write_close();
        $panel=curl_exec($curlHandle);
        curl_close($curlHandle);
        return $panel;
    }
    function getFundsConverionPanel($variableArray)
    {
        $filePath="http://localhost/xchange-pro/php/getFundConversionPanel.php";
        $pathFieldsArray=array();
        while(list($key,$value)=  each($variableArray))
        {
            $pathFieldsArray[]=urlencode("$key")."=".urlencode("$value");
        }
        $pathFields=implode('&', $pathFieldsArray);
        $curlHandle=curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $filePath);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $pathFields);
        curl_setopt($curlHandle, CURLOPT_COOKIE, "PHPSESSID=".  session_id());
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        session_write_close();
        $panel=curl_exec($curlHandle);
        curl_close($curlHandle);
        return $panel;
    }
    function getProductImagePanel($variableArray)
    {
        $filePath="http://localhost/xchange-pro/php/addProductImagePanel1.php";
        $pathFieldsArray=array();
        while(list($key,$value)=  each($variableArray))
        {
            $pathFieldsArray[]=urlencode("$key")."=".urlencode("$value");
        }
        $pathFields=implode('&', $pathFieldsArray);
        $curlHandle=curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $filePath);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $pathFields);
        curl_setopt($curlHandle, CURLOPT_COOKIE, "PHPSESSID=".  session_id());
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        session_write_close();
        $signature=curl_exec($curlHandle);
        curl_close($curlHandle);
        return $signature;
    }
    function getUserSignaturePanel($variableArray)
    {
        $filePath="http://localhost/xchange-pro/php/addSignaturePanel.php";
        $pathFieldsArray=array();
        while(list($key,$value)=  each($variableArray))
        {
            $pathFieldsArray[]=urlencode("$key")."=".urlencode("$value");
        }
        $pathFields=implode('&', $pathFieldsArray);
        $curlHandle=curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $filePath);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $pathFields);
        curl_setopt($curlHandle, CURLOPT_COOKIE, "PHPSESSID=".  session_id());
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        session_write_close();
        $signature=curl_exec($curlHandle);
        curl_close($curlHandle);
        return $signature;
    }
    function getCaptcha($oldIndex,$standAloneStatus,$identifierSuffix)
    {
        $filePath="http://localhost/xchange-pro/php/captcha.php";
        $pathFields.=urlencode("standAlone")."=".urlencode($standAloneStatus)."&";
        if(isset($identifierSuffix) && trim($identifierSuffix)!="")
        {
            $pathFields.=urlencode("suffix")."=".urlencode($identifierSuffix)."&";
        }
        if(isset($oldIndex) && trim($oldIndex)!="")
        {
             $pathFields.=urlencode("index")."=".urlencode($oldIndex);
        }
        $curlHandle=curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $filePath);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $pathFields);
        curl_setopt($curlHandle, CURLOPT_COOKIE, "PHPSESSID=".  session_id());
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        session_write_close();
        $captcha=curl_exec($curlHandle);
        curl_close($curlHandle);
        return $captcha;
    }
    function validateCaptcha($captcha_index,$captcha_value)
    {
        $errorPage5="";
        if((isset($captcha_index) && trim($captcha_index)!=""))
        {
            if(isset($captcha_value) && trim($captcha_value)!="")
            {
                $filePath="http://localhost/xchange-pro/php/validateCaptcha.php";
                $pathFields.=urlencode("captcha_value")."=".urlencode($captcha_value)."&";
                $pathFields.=urlencode("captcha_index")."=".urlencode($captcha_index)."&";
                $curlHandle=curl_init();
                curl_setopt($curlHandle, CURLOPT_URL, $filePath);
                curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curlHandle, CURLOPT_POST, 1);
                curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $pathFields);
                curl_setopt($curlHandle, CURLOPT_COOKIE, "PHPSESSID=".  session_id());
                curl_setopt($curlHandle, CURLOPT_HEADER, 0);
                session_write_close();
                $captchaResponse=curl_exec($curlHandle);
                curl_close($curlHandle);
                if(isset($captchaResponse) && trim($captchaResponse)!="")
                {
                    $r=  intval(trim($captchaResponse));
                    switch ($r)
                    {
                        case 0:
                        {
                            return true;
                            break;
                        }
                        case -1;
                        {
                            $errorPage5.="Captcha error. Please type the image content into the textbox.<>";
                            break;
                        }
                        case -2;
                        {
                            $errorPage5.="Captcha error. Please type the image content into the textbox.<>";
                            break;
                        }
                        case -3;
                        {
                            $errorPage5.="Captcha error. Validation period has expired. Please refresh the image.<>";
                            break;
                        }
                        case -4;
                        {
                            $errorPage5.="Captcha error. The value you typed does not match the content of the image.<>";
                            break;
                        }
                        case -5;
                        {
                            $errorPage5.="Captcha error. The value you typed does not match the content of the image.<>";
                            break;
                        }
                        default :
                        {
                            $errorPage5.="Captcha error. Cannot validate captcha.<>";
                            break;
                        }
                    }
                }
                else
                {
                    $errorPage5.="Captcha error. Cannot validate captcha.<>";
                }
            }
            else
            {
                $errorPage5.="Captcha error. Please type the image content into the textbox.<>";
            }
        }
        else
        {
            $errorPage5.="Captcha error. Cannot vaalidate the content.<>";
        }
        return $errorPage5;
    }
    function getUserDetail($role,$status,$comInfo,$userID,$userEmail)
    {
         $filePath="http://localhost/xchange-pro/php/userDetail.php";
         $pathFields="";
        if(isset($userID) && trim($userID)!="")
        {
            //try user id
            $pathFields.=urlencode('userID')."=".urlencode($userID)."&";

        }
         else 
         {
             //user email
             $pathFields.=urlencode('userEmail')."=".urlencode($userEmail)."&";
         }
         $pathFields.=urlencode("site_role")."=".urlencode($role)."&";
         $pathFields.=urlencode("rating_status")."=".urlencode($status)."&";
         $pathFields.=urlencode("communication_view")."=".urlencode($comInfo);
         $curlHandle=curl_init();
         curl_setopt($curlHandle, CURLOPT_URL, $filePath);
         curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($curlHandle, CURLOPT_POST, 1);
         curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $pathFields);
         curl_setopt($curlHandle, CURLOPT_COOKIE, "PHPSESSID=".  session_id());
         curl_setopt($curlHandle, CURLOPT_HEADER, 0);
         session_write_close();
         $authorizingUserDetail=curl_exec($curlHandle);
         curl_close($curlHandle);
         return $authorizingUserDetail;
    }
}

?>
