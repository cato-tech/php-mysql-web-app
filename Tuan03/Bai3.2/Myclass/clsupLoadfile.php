<?php
class myupload{
    public function uploadfile ($tmp_name, $name,$folder){
        $new_name = $folder."/".$name;
        if(move_uploaded_file($tmp_name,$new_name))
        {
            return 1;
        }
        else{
            return 0;
        }
    }
}
?>