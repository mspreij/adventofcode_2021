<?php

$fishes = explode(',', trim(file_get_contents('6.txt')));
$count  = array_count_values($fishes);

// every day, all the counters decrement, and the counters that reach -1 turn 6 instead, while creating as many 8's
// create a new array for each loop and reassign it at the end, because the keys are out of order etc
for ($i=0;$i<256;$i++) {
	$newCount = array_fill(0, 9, 0); // init all counters here..
	foreach ($count as $decr => $number) {
		$decr--;
		if ($decr == -1) {
			$decr = 6;
			$newCount[8] = $number;
		}
		$newCount[$decr] += $number; // ..so this works! counter 6 has incoming from counters 7 and 0
	}
	$count = $newCount;
}
echo array_sum($count);
