<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ManageGenericInput
{
    
    var $connection;
    
    function ManageGenericInput()
    {
       $this->connection =new DatabaseConnection();
    }
     function statusUpdaterForMain($template,$replacementFileID,$suffix,$mainID,$updatePrefixArray,$updateSuccessfulImageName,$updateFailureImageName,$deletePrefixArray,$deleteSuccessfulImageName,$deleteFailureImageName,$remark,$dataArray)
     {
         //$template,$replacementFileID,
        //$suffix -- added to the prefix element to make the replacement variable
        //$updateSuccessfullPrefixArray,$updateFailedPrefixArray,$deleteSuccessfullPrefixArray,$deleteFailedPrefixArray- array with 3 elements 0=visibilityPrefix 1=image name prefix 2=image title
        //$updateFailedImageName,$updateSuccessfulImageName,$deleteSuccessfulImageName,$deleteFailedImageName -- image name for the different states
        //$singlarRemark,$pluralRemark - for title messages
         $errorMessage="";
         if(isset($template) && is_int($replacementFileID) && isset($mainID) && $mainID!=NULL && trim($mainID)!="")
        {
            if(isset($updatePrefixArray) && is_array($updatePrefixArray))
            {
                if(isset($deletePrefixArray) && is_array($deletePrefixArray))
                {
                    if(count($deletePrefixArray)==3 && count($updatePrefixArray)==3)
                    {
                        if(isset($dataArray) && is_array($dataArray) && count($dataArray)==5)
                        {
                            $addResult=$dataArray[1];
                            $deleteResult=$dataArray[2];
                            $deleteAllResult=$dataArray[3];
                            $defaultResult=$dataArray[4];
                            if(isset($addResult) && count($addResult)>0 && array_key_exists($mainID, $addResult))
                            {
                                
                                if($addResult[$mainID]==1)
                                {
                                    $template->replaceString($replacementFileID, $updatePrefixArray[0].$suffix, "visible");
                                    $template->replaceString($replacementFileID, $updatePrefixArray[1].$suffix, "$updateSuccessfulImageName");
                                    $message="$remark was added";
                                    $errorMessage.="$message <>";
                                    $template->replaceString($replacementFileID, $updatePrefixArray[2].$suffix, $message);
                                }
                                elseif($addResult[$mainID]==0)
                                {
                                    $template->replaceString($replacementFileID, $updatePrefixArray[0].$suffix, "visible");
                                    $template->replaceString($replacementFileID, $updatePrefixArray[1].$suffix, "$updateFailureImageName");
                                    $message="Failed to add $remark";
                                    $errorMessage.="$message <>";
                                    $template->replaceString($replacementFileID, $updatePrefixArray[2].$suffix, $message);
                                }
                                else
                                {
                                    $template->replaceString($replacementFileID, $updatePrefixArray[0].$suffix, "invisible");
                                    $template->replaceString($replacementFileID, $updatePrefixArray[1].$suffix, "");
                                    $template->replaceString($replacementFileID, $updatePrefixArray[2].$suffix, "");
                                }
                            }
                            else
                            {
                                $template->replaceString($replacementFileID, $updatePrefixArray[0].$suffix, "invisible");
                                $template->replaceString($replacementFileID, $updatePrefixArray[1].$suffix, "");
                                $template->replaceString($replacementFileID, $updatePrefixArray[2].$suffix, "");
                            }
                            if(isset($deleteAllResult) && is_int($deleteAllResult) && $deleteAllResult>-1)
                            {
                                if($deleteAllResult>0)
                                {
                                    $template->replaceString($replacementFileID, $deletePrefixArray[0].$suffix, "visible");
                                    $template->replaceString($replacementFileID, $deletePrefixArray[1].$suffix, "$deleteSuccessfulImageName");
                                    $message="$remark was deleted";
                                    $errorMessage.="$message <>";
                                    $template->replaceString($replacementFileID, $deletePrefixArray[2].$suffix, $message);
                                }
                                 else if($deleteAllResult==0)
                                 {
                                    $template->replaceString($replacementFileID, $deletePrefixArray[2].$suffix, "$remark was not deleted.");
                                    $template->replaceString($replacementFileID, $deletePrefixArray[0].$suffix, "visible");
                                    $template->replaceString($replacementFileID, $deletePrefixArray[1].$suffix, "$deleteFailureImageName");
                                 }
                                elseif(isset($defaultResult) && is_int($defaultResult) && $defaultResult==$mainID)
                                {
                                    $message="You cannot delete the default $remark. ";
                                    $errorMessage.="$message <>";
                                    $template->replaceString($replacementFileID, $deletePrefixArray[2].$suffix, "$message");
                                    $template->replaceString($replacementFileID, $deletePrefixArray[0].$suffix, "visible");
                                    $template->replaceString($replacementFileID, $deletePrefixArray[1].$suffix, "$deleteFailureImageName");
                                }
                                 else 
                                 {
                                    $template->replaceString($replacementFileID, $deletePrefixArray[0].$suffix, "invisible");
                                    $template->replaceString($replacementFileID, $deletePrefixArray[1].$suffix, "");
                                    $template->replaceString($replacementFileID, $deletePrefixArray[2].$suffix, "");
                                 }

                            }
                            else 
                            {
                                if(isset($deleteResult) && count($deleteResult)>0 && array_key_exists($mainID, $deleteResult))
                                {
                                    
                                    if($deleteResult[$mainID]==1)
                                    {
                                        $template->replaceString($replacementFileID, $deletePrefixArray[0].$suffix, "visible");
                                        $template->replaceString($replacementFileID, $deletePrefixArray[1].$suffix, "$deleteSuccessfulImageName");
                                        $message="$remark was deleted";
                                        $errorMessage.="$message <>";
                                        $template->replaceString($replacementFileID, $deletePrefixArray[2].$suffix, $message);
                                    }
                                    elseif($deleteResult[$mainID]==0)
                                    {
                                        $template->replaceString($replacementFileID, $deletePrefixArray[0].$suffix, "visible");
                                        $template->replaceString($replacementFileID, $deletePrefixArray[1].$suffix, "$deleteFailureImageName");
                                        $message="Failed to delete $remark";
                                        $errorMessage.="$message <>";
                                        $template->replaceString($replacementFileID, $deletePrefixArray[2].$suffix, $message);
                                    }
                                    elseif(isset($defaultResult) && is_int($defaultResult) && $defaultResult==$mainID)
                                    {
                                        $template->replaceString($replacementFileID, $deletePrefixArray[2].$suffix, "You cannot delete the default email. $message");
                                        $template->replaceString($replacementFileID, $deletePrefixArray[0].$suffix, "visible");
                                        $template->replaceString($replacementFileID, $deletePrefixArray[1].$suffix, "$deleteFailureImageName");
                                    }
                                    else
                                    {
                                        $template->replaceString($replacementFileID, $deletePrefixArray[0].$suffix, "invisible");
                                        $template->replaceString($replacementFileID, $deletePrefixArray[1].$suffix, "");
                                        $template->replaceString($replacementFileID, $deletePrefixArray[2].$suffix, "");
                                    }
                                }
                                else
                                {
                                    $template->replaceString($replacementFileID, $deletePrefixArray[0].$suffix, "invisible");
                                    $template->replaceString($replacementFileID, $deletePrefixArray[1].$suffix, "");
                                    $template->replaceString($replacementFileID, $deletePrefixArray[2].$suffix, "");
                                }
                            }

                        }
                        else
                        {
                            $template->replaceString($replacementFileID, $deletePrefixArray[0].$suffix, "invisible");
                            $template->replaceString($replacementFileID, $deletePrefixArray[1].$suffix, "");
                            $template->replaceString($replacementFileID, $deletePrefixArray[2].$suffix, "");
                            $template->replaceString($replacementFileID, $updatePrefixArray[0].$suffix, "invisible");
                            $template->replaceString($replacementFileID, $updatePrefixArray[1].$suffix, "");
                            $template->replaceString($replacementFileID, $updatePrefixArray[2].$suffix, "");
                        }
                    }
                }
            }
        }
        return $errorMessage;
     }
    function statusUpdaterForSubs($template,$replacementFileID,$suffix,$updateSuccessfullPrefixArray,$updateSuccessfulImageName,$updateFailedPrefixArray,$updateFailedImageName,$deleteSuccessfullPrefixArray,$deleteSuccessfulImageName,$deleteFailedPrefixArray,$deleteFailedImageName,$singlarRemark,$pluralRemark,$dataArray)
    {
        //$template,$replacementFileID,
        //$suffix -- added to the prefix element to make the replacement variable
        //$updateSuccessfullPrefixArray,$updateFailedPrefixArray,$deleteSuccessfullPrefixArray,$deleteFailedPrefixArray- array with 3 elements 0=visibilityPrefix 1=image name prefix 2=image title
        //$updateFailedImageName,$updateSuccessfulImageName,$deleteSuccessfulImageName,$deleteFailedImageName -- image name for the different states
        //$singlarRemark,$pluralRemark - for title messages
        $errorMessage="";
        if(isset($template) && is_int($replacementFileID))
        {
            if(isset($updateFailedPrefixArray) && is_array($updateFailedPrefixArray) && isset($updateSuccessfullPrefixArray) && is_array($updateSuccessfullPrefixArray))
            {
                if(isset($deleteFailedPrefixArray) && is_array($deleteFailedPrefixArray) && isset($deleteSuccessfullPrefixArray) && is_array($deleteSuccessfullPrefixArray))
                {
                    if(count($deleteFailedPrefixArray)==3 &&  count($deleteSuccessfullPrefixArray)==3 && count($updateSuccessfullPrefixArray)==3 &&  count($updateFailedPrefixArray)==3)
                    {
                        if(isset($dataArray) && is_array($dataArray) && count($dataArray)==5)
                        {
                            $addResult=$dataArray[1];
                            $deleteResult=$dataArray[2];
                            $deleteAllResult=$dataArray[3];
                            $defaultResult=$dataArray[4];
                            if(isset($addResult) && count($addResult)>0)
                            {
                                $arraycomponentCount=array_count_values($addResult);
                                if(array_key_exists(1, $arraycomponentCount))
                                {
                                    $successCount=$arraycomponentCount[1];
                                    $template->replaceString($replacementFileID, $updateSuccessfullPrefixArray[0].$suffix, "visible");
                                    $template->replaceString($replacementFileID, $updateSuccessfullPrefixArray[1].$suffix, "$updateSuccessfulImageName");
                                    $message="";
                                    $s=$successCount;
                                    if($successCount>1)
                                    {
                                        $message="$s $pluralRemark were added";
                                        $errorMessage.="$message <>";
                                    }
                                    else
                                    {
                                        $message="$s $singlarRemark was added";
                                        $errorMessage.="$message <>";
                                    }
                                    $template->replaceString($replacementFileID, $updateSuccessfullPrefixArray[2].$suffix, $message);
                                }
                                else
                                {
                                    $template->replaceString($replacementFileID, $updateSuccessfullPrefixArray[0].$suffix, "invisible");
                                    $template->replaceString($replacementFileID, $updateSuccessfullPrefixArray[1].$suffix, "");
                                    $template->replaceString($replacementFileID, $updateSuccessfullPrefixArray[2].$suffix, "");
                                }
                                if(array_key_exists(0, $arraycomponentCount))
                                {
                                    $failureCount=$arraycomponentCount[0];
                                    $template->replaceString($replacementFileID, $updateFailedPrefixArray[0].$suffix, "visible");
                                    $template->replaceString($replacementFileID, $updateFailedPrefixArray[1].$suffix, "$updateFailedImageName");
                                    $message="";
                                    $s=$failureCount;
                                    if($successCount>1)
                                    {
                                        $message="Failed to add $s $pluralRemark";
                                        $errorMessage.="$message <>";
                                    }
                                    else
                                    {
                                        $message="Failed to add $s $singlarRemark";
                                        $errorMessage.="$message <>";
                                    }
                                    $template->replaceString($replacementFileID, $updateFailedPrefixArray[2].$suffix, $message);
                                }
                                else
                                {
                                    $template->replaceString($replacementFileID, $updateFailedPrefixArray[0].$suffix, "invisible");
                                    $template->replaceString($replacementFileID, $updateFailedPrefixArray[1].$suffix, "");
                                    $template->replaceString($replacementFileID, $updateFailedPrefixArray[2].$suffix, "");
                                }
                            }
                            else
                            {
                                $template->replaceString($replacementFileID, $updateFailedPrefixArray[0].$suffix, "invisible");
                                $template->replaceString($replacementFileID, $updateFailedPrefixArray[1].$suffix, "");
                                $template->replaceString($replacementFileID, $updateFailedPrefixArray[2].$suffix, "");
                                $template->replaceString($replacementFileID, $updateSuccessfullPrefixArray[0].$suffix, "invisible");
                                $template->replaceString($replacementFileID, $updateSuccessfullPrefixArray[1].$suffix, "");
                                $template->replaceString($replacementFileID, $updateSuccessfullPrefixArray[2].$suffix, "");
                            }
                            if(isset($deleteAllResult) && is_int($deleteAllResult) && $deleteAllResult>-1)
                            {
                                $not=false;
                                if($deleteAllResult>0)
                                {
                                    $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[0].$suffix, "visible");
                                    $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[1].$suffix, "$deleteSuccessfulImageName");
                                    $message="";
                                    
                                    if($deleteAllResult>1)
                                    {
                                         $message="$deleteAllResult $pluralRemark were deleted";
                                        $errorMessage.="$message <>";
                                    }
                                    else
                                    {
                                         $message="$deleteAllResult $singlarRemark was deleted";
                                        $errorMessage.="$message <>";
                                    }
                                    $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[2].$suffix, $message);
                                    $template->replaceString($replacementFileID, $deleteFailedPrefixArray[2].$suffix, "");
                                    $template->replaceString($replacementFileID, $deleteFailedPrefixArray[0].$suffix, "invisible");
                                    $template->replaceString($replacementFileID, $deleteFailedPrefixArray[1].$suffix, "");
                                }
                                 else if($deleteAllResult==0)
                                 {
                                    $not=true;
                                    $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[0].$suffix, "invisible");
                                    $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[1].$suffix, "");
                                    $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[2].$suffix, "");
                                    $template->replaceString($replacementFileID, $deleteFailedPrefixArray[2].$suffix, "$singlarRemark was not deleted.");
                                    $template->replaceString($replacementFileID, $deleteFailedPrefixArray[0].$suffix, "visible");
                                    $template->replaceString($replacementFileID, $deleteFailedPrefixArray[1].$suffix, "$deleteFailedImageName");
                                 }
                                if(isset($defaultResult) && is_int($defaultResult) && $defaultResult==1)
                                {
                                    
                                    if($not)
                                    {
                                        $message.="$singlarRemark was not deleted. ";
                                    }
                                    else
                                    {
                                        $message="You cannot delete the default $singlarRemark. ";
                                    }
                                    $errorMessage.="$message <>";
                                    $template->replaceString($replacementFileID, $deleteFailedPrefixArray[2].$suffix, "$message");
                                    $template->replaceString($replacementFileID, $deleteFailedPrefixArray[0].$suffix, "visible");
                                    $template->replaceString($replacementFileID, $deleteFailedPrefixArray[1].$suffix, "$deleteFailedImageName");
                                }

                            }
                            else 
                            {
                                if(isset($deleteResult) && count($deleteResult)>0)
                                {
                                    $arraycomponentCount=array_count_values($deleteResult);
                                    if(array_key_exists(1, $arraycomponentCount))
                                    {
                                        $successCount=$arraycomponentCount[1];
                                        $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[0].$suffix, "visible");
                                        $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[1].$suffix, "$deleteSuccessfulImageName");
                                        $message="";
                                        $s=$successCount;
                                        if($successCount>1)
                                        {
                                            $message="$s $pluralRemark were deleted";
                                            $errorMessage.="$message <>";
                                        }
                                        else
                                        {
                                            $message="$s $singlarRemark was deleted";
                                            $errorMessage.="$message <>";
                                        }
                                        $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[2].$suffix, $message);
                                    }
                                    else
                                    {
                                        $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[0].$suffix, "invisible");
                                        $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[1].$suffix, "");
                                        $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[2].$suffix, "");
                                    }
                                    $message="";
                                    $failedAready=false;
                                    if(array_key_exists(0, $arraycomponentCount))
                                    {
                                        $failedAready=true;
                                        $failureCount=$arraycomponentCount[0];
                                        $template->replaceString($replacementFileID, $deleteFailedPrefixArray[0].$suffix, "visible");
                                        $template->replaceString($replacementFileID, $deleteFailedPrefixArray[1].$suffix, "$deleteFailedImageName");
                                        $s=$failureCount;
                                        if($successCount>1)
                                        {
                                            $message="Failed to delete $s $singlarRemark";
                                            $errorMessage.="$message <>";
                                        }
                                        else
                                        {
                                            $message="Failed to delete $s $singlarRemark";
                                            $errorMessage.="$message <>";
                                        }
                                        $template->replaceString($replacementFileID, $deleteFailedPrefixArray[2].$suffix, $message);
                                    }
                                    else
                                    {
                                        $template->replaceString($replacementFileID, $deleteFailedPrefixArray[2].$suffix, "");
                                        $template->replaceString($replacementFileID, $deleteFailedPrefixArray[0].$suffix, "invisible");
                                        $template->replaceString($replacementFileID, $deleteFailedPrefixArray[1].$suffix, "");
                                    }
                                    if(isset($defaultResult) && is_int($defaultResult) && $defaultResult!=-1)
                                    {
                                        if($defaultResult==1)
                                        {
                                            $template->replaceString($replacementFileID, $deleteFailedPrefixArray[2].$suffix, "You cannot delete the default email. $message");
                                            if(!$failedAready)
                                            {
                                                $template->replaceString($replacementFileID, $deleteFailedPrefixArray[0].$suffix, "visible");
                                                $template->replaceString($replacementFileID, $deleteFailedPrefixArray[1].$suffix, "$deleteFailedImageName");
                                            }
                                        }
                                    }
                                }
                                else
                                {
                                    $template->replaceString($replacementFileID, $deleteFailedPrefixArray[2].$suffix, "");
                                    $template->replaceString($replacementFileID, $deleteFailedPrefixArray[0].$suffix, "invisible");
                                    $template->replaceString($replacementFileID, $deleteFailedPrefixArray[1].$suffix, "");
                                    $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[0].$suffix, "invisible");
                                    $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[1].$suffix, "");
                                    $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[2].$suffix, "");
                                }
                            }

                        }
                        else
                        {
                            $template->replaceString($replacementFileID, $updateFailedPrefixArray[0].$suffix, "invisible");
                            $template->replaceString($replacementFileID, $updateFailedPrefixArray[1].$suffix, "");
                            $template->replaceString($replacementFileID, $updateFailedPrefixArray[2].$suffix, "");
                            $template->replaceString($replacementFileID, $updateSuccessfullPrefixArray[0].$suffix, "invisible");
                            $template->replaceString($replacementFileID, $updateSuccessfullPrefixArray[1].$suffix, "");
                            $template->replaceString($replacementFileID, $updateSuccessfullPrefixArray[2].$suffix, "");
                            $template->replaceString($replacementFileID, $deleteFailedPrefixArray[2].$suffix, "");
                            $template->replaceString($replacementFileID, $deleteFailedPrefixArray[0].$suffix, "invisible");
                            $template->replaceString($replacementFileID, $deleteFailedPrefixArray[1].$suffix, "");
                            $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[0].$suffix, "invisible");
                            $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[1].$suffix, "");
                            $template->replaceString($replacementFileID, $deleteSuccessfullPrefixArray[2].$suffix, "");
                        }
                    }
                }
            }
        }
        return $errorMessage;
    }
    function manageCheckBoxInput($userID,$userSelectionArray,$defaultSelection,$existingSelectionQuery,$addSelectionQuery,$addSelectionQueryAdditionalInput,$deleteAllUserComponentQuery,$deleteUserSelectionByConponentID,$singularMessaagePrefix,$pluralMessaagePrefix,$deleteAllUserComponentQueryAdditionalInput,$deleteUserSelectionByConponentIDAdditionalInput) {
        $collectiveStatus=array();
        $message="";
        try
        {
            $pdo=$this->connection->getConnection();
            $pdoStatement = $pdo->prepare($existingSelectionQuery);
            $isSuccess=$pdoStatement->execute(array($userID));
            $addAll=true;
            if($isSuccess)
            {
                if($pdoStatement->rowCount()>0)
                {
                    $row=$pdoStatement->fetchAll(PDO::FETCH_COLUMN, 0);
                    if(isset($row) && is_array($row) && count($row)>0)
                    {
                        $addAll=false;
                        if(isset($userSelectionArray) && count($userSelectionArray)>0)
                        {
                            $pdo->beginTransaction();
                            for($r=0;$r<count($userSelectionArray);$r++)
                            {
                                $selection=$userSelectionArray[$r];
                                if(!in_array($selection, $row))
                                {
                                    // add new currncy
                                    $pdoStatement = $pdo->prepare($addSelectionQuery);
                                    $queryInput=array($userID,$selection);
                                    if(isset($addSelectionQueryAdditionalInput) && is_array($addSelectionQueryAdditionalInput))
                                    {
                                        $queryInput=  array_merge(array($userID,$selection), $addSelectionQueryAdditionalInput);
                                    }
                                    $isSuccess=$pdoStatement->execute($queryInput);
                                    if($isSuccess && $pdoStatement->rowCount()>0)
                                    {
                                        $collectiveStatus[]=1;
                                    }
                                    else
                                    {
                                        $collectiveStatus[]=0;
                                        if(in_array($selection, $userSelectionArray))
                                        {
                                            $userSelectionArray[$r]="";
                                            //remove element from array
                                        }
                                    }
                                }
                            }
                            if(isset($collectiveStatus) && count($collectiveStatus)>0)
                            {
                                if(count($collectiveStatus)==1)
                                {
                                    if($collectiveStatus[0]==1)
                                    {
                                        $message.=ucfirst($singularMessaagePrefix) ." was added successfully. <>";
                                    }
                                    elseif($collectiveStatus[0]==0)
                                    {
                                        $message.=ucfirst($singularMessaagePrefix) ." was not added.<>";
                                    }
                                }
                                else
                                {

                                    if(in_array(1, $collectiveStatus)&& in_array(0, $collectiveStatus))
                                    {
                                        $message.="Not all ". strtolower($pluralMessaagePrefix)." were added. <>";
                                    }
                                    else if(in_array(1, $collectiveStatus)&& !in_array(0, $collectiveStatus))
                                    {
                                        $message.="All ". strtolower($pluralMessaagePrefix)." were added. <>";
                                    }
                                    else if(!in_array(1, $collectiveStatus) && in_array(0, $collectiveStatus))
                                    {
                                        $message.="No ". strtolower($singularMessaagePrefix)." method was added. <>";
                                    }
                                }
                                $pdo->commit();
                            }
                            else
                            {
                                $pdo->rollBack();
                            }
                            $collectiveStatus=array();
                            $pdo->beginTransaction();
                            for($r=0;$r<count($row);$r++)
                            {
                                $selection=$row[$r];
                                if(!in_array($selection, $userSelectionArray))
                                {
                                    if(!(isset($defaultSelection) && $defaultSelection!=NULL && trim($defaultSelection)!="") || $defaultSelection!=$selection)
                                    {
                                        $pdoStatement = $pdo->prepare($deleteUserSelectionByConponentID);
                                        $queryInput=array($userID,$selection);
                                        if(isset($deleteUserSelectionByConponentIDAdditionalInput) && is_array($deleteUserSelectionByConponentIDAdditionalInput))
                                        {
                                            $queryInput=  array_merge(array($userID,$selection), $deleteUserSelectionByConponentIDAdditionalInput);
                                        }
                                        $isSuccess=$pdoStatement->execute($queryInput);
                                        if($isSuccess && $pdoStatement->rowCount()>0)
                                        {
                                            $collectiveStatus[]=1;
                                        }
                                        else
                                        {
                                            $collectiveStatus[]=0;
                                            $userSelectionArray[]=$selection;
                                        }
                                    }
                                     else 
                                     {
                                         $userSelectionArray[]=$defaultSelection;
                                        $message.="You cannot delete default". strtolower($singularMessaagePrefix).". <>" ;
                                     }
                                }
                            }
                            if(isset($collectiveStatus) && count($collectiveStatus)>0)
                            {
                                if(count($collectiveStatus)==1)
                                {
                                    if($collectiveStatus[0]==1)
                                    {
                                        $message.=ucfirst($singularMessaagePrefix)." was deleted successfully. <>";
                                    }
                                    elseif($collectiveStatus[0]==0)
                                    {
                                        $message.=ucfirst($singularMessaagePrefix)." was not deleted. <>";
                                    }
                                }
                                else
                                {

                                    if(in_array(1, $collectiveStatus)&& in_array(0, $collectiveStatus))
                                    {
                                        $message.="Some ".strtolower($pluralMessaagePrefix) ." were not deleted. <>";
                                    }
                                    else if(in_array(1, $collectiveStatus)&& !in_array(0, $collectiveStatus))
                                    {
                                        $message.=ucfirst($pluralMessaagePrefix)." were deleted succesfully. <>";
                                    }
                                    else if(!in_array(1, $collectiveStatus) && in_array(0, $collectiveStatus))
                                    {
                                        $message.=ucfirst($singularMessaagePrefix)." was not deleted succesfully. <>";
                                    }
                                }
                                $pdo->commit();
                            }
                            else
                            {
                                $pdo->rollBack();
                            }
                        }
                        else
                        {
                            //delete all user categories add base currency as default
                            $pdoStatement = $pdo->prepare($deleteAllUserComponentQuery);
                            $pdo->beginTransaction();
                            $queryInput=array($userID);
                            if(isset($deleteAllUserComponentQueryAdditionalInput) && is_array($deleteAllUserComponentQueryAdditionalInput))
                            {
                                $queryInput=  array_merge(array($userID), $deleteAllUserComponentQueryAdditionalInput);
                            }
                            $isSuccess=$pdoStatement->execute($queryInput);
                            if($isSuccess)
                            {
                                if($pdoStatement->rowCount()==1)
                                {
                                    $message.=ucfirst($singularMessaagePrefix)." was deleted successfully. <>";
                                    $pdo->commit();
                                }
                                elseif($pdoStatement->rowCount()>=2)
                                {
                                    $message.=ucfirst($pluralMessaagePrefix)." were deleted successfully. <>";
                                    $pdo->commit();
                                }
                                else
                                {
                                    $message.=ucfirst($pluralMessaagePrefix)." were not deleted. <>";
                                    $pdo->rollBack();
                                }
                            }
                            else
                            {
                                $message.=ucfirst($pluralMessaagePrefix)." were not deleted <>";
                            }
                            if(isset($defaultSelection) && $defaultSelection!=NULL && trim($defaultSelection)!="")
                            {
                                $userSelectionArray=array($defaultSelection);
                                $message.="Cannot delete default ".  strtolower($singularMessaagePrefix).". <>";
                            }
                        }

                    }
                }
            }
            if($addAll)
            {
                if(isset($userSelectionArray) && count($userSelectionArray)>0)
                {
                    $pdo->beginTransaction();
                    $collectiveStatus=array();

                    for($r=0;$r<count($userSelectionArray);$r++)
                    {
                        $selection=$userSelectionArray[$r];
                        if(isset($selection) && $selection!=NULL && trim($selection)!="")
                        {
                            $pdoStatement = $pdo->prepare($addSelectionQuery);
                            $queryInput=array($userID,$selection);
                            if(isset($addSelectionQueryAdditionalInput) && is_array($addSelectionQueryAdditionalInput))
                            {
                                $queryInput=  array_merge(array($userID,$selection), $addSelectionQueryAdditionalInput);
                            }
                            $isSuccess=$pdoStatement->execute($queryInput);
                            if($isSuccess && $pdoStatement->rowCount()>0)
                            {
                                $collectiveStatus[]=1;
                            }
                            else
                            {
                                $collectiveStatus[]=0;  
                                $userSelectionArray[$r]=""; //remove element from array
                            }
                        }
                    }

                }
                if(isset($collectiveStatus) && count($collectiveStatus)>0)
                {
                    if(count($collectiveStatus)==1)
                    {
                        if($collectiveStatus[0]==1)
                        {
                            $message.=ucfirst($singularMessaagePrefix)." was added successfully. <>";
                        }
                        elseif($collectiveStatus[0]==0)
                        {
                            $message.=ucfirst($singularMessaagePrefix)." was not added. <>";
                        }
                    }
                    else
                    {

                        if(in_array(1, $collectiveStatus)&& in_array(0, $collectiveStatus))
                        {
                            $message.="Not all ". strtolower($pluralMessaagePrefix)." were added. <>";
                        }
                        else if(in_array(1, $collectiveStatus)&& !in_array(0, $collectiveStatus))
                        {
                            $message.="All ". strtolower($pluralMessaagePrefix)." were added. <>";
                        }
                        else if(!in_array(1, $collectiveStatus) && in_array(0, $collectiveStatus))
                        {
                            $message.="No ". strtolower($singularMessaagePrefix)." method was added. <>";
                        }
                    }
                    $pdo->commit();
                }
                else
                {
                    $pdo->rollBack();
                }
            }

        }
        catch(PDOException $e)
        {

        }
        return array($userSelectionArray,$message);
    }
//    manageCheckBoxInput2($userID, $innerUserPurchaseCategorySelected,"", $get_user_product_categories_id_by_category_group, $add_user_product_category,array($dd[$t]), $delete_user_product_category_by_user_id, $delete_user_product_category_by_user_id_and_currency_id,array($dd[$t]),"",array($dd[$t]));
    function manageCheckBoxInput2($userID,$userSelectionArray,$defaultSelection,$existingSelectionQuery,$addSelectionQuery,$addSelectionQueryAdditionalInput,$deleteAllUserComponentQuery,$deleteUserSelectionByConponentID,$deleteAllUserComponentQueryAdditionalInput,$deleteUserSelectionByConponentIDAdditionalInput,$existingSelectionQueryAdditionalInput) {
        $addResult=array();
        $deleteResult=array();
        $deleteAllResult=-1;
        $defaultResult=-1;
        try
        {
            $pdo=$this->connection->getConnection();
            $pdoStatement = $pdo->prepare($existingSelectionQuery);
            $queryData=array($userID);
            if(isset($existingSelectionQueryAdditionalInput) && is_array($existingSelectionQueryAdditionalInput) && count($existingSelectionQueryAdditionalInput)>0)
            {
                $queryData=  array_merge($queryData, $existingSelectionQueryAdditionalInput);
            }
            $isSuccess=$pdoStatement->execute($queryData);
            $addAll=true;
            if($isSuccess)
            {
                if($pdoStatement->rowCount()>0)
                {
                    $row=$pdoStatement->fetchAll(PDO::FETCH_COLUMN, 0);
                    if(isset($row) && is_array($row) && count($row)>0)
                    {
                        $addAll=false;
                        if(isset($userSelectionArray) && count($userSelectionArray)>0)
                        {
                            $pdo->beginTransaction();
                            for($r=0;$r<count($userSelectionArray);$r++)
                            {
                                $selection=$userSelectionArray[$r];
                                if(!in_array($selection, $row))
                                {
                                    // add new currncy
                                    $pdoStatement = $pdo->prepare($addSelectionQuery);
                                    $queryInput=array($userID,$selection);
                                    if(isset($addSelectionQueryAdditionalInput) && is_array($addSelectionQueryAdditionalInput))
                                    {
                                        $queryInput=  array_merge(array($userID,$selection), $addSelectionQueryAdditionalInput);
                                    }
                                    $isSuccess=$pdoStatement->execute($queryInput);
                                    if($isSuccess && $pdoStatement->rowCount()>0)
                                    {
                                        $addResult[$selection]=1;
                                    }
                                    else
                                    {
                                        $addResult[$selection]=0;
                                        if(in_array($selection, $userSelectionArray))
                                        {
                                            $userSelectionArray[$r]="";
                                            //remove element from array
                                        }
                                    }
                                }
                            }
                            if(isset($addResult) && count($addResult)>0)
                            {
                                $pdo->commit();
                            }
                            else
                            {
                                $pdo->rollBack();
                            }
                            $pdo->beginTransaction();
                            for($r=0;$r<count($row);$r++)
                            {
                                $selection=$row[$r];
                                if(!in_array($selection, $userSelectionArray))
                                {
                                    if(!(isset($defaultSelection) && $defaultSelection!=NULL && trim($defaultSelection)!="") || $defaultSelection!=$selection)
                                    {
                                        $pdoStatement = $pdo->prepare($deleteUserSelectionByConponentID);
                                        $queryInput=array($userID,$selection);
                                        if(isset($deleteUserSelectionByConponentIDAdditionalInput) && is_array($deleteUserSelectionByConponentIDAdditionalInput))
                                        {
                                            $queryInput=  array_merge(array($userID,$selection), $deleteUserSelectionByConponentIDAdditionalInput);
                                        }
                                        $isSuccess=$pdoStatement->execute($queryInput);
                                        if($isSuccess && $pdoStatement->rowCount()>0)
                                        {
                                            $deleteResult[$selection]=1;
                                        }
                                        else
                                        {
                                            $deleteResult[$selection]=1;
                                            $userSelectionArray[]=$selection;
                                        }
                                    }
                                     else 
                                     {
                                         $userSelectionArray[]=$defaultSelection;
                                         $defaultResult=1;
                                     }
                                }
                            }
                            if(isset($deleteResult) && count($deleteResult)>0)
                            {
                                $pdo->commit();
                            }
                            else
                            {
                                $pdo->rollBack();
                            }
                        }
                        else
                        {
                            //delete all user categories add default
                            $pdoStatement = $pdo->prepare($deleteAllUserComponentQuery);
                            $pdo->beginTransaction();
                            $queryInput=array($userID);
                            if(isset($deleteAllUserComponentQueryAdditionalInput) && is_array($deleteAllUserComponentQueryAdditionalInput))
                            {
                                $queryInput=  array_merge(array($userID), $deleteAllUserComponentQueryAdditionalInput);
                            }
                            $isSuccess=$pdoStatement->execute($queryInput);
                            if($isSuccess)
                            {
                                $pdo->commit();
                                if($pdoStatement->rowCount()>=1)
                                {
                                   $deleteAllResult=$pdoStatement->rowCount();
                                }
                                else
                                {
                                     $deleteAllResult=-1;
                                }
                            }
                            else
                            {
                                $pdo->rollBack();
                                $deleteAllResult=0;
                            }
                            if(isset($defaultSelection) && $defaultSelection!=NULL && trim($defaultSelection)!="")
                            {
                                $userSelectionArray=array($defaultSelection);
                                $defaultResult=1;
                            }
                        }

                    }
                }
            }
            if($addAll)
            {
                //save all the user selected
                if(isset($userSelectionArray) && count($userSelectionArray)>0)
                {
                    
                    for($r=0;$r<count($userSelectionArray);$r++)
                    {
                        $selection=$userSelectionArray[$r];
                        if(isset($selection) && $selection!=NULL && trim($selection)!="")
                        {
                            $pdoStatement = $pdo->prepare($addSelectionQuery);
                            $queryInput=array($userID,$selection);
                            if(isset($addSelectionQueryAdditionalInput) && is_array($addSelectionQueryAdditionalInput))
                            {
                                $queryInput=  array_merge(array($userID,$selection), $addSelectionQueryAdditionalInput);
                            }
                            $isSuccess=$pdoStatement->execute($queryInput);
                            if($isSuccess && $pdoStatement->rowCount()>0)
                            {
                                $addResult[$selection]=1;
                            }
                            else
                            {
                                $addResult[$selection]=0;  
                                $userSelectionArray[$r]=""; //remove element from array
                            }
                        }
                    }
                }
            }

        }
        catch(PDOException $e)
        {

        }
        return array($userSelectionArray,$addResult,$deleteResult,$deleteAllResult,$defaultResult);
    }

    function updateSingularElement($updateValue,$updateQuery,$additionalQueryInput,$positiveValue,$negetiveValue,$savePositveResponseArray,$saveNegativeResponseArray,$conditionFailureResponseArray,$positiveNoChangeResponseArray,$negativeNoChangeResponseArray)
    {
        $returnArray=array();
        if(isset($updateValue) && trim($updateValue)!=null)
        {
            try
            {
                $pdo=$this->connection->getConnection();
                $pdoStatement = $pdo->prepare($updateQuery);
                $totalQueryInput=array($updateValue);
                if(isset($additionalQueryInput) && is_array($additionalQueryInput) && count($additionalQueryInput)>0)
                {
                    $totalQueryInput=array_merge(array($updateValue), $additionalQueryInput);
                }
//                print "".  implode("<>", $totalQueryInput)."<br>";
                $isSuccess=$pdoStatement->execute($totalQueryInput);
                if($isSuccess)
                {
                    if($pdoStatement->rowCount()>0)
                    {

                        if($updateValue==$positiveValue)
                        {
                            if(isset($savePositveResponseArray)  && is_array($savePositveResponseArray) && count($savePositveResponseArray)>0)
                            {
                                $returnArray=$savePositveResponseArray;
                            }
                        }
                        else if($updateValue==$negetiveValue)
                        {
                            if(isset($saveNegativeResponseArray)  && is_array($saveNegativeResponseArray) && count($saveNegativeResponseArray)>0)
                            {
                                $returnArray=$saveNegativeResponseArray;
                            }
                        }
                    }
                    else
                    {
                           if($updateValue==$positiveValue)
                            {
                                $returnArray=$positiveNoChangeResponseArray;
                            }
                            else if($updateValue==$negetiveValue)
                            {
                                $returnArray=$negativeNoChangeResponseArray;
                            }
                    }
                }
                else
                {
                }
            }
            catch(PDOException $r)
            {

            }
        }
        else
        {
            if(isset($conditionFailureResponseArray)  && is_array($conditionFailureResponseArray) && count($conditionFailureResponseArray)>0)
            {
                $returnArray=$conditionFailureResponseArray;
            }
        }
        return $returnArray;
    }
    function splitInterval2($inputInterval)
    {
        $Day=0;
        $Hour=0;
        $Minute=0;
        $Seconds=0;
         if(is_int($inputInterval) && $inputInterval>0)
        {

            $totalSeconds=intval(trim($inputInterval));
            $Day=  intval($totalSeconds/(24*60*60));
            $Hour=intval(($totalSeconds%(24*60*60))/(60*60));
            $Minute=intval((($totalSeconds%(24*60*60))%(60*60))/60);
        }
        return array($Day,$Hour,$Minute,$Seconds);
    }
    function splitInterval($inputInterval,$intervalSet)
    {
        $DayVisible="invisible";
        $Day=0;
        $HourVisible="invisible";
        $Hour=0;
        $MinuteVisible="invisible";
        $Minute=0;
        $SecondsVisible="invisible";
        $Seconds=0;
        $PluralDayVisible='invisible';
        $PluralHourVisible='invisible';
        $PluralMinuteVisible='invisible';
        $PluralSecondsVisible='invisible';
        $SingularDayVisible='visible';
        $SingularHourVisible='visible';
        $SingularMinuteVisible='visible';
        $SingularSecondsVisible='visible';
        $Visible="invisible";
        $NotVisible="visible";
        if($intervalSet)
        {
            if(is_int($inputInterval) && $inputInterval>0)
            {
                $Visible="visible";
                $NotVisible="invisible";
                $totalSeconds=intval(trim($inputInterval));
                $Day=  intval($totalSeconds/(24*60*60));
                $Hour=intval(($totalSeconds%(24*60*60))/(60*60));
                $Minute=intval((($totalSeconds%(24*60*60))%(60*60))/60);
                if($Day>0)
                {
                    $DayVisible="visible";
                    if($Day>1)
                    {
                        $PluralDayVisible="visible";
                        $SingularDayVisible="invisible";
                    }
                }
                if($Hour>0)
                {
                    $HourVisible="visible";
                    if($Hour>1)
                    {
                        $PluralHourVisible="visible";
                        $SingularHourVisible="invisible";
                    }
                }
                if($Minute>0)
                {
                    $MinuteVisible="visible";
                    if($Minute>1)
                    {
                        $PluralMinuteVisible="visible";
                        $SingularMinuteVisible="invisible";
                    }
                }
            }
        }
        return array($DayVisible,$Day,$SingularDayVisible,$PluralDayVisible,$HourVisible,$Hour,$SingularHourVisible,$PluralHourVisible,$MinuteVisible,$Minute,$SingularMinuteVisible,$PluralMinuteVisible,$NotVisible,$Visible);
    }
    function verifySecurityAnswer($securityAnswer,$userID,$query)
    {
        $errorPage5="";
         if(isset($securityAnswer) && trim($securityAnswer)!="")
        {
            try
            {
                $pdo=$this->connection->getConnection();
                $pdoStatement=$pdo->prepare($query);
                $isSuccess=$pdoStatement->execute(array($userID));
                if($isSuccess && $pdoStatement->rowCount()==1)
                {
                    $g=$pdoStatement->fetch(PDO::FETCH_NUM);
                    if(isset($g) && is_array($g) && count($g)==1)
                    {
                        if(trim($g[0])==trim($securityAnswer))
                        {
                            return true;
                        }
                        else
                        {
                            $errorPage5.="Answer to your security question provided does not match stored value.<>";
                        }
                    }
                    else
                    {
                        $errorPage5.="Cannot confirm answer to your security question.<>";
                    }
                }
                else
                {
                     $errorPage5.="Cannot confirm answer to your security question.<>";
                }

            }
             catch (PDOException $fffjj)
             {
                 $errorPage5.="Cannot confirm answer to your security question.<>";
             }
        }
        else
        {
            $errorPage5.="Please provide the answer to your security question .<>";
        }  
        return $errorPage5;
    }
}   
       
?>
