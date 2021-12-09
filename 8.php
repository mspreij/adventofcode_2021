<?php

$input = trim(file_get_contents('8.txt'));

$X_input = 'be cfbegad cbdgef fgaecd cgeb fdcge agebfd fecdb fabcd edb | fdgacbe cefdb cefbgd gcbe
edbfga begcd cbg gc gcadebf fbgde acbgfd abcde gfcbed gfec | fcgedb cgb dgebacf gc
fgaebd cg bdaec gdafb agbcfd gdcbef bgcad gfac gcb cdgabef | cg cg fdcagb cbg
fbegcd cbd adcefb dageb afcb bc aefdc ecdab fgdeca fcdbega | efabcd cedba gadfec cb
aecbfdg fbg gf bafeg dbefa fcge gcbea fcaegb dgceab fcbdga | gecf egdcabf bgf bfgea
fgeab ca afcebg bdacfeg cfaedg gcfdb baec bfadeg bafgc acf | gebdcfa ecba ca fadegcb
dbcfg fgd bdegcaf fgec aegbdf ecdfab fbedc dacgb gdcebf gf | cefg dcbef fcge gbcadfe
bdfegc cbegaf gecbf dfcage bdacg ed bedf ced adcbefg gebcd | ed bcgafe cdgba cbgef
egadfb cdbfeg cegd fecab cgb gbdefca cg fgcdab egfdb bfceg | gbdfcae bgc cg cgb
gcafb gcf dcaebfg ecagb gf abcdeg gaef cafbge fdbac fegbdc | fgae cfgab fg bagce';

$lines = explode("\n", $input);

/**
 * I am very, very sorry for the mess. :-|
**/

$foo = 0;

// 8A
foreach($lines as $line) {
  list($digits, $display) = explode(' | ', $line);
  $digits = explode(' ', $digits);
  $display = explode(' ', $display);
  foreach($display as $nixieTube) { // Appreciate that variable name, it took me ages to find!
    if (in_array(strlen($nixieTube), [2, 3, 4, 7])) $foo++;
  }
}
echo "8A: $foo\n";

$foo = 0;
// 8B (no one saw THIS part coming!)
foreach($lines as $line) {
  list($digits, $display) = explode(' | ', $line);
  $digits = explode(' ', $digits);
  $display = explode(' ', $display);
  $map = map($digits);
  $output = map_to_num($map, $display);
  $foo += $output;
}

echo "8B: $foo\n";

function map($fairies) {
  // create a map of [abcde => 5, ...]
  // sort them /all/ and do substring magic lookups, after
  foreach ($fairies as $i => $fairy) {
    $fairy = str_split($fairy);
    sort($fairy); // am I retarded or is there no shorter way to char-sort an array of items?
    $fairies[$i] = join('', $fairy); // I did *not* spend about an hour misspelling this and wondering why it didn't work. For the record.
  }
  foreach ($fairies as $fairy) {
    if (strlen($fairy) === 2) $num[1] = $fairy;
    if (strlen($fairy) === 3) $num[7] = $fairy;
    if (strlen($fairy) === 4) $num[4] = $fairy;
    if (strlen($fairy) === 7) $num[8] = $fairy;
  }
  $top = current(array_diff(str_split($num[7]), str_split($num[1])));
  $sixes = array_filter($fairies, fn($s) => strlen($s) == 6);
  foreach($sixes as $fairy) {
    $glitter = str_split($fairy);
    $diff = array_diff($glitter, str_split($num[4].$top));
    if (count($diff) === 1) {
      $bottom = current($diff);
      $num[9] = $fairy;
    }
    $diff = array_diff(str_split($num[1]), $glitter);
    if ($diff) $num[6] = $fairy;
  }
  $num[0] = current(array_diff($sixes, $num)); // 2, 3, 5 to go
  $fives = array_filter($fairies, fn($s) => strlen($s) == 5);
  foreach($fives as $fairy) {
    $glitter = str_split($fairy);
    if (! array_diff(str_split($num[1]), $glitter)) {
      $num[3] = $fairy;
    }elseif(count(array_diff(str_split($num[4]), $glitter)) === 2) {
      $num[2] = $fairy;
    }else{
      $num[5] = $fairy;
    }
  }
  return $num;
}

function map_to_num($map, $display) {
  $map = array_flip($map);
  $num = '';
  foreach($display as $str) {
    $chars = str_split($str);
    sort($chars);
    $num .= $map[join('', $chars)];
  }
  return $num;
}
