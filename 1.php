<?php
$values = explode("\n", trim(file_get_contents("1.txt")));

/* 1A
$count = 0;
foreach($values as $i => $value) {
  if ($i and $value > $values[$i-1]) $count++;
}
echo $count;
*/

$triplets = [];
foreach($values as $i => $value) {
  if ($i > 1) $triplets[] = $values[$i] + $values[$i-1] +$values[$i-2];
}
$count = 0;
foreach($triplets as $i => $value) {
  if ($i and $value > $triplets[$i-1]) $count++; // strangest sense of deja vu
}
echo $count;
