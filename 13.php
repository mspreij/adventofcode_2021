<?php

// Origami! \o/

$data = trim(file_get_contents('13.txt'));

list($coords, $fold_data) = explode("\n\n", $data);
// make initial thing
foreach(explode("\n", $coords) as $coord) {
  list($x,$y) = explode(',', $coord);
  $grid[$y][$x] = 1;
}
foreach(explode("\n", $fold_data) as $fold) {
  $folds[] = substr($fold, 11);
}

// $folds = [$folds[0]];

// do a[ll] fold[s]
foreach($folds as $fold) {
  list($dir, $value) = explode("=", $fold);
  foreach($grid as $y => $rows) {
    foreach($rows as $x => $val) {
      if (! $val) continue; // I am starting to not like grids.
      if ($dir === 'x') {
        if ($x > $value) {
          $grid[$y][$x-($x-$value)*2] = 1;
          $grid[$y][$x] = 0;
        }
      }else{
        if ($y > $value) {
          $grid[$y-($y-$value)*2][$x] = 1;
          $grid[$y][$x] = 0;
        }
      }
    }
  }
}

/* 13A
$count = 0;
foreach($grid as $y => $row) foreach($row as $x => $val) $count+=$val;
echo $count;
*/

// 13B
display();

function display() {
  global $grid;
  $max_x = $max_y = 0;
  foreach($grid as $y => $row) {
    foreach($row as $x => $val) {
      if ($val) {
        $max_y = max($y, $max_y);
        $max_x = max($x, $max_x);
      }
    }
  }
  echo "\n$max_x, $max_y\n";
  for($y=0;$y<=$max_y;$y++) {
    for($x=0;$x<=$max_x;$x++) {
      echo ! empty($grid[$y][$x]) ? 'x' : ' ';
    }
    echo "\n";
  }
}
