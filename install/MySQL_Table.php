<?php 

$result = $con->query("CREATE TABLE IF NOT EXISTS `cart_item` (`Id` int(20) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`Id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
$result = mysqli_query($con,"SHOW COLUMNS FROM `cart_item`");
while($row = mysqli_fetch_array($result)){
    $ClickColum = isset($ClickColum) ? $ClickColum : $row['Field'];
    $tableColum[]=$row['Field'];
}
if(!in_array("Qty", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `Qty` VARCHAR(255) NOT NULL;"); }
if(!in_array("ItemCode", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `ItemCode` VARCHAR(255) NOT NULL;"); }
if(!in_array("ItemType", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `ItemType` VARCHAR(255) NOT NULL;"); }
if(!in_array("EAN", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `EAN` VARCHAR(255) NOT NULL;"); }
if(!in_array("Item_Size", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `Item_Size` VARCHAR(255) NOT NULL;"); }
if(!in_array("Item_Color", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `Item_Color` VARCHAR(255) NOT NULL;"); }
if(!in_array("Title", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `Title` VARCHAR(255) NOT NULL;"); }
if(!in_array("UnitPrice", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `UnitPrice` decimal(20,8) NOT NULL;"); }
if(!in_array("VAT_Procent", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `VAT_Procent` decimal(20,8) NOT NULL;"); }
$result = $con->query("ALTER TABLE `cart_item` MODIFY COLUMN `VAT_Procent` Varchar(20) AFTER `UnitPrice`;");
if(!in_array("[users]Id", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `[users]Id` VARCHAR(20) NOT NULL;"); }
if(!in_array("[visiters]Id", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `[visiters]Id` int(20) NOT NULL;"); }
if(!in_array("VisiterToken", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `VisiterToken` VARCHAR(64) NOT NULL;"); }
if(!in_array("OrderCode", $tableColum)){ $result = $con->query("ALTER TABLE `cart_item` ADD `OrderCode` VARCHAR(255) NOT NULL;"); }
//$result = $con->query("ALTER TABLE `cart_item` MODIFY COLUMN `OrderCode` Varchar(20) AFTER `VisiterToken` DEFAULT NULL;");

//ALTER TABLE `cart_item` CHANGE `VAT_Procent` `VAT_Procent` VARCHAR(20) NULL DEFAULT NULL;




$result = $con->query("CREATE TABLE IF NOT EXISTS `cart` (`Id` int(20) NOT NULL AUTO_INCREMENT, PRIMARY KEY (`Id`)) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
$result = mysqli_query($con,"SHOW COLUMNS FROM `cart`");
while($row = mysqli_fetch_array($result)){
    $ClickColum = isset($ClickColum) ? $ClickColum : $row['Field'];
    $tableColum[]=$row['Field'];
}
if(!in_array("[users]Id", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `[users]Id` VARCHAR(20) NOT NULL;"); }
if(!in_array("[visiters]Id", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `[visiters]Id` int(20) NOT NULL;"); }
if(!in_array("VisiterToken", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `VisiterToken` VARCHAR(64) NOT NULL;"); }
if(!in_array("OrderCode", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `OrderCode` VARCHAR(255) NOT NULL;"); }

if(!in_array("Client_FirstName", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Client_FirstName` VARCHAR(255) NOT NULL;"); }
if(!in_array("Client_LastName", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Client_LastName` VARCHAR(255) NOT NULL;"); }
if(!in_array("Client_Email", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Client_Email` VARCHAR(255) NOT NULL;"); }
if(!in_array("Client_Telephone", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Client_Telephone` VARCHAR(20) NOT NULL;"); }

if(!in_array("Shipping_FirstName", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Shipping_FirstName` VARCHAR(255) NOT NULL;"); }
if(!in_array("Shipping_LastName", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Shipping_LastName` VARCHAR(255) NOT NULL;"); }
if(!in_array("Shipping_Address1", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Shipping_Address1` VARCHAR(255) NOT NULL;"); }
if(!in_array("Shipping_Address2", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Shipping_Address2` VARCHAR(255) NOT NULL;"); }
if(!in_array("Shipping_Address3", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Shipping_Address3` VARCHAR(255) NOT NULL;"); }
if(!in_array("Shipping_Zipcode", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Shipping_Zipcode` VARCHAR(255) NOT NULL;"); }
if(!in_array("Shipping_City", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Shipping_City` VARCHAR(255) NOT NULL;"); }
if(!in_array("Shipping_CountryCode", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Shipping_CountryCode` VARCHAR(255) NOT NULL;"); }

if(!in_array("Handling_Fee", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Handling_Fee` decimal(20,8) NOT NULL;"); }

if(!in_array("Shipping_MethodCode", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Shipping_MethodCode` VARCHAR(255) NOT NULL;"); }
if(!in_array("Shipping_Fee", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Shipping_Fee` decimal(20,8) NOT NULL;"); }
if(!in_array("Shipping_Parameter1", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Shipping_Parameter1` VARCHAR(255) NOT NULL;"); }
if(!in_array("Shipping_Parameter2", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Shipping_Parameter2` VARCHAR(255) NOT NULL;"); }

if(!in_array("Payment_MethodCode", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Payment_MethodCode` VARCHAR(255) NOT NULL;"); }
if(!in_array("Payment_Fee", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Payment_Fee` decimal(20,8) NOT NULL;"); }
if(!in_array("Payment_Parameter1", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Payment_Parameter1` VARCHAR(255) NOT NULL;"); }
if(!in_array("Payment_Parameter2", $tableColum)){ $result = $con->query("ALTER TABLE `cart` ADD `Payment_Parameter2` VARCHAR(255) NOT NULL;"); }
?>