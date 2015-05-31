<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include '../template/passwordVerificationFunctions.php';
$typedPassword=$_GET["typedPassword"];
if(isset($typedPassword))
{
    $passwordScore=0;
    $lowerCasePattern="([a-z]+)";
    $upperCasePattern="([A-Z]+)";
    $symbolPattern="([\!\@\#\$\%\^\&\*\(\)\_\+\-\=\<\>\;\:\'\"\/\,\|])";
    $digitPattern="([0-9]+)";
    $passwordLenght=  strlen($typedPassword);
    $digitFoundArray=array();
    $symbolFoundArray=array();
    $lowerCaseFoundArray=array();
    $upperCaseFoundArray=array();
    $lowerCaseFound=preg_match_all($lowerCasePattern, $typedPassword,$lowerCaseFoundArray);
    $upperCaseFound=preg_match_all($upperCasePattern, $typedPassword,$upperCaseFoundArray);
    $symbolFound=preg_match_all($symbolPattern, $typedPassword,$symbolFoundArray);
    $digitFound=preg_match_all($digitPattern, $typedPassword,$digitFoundArray);
    if($passwordLenght>=8 &&$passwordLenght<=15 && $lowerCaseFound && $upperCaseFound && $digitFound && $symbolFound)
    {
        if(count($lowerCaseFoundArray)>0)
        {
            if(count($lowerCaseFoundArray[0])>0)
            {
                $d=count($lowerCaseFoundArray[0]);
                
                $error=false;
                for($u=0;$u<$d;$u++)
                {
                    if(checkForRepeatedCharacters($lowerCaseFoundArray[0][$u]) || checkForRepeatedCharacterSequenceInStrings($lowerCaseFoundArray[0][$u]))
                    {
                        $error=true;
                        break;
                    }
                }
                if(!$error)
                {
                    if(checkForRepeatedCharacterInArrays($lowerCaseFoundArray[0]))
                    {
                        print -3; //repeated sequence in lower case words
                    }
                    else
                    {
                        $passwordScore+=$d;
                        if(count($upperCaseFoundArray)>0)
                        {
                            if(count($upperCaseFoundArray[0])>0)
                            {
                                $d=count($upperCaseFoundArray[0]);
                                
                                for($u=0;$u<$d;$u++)
                                {
                                    if(checkForRepeatedCharacters($upperCaseFoundArray[0][$u]) || checkForRepeatedCharacterSequenceInStrings($upperCaseFoundArray[0][$u]))
                                    {
                                        $error=true;
                                        break;
                                    }
                                }
                                if(!$error)
                                {
                                    if(checkForRepeatedCharacterInArrays($upperCaseFoundArray[0]))
                                    {
                                        print -6; //repeated sequence in upper case words
                                    }
                                    else
                                    {
                                        $passwordScore+=$d;
                                        if(count($symbolFoundArray)>0)
                                        {
                                            if(count($symbolFoundArray[0])>0)
                                            {
                                                $d=count($symbolFoundArray[0]);
                                                
                                                for($u=0;$u<$d;$u++)
                                                {
                                                    if(checkForRepeatedCharacters($symbolFoundArray[0][$u]) || checkForRepeatedCharacterSequenceInStrings($symbolFoundArray[0][$u]))
                                                    {
                                                        $error=true;
                                                        break;
                                                    }
                                                }
                                                if(!$error)
                                                {
                                                    if(checkForRepeatedCharacterInArrays($symbolFoundArray[0]))
                                                    {
                                                        print -9; //repeated sequence in symbols
                                                    }
                                                    else
                                                    {
                                                        $passwordScore+=($d+count($digitFoundArray[0]));
                                                        print $passwordScore;
                                                        
                                                    }
                                                }
                                                else
                                                {
                                                    print -8; // repeated sequence in symbol characters
                                                }
                                            }
                                            else
                                            {
                                                print -7; // symbol characters does not match criteria
                                            }
                                        }
                                        else
                                        {
                                            print -7; // symbol characters does n ot match criteria
                                        }
                                    }
                                }
                                else
                                {
                                    print -5; // repeated sequence in uppercase characters
                                }
                            }
                            else
                            {
                                print -4; // uppercase characters does n ot match criteria
                            }
                        }
                        else
                        {
                            print -4; // uppercase characters does n ot match criteria
                        }
                    }
                }
                else
                {
                    print -2; // repeated sequence in lowercase characters
                }
            }
            else
            {
                print -1; // lowercase characters does n ot match criteria
            }
        }
        else
        {
            print -1; // lowercase characters does n ot match criteria
        }
    }
    else
    {
        print 0;
    }
}
 else {
    print -10;
}
?>
