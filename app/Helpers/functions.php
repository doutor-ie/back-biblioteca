<?php

function somar_data($data, $dias, $meses, $ano){
  $data = explode("/", $data);
  $resData = date("d/m/Y", mktime(0, 0, 0, $data[1] + $meses, $data[0] + $dias, $data[2] + $ano));
  return $resData;
}