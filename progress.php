<?php
     
  
for($i=0; $i<10000; $i++) {
 $variable=($i/10000)*100;
  $variable2=round($variable);
  echo $variable2.'%'; 
flush();
}
//ejemplo
?>