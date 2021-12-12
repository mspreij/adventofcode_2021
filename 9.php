<?php

$input = file('9.txt', FILE_IGNORE_NEW_LINES); // thanks Jessica!
$x_input = explode("\n", '2199943210
3987894921
9856789892
8767896789
9899965678');

// 9A
$len = strlen($input[0]);
foreach($input as $y => $line) {
  for($x=0;$x<$len;$x++) {
    $c = $line[$x];
    if ($y && $input[$y-1][$x] <= $c) continue;
    if ($x && $line[$x-1] <= $c) continue;
    if (isset($line[$x+1]) and $line[$x+1] <= $c) continue;
    if (isset($input[$y+1][$x]) and $input[$y+1][$x] <= $c) continue;
    $lows["$x,$y"] = $c;
  }
}
echo "9A: ".(array_sum($lows) + count($lows))."\n";

// 9B
$basins = [];
foreach ($lows as $coords => $low) {
  $basin = [];
  $edge = [$coords];
  while (count($edge) > 0) {
    $new_edge = expand($edge, $basin);
    $basin = array_merge($basin, $edge);
    $edge = $new_edge;
  }
  $basins[] = $basin;
}

// get the top 3 basins, something usort, splice(3), product. sum? it'll be somewhere in the description..
$basins = array_map('count', $basins); // or you know
rsort($basins); // differently
echo "9B: ".array_product(array_slice($basins, 0, 3))."\n"; // but it /was/ product.

// === FUNCTIONS^H ===

function expand($edge, $basin) {
  global $input;
  // for each edge coordinate, return the 4 adjacent coordinates that are not in either edge, or this basin, already.
  // and oh, or 9 - don't return 9s.
  $out = [];
  foreach($edge as $coord) {
    list($x, $y) = explode(',', $coord);
    $line = $input[$y];
    if ($y and $input[$y-1][$x] != 9 /*no*/) $out[] = $x.','.($y-1);
    if ($x and $line[$x-1] != 9 /*no!*/)     $out[] = ($x-1).','.$y;
    if (isset($line[$x+1]) and $line[$x+1] != 9) /*noooo*/ $out[] = ($x+1).','.$y;
    if (isset($input[$y+1][$x]) and $input[$y+1][$x] != 9) $out[] = $x.','.($y+1);
  }
  // oh yeah and not edge/basins thing
  return array_unique(array_diff($out, $edge, $basin));
}
