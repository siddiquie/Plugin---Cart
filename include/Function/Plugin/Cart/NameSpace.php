<?php 

namespace P\Cart;

function config($virable){
    include("include/Function/inc_NameSpace/config.php");
    return $return;
}

function t($tableName){
    include("include/Function/inc_NameSpace/t.php");
    return $return;
}





function count_qty(){
	//sh_debug(array("Msg"=>"in Function","debug_backtrace"=>debug_backtrace()));
	sh_debug(array("Msg"=>"in Function"));
    global $con;
	
	
	 $VisiterID=VisiterID(); 
	 $VisiterToken=$_SESSION["VisiterToken"]; 
	
	$count_qty=0;
	$result = mysqli_query($con, "SELECT * FROM `cart_item` WHERE `VisiterToken`='$VisiterToken' ");
	$rowcount=mysqli_num_rows($result);
	if($rowcount>0){
	    while($row = mysqli_fetch_array($result)){
	        $count_qty=$count_qty + $row["Qty"]; 
	    }
	} else { 
	    $count_qty=0;
	}
	return $count_qty;
	
}

function do_empty($OrderCode=null){
    global $con;
	if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); }
	$VisiterToken=$_SESSION["VisiterToken"]; 
	$deleteQuery=" `VisiterToken`='$VisiterToken' ";
	if(isset($OrderCode)){ $deleteQuery .=" OR `OrderCode`='$OrderCode' "; }
	$con->query("DELETE FROM `cart_item` WHERE ".$deleteQuery);
	$con->query("DELETE FROM `cart` WHERE ".$deleteQuery);
}

function setOrderCode($OrderCode=null){

}

function i_add($array){
	global $con;

	$VisiterToken=$_SESSION["VisiterToken"]; 
	if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); }
	if(!isset($array["Qty"])){ $array['Qty']="1"; }
	if(!isset($array["ItemCode"]) || $array["ItemCode"]==""){ $array['ItemCode']=strtoupper(bin2hex(random_bytes("12")));	 }
	if(!isset($array["VAT_Procent"])){
		$array["VAT_Procent"]=0;
		if(function_exists('\P\VAT\defaultProcent')) { 
			$result=\P\VAT\defaultProcent();
			$array["VAT_Procent"]=$result["Procent"];
		 } 
	}
	
	$array["Title"] = mysqli_real_escape_string($con, $array["Title"]);

	$result = mysqli_query($con, "SELECT * FROM `cart_item` WHERE `ItemCode`='$array[ItemCode]' AND `VisiterToken`='$VisiterToken' ");
	$rowcount=mysqli_num_rows($result);
	if($rowcount>0){
		//echo"yes";
		$row = mysqli_fetch_array($result);
		$NewQty=$row["Qty"]+$array["Qty"];
		//echo"$NewQty";
		$con->query("UPDATE `cart_item` SET `Qty`='$NewQty' WHERE `ItemCode`='$array[ItemCode]'");
	} else {
		if(!isset($array["EAN"])){ $array["EAN"]=""; }
		if(!isset($array["Item_Size"])){ $array["Item_Size"]=""; }
		if(!isset($array["Item_Color"])){ $array["Item_Color"]=""; }
		$con->query("INSERT INTO `cart_item` (
			`Qty`, `Title`, `UnitPrice`, `ItemCode`, `EAN`, `VisiterToken`, 
			`Item_Size`, `Item_Color`, `VAT_Procent`
		) VALUES (
			'$array[Qty]', '$array[Title]', '$array[UnitPrice]', '$array[ItemCode]', '$array[EAN]', '$VisiterToken', 
			'$array[Item_Size]', '$array[Item_Color]', '$array[VAT_Procent]'
		)");
	}

	$return["Status"]=true;
	return $return;
	
}

function info($colum, $VisiterID=''){
	
	global $con; // Connect to MySQL
	if($VisiterID==""){ $VisiterID=VisiterID(); } // Automatic Visiter ID
	$VisiterToken=$_SESSION["VisiterToken"]; // VisiterToken
	$result = mysqli_query($con, "SELECT * FROM `cart` WHERE `VisiterToken`='$VisiterToken'");
	$num=mysqli_num_rows($result);
	if($num>0){
		$row = mysqli_fetch_array($result);
	} else {
		$row["$colum"]=null;
	}
	
	$return=$row["$colum"];

	return $return;
	
}

function listing(){
	global $con; // Connection To SQL
	$VisiterToken=$_SESSION["VisiterToken"]; // VisiterToken
	$result = mysqli_query($con, "SELECT * FROM `cart_item` WHERE `VisiterToken`='$VisiterToken' "); 
	return $result;
}

function toPay($VisiterID=''){
	global $con;
	if($VisiterID==""){ $VisiterID=VisiterID(); } // Automatic Visiter ID 
	$total=total(); // This is Calc. Total of Items
	$Handling_Fee=info("Handling_Fee");
	$Shipping_Fee=info("Shipping_Fee");
	$Payment_Fee=info("Payment_Fee");
	$ToPay=$total + $Handling_Fee;
	$ToPay=$ToPay + $Shipping_Fee;
	$ToPay=$ToPay + $Payment_Fee;
	return $ToPay;
}

function total($VisiterID=''){ 
    // This function is calc. total of items in your Cart
	global $con;
	
	$CartTotal=0;
	if($VisiterID==""){ $VisiterID=VisiterID(); } // Automatic Visiter ID 
	$VisiterToken=$_SESSION["VisiterToken"]; // VisiterToken
	$result = mysqli_query($con, "SELECT * FROM `cart_item` WHERE `VisiterToken`='$VisiterToken' ");
	$num=mysqli_num_rows($result);
	while($row = mysqli_fetch_array($result)){
		$ItemTotal=$row["UnitPrice"]*$row["Qty"];
		//echo"$row[UnitPrice]";
		$CartTotal=$CartTotal+$ItemTotal;
	}
	
	
	
	return $CartTotal;
}

function OrderCodeUpdate($Get){
	global $con;
	$con->query("UPDATE `cart_item` SET `Qty`='$NewQty' WHERE `ItemCode`='$array[ItemCode]'");
}

function pi_update($array=''){
	// Personal Information
	global $con;
	if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); } // Automatic VisiterID
	$VisiterToken=$_SESSION["VisiterToken"]; // VisiterToken
	$OrderCode=strtoupper(bin2hex(random_bytes("4")));	// Random Code
	
	$result = mysqli_query($con, "SELECT * FROM `cart` WHERE `VisiterToken`='$VisiterToken'");
	$rowcount=mysqli_num_rows($result);
	if($rowcount>0){
		$con->query("UPDATE `cart` SET `Client_FirstName`='$array[Client_FirstName]', `Client_LastName`='$array[Client_LastName]', `Client_Email`='$array[Client_Email]', `Client_Telephone`='$array[Client_GSM]' WHERE `VisiterToken`='$VisiterToken'");
	} else {
		$con->query("INSERT INTO `cart` (`VisiterToken`, `Client_FirstName`, `Client_LastName`, `Client_Email`, `Client_Telephone`) VALUES ('$VisiterToken', '$array[Client_FirstName]', '$array[Client_LastName]', '$array[Client_Email]', '$array[Client_GSM]')");
	}
	
}

function update_address($array=''){
	// Personal Information
	global $con;
	if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); }
	$VisiterToken=$_SESSION["VisiterToken"]; // VisiterToken
	$result = mysqli_query($con, "SELECT * FROM `cart` WHERE `VisiterToken`='$VisiterToken'");
	$rowcount=mysqli_num_rows($result);
	if($rowcount>0){
		$con->query("UPDATE `cart` SET 
			`Shipping_FirstName`='$array[Shipping_FirstName]', 
			`Shipping_LastName`='$array[Shipping_LastName]', 
			`Shipping_Address1`='$array[Shipping_Address1]', 
			`Shipping_Address2`='$array[Shipping_Address2]', 
			`Shipping_Address3`='$array[Shipping_Address3]', 
			`Shipping_Zipcode`='$array[Shipping_Zipcode]', 
			`Shipping_City`='$array[Shipping_City]', 
			`Shipping_CountryCode`='$array[Shipping_CountryCode]' 
		WHERE `VisiterToken`='$VisiterToken'");
	} else {
	}
}



?>