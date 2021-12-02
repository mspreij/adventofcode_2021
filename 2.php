<?php
$values = explode("\n", trim(file_get_contents("2.txt")));

/* 2a
$arr = ['forward' => 0, 'up' => 0, 'down' => 0];
foreach($values as $value) {
  list($dir, $num) = explode(' ', $value);
  $arr[$dir] += $num;
}
echo $arr['forward'] * ($arr['down'] - $arr['up']);
*/

// 2b

$aim  = 0;
$fwd  = 0;
$down = 0;
foreach($values as $value) {
  list($dir, $num) = explode(' ', $value);
  if ($dir === 'down')    $aim += $num;
  if ($dir === 'up')      $aim -= $num;
  if ($dir === 'forward') {
    $fwd  += $num;
    $down += $aim * $num;
  }
}
echo $fwd * $down;
