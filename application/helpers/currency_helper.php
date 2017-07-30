<?php
function format($n){
  return substr($n, 0, 4)."-".substr($n,4,7);
}
function celular($n){
  return substr($n, 0, 5)."-".substr($n,5,7);
}