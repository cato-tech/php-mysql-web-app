<?php
    include ("Myclass/tinhtoan.php");
    $p = new tinhtoan();
    echo "Phep cong: ".$p->cong(5,5);
    echo "<br>";
    echo "Phep tru: ".$p->tru(6,3);
    echo "<br>";
    echo "Phep nhan: ".$p->nhan(3,9);
    echo "<br>";
    echo "Phep chia: ".$p->chia(8,4);
?>