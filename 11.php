<?php

// 11A, back to the grid.
$input = file('11.txt', FILE_IGNORE_NEW_LINES);
$X_input = explode("\n", '5483143223
2745854711
5264556173
6141336146
6357385478
4167524645
2176841721
6882881134
4846848554
5283751526');

$octopi = array_map('str_split', $input);

/*
soo.. for each step, add 1 to everything. store 10s for convenience
then loop:
 - flash 10s, turn them into 0 ($flash++)
 - add 1 to each adjacent square (not to 0s though, any 0 in this step will have just flashed. NOR to 10s because ffs.)
   - store new 10s
end

for part B, count the flashes on each loop, when it's equal to width squared (nr of octopi) exit with loop count
*/

$width = count($octopi[0]);

$steps = 1000;
$flashes = 0;
$total_flashes = 0;

for ($i=1; $i<$steps; $i++) {
  // add 1 to every uh.. dumbo octopus
  $charged = [];
  $flashes = 0;
  for($y=0;$y<$width;$y++) {
    for($x=0;$x<$width;$x++) {
      $octopi[$y][$x]++;
      if ($octopi[$y][$x] === 10) $charged[] = [$x, $y];
    }
  }
  while (count($charged)) {
    $new_charged = [];
    foreach($charged as $coords) {
      list($x, $y) = $coords;
      $octopi[$y][$x] = 0; // FLASH
      $flashes++;
      foreach(adjacent($x, $y) as $adj) {
        list($x,$y) = $adj;
        $val = $octopi[$y][$x];
        if ($val > 0 and $val < 10) {
          $octopi[$y][$x]++;
          if ($octopi[$y][$x] === 10) $new_charged[] = [$x, $y];
        }
      }
    }
    $charged = $new_charged;
  }
  $total_flashes += $flashes;
  if ($i === 100) {
    display();
    echo "10A: $total_flashes flashes\n";
  }
  if ($flashes === $width**2) {
    display();
    echo "10B: full-flash step: $i\n";
    break;
  }
}

function adjacent($x, $y) {
  global $octopi, $width;
  $out = [];
  if ($y) {
    if ($x) $out[] = [$x-1, $y-1];
    $out[] = [$x, $y-1];
    if ($x<($width-1)) $out[] = [$x+1, $y-1];
  }
  if ($x) $out[] = [$x-1, $y];
  if ($x<($width-1)) $out[] = [$x+1, $y];
  if ($y<($width-1)) {
    if ($x) $out[] = [$x-1, $y+1];
    $out[] = [$x, $y+1];
    if ($x<($width-1)) $out[] = [$x+1, $y+1];
  }
  return $out;
}

function display() {
  global $octopi;
  foreach($octopi as $row) {
    foreach($row as $o) {
      if ($o === 10) $o = 'F';
      echo $o?$o:"\x1b[33;43;1m$o\x1b[0m";
    }
    echo "\n";
  }
  echo "\n";
}
