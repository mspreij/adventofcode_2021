<?php
$input = trim(file_get_contents("4.txt"));

$X_input = '7,4,9,5,11,17,23,2,0,14,21,24,10,16,13,6,15,25,12,22,18,20,8,19,3,26,1

22 13 17 11  0
 8  2 23  4 24
21  9 14 16  7
 6 10  3 18  5
 1 12 20 15 19

 3 15  0  2 22
 9 18 13 17  5
19  8  7 25 23
20 11 10 24  4
14 21 16 12  6

14 21 17 24  4
10 16 15  9 19
18  8 23 26 20
22 11 13  6  5
 2  0 12  3  7';

list($number_data, $card_data) = explode("\n\n", $input, 2);
$numbers        = explode(',', $number_data);
$card_data_list = explode("\n\n", $card_data);

$cards = []; // store the numbers as cardindex -> y -> x [value]
$hits  = []; // store matches
$inhit = [[0,0,0,0,0], [0,0,0,0,0], [0,0,0,0,0], [0,0,0,0,0], [0,0,0,0,0]];

// parse the card data and init scores/hits
foreach($card_data_list as $i => $card_raw) {
  $card_lines = explode("\n", $card_raw);
  foreach($card_lines as $line) {
    $cards[$i][] = preg_split('/\s+/', trim($line));
    $h[$i] = $inhit;
  }
}

$won_already = [];
foreach($numbers as $n => $number) {
  foreach ($cards as $c => $card) {
    $win = false;
    if (in_array($c, $won_already)) continue;
    for($y=0;$y<5;$y++) {
      for($x=0;$x<5;$x++) {
        if ($card[$y][$x] == $number) { // match
          $h[$c][$y][$x] = 1;
          if (bingo($h[$c], $y, $x)) {
            $sum = empty_sum($h[$c], $card);
            $result = $sum * $number;
            // echo "number $number, card $c, [$y $x] $result\n";
            $win = true;
            break 2;
          }
        }
      }
    }
    if ($win) {
      $won_already[] = $c;
      // echo "Won so far: ".join(', ', $won_already)."\n";
    }
  }
}

echo $result."\n";

// == Functions ==========================

function empty_sum($H, $card) {
  $sum = 0;
  for($y=0;$y<5;$y++) {
    for($x=0;$x<5;$x++) {
      if ($H[$y][$x] == 0) $sum += $card[$y][$x];
    }
  }
  return $sum;
}

function bingo($H, $y, $x) { // $H is a scorecard.
  // we only have to check the two rows intersecting on (x, y)
  return ($H[0][$x] + $H[1][$x] + $H[2][$x] + $H[3][$x] + $H[4][$x] == 5 or // vertical match
          $H[$y][0] + $H[$y][1] + $H[$y][2] + $H[$y][3] + $H[$y][4] == 5);  // horizontal match
}
