
<?php
class dangnhap{
	public function fc_dangnhap($use,$pass){
		if ($use != "" && $pass != ""){
			if ($use == 'abc123@gmail.com' && $pass == '123456')
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		else{
			return 0;
		}
	}
}
?>