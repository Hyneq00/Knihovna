<?php
phpinfo();

$n1 = 50;
$n2 = 10;





try {
    if ($n2 === 0) {
        throw new Exception("Dělení nulou je zakázané");
    }
    $result = $n1 / $n2;
    echo $result;
} catch (Exception $e) {
    error_log("CHyba dělení nulou", 3, "errors/error.log" );
}


