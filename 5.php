<?php

$lines = explode("\n", trim(file_get_contents('5.txt')));
foreach($lines as $line) {
  $pairs = explode(' -> ', $line);
  $coords[] = [explode(',', $pairs[0]), explode(',', $pairs[1])];
}

$grid     = [];
$hotspots = 0;

/* 5a
foreach($coords as $crd) {
  if ($crd[0][0] === $crd[1][0]) {
    // nice thing about range(), it works in either direction
    foreach(range($crd[0][1], $crd[1][1]) as $y) add_point($crd[0][0], $y);
  }elseif($crd[0][1] === $crd[1][1]) {
    foreach(range($crd[0][0], $crd[1][0]) as $x) add_point($x, $crd[0][1]);
  }else continue; // skip diagonal lines
} */

// 5b
foreach($coords as $crd) {
  if ($crd[0][0] === $crd[1][0]) {
    foreach(range($crd[0][1], $crd[1][1]) as $y) add_point($crd[0][0], $y);
  }elseif($crd[0][1] === $crd[1][1]) {
    foreach(range($crd[0][0], $crd[1][0]) as $x) add_point($x, $crd[0][1]);
  }else{
    $xx = range($crd[0][0], $crd[1][0]);
    $yy = range($crd[0][1], $crd[1][1]);
    foreach($xx as $i => $x) add_point($x, $yy[$i]);
  }
}

echo $hotspots;


function add_point($x, $y) {
  global $grid, $hotspots;
  if (! isset($grid[$x][$y])) $grid[$x][$y] = 0;
  $grid[$x][$y]++;
  if ($grid[$x][$y] === 2) $hotspots++;
}
