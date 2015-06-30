<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
function verifyPasswordStrenght($typedPassword)
{
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
                            return -3; //repeated sequence in lower case words
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
                                            return -6; //repeated sequence in upper case words
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
                                                            return -9; //repeated sequence in symbols
                                                        }
                                                        else
                                                        {
                                                            $passwordScore+=($d+count($digitFoundArray[0]));
                                                            return $passwordScore;

                                                        }
                                                    }
                                                    else
                                                    {
                                                        return -8; // repeated sequence in symbol characters
                                                    }
                                                }
                                                else
                                                {
                                                    return -7; // symbol characters does not match criteria
                                                }
                                            }
                                            else
                                            {
                                                return -7; // symbol characters does n ot match criteria
                                            }
                                        }
                                    }
                                    else
                                    {
                                        return -5; // repeated sequence in uppercase characters
                                    }
                                }
                                else
                                {
                                    return -4; // uppercase characters does n ot match criteria
                                }
                            }
                            else
                            {
                                return -4; // uppercase characters does n ot match criteria
                            }
                        }
                    }
                    else
                    {
                        return -2; // repeated sequence in lowercase characters
                    }
                }
                else
                {
                    return -1; // lowercase characters does n ot match criteria
                }
            }
            else
            {
                return -1; // lowercase characters does n ot match criteria
            }
        }
        else
        {
            return 0;
        }
    }
     else {
        return -10;
    }
}
function checkForRepeatedCharacterInArrays($word)
{
    if(isset($word))
    {
        if(is_array($word))
        {
            $arrayLenght=count($word);
            for ($p=0;$p<$arrayLenght;$p++)
            {
                $mainString=$word[$p];
                $n=strlen($mainString);
                for ($j=$p+1;$j<$arrayLenght;$j++)
                {
                    $haystack=$word[$j];
                    for($r=0;$r<$n;$r++)
                    {
                        for($q=2;$q<=($n-$r);$q++)
                        {
                            $searchString=  substr($mainString, $r,$q);
                            $rt=  strstr($haystack, $searchString);
                            if($rt)
                            {
                                return true;
                            }
                        }
                    }
                }
            }
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}
function checkForRepeatedCharacterSequenceInStrings($word)
{
    if(isset($word))
    {
        if(is_string($word))
        {
            $lenght=  strlen($word);

            if($lenght==1)
            {
                return false;
            }
            else if($lenght>=2 && $lenght<4)
            {
                return checkForRepeatedCharacters($word); 
            }
            else if($lenght>=4)
            {
                $p=  intval($lenght/2);
                for($x=0 ;$x<$lenght;$x++)
                {
                    $found=false;
                    for($z=2;$z<=$p;$z++)
                    {
                        if($x+$z<$lenght)//ensures the sustring being requested is less than the input word lenght.
                        {
                            if(($z)<=($lenght-($x+$z)))//ensures that the search string  lenght is less than the remaining string lenght
                            {
                                $subStr1=  substr($word, $x, $z);
                                $subStr2=  substr($word,($z+$x));
                                $r=strstr($subStr2, $subStr1);
                                if($r)
                                {
                                    $found=true;
                                    break;
                                }
                            }
                            else
                            {
                                break;
                            }
                        }
                        else
                        {
                            break;
                        }
                    }
                    if($found)
                    {
                        return true;
                    }
                }
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            return true;
        }
    }
    else
    {
        return true;
    }
}
function checkForRepeatedCharacters($word)
{
    if(isset($word))
    {
        if(is_string($word))
        {
            $lenght=  strlen($word);
            if($lenght==1)
            {
                return false;
            }
            else if($lenght>1)
            {
                for($y=1 ;$y<$lenght;$y++)
                {
                    if($word[($y-1)]==$word[$y])
                    {
                        return true;
                    }
                }
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
                    
            return true;
        }
    }
    else
    {
        return true;
    }
}
?>
