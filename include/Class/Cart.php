<?php 

//  

	function do_empty(){
		global $con;
		if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); }
		echo "do empty";
		$con->query("DELETE FROM `cart_item` WHERE `[visiters]Id`='$array[VisiterID]' ");
		$con->query("DELETE FROM `cart` WHERE `[visiters]Id`='$array[VisiterID]' ");
	}


class Cart { 

	
	/*
		1. add_item
		2. item_delete
		3. cart_pi_update
		4. do_empty
	*/

	function add_item($array){
		global $con;
		
		if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); }
		
		$result = mysqli_query($con, "SELECT * FROM `cart_item` WHERE `ItemCode`='$array[ItemCode]' AND `[visiters]Id`='$array[VisiterID]' ");
		$rowcount=mysqli_num_rows($result);
		if($rowcount>0){
			//echo"yes";
			$row = mysqli_fetch_array($result);
			$NewQty=$row["Qty"]+$array["Qty"];
			//echo"$NewQty";
			$con->query("UPDATE `cart_item` SET `Qty`='$NewQty' WHERE `ItemCode`='$array[ItemCode]'");
		} else {
			if(!isset($array["Item_Size"])){ $array["Item_Size"]=""; }
			$con->query("INSERT INTO `cart_item` (
				`Qty`, `Title`, `UnitPrice`, `ItemCode`, `[visiters]Id`, 
				`Item_Size`, `Item_Color`
			) VALUES (
				'$array[Qty]', '$array[Title]', '$array[UnitPrice]', '$array[ItemCode]', '$array[VisiterID]', 
				'$array[Item_Size]', '$array[Item_Color]'
			)");
		}
		
	}
	
	function item_delete($item_id){
		global $con;
		$con->query("DELETE FROM cart_item WHERE `Id`='$item_id'");
	}
	
	function cart_pi_update($array=''){
		// Personal Information
		global $con;
		if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); } // Automatic VisiterID
		$OrderCode=strtoupper(bin2hex(random_bytes("4")));	// Random Code
		
		$result = mysqli_query($con, "SELECT * FROM `cart` WHERE `[visiters]Id`='$array[VisiterID]'");
		$rowcount=mysqli_num_rows($result);
		if($rowcount>0){
			$con->query("UPDATE `cart` SET `Client_FirstName`='$array[Client_FirstName]', `Client_LastName`='$array[Client_LastName]', `Client_Email`='$array[Client_Email]' WHERE `[visiters]Id`='$array[VisiterID]'");
		} else {
			$con->query("INSERT INTO `cart` (`[visiters]Id`, `Client_FirstName`, `Client_LastName`, `Client_Email`) VALUES ('$array[VisiterID]', '$array[Client_FirstName]', '$array[Client_LastName]', '$array[Client_Email]')");
		}
		
	}
	
	function do_empty(){
		global $con;
		if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); }
		$con->query("DELETE FROM `cart_item` WHERE `[visiters]Id`='$array[VisiterID]' ");
		$con->query("DELETE FROM `cart` WHERE `[visiters]Id`='$array[VisiterID]' ");
	}
	
	function cart_address_update($array=''){
		// Personal Information
		global $con;
		if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); }
		$result = mysqli_query($con, "SELECT * FROM `cart` WHERE `[visiters]Id`='$array[VisiterID]'");
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
			WHERE `[visiters]Id`='$array[VisiterID]'");
		} else {
		}
	}
	
	function cart_items($array=''){
		
	}
	
	function cart_info($colum){
		global $con;
		$row=array();
		if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); }
		$result = mysqli_query($con, "SELECT * FROM `cart` WHERE `[visiters]Id`='$array[VisiterID]'");
		$num=mysqli_num_rows($result);
		if($num>0){
			$row = mysqli_fetch_array($result);
		} else {
			
		}
		
			
		if($colum=="Shipping_FirstName" && $row["Shipping_FirstName"]==""){ $colum="Client_FirstName"; }
		if($colum=="Shipping_LastName"  && $row["Shipping_LastName"]==""){ $colum="Client_LastName"; }
		
		$row[$colum] = (isset($row[$colum])) ? $row[$colum] : '';
		
		
		$return=$row[$colum];
		
		
		
		return $return;
	}
	
	function items_total($array=''){
		global $con;
		$CartTotal=0;
		$array=array("cart_total"=>"");
		if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); }
		$result = mysqli_query($con, "SELECT * FROM `cart_item` WHERE `[visiters]Id`='$array[VisiterID]'");
		//echo mysqli_num_rows($result);
		while($row = mysqli_fetch_array($result)){
			$ItemTotal=$row["UnitPrice"]*$row["Qty"];
			//echo"$row[UnitPrice]";
			$CartTotal=$CartTotal+$ItemTotal;
		}
		
		
		return $CartTotal;
	}
	
	function items_ship_total(){
		$items_total=$this->items_total();
		$shipping_fee=$this->shipping_fee();
		$items_ship_total=$items_total + $shipping_fee;
		return $items_ship_total;
	}
	
	function shipping_fee($array=''){
		
		global $con; // Connect to MySQL
		$array=array("cart_total"=>"");
		if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); } // Automatic Visiter ID
		$result = mysqli_query($con, "SELECT * FROM `cart` WHERE `[visiters]Id`='$array[VisiterID]'");
		$num=mysqli_num_rows($result);
		if($num>0){
			$row = mysqli_fetch_array($result);
		} else {
			$row["Shipping_Fee"]="0.00";
		}
		
		$return=$row["Shipping_Fee"];
		return $return;
		
	}
	function shipping_methodcode($array=''){
		
		global $con; // Connect to MySQL
		$array=array("cart_total"=>"");
		if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); } // Automatic Visiter ID
		$result = mysqli_query($con, "SELECT * FROM `cart` WHERE `[visiters]Id`='$array[VisiterID]'");
		$num=mysqli_num_rows($result);
		if($num>0){
			$row = mysqli_fetch_array($result);
		} else {
			
		}
		
		$return=$row["Shipping_MethodCode"];
		return $return;
		
	}
	
	function cart_to_order(){
		
		global $con; 										// Connect to MySQL
		$datetime=date("Y-m-d H:i:s");						// dateTime
		$OrderCode=strtoupper(bin2hex(random_bytes("4")));	// Random Code
		
		$array=array("OrderCode"=>"$OrderCode");
		if(!isset($array["VisiterID"])){ $array['VisiterID']=VisiterID(); } // Automatic Visiter ID
		
		$sql="INSERT INTO `orders` (`[visiters]Id`) VALUES ('$array[VisiterID]')";
		
		if ($con->query($sql) === TRUE) {
			$Last_Insert_Id=$con->insert_id;
			$result = mysqli_query($con, "SELECT * FROM `cart` WHERE `[visiters]Id`='$array[VisiterID]'");
			$num=mysqli_num_rows($result);
			if($num>0){	$row = mysqli_fetch_array($result); }
			
			$con->query("UPDATE `orders` SET 
				`[visiters]Id`='".$row['[visiters]Id']."', 
				`OrderCode`='$OrderCode', 
				`Client_FirstName`='$row[Client_FirstName]', 
				`Client_LastName`='$row[Client_LastName]', 
				`Client_Email`='$row[Client_Email]', 
				`Client_Telephone`='$row[Client_Telephone]', 
				`Shipping_FirstName`='$row[Shipping_FirstName]', 
				`Shipping_LastName`='$row[Shipping_LastName]', 
				`Shipping_Address1`='$row[Shipping_Address1]', 
				`Shipping_Address2`='$row[Shipping_Address2]', 
				`Shipping_Address3`='$row[Shipping_Address3]', 
				`Shipping_Zipcode`='$row[Shipping_Zipcode]', 
				`Shipping_City`='$row[Shipping_City]', 
				`Shipping_CountryCode`='$row[Shipping_CountryCode]',
				`Shipping_MethodCode`='$row[Shipping_MethodCode]',
				`Shipping_Fee`='$row[Shipping_Fee]',
				`Shipping_Parameter1`='$row[Shipping_Parameter1]',
				`Shipping_Parameter2`='$row[Shipping_Parameter2]',
				`Payment_MethodCode`='$row[Payment_MethodCode]',
				`Payment_Fee`='$row[Payment_Fee]',
				`Payment_Parameter1`='$row[Payment_Parameter1]',
				`Payment_Parameter2`='$row[Payment_Parameter2]',
				`CreatedDateTime`='$datetime'
			WHERE `Id`='$Last_Insert_Id'");

			$result2 = mysqli_query($con, "SELECT * FROM `cart_item` WHERE `[visiters]Id`='$array[VisiterID]'");
			//echo mysqli_num_rows($result);
			while($row2 = mysqli_fetch_array($result2)){
				
				$con->query("INSERT INTO `order_item` (`Qty`, `ItemCode`, `Title`, `UnitPrice`, `[orders]Id`) VALUES ('$row2[Qty]', '$row2[ItemCode]', '$row2[Title]', '$row2[UnitPrice]', '$Last_Insert_Id')");
			}
		
			//echo "New record created successfully";
		} else {
			
		}
		/*
		$result = mysqli_query($con, "SELECT * FROM `cart` WHERE `[visiters]Id`='$array[VisiterID]'");
		$num=mysqli_num_rows($result);
		if($num>0){
			$row = mysqli_fetch_array($result);
			
			
		} else {
			
		}
		*/
	}
}
?>
