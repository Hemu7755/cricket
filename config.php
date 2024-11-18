<?php
$server="localhost";
$usename="root";
$password="";
$database="cricket";
$conn=new mysqli ($server,$usename,$password,$database);
if($conn!="")
{
echo"";
}
    else
{
echo"connection error";
}
?>