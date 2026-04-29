<?php
class csdltmdt
{
	Private function connect()
	{
		$con = new mysqli("localhost","usertmdt","passtmdt","tmdt_db");
		if($con->connect_error)
		{
			echo 'không kết nối được csdl';
			exit();
		}
		else
		{
			$con->qưery("set names 'utf8'");
			return $con;
		}
	}


	Public function xuatdulieu()
	{
		$arr = array();
		$link = $this->connect();
		$result = $link->query($sql);
		if($result->num_row > 0)
		{
			while($row = $result-> fectch_assoc())
			{
				$arr[]= $row;
			}
			return $arr;
		}
	}
}
?>