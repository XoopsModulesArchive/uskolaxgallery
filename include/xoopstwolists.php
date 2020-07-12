<?php

class XoopsListScripts{ 

Var $FormName;
Var $list1;
Var $list2;
Var $hidden1;
Var $hidden2;
Var $hidden3;
Var $hidden4;
Var $List1IdValues= array();
Var $List1TextValues= array();
Var $List2IdValues= array();
Var $List2TextValues= array();

	function InsertFormName($Name) 
	{
		$this->FormName = $Name;
	}

	function InsertList1Name($Name) 
	{
		$this->list1 = $Name;
	}

	function InsertList2Name($Name) 
	{
		$this->list2 = $Name;
	}

	function InsertHidden1Name($Name) 
	{
		$this->hidden1 = $Name;
	}

	function InsertHidden2Name($Name) 
	{
		$this->hidden2 = $Name;
	}

	function InsertHidden3Name($Name) 
	{
		$this->hidden3 = $Name;
	}

	function InsertHidden4Name($Name) 
	{
		$this->hidden4 = $Name;
	}


	Function PrepareListJavascript(){
		echo '
		<script language="Javascript">
		<!--

		function ClearList(OptionList, TitleName) 
		{
			OptionList.length = 0;
		}
			
		function move(side)
		{   
			var temp1 = new Array();
			var temp2 = new Array();
			var tempa = new Array();
			var tempb = new Array();
			var current1 = 0;
			var current2 = 0;
			var y=0;
			var attribute;
			
			//assign what select attribute treat as attribute1 and attribute2
			if (side == "right")
			{  
				attribute1 = document.'. $this->FormName . '.' . $this->list1 . '; 
				attribute2 = document.'. $this->FormName . '.' . $this->list2 . ';
				attribute3 = document.'. $this->FormName . '.' . $this->hidden1 . ';
				attribute4 = document.'. $this->FormName . '.' . $this->hidden2 . ';
				attribute5 = document.'. $this->FormName . '.' . $this->hidden3 . ';
				attribute6 = document.'. $this->FormName . '.' . $this->hidden4 . ';
			}
			else
			{  
				attribute1 = document.'. $this->FormName . '.' . $this->list2 . ';
				attribute2 = document.'. $this->FormName . '.' . $this->list1 . ';  
				attribute3 = document.'. $this->FormName . '.' . $this->hidden2 . ';
				attribute4 = document.'. $this->FormName . '.' . $this->hidden1 . ';
				attribute5 = document.'. $this->FormName . '.' . $this->hidden4 . ';
				attribute6 = document.'. $this->FormName . '.' . $this->hidden3 . ';
			}

			//fill an array with old values
			for (var i = 0; i < attribute2.length; i++)
			{  
				y=current1++
				temp1[y] = attribute2.options[i].value;
				tempa[y] = attribute2.options[i].text;
			}

			//assign new values to arrays
			for (var i = 0; i < attribute1.length; i++)
			{   
				if ( attribute1.options[i].selected )
				{  
					y=current1++
					temp1[y] = attribute1.options[i].value;
					tempa[y] = attribute1.options[i].text;
				}
				else
				{  
					y=current2++
					temp2[y] = attribute1.options[i].value; 
					tempb[y] = attribute1.options[i].text;
				}
			}

			//generating new options 
			attribute4.value = "";
			attribute3.value = "";
			attribute5.value = "";
			attribute6.value = "";

			for (var i = 0; i < temp1.length; i++)
			{  
				attribute2.options[i] = new Option();
				attribute2.options[i].value = temp1[i];
				attribute2.options[i].text =  tempa[i];
				attribute4.value = attribute4.value +  temp1[i] + ",";
				attribute6.value = attribute6.value +  tempa[i] + ",";
			}

			//generating new options
			ClearList(attribute1,attribute1);

			if (temp2.length>0)
			{	
				for (var i = 0; i < temp2.length; i++)
				{   
					attribute1.options[i] = new Option();
					attribute1.options[i].value = temp2[i];
					attribute1.options[i].text =  tempb[i];
					attribute3.value = attribute3.value +  temp2[i] + ",";
					attribute5.value = attribute5.value +  tempb[i] + ",";
				}
			}
		}
				
				
		//-->
		</script>
	';
	}
	Function InsertList1Values($id, $value){
		$this->List1IdValues[] = $id;
		$this->List1TextValues[] = $value;
	}

	Function InsertList2Values($id, $value){
		$this->List2IdValues[] = $id;
		$this->List2TextValues[] = $value;
	}


	Function InsertHiddenFields(){
	echo '
		<input type="hidden" name="'. $this->hidden1 .'" value=""><br>
		<input type="hidden" name="'. $this->hidden2 .'" value=""><br>
		<input type="hidden" name="'. $this->hidden3 .'" value=""><br>
		<input type="hidden" name="'. $this->hidden4 .'" value=""><br>
	';
	}
	Function InsertFirstList($width=150){
		echo '<select name="' . $this->list1 .'" multiple size="10" style="width=' . $width .'px" width="' . $width .'px" onDblClick="move(\'right\')" >';
			for ($ListCount = 0; $ListCount < count($this ->List1IdValues) ; $ListCount++ ) {
				echo '<option value="' . $this->List1IdValues[$ListCount] . '">' . $this->List1TextValues[$ListCount] . '</option>';
			}
		echo '</select>';
	}

	Function InsertButtonsList($rightvalue = ">>", $leftvalue = "<<", $submitvalue = "submit"){
		echo '
				<input type="button" value="' . $rightvalue . '" onclick="move(\'right\')"><br><br>
				<input type="button" value="' . $leftvalue . '"  onclick="move(\'left\')"><br><br>
				<input type="submit" name="' . $submitvalue . '" value="Submit">
		';
	}

	Function InsertSecondList($width=150){
		echo '<select name="' . $this->list2 .'" multiple size="10" style="width=' . $width .'px" width="' . $width .'px" onDblClick="move(\'left\')" >';
			for ($ListCount = 0; $ListCount < count($this ->List2IdValues) ; $ListCount++ ) {
				echo '<option value="' . $this->List2IdValues[$ListCount] . '">' . $this->List2TextValues[$ListCount] . '</option>';
			}
		echo '</select>';
	}

}
?>