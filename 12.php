<?php

// Look. Underwater cave exploring is seriously one of _the_ most risky activities. And these want recursion?? Madness!

$input = file('12.txt', FILE_IGNORE_NEW_LINES);
// lines are connections between nodes.
// nodes are "start", "end", [A-Z]{2} or [a-z]{2}
// uppercase nodes can be passed multiple times, lowercase only _once_
// there are no uppercase connecting to uppercase so bouncing around shouldn't be possible

// create a "map" n
foreach($input as $line) {
  list($a, $b) = explode('-', $line);
  $n[$a][] = $b;
  $n[$b][] = $a; // since the order of nodes is arbitrary both in traversing and the input list, add each way
}

$routes = 0;

curses('start');

echo "12A: $routes routes\n";

function curses($node, $network = []) {
  global $n, $routes;
  
  foreach($n[$node] as $next) {
    if ($next === 'end') {
      $route = $network;
      $route[] = 'end';
      $routes[] = $route; // ok, cool
    }elseif ($next === 'start' or ctype_lower($node) && in_array($node, $network)) {
      continue; // not cool
    }else{
      curses($next, 
    }
  }
}
