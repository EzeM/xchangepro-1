 <?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();    
$userID=$_SESSION["userID"];
if(isset($userID) && trim($userID))
{            
    include '../template/template.php';
    $temp=new template();
    $temp->registerFiles(1, "../page_segments/userImageEditFrame2.html");
    $temp->registerVariables(1, "signIndex,imageBaseName,imageName,collectiveCountName,suffix");
    $signIndex=1;
    $imageBaseName="";
    $imageName="";
    $suffix=$_POST['suffix'];
     if(!isset($suffix) || trim($suffix)=="")
     {
         $suffix=$_GET['suffix'];
     }
    $collectiveCountName=$_POST['countVar'];
     if(!isset($collectiveCountName) || trim($collectiveCountName)=="")
     {
         $collectiveCountName=$_GET['countVar'];
     }
    $count=$_POST['signIndex'];
     if(!isset($count) || trim($count)=="")
     {
         $count=$_GET['signIndex'];
     }

     $imageBaseName=$_POST['imageBaseName'];
     if(!isset($imageBaseName) || trim($imageBaseName)=="")
     {
         $imageBaseName=$_GET['imageBaseName'];
     }
     $imageName=$_POST['imageName'];
     if(!isset($imageName) || trim($imageName)=="")
     {
         $imageName=$_GET['imageName'];
     }
     if(!isset($imageName) || trim($imageName)=="")
     {
         $imageName="../Images/default_product.png";
     }
     $count=  intval($count);
    if(is_int($count))
    {
        $signIndex=$count+1;
    }
 else {
        $signIndex=1;
    }
    $temp->parseFile(1);
    $temp->printFile(1,false);
}
 else {
        header("Location: ../php/login.php");
}

// }
?>
