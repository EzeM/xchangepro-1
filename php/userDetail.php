<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();                
include '../template/template.php';
include '../preparedQuery/queries.php';
include '../template/database_parameters.php';
include '../template/DatabaseConnection.php';$databaseConnection=new DatabaseConnection();

$pdo=$databaseConnection->getConnection();
$temp=new template(); 
$loggedUserID=$_SESSION["userID"];
$authorizationRoleID="4"; //set to database value
$arbitrationRoleID="3"; //set to database value
if((isset($loggedUserID) && trim($loggedUserID)!=""))
{
    $userID=$_GET['userID'];
    if(!isset($userID) || trim($userID)=="")
    {
        $userID=$_POST['userID'];
    }
    $userEmailID=$_GET['userEmail'];
    if(!isset($userEmailID) || trim($userEmailID)=="")
    {
        $userEmailID=$_POST['userEmail'];
    }
    if((isset($userEmailID) && trim($userEmailID)!==""))
    {
        if(isset($pdo))
        {
            try
            {
                $pdoStatement=$pdo->prepare($get_user_id_from_email_address);
                $isSuccess=$pdoStatement->execute(array($userEmailID));
                if($isSuccess && $pdoStatement->rowCount()>0)
                {
                    $userIDExist=$pdoStatement->fetch(PDO::FETCH_NUM);
                    if(is_array($userIDExist) && count($userIDExist)==1 )
                    {
                        $userID=$userIDExist[0];
                    }
                }
            }
            catch (PDOException $p)
            {

            }
        }
    }
    if((isset($userID) && trim($userID)!=""))
    {

        $siteRole=$_GET['site_role'];
        if(!isset($siteRole) || trim($siteRole)=="")
        {
            $siteRole=$_POST['site_role'];
        }
        $ratingStatus=$_GET['rating_status'];
        if(!isset($ratingStatus) || trim($ratingStatus)=="")
        {
            $ratingStatus=$_POST['rating_status'];
        }
        $viewCommunication=$_GET['communication_view'];
        if(!isset($viewCommunication) || trim($viewCommunication)=="")
        {
            $viewCommunication=$_POST['communication_view'];
        }
        if(isset($siteRole) && trim($siteRole)!="")
        {
            if(isset($pdo))
            {
                try
                {
                    $pdoStatement=$pdo->prepare($site_role_exist_for_user);
                    $isSuccess=$pdoStatement->execute(array($userID,$siteRole));
                    if($isSuccess && $pdoStatement->rowCount()>0)
                    {
                        $siteRoleExist=$pdoStatement->fetch(PDO::FETCH_NUM);
                        if(is_array($siteRoleExist) && count($siteRoleExist)==1 && $siteRoleExist[0]>0)
                        {
                            
                            $imageID="";
                            $userName="";
                            $noOfDealsVisible="invisible";
                            $deals="";
                            $dealValueVisible="";
                            $dealValue="";
                            $image_1="star_dark.png";
                            $image_2="star_dark.png";
                            $image_3="star_dark.png";
                            $image_4="star_dark.png";
                            $image_5="star_dark.png";
                            $communicationVisible="invisible";
                            $emailVisible="invisible";
                            $emails="";
                            $phoneVisible="invisible";
                            $phones="";
                            $webVisible="invisible";
                            $website="";
                            $statusCount="";
                            $totalDealCount="";
                            $status="";
                            $statusVisible="invisible";
                            $dealRatingVisible="invisible";
                            $chargeVisible="invisible";
                            $authorizationChargeVisible="invisible";
                            $arbitrationChargeVisible="invisible";
                            $arbitrationCharge="0.00";
                            $authorizationCharge="0.00";
                            $temp->registerFiles(1, "../page_segments/userDetail.html");
                            $temp->registerVariables(1, "dealRatingVisible,userID,imageID,userName,noOfDealsVisible,dealValueVisible,dealValue,deals,communicationVisible,emailVisible");
                            $temp->registerVariables(1, "emails,phoneVisible,phones,webVisible,statusCount,totalDealCount,status,statusVisible");
                            $temp->registerVariables(1, "chargeVisible,authorizationChargeVisible,authorizationCharge,arbitrationChargeVisible,arbitrationCharge");
                            $temp->registerVariables(1, "image_1,image_2,image_3,image_4,image_5");
                            $pdoStatement=$pdo->prepare($get_user_images_id_by_user_id_and_role_id);
                            $isSuccess=$pdoStatement->execute(array($userID,$siteRole));
                            if($isSuccess && $pdoStatement->rowCount()>0)
                            {

                                $imageIDArray=$pdoStatement->fetch(PDO::FETCH_NUM);
                                if(is_array($imageIDArray) && count($imageIDArray)>=1)
                                {
                                    $imageID=$imageIDArray[0];
                                }
                            }
                            $pdoStatement=$pdo->prepare($get_user_name);
                            $isSuccess=$pdoStatement->execute(array($userID));
                            if($isSuccess && $pdoStatement->rowCount()==1)
                            {
                                $x=$pdoStatement->fetch(PDO::FETCH_NUM);
                                if(is_array($x))
                                {
                                    $u=  implode(" ", $x);
                                    if(isset($u) && trim($u)!="")
                                    {
                                        $userName=$u;
                                        $pdoStatement=$pdo->prepare($user_transaction_details_setting);
                                        $isSuccess=$pdoStatement->execute(array($userID));
                                        $dealSuccess=false;
                                        if($isSuccess && $pdoStatement->rowCount()==1)
                                        {
                                            $transSetting=$pdoStatement->fetch(PDO::FETCH_NUM);
                                            if(is_array($transSetting) && count($transSetting)>=2)
                                            {

                                                $dealSuccess=true;
                                                $tempSetting=$transSetting[0];
                                                if(isset($tempSetting) && trim($tempSetting)!="")
                                                {
                                                    if(trim($tempSetting)=='1')
                                                    {
                                                        $noOfDealsVisible="visible";
                                                    }
                                                    else
                                                    {
                                                        $noOfDealsVisible="invisible";
                                                    }
                                                }
                                                $tempSetting=$transSetting[1];
                                                if(isset($tempSetting) && trim($tempSetting)!="")
                                                {
                                                    if(trim($tempSetting)=='1')
                                                    {
                                                        $dealValueVisible="visible";
                                                    }
                                                    else
                                                    {
                                                        $dealValueVisible="invisible";
                                                    }
                                                }
                                            }

                                        }
                                        if(!$dealSuccess)
                                        {
                                            $dealValueVisible="visible";
                                            $noOfDealsVisible="visible";
                                        }

                                        $siteRoleTransactionTableName="";
                                        $pdoStatement=$pdo->prepare($get_site_role_transaction_column_name);
                                        $isSuccess=$pdoStatement->execute(array($siteRole));
                                        if($isSuccess && $pdoStatement->rowCount()==1)
                                        {
                                            $v=$pdoStatement->fetch(PDO::FETCH_NUM);
                                            if(is_array($v) && count($v)==1)
                                            {
                                                $siteRoleTransactionTableName=$v[0];
                                                $dealValueVisible="visible";
                                                $noOfDealsVisible="visible";
                                                $dealRatingVisible="visible";
                                            }
                                            else
                                            {
                                                $dealValueVisible="invisible";
                                                $noOfDealsVisible="invisible";
                                                $dealRatingVisible="invisible";
                                            }
                                        }
                                        else
                                        {
                                            $dealValueVisible="invisible";
                                            $noOfDealsVisible="invisible";
                                            $dealRatingVisible="invisible";
                                        }
                                        if($dealValueVisible=="visible" )
                                        {
                                            if(isset($siteRoleTransactionTableName) && trim($siteRoleTransactionTableName)!="")
                                            {
                                                $dealCurrencyQuery=$temp->returnDynamicQuery($get_user_transaction_currency_id_and_symbol_per_site_role, array("searchColumnName"=>$siteRoleTransactionTableName));
                                                $pdoStatement=$pdo->prepare($dealCurrencyQuery);
                                                $isSuccess=$pdoStatement->execute(array($userID));
                                                if($isSuccess && $pdoStatement->rowCount()>0)
                                                {

                                                    $rowS= $pdoStatement->fetchAll(PDO::FETCH_NUM);
                                                    for($t=0;$t<count($rowS);$t++)
                                                    {

                                                        $row=$rowS[$t];
                                                        if(is_array($row) && count($row)==2)
                                                        {

                                                            $currencyID=$row[0];
                                                            $currencySym=$row[1];
                                                            $dealAmountQuery=$temp->returnDynamicQuery($get_deal_Amount_summation_per_currency_per_site_role, array("searchColumnName"=>$siteRoleTransactionTableName));
                                                            $pdoStatement=$pdo->prepare($dealAmountQuery);
                                                            $isSuccess=$pdoStatement->execute(array($currencyID,$userID));
                                                            if($isSuccess && $pdoStatement->rowCount()>0)
                                                            {
                                                                $innerRow = $pdoStatement->fetch(PDO::FETCH_NUM);
                                                                if(is_array($innerRow) && count($innerRow)==1)
                                                                {
                                                                    $innerDealAmount=$innerRow[0];
                                                                    $innerDealAmount=  doubleval($innerDealAmount);
                                                                    $innerDealAmount= number_format($innerDealAmount, 2, '.', '');
                                                                    if($innerDealAmount>0)
                                                                    {
                                                                        if(trim($dealValue)=="")
                                                                        {
                                                                            $dealValue.=" <span style='font-weight: bold'>$currencySym</span>".strval($innerDealAmount);
                                                                        }
                                                                        else
                                                                        {
                                                                            $dealValue.=" | <span style='font-weight: bold'>$currencySym</span>".strval($innerDealAmount);
                                                                        }

                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    if(trim($dealValue)=="")
                                                    {
                                                        $dealValue="";
                                                        $dealValueVisible="invisible";
                                                    }
                                                }
                                                else
                                                {
                                                    $dealValue="";
                                                    $dealValueVisible="invisible";
                                                }
                                            }
                                            else
                                            {
                                                $dealValue="";
                                                $dealValueVisible="invisible";
                                            }

                                        }
                                        else
                                        {
                                            $dealValue="";
                                            $dealValueVisible="invisible";
                                        }
                                        if($noOfDealsVisible=="visible")
                                        {
                                            if(isset($siteRoleTransactionTableName) && trim($siteRoleTransactionTableName)!="")
                                            {
                                                $dealCountQuery=$temp->returnDynamicQuery($get_deal_count_per_site_role, array("searchColumnName"=>$siteRoleTransactionTableName));
                                                $pdoStatement=$pdo->prepare($dealCountQuery);
                                                $isSuccess=$pdoStatement->execute(array($userID));
                                                if($isSuccess && $pdoStatement->rowCount()==1)
                                                {

                                                    $kk=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                    if(is_array($kk) && count($kk)==1)
                                                    {
                                                        $theCount=$kk[0];
                                                        $theCount=  intval($theCount);
                                                        if(is_int($theCount))
                                                        {
                                                            if($theCount>1)
                                                            {
                                                                $deals=  strval($theCount)." deals";
                                                            }
                                                             else if($theCount==1)
                                                             {
                                                                 $deals=  strval($theCount)." deal";
                                                             }
                                                             else
                                                             {
                                                                  $deals= "No deal";
                                                             }
                                                        }
                                                        else
                                                        {
                                                            $deals= "No deal";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $deals= "No deal";
                                                    }
                                                }
                                                else
                                                {
                                                    $deals= "No deal";
                                                }
                                            }
                                            else
                                            {
                                                $deals="";
                                                $noOfDealsVisible="invisible";
                                            }

                                        }
                                        else
                                        {
                                            $deals="";
                                            $noOfDealsVisible="invisible";
                                        }
                                        $dealRatingOK=false;
                                        if(isset($ratingStatus) && trim($ratingStatus)!="" && $dealRatingVisible=="visible" && isset($siteRoleTransactionTableName) && trim($siteRoleTransactionTableName)!="")
                                        {
                                            $dealCountQuery=$temp->returnDynamicQuery($get_deal_count_per_site_role, array("searchColumnName"=>$siteRoleTransactionTableName));
                                            $pdoStatement=$pdo->prepare($dealCountQuery);
                                            $isSuccess=$pdoStatement->execute(array($userID));
                                            if($isSuccess && $pdoStatement->rowCount()==1)
                                            {
                                                $kk=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                if(is_array($kk) && count($kk)==1)
                                                {
                                                    $totalDealCount=$kk[0];
                                                    $totalDealCount=  intval($totalDealCount);
                                                    if(is_int($totalDealCount))
                                                    {
                                                        $dealCountQuery=$temp->returnDynamicQuery($get_status_count_per_user_transaction_and_site_role, array("searchColumnName"=>$siteRoleTransactionTableName));
                                                        //error in query above need status of the latest entry per transaction id not all entries per transactioon id
                                                        $pdoStatement=$pdo->prepare($dealCountQuery);
                                                        $isSuccess=$pdoStatement->execute(array($userID,$ratingStatus));
                                                        if($isSuccess && $pdoStatement->rowCount()==1)
                                                        {
                                                            $zz=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                            if(is_array($zz) && count($zz)==1)
                                                            {
                                                                $statusCount=$zz[0];
                                                                $statusCount=  intval($statusCount);
                                                                if(is_int($statusCount))
                                                                {
                                                                    if($statusCount>0 && $totalDealCount>0 )
                                                                    {
                                                                        $dealRatingOK=true;
                                                                        $ratio=  intval($statusCount/$totalDealCount*5);
                                                                        $statusVisible="visible";
                                                                        if($ratio>=1)
                                                                        {
                                                                            $image_1="star_green.png";
                                                                            if($ratio>=2)
                                                                            {
                                                                                $image_2="star_green.png";
                                                                                if($ratio>=3)
                                                                                {
                                                                                    $image_3="star_green.png";
                                                                                    if($ratio>=4)
                                                                                    {
                                                                                        $image_4="star_green.png";
                                                                                        if($ratio>=5)
                                                                                        {
                                                                                            $image_5="star_green.png";
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $image_5="star_dark.png";
                                                                                        }
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        $image_4="star_dark.png";
                                                                                    }
                                                                                }
                                                                                else
                                                                                {
                                                                                    $image_3="star_dark.png";
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                $image_2="star_dark.png";
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $image_1="star_dark.png";
                                                                        }
                                                                        $pdoStatement=$pdo->prepare($get_status_message_from_id);
                                                                        $isSuccess=$pdoStatement->execute(array($ratingStatus));
                                                                        if($isSuccess && $pdoStatement->rowCount()>0)
                                                                        {
                                                                            $zz=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                                            if(is_array($zz) && count($zz)==1)
                                                                            {
                                                                                $status=$zz[0];
                                                                            }

                                                                        }
                                                                        $statusCount=  number_format($statusCount,  0, '.', '');
                                                                        $totalDealCount=  number_format($totalDealCount,  0, '.', '');
                                                                    }
                                                                }
                                                            }
                                                        }

                                                    }
                                                }

                                            }
                                        }
                                         if(!$dealRatingOK)
                                         {
                                            $dealRatingVisible="invisible";
                                            $image_1="star_dark.png";
                                            $image_2="star_dark.png";
                                            $image_3="star_dark.png";
                                            $image_4="star_dark.png";
                                            $image_5="star_dark.png";
                                         }
                                         if(isset($viewCommunication) && trim($viewCommunication)=="1")
                                         {
                                            $pdoStatement=$pdo->prepare($get_web_count);
                                            $isSuccess=$pdoStatement->execute(array($userID));
//                                            $isWebOk=false;
                                            if($isSuccess && $pdoStatement->rowCount()==1)
                                            {
                                                $v=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                if(is_array($v) && count($v)==1)
                                                {
                                                    $count=  intval($v[0]);
                                                    if(is_int($count) && $count>0)
                                                    {
                                                        $columnCount=2;
                                                        $columnWidth="46%";
                                                        if($count<2)
                                                        {
                                                            $columnCount=1;
                                                            $columnWidth="100%";
                                                        }
                                                        $webVisible="visible";
                                                        $temp->registerFiles(2, "../page_segments/link.html");
                                                        $temp->registerString(3, "<div  class='{bandClass}'>{group}</div>");
                                                        $temp->parseSQLAndVariable(1,"website","get_web_address_and_description=>$userID",2,array("linkAddresse","linkDescription"),"0:==:::_blank:linkTarget=>0:==:::$columnWidth:width",3,"group",$columnCount,"","","","","","",'bandClass',array("highlight_band1","highlight_band2"));
                                                    }
                                                }
                                            }
//                                            if(!$isWebOk)
//                                            {
//                                                $webVisible="visible";
//                                            }

                                            $pdoStatement=$pdo->prepare($get_email_count);
                                            $isSuccess=$pdoStatement->execute(array($userID));
//                                            $isEmailOk=false;
                                            if($isSuccess && $pdoStatement->rowCount()==1)
                                            {
                                                $v=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                if(is_array($v) && count($v)==1)
                                                {
                                                    $count=  intval($v[0]);
                                                    if(is_int($count) && $count>0)
                                                    {
                                                        $columnCount=2;
                                                        $columnWidth="46%";
                                                        if($count<2)
                                                        {
                                                            $columnCount=1;
                                                            $columnWidth="100%";
                                                        }
                                                        $emailVisible="visible";
                                                        $temp->registerFiles(2, "../page_segments/emailandTelLink.html");
                                                        $temp->registerString(3, "<div  class='{bandClass}'>{group}</div>");
                                                        $temp->parseSQLAndVariable(1,"emails","get_email_id_and_address=>$userID",2,array("actionID","Link"),"0:==:::Send Email:actionLabel=>0:==:::sendEmail:actionMethod=>0:==::::link=>0:==:::$columnWidth:width",3,"group",$columnCount,"","","","","","",'bandClass',array("highlight_band1","highlight_band2"));
                                                    }
                                                }
                                            }
//                                            if(!$isEmailOk)
//                                            {
//                                                $emailVisible="visible";
//                                            }
                                            
                                             $pdoStatement=$pdo->prepare($get_phonenumber_count);
                                            $isSuccess=$pdoStatement->execute(array($userID));
//                                            $isPhoneOk=false;
                                            if($isSuccess && $pdoStatement->rowCount()==1)
                                            {
                                                $v=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                if(is_array($v) && count($v)==1)
                                                {
                                                    $count=  intval($v[0]);
                                                    if(is_int($count) && $count>0)
                                                    {
                                                        $columnCount=2;
                                                        $columnWidth="46%";
                                                        if($count<2)
                                                        {
                                                            $columnCount=1;
                                                            $columnWidth="100%";
                                                        }
                                                        $phoneVisible="visible";
                                                        $temp->registerFiles(2, "../page_segments/emailandTelLink.html");
                                                        $temp->registerString(3, "<div  class='{bandClass}'>{group}</div>");
                                                        $temp->parseSQLAndVariable(1,"phones","get_phone_code_number=>$userID",2,array("actionID","Link"),"0:==:::Send Text:actionLabel=>0:==:::sendText:actionMethod=>0:==::::link=>0:==:::$columnWidth:width",3,"group",$columnCount,"","","","","","",'bandClass',array("highlight_band1","highlight_band2"));
                                                    }
                                                }
                                            } 
//                                            if(!$isPhoneOk)
//                                            {
//                                                $phoneVisible="visible";
//                                            }
                                            if($webVisible=="visible" || $phoneVisible=="visible" || $emailVisible=="visible")
                                            {
                                                $communicationVisible="visible";
                                            }
                                            else
                                            {
                                                $communicationVisible="invisible";
                                            }
                                         }
                                         if($siteRole==$arbitrationRoleID || $siteRole==$authorizationRoleID)
                                         {
                                            $chargeVisible="visible";
                                             if($siteRole==$arbitrationRoleID)
                                            {
                                                $arbitrationChargeVisible="visible";
                                                $pdoStatement=$pdo->prepare($get_user_charge_by_role_id);
                                                $isSuccess=$pdoStatement->execute(array($userID,$arbitrationRoleID));
                                                if($isSuccess && $pdoStatement->rowCount()>0)
                                                {
                                                    $v=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                    if(is_array($v) && count($v)>0)
                                                    {
                                                        $arbitrationCharge=strval($v[0]);
                                                    }
                                                }
                                                if(!isset($arbitrationCharge) || !is_finite(doubleval($arbitrationCharge)) || doubleval($arbitrationCharge)<0)
                                                {
                                                    $arbitrationCharge="0.00";
                                                }
                                            } 
                                            if($siteRole==$authorizationRoleID)
                                            {
                                                $authorizationChargeVisible="visible";
                                                $pdoStatement=$pdo->prepare($get_user_charge_by_role_id);
                                                $isSuccess=$pdoStatement->execute(array($userID,$authorizationRoleID));
                                                if($isSuccess && $pdoStatement->rowCount()>0)
                                                {
                                                    $v=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                    if(is_array($v) && count($v)>0)
                                                    {
                                                        $authorizationCharge=  strval($v[0]);
                                                    }
                                                }
                                                if(!isset($authorizationCharge) || !is_finite(doubleval($authorizationCharge)) || doubleval($authorizationCharge)<0)
                                                {
                                                    $authorizationCharge="0.00";
                                                }
                                            }
                                            
                                         }
                                            
                                    }
                                    else
                                    {
    //                                    print ' ';
                                    }
                                }
                                else
                                {
    //                                print ' ';
                                }
                            }
                            else
                            {
    //                            print ' ';
                            }
                            $temp->parseFile(1);
                            $temp->printFile(1,false);
                        }
                         else
                        {
    //                        print 'rr';
                        }
                    }
                     else
                    {
    //                    print ' yy';
                    }
                }
                catch(PDOException $r)
                {
//                    print '';
                }
            }
            else
            {
    //            print '7p7 ';
            }
        }
        else
        {
    //        print ' 6uok';
        }
    }
}
else
{
    
}
    
?>
