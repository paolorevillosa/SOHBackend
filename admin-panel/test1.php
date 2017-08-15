<?php

// Connects to your Database 
 include "config.php";

 $QUERY_LISTAR_DISTRITO = "SELECT id, nome FROM distrito";

 $DISTRITO = mysql_query($QUERY_LISTAR_DISTRITO) or die(mysql_error());
 $nr_distrito = mysql_num_rows($DISTRITO);

 while ($nr_distrito > 0) {
    $row = mysql_fetch_row($DISTRITO);

    echo '<option value="'.$row[0].'">'.$row[1].'</option>';
    $nr_distrito--;
 }
?>