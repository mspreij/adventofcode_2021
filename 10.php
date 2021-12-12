<?php

$input = file('10.txt', FILE_IGNORE_NEW_LINES);

$X_input = explode("\n", '[({(<(())[]>[[{[]{<()<>>
[(()[<>])]({[<{<<[]>>(
{([(<{}[<>[]}>{[]{[(<()>
(((({<>}<{<{<>}{[]{[]{}
[[<[([]))<([[{}[[()]]]
[{[{({}]{}}([{[{{{}}([]
{<[[]]>}<{[{[{[]{()[[[]
[<(<(<(<{}))><([]([]()
<{([([[(<>()){}]>(<<{{
<{([{{}}[<[[[<>{}]]]>[]]');

$open  = ['(', '{', '[', '<'];
$close = [')', '}', ']', '>'];
$points = [
 ')' => 3,
 ']' => 57,
 '}' => 1197,
 '>' => 25137,
];

$score = 0;
$corrupted  = 0;
$incomplete = [];

foreach($input as $line) {
  $stack = []; // this syntax won't be confusing at all
  foreach(str_split($line) as $c) {
    if (in_array($c, $open)) {
      $stack[] = $c;
    }else{
      if (end($stack) == $open[array_search($c, $close)]) {
        array_pop($stack);
      }else{
        $score += $points[$c]; // corrupt
        $corrupted++;
        $stack = [];
        break;
      }
    }
  } // end line
  // if there's items left on the stack, the line was incomplete since we emptied the corrupt stacks
  // turns out we needed this for B, yay
  if (count($stack)) {
    $incompletes[] = array_reverse(str_replace($open, $close, $stack));
  }
}
echo "10A, input lines: ". count($input) .", $corrupted corrupted lines, score: $score\n";
echo count($incompletes) ." incompleted lines left.\n";

// 10B
$points = [')' => 1, ']' => 2, '}' => 3, '>' => 4];
$scores = [];
foreach($incompletes as $tail) {
  $score = 0;
  foreach($tail as $c) {
    $score *= 5;
    $score += $points[$c];
  }
  $scores[] = $score;
}
sort($scores);
echo "10B: ". $scores[floor(count($scores)/2)]."\n";
