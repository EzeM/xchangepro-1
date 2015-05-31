<?php

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
$temp=new template();
$databaseConnection=new DatabaseConnection();
$pdo=$databaseConnection->getConnection();
$genericMethod= new ManageGenericInput();
$userID=$_SESSION["userID"];
$selectedTabTemp=$_POST["selectedTab"];
$temp->registerFiles(1, "../html/update.html");
$errorMessage="";
$authorizationRoleID="4"; //set to database value
$arbitrationRoleID="3"; //set to database value
if(isset($pdo))
{
    if(!(isset($selectedTabTemp) && trim($selectedTabTemp)!=""))
    {
        $selectedTabTemp=$_GET["selectedTab"];
    }
    if((isset($userID) && trim($userID)!=""))
    {
        $selectTab1="";
        $selectTab2="";
        $selectTab3="";
        $selectTab4="";
        if(!(isset($selectedTabTemp) && trim($selectedTabTemp)!=""))
        {
            $selectedTabTemp=1;
        }
        $selectedTab=intval($selectedTabTemp);
        if($selectedTab)
        {
            switch ($selectedTab)
            {
                case 1: $selectTab1="highlight";break;
                case 2: $selectTab2="highlight";break;
                case 3: $selectTab3="highlight";break;
                case 4: $selectTab4="highlight";break;
                default:$selectTab1="highlight";break;
            }
        }
        else
        {
            $selectTab1="highlight2";
        }
        if($selectedTab==1)
        {
            $seen=$_POST["seen"];
            $bioErrorMessage="";
            $addressErrorMessage="";
            $emailErrorMessage="";
            $webErrorMessage="";
            $phoneErrorMessage="";
            $emailErrorState="invisible";
            $phoneErrorState="invisible";
            $bioErrorState="invisible";
            $webErrorState="invisible";
            $addressErrorState="invisible";
            $emailError="";
            $addressError="";
            $phoneNumberError="";
            $webError="";
            $bioError="";
            $firstName=""; 
            $middleName="";
            $surname="";
            $male="";
            $female="checked";
            $addressLine1="";
            $addressLine2="";
            $province="";
            $city="";
            $country="1"; // default id for Nigeria code
            $state="1"; //default id for lagos lagos code
            $DOB="";
            $day=5;
            $month=5;
            $year=2012;
            $gender="Female";
            $day_options="";
            $month_options="";
            $year_options="";
            $phoneCount=1;
            $emailCount=1;
            $webCount=1;
            $mobiletypePrefix="phone_type";
            $phoneCodePrefix="phone_code";
            $phoneNumberNamePrefix="phone";
            $phoneNumberPreferencePrefix="phone_preference";
            $phoneNumberNameIDXPrefix="phone_ID";
            $phoneNumberStatusImageIDPrefix="phone_status_image_ID";
            $phoneNumberNameIDX="";
            $mobiletypeX="";
            $phoneCodeX="";
            $phoneNumberNameX="";
            $phoneNumberPreferenceX="";
            $phone_numbers="";
            $emails="";
            $websites="";
            $phoneNumberX="";
            $emailX="";
            $emailIDX="";
            $emailNameIDX="";
            $phoneNumberIDX="";
            $emailNameIDXPrefix="email_ID";
            $emailAddressXPrefix="email";
            $emailPreferenceXPrefix="email_preference";
            $emailStatusImageIDPrefix="email_status_image_ID";
            $emailAddressX="";
            $emailPreferenceX="";
            $webX="";
            $webXName="";
            $webIDX="";
            $webIDNameX="";
            $webXDescriptionName="";
            $webDescriptionX="";
            $webIDNameXPrefix="web_ID";
            $webStatusImageIDPrefix="web_status_image_ID";
            $webXDescriptionNamePrefix="web_description";
            $webXPrefix="web";
            $isPrefered="selected";
            $isAlternative="";
            $defaultNew=2;
            $pathToSuccessfulUpdateImage="../Images/warning/update_sucessful.png";
            $pathToUnsuccessfulUpdateImage="../Images/warning/update_unsucessful.png";
            $pathToSuccessfulAddImage="../Images/warning/add_successful.png";
            $pathToUnsuccessfulAddImage="../Images/warning/add_unsuccessful.png";
            $webArray=array();
            $toDeletewebArray=array();
            $phoneArray=array();
            $toDeletePhoneArray=array();
            $emailArray=array();
            $toDeleteEmailArray=array();
            $bioPanelLocation=0;
            $addressPanelLocation=750;
            $phonePanelLocation=1500;
            $emailPanelLocation=2250;
            $webPanelLocation=3000;
            $bioDataTabSelected="highlight";
            $addressTabSelected="highlight2";
            $phoneNumberTabSelected="highlight2";
            $emailTabSelected="highlight2";
            $webTabSelected="highlight2";
            $temp->registerFiles(2, "../page_segments/personalUpdate.html");
            $temp->registerFiles(3, "../page_segments/options.html");
            $temp->registerVariables(2, "emailError,addressError,phoneNumberError,webError,bioError,firstName,middleName,surname,male,female,addressLine1");
            $temp->registerVariables(2, "addressLine2,province,city,country,state,day_options,month_options,year_options,websites");
            $temp->registerVariables(2, 'phoneCount,emailCount,webCount,phone_numbers,websites,emails');
            $temp->registerVariables(2, 'emailErrorState,phoneErrorState,bioErrorState,webErrorState,addressErrorState');
            $temp->registerVariables(2, 'bioPanelLocation,addressPanelLocation,phonePanelLocation,emailPanelLocation,webPanelLocation');
            $temp->registerVariables(2, 'bioDataTabSelected,addressTabSelected,phoneNumberTabSelected,emailTabSelected,webTabSelected');
            if(isset($seen))
            {
                $isBioDataOK=true;
                $isAddressOK=true;
                $isPhoneOk=true;
//                $isEmailOK=true;
//                $isWebOK=true;
                //check Name
                $firstName=$_POST["firstName"];
                $middleName=$_POST["middleName"];
                $surname=$_POST["surname"];
                $day=  intval($_POST["day"]) ;
                $month=  intval($_POST["month"]) ;
                $year=  intval($_POST["year"]) ;
                $gender=$_POST["gender"];
                if(!(isset($firstName) && trim($firstName)!=""))
                {
                    $isBioDataOK=FALSE;
                    $bioError.="First name is required. ";
                    $bioErrorMessage.="First name is required. <>";
                }
                if(!(isset($surname) && trim($surname)!=""))
                {
                    $isBioDataOK=FALSE;
                    $bioError.="Surname is required. ";
                    $bioErrorMessage.="Surname is required. <>";
                }
                $dateOK=false;
                if($month==2)
                {
                    $daysInFeb=($year%4==0 && $year%100!=0 || $year%400==0 ? 29 : 28);
                    if($day>=1 && $day<=$daysInFeb)
                    {
                        $dateOK=true;
                    }
                }
                else if($month==9 || $month==4 || $month==6 || $month==11)
                {
                    if($day>=1 && $day<=31)
                    {
                        $dateOK=true;
                    }
                }
                else if($month==1 || $month==3 || $month==5 || $month==7|| $month==8 || $month==10 || $month==12)
                {
                    if($day>=1 && $day<=31)
                    {
                        $dateOK=true;
                    }
                }

                if(!$dateOK)
                {
                    $isBioDataOK=FALSE;
                    $bioError.="Date does not exist. ";
                    $bioErrorMessage.="Date does not exist. <>";
                    
                }
                else
                {
                    $DOB="$year-$month-$day";
                }
                //handle Address
                $addressLine1=$_POST["addressLine1"];
                $addressLine2=$_POST["addressLine2"];
                $province=$_POST["province"];
                $city=$_POST["city"];
                $country=$_POST["country"];
                $state=$_POST["state"];
    //            print "$addressLine1 $addressLine2 $province $state,$city,$country";
                if(!(isset($addressLine1)&& trim($addressLine1)!=""))
                {
                    $isAddressOK=false;
                    $addressError.="Address Line 1 is required. ";
                    $addressErrorMessage.="Address Line 1 is required. <>";
                }
                if(!(isset($country)&& trim($country)!=""))
                {
                    $isAddressOK=false;
                    $addressError.="Country is required. ";
                    $addressErrorMessage.="Country is required. <>";
                }
                if(!(isset($state)&& trim($state)!=""))
                {
                    $isAddressOK=false;
                    $addressError.="State is required. ";
                    $addressErrorMessage.="State is required. <>";
                }
                //Phone Number
                $phoneCount=$_POST["phoneCount"];
    //            print "$phoneCount";
                for($r=0;$r<$phoneCount;$r++)
                {
                    $mobileType=$_POST[$mobiletypePrefix.strval($r)];
                    $mobileCode=$_POST[$phoneCodePrefix.  strval($r)];
                    $mobile=$_POST[$phoneNumberNamePrefix. strval($r)];
                    $isMobilePreffered=$_POST[$phoneNumberPreferencePrefix. strval($r)];
                    $phoneID=$_POST[$phoneNumberNameIDXPrefix. strval($r)];
                    if(isset($mobile) && trim($mobile)!="")
                    {
                        $phoneArray[]=array($mobileType,$mobileCode,$mobile,$isMobilePreffered,$phoneID,"visible","","");
                    }
                    else
                    {
                        if(isset($phoneID) && trim($phoneID)!="")
                        {
                            $toDeletePhoneArray[]=$phoneID;
                        }
                    }
                }

                if(count($phoneArray)==0) 
                {
                    $isPhoneOk=false;
                    $phoneNumberError.="At least a phone number is required";
                    $phoneErrorMessage.="At least a phone number is required.<>";
                }
                //email
                $emailCount=$_POST["emailCount"];
    //            print "$emailCount";
                $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
                for($r=0;$r<$emailCount;$r++)
                {
                    $email=$_POST[$emailAddressXPrefix.strval($r)];
                    $id=$_POST[$emailNameIDXPrefix.  strval($r)];
                    $isEmailPreffered=$_POST[$emailPreferenceXPrefix. strval($r)];
                    if(isset($email) && trim($email)!="")
                    {
                        $emailArray[]=array($email,$isEmailPreffered,$id,"visible","","");
                        
                    }
                    else
                    {
                        if(isset($id) && trim($id)!="")
                        {
                            $toDeleteEmailArray[]=$id;
                        }
                    }
                }
                if(count($emailArray)==0) 
                {
//                    $isEmailOK=false;
                    $emailError.="At least an email is required";
                    $emailErrorMessage.="At least an email is required. <>";
                }
                //web
                $webCount=$_POST["webCount"];
                for($r=0;$r<$webCount;$r++)
                {
                    $web=$_POST[$webXPrefix.strval($r)];
                    $webID=$_POST[$webIDNameXPrefix.strval($r)];
                    $webDescription=$_POST[$webXDescriptionNamePrefix.strval($r)];
                    if(isset($web) && trim($web)!="")
                    {
                        $webArray[]=array($web,$webID,$webDescription);
                    }
                    else
                    {
                        
                        if(isset($webID) && trim($webID)!="")
                        {
                            $toDeletewebArray[]=$webID;
                        }
                    }
                }

                    //load to Database;
                    try
                    {
                        $pdo=$databaseConnection->getConnection();
                        if($isBioDataOK)
                        {
                            try
                            {
                                $pdo->beginTransaction();
                                $pdoStatement=$pdo->prepare($is_name_saved);
                                $isSuccess=$pdoStatement->execute(array($userID));
                                if($isSuccess)
                                {

                                    $ttt=$pdoStatement->fetch(PDO::FETCH_NUM);
                                    if(is_array($ttt) && count($ttt)==1 && $ttt[0]==0)
                                    {
                                        //add biodata
                                        $pdoStatement=$pdo->prepare($add_new_user_bio);
                                    }
                                    else
                                    {
                                        $pdoStatement=$pdo->prepare($update_user);
                                    }
                                }
                                else
                                {
                                    $pdoStatement=$pdo->prepare($update_user);
                                }
//                                print implode(",", array($firstName,$middleName,$surname,$DOB,$gender,$userID));
                                $isSuccess=$pdoStatement->execute(array($firstName,$surname,$middleName,$DOB,$gender,$userID));
                                if($isSuccess )
                                {
                                    if($pdoStatement->rowCount()>0)
                                    {
                                        $bioError.="Bio data was updated succcessfully. ";
                                        $bioErrorMessage.="Bio data was updated succcessfully. <>";
                                        $_SESSION["userName"]="$firstName $middleName $surname";
                                    }
                                     else 
                                         {

                                         }
                                }
                                else
                                {
                                    $bioError.="Verify the information provided. Bio data was not saved. ";
                                    $bioErrorMessage.="Verify the information provided. Bio data was not saved.<>";
                                }
                                $pdo->commit();

                            }
                             catch (PDOException $ll)
                             {
                                 $bioError.="Database error. Bio data was not saved. ";
                                $bioErrorMessage.="Database error. Bio data was not saved.<>";
                                 if(isset($pdo))
                                 {
                                     $pdo->rollBack();
                                 }
                             }
                       }
                        else
                        {
                            $bioError.="Bio data was not saved";
                            $bioErrorMessage.="Bio data was not saved.<>";
                        }
                        if($isAddressOK)
                        {
                            try
                            {
                                $pdo->beginTransaction();
                                $pdoStatement=$pdo->prepare($is_address_saved);
                                $isSuccess=$pdoStatement->execute(array($userID));
                                if($isSuccess)
                                {
                                    $ttt=$pdoStatement->fetch(PDO::FETCH_NUM);
                                    if(is_array($ttt) && count($ttt)==1 && $ttt[0]==0)
                                    {
                                        //add address
                                        $pdoStatement=$pdo->prepare($add_new_user_address);
                                        $isSuccess=$pdoStatement->execute(array($addressLine1,$addressLine2,$province,$city,$country,$state,$userID));
                                    }
                                    else
                                    {
                                        //update address
                                        $pdoStatement=$pdo->prepare($update_user_address);
                                        $isSuccess=$pdoStatement->execute(array($addressLine1,$addressLine2,$province,$city,$country,$state,$userID,$country,$state,$country));
                                    }
                                }
                                else
                                {
                                    //update address
                                    $pdoStatement=$pdo->prepare($update_user_address);
                                    $isSuccess=$pdoStatement->execute(array($addressLine1,$addressLine2,$province,$city,$country,$state,$userID,$country,$state,$country));
                                }

                                //$isSuccess=$pdoStatement->execute(array($addressLine1,$addressLine2,$province,$city,$country,$state,$userID,$country,$state,$country));
                                if($isSuccess)
                                {
                                    if($pdoStatement->rowCount()>0)
                                    {
                                        $addressError.="Address was updated succcessfully. ";
                                        $addressErrorMessage.="Address was updated succcessfully. <>";
                                        
                                    }
                                    else
                                    {

                                    }
                                }
                                else
                                {
    //                                $ff=$pdoStatement->errorInfo();
    //                                print "".$ff[2];
                                    $addressError.="Verify the information provided. Address was not saved. ";
                                    $addressErrorMessage.="Verify the information provided. Address was not saved. <>";

                                }
                                $pdo->commit();
                            }
                             catch (PDOException $ll)
                             {
                                 $addressError.="Database error. Address was not saved. ";
                                $addressErrorMessage.="Database error. Address was not saved. <>";
                                 if(isset($pdo))
                                 {
                                     $pdo->rollBack();
                                 }
                             }
                        }
                        else
                        {
                            $addressError.="Address was not saved";
                            $addressErrorMessage.="Address was not saved<>";
                        }
                        if($isPhoneOk)
                        {
                            try
                            {
                                if(is_array($phoneArray) && count($phoneArray)!=0)
                                {

                                    for($b=0;$b<count($phoneArray);$b++)
                                    {
                                        $row=$phoneArray[$b];
                                        $pdo->beginTransaction();
                                        list($mobileType,$mobileCode,$mobile,$isMobilePreffered,$phoneID)=$row;
                                        if(isset($phoneID)&& trim($phoneID)!="")
                                        {
    //                                       $pdoStatement=$pdo->prepare($avoid_duplicate_numbers);
                                            //select count(`phone_ID`) from phone_numbers where phone_code_id=? and phone_number=? and user_id=? and `phone_ID`<>?
                                            $pdoStatement=$pdo->prepare($avoid_duplicate_phone);
                                            $isSuccess=$pdoStatement->execute(array($mobileCode,$mobile,$userID,$phoneID));
//                                            $row[5]="visible";
//                                            $row[6]=$pathToUnsuccessfulUpdateImage;
//                                            $row[7]="Number already exist. Update failed";
                                            if($isSuccess)
                                            {
                                                if($pdoStatement->rowCount()==1)
                                                {
                                                    $rowX=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                        if($rowX[0]==0)
                                                        {
                                                            $pdoStatement=$pdo->prepare($update_user_mobile);
                                                            $isSuccess=$pdoStatement->execute(array($mobile,$isMobilePreffered,$mobileType,$mobileCode,$userID,$phoneID));
                                                            if($isSuccess)
                                                            {
                                                                if($pdoStatement->rowCount()>0)
                                                                {
                                                                    $row[5]="visible";
                                                                    $row[6]=$pathToSuccessfulUpdateImage;
                                                                    $row[7]="Update successfully.";
                                                                    $phoneErrorMessage.="Update of $mobile was successful. <>";
                                                                }
                                                                else
                                                                {

                                                                }

                                                            }
                                                            else
                                                            {
                                                                $row[5]="visible";
                                                                $row[6]=$pathToUnsuccessfulUpdateImage;
                                                                $row[7]="Verify the information provided. Update unsuccessfull.";
                                                                $phoneErrorMessage.="Update of $mobile was unsuccessful. <>";
                                                            }
                                                        }
                                                }
                                            }      
                                        }
                                        else
                                        {
                                           while(true)
                                            {
                                                $phoneID=  rand(1,10000000000000).date("uU");
                                                $pdoStatement=$pdo->prepare($verify_phone_id);
                                                $isSuccess=$pdoStatement->execute(array($phoneID));
                                                if($isSuccess)
                                                {
                                                    if($pdoStatement->rowCount()==1)
                                                    {
                                                        $rowS=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                        if($rowS[0]==0)
                                                        {
                                                            //id is available for use.
                                                            $pdoStatement=$pdo->prepare($insert_new_user_mobile);
                                                            $isSuccess=$pdoStatement->execute(array($userID,$mobileCode,$mobile,$isMobilePreffered,$mobileType,$phoneID));
                                                            $row[5]="visible";
                                                            if($isSuccess)
                                                            {
                                                                if( $pdoStatement->rowCount()>0)
                                                                {
                                                                    $row[6]=$pathToSuccessfulAddImage;
                                                                    $row[7]="New number added successfully.";
                                                                    $phoneErrorMessage.="$mobile was added successfully. <>";
                                                                    $row[4]=$phoneID;
                                                                }
                                                                 else 
                                                                     {

                                                                     }
                                                            }
                                                            else
                                                            {
                                                                $row[6]=$pathToUnsuccessfulAddImage;
                                                                $row[7]="Verify the information provided. Number addition unsuccessfull.";
                                                                $phoneErrorMessage.="$mobile was not added. <>";
                                                            }
                                                             break;
                                                        }
                                                    }
                                                }
                                            }

                                        }
                                       $phoneArray[$b]=$row;
                                       $pdo->commit();
                                    }
                                }
                                else
                                {

                                }
                                if(isset($toDeletePhoneArray) && is_array($toDeletePhoneArray) && count($toDeletePhoneArray)!=0)
                                {
                                    while(list($k,$v)=each($toDeletePhoneArray))
                                    {
                                        try
                                        {
                                            $pdo->beginTransaction();
                                            $pdoStatement=$pdo->prepare($get_phone_number_from_id);
                                            $isSuccess=$pdoStatement->execute(array($v));
                                            if($isSuccess)
                                            {
                                                if($pdoStatement->rowCount()==1)
                                                {
                                                    $rowS=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                    $pdoStatement=$pdo->prepare($delete_user_mobile);
                                                    $isSuccess=$pdoStatement->execute(array($userID,$v));
                                                    if($isSuccess)
                                                    {
                                                        if( $pdoStatement->rowCount()>0)
                                                        {
                                                            $phoneNumberError.=$rowS[0]. " was deleted successfully. ";
                                                            $phoneErrorMessage.=$rowS[0]. " was deleted successfully. <>";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $phoneNumberError.=$rowS[0]. " was not deleted successfully. ";
                                                        $phoneErrorMessage.=$rowS[0]. " was not deleted successfully. <>";
                                                    }
                                                }
                                                else
                                                {

                                                }
                                            }
                                            $pdo->commit();
                                        }
                                        catch(PDOException $mm)
                                        {
                                            if(isset($pdo))
                                            {
                                                $pdo->rollBack();
                                            }
                                        }

                                    }

                                }
                            }
                             catch (PDOException $ll)
                             {
                                 $phoneNumberError.="Database error. Phone Number was not saved. ";
                                $phoneErrorMessage.="Database error. Phone Number was not saved.<>";
                                 if(isset($pdo))
                                 {
                                     $pdo->rollBack();
                                 }
                             }
                        }
                        else
                        {
                            $phoneNumberError.="Phone number(s) was not saved";
                            $phoneErrorMessage.="Phone number(s) was not saved.<>";
                        }

                        //handle web 
//                        if($isWebOK)
                        {
                            try
                            {
                                if(is_array($webArray) && count($webArray)!=0)
                                {
                                    $regexp="^(http(s){0,1}://){1}(www)(\.)([A-Z a-z 0-9]+)((\.)([A-Z a-z]{2,4})){1,2}(/([A-Z a-z 0-9])+)*((/)([A-Z a-z 0-9])+(\.)([A-Z a-z]{2,4})){0,1}$";
                                    for($b=0;$b<count($webArray);$b++)
                                    {
                                        $row=$webArray[$b];
                                        $pdo->beginTransaction();
                                        list($webAddress,$webID,$webDescription)=$row;
                                        if(isset($webAddress) && trim($webAddress)!="")
                                        {
                                            $o=  eregi($regexp, $webAddress);
                                            if($o)
                                            { 
                                                if(isset($webID)&& trim($webID)!="")
                                                {
                                                    if(isset($webDescription)&& trim($webDescription)!="")
                                                    {
                                                        $pdoStatement=$pdo->prepare($avoid_duplicate_web);
                                                        $isSuccess=$pdoStatement->execute(array($webAddress,$userID,$webID));
                                                        if($isSuccess)
                                                        {
                                                            if($pdoStatement->rowCount()==1)
                                                            {
                                                                $rowX=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                                    if($rowX[0]==0)
                                                                    {
                                                                        $pdoStatement=$pdo->prepare($update_user_web);
                                                                        $isSuccess=$pdoStatement->execute(array($webAddress,$userID,$webID,$webDescription));
                                                                        if($isSuccess)
                                                                        {
                                                                            if( $pdoStatement->rowCount()>0)
                                                                            {
                                                                                $row[3]="visible";
                                                                                $row[4]=$pathToSuccessfulUpdateImage;
                                                                                $row[5]="Update successfull for $webAddress. ";
                                                                                $webErrorMessage.="Update successfull for $webAddress.<>";
                                                                            }
                                                                            else
                                                                            {

                                                                            }

                                                                        }
                                                                        else
                                                                        {
                                                                            $row[3]="visible";
                                                                            $row[4]=$pathToUnsuccessfulUpdateImage;
                                                                            $row[5]="Verify the information provided. Update unsuccessfull.";
                                                                            $webErrorMessage.="Verify the information provided. Update of $webAddress unsuccessfull.<>";
                                                                        }
                                                                    }
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $row[3]="visible";
                                                        $row[4]=$pathToUnsuccessfulUpdateImage;
                                                        $row[5]="Description of $webAddress cannot be null. Update unsuccessfull.";
                                                        $webErrorMessage.="Description of $webAddress cannot be null. Update unsuccessfull. <>";
                                                    }

                                                }
                                                else
                                                {
                                                    if(isset($webDescription)&& trim($webDescription)!="")
                                                    {
                                                        $pdoStatement=$pdo->prepare($verify_web);
                                                        $isSuccess=$pdoStatement->execute(array($userID,$webAddress));
                                                        $row[3]="visible";
                                                        $row[4]=$pathToUnsuccessfulAddImage;
                                                        $row[5]="Website was added previous. ";
                                                        if($isSuccess)
                                                        {
                                                            if($pdoStatement->rowCount()==1)
                                                            {
                                                                $rowX=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                                    if($rowX[0]==0)
                                                                    {
                                                                        while(true)
                                                                        {
                                                                            $webID=  rand(1,10000000000000).date("uU");
                                                                            $pdoStatement=$pdo->prepare($verify_web_id);
                                                                            $isSuccess=$pdoStatement->execute(array($webID));
                                                                            if($isSuccess )
                                                                            {
                                                                                if($pdoStatement->rowCount()==1)
                                                                                {
                                                                                    $rowS=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                                                    if($rowS[0]==0)
                                                                                    {
                                                                                        //id is available for use.
                                                                                        //insert into user_websites(user_id,website_address,web_id) values(?,?,?)
                                                                                        $pdoStatement=$pdo->prepare($insert_new_user_website);
                                                                                        $isSuccess=$pdoStatement->execute(array($userID,$webAddress,$webID,$webDescription));
                                                                                        $row[3]="visible";
                                                                                        if($isSuccess)
                                                                                        {
                                                                                            if($pdoStatement->rowCount()>0)
                                                                                            {
                                                                                                $row[4]=$pathToSuccessfulAddImage;
                                                                                                $row[5]="New website added successfully.";
                                                                                                $webErrorMessage.="New website ($webAddress) was successfully added. <>";
                                                                                                $row[1]=$webID;
                                                                                            }
                                                                                            else
                                                                                            {

                                                                                            }
                                                                                        }
                                                                                        else
                                                                                        {
                                                                                            $row[4]=$pathToUnsuccessfulAddImage;
                                                                                            $row[5]="Verify the information provided. Website addition unsuccessfull.";
                                                                                            $webErrorMessage.="Verify the information provided. Website ($webAddress) was not saved. <>";
                                                                                        }
                                                                                         break;
                                                                                    }
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $row[3]="visible";
                                                        $row[4]=$pathToUnsuccessfulAddImage;
                                                        $row[5]="Website was not added. Description cannot be null. ";
                                                        $webErrorMessage.="Website ($webAddress) was not added. Description of website cannot be null. <>";
                                                    }
                                                }
                                            }
                                            else
                                            {
                                                $row[3]="visible";
                                                $row[4]=$pathToUnsuccessfulUpdateImage;
                                                $row[5]="$webAddress does not match the desired format. Update unsuccessfull.";
                                               $webErrorMessage.="$webAddress does not match the desired format. Update unsuccessfull. <>";
                                            }
                                        }
                                        else
                                        {
                                            $row[3]="visible";
                                            $row[4]=$pathToUnsuccessfulUpdateImage;
                                            $row[5]="Web address cannot be null. Update unsuccessfull.";
                                           $webErrorMessage.="Web address cannot be null. Update unsuccessfull. <>";
                                        }
                                       $webArray[$b]=$row;
                                       $pdo->commit();
                                    }
                                }
                                else
                                {

                                }
                                if(isset($toDeletewebArray) && is_array($toDeletewebArray) && count($toDeletewebArray)!=0)
                                {
                                    while(list($k,$v)=each($toDeletewebArray))
                                    {
                                        try
                                        {
                                            $pdo->beginTransaction();
                                            $pdoStatement=$pdo->prepare($get_web_from_id);
                                            $isSuccess=$pdoStatement->execute(array($v));
                                            if($isSuccess)
                                            {
                                                if($pdoStatement->rowCount()==1)
                                                {
                                                    $rowX=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                    $pdoStatement=$pdo->prepare($delete_user_website);
                                                    $isSuccess=$pdoStatement->execute(array($userID,$v));
                                                    if($isSuccess)
                                                    {
                                                        if($pdoStatement->rowCount()>0)
                                                        {
                                                            $webError.=$rowX[0]. "was deleted successfully. ";
                                                            $webErrorMessage.=$rowX[0]. "was deleted successfully.<>";
                                                        }
                                                        else
                                                        {

                                                        }
                                                    }
                                                    else
                                                    {
                                                        $webError.=$rowX[0]. "was not deleted successfully. ";
                                                        $webErrorMessage.=$rowX[0]. "was not deleted successfully. <>";
                                                    }
                                                }
                                                else
                                                {

                                                }
                                            }
                                            $pdo->commit();
                                        }
                                        catch(PDOException $mm)
                                        {
                                            if(isset($pdo))
                                            {
                                                $pdo->rollBack();
                                            }
                                        }

                                    }

                                }
                            }
                             catch (PDOException $ll)
                             {
                                 $webError.="Database error. Website(s) was not saved. ";
                                 $webErrorMessage.="Database error. Website(s) was not saved. <>";
                                 if(isset($pdo))
                                 {
                                     $pdo->rollBack();
                                 }
                             }
                        }
//                        else
//                        {
//                            $webError.="Website(s) was not saved";
//                        }
                        //handle email
//                        if($isEmailOK)
                        {
                            try
                            {
                                if(is_array($emailArray) && count($emailArray)!=0)
                                {
                                    $regexp="((^[A-Z 0-9]+)((\.([A-Z 0-9])+)*))@(([A-Z 0-9]+)((\.([A-Z 0-9]+))+))$";
                                    for($b=0;$b<count($emailArray);$b++)
                                    {
                                        $row=$emailArray[$b];
                                        $pdo->beginTransaction();
                                        list($email_int,$isEmailPreffered,$emailID)=$row;
                                        
                                        $o=  eregi($regexp, $email_int);
                                        if($o)
                                        {
                                            if(isset($emailID)&& trim($emailID)!="")//if this fails email is new email
                                            {
                                                $pdoStatement=$pdo->prepare($avoid_duplicate_email2);
                                                $isSuccess=$pdoStatement->execute(array($email_int,$userID));
                                                if($isSuccess)
                                                {
                                                    if($pdoStatement->rowCount()>0)
                                                    {
                                                        $othersCount=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                        if(is_array($othersCount) && count($othersCount)>0 && $othersCount[0]==0)
                                                        {
                                                            $pdoStatement=$pdo->prepare($avoid_duplicate_email);
                                                            $isSuccess=$pdoStatement->execute(array($email_int,$userID,$emailID));
                                                            $row[5]=" Email already exist. Update failed";
                                                            if($isSuccess)
                                                            {
                                                                if($pdoStatement->rowCount()>0)
                                                                {
                                                                    $rowX=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                                        if($rowX[0]==0)
                                                                        {
                                                                            $pdoStatement=$pdo->prepare($update_user_email);
                                                                            //UPDATE email_address set email=?, preferred=? where user_id=? and email_id=?
                                                                            $isSuccess=$pdoStatement->execute(array($email_int,$isEmailPreffered,$userID,$emailID));
                                                                            if($isSuccess)
                                                                            {
                                                                                if($pdoStatement->rowCount()>0)
                                                                                {
                                                                                    $row[3]="visible";
                                                                                    $row[4]=$pathToSuccessfulUpdateImage;
                                                                                    $row[5]="Update successfully.";
                                                                                    $emailErrorMessage.="Update of $email_int was successfull. <>";
                                                                                }
                                                                                else
                                                                                {

                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                $row[3]="visible";
                                                                                $row[4]=$pathToUnsuccessfulUpdateImage;
                                                                                $row[5]="Verify the information provided. Update unsuccessfull.";
                                                                                $emailErrorMessage.="Verify the information provided. Update of $email_int was not successfull. <>";
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $row[3]="visible";
                                                                            $row[4]=$pathToUnsuccessfulUpdateImage;
                                                                            $row[5]="Email already exist. Update unsuccessful";
                                                                            $emailErrorMessage.="Email already exist. Update of $email_int was not successfull. <>";
                                                                        }
                                                                }
                                                                else
                                                                {
                                                                    $row[3]="visible";
                                                                    $row[4]=$pathToUnsuccessfulUpdateImage;
                                                                    $row[5]="Cannot verify if email is already in use by you.";
                                                                    $emailErrorMessage.="Cannot verify email. Update of $email_int was not successfull. <>";
                                                                }
                                                            }
                                                            else
                                                            {
                                                                $row[3]="visible";
                                                                $row[4]=$pathToUnsuccessfulUpdateImage;
                                                                $row[5]="Cannot verify if email is already in use by you.";
                                                                $emailErrorMessage.="Cannot verify email. Update of $email_int was not successfull. <>";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            $row[3]="visible";
                                                            $row[4]=$pathToUnsuccessfulUpdateImage;
                                                            $row[5]="Email has been registered by another user. ";
                                                            $emailErrorMessage.="Email has been registered by another user. Update of $email_int was not successfull. <>";
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $row[3]="visible";
                                                        $row[4]=$pathToUnsuccessfulUpdateImage;
                                                        $row[5]="Cannot verify if email is already in use by another user. ";
                                                        $emailErrorMessage.="Cannot verify email. Update of $email_int was not successfull. <>";
                                                    }
                                                }
                                                else
                                                {
                                                    $row[3]="visible";
                                                    $row[4]=$pathToUnsuccessfulUpdateImage;
                                                    $row[5]="Cannot verify if email is already in use by another user. ";
                                                    $emailErrorMessage.="Cannot verify email. Update of $email_int was not successfull. <>";
                                                }
                                                //

                                            }
                                            else
                                            {
                                                $row[3]="visible";
                                                $row[4]=$pathToUnsuccessfulAddImage;
                                                $row[5]="Email already exist for another user. ";
                                                $pdoStatement=$pdo->prepare($verify_email2);
                                                $isSuccess=$pdoStatement->execute(array($email_int,$userID));
                                                if($isSuccess)
                                                {
                                                    $pdoStatement=$pdo->prepare($verify_email);
                                                    $isSuccess=$pdoStatement->execute(array($email_int,$userID));
                                                    $row[5]="Email already exist for you. ";
                                                    if($isSuccess)
                                                    {
                                                        if($pdoStatement->rowCount()==1)
                                                        {
                                                            $rowX=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                                if($rowX[0]==0)
                                                                {
                                                                    while(true)
                                                                    {
                                                                        $emailID=  rand(1,10000000000000).date("uU");
                                                                        $pdoStatement=$pdo->prepare($verify_email_id);
                                                                        $isSuccess=$pdoStatement->execute(array($emailID));
                                                                        if($isSuccess)
                                                                        {
                                                                            if($pdoStatement->rowCount()==1)
                                                                            {
                                                                                $rowS=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                                                if($rowS[0]==0)
                                                                                {
                                                                                    //id is available for use.
                                                                                    //insert into email_address(user_id,email,preferred,email_id) values(?,?,?,?
                                                                                    $pdoStatement=$pdo->prepare($insert_new_user_email);
                                                                                    $isSuccess=$pdoStatement->execute(array($userID,$email_int,$isEmailPreffered,$emailID));
                                                                                    if($isSuccess)
                                                                                    {
                                                                                        if($pdoStatement->rowCount()>0)
                                                                                        {
                                                                                            $row[4]=$pathToSuccessfulAddImage;
                                                                                            $row[5]="New email added successfully.";
                                                                                            $emailErrorMessage.="Addition of $email_int was successfull. <>";
                                                                                            $row[2]=$emailID;
                                                                                        }
                                                                                        else
                                                                                        {

                                                                                        }
                                                                                    }
                                                                                    else
                                                                                    {
                                                                                        $row[4]=$pathToUnsuccessfulAddImage;
                                                                                        $row[5]="Verify the information provided. Email addition unsuccessfull.";
                                                                                        $emailErrorMessage.="Verify the information provided. Addition of $email_int was not successfull. <>";
                                                                                    }
                                                                                     break;
                                                                                }
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $row[3]="visible";
                                            $row[4]=$pathToUnsuccessfulUpdateImage;
                                            $row[5]="Wrong email format. ";
                                            $emailErrorMessage.="Wrong email format. Update of $email_int was not successfull. <>";
                                        }
                                            
                                       $emailArray[$b]=$row;
                                       $pdo->commit();
                                    }
                                }
                                else
                                {

                                }
                                if(isset($toDeleteEmailArray) && is_array($toDeleteEmailArray) && count($toDeleteEmailArray)!=0)
                                {
                                    while(list($k,$v)=each($toDeleteEmailArray))
                                    {
                                        try
                                        {
                                            $delSuccessful=false;
                                            $delMessage="Sorry email cannot be deleted. We cannot verify you login Email at this time";
                                            $pdo->beginTransaction();
                                            $pdoStatement=$pdo->prepare($get_login_email_addresse_id);
                                            $isSuccess=$pdoStatement->execute(array($userID));
                                            if($isSuccess && $pdoStatement->rowCount()>0)
                                            {
                                                
                                                $loginEmailCheck=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                if(isset($loginEmailCheck) && is_array($loginEmailCheck) && count($loginEmailCheck)>0)
                                                {
                                                    $loginEmailID=$loginEmailCheck[0];
                                                    if(isset($loginEmailID))
                                                    {
                                                        if($loginEmailID!=$v)
                                                        {
                                                                $pdoStatement=$pdo->prepare($get_email_from_id);
                                                                $isSuccess=$pdoStatement->execute(array($v));
                                                                if($isSuccess)
                                                                {
                                                                    if($pdoStatement->rowCount()==1)
                                                                    {
                                                                        $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                                        $pdoStatement=$pdo->prepare($delete_user_email);
                                                                        $isSuccess=$pdoStatement->execute(array($userID,$v));
                                                                        if($isSuccess)
                                                                        {
                                                                            if( $pdoStatement->rowCount()>0)
                                                                            {
                                                                                $emailError.=$row[0]. " was deleted successfully. ";
                                                                                $emailErrorMessage.=$row[0]. " was deleted successfully. <>";
                                                                                $delSuccessful= true;
                                                                            }
                                                                            else
                                                                            {
                                                                                $delMessage=$row[0]. " was not deleted successfully. ";
                                                                                $emailErrorMessage.=$row[0]. " was not deleted successfully. <>";
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $delMessage=$row[0]. "was not deleted successfully. ";
                                                                            $emailErrorMessage.=$row[0]. " was not deleted successfully. <>";
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        $delMessage="Email was not delete as the email information could not be found";
                                                                        $emailErrorMessage.="Email was not delete as the email information could not be found <>";
                                                                    }
                                                                }
                                                                else
                                                                {
                                                                    $delMessage="Email was not delete as the email information could not be found";
                                                                    $emailErrorMessage.="Email was not delete as the email information could not be found <>";
                                                                }
                                                        }
                                                        else
                                                        {
                                                            $delMessage="Cannot delete your login Email. Change login email in security information tab before attempting to delete this email";
                                                            $emailErrorMessage.="Cannot delete your login Email. Change login email in security information tab before attempting to delete this email<>";
                                                        }
                                                    }
                                                }
                                            }
                                            $delSuccessful2=false;
                                            if(!$delSuccessful)
                                            {
                                                $pdoStatement = $pdo->prepare($get_email_address_by_id);
                                                $pdoStatement->execute(array($userID,$v));
                                                if($pdoStatement->rowCount()>0)
                                                {
                                                    while($delRow=$pdoStatement->fetch(PDO::FETCH_NUM))
                                                    {
                                                        if(isset($delRow) && is_array($delRow))
                                                        {
                                                            $delSuccessful2=true;
                                                            $delRow[]="visible";
                                                            $delRow[]="$pathToUnsuccessfulUpdateImage";
                                                            $delRow[]= $delMessage;
                                                            $emailArray[]=$delRow;
                                                        }
                                                    }

                                                }
                                                if(!$delSuccessful2)
                                                {
                                                    $emailError.="$delMessage";
                                                }
                                            }
                                            
                                            
                                           
                                            $pdo->commit();
                                        }
                                        catch(PDOException $mm)
                                        {
                                            if(isset($pdo))
                                            {
                                                $pdo->rollBack();
                                            }
                                        }

                                    }

                                }
                            }
                             catch (PDOException $ll)
                             {
                                 $emailError.="Database error. Email was not saved. ";
                                $emailErrorMessage.="Database error. Email was not saved. <>";
                                 if(isset($pdo))
                                 {
                                     $pdo->rollBack();
                                 }
                             }
                        }
//                        else
//                        {
//                            $emailError.="Email(s) was not saved";
//                        }
                    }
                    catch(PDOException $g)
                    {
                        //$addressError.="Database error. Address was not saved. ";
                         if(isset($pdo))
                         {
                             $pdo->rollBack();
                         }
                    }

                {
                    //reload page with entered Data.
//
//                    if(!$isPhoneOk)
//                    {
//                        $phoneNumberError.="Phone number(s) was not saved";
//                    }
//                    if(!$isEmailOK)
//                    {
//                        $emailError.="E-mail(s) was not saved";
//                    }
//                    if(!$isWebOK)
//                    {
//                        $webError.="Website(s) was not saved";
//                    }


                }
                //make comment visible
                {
                    
                   if(isset($bioErrorMessage) && trim($bioErrorMessage)!="")
                    {
                        $errorMessage.="Feedback on update of bio-data<=>$bioErrorMessage<...>";
                    }
                    if(isset($addressErrorMessage) && trim($addressErrorMessage)!="")
                    {
                        $errorMessage.="Feedback on update of address information<=>$addressErrorMessage<...>";
                    }
                    if(isset($phoneErrorMessage) && trim($phoneErrorMessage)!="")
                    {
                        $errorMessage.="Feedback on update of phone information<=>$phoneErrorMessage<...>";
                    }
                    if(isset($emailErrorMessage) && trim($emailErrorMessage)!="")
                    {
                        $errorMessage.="Feedback on update of email information<=>$emailErrorMessage<...>";
                    }
                    if(isset($webErrorMessage) && trim($webErrorMessage)!="")
                    {
                        $errorMessage.="Feedback on update of website information<=>$webErrorMessage<...>";
                    }
                    if(isset($bioError) && trim($bioError)!="")
                    {
                        $bioErrorState="visible";
                    }  
                    if(isset($addressError) && trim($addressError)!="")
                    {
                        $addressErrorState="visible";
                    }
                    if(isset($phoneNumberError) && trim($phoneNumberError)!="")
                    {
                        $phoneErrorState="visible";
                    }
                    if(isset($emailError) && trim($emailError)!="")
                    {
                        $emailErrorState="visible";;
                    }
                    if(isset($webError) && trim($webError)!="")
                    {
                        $webErrorState="visible";
                    }
                }
            }
            else
            {
                //format columnIndex:compareType:compareValue:trueReplacement:falseReplacement:variableToReplace
                //global  $dsn, $username, $password,$get_user_name,$get_address;

                try
                { 
                    $pdo=$databaseConnection->getConnection();
                    $pdo->beginTransaction();
                    $pdoStatement = $pdo->prepare($get_user_Bio);
                    $pdoStatement->execute(array($userID));
                    if($pdoStatement->rowCount()==1)
                    {
                        $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                        $firstName=$row[0];
                        $middleName=$row[1];
                        $surname=$row[2];
                        $DOB=$row[3];
                        $gender =$row[4];
                    }
                    else
                    {

                    }
                    $pdoStatement = $pdo->prepare($get_address);
                    $pdoStatement->execute(array($userID));
                    if($pdoStatement->rowCount()==1)
                    {
                        $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                        $addressLine1=$row[0];
                        $addressLine2=$row[1];
                        $province=$row[2];
                        $city=$row[3];
                        $country=$row[4];
                        $state=$row[5];
                        $addressSaved=true;
                    }
                    else
                    {
                        $addressSaved=false;
                    }
                    //handle phone numbers
                    $pdoStatement = $pdo->prepare($get_phone_numbers);
                    $pdoStatement->execute(array($userID));
                    if($pdoStatement->rowCount()>0)
                    {
                        $phoneCount=$pdoStatement->rowCount();
                        while($row=$pdoStatement->fetch(PDO::FETCH_NUM))
                        {
                            if(isset($row) && is_array($row))
                            {
                                $row[]="invisible";
                                $row[]="";
                                $row[]="";
                                $phoneArray[]=$row;
                            }
                        }
                    }
                    //handle emails
                    $pdoStatement = $pdo->prepare($get_email_address);
                    $pdoStatement->execute(array($userID));
                    if($pdoStatement->rowCount()>0)
                    {
                        $emailCount=$pdoStatement->rowCount();
                        while($row=$pdoStatement->fetch(PDO::FETCH_NUM))
                        {
                            if(isset($row) && is_array($row))
                            {
                                $row[]="invisible";
                                $row[]="";
                                $row[]="";
                                $emailArray[]=$row;
                            }
                        }

                    }

                    //handle websites
                    $pdoStatement = $pdo->prepare($get_web_address_and_id_and_description);
                    $pdoStatement->execute(array($userID));
                    if($pdoStatement->rowCount()>0)
                    {
                        $webCount=$pdoStatement->rowCount();
                        while($row=$pdoStatement->fetch(PDO::FETCH_NUM))
                        {
                            if(isset($row) && is_array($row))
                            {
                                $row[]="invisible";
                                $row[]="";
                                $row[]="";
                                $webArray[]=$row;
                            }
                        }
                    }
                    $pdo->commit();
                }
                catch (PDOException $r)
                {
                    if(isset($pdo))
                    {
                        $pdo->rollBack();
                    }
                }


            }
            //handle page possitioning.
            if((isset($bioError) && trim($bioError)!="" && $bioErrorState=="visible")|| (isset($bioErrorMessage) && trim($bioErrorMessage)!=""))
            {
                $addressPanelLocation-=$bioPanelLocation;
                $emailPanelLocation-=$bioPanelLocation;
                $webPanelLocation-=$bioPanelLocation;
                $phonePanelLocation-=$bioPanelLocation;
                $bioPanelLocation=0;
                $bioDataTabSelected="highlight";
                $addressTabSelected="highlight2";
                $phoneNumberTabSelected="highlight2";
                $emailTabSelected="highlight2";
                $webTabSelected="highlight2";
            }
            else if((isset($addressError) && trim($addressError)!="" && $addressErrorState=="visible") || (isset($addressErrorMessage) && trim($addressErrorMessage)!=""))
            {
                $bioPanelLocation-=$addressPanelLocation;
                $emailPanelLocation-=$addressPanelLocation;
                $webPanelLocation-=$addressPanelLocation;
                $phonePanelLocation-=$addressPanelLocation;
                $addressPanelLocation=0;
                $bioDataTabSelected="highlight2";
                $addressTabSelected="highlight";
                $phoneNumberTabSelected="highlight2";
                $emailTabSelected="highlight2";
                $webTabSelected="highlight2";
            }
            else if((isset($emailError) && trim($emailError)!="" && $emailErrorState=="visible") || (isset($emailErrorMessage) && trim($emailErrorMessage)!=""))
            {
                $bioPanelLocation-=$emailPanelLocation;
                $addressPanelLocation-=$emailPanelLocation;
                $webPanelLocation-=$emailPanelLocation;
                $phonePanelLocation-=$emailPanelLocation;
                $emailPanelLocation=0;
                $bioDataTabSelected="highlight2";
                $addressTabSelected="highlight2";
                $phoneNumberTabSelected="highlight2";
                $emailTabSelected="highlight";
                $webTabSelected="highlight2";
            }
            else if((isset($webError) && trim($webError)!="" && $webErrorState=="visible") || (isset($webErrorMessage) && trim($webErrorMessage)!=""))
            {
                $bioPanelLocation-=$webPanelLocation;
                $addressPanelLocation-=$webPanelLocation;
                $emailPanelLocation-=$webPanelLocation;
                $phonePanelLocation-=$webPanelLocation;
                $webPanelLocation=0;
                $bioDataTabSelected="highlight2";
                $addressTabSelected="highlight2";
                $phoneNumberTabSelected="highlight2";
                $emailTabSelected="highlight2";
                $webTabSelected="highlight";
            }
            else if((isset($phoneNumberError) && trim($phoneNumberError)!="" && $phoneErrorState=="visible") || (isset($phoneErrorMessage) && trim($phoneErrorMessage)!=""))
            {
                $bioPanelLocation-=$phonePanelLocation;
                $addressPanelLocation-=$phonePanelLocation;
                $emailPanelLocation-=$phonePanelLocation;
                $webPanelLocation-=$phonePanelLocation;
                $phonePanelLocation=0;
                $bioDataTabSelected="highlight2";
                $addressTabSelected="highlight2";
                $phoneNumberTabSelected="highlight";
                $emailTabSelected="highlight2";
                $webTabSelected="highlight2";
            }
            //handle date of birth
        if(!(isset($DOB) && is_string($DOB) && trim($DOB)!=""))
        {
            $DOB= date("Y-n-j");
        }
        $r=split("-", $DOB);
        if(count($r)==3)
        {
            $year=  intval($r[0]);
            $month=  intval($r[1]);
            $day=  intval($r[2]);
        }
        $end=31;
        if($month==9 || $month==4 || $month==6 || $month==11)
        {
            $end=30;
        }
        else if($month==2)
        {
            $end=28;
        }
        $monthText=array("January","February","March","April","May","June","July","August","September","October","November","December");
        $toDate=intval(date("Y"));
        $day_options=$temp->returnSequentialFileUpdate(3, 1, $end, $day, "value","text","", "isselected", "selected","");
        $month_options=$temp->returnSequentialFileUpdate(3, 1, 12, $month, "value","text",$monthText, "isselected", "selected","");
        $year_options=$temp->returnSequentialFileUpdate(3, 1970, $toDate, $year, "value","text","", "isselected", "selected","");
        //handle gender
        if($gender=="Male")
        {
            $male="checked";
            $female="";
        }
        $temp->parseSQLAndVariable(2,"country_id_and_name", "country_id_and_name", 3,array("value","text"), "0:==:$country:selected::isselected");
        $temp->parseSQLAndVariable(2,"state_id_and_name", "state_id_and_name=>$country", 3,array("value","text"), "0:==:$state:selected::isselected");
        $no_phones=true;
        $no_emails=true;
        $no_web=true;
        if(isset($phoneArray) && is_array($phoneArray))
        {
            if(count($phoneArray)>0)
            {
                $h=0;
                $no_phones=false;
                 for($b=0;$b<count($phoneArray);$b++)       
                {
                    $row=$phoneArray[$b];
                    list($defaultType,$defaultCode,$defaultNumber,$isPre,$numberID,$imageViewStatusX,$imageLinkStatusX,$imageTitleStatusX)=$row;
                    $phoneNumberX=$defaultNumber;
                    $phoneNumberIDX=$numberID;
                    $phoneNumberNameIDX=$phoneNumberNameIDXPrefix.  strval($h);
                    $mobiletypeX=$mobiletypePrefix.  strval($h);
                    $phoneCodeX=$phoneCodePrefix.  strval($h);
                    $phoneNumberNameX=$phoneNumberNamePrefix.  strval($h);
                    $phoneNumberPreferenceX=$phoneNumberPreferencePrefix.  strval($h);
                    $imageStatusX=$phoneNumberStatusImageIDPrefix.  strval($h);
                    if(isset($isPre) && $isPre)
                    {
                        $isPrefered="selected";
                        $isAlternative="";
                    }
                    else
                    {
                        $isPrefered="";
                        $isAlternative="selected";
                    }
                    $temp->registerFiles(4, "../page_segments/phoneNumber.html");
                    $temp->registerVariables(4, "mobiletypeX,phoneCodeX,phoneNumberNameX,phoneNumberPreferenceX,phoneNumberX,isPrefered,isAlternative,phoneNumberIDX,phoneNumberNameIDX");
                    $temp->registerVariables(4, "imageStatusX,imageViewStatusX,imageLinkStatusX,imageTitleStatusX");
                    $temp->parseFile(4);
                    $temp->parseSQLAndVariable(4, "mobileTypeOptionX", "phone_types", 3, array("value","text"), "0:==:$defaultType:selected::isselected");
                    $temp->parseSQLAndVariable(4, "phoneCodeOptionX", "phone_codes", 3, array("value","text"), "0:==:$defaultCode:selected::isselected");
                    $phone_numbers.="\n".$temp->returnFile(4);
                    $h++;
                }
            }
        }
        if(isset($emailArray) && is_array($emailArray))
        {
            if(count($emailArray)>0)
            {
                $h=0;
                $no_emails=false;
                for($b=0;$b<count($emailArray);$b++)       
                {
                    $row=$emailArray[$b];
                    list($defaultEmail,$isPre,$email_id,$imageViewStatusX,$imageLinkStatusX,$imageTitleStatusX)=$row;
                    $emailX=$defaultEmail;
                    $emailIDX=$email_id;
                    $emailNameIDX=$emailNameIDXPrefix.  strval($h);
                    $emailAddressX=$emailAddressXPrefix.  strval($h);
                    $emailPreferenceX=$emailPreferenceXPrefix.  strval($h);
                    $imageStatusX=$emailStatusImageIDPrefix.  strval($h);
                    if(isset($isPre) && $isPre)
                    {
                        $isPrefered="selected";
                        $isAlternative="";
                    }
                    else
                    {
                        $isPrefered="";
                        $isAlternative="selected";
                    }
                    $temp->registerFiles(4, "../page_segments/email.html");
                    $temp->registerVariables(4, "imageStatusX,imageViewStatusX,imageLinkStatusX,imageTitleStatusX");
                    $temp->registerVariables(4, "emailAddressX,emailX,emailPreferenceX,emailNameIDX,emailIDX,isPrefered,isAlternative");
                    $temp->parseFile(4);
                    $emails.="\n".$temp->returnFile(4);
                    $h++;
                }
            }
        }
        if(isset($webArray) && is_array($webArray))
        {
            if(count($webArray)>0)
            {
                $h=0;
                $no_web=false;
                while(list($key,$row)=  each($webArray))
                {
                    list($webAddress,$webID,$webDescription,$imageViewStatusX,$imageLinkStatusX,$imageTitleStatusX)=$row;
                    $webX=$webAddress;
                    $webIDX=$webID;
                    $webIDNameX=$webIDNameXPrefix.  strval($h);
                    $webXName=$webXPrefix.  strval($h);
                    $imageStatusX=$webStatusImageIDPrefix.  strval($h);
                    $webXDescriptionName=$webXDescriptionNamePrefix.strval($h);
                    $webDescriptionX=$webDescription;
                    $temp->registerFiles(4, "../page_segments/web.html");
                    $temp->registerVariables(4, "imageStatusX,imageViewStatusX,imageLinkStatusX,imageTitleStatusX");
                    $temp->registerVariables(4, "webXName,webX,webIDX,webIDNameX");
                    $temp->registerVariables(4, "webXDescriptionName,webDescriptionX");
                    $temp->parseFile(4);
                    $websites.="\n".$temp->returnFile(4);
                    $h++;
                }
            }
        }
        if($no_phones)
        {
            for($h=0;$h<$defaultNew;$h++)
            {
                $phoneNumberX=$defaultNumber;
                $mobiletypeX=$mobiletypePrefix.  strval($h);
                $phoneCodeX=$phoneCodePrefix.  strval($h);
                $phoneNumberNameX=$phoneNumberNamePrefix.  strval($h);
                $phoneNumberPreferenceX=$phoneNumberPreferencePrefix.  strval($h);
                $phoneNumberIDX="";
                $phoneNumberNameIDX=$phoneNumberNameIDXPrefix.  strval($h);
                $imageStatusX=$phoneNumberStatusImageIDPrefix.  strval($h);
                $isselected="";
                $isPrefered="selected";
                $imageViewStatusX="invisible";
                $isAlternative="";
                $temp->registerFiles(4, "../page_segments/phoneNumber.html");
                $temp->registerVariables(4, "imageStatusX,imageViewStatusX,imageLinkStatusX,imageTitleStatusX");
                $temp->registerVariables(4, "mobiletypeX,phoneCodeX,phoneNumberNameX,phoneNumberPreferenceX,phoneNumberX,isPrefered,isAlternative,phoneNumberIDX,phoneNumberNameIDX,isselected");
                $temp->parseSQLAndVariable(4, "mobileTypeOptionX", "phone_types", 3, array("value","text"), "");
                $temp->parseSQLAndVariable(4, "phoneCodeOptionX", "phone_codes", 3, array("value","text"), "");
                $temp->parseFile(4);
                $phone_numbers.="\n".$temp->returnFile(4);
            }
        }
        if($no_emails)
        {
            for($h=0;$h<$defaultNew;$h++)
            {
                $emailAddressX=$emailAddressXPrefix.  strval($h);
                $emailPreferenceX=$emailPreferenceXPrefix.  strval($h);
                $emailIDX="";
                $emailNameIDX=$emailNameIDXPrefix.  strval($h);
                $imageStatusX=$emailStatusImageIDPrefix.  strval($h);
                $imageViewStatusX="invisible";
                $isPrefered="selected";
                $isAlternative="";
                $temp->registerFiles(4, "../page_segments/email.html");
                $temp->registerVariables(4, "imageStatusX,imageViewStatusX,imageLinkStatusX,imageTitleStatusX");
                $temp->registerVariables(4, "emailAddressX,emailX,emailPreferenceX,emailIDX,emailNameIDX,isPrefered,isAlternative");
                $temp->parseFile(4);
                $emails.="\n".$temp->returnFile(4);
            }
        }
        if($no_web)
        {
            for($h=0;$h<$defaultNew;$h++)
            {
                $webXName=$webXPrefix.  strval($h);
                $webIDX="";
                $webIDNameX=$webIDNameXPrefix.  strval($h);
                $imageStatusX=$webStatusImageIDPrefix.  strval($h);
                $webXDescriptionName=$webXDescriptionNamePrefix.strval($h);
                $webDescriptionX="";
                $imageViewStatusX="invisible";
                $temp->registerFiles(4, "../page_segments/web.html");
                $temp->registerVariables(4, "imageStatusX,imageViewStatusX,imageLinkStatusX,imageTitleStatusX");
                $temp->registerVariables(4, "webXName,webX,webIDX,webIDNameX");
                $temp->registerVariables(4, "webXDescriptionName,webDescriptionX");
                $temp->parseFile(4);
                $websites.="\n".$temp->returnFile(4);
            }
        }
        }
        else if($selectedTab==2)
        {
            $seen=$_POST["seen"];
            $passwordErrorMessage="";
            $securityErrorMessage="";
            $loginChangeErrorMessage="";
            $recoveryErrorMessage="";
            $currentPasswordError="";
            $passwordEqualityError="";
            $passwordStrenghtError="";
            $passwordChangeMessage="";
            $loginEmailStatus="";
            $currentSecurityAnswerStatus="";
            $newSecurityQuestionStatus="";
            $accountRecoveryStatus="";
            $accountRecoveryOptionStatus="";        
            $newSecurityAnswerStatus="";

            $loginEmailStatusImageName="update_unsucessful.png";
            $passwordStrenghtImageName="0.png";
            $passwordEualityImageName="not_ok.png";
            $passwordUpdateImageName="update_unsucessful.png";
            $currentSecurityAnswerImageName="not_ok.png";
            $newSecurityQuestionImageName="not_ok.png";
            $accountRecoveryOptionStatusImageName="update_unsucessful.png";
            $accountRecoveryStatusImageName="update_unsucessful.png";
            $newSecurityAnswerImageName="update_unsucessful.png";

            $passwordErrorVisible="invisible";
            $passwordStrenghtImageVisible="invisible";
            $passwordEualityImageVisible="invisible";
            $passwordUpdateImageVisible="invisible";
            $loginEmailStatusImageVisible="invisible";
            $passwordRecoveryMeansStatusVisible="invisible";
            $loginPanelStatusVisible="invisible";
            $currentSecurityAnswerImageVisible="invisible";
            $securityQuestionAndAnswerStatusVisible="invisible";
            $newSecurityQuestionImageVisible="invisible";
            $currentSecurityAnswerVisible="invisible";
            $newSecurityAnswerImageVisible="invisible";
            $accountRecoveryStatusImageVisible="invisible";
            $accountRecoveryOptionStatusImageVisible="invisible";


            $currentPassword="";
            $newPassword="";
            $newPassword2="";

            $recovery_media="";

            $current_question="";
            $current_answer="";
            $new_question="";
            $new_answer="";
            $recovery_method_id="";
            $recovery_option_id="";
            $login_email_id="";
            
            $passwordPanelLocation=0;
            $securityPanelLocation=750;
            $recoveryPanelLocation=1500;
            $loginChangePanelLocation=2250;
            
            $passwordTabSelected="highlight";
            $securityTabSelected="highlight2";
            $recoveryTabSelected="highlight2";
            $loginChangeTabSelected="highlight2";

            $temp->registerFiles(2, "../page_segments/securityUpdate.html");
            $temp->registerFiles(3, "../page_segments/options.html");
            $temp->registerVariables(2, "current_question,new_question,newSecurityAnswerStatus,currentPasswordError,passwordEqualityError,passwordStrenghtError,passwordChangeMessage,loginEmailStatus,currentSecurityAnswerStatus,newSecurityQuestionStatus,accountRecoveryStatus,accountRecoveryOptionStatus");
            $temp->registerVariables(2, "newSecurityAnswerImageName,accountRecoveryOptionStatusImageName,recovery_media,accountRecoveryStatusImageName,newSecurityQuestionImageName,currentSecurityAnswerImageName,passwordUpdateImageName,passwordEualityImageName,passwordStrenghtImageName,loginEmailStatusImageName");
            $temp->registerVariables(2, "newSecurityAnswerImageVisible,accountRecoveryOptionStatusImageVisible,accountRecoveryStatusImageVisible,currentSecurityAnswerVisible,newSecurityQuestionImageVisible,securityQuestionAndAnswerStatusVisible,currentSecurityAnswerImageVisible,passwordRecoveryMeansStatusVisible,loginEmailStatusImageVisible,passwordUpdateImageVisible,passwordEualityImageVisible,passwordStrenghtImageVisible,passwordErrorVisible,loginPanelStatusVisible");
            $temp->registerVariables(2, "currentPassword,newPassword,newPassword2");
            $temp->registerVariables(2, 'passwordPanelLocation,securityPanelLocation,recoveryPanelLocation,loginChangePanelLocation');
            $temp->registerVariables(2, 'passwordTabSelected,securityTabSelected,recoveryTabSelected,loginChangeTabSelected');
            if($seen)
            {
                $currentPassword=$_POST["currentPassword"];
                $newPassword=$_POST["newPassword"];
                $newPassword2=$_POST["newPassword2"];
                if(isset($currentPassword) && $currentPassword!=NULL && trim($currentPassword)!="" )
                {
                    if((!isset($newPassword) || $newPassword==NULL || trim($newPassword)=="") && (!isset($newPassword2) || $newPassword2==NULL || trim($newPassword2)==""))
                    {
                        //both $newPassword ang $newPassword2 fields are null
                        $newPassword="";
                        $newPassword2="";
                        $passwordChangeMessage="Please type and verify the new password. ";
                        $passwordUpdateImageVisible="visible";
                        $passwordUpdateImageName="not_ok.png";
                    }
                    else
                    {
                        if((isset($newPassword) && $newPassword!=NULL && trim($newPassword)!="") )
                        {
                            if((isset($newPassword2) && $newPassword2!=NULL && trim($newPassword2)!=""))
                            {
                                if($newPassword==$newPassword2)
                                {
                                    $returned=  verifyPasswordStrenght($newPassword);
                                    $passwordStrenghtImageVisible="visible";
                                    switch($returned)
                                    {
                                        case 0: 
                                        {
                                            $passwordStrenghtImageName="0.png";
                                            $passwordStrenghtError="Password does not meet the minimum criteria. ";
                                            break;
                                        }
                                        case -10: 
                                        {
                                            $passwordStrenghtImageName="0.png";

                                            $passwordStrenghtError="Password not found.";
                                            break;
                                        }
                                        case -1: 
                                        {
                                            $passwordStrenghtImageName="0.png";

                                            $passwordStrenghtError="Password does not contain lowercase characters. ";
                                            break;
                                        }
                                        case -2: 
                                        {
                                            $passwordStrenghtImageName="0.png";
                                            $passwordStrenghtError="Password contains repeated character sequence in lowercase characters. ";
                                            break;
                                        }
                                        case -3: 
                                        {
                                            $passwordStrenghtImageName="0.png";

                                            $passwordStrenghtError="Password contains repeated character sequence in lowercase character groups. ";
                                            break;
                                        }
                                        case -4: 
                                        {
                                            $passwordStrenghtImageName="0.png";

                                            $passwordStrenghtError="Password does not contain uppercase characters. ";
                                            break;
                                        }
                                        case -5: 
                                        {
                                            $passwordStrenghtImageName="0.png";

                                            $passwordStrenghtError="Password contains repeated character sequence in uppercase characters. ";
                                            break;
                                        }
                                        case -6: 
                                        {
                                            $passwordStrenghtImageName="0.png";

                                            $passwordStrenghtError="Password contains repeated character sequence in uppercase character groups. ";
                                            break;
                                        }
                                        case -7: 
                                        {
                                            $passwordStrenghtImageName="0.png";

                                            $passwordStrenghtError="Password does not contain symbols ";
                                            break;
                                        }
                                        case -8: 
                                        {
                                            $passwordStrenghtImageName="0.png";

                                            $passwordStrenghtError="Password contains repeated character sequence in symbols. ";
                                            break;
                                        }
                                        case -9: 
                                        {
                                            $passwordStrenghtImageName="0.png";

                                            $passwordStrenghtError="Password contains repeated character sequence in symbol groups. ";
                                            break;
                                        }
                                        case 4:
                                        {
                                            $passwordStrenghtImageName="1.png";

                                            $passwordStrenghtError="Very weak password.";
                                            break;
                                        }
                                        case 5:
                                        {
                                            $passwordStrenghtImageName="2.png";

                                            $passwordStrenghtError="Weak password.";
                                            break;
                                        }
                                        case 6:
                                        {
                                            $passwordStrenghtImageName="3.png";

                                            $passwordStrenghtError="Average password. ";
                                            break;
                                        }
                                        case 7:
                                        {
                                            $passwordStrenghtImageName="4.png";

                                            $passwordStrenghtError="Strong password. ";
                                            break;
                                        }
                                        default:
                                        {
                                            if($returned>=8)
                                            {
                                                $passwordStrenghtImageName="5.png";

                                                $passwordStrenghtError="Very Strong password. ";
                                            }
                                             else 
                                             {
                                                 $passwordStrenghtImageName="0.png";

                                                $passwordStrenghtError="Password error. ";
                                             }   
                                            break;
                                        }
                                    }
                                    if(isset($passwordStrenghtError) && trim($passwordStrenghtError)!="")
                                    {
                                         $passwordErrorMessage.="$passwordStrenghtError <>";
                                    }
                                    if($returned>=8)
                                    {
                                        //change password

                                        try
                                        { 
                                            $pdo=$databaseConnection->getConnection();
                                            $pdo->beginTransaction();
                                            $pdoStatement = $pdo->prepare($get_user_password2);
                                            $isSuccess=$pdoStatement->execute(array($userID));
                                            $passwordUpdateImageVisible="visible";
                                            $passwordUpdateImageName="not_ok.png";
                                            if($isSuccess && $pdoStatement->rowCount()==1)
                                            {
                                                $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                if($row[0]==$currentPassword)
                                                {
                                                        $pdoStatement = $pdo->prepare($update_password);
                                                        $isSuccess=$pdoStatement->execute(array($newPassword,$userID));
                                                        if($isSuccess)
                                                        {
                                                            if($pdoStatement->rowCount()>0)
                                                            {
                                                                $passwordChangeMessage="Password change was successful. ";
                                                                $passwordErrorMessage.="Password change was successful. <>";
                                                                $passwordUpdateImageName="";
                                                                $currentPassword="";
                                                                $newPassword="";
                                                                $newPassword2="";
                                                                $passwordUpdateImageVisible="invisible";
                                                                $passwordStrenghtImageVisible="invisible";
                                                                $passwordErrorVisible="invisible";
                                                                $pdo->commit();
                                                            }
                                                            else
                                                            {
                                                                $passwordChangeMessage="Database error. User does not exist. ";
                                                                $passwordErrorMessage.="Database error. User does not exist. <>";
                                                            }
                                                        }
                                                         else 
                                                         {
                                                             $passwordChangeMessage="Database error. Password was not changed. ";
                                                             $passwordErrorMessage.="Database error. Password was not changed. <>";
                                                         }
                                                }
                                                else
                                                {
                                                    $passwordChangeMessage="Password mismatch. The current password you typed does not match the saved password. ";
                                                    $passwordErrorMessage.="Password mismatch. The current password you typed does not match the saved password. <>";
                                                } 
                                            }
                                             else 
                                             {
                                                 $passwordChangeMessage="User does not exist. ";
                                                 $passwordErrorMessage.="User does not exist. <>";
                                             }
                                        }
                                        catch(PDOException $I4)
                                        {
                                            if(isset($pdo))
                                            {
                                                $pdo->rollBack();
                                            }
                                        }
                                    }


                                }
                                 else 
                                 {
                                     $passwordEqualityError="New Password does not match";
                                     $passwordErrorMessage.="New Password does not match. <>";
                                     $passwordEualityImageVisible="visible";
                                     $passwordEualityImageName="not_ok.png";
                                 }
                            }
                            else
                            {
                                $newPassword2="";
                                $passwordChangeMessage="Re-type new password field is blank. ";
                                $passwordErrorMessage.="Re-type new password field is blank. <>";
                                $passwordUpdateImageVisible="visible";
                                $passwordUpdateImageName="not_ok.png";
                            }
                        }
                         else 
                         {
                            $newPassword="";
                            $passwordChangeMessage="New password field is blank. ";
                            $passwordErrorMessage.="New password field is blank. <>";
                            $passwordUpdateImageVisible="visible";
                            $passwordUpdateImageName="not_ok.png";
                         }
                    }
                }
                else
                {
                    $currentPassword="";
                    if((isset($newPassword) && $newPassword!=NULL && trim($newPassword)!="") || (isset($newPassword) && $newPassword!=NULL && trim($newPassword)!=""))
                    {
                        $currentPasswordError="Please type your current password. ";
                        $passwordErrorMessage.="Please type your current password. <>";
                        $passwordErrorMessage.="Current password cannot be null. Please type your current password. <>";
                    }

                }
                $current_answer=$_POST["current_answer"];
                $new_question=$_POST["new_question"];
                $new_answer=$_POST["new_Answer"];
                $current_question=$_POST["current_question"];
                try
                {
                    $pdo=$databaseConnection->getConnection();
                    $pdoStatement=$pdo->prepare($get_answer_to_secret_question);
                    $isSuccess=$pdoStatement->execute(array($userID));
                    $currentSecurityAnswerSet=false;
                    $databaseSecurityAnswer="";
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                            $databaseSecurityAnswer=$row[0];
                            if(isset($databaseSecurityAnswer) && $databaseSecurityAnswer!=NULL && trim($databaseSecurityAnswer)!="")
                            {
                                $currentSecurityAnswerSet=true;
                            }
                        }
                        else
                        {
                            $currentSecurityAnswerStatus="Database Error. User information does not exist on database";
                            $securityErrorMessage.="Database Error. User information does not exist on database. <>";
                        }
                    }
                    else
                    {
                        $currentSecurityAnswerStatus="Database Error. Cannot retreive user information";
                        $securityErrorMessage.="Database Error. Cannot retreive user information. <>";
                    }
                    if((isset($new_question) && $new_question!=NULL && trim($new_question)!="") || (isset($new_answer) && $new_answer!=NULL && trim($new_answer)!=""))
                    {
                        //either the new question or answer field has been populated
                        if((isset($new_question) && $new_question!=NULL && trim($new_question)!="") && (isset($new_answer) && $new_answer!=NULL && trim($new_answer)!=""))
                        {
                              //both the new question or answer field has been populated
                            $shouldUpdate=false;
                            if($currentSecurityAnswerSet && (isset($current_answer) && $current_answer!=NULL && trim($current_answer)!=""))
                            {
                                if($databaseSecurityAnswer==$current_answer)
                                {
                                    //can update security question and answer
                                    $shouldUpdate=true;
                                }
                                 else 
                                 {
                                     //cannot update security question and answer
                                     $currentSecurityAnswerImageName="not_ok.png";
                                     $currentSecurityAnswerImageVisible="visible";
                                     $currentSecurityAnswerVisible="visible";
                                     $currentSecurityAnswerStatus="Security Answer mismatch. Typed value does not match database value";
                                     $securityErrorMessage.="Security Answer mismatch. Typed value does not match database value. <>";
                                 }
                            }
                            else
                            {
                                //can update security question and answer
                                    $shouldUpdate=true;
                            }
                            if($shouldUpdate)
                            {
                                $pdo->beginTransaction();
                                $pdoStatement=$pdo->prepare($update_security_question_and_answer);
                                $isSuccess=$pdoStatement->execute(array($new_question,$new_answer,$userID));
                                if($isSuccess)
                                {
                                    if($pdoStatement->rowCount()>0)
                                    {
                                        $current_question=$new_question;
                                        $currentSecurityAnswerVisible="visible";
                                        $newSecurityQuestionStatus="Security question has been updated. ";
                                        $securityErrorMessage.="Security question has been updated. <>";
                                        $newSecurityQuestionImageVisible="visible";
                                        $newSecurityQuestionImageName="update_sucessful.png";
                                        $newSecurityAnswerStatus="Answer to security question has been updated.";
                                        $securityErrorMessage.="Answer to security question has been updated. <>";
                                        $newSecurityAnswerImageVisible="visible";
                                        $newSecurityAnswerImageName="update_sucessful.png";
                                        
                                        $pdo->commit();
                                    }
                                    else
                                    {
                                        $newSecurityQuestionStatus="Security question was not updated. ";
                                        $securityErrorMessage.="Security question was not updated. <>";
                                        $newSecurityQuestionImageVisible="visible";
                                        $newSecurityQuestionImageName="update_unsucessful.png";
                                        $newSecurityAnswerStatus="Answer to security question was not updated. Database value is consistent with current value";
                                        $securityErrorMessage.="Answer to security question was not updated. Database value is consistent with current value. <>";
                                        $newSecurityAnswerImageVisible="visible";
                                        $newSecurityAnswerImageName="update_unsucessful.png";
                                        $pdo->rollBack();
                                    }
                                }
                                else
                                {
                                    $newSecurityQuestionStatus="Security question was not updated. ";
                                    $securityErrorMessage.="Security question was not updated. <>";
                                    $newSecurityQuestionImageVisible="visible";
                                    $newSecurityQuestionImageName="update_unsucessful.png";
                                    $newSecurityAnswerStatus="Answer to security question was not updated. Database error";
                                    $securityErrorMessage.="Answer to security question was not updated. Database error. <>";
                                    $newSecurityAnswerImageVisible="visible";
                                    $newSecurityAnswerImageName="update_unsucessful.png";
                                    $pdo->rollBack();
                                }
                            }
                        }
                         else
                         {
                             if(!(isset($new_question) && $new_question!=NULL && trim($new_question)!=""))
                             {
                                    //the new question field has not been populated
                                 $newSecurityQuestionStatus="Please fill the Security question field";
                                 $securityErrorMessage.="Please fill the Security question field. <>";
                                 $newSecurityQuestionImageVisible="visible";
                                 $newSecurityQuestionImageName="not_ok.png";
                             }
                             else if(!(isset($new_answer) && $new_answer!=NULL && trim($new_answer)!=""))
                             {
                                    //the new answer field has NOT been populated
                                 $newSecurityAnswerStatus="Please answer the security question";
                                 $securityErrorMessage.="Please answer the security question. <>";
                                 $newSecurityAnswerImageVisible="visible";
                                 $newSecurityAnswerImageName="not_ok.png";
                             }
                             if($currentSecurityAnswerSet)
                             {
                                 $currentSecurityAnswerVisible="visible";
                             }
                         }

                    }
                    else
                    {
                        if($currentSecurityAnswerSet)
                        {
                            $currentSecurityAnswerVisible="visible";
                            if((isset($current_answer) && $current_answer!=NULL && trim($current_answer)!=""))
                            {
                                 $newSecurityQuestionStatus="Please fill the security question field";
                                 $securityErrorMessage.="Please fill the security question field. <>";
                                 $newSecurityQuestionImageVisible="visible";
                                 $newSecurityQuestionImageName="not_ok.png";
                                 $newSecurityAnswerStatus="Please answer the security question";
                                 $securityErrorMessage.="Please answer the security question. <>";
                                 $newSecurityAnswerImageVisible="visible";
                                 $newSecurityAnswerImageName="not_ok.png";
                            }
                        }

                    }
                }
                catch(PDOException $d)
                {
                    if(isset($pdo))
                     {
                         $pdo->rollBack();
                     }
                }
                //change login id
                $login_email_id=$_POST["login_email_id"];
                if((isset($login_email_id) && $login_email_id!=NULL && trim($login_email_id)!=""))
                {
                    try
                    {
                        $pdo=$databaseConnection->getConnection();
                        $pdo->beginTransaction();
                        $changeCommited=false;
                        $pdoStatement = $pdo->prepare($get_login_email_addresse_id);
                        $isSuccess=$pdoStatement->execute(array($userID));
                        
                        if($isSuccess && $pdoStatement->rowCount()>0)
                        {
                            $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                            $g=$row[0];
                            if($g!=$login_email_id)
                            {
                                if(isset($g)&& $g!=NULL && trim($g)!="");
                                {
                                    $pdoStatement = $pdo->prepare($update_login_email_id);
                                    $isSuccess=$pdoStatement->execute(array($login_email_id,$userID));
                                    if($isSuccess && $pdoStatement->rowCount()>0)
                                    {
                                        $loginEmailStatus="Login email was changed sucessfully. ";
                                        $loginChangeErrorMessage.="Login email was changed sucessfully. <>";
                                        $loginEmailStatusImageVisible="visible";
                                        $loginEmailStatusImageName="update_sucessful.png";
                                        $changeCommited=true;
                                        $pdo->commit();
                                    }
                                    else
                                    {
                                        $loginEmailStatus="Login email was not changed. New login email is the same as the current login email. ";
                                        $loginChangeErrorMessage.="Login email was not changed. New login email is the same as the current login email. <>";
                                        $loginEmailStatusImageVisible="visible";
                                        $loginEmailStatusImageName="update_unsucessful.png";

                                    }
                                }

                            }
                        }
                        else
                        {
                            $loginEmailStatus="Login email was not changed. Database error";
                            $loginChangeErrorMessage.="Login email was not changed. Database error. <>";
                            $loginEmailStatusImageVisible="visible";
                            $loginEmailStatusImageName="update_unsucessful.png";
                        }
                        if(!$changeCommited)
                        {
                            $pdo->rollBack();
                        }
                    }
                    catch(PDOException $r)
                    {
                        if(isset($pdo))
                        {
                            $pdo->rollBack();
                        }
                    }

                }
                $recovery_method_id=$_POST["recovery_method_id"];
                $recovery_option_id=$_POST["recovery_option_id"];

                    try
                    {
                        $pdo=$databaseConnection->getConnection();
                        $pdo->beginTransaction();
                        $changeCommited=false;
                        if(isset($recovery_method_id) && $recovery_method_id!=NULL && trim($recovery_method_id)!=null)
                        {
                            $pdoStatement = $pdo->prepare($update_recovery_method);
                            $isSuccess=$pdoStatement->execute(array($recovery_method_id,$userID));
                            if($isSuccess)
                            {
                                if($pdoStatement->rowCount()>0)
                                {
                                    $accountRecoveryStatusImageVisible="visible";
                                    $accountRecoveryStatusImageName="update_sucessful.png";
                                    $accountRecoveryStatus="Account recovery method changed successfully. ";
                                    $recoveryErrorMessage.="Account recovery method changed successfully. <>";
                                    $pdo->commit();
                                    $changeCommited=true;
                                }
                                else
                                {
    //                                $accountRecoveryStatusImageName="not_ok.png";
    //                                $accountRecoveryStatus="Account recovery method was not changed. ";
                                }
                            }
                            else
                            {
                                $accountRecoveryStatusImageVisible="visible";
                                $accountRecoveryStatusImageName="update_sucessful.png";
                                $accountRecoveryStatus="Account recovery method was not changed. ";
                                $recoveryErrorMessage.="Account recovery method was not changed. <>";
                            }
                        }
                        if(!$changeCommited)
                        {
                            $pdo->rollBack();
                        }
                        if(isset($recovery_option_id) && $recovery_option_id!=NULL && trim($recovery_option_id)!=null)
                        {
                            $pdoStatement = $pdo->prepare($get_communication_media_by_id);
                            $isSuccess=$pdoStatement->execute(array($recovery_method_id));
                            if($isSuccess && $pdoStatement->rowCount()>0)
                            {
                                $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                                $ff=$row[0];
                                if(isset($ff) && $ff!=NULL && trim($ff)!="")
                                {
                                    $recovery_media=  ucfirst($ff);
                                    $verificationQuery="";
                                    $updateQuery=$update_recovery_id;
                                    $verificationArray=array($userID,$recovery_option_id);
                                    $updateArray=array($recovery_option_id,$userID);
                                    if($recovery_media=="Phone")
                                    {
                                        $verificationQuery=$verify_phone_number_exist;
                                    }
                                    else if($recovery_media=="Email")
                                    {
                                        $verificationQuery=$verify_email_exist;
                                    }
                                     else if($recovery_media=="Website")
                                    {
                                         $verificationQuery=$verify_web_exist;
                                    }
                                    $pdoStatement = $pdo->prepare($verificationQuery);;
                                    $isSuccess=$pdoStatement->execute($verificationArray);
                                    if($isSuccess && $pdoStatement->rowCount()>0)
                                    {
                                        $pdoStatement = $pdo->prepare($updateQuery);
                                        $pdo->beginTransaction();
                                        $changeCommited=false;
                                        $isSuccess=$pdoStatement->execute($updateArray);
                                        if($isSuccess)
                                        {
                                            if($pdoStatement->rowCount()>0)
                                            {
                                                $accountRecoveryOptionStatusImageVisible="visible";
                                                $accountRecoveryOptionStatusImageName="update_sucessful.png";
                                                $accountRecoveryOptionStatus="$recovery_media was changed successfully";
                                                $recoveryErrorMessage.="$recovery_media was changed successfully. <>";
                                                $pdo->commit();
                                                $changeCommited=true;
                                            }
                                            else
                                            {
    //                                            $accountRecoveryOptionStatusImageName="not_ok.png";
    //                                            $accountRecoveryOptionStatus="$recovery_media was not changed";
                                            }
                                        }
                                        else
                                        {
                                            $accountRecoveryOptionStatusImageVisible="visible";
                                            $accountRecoveryOptionStatusImageName="update_unsucessful.png";
                                            $accountRecoveryOptionStatus="$recovery_media was not changed";
                                            $recoveryErrorMessage.="$recovery_media was not changed. <>";
                                        }
                                        if(!$changeCommited)
                                        {
                                            $pdo->rollBack();
                                        }
                                    }
                                    else
                                    {

                                    }
                                }
                            }
                            else
                            {

                            }
                        }
                        else
                        {

                        }
                    }
                    catch(PDOException $r)
                    {
                        if(isset($pdo))
                        {
                            $pdo->rollBack();
                        }

                    }
                    if(isset($passwordChangeMessage) && trim($passwordChangeMessage)!="")
                    {
                        $errorMessage.="Feedback on password change<=>$passwordChangeMessage<...>";
                    }
                    if(isset($securityErrorMessage) && trim($securityErrorMessage)!="")
                    {
                        $errorMessage.="Feedback on modify security question/answer<=>$securityErrorMessage<...>";
                    }
                    if(isset($recoveryErrorMessage) && trim($recoveryErrorMessage)!="")
                    {
                        $errorMessage.="Feedback on change of password recovery method<=>$recoveryErrorMessage<...>";
                    }
                    if(isset($loginChangeErrorMessage) && trim($loginChangeErrorMessage)!="")
                    {
                        $errorMessage.="Feedback on change of login email<=>$loginChangeErrorMessage<...>";
                    }
            }
            else
            {

                try
                { 
                    $pdo=$databaseConnection->getConnection();
                    $pdo->beginTransaction();
                    $pdoStatement = $pdo->prepare($get_user_authentication_data);
                    $isSuccess=$pdoStatement->execute(array($userID));
                    if($isSuccess && $pdoStatement->rowCount()==1)
                    {
                        list($current_question,$current_answer,$recovery_method_id,$recovery_option_id,$login_email_id)=$pdoStatement->fetch(PDO::FETCH_NUM);
                        if(isset($current_answer) && $current_answer!=NULL && trim($current_answer)!="")
                        {
                            $currentSecurityAnswerVisible="visible";
                        }
                        if(!isset($current_question) || $current_question==NULL)
                        {
                            $current_question="";
                        }
                    }
                     else 
                     {
    //                     $rt=$pdoStatement->errorInfo();
    //                     print"$rt[2]";
                     }
                }
                 catch (PDOException $s)
                 {
                     if(isset($pdo))
                     {
                         $pdo->rollBack();
                     }
                 }
            }
            //show password change error
            if(trim($passwordEqualityError)!="" || trim($passwordStrenghtError)!="" || trim($passwordChangeMessage)!="" || trim($currentPasswordError)!="")
            {
                $passwordErrorVisible="visible";
            }
            else
            {
                $passwordErrorVisible="invisible";
            }
            //show security question and answerChange message
            if(trim($currentSecurityAnswerStatus)!="" || trim($newSecurityQuestionStatus)!="" || trim($newSecurityAnswerStatus)!="")
            {
                $securityQuestionAndAnswerStatusVisible="visible";
            }
            else
            {
                $securityQuestionAndAnswerStatusVisible="invisible";
            }
            //show login status
            if(trim($loginEmailStatus!=""))
            {
                $loginPanelStatusVisible="visible";
            }
            else
            {
                $loginPanelStatusVisible="invisible";
            }
            //handle options
            if($accountRecoveryOptionStatus!="" || $accountRecoveryStatus!="")
            {
                $passwordRecoveryMeansStatusVisible="visible";
            }
            
            //set view tab
            if((isset($passwordErrorMessage) && trim($passwordErrorMessage)!="") || trim($passwordErrorVisible)=="visible"  )
            {
                $securityPanelLocation-=$passwordPanelLocation;
                $recoveryPanelLocation-=$passwordPanelLocation;
                $loginChangePanelLocation-=$passwordPanelLocation;
                $passwordPanelLocation=0;
                $passwordTabSelected="highlight";
                $recoveryTabSelected="highlight2";
                $loginChangeTabSelected="highlight2";
                $securityTabSelected="highlight2";
            }
            elseif((isset($securityErrorMessage) && trim($securityErrorMessage)!="") || trim($securityQuestionAndAnswerStatusVisible)=="visible"  )
            {
                $passwordPanelLocation-=$securityPanelLocation;
                $recoveryPanelLocation-=$securityPanelLocation;
                $loginChangePanelLocation-=$securityPanelLocation;
                $securityPanelLocation=0;
                $passwordTabSelected="highlight2";
                $recoveryTabSelected="highlight2";
                $loginChangeTabSelected="highlight2";
                $securityTabSelected="highlight";
            }
            elseif((isset($recoveryErrorMessage) && trim($recoveryErrorMessage)!="") || trim($passwordRecoveryMeansStatusVisible)=="visible"  )
            {
                $passwordPanelLocation-=$recoveryPanelLocation;
                $securityPanelLocation-=$recoveryPanelLocation;
                $loginChangePanelLocation-=$recoveryPanelLocation;
                $recoveryPanelLocation=0;
                $passwordTabSelected="highlight2";
                $recoveryTabSelected="highlight";
                $loginChangeTabSelected="highlight2";
                $securityTabSelected="highlight2";
            }
            elseif((isset($loginChangeErrorMessage) && trim($loginChangeErrorMessage)!="") || trim($loginPanelStatusVisible)=="visible"  )
            {
                $passwordPanelLocation-=$loginChangePanelLocation;
                $securityPanelLocation-=$loginChangePanelLocation;
                $recoveryPanelLocation-=$loginChangePanelLocation;
                $loginChangePanelLocation=0;
                $passwordTabSelected="highlight2";
                $recoveryTabSelected="highlight2";
                $loginChangeTabSelected="highlight";
                $securityTabSelected="highlight2";
            }
            if(!(isset($recovery_method_id) && $recovery_method_id!=NULL && trim($recovery_method_id)!=""))
            {
                $recovery_method_id="1";
                $recovery_media="Email";
                // RECOVERY id MUST BE SET WHEN USERR IS ADDED
            }
            else
            {


                try
                {
                    $pdo=$databaseConnection->getConnection();
                    $pdoStatement = $pdo->prepare($get_communication_media_by_id);
                    $isSuccess=$pdoStatement->execute(array($recovery_method_id));
                    if($isSuccess && $pdoStatement->rowCount()>0)
                    {
                        $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                        $ff=$row[0];
                        if(isset($ff) && $ff!=NULL && trim($ff)!="")
                        {
                            $recovery_media=$ff;
                        }
                        else
                        {
                            $recovery_media="Email";
                        }
                    }
                    else
                    {
                        $recovery_media="Email";
                    }

                }
                catch(PDOException $r)
                {
                    $recovery_media="Email";

                }
            }
            $recovery_media=  ucfirst($recovery_media);
            if(isset($recovery_option_id) && $recovery_option_id!=NULL && trim($recovery_option_id)!="")
            {
                if($recovery_media=="Phone")
                {
                    $temp->parseSQLAndVariable(2,"recovery_options", "get_phone_code_number=>$userID", 3,array("value","text"), "0:==:$recovery_option_id:selected::isselected");
                }
                else if($recovery_media=="Email")
                {
                    $temp->parseSQLAndVariable(2,"recovery_options", "get_email_id_and_address=>$userID", 3,array("value","text"), "0:==:$recovery_option_id:selected::isselected");
                }
                 else if($recovery_media=="Website")
                {
                    $temp->parseSQLAndVariable(2,"recovery_options", "get_web_address=>$userID", 3,array("text","value"), "1:==:$recovery_option_id:selected::isselected");
                }
            }
            else
            {
                if($recovery_media=="Phone")
                {
                    $temp->parseSQLAndVariable(2,"recovery_options", "get_phone_code_number=>$userID", 3,array("value","text"), "");
                }
                else if($recovery_media=="Email")
                {
                    $temp->parseSQLAndVariable(2,"recovery_options", "get_email_id_and_address=>$userID", 3,array("value","text"), "");
                }
                 else if($recovery_media=="Website")
                {
                    $temp->parseSQLAndVariable(2,"recovery_options", "get_web_address=>$userID", 3,array("text","value"), "");
                }
            }
            $temp->parseSQLAndVariable(2,"login_email_options", "get_email_id_and_address=>$userID", 3,array("value","text"), "0:==:$login_email_id:selected::isselected");
            $temp->parseSQLAndVariable(2,"account_recovery_methods", "get_communication_types", 3,array("value","text"), "0:==:$recovery_method_id:selected::isselected");
        }
        elseif ($selectedTab==3) 
        {
            $seen=$_POST["seen"];
            $currencyStatusVisible="invisible";
            $basecurrencyStatusVisible="invisible";
            $baseCurrencyStatusImageVisible="invisible";
//            $productCategoryStatusVisible="invisible";
//            $communicationMethodStatusVisible="invisible";
            $currencyStatusMessage="";
            $basecurrencyStatusMessage="";
//            $productCategoryStatusMessage="";
//            $communicationMethodStatusMessage="";

            $baseCurrencyStatusImageName="not_ok.png";

            $userCurrenciesArray=array();
            $userBaseCurrency="";
            $userProductCategoriesGroupArray=array();
            $userProductCategoriesArray=array();
            $userCommunicationArray=array();
            $userEmailArray=array();
            $userMobileArray=array();
            $userWebArray=array();

            $currencyCheckboxNamePrefix="currency";
            $purchasecategoryCheckboxNamePrefix="category";
            $communicationCheckboxNamePrefix="communication";
            $emailPrefix="email";
            $webPrefix="web";
            $mobilePrefix="mobile";
            $categorySubCheckboxPrefix="sub-division";
            $updateCategoryStatusVisiblePrefix="update_category";
            $updateCategoryStatusImageNamePrefix="update_category_image";
            $updateCategoryStatusMessagePrefix="update_category_message";
            $deleteCategoryStatusVisiblePrefix="delete_category";
            $deleteCategoryStatusImageNamePrefix="delete_category_image";
            $deleteCategoryStatusMessagePrefix="delete_category_message";
            
            $updateSubCategorySuccessfulStatusVisiblePrefix="update_sub_category_successful";
            $updateSubCategorySuccessfulStatusImageNamePrefix="update_sub_category_image_successful";
            $updateSubCategorySuccessfulStatusMessagePrefix="update_sub_category_message_successful";
            
            $updateSubCategoryFailedStatusVisiblePrefix="update_sub_category_failed";
            $updateSubCategoryFailedStatusImageNamePrefix="update_sub_category_image_failed";
            $updateSubCategoryFailedStatusMessagePrefix="update_sub_category_message_failed";
            
            $deleteSubCategoryFailedStatusVisiblePrefix="delete_sub_category_failed";
            $deleteSubCategoryFailedStatusImageNamePrefix="delete_sub_category_image_failed";
            $deleteSubCategoryFailedStatusMessagePrefix="delete_sub_category_message_failed";
            
            $deleteSubCategorydSuccessfulStatusVisiblePrefix="delete_sub_category_method_successful";
            $deleteSubCategorySuccessfulStatusImageNamePrefix="delete_sub_category_method_image_successful";
            $deleteSubCategorySuccessfulStatusMessagePrefix="delete_sub_category_method_message_successful";
            
            $updateSuccessfullPrefixArray=array($updateSubCategorySuccessfulStatusVisiblePrefix,$updateSubCategorySuccessfulStatusImageNamePrefix,$updateSubCategorySuccessfulStatusMessagePrefix);
            $updateFailedPrefixArray=array($updateSubCategoryFailedStatusVisiblePrefix,$updateSubCategoryFailedStatusImageNamePrefix,$updateSubCategoryFailedStatusMessagePrefix);
            $deleteSuccessfullPrefixArray=array($deleteSubCategorydSuccessfulStatusVisiblePrefix,$deleteSubCategorySuccessfulStatusImageNamePrefix,$deleteSubCategorySuccessfulStatusMessagePrefix);
            $deleteFailedPrefixArray=array($deleteSubCategoryFailedStatusVisiblePrefix,$deleteSubCategoryFailedStatusImageNamePrefix,$deleteSubCategoryFailedStatusMessagePrefix);
            $categoryGroupUpdateStatusArray=array($updateCategoryStatusVisiblePrefix,$updateCategoryStatusImageNamePrefix,$updateCategoryStatusMessagePrefix);
            $categoryGroupDeleteStatusArray=array($deleteCategoryStatusVisiblePrefix,$deleteCategoryStatusImageNamePrefix,$deleteCategoryStatusMessagePrefix);
            
            
            $emailSubStatusMessageArray=array();
            $phoneSubStatusMessageArray=array();
            $webSubStatusMessageArray=array();
            $communicationStatusMessageArray=array();
            $purchaseCategoryStatusMessageArray=array();
            $purchaseCategorySubStatusMessageArray=array();
            
            $noOfDealsVisible="";
            $noOfDealsVisibleChecked="";
            $noOfDealsVisibleStatusImage="";
            $noOfDealsVisibleStatusMessage="";
            $noOfDealsVisibleStatusImageVisible="invisible";
            
            $dealValueVisibleChecked="";
            $dealValueVisible="";
            $dealValueVisibleStatusImage="";
            $dealValueVisibleStatusMessage="";
            $dealValueVisibleStatusImageVisible="invisible";
            
            $delimiter="<>";
            $baseCurrencyTabSelected="highlight";
            $operationCurrencyTabSelected="highlight2";
            $communicationTabSelected="highlight2";
            $categoryTabSelected="highlight2";
            $transactionPreferenceTabSelected="highlight2";
            
            $baseCurrencyPanelLocation=0;
            $operationCurrencyPanelLocation=750;
            $communicationPanelLocation=1500;
            $categoryLocation=2250;
            $transactionPreferencePanelLocation=3000;
            
            
            $baseCurrencyErrorMessage="";
            $operationCurrencyErrorMessage="";
            $communicationErrorMessage="";
            $categoryErrorMessage="";
            $transactionPreferenceErrorMessage="";
            $authorizationPercentageVisible="invisible";
            $arbitrationPercentageVisible="invisible";
            $authorizationPercentage="0";
            $arbitrationPercentage="0";
            $authorizationChargeStatusImage="";
            $authorizationChargeStatusMessage="";
            $authorizationChargeImageVisible="invisible";
            $arbitrationChargeStatusImage="";
            $arbitrationChargeStatusMessage="";
            $arbitrationChargeImageVisible="invisible";
            
            $temp->registerFiles(2, "../page_segments/preferencesupdate.html");
            $temp->registerFiles(3, "../page_segments/options.html");
            $temp->registerFiles(4, "../page_segments/checkbox.html");
            $temp->registerFiles(7, "../page_segments/checkboxwithsubs.html");
            $temp->registerFiles(8, "../page_segments/checkboxwithdisable.html");
            $temp->registerString(5, "<tr>{group}</tr>");
            $temp->registerVariables(2,"currencyStatusVisible,basecurrencyStatusVisible,baseCurrencyStatusImageVisible");
            $temp->registerVariables(2,"currencyStatusMessage,basecurrencyStatusMessage");
            $temp->registerVariables(2,"authorizationPercentageVisible,arbitrationPercentageVisible,authorizationPercentage,arbitrationPercentage");
            $temp->registerVariables(2,"authorizationChargeStatusImage,authorizationChargeStatusMessage,authorizationChargeImageVisible");
            $temp->registerVariables(2,"arbitrationChargeStatusImage,arbitrationChargeStatusMessage,arbitrationChargeImageVisible");
            $temp->registerVariables(2,"baseCurrencyTabSelected,operationCurrencyTabSelected,communicationTabSelected,categoryTabSelected,transactionPreferenceTabSelected");
            $temp->registerVariables(2,"baseCurrencyPanelLocation,operationCurrencyPanelLocation,communicationPanelLocation,categoryLocation,transactionPreferencePanelLocation");
            $temp->registerVariables(2,"baseCurrencyStatusImageName,delimiter");
            $temp->registerVariables(2,"dealValueVisible,dealValueVisibleChecked,noOfDealsVisible,noOfDealsVisibleChecked,noOfDealsVisibleStatusMessage,noOfDealsVisibleStatusImage,noOfDealsVisibleStatusImageVisible,dealValueVisibleStatusImage,dealValueVisibleStatusMessage,dealValueVisibleStatusImageVisible");
            if($seen)
            {
                
                $userBaseCurrency=$_POST["baseCurrency"];
                $avoidRequestforDefaultCurrency=false;
                try
                {
                    if(isset($userBaseCurrency) && $userBaseCurrency!=NULL && trim($userBaseCurrency)!="")
                    {
                        $pdoStatement = $pdo->prepare($get_user_base_currency);
                        $isSuccess=$pdoStatement->execute(array($userID));
                        $storedBaseCurrrency="";
                        if($isSuccess)
                        {
                            if($pdoStatement->rowCount()>0)
                            {
                                $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                                $storedBaseCurrrency=$row[0];
                            }
                        }
                        if(isset($storedBaseCurrrency) && $storedBaseCurrrency!=NULL && trim($storedBaseCurrrency)!="")
                        {

                            
//                            $pdo->beginTransaction();
                            if($userBaseCurrency!=$storedBaseCurrrency)
                            {
                                //clear current base currency
                                $pdoStatement = $pdo->prepare($update_user_base_currency);
                                $isSuccess=$pdoStatement->execute(array('0',$userID,$storedBaseCurrrency));
                                if($isSuccess && $pdoStatement->rowCount()>0)
                                {
        //                            $pdoStatement = $pdo->prepare($update_user_base_currency);
                                    $isSuccess=$pdoStatement->execute(array('1',$userID,$userBaseCurrency));
                                    if($isSuccess && $pdoStatement->rowCount()>0)
                                    {
                                        $basecurrencyStatusMessage="Base currency was changed";
                                        $baseCurrencyErrorMessage.="Base currency was changed. <>";
                                        $baseCurrencyStatusImageName="update_sucessful.png";
                                        $baseCurrencyStatusImageVisible="visible";
                                        $avoidRequestforDefaultCurrency=true;
//                                        $pdo->commit();
                                    }
                                    else
                                    {
                                        $basecurrencyStatusMessage="Could not change base currency";
                                        $baseCurrencyErrorMessage.="Base currency was not changed. <>";
                                        $baseCurrencyStatusImageName="update_unsucessful.png";
                                        $baseCurrencyStatusImageVisible="visible";
//                                        $pdo->rollBack();
                                    }
                                }
                                else
                                {
                                    $basecurrencyStatusMessage="Could not change base currency";
                                    $baseCurrencyErrorMessage.="Base currency was not changed. <>";
                                    $baseCurrencyStatusImageName="update_unsucessful.png";
                                    $baseCurrencyStatusImageVisible="visible";
                                }
                            }
                        }
                        else
                        {
                            // no base currency has been saved
//                             $pdoStatement = $pdo->prepare($update_user_base_currency);
                            $pdoStatement = $pdo->prepare($add_user_base_currency);
                            $isSuccess=$pdoStatement->execute(array($userID,$userBaseCurrency,'1'));
                            if($isSuccess && $pdoStatement->rowCount()>0)
                            {
                                $basecurrencyStatusMessage="Base currency was changed successfully";
                                $baseCurrencyErrorMessage.="Base currency was set successfully. <>";
                                $avoidRequestforDefaultCurrency=true;
                                $baseCurrencyStatusImageName="update_sucessful.png";
                                $baseCurrencyStatusImageVisible="visible";
//                                $pdo->commit();
                            }
                            else
                            {
                                $basecurrencyStatusMessage="Could not change base currency";
                                $baseCurrencyErrorMessage.="Apologies we could not set your base currency. <>";
                                $baseCurrencyStatusImageName="update_unsucessful.png";
                                $baseCurrencyStatusImageVisible="visible";
//                                $pdo->rollBack();
                            }
                        }
                    }
                }
                catch(PDOException $rrrr)
                {
                    
                }
                
                try
                {
                    $pdo=$databaseConnection->getConnection();
                    $pdoStatement = $pdo->prepare($get_currencies_count);
                    $isSuccess=$pdoStatement->execute();
                    if($isSuccess)
                    {
                        $dd=$pdoStatement->fetch(PDO::FETCH_NUM);
                        if(isset($dd) && is_array($dd))
                        {
                            $currencyCount=  intval($dd[0]);
                            if(is_int($currencyCount) && $currencyCount>0)
                            {
                                for($t=1;$t<=$currencyCount;$t++)
                                {
                                    $selectedCurrency=$_POST["$currencyCheckboxNamePrefix". strval($t)];
                                    if(isset($selectedCurrency) && $selectedCurrency!=NULL && trim($selectedCurrency)!="")
                                    {
                                       $userCurrenciesArray[]=$selectedCurrency;
                                    }
                                }
                                $defaultCurrency="";
                                if($avoidRequestforDefaultCurrency)
                                {
                                    $defaultCurrency=$userBaseCurrency;
                                }
                                else
                                {
                                    $pdoStatement=$pdo->prepare($get_user_base_currency);
                                    $isSuccess=$pdoStatement->execute(array($userID));
                                    if($isSuccess && $pdoStatement->rowCount()>0)
                                    {
                                        $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                                        if(is_array($row) && count($row)>0)
                                        {
                                            $defaultCurrency=$row[0];
                                        }
                                    }
                                }
                                
                                list($userCurrenciesArray,$operationCurrencyErrorMessage)=$genericMethod->manageCheckBoxInput($userID, $userCurrenciesArray,$defaultCurrency, $get_user_currencies_id, $add_user_currency,"", $delete_user_currency_by_user_id, $delete_user_currency_by_user_id_and_currency_id, "currency", "currencies",array('0'));
                                if(isset($operationCurrencyErrorMessage) && trim($operationCurrencyErrorMessage)!="")
                                {
                                    $currencyStatusMessage=  str_replace('<>',"", $operationCurrencyErrorMessage);
                                }
                                
                            }
                        }
                    }

                }
                catch(PDOException $e)
                {

                }
                try
                {
                    $pdo=$databaseConnection->getConnection();
                    $pdoStatement = $pdo->prepare($get_purchase_category_group_id);
                    $isSuccess=$pdoStatement->execute();
                    if($isSuccess)
                    {
                        $dd=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                        if(isset($dd) && is_array($dd))
                        {
                            $queryResultCount=  count($dd);
                            if(is_int($queryResultCount) && $queryResultCount>0)
                            {
                                for($t=0;$t<$queryResultCount;$t++)
                                {
                                    $selectedResult=$_POST["$purchasecategoryCheckboxNamePrefix".$dd[$t]];
                                    if(isset($selectedResult) && $selectedResult!=NULL && trim($selectedResult)!="")
                                    {
                                       $userProductCategoriesGroupArray[]=$selectedResult;
                                    }
                                }
                                $purchaseCategoryStatusMessageArray=$genericMethod->manageCheckBoxInput2($userID, $userProductCategoriesGroupArray,"", $get_user_purchase_category_group_id, $add_user_product_category_group,"", $delete_user_product_category_group_by_user_id, $delete_user_product_category_group_by_user_id_and_group_id, "product group", "product groups");
                                if(isset($purchaseCategoryStatusMessageArray) && count($purchaseCategoryStatusMessageArray)>0)
                                {
                                    $userProductCategoriesGroupArray=$purchaseCategoryStatusMessageArray[0];
                                }
                                for($t=0;$t<$queryResultCount;$t++)
                                {
                                    if(in_array($dd[$t], $userProductCategoriesGroupArray))
                                    {
                                        //check for check box of subcomponents.
                                        $pdo=$databaseConnection->getConnection();
                                        $pdoStatement = $pdo->prepare($get_purchase_category_by_group);
                                        $isSuccess=$pdoStatement->execute(array($dd[$t]));
                                        if($isSuccess)
                                        {
                                            $subs=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                                            if(isset($subs) && is_array($subs))
                                            {
                                                $subsCount=  count($subs);
                                                if(is_int($subsCount) && $subsCount>0)
                                                {
                                                    $innerUserPurchaseCategorySelected=array();
                                                    for($b=0;$b<$subsCount;$b++)
                                                    {
                                                        $subResult=$_POST["$purchasecategoryCheckboxNamePrefix".$dd[$t].$subs[$b]];
//                                                        print "$purchasecategoryCheckboxNamePrefix".$dd[$t].$subs[$b]." --- $subResult<br>";
                                                         if(isset($subResult) && $subResult!=NULL && trim($subResult)!="")
                                                         {
                                                             $innerUserPurchaseCategorySelected[]=$subResult;
                                                         }
                                                    }
                                                    $y=$genericMethod->manageCheckBoxInput2($userID, $innerUserPurchaseCategorySelected,"", $get_user_product_categories_id_by_category_group, $add_user_product_category,array($dd[$t]), $delete_user_product_category_by_user_id, $delete_user_product_category_by_user_id_and_currency_id,array($dd[$t]),"",array($dd[$t]));
                                                    if(isset($y) && is_array($y) && count($y)>0)
                                                    {
                                                        $purchaseCategorySubStatusMessageArray[$dd[$t]]=$y;
                                                        $userProductCategoriesArray[$dd[$t]] =$y[0];
//                                                        print "".implode(":", $y[0]);
                                                    }
                                                    
                                                }
                                            }
                                        }
                                    }
                                    else
                                    {
                                        //load default
                                        $pdoStatement = $pdo->prepare($get_user_product_categories_id_by_category_group);
                                        $isSuccess=$pdoStatement->execute(array($userID,$dd[$t]));
                                        if($isSuccess)
                                        {
                                            if($pdoStatement->rowCount()>0)
                                            {
                                                $userProductCategoriesArray[$dd[$t]]=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                                            }
                                        }
                                    }
                                }
                                    
                            }
                        }
                    }

                }
                catch(PDOException $e)
                {

                }
                try
                {
                    $pdo=$databaseConnection->getConnection();
                    
                    $pdoStatement = $pdo->prepare($get_communication_media_id);
                    $isSuccess=$pdoStatement->execute();
                    if($isSuccess)
                    {
                        $dd=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                        if(isset($dd) && is_array($dd))
                        {
                            $queryResultCount= count($dd);
                            if(is_int($queryResultCount) && $queryResultCount>0)
                            {
                                for($t=0;$t<$queryResultCount;$t++)
                                {
                                    $selectedResult=$_POST["$communicationCheckboxNamePrefix". $dd[$t]];
                                    if(isset($selectedResult) && $selectedResult!=NULL && trim($selectedResult)!="")
                                    {
                                       $userCommunicationArray[]=$selectedResult;
                                    }
                                }
                                $communicationStatusMessageArray=$genericMethod->manageCheckBoxInput2($userID, $userCommunicationArray,"", $get_user_communication_id, $add_user_commommunication_media,"", $delete_user_communication_media_by_user_id, $delete_user_communication_media_by_user_id_and_currency_id,array('0'));
                                if(isset($communicationStatusMessageArray) && count($communicationStatusMessageArray)>0)
                                {
                                    $userCommunicationArray=$communicationStatusMessageArray[0];
                                }
//                                list($userCommunicationArray,$communicationMethodStatusMessage)=$genericMethod->manageCheckBoxInput($userID, $userCommunicationArray,"", $get_user_communication_id, $add_user_commommunication_media,"", $delete_user_communication_media_by_user_id, $delete_user_communication_media_by_user_id_and_currency_id, "communication method", "communication methods",array('0'));
                            }
                        }
                    }
//                    if(isset($userCommunicationArray) && is_array($userCommunicationArray))
                    {
                        $pdoStatement = $pdo->prepare($get_email_communuication_method_id);
                        $isSuccess=$pdoStatement->execute();
                        if($isSuccess)
                        {
                            if($pdoStatement->rowCount()>0)
                            {
                                $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                                if(in_array($row[0], $userCommunicationArray))
                                {
                                    $pdoStatement = $pdo->prepare($get_user_email_id);
                                    $isSuccess=$pdoStatement->execute(array($userID));
                                    if($isSuccess)
                                    {
                                        if($pdoStatement->rowCount()>0)
                                        {
                                            $dd=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                                            if(isset($dd) && is_array($dd))
                                            {
                                                $queryResultCount= count($dd);
                                                if(is_int($queryResultCount) && $queryResultCount>0)
                                                {
                                                    for($t=0;$t<$queryResultCount;$t++)
                                                    {
                                                        $selectedResult=$_POST["$emailPrefix". $dd[$t]];
                                                        if(isset($selectedResult) && $selectedResult!=NULL && trim($selectedResult)!="")
                                                        {
                                                           $userEmailArray[]=$selectedResult;
                                                        }
                                                    }
//                                                    if(in_array($row[0], $userCommunicationArray))
                                                    {
                                                        $emailSubStatusMessageArray=$genericMethod->manageCheckBoxInput2($userID, $userEmailArray,"", $get_communication_email_id, $add_user_communication_email,"", $remove_all_user_communication_email, $remove_user_communication_email_by_email_id_and_user_id);
                                                        if(isset($emailSubStatusMessageArray) && count($emailSubStatusMessageArray)>0)
                                                        {
                                                            $userEmailArray=$emailSubStatusMessageArray[0];
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                else
                                {
//                                    $currentUserCommunicationArray
                                    $pdoStatement = $pdo->prepare($get_communication_email_id);
                                    $isSuccess=$pdoStatement->execute(array($userID));
                                    if($isSuccess)
                                    {
                                        if($pdoStatement->rowCount()>0)
                                        {
                                            $userEmailArray=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                                        }
                                    }
                                }
                            }
                        }
                        $pdoStatement = $pdo->prepare($get_web_communuication_method_id);
                        $isSuccess=$pdoStatement->execute();
                        if($isSuccess)
                        {
                            if($pdoStatement->rowCount()>0)
                            {
                                $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                                if(in_array($row[0], $userCommunicationArray))
                                {
                                    $pdoStatement = $pdo->prepare($get_user_web_id);
                                    $isSuccess=$pdoStatement->execute(array($userID));
                                    if($isSuccess)
                                    {
                                        if($pdoStatement->rowCount()>0)
                                        {
                                            $dd=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                                            if(isset($dd) && is_array($dd))
                                            {
                                                $queryResultCount= count($dd);
                                                if(is_int($queryResultCount) && $queryResultCount>0)
                                                {
                                                    for($t=0;$t<$queryResultCount;$t++)
                                                    {
                                                        $selectedResult=$_POST["$webPrefix". $dd[$t]];
                                                        if(isset($selectedResult) && $selectedResult!=NULL && trim($selectedResult)!="")
                                                        {
                                                           $userWebArray[]=$selectedResult;
                                                        }
                                                    }
//                                                    i         f(in_array($row[0], $userCommunicationArray))
                                                    {
                                                        $webSubStatusMessageArray=$genericMethod->manageCheckBoxInput2($userID, $userWebArray,"", $get_communication_web_id, $add_user_communication_web,"", $remove_all_user_communication_web, $remove_user_communication_web_by_web_id_and_user_id);
                                                        if(isset($webSubStatusMessageArray) && count($webSubStatusMessageArray)>0)
                                                        {
                                                            $webSubStatusMessageArray[0]=$userWebArray;
                                                        }
                                                    }
                                                    
                                                 }
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    $pdoStatement = $pdo->prepare($get_communication_web_id);
                                    $isSuccess=$pdoStatement->execute(array($userID));
                                    if($isSuccess)
                                    {
                                        if($pdoStatement->rowCount()>0)
                                        {
                                            $userWebArray=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);

                                        }
                                    }
                                }
                            }
                        }
                        $pdoStatement = $pdo->prepare($get_phone_communuication_method_id);
                        $isSuccess=$pdoStatement->execute();
                        if($isSuccess)
                        {
                            if($pdoStatement->rowCount()>0)
                            {
                                $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                                if(in_array($row[0], $userCommunicationArray))
                                {
                                    $pdoStatement = $pdo->prepare($get_user_mobile_id);
                                    $isSuccess=$pdoStatement->execute(array($userID));
                                    if($isSuccess)
                                    {
                                        if($pdoStatement->rowCount()>0)
                                        {
                                            $dd=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                                            if(isset($dd) && is_array($dd))
                                            {
                                                $queryResultCount= count($dd);
                                                if(is_int($queryResultCount) && $queryResultCount>0)
                                                {
                                                    for($t=0;$t<$queryResultCount;$t++)
                                                    {
                                                        $selectedResult=$_POST["$mobilePrefix". $dd[$t]];
                                                        if(isset($selectedResult) && $selectedResult!=NULL && trim($selectedResult)!="")
                                                        {
                                                           $userMobileArray[]=$selectedResult;
                                                        }
                                                    }
//                                                    if(in_array($row[0], $userCommunicationArray))
                                                    {
                                                        $phoneSubStatusMessageArray=$genericMethod->manageCheckBoxInput2($userID, $userMobileArray,"", $get_communication_phone_id, $add_user_communication_mobile,"", $remove_all_user_communication_mobile, $remove_user_communication_mobile_by_mobile_id_and_user_id);
                                                        if(isset($phoneSubStatusMessageArray) && count($phoneSubStatusMessageArray)>0)
                                                        {
                                                            $userMobileArray =$phoneSubStatusMessageArray[0];
                                                        }
                                                    }
                                                 }
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    $pdoStatement = $pdo->prepare($get_communication_phone_id);
                                    $isSuccess=$pdoStatement->execute(array($userID));
                                    if($isSuccess)
                                    {
                                        if($pdoStatement->rowCount()>0)
                                        {
                                            $userMobileArray=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);

                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                catch(PDOException $e)
                {

                }
                $_4=array();
                $dealValueVisible=$_POST["dealValueVisible"];
                $posMess="The total value of deals would be visible to others";
                $negMess="The total value of deals would not be visible to others";
                if(isset($dealValueVisible) && trim($dealValueVisible)!="")
                {
                    $dealValueVisible="1";
                 }
                 else
                 {
                     $dealValueVisible="0";
                 }
                 $_4=$genericMethod->updateSingularElement($dealValueVisible, $update_for_total_deal_amount, array($userID), "1", "0", array("checkValue"=>"checked","message"=>"$posMess","image"=>"update_sucessful.png"), array("checkValue"=>"","message"=>"$negMess","image"=>"delete_successfull.png"), array("checkValue"=>"","message"=>"","image"=>""), array("checkValue"=>"checked","message"=>"","image"=>""), array("checkValue"=>"","message"=>"","image"=>"")); 
                 if(isset($_4) && is_array($_4) && count($_4)>0)
                {
                    $dealValueVisibleChecked=$_4["checkValue"];
                    $dealValueVisibleStatusMessage=$_4["message"];
                    if(isset($dealValueVisibleStatusMessage) && trim($dealValueVisibleStatusMessage)!="")
                    {
                        $transactionPreferenceErrorMessage.="$dealValueVisibleStatusMessage <>";
                    }
                    $dealValueVisibleStatusImage=$_4["image"];
                }
                else
                 {
                     $dealValueVisible="0";
                     $dealValueVisibleChecked="";
                 }
                  
                 $_2=array();
                $posMess="The total number of deals would be visible to others";
                $negMess="The total number of deals would not be visible to others";
                $noOfDealsVisible=$_POST["noOfDealsVisible"];
                if(isset($noOfDealsVisible) && trim($noOfDealsVisible)!="")
                {
                    $noOfDealsVisible="1";
                 }
                 else
                 {
                     $noOfDealsVisible="0";
                  }
                 $_2=$genericMethod->updateSingularElement($noOfDealsVisible,$update_for_No_of_deals_state , array($userID), "1", "0", array("checkValue"=>"checked","message"=>"$posMess","image"=>"update_sucessful.png"), array("checkValue"=>"","message"=>"$negMess","image"=>"delete_successfull.png"), array("checkValue"=>"","message"=>"","image"=>""), array("checkValue"=>"checked","message"=>"","image"=>""), array("checkValue"=>"","message"=>"","image"=>""));   
                 if(isset($_2) && is_array($_2) && count($_2)>0)
                {
                    $noOfDealsVisibleChecked=$_2["checkValue"];
                    $noOfDealsVisibleStatusMessage=$_2["message"];
                    if(isset($noOfDealsVisibleStatusMessage) && trim($noOfDealsVisibleStatusMessage)!="")
                    {
                        $transactionPreferenceErrorMessage.="$noOfDealsVisibleStatusMessage <>";
                    }
                    $noOfDealsVisibleStatusImage=$_2["image"];
                }
                else
                 {
                     $noOfDealsVisible="0";
                     $noOfDealsVisibleChecked="";
                 }
                 //confirm user authorization
                 $authorizationPercentage=$_POST["authorizationPercentage"];
                  if(!isset($authorizationPercentage) || doubleval($authorizationPercentage)<0)
                  {
                      $authorizationPercentage="0";                      
                  }
                 if(isset($authorizationPercentage) && doubleval($authorizationPercentage)>0)
                 {
                    //verify can save
                     $pdoStatement = $pdo->prepare($verify_user_role_id);
                    $isSuccess=$pdoStatement->execute(array($userID,$authorizationRoleID));
                     if($isSuccess)
                    {
                         if($pdoStatement->rowCount()>0)
                        {
                            $roleArray=$pdoStatement->fetchAll(PDO::FETCH_COLUMN, 0);
                            if(isset($roleArray) && count($roleArray)>0)
                            {
                                $tempRoleCount=$roleArray[0];
                                if(isset($tempRoleCount) && intval($tempRoleCount)>0)
                                {
                                    $authorizationPercentageVisible="visible";
                                    //save new authorizationpercentatge.
                                    $addNew=false;
                                    $update=false;
                                    $pdoStatement = $pdo->prepare($get_user_charge_by_role_id);
                                    $isSuccess=$pdoStatement->execute(array($userID,$authorizationRoleID));
                                    $currentVal=0;
                                    if($isSuccess)
                                    { 
                                        if($pdoStatement->rowCount()>0)
                                        { 
                                             $df=$pdoStatement->fetch(PDO::FETCH_NUM);
                                             if(isset($df) && count($df)>=1)
                                             {
                                                  $currentVal=$df[0];
                                                  if(doubleval($currentVal)!=  doubleval($authorizationPercentage))
                                                  {
                                                       $update=true;
                                                  }
                                             }
                                        }
                                        else
                                        {
                                            //not set before
                                            $addNew=true;
                                   
                                        }
                                    }
                                    if($update)
                                    {
                                        $pdoStatement = $pdo->prepare($update_user_charge);
                                        $isSuccess=$pdoStatement->execute(array(doubleval($authorizationPercentage),$userID,$authorizationRoleID));
                                        if($isSuccess)
                                        {
                                             if($pdoStatement->rowCount()>0)
                                             {
                                                 //updated 
                                                $authorizationChargeStatusImage="update_sucessful.png";
                                                $authorizationChargeStatusMessage="Update Successful";
                                                $transactionPreferenceErrorMessage.="Authorization charge was changed successfully <>";
                                                $authorizationChargeImageVisible="visible";
                                             }
                                        }
                                        else
                                        {
                                            $authorizationChargeStatusImage="update_unsucessful.png";
                                            $authorizationChargeStatusMessage="Update Unsuccessful";
                                            $authorizationPercentage=  strval($currentVal);
                                            $transactionPreferenceErrorMessage.="Authorization charge was not changed<>";
                                            $authorizationChargeImageVisible="visible";
                                        }
                                    }
                                    else if($addNew)
                                    {
                                        $pdoStatement = $pdo->prepare($add_user_charges);
                                        $isSuccess=$pdoStatement->execute(array(doubleval($authorizationPercentage),$authorizationRoleID,$userID));
                                        if($isSuccess)
                                        {
                                             if($pdoStatement->rowCount()>0)
                                             {
                                                 //updated 
                                                $authorizationChargeStatusImage="add_successful.png";
                                                $authorizationChargeStatusMessage="Update Successful";
                                                $transactionPreferenceErrorMessage.="Authorization charge was changed successfully <>";
                                                $authorizationChargeImageVisible="visible";
                                             }
                                        }
                                        else
                                        {
                                            $authorizationChargeStatusImage="add_unsuccessful.png";
                                            $authorizationChargeStatusMessage="Update Unsuccessful";
                                            $transactionPreferenceErrorMessage.="Authorization charge was not changed<>";
                                            $authorizationPercentage=  strval($currentVal);
                                            $authorizationChargeImageVisible="visible";
                                        }
                                    }
                                        
                                }
                            }
                        }
                    }
                 }
                 $arbitrationPercentage=$_POST["arbitrationPercentage"];
                  if(!isset($arbitrationPercentage) || doubleval($arbitrationPercentage)<0)
                  {
                      $arbitrationPercentage="0";                      
                  }
                  if(isset($arbitrationPercentage) && doubleval($arbitrationPercentage)>0)
                 {
                    //verify can save
                     $pdoStatement = $pdo->prepare($verify_user_role_id);
                    $isSuccess=$pdoStatement->execute(array($userID,$arbitrationRoleID));
                     if($isSuccess)
                    {
                         if($pdoStatement->rowCount()>0)
                        {
                            $roleArray=$pdoStatement->fetchAll(PDO::FETCH_COLUMN, 0);
                            if(isset($roleArray) && count($roleArray)>0)
                            {
                                $tempRoleCount=$roleArray[0];
                                if(isset($tempRoleCount) && intval($tempRoleCount)>0)
                                {
                                    $arbitrationPercentageVisible="visible";
                                    //save new arbitration percentatge.
                                    $addNew=false;
                                    $update=false;
                                    $pdoStatement = $pdo->prepare($get_user_charge_by_role_id);
                                    $isSuccess=$pdoStatement->execute(array($userID,$arbitrationRoleID));
                                    $currentVal=0;
                                    if($isSuccess)
                                    { 
                                        if($pdoStatement->rowCount()>0)
                                        { 
                                             $df=$pdoStatement->fetch(PDO::FETCH_NUM);
                                             if(isset($df) && count($df)>=1)
                                             {
                                                  $currentVal=$df[0];
                                                  if(doubleval($currentVal)!=  doubleval($arbitrationPercentage))
                                                  {
                                                       $update=true;
                                                  }
                                             }
                                        }
                                        else
                                        {
                                            //not set before
                                            $addNew=true;
                                   
                                        }
                                    }
                                    if($update)
                                    {
                                        $pdoStatement = $pdo->prepare($update_user_charge);
                                        $isSuccess=$pdoStatement->execute(array(doubleval($arbitrationPercentage),$userID,$arbitrationRoleID));
                                        if($isSuccess)
                                        {
                                             if($pdoStatement->rowCount()>0)
                                             {
                                                 //updated 
                                                $arbitrationChargeStatusImage="update_sucessful.png";
                                                $arbitrationChargeStatusMessage="Update Successful";
                                                $transactionPreferenceErrorMessage.="Arbitration charge was changed successfully <>";
                                                $arbitrationChargeImageVisible="visible";
                                             }
                                        }
                                        else
                                        {
                                            $arbitrationChargeStatusImage="update_unsucessful.png";
                                            $arbitrationChargeStatusMessage="Update Unsuccessful";
                                            $arbitrationPercentage=  strval($currentVal);
                                            $transactionPreferenceErrorMessage.="Arbitration charge was not changed<>";
                                            $arbitrationChargeImageVisible="visible";
                                        }
                                    }
                                    else if($addNew)
                                    {
                                        $pdoStatement = $pdo->prepare($add_user_charges);
                                        $isSuccess=$pdoStatement->execute(array(doubleval($arbitrationPercentage),$arbitrationRoleID,$userID));
                                        if($isSuccess)
                                        {
                                             if($pdoStatement->rowCount()>0)
                                             {
                                                 //updated 
                                                $arbitrationChargeStatusImage="add_successful.png";
                                                $arbitrationChargeStatusMessage="Update Successful";
                                                $transactionPreferenceErrorMessage.="Arbitration charge was changed successfully <>";
                                                $arbitrationChargeImageVisible="visible";
                                             }
                                        }
                                        else
                                        {
                                            $arbitrationChargeStatusImage="add_unsuccessful.png";
                                            $arbitrationChargeStatusMessage="Update Unsuccessful";
                                            $transactionPreferenceErrorMessage.="Arbitration charge was not changed<>";
                                            $arbitrationPercentage=  strval($currentVal);
                                            $arbitrationChargeImageVisible="visible";
                                        }
                                    }
                                        
                                }
                            }
                        }
                    }
                 }
            }
            else
            {

                try
                {
                    $pdo=$databaseConnection->getConnection();
                    $pdoStatement = $pdo->prepare($get_user_currencies_id);
                    $isSuccess=$pdoStatement->execute(array($userID));
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $userCurrenciesArray=$pdoStatement->fetchAll(PDO::FETCH_COLUMN, 0);
                        }
                    }
                    $pdoStatement = $pdo->prepare($get_user_purchase_category_group_id);
                    $isSuccess=$pdoStatement->execute(array($userID));
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $userProductCategoriesGroupArray=$pdoStatement->fetchAll(PDO::FETCH_COLUMN, 0);
                        }
                    }
                    //load user group purchase subgroups
                    $pdoStatement = $pdo->prepare($get_purchase_category_group_id);
                    $isSuccess=$pdoStatement->execute();
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $categoryGroup=$pdoStatement->fetchAll(PDO::FETCH_COLUMN, 0);
                            if(isset($categoryGroup) && is_array($categoryGroup) && count($categoryGroup)>0 )
                            {
                                
                                for($u=0;$u<count($categoryGroup);$u++)
                                {
                                    
                                    $category=$categoryGroup[$u];
                                    $pdoStatement = $pdo->prepare($get_user_product_categories_id_by_category_group);
                                    $isSuccess=$pdoStatement->execute(array($userID,$category));
                                    if($isSuccess)
                                    {
                                        if($pdoStatement->rowCount()>0)
                                       {
                                            $rr=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                                            $userProductCategoriesArray[$category]=$rr;
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $pdoStatement = $pdo->prepare($get_user_communication_id);
                    $isSuccess=$pdoStatement->execute(array($userID));
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $userCommunicationArray=$pdoStatement->fetchAll(PDO::FETCH_COLUMN, 0);
                        }
                    }
                    $pdoStatement = $pdo->prepare($get_user_base_currency);
                    $isSuccess=$pdoStatement->execute(array($userID));
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                            $userBaseCurrency=$row[0];
                        }
                    }
                    
                    $pdoStatement = $pdo->prepare($get_communication_web_id);
                    $isSuccess=$pdoStatement->execute(array($userID));
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $userWebArray=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                            
                        }
                    }
                    $pdoStatement = $pdo->prepare($get_communication_phone_id);
                    $isSuccess=$pdoStatement->execute(array($userID));
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $userMobileArray=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                            
                        }
                    }
                    $pdoStatement = $pdo->prepare($get_communication_email_id);
                    $isSuccess=$pdoStatement->execute(array($userID));
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $userEmailArray=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                        }
                    }
                    $pdoStatement = $pdo->prepare($user_transaction_details_setting);
                    $isSuccess=$pdoStatement->execute(array($userID));
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $transactionViewStatusArray=$pdoStatement->fetch(PDO::FETCH_NUM);
                            if(isset($transactionViewStatusArray) && count($transactionViewStatusArray)>=2)
                            {
                                $noOfDealsVisibleSub=$transactionViewStatusArray[0];
                                $dealValueVisibleSub=$transactionViewStatusArray[1];
                                if(isset($noOfDealsVisibleSub) && is_string($noOfDealsVisibleSub) && trim($noOfDealsVisibleSub)!="")
                                {
                                    if(trim($noOfDealsVisibleSub)=="1")
                                    {
                                        $noOfDealsVisible="1";
                                        $noOfDealsVisibleChecked="checked";
                                    }
                                    else
                                    {
                                        $noOfDealsVisible="0";
                                        $noOfDealsVisibleChecked="";
                                    }
                                        
                                }
                                else
                                {
                                    $noOfDealsVisible="0";
                                    $noOfDealsVisibleChecked="";
                                }
                                if(isset($dealValueVisibleSub) && is_string($dealValueVisibleSub) && trim($dealValueVisibleSub)!="")
                                {
                                    if(trim($dealValueVisibleSub)=="1")
                                    {
                                        $dealValueVisible="1";
                                        $dealValueVisibleChecked="checked";
                                    }
                                    else
                                    {
                                        $dealValueVisible="0";
                                        $dealValueVisibleChecked="";
                                    }
                                    
                                }
                                else
                                {
                                    $dealValueVisible="0";
                                    $dealValueVisibleChecked="";
                                }
                            }
                            else
                            {
                                $dealValueVisible="0";
                                $dealValueVisibleChecked="";
                                $noOfDealsVisible="0";
                                $noOfDealsVisibleChecked="";
                            }
                        }
                        else
                        {
                            $dealValueVisible="0";
                            $dealValueVisibleChecked="";
                            $noOfDealsVisible="0";
                            $noOfDealsVisibleChecked="";
                        }
                    }
                    else
                    {
                        $dealValueVisible="0";
                        $dealValueVisibleChecked="";
                        $noOfDealsVisible="0";
                        $noOfDealsVisibleChecked="";
                    }
                    $pdoStatement = $pdo->prepare($get_user_charges_info);
                    $isSuccess=$pdoStatement->execute(array($userID));
                    if($isSuccess)
                    {
                         if($pdoStatement->rowCount()>0)
                        {
                            while($transactionChargesArray=$pdoStatement->fetch(PDO::FETCH_NUM))
                            {
                                if(isset($transactionChargesArray) && count($transactionChargesArray)>=2)
                                {
                                    $charge=$transactionChargesArray[0];
                                    $role=$transactionChargesArray[1];
                                    if(trim($role)==$authorizationRoleID)
                                    {
                                        if(isset($charge))
                                        {
                                            $charge=doubleval($charge);
                                            if($charge>=0) 
                                            {
                                                $authorizationPercentage=  strval($charge);
                                            }
                                            else
                                            {
                                                $authorizationPercentage="0";
                                            }
                                        }
                                        else
                                        {
                                            $authorizationPercentage="0";
                                        }
                                    }
                                    else if(trim($role)==$arbitrationRoleID)
                                    {
                                        if(isset($charge))
                                        {
                                            $charge=doubleval($charge);
                                            if($charge>=0) 
                                            {
                                                $arbitrationPercentage=  strval($charge);
                                            }
                                            else
                                            {
                                                $arbitrationPercentage="0";
                                            }
                                        }
                                        else
                                        {
                                            $arbitrationPercentage="0";
                                        }
                                    }
                                }
                            }
                                
                        }
                    }
                    $pdoStatement = $pdo->prepare($verify_user_role_id);
                    $isSuccess=$pdoStatement->execute(array($userID,$authorizationRoleID));
                     if($isSuccess)
                    {
                         if($pdoStatement->rowCount()>0)
                        {
                            $roleArray=$pdoStatement->fetch(PDO::FETCH_NUM);
                            if(isset($roleArray) && count($roleArray)>=1)
                            {
                                $tempRoleCount=$roleArray[0];
                                if(isset($tempRoleCount) && intval($tempRoleCount)>0)
                                {
                                    $authorizationPercentageVisible="visible";
                                }
                            }
                        }
                    }
                    $pdoStatement = $pdo->prepare($verify_user_role_id);
                    $isSuccess=$pdoStatement->execute(array($userID,$arbitrationRoleID));
                     if($isSuccess)
                    {
                         if($pdoStatement->rowCount()>0)
                        {
                            $roleArray=$pdoStatement->fetch(PDO::FETCH_NUM);
                            if(isset($roleArray) && count($roleArray)>=1)
                            {
                                $tempRoleCount=$roleArray[0];
                                if(isset($tempRoleCount) && intval($tempRoleCount)>0)
                                {
                                    $arbitrationPercentageVisible="visible";
                                }
                            }
                        }
                    }
                }
                catch(PDOException $f)
                {
                    if(isset($pdo))
                    {
                        $pdo->rollBack();
                    }
                }
            }
            //load comments
            if(isset($dealValueVisibleStatusMessage) && $dealValueVisibleStatusMessage!=NULL && trim($dealValueVisibleStatusMessage)!="" )
            {
                $dealValueVisibleStatusImageVisible="visible";
            }
            else
            {
                $dealValueVisibleStatusImageVisible="invisible";
            }
            if(isset($noOfDealsVisibleStatusMessage) && $noOfDealsVisibleStatusMessage!=NULL && trim($noOfDealsVisibleStatusMessage)!="" )
            {
                $noOfDealsVisibleStatusImageVisible="visible";
            }
            else
            {
                $noOfDealsVisibleStatusImageVisible="invisible";
            }
            if(isset($currencyStatusMessage) && $currencyStatusMessage!=NULL && trim($currencyStatusMessage)!="" )
            {
                $currencyStatusVisible="visible";
            }
            else
            {
                $currencyStatusVisible="invisible";
            }
            if(isset($basecurrencyStatusMessage) && $basecurrencyStatusMessage!=NULL && trim($basecurrencyStatusMessage)!="" )
            {
                $basecurrencyStatusVisible="visible";
            }
            else
            {
                $basecurrencyStatusVisible="invisible";
            }
            // load base currency
            if(isset($userBaseCurrency) && $userBaseCurrency!=NULL && trim($userBaseCurrency)!="")
            {
                $temp->parseSQLAndVariable(2,"baseCurrencyOptions", "user_country_currencies=>$userID", 3,array("value","text"), "0:==:$userBaseCurrency:selected::isselected");
            }
            else
            {
                $temp->parseSQLAndVariable(2,"baseCurrencyOptions", "user_country_currencies=>$userID", 3,array("value","text"),"");
            }

            if(is_array($userCurrenciesArray) && count($userCurrenciesArray)>0)
            {
                $r=  implode("<>", $userCurrenciesArray);
                $temp->parseSQLAndVariable(2,"supportedCurrencies", "get_country_id_and_currency", 4,array("id","text"),"0:==:$r:checked::ischecked",5,"group",4,"OptionNamePrefix",$currencyCheckboxNamePrefix);
            }
            else
            {
                $temp->parseSQLAndVariable(2,"supportedCurrencies", "get_country_id_and_currency", 4,array("id","text"),"",5,"group",4,"OptionNamePrefix",$currencyCheckboxNamePrefix);
            }
            $checkBoxwithSubPrefixesReplacement=array("OptionNamePrefix","optionsubs","updateGroupImageName","updateGroupImageTitle","updateGroupImageVisible","deleteGroupImageName","deleteGroupImageTitle","deleteGroupImageVisible","deleteSubSuccessfulImage","deleteSubSuccessfulImageTitle","deleteSubSuccessfulImageVisible","updateSubSuccessfulImage","updateSubSuccessfulImageTitle","updateSubSuccessfulImageVisible","deleteSubFailedImage","deleteSubFailedImageTitle","deleteSubFailedImageVisible","updateSubFailedImage","updateSubFailedImageTitle","updateSubFailedImageVisible");
            $productCategoryPrefixesReplacement=array($purchasecategoryCheckboxNamePrefix,$categorySubCheckboxPrefix,$updateCategoryStatusImageNamePrefix,$updateCategoryStatusMessagePrefix,$updateCategoryStatusVisiblePrefix,$deleteCategoryStatusImageNamePrefix,$deleteCategoryStatusMessagePrefix,$deleteCategoryStatusVisiblePrefix,$deleteSubCategorySuccessfulStatusImageNamePrefix,$deleteSubCategorySuccessfulStatusMessagePrefix,$deleteSubCategorydSuccessfulStatusVisiblePrefix,$updateSubCategorySuccessfulStatusImageNamePrefix,$updateSubCategorySuccessfulStatusMessagePrefix,$updateSubCategorySuccessfulStatusVisiblePrefix,$deleteSubCategoryFailedStatusImageNamePrefix,$deleteSubCategoryFailedStatusMessagePrefix,$deleteSubCategoryFailedStatusVisiblePrefix,$updateSubCategoryFailedStatusImageNamePrefix,$updateSubCategoryFailedStatusMessagePrefix,$updateSubCategoryFailedStatusVisiblePrefix);
            if(is_array($userProductCategoriesGroupArray) && count($userProductCategoriesGroupArray)>0)
            {
                $r=  implode("<>", $userProductCategoriesGroupArray);
                $temp->parseSQLAndVariable(2,"productCategories", "get_purchase_category_group", 7,array("id","text"),"0:==:$r:checked::ischecked",5,"group",1,$checkBoxwithSubPrefixesReplacement,$productCategoryPrefixesReplacement);
            }
            else
            {
                $temp->parseSQLAndVariable(2,"productCategories", "get_purchase_category_group", 7,array("id","text"),"",5,"group",1,$checkBoxwithSubPrefixesReplacement,$productCategoryPrefixesReplacement);
            }
            //load sub options for the different purchase category
            try
            {
                $pdo=$databaseConnection->getConnection();
                $purchaseCategoryGroupID="";
                $purchaseCategoryGroupName="";
                if($pdo)
                {
                    $pdoStatement=$pdo->prepare($get_purchase_category_group);
                    $isSuccess=$pdoStatement->execute();
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
//                            $purchaseCategoryGroupID=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
//                            $purchaseCategoryGroupName=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,1);
//                            print implode('<>', $purchaseCategoryGroupName);
//                            if(isset($purchaseCategoryGroupID) && is_array($purchaseCategoryGroupID) && count($purchaseCategoryGroupID)>0)
//                            {
                                while($g=$pdoStatement->fetch(PDO::FETCH_NUM))
                                {
                                    $purchaseCategoryGroupID=$g[0];
                                    $purchaseCategoryGroupName=$g[1];
//                                    print $purchaseCategoryGroupID."  ".$purchaseCategoryGroupName."<br>";
                                    $d=$purchasecategoryCheckboxNamePrefix.$purchaseCategoryGroupID;
                                    if(is_array($userProductCategoriesGroupArray) && count($userProductCategoriesGroupArray)>0)
                                    { 
                                        $r=  implode("<>", $userProductCategoriesGroupArray);
                                        $p=$categorySubCheckboxPrefix.$purchaseCategoryGroupID;
                                        if(is_array($userProductCategoriesArray) && count($userProductCategoriesArray)>0 && array_key_exists($purchaseCategoryGroupID, $userProductCategoriesArray))
                                        {
                                            $s=  implode("<>", $userProductCategoriesArray[$purchaseCategoryGroupID]);
                                            $temp->parseSQLAndVariable(2,$p, "get_purchase_category_by_group_with_group=>$purchaseCategoryGroupID", 8,array("id","text"),"0:==:$s:checked::ischecked=>2:==:$r::disabled:disabled",5,"group",6,array("OptionNamePrefix"),array($d),0);
                                        }
                                        else
                                        {
                                            $temp->parseSQLAndVariable(2,$p, "get_purchase_category_by_group_with_group=>$purchaseCategoryGroupID", 8,array("id","text"),"2:==:$r::disabled:disabled",5,"group",6,array("OptionNamePrefix"),array($d),0);
                                        }
                                    }
                                    else
                                    {
                                        $p=$categorySubCheckboxPrefix.$purchaseCategoryGroupID;
                                        if(is_array($userProductCategoriesArray) && is_array($userProductCategoriesArray)&& count($userProductCategoriesArray)>0 && array_key_exists($purchaseCategoryGroupID, $userProductCategoriesArray))
                                        {
                                            $s=  implode("<>", $userProductCategoriesArray[$purchaseCategoryGroupID]);
                                            $temp->parseSQLAndVariable(2,$p, "get_purchase_category_by_group_with_group=>$purchaseCategoryGroupID", 8,array("id","text"),"0:==:$s:checked::ischecked=>2:==::disabled:disabled:disabled",5,"group",6,array("OptionNamePrefix"),array($d),0);
                                        }
                                        else
                                        {
                                            $temp->parseSQLAndVariable(2,$p, "get_purchase_category_by_group_with_group=>$purchaseCategoryGroupID", 8,array("id","text"),"2:==::disabled:disabled:disabled",5,"group",6,array("OptionNamePrefix"),array($d),0);
                                        }
                
                                    }
                                    //load purchase category event
                                    $temp->replaceStringWithDelimitedQueryResult(2, $purchasecategoryCheckboxNamePrefix.$purchaseCategoryGroupID, "get_purchase_category_by_group=>$purchaseCategoryGroupID", $d, 0, $delimiter);
                                    //load sub category group status 
                                    $categoryErrorMessage.=$genericMethod->statusUpdaterForSubs($temp, 2,$purchaseCategoryGroupID, $updateSuccessfullPrefixArray, "update_sucessful.png", $updateFailedPrefixArray, "update_unsucessful.png", $deleteSuccessfullPrefixArray, "delete_successfull.png", $deleteFailedPrefixArray, "delete_unsuccessfull.png", "$purchaseCategoryGroupName", "$purchaseCategoryGroupName", $purchaseCategorySubStatusMessageArray[$purchaseCategoryGroupID]);
                                    //load main group status
                                    $categoryErrorMessage.=$genericMethod->statusUpdaterForMain($temp, 2, $purchaseCategoryGroupID, $purchaseCategoryGroupID, $categoryGroupUpdateStatusArray,  "update_sucessful.png", "update_unsucessful.png", $categoryGroupDeleteStatusArray, "delete_successfull.png", "delete_unsuccessfull.png", "$purchaseCategoryGroupName", $purchaseCategoryStatusMessageArray);
                                }
//                            }
                        }
                    }
                }
            }
            catch(PDOException $nnnn)
            {
                
            }
            $cummunicationPrefixes=array($communicationCheckboxNamePrefix,$categorySubCheckboxPrefix,$updateCategoryStatusImageNamePrefix,$updateCategoryStatusMessagePrefix,$updateCategoryStatusVisiblePrefix,$deleteCategoryStatusImageNamePrefix,$deleteCategoryStatusMessagePrefix,$deleteCategoryStatusVisiblePrefix,$deleteSubCategorySuccessfulStatusImageNamePrefix,$deleteSubCategorySuccessfulStatusMessagePrefix,$deleteSubCategorydSuccessfulStatusVisiblePrefix,$updateSubCategorySuccessfulStatusImageNamePrefix,$updateSubCategorySuccessfulStatusMessagePrefix,$updateSubCategorySuccessfulStatusVisiblePrefix,$deleteSubCategoryFailedStatusImageNamePrefix,$deleteSubCategoryFailedStatusMessagePrefix,$deleteSubCategoryFailedStatusVisiblePrefix,$updateSubCategoryFailedStatusImageNamePrefix,$updateSubCategoryFailedStatusMessagePrefix,$updateSubCategoryFailedStatusVisiblePrefix);
            if(is_array($userCommunicationArray) && count($userCommunicationArray)>0)
            {
                $r=  implode("<>", $userCommunicationArray);
                $temp->parseSQLAndVariable(2,"communicationMethods", "get_communication_types", 7,array("id","text"),"0:==:$r:checked::ischecked",5,"group",1,$checkBoxwithSubPrefixesReplacement,$cummunicationPrefixes,0);
            }
            else
            {
                $temp->parseSQLAndVariable(2,"communicationMethods", "get_communication_types", 7,array("id","text"),"",5,"group",1,$checkBoxwithSubPrefixesReplacement,$cummunicationPrefixes,0);
            }
            //load sub options for the different commmunication methods
            $emailCommunicationID="";
            $phoneCommunicationID="";
            $webCommunicationID="";
            //GET cOMMUNICATION idS
            try
            {
                $pdo=$databaseConnection->getConnection();
                if($pdo)
                {

                    $pdoStatement=$pdo->prepare($get_email_communuication_method_id);
                    $isSuccess=$pdoStatement->execute();
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                            $emailCommunicationID=$row[0];
                        }
                    }
                    $pdoStatement=$pdo->prepare($get_web_communuication_method_id);
                    $isSuccess=$pdoStatement->execute();
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                            $webCommunicationID=$row[0];
                        }
                    }
                    $pdoStatement=$pdo->prepare($get_phone_communuication_method_id);
                    $isSuccess=$pdoStatement->execute();
                    if($isSuccess)
                    {
                        if($pdoStatement->rowCount()>0)
                        {
                            $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                            $phoneCommunicationID=$row[0];
                        }
                    }
                }
                
            }
             catch (PDOException $ffff)
             {

             }
             ////LOAD USER SELECTION CHECKBOXES
            if(is_array($userCommunicationArray) && count($userCommunicationArray)>0)
            {
                $r=  implode("<>", $userCommunicationArray);
                $p=$categorySubCheckboxPrefix.$emailCommunicationID;
                if(is_array($userEmailArray) && count($userEmailArray)>0)
                {
                    $s=  implode("<>", $userEmailArray);
                    $temp->parseSQLAndVariable(2,$p, "get_email_id_and_address_and_communication_method_id=>$userID", 8,array("id","text"),"0:==:$s:checked::ischecked=>2:==:$r::disabled:disabled",5,"group",4,array("OptionNamePrefix"),array($emailPrefix),0);
                }
                else
                {
                    $temp->parseSQLAndVariable(2,$p, "get_email_id_and_address_and_communication_method_id=>$userID", 8,array("id","text"),"2:==:$r::disabled:disabled",5,"group",4,array("OptionNamePrefix"),array($emailPrefix),0);
                }
                $p=$categorySubCheckboxPrefix.$phoneCommunicationID;
                if(is_array($userMobileArray) && count($userMobileArray)>0)
                {
                    $s=  implode("<>", $userMobileArray);
                    $temp->parseSQLAndVariable(2,$p, "get_phone_code_number_and_communication_method_id=>$userID", 8,array("id","text"),"0:==:$s:checked::ischecked=>2:==:$r::disabled:disabled",5,"group",4,array("OptionNamePrefix"),array($mobilePrefix),0);
                }
                else
                {
                    $temp->parseSQLAndVariable(2,$p, "get_phone_code_number_and_communication_method_id=>$userID", 8,array("id","text"),"2:==:$r::disabled:disabled",5,"group",4,array("OptionNamePrefix"),array($mobilePrefix),0);
                }
                $p=$categorySubCheckboxPrefix.$webCommunicationID;
                if(is_array($userWebArray) && count($userWebArray)>0)
                {
                    $s=  implode("<>", $userWebArray);
                    $temp->parseSQLAndVariable(2,$p, "get_web_address_and_communication_method_id=>$userID", 8,array("id","text"),"0:==:$s:checked::ischecked=>2:==:$r::disabled:disabled",5,"group",4,array("OptionNamePrefix"),array($webPrefix),0);
                }
                else
                {
                    $temp->parseSQLAndVariable(2,$p, "get_web_address_and_communication_method_id=>$userID", 8,array("id","text"),"2:==:$r::disabled:disabled",5,"group",4,array("OptionNamePrefix"),array($webPrefix),0);
                }
            }
            else
            {
                $p=$categorySubCheckboxPrefix.$emailCommunicationID;
                if(is_array($userEmailArray) && count($userEmailArray)>0)
                {
                    $s=  implode("<>", $userEmailArray);
                    $temp->parseSQLAndVariable(2,$p, "get_email_id_and_address_and_communication_method_id=>$userID", 8,array("id","text"),"0:==:$s:checked::ischecked=>2:==::disabled:disabled:disabled",5,"group",4,array("OptionNamePrefix"),array($emailPrefix),0);
                }
                else
                {
                    $temp->parseSQLAndVariable(2,$p, "get_email_id_and_address_and_communication_method_id=>$userID", 8,array("id","text"),"2:==::disabled:disabled:disabled",5,"group",4,array("OptionNamePrefix"),array($emailPrefix),0);
                }
                
                $p=$categorySubCheckboxPrefix.$phoneCommunicationID;
                if(is_array($userMobileArray) && count($userMobileArray)>0)
                {
                    $s=  implode("<>", $userMobileArray);
                    $temp->parseSQLAndVariable(2,$p, "get_phone_code_number_and_communication_method_id=>$userID", 8,array("id","text"),"0:==:$s:checked::ischecked=>2:==::disabled:disabled:disabled",5,"group",4,array("OptionNamePrefix"),array($mobilePrefix),0);
                }
                else
                {
                    $temp->parseSQLAndVariable(2,$p, "get_phone_code_number_and_communication_method_id=>$userID", 8,array("id","text"),"2:==::disabled:disabled:disabled",5,"group",4,array("OptionNamePrefix"),array($mobilePrefix),0);
                }
                $p=$categorySubCheckboxPrefix.$webCommunicationID;
                if(is_array($userWebArray) && count($userWebArray)>0)
                {
                    $s=  implode("<>", $userWebArray);
                    $temp->parseSQLAndVariable(2,$p, "get_web_address_and_communication_method_id=>$userID", 8,array("id","text"),"0:==:$s:checked::ischecked=>2:==::disabled:disabled:disabled",5,"group",4,array("OptionNamePrefix"),array($webPrefix),0);
                }
                else
                {
                    $temp->parseSQLAndVariable(2,$p, "get_web_address_and_communication_method_id=>$userID", 8,array("id","text"),"2:==::disabled:disabled:disabled",5,"group",4,array("OptionNamePrefix"),array($webPrefix),0);
                }
            }
            //load event variable
            $temp->replaceStringWithDelimitedQueryResult(2, $communicationCheckboxNamePrefix.$emailCommunicationID, "get_user_email_id=>$userID", $emailPrefix, 0, $delimiter);
            $temp->replaceStringWithDelimitedQueryResult(2, $communicationCheckboxNamePrefix.$webCommunicationID, "get_user_web_id=>$userID", $webPrefix, 0, $delimiter);
            $temp->replaceStringWithDelimitedQueryResult(2, $communicationCheckboxNamePrefix.$phoneCommunicationID, "get_user_mobile_id=>$userID", $mobilePrefix, 0, $delimiter);
            //load sub category group status
            $communicationErrorMessage.=$genericMethod->statusUpdaterForSubs($temp, 2, $phoneCommunicationID, $updateSuccessfullPrefixArray, "update_sucessful.png", $updateFailedPrefixArray, "update_unsucessful.png", $deleteSuccessfullPrefixArray, "delete_successfull.png", $deleteFailedPrefixArray, "delete_unsuccessfull.png", "phone number", "phone numbers", $phoneSubStatusMessageArray);
            $communicationErrorMessage.=$genericMethod->statusUpdaterForSubs($temp, 2, $emailCommunicationID, $updateSuccessfullPrefixArray, "update_sucessful.png", $updateFailedPrefixArray, "update_unsucessful.png", $deleteSuccessfullPrefixArray, "delete_successfull.png", $deleteFailedPrefixArray, "delete_unsuccessfull.png", "email", "emails", $emailSubStatusMessageArray);
            $communicationErrorMessage.=$genericMethod->statusUpdaterForSubs($temp, 2, $webCommunicationID, $updateSuccessfullPrefixArray, "update_sucessful.png", $updateFailedPrefixArray, "update_unsucessful.png", $deleteSuccessfullPrefixArray, "delete_successfull.png", $deleteFailedPrefixArray, "delete_unsuccessfull.png", "website", "websites", $webSubStatusMessageArray);
            //load category status
            $communicationErrorMessage.=$genericMethod->statusUpdaterForMain($temp, 2, $emailCommunicationID, $emailCommunicationID, $categoryGroupUpdateStatusArray, "email_update_successfull.png", "email_update_successfull.png", $categoryGroupDeleteStatusArray, "email_delete_successfull.png", "email_delete_successfull.png", "Email as communication method", $communicationStatusMessageArray);
            $communicationErrorMessage.=$genericMethod->statusUpdaterForMain($temp, 2, $phoneCommunicationID, $phoneCommunicationID, $categoryGroupUpdateStatusArray, "phone_update_successfull.png", "phone_update_successfull.png", $categoryGroupDeleteStatusArray, "delete_successfull.png", "delete_unsuccessfull.png", "Text message as communication method", $communicationStatusMessageArray);
            $communicationErrorMessage.=$genericMethod->statusUpdaterForMain($temp, 2, $webCommunicationID, $webCommunicationID, $categoryGroupUpdateStatusArray,  "web_update_successfull.png", "web_update_successfull.png", $categoryGroupDeleteStatusArray, "delete_successfull.png", "delete_unsuccessfull.png", "Website as communication method", $communicationStatusMessageArray);
             try
            {
                $pdo=$databaseConnection->getConnection();
                $pdoStatement=$pdo->prepare($get_communication_media_id);
                $isSuccess=$pdoStatement->execute();
                if($isSuccess && $pdoStatement->rowCount()>0)
                {
                    $id=$pdoStatement->fetchAll(PDO::FETCH_COLUMN,0);
                    if(isset($id) && count($id)>0)
                    {
                        for($t=0;$t<count($id);$t++)
                        {
                            $comID=$id[$t];
                            if(isset($deleteSubStatusMessageArray) && count($deleteSubStatusMessageArray)>0)
                            {
                                if(array_key_exists($comID, $deleteSubStatusMessageArray))
                                {
                                    $val=$deleteSubStatusMessageArray[$comID];
//                                    sif
                                    $temp->replaceString(2, $deleteSubCommunicationMethodStatusVisiblePrefix.$comID, "");
                                    $temp->replaceString(2, $deleteSubCommunicationMethodStatusImageNamePrefix.$comID, "");
                                    $temp->replaceString(2, $deleteSubCommunicationMethodStatusMessagePrefix.$comID, "");
                                }
                                else
                                {
                                    $temp->replaceString(2, $deleteSubCommunicationMethodStatusVisiblePrefix.$comID, "invisible");
                                    $temp->replaceString(2, $deleteSubCommunicationMethodStatusImageNamePrefix.$comID, "");
                                    $temp->replaceString(2, $deleteSubCommunicationMethodStatusMessagePrefix.$comID, "");
                                }
                            }
                            else
                            {
                                $temp->replaceString(2, $deleteSubCommunicationMethodStatusVisiblePrefix.$comID, "invisible");
                                $temp->replaceString(2, $deleteSubCommunicationMethodStatusImageNamePrefix.$comID, "");
                                $temp->replaceString(2, $deleteSubCommunicationMethodStatusMessagePrefix.$comID, "");
                            }
                        }
                    }
                }
            }
            catch(PDOException $ddd)
            {
                
            }
            
            //select tab to make visible
            if((isset($basecurrencyStatusMessage) && trim($basecurrencyStatusMessage)!="") || (isset($baseCurrencyErrorMessage) && trim($baseCurrencyErrorMessage)!=""))
            {
                $operationCurrencyPanelLocation-=$baseCurrencyPanelLocation;
                $communicationPanelLocation-=$baseCurrencyPanelLocation;
                $categoryLocation-=$baseCurrencyPanelLocation;
                $transactionPreferencePanelLocation-=$baseCurrencyPanelLocation;
                $baseCurrencyPanelLocation=0;
                $baseCurrencyTabSelected="highlight";
                $operationCurrencyTabSelected="highlight2";
                $communicationTabSelected="highlight2";
                $categoryTabSelected="highlight2";
                $transactionPreferenceTabSelected="highlight2";
            }
            else if((isset($currencyStatusMessage) && trim($currencyStatusMessage)!="") || (isset($operationCurrencyErrorMessage) && trim($operationCurrencyErrorMessage)!=""))
            {
                $baseCurrencyPanelLocation-=$operationCurrencyPanelLocation;
                $communicationPanelLocation-=$operationCurrencyPanelLocation;
                $categoryLocation-=$operationCurrencyPanelLocation;
                $transactionPreferencePanelLocation-=$operationCurrencyPanelLocation;
                $operationCurrencyPanelLocation=0;
                $baseCurrencyTabSelected="highlight2";
                $operationCurrencyTabSelected="highlight";
                $communicationTabSelected="highlight2";
                $categoryTabSelected="highlight2";
                $transactionPreferenceTabSelected="highlight2";
            }
            else if((isset($communicationErrorMessage) && trim($communicationErrorMessage)!=""))
            {
                $operationCurrencyPanelLocation-=$communicationPanelLocation;
                $baseCurrencyPanelLocation-=$communicationPanelLocation;
                $categoryLocation-=$communicationPanelLocation;
                $transactionPreferencePanelLocation-=$communicationPanelLocation;
                $communicationPanelLocation=0;
                $baseCurrencyTabSelected="highlight2";
                $operationCurrencyTabSelected="highlight2";
                $communicationTabSelected="highlight";
                $categoryTabSelected="highlight2";
                $transactionPreferenceTabSelected="highlight2";
            }
            else if((isset($categoryErrorMessage) && trim($categoryErrorMessage)!=""))
            {
                $operationCurrencyPanelLocation-=$categoryLocation;
                $baseCurrencyPanelLocation-=$categoryLocation;
                $communicationPanelLocation-=$categoryLocation;
                $transactionPreferencePanelLocation-=$categoryLocation;
                $categoryLocation=0;
                $baseCurrencyTabSelected="highlight2";
                $operationCurrencyTabSelected="highlight2";
                $communicationTabSelected="highlight2";
                $categoryTabSelected="highlight";
                $transactionPreferenceTabSelected="highlight2";
            }
            else if((isset($transactionPreferenceErrorMessage) && trim($transactionPreferenceErrorMessage)!="") || (isset($noOfDealsVisibleStatusMessage) && trim($noOfDealsVisibleStatusMessage)!="") || (isset($dealValueVisibleStatusMessage) && trim($dealValueVisibleStatusMessage)!=""))
            {
                $operationCurrencyPanelLocation-=$transactionPreferencePanelLocation;
                $baseCurrencyPanelLocation-=$transactionPreferencePanelLocation;
                $communicationPanelLocation-=$transactionPreferencePanelLocation;
                $categoryLocation-=$transactionPreferencePanelLocation;
                $transactionPreferencePanelLocation=0;
                $baseCurrencyTabSelected="highlight2";
                $operationCurrencyTabSelected="highlight2";
                $communicationTabSelected="highlight2";
                $categoryTabSelected="highlight2";
                $transactionPreferenceTabSelected="highlight";
            }
            //update errorMessage
            if(isset($baseCurrencyErrorMessage) && trim($baseCurrencyErrorMessage)!="")
            {
                $errorMessage.="Feedback on update of base currency<=>$baseCurrencyErrorMessage<...>";
            }
            if(isset($operationCurrencyErrorMessage) && trim($operationCurrencyErrorMessage)!="")
            {
                $errorMessage.="Feedback on update of operating currencies<=>$operationCurrencyErrorMessage<...>";
            }
            if(isset($communicationErrorMessage) && trim($communicationErrorMessage)!="")
            {
                $errorMessage.="Feedback on update of communication methods<=>$communicationErrorMessage<...>";
            }
            if(isset($categoryErrorMessage) && trim($categoryErrorMessage)!="")
            {
                $errorMessage.="Feedback on update of purchase interest<=>$categoryErrorMessage<...>";
            }
            if(isset($transactionPreferenceErrorMessage) && trim($transactionPreferenceErrorMessage)!="")
            {
                $errorMessage.="Feedback on update of other preferences<=>$transactionPreferenceErrorMessage<...>";
            }
        }
        elseif ($selectedTab==4) 
        {
            $seen=$_POST["seen"];
            $addStatusVisible="invisible";
            $addStatusMessage="";
            $addStatusSrc="";
            $defaultImagePath="../Images/default_user.png";
            $imagePrefix="user_image";
            $deleteImagePrefix="delete_image";
            $siteRolePrefix="site_role";
            $siteRoleOptionPrefix="site_role_options";
            $updateImageVisiblePrefix="image_site_role_update_image_visible";
            $updateImagePrefix="image_site_role_update_image_message";
            $updateMessagePrefix="image_site_role_update_image_title";
            
            $pictureStatusMessage="";
            $pictureStatusVisible="invisible";
            
            $visibleUpdateImageArray=array();
            $updateImageNameArray=array();
            $updateImageTitleArray=array();
            $siteRoleOptionDefaultArray=array();
            
            $temp->registerFiles(6, "../page_segments/imageupdate.html");
            $temp->registerFiles(3, "../page_segments/options.html");
            $temp->registerFiles(4, "../page_segments/userImageEditFrame.html");
            $temp->registerString(5, "<tr>{group}</tr>");
            
            $count=0;
            
            $newImagePanelLocation=750;
            $existingImagePanelLocation=0;
            $existingImageTabSelected="highlight";
            $newImageTabSelected="highlight2";
            $newImageStatusMessage="";
            $existingImageStatusMessage="";
            if($seen)
            {
                try
                {
                    $pdo=$databaseConnection->getConnection();
                    if(isset($pdo))
                    {
                        $pdoStatement=$pdo->prepare($get_user_images_id);
                        $isSuccess=$pdoStatement->execute(array($userID));
//                                print "$isSuccess jj"."<br>";
                        $currentImageCount=0;
                        if($isSuccess && $pdoStatement->rowCount()>0)
                        {
                            $row=$pdoStatement->fetchAll(PDO::FETCH_COLUMN);
                            $count=  count($row);
                            $currentImageCount=$count;
                            $pdoStatement=$pdo->prepare($get_site_roles_id);
                            $isSuccess=$pdoStatement->execute();
                            if($isSuccess && $pdoStatement->rowCount()>0)
                            {
                                $roleID=$pdoStatement->fetchAll(PDO::FETCH_COLUMN);
                                $hasSiteRoles=false;
                                if(is_array($roleID) && count($roleID)>0)
                                {
                                    $hasSiteRoles=TRUE;
                                }
                                $deleteSuccessfulCount=0;
                                $deleteUnsuccessfulCount=0;
                                $deleteUnsuccessfulNoImageCount=0;
                                $siteRoleUpdateSuccsfulCount=0;
                                $siteRoleUpdateUnsuccsfulCount=0;
                                for($r=0;$r<$count;$r++)
                                {
                                    $userImageID=$row[$r];
                                    $selectedSiteRole=$_POST[$siteRolePrefix.$userImageID];
                                    
                                    $toDeleteImage=$_POST[$deleteImagePrefix.$userImageID];
                                    if(isset($toDeleteImage) && $toDeleteImage!=NULL && trim($toDeleteImage)!="")
                                    {
                                        $pdoStatement=$pdo->prepare($get_user_images);
                                        $isSuccess=$pdoStatement->execute(array($userID,$userImageID));
                                        if($isSuccess && $pdoStatement->rowCount()>0)
                                        {
                                            $t=$pdoStatement->fetch(PDO::FETCH_NUM);
                                            if(isset($t) && count($t)>0)
                                            {
                                                $imagePath=$t[0];
                                                if(isset($imagePath) && trim($imagePath)!="")
                                                {
                                                    $pdo->beginTransaction();
                                                        $pdoStatement=$pdo->prepare($delete_user_image);
                                                        $isSuccess=$pdoStatement->execute(array($userID,$userImageID));
                                                        if($isSuccess)
                                                        {

                                                            if($pdoStatement->rowCount()>0)
                                                            {

                                                                if(!unlink("$imagePath"))
                                                                {

                                                                    if(exec("$imagePath"))
                                                                    {
                                                                        $pdo->commit();
                                                                        $deleteSuccessfulCount++;
                                                                        $currentImageCount--;
                                                                    }
                                                                    else
                                                                    {
                                                                        $pdo->rollBack();
                                                                        $visibleUpdateImageArray[]=$row[$r];
                                                                        $updateImageNameArray[$row[$r]]="not_ok.png";
                                                                        $deleteUnsuccessfulCount++;
                                                                        $updateImageTitleArray[$row[$r]]="Image was not deleted";
                                                                    }
                                                                }
                                                                 else 
                                                                 {
                                                                     $pdo->commit();
                                                                     $deleteSuccessfulCount++;
                                                                    $currentImageCount--;
                                                                 }


                                                            }
                                                            else
                                                            {

                                                            }

                                                        }
                                                        else
                                                        {
                                                            $visibleUpdateImageArray[]=$row[$r];
                                                            $updateImageNameArray[$row[$r]]="not_ok.png";
                                                            $updateImageTitleArray[$row[$r]]="Image was not deleted";
                                                            $deleteUnsuccessfulCount++;
                                                            $pdo->rollBack();
                                                        }
                                                }
                                                else
                                                {
                                                    $visibleUpdateImageArray[]=$row[$r];
                                                    $updateImageNameArray[$row[$r]]="not_ok.png";
                                                    $updateImageTitleArray[$row[$r]]="Image was not found. Delete unsuccessful";
                                                    $deleteUnsuccessfulNoImageCount++;
                                                }
                                            }
                                            else
                                            {
                                                $visibleUpdateImageArray[]=$row[$r];
                                                $updateImageNameArray[$row[$r]]="not_ok.png";
                                                $updateImageTitleArray[$row[$r]]="Image was not found. Delete unsuccessful";
                                                $deleteUnsuccessfulNoImageCount++;
                                            }
                                        }
                                        else
                                        {
                                            $visibleUpdateImageArray[]=$row[$r];
                                            $updateImageNameArray[$row[$r]]="not_ok.png";
                                            $updateImageTitleArray[$row[$r]]="Image was not found. Delete unsuccessful";
                                            $deleteUnsuccessfulNoImageCount++;
                                        }
                                                        
                                    }
                                    else
                                    {
                                        if($hasSiteRoles)
                                        {
                                            if(in_array($selectedSiteRole, $roleID))
                                            {
                                                if(isset($selectedSiteRole) && $selectedSiteRole!=NULL && trim($selectedSiteRole)!="")
                                                {
                                                    $pdo->beginTransaction();
                                                    $pdoStatement=$pdo->prepare($update_site_role_image);
                                                    $isSuccess=$pdoStatement->execute(array($selectedSiteRole,$userID,$userImageID,$selectedSiteRole));
                                                    if($isSuccess)
                                                    {
                                                        $pdo->commit();
                                                        if($pdoStatement->rowCount()>0)
                                                        {
                                                            $siteRoleOptionDefaultArray[$row[$r]]=$selectedSiteRole;
                                                            $visibleUpdateImageArray[]=$row[$r];
                                                            $updateImageNameArray[$row[$r]]="update_sucessful.png";
                                                            $updateImageTitleArray[$row[$r]]="Site role for this image was updated successfully";
                                                            $siteRoleUpdateSuccsfulCount++;
                                                            
                                                        }
                                                        else
                                                        {
                                                            $siteRoleOptionDefaultArray[$row[$r]]=$selectedSiteRole;
                                                            //no changes
                                                        }
                                                    }
                                                    else
                                                    {
                                                        $visibleUpdateImageArray[]=$row[$r];
                                                        $updateImageNameArray[$row[$r]]="update_unsucessful.png";
                                                        $updateImageTitleArray[$row[$r]]="Site role for this image was not updated";
                                                        $siteRoleUpdateUnsuccsfulCount++;
                                                        $pdo->rollBack();
                                                    }
                                                }

                                            }
                                        }
                                    }
                                }
                                if($deleteSuccessfulCount>0)
                                {
                                    if($deleteSuccessfulCount==1)
                                    {
                                        $existingImageStatusMessage.="$deleteSuccessfulCount image has been deleted. <>";
                                        $pictureStatusMessage.="$deleteSuccessfulCount image was deleted. ";
                                    }
                                    else
                                    {
                                        $existingImageStatusMessage.="$deleteSuccessfulCount Images has been deleted. <>";
                                        $pictureStatusMessage.="$deleteSuccessfulCount images were deleted. ";
                                    }
                                }
                                if($deleteUnsuccessfulCount>0)
                                {
                                    if($deleteUnsuccessfulCount==1)
                                    {
                                        $existingImageStatusMessage.="Apologies $deleteUnsuccessfulCount Image could not be deleted. <>";
                                        $pictureStatusMessage.="$deleteUnsuccessfulCount image was not deleted. ";
                                    }
                                    else
                                    {
                                        $existingImageStatusMessage.="Apologies $deleteUnsuccessfulCount Images could not be deleted. <>";
                                        $pictureStatusMessage.="$deleteUnsuccessfulCount images were not deleted. ";
                                    }
                                }
                                if($deleteUnsuccessfulNoImageCount>0)
                                {
                                    if($deleteUnsuccessfulNoImageCount==1)
                                    {
                                        $existingImageStatusMessage.="Apologies $deleteUnsuccessfulNoImageCount Image was not be found. $deleteUnsuccessfulNoImageCount image was not deleted<>";
                                        $pictureStatusMessage.="$deleteUnsuccessfulNoImageCount image was not found. Image was not deleted";
                                    }
                                    else
                                    {
                                        $existingImageStatusMessage.="Apologies $deleteUnsuccessfulNoImageCount Images was not be found. $deleteUnsuccessfulNoImageCount images were not deleted. <>";
                                        $pictureStatusMessage.="$deleteUnsuccessfulNoImageCount images were not found. Images were not deleted";
                                    }
                                }
                                if($siteRoleUpdateUnsuccsfulCount>0)
                                {
                                    if($siteRoleUpdateUnsuccsfulCount==1)
                                    {
                                        $existingImageStatusMessage.="site role for selected image was not updated.<>";
                                        $pictureStatusMessage.="Apologies site role for selected image was not updated.";
                                    }
                                    else
                                    {
                                        $existingImageStatusMessage.="site role for $siteRoleUpdateUnsuccsfulCount selected images were not updated. <>";
                                        $pictureStatusMessage.="Apologies site role for $siteRoleUpdateUnsuccsfulCount selected images were not updated.";
                                    }
                                }
                                if($siteRoleUpdateSuccsfulCount>0)
                                {
                                    if($siteRoleUpdateSuccsfulCount==1)
                                    {
                                        $existingImageStatusMessage.="site role for selected image was updated.<>";
                                        $pictureStatusMessage.="Site role for selected image was updated.";
                                    }
                                    else
                                    {
                                        $existingImageStatusMessage.="Site role for $siteRoleUpdateSuccsfulCount selected images were updated. <>";
                                        $pictureStatusMessage.="Site role for $siteRoleUpdateSuccsfulCount selected images were updated.";
                                    }
                                }
                                
                            }
                                
                        }
                        $fileName=$_FILES['newImage']['name'];
                        $fileType=$_FILES['newImage']['type'];
                        $fileSize=$_FILES['newImage']['size'];
                        $fileTempName=$_FILES['newImage']['tmp_name'];
                        $fileError=$_FILES['newImage']['error'];
                        if($fileError==0)
                        {
                            if(isset($fileName) && $fileName!=NULL && trim($fileName)!="")
                            {
                                
                                if($fileSize<16777216)
                                {
                                    if(++$currentImageCount<=10)
                                    {
                                        if($fileType=="image/jpeg" || $fileType=="image/jpg" || $fileType=="image/png")
                                        {
                                            $fileType= substr($fileType, 6);
                                            while(true)
                                            {
                                                $imageID=rand(1,10000000000000).date("uU");
                                                $pdoStatement = $pdo->prepare($verify_image_id);
                                                $pdoStatement->execute(array($imageID));
                                                if($pdoStatement->rowCount()==1)
                                                {
                                                    $row=$pdoStatement->fetch(PDO::FETCH_NUM);
                                                    if($row[0]==0)
                                                    {
                                                        $directoryOK=true;
                                                        if(!file_exists("../Images/user_images/$userID"))
                                                        {
                                                            if(!mkdir("../Images/user_images/$userID"))
                                                            {
                                                                $directoryOK=false;
                                                            }
                                                        }
                                                        if($directoryOK)
                                                        {
                                                            $newImageSiteRole=$_POST['newImageSiteRole'];
                                                            $moveSuccessfull=move_uploaded_file($fileTempName, "../Images/user_images/$userID/$imageID.$fileType");
                                                            if($moveSuccessfull)
                                                            {
                                                                $image="../Images/user_images/$userID/$imageID.$fileType";
                                                                $pdo->beginTransaction();
                                                                $pdoStatement = $pdo->prepare($add_user_image);
                                                                $success=$pdoStatement->execute(array($imageID,$userID,$image,$fileType,$newImageSiteRole));
                                                                if($success)
                                                                {
                                                                   $pdo->commit();
                                                                   if($pdoStatement->rowCount()>0)
                                                                   {
                                                                       $pictureStatusMessage="New Image was added successfully. ";
                                                                       $newImageStatusMessage.="The image was saved. <>";
                                                                       $siteRoleOptionDefaultArray[$imageID]=$newImageSiteRole;
                                                                   }
                                                                   else
                                                                   {

                                                                   }
                                                                }
                                                                else
                                                                {
                                                                    $pdo->rollBack();
                                                                    $copySuccessful=  copy("../Images/user_images/$userID/$imageID.$fileType", "../Images/temp/$imageID.$fileType");
                                                                    if($copySuccessful)
                                                                    {
                                                                        if(!unlink("../Images/user_images/$userID/$imageID.$fileType"))
                                                                        {
                                                                            system("del ../Images/user_images/$userID/$imageID.$fileType");
                                                                        }
                                                                        $defaultImagePath="../Images/temp/$imageID.$fileType";
                                                                    }
                                                                    elseif($moveSuccessfull)
                                                                    {
                                                                        $defaultImagePath="../Images/user_images/$userID/$imageID.$fileType";
                                                                    }
                                                                    
                                                                    $addStatusMessage="Could not add image.";
                                                                    $newImageStatusMessage.="The image was not saved. <>";
                                                                    $addStatusSrc="add_unsuccessful.png";

                                                                }
                                                            }
                                                            else
                                                            {
                                                                $copySuccessful=  copy("../Images/user_images/$userID/$imageID.$fileType", "../Images/temp/$imageID.$fileType");
                                                                if($copySuccessful)
                                                                {
                                                                    if(!unlink("../Images/user_images/$userID/$imageID.$fileType"))
                                                                    {
                                                                         system("del ../Images/user_images/$userID/$imageID.$fileType");
                                                                    }
                                                                    $defaultImagePath="../Images/temp/$imageID.$fileType";
                                                                }
                                                                elseif($moveSuccessfull)
                                                                {
                                                                    
                                                                    $defaultImagePath="../Images/user_images/$userID/$imageID.$fileType";
                                                                }
                                                                
                                                                $addStatusMessage="Could not add image.";
                                                                $newImageStatusMessage.="The image was not saved. <>";
                                                                $addStatusSrc="add_unsuccessful.png";
                                                            }

                                                        }
                                                        break;
                                                    }
                                                }
                                            }
                                        }
                                        else
                                        {
                                            
                                            $addStatusMessage="Invalid file format.";
                                            $newImageStatusMessage.="Invalid file format. The image was not saved. <>";
                                            $addStatusSrc="add_unsuccessful.png";
                                        }
                                    }
                                    else
                                    {
                                        $moveSuccessfull=move_uploaded_file($fileTempName, "../Images/temp/$fileName");
                                        if($moveSuccessfull)
                                        {
                                            $defaultImagePath="../Images/temp/$fileName";
                                        }
                                        
                                        $addStatusMessage="You cannot save more than 10 pictures. ";
                                        $newImageStatusMessage.="Image allocation exhausted. You cannot have more than 10 images. The image was not saved. <>";
                                        $addStatusSrc="add_unsuccessful.png";
                                    }
                                }
                                else
                                {
                                    $moveSuccessfull=move_uploaded_file($fileTempName, "../Images/temp/$fileName");
                                    if($moveSuccessfull)
                                    {
                                        $defaultImagePath="../Images/temp/$fileName";
                                    }
                                    
                                    $addStatusMessage="Image too large.";
                                    $newImageStatusMessage.="Image is too large. The image was not saved. <>";
                                    $addStatusSrc="add_unsuccessful.png";
                                }
                            }
                        }
                        else
                        {
                            
                        }
                    }
                }
                 catch (PDOException $ff)
                 {

                 }
            }
            else
            {
                try
                {
                    $pdo=$databaseConnection->getConnection();
                    if(isset($pdo))
                    {
                        $pdoStatement=$pdo->prepare($get_user_image_site_roles);
                        $isSuccess=$pdoStatement->execute(array($userID));
                        if($isSuccess && $pdoStatement->rowCount()>0)
                        {
                            while($row=$pdoStatement->fetch(PDO::FETCH_NUM))
                            {
                                $imageID=$row[1];
                                $imageRoleID=$row[0];
                                if(isset($imageID) && $imageID!=NULL && trim($imageID)!="" && isset($imageRoleID) && $imageRoleID!=NULL && trim($imageRoleID)!="")
                                {
                                    $siteRoleOptionDefaultArray[$imageID]=$imageRoleID;
                                }
                            }
                        }
                    }
                }
                catch (PDOException $HH)
                {
                    
                }
            }
            
            $f=array("imagePrefix","siteRolePrefix","siteRoleOptionPrefix","updateImageVisiblePrefix","updateImagePrefix","updateMessagePrefix","deleteImagePrefix");
            $e=array($imagePrefix,$siteRolePrefix,$siteRoleOptionPrefix,$updateImageVisiblePrefix,$updateImagePrefix,$updateMessagePrefix,$deleteImagePrefix);
            $temp->parseSQLAndVariable(6,"images", "get_user_images_id=>$userID", 4,array("image_id"),"",5,"group",3,$f,$e,0);
            $temp->parseSQLAndVariable(6,"new_image_site_roles_option", "get_user_site_roles_data=>$userID", 3,array("value","text"));
//            $temp->parseSQLAndVariable(6,"new_image_site_roles_option", "get_site_roles_data", 3,array("value","text"));
            try
            {
                $pdo=$databaseConnection->getConnection();
                if(isset($pdo))
                {
                    $pdoStatement=$pdo->prepare($get_user_images_id);
                    $isSuccess=$pdoStatement->execute(array($userID));
                    if($isSuccess && $pdoStatement->rowCount()>0)
                    {
                        $row=$pdoStatement->fetchAll(PDO::FETCH_COLUMN);
                        $count=  count($row);
                        for($r=1;$r<=$count;$r++)
                        {
                            $t=$r-1;
                            $updateImagevisible=$updateImageVisiblePrefix.$row[$t];
                            $$updateImagevisible="invisible";
                            if(is_array($visibleUpdateImageArray))
                            {
                                if(in_array($row[$t], $visibleUpdateImageArray))
                                {
                                    $$updateImagevisible="visible";
                                }
                            }
                            $updateImageName=$updateImagePrefix.$row[$t];
                            $$updateImageName="";
                            if(is_array($updateImageNameArray))
                            {
                                if(array_key_exists($row[$t], $updateImageNameArray))
                                {
                                    $$updateImageName=$updateImageNameArray[$row[$t]];
                                }
                            }
                            $updateMessage=$updateMessagePrefix.$row[$t];
                            $$updateMessage="";
                            if(is_array($updateImageTitleArray))
                            {
                                if(array_key_exists($row[$t], $updateImageTitleArray))
                                {
                                    $$updateMessage=$updateImageTitleArray[$row[$t]];
                                }
                            }
                            $siteRoleVariable=$siteRoleOptionPrefix.$row[$t];
                            $defaultRole="";
                            if(is_array($siteRoleOptionDefaultArray))
                            {
                                if(array_key_exists($row[$t], $siteRoleOptionDefaultArray))
                                {
                                    $defaultRole=$siteRoleOptionDefaultArray[$row[$t]];
//                                print "$defaultRole<br>";
                                    
                                }
                            }
                            if(isset($defaultRole) && trim($defaultRole)!="")
                            {
                                $temp->parseSQLAndVariable(6,"$siteRoleVariable", "get_user_site_roles_data=>$userID", 3,array("value","text"),"0:==:$defaultRole:selected::isselected");
//                                $temp->parseSQLAndVariable(6,"$siteRoleVariable", "get_site_roles_data", 3,array("value","text"),"0:==:$defaultRole:selected::isselected");
                            }
                            else
                            {
                                $temp->parseSQLAndVariable(6,"$siteRoleVariable", "get_user_site_roles_data=>$userID", 3,array("value","text"));
//                                $temp->parseSQLAndVariable(6,"$siteRoleVariable", "get_site_roles_data", 3,array("value","text"));
                            }
                            $temp->registerVariables(6, "$updateImagevisible,$updateImageName,$updateMessage");
                            $temp->parseFile(6);
                        }
                    }
                }
            }
            catch(PDOException $er)
            {
                
            }
            if(isset($pictureStatusMessage) && $pictureStatusMessage!=NULL && trim($pictureStatusMessage)!="")
            {
                $pictureStatusVisible="visible";
            }
            else
            {
                $pictureStatusVisible="invisible";
            }
            if(isset($addStatusMessage) && $addStatusMessage!=NULL && trim($addStatusMessage)!="")
            {
                $addStatusVisible="visible";
            }
            else
            {
                $addStatusVisible="invisible";
            }
            if((isset($pictureStatusVisible) && trim($pictureStatusVisible)=="visible") || (isset($existingImageStatusMessage) && trim($existingImageStatusMessage)!=""))
            {
                $newImagePanelLocation-=$existingImagePanelLocation;
                $existingImagePanelLocation=0;
                $existingImageTabSelected="highlight";
                $newImageTabSelected="highlight2";
            }
            elseif((isset($addStatusVisible) && trim($addStatusVisible)=="visible") || (isset($newImageStatusMessage) && trim($newImageStatusMessage)!=""))
            {
                $existingImagePanelLocation-=$newImagePanelLocation;
                $newImagePanelLocation=0;
                $existingImageTabSelected="highlight2";
                $newImageTabSelected="highlight";
            }
            if((isset($existingImageStatusMessage) && trim($existingImageStatusMessage)!=""))
            {
                $errorMessage.="Feedback on update of existing image(s)<=>$existingImageStatusMessage<...>";
            }
            if((isset($newImageStatusMessage) && trim($newImageStatusMessage)!=""))
            {
                $errorMessage.="Feedback on addition of image<=>$newImageStatusMessage<...>";
            }
            $temp->registerString(2, $temp->returnFile(6));
            $temp->registerVariables(2, "pictureStatusMessage,pictureStatusVisible,defaultImagePath,addStatusVisible,addStatusMessage,addStatusSrc");
            $temp->registerVariables(2, "newImagePanelLocation,existingImagePanelLocation,existingImageTabSelected,newImageTabSelected");
//            array to hold ids of images that have updates in message, visibility etc
        }
        if(isset($errorMessage) && trim($errorMessage)!="")
        {
            $errorMessage="Save Operation Update<>$errorMessage";
        }
        $temp->parseFile(2);
        $temp->registerVariables(1, "selectTab1,selectTab2,selectTab3,selectTab4,errorMessage");
        $temp->parseFile(1);
        $temp->insertFile(1, "selectedTabContent", 2);
        $temp->printFile(1,false);
    }
    else
    {
        $r=urlencode("../php/update.php&selectedTab=$selectedTabTemp");
        header("Location: ../php/login.php?destination=$r");
    }
}
else
{
    print "Cannot connect to database";
}
 
?>
