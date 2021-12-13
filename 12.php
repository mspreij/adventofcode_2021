<?php

// Look. Underwater cave exploring is seriously one of _the_ most risky activities. And these want recursion?? Madness!

$input = file('12.txt', FILE_IGNORE_NEW_LINES);

$X_input = explode("\n", 'start-A
start-b
A-c
A-b
b-d
A-end
b-end');

// lines are connections between nodes.
// nodes are "start", "end", [A-Z]{2} or [a-z]{2}
// uppercase nodes can be passed multiple times, lowercase only _once_ (or, in B, twice one single time)
// there are no uppercase connecting to uppercase so bouncing around shouldn't be possible

// create a "map" $n of outputs for each input
foreach($input as $line) {
  list($a, $b) = explode('-', $line);
  $n[$a][] = $b;
  $n[$b][] = $a; // since the order of nodes is arbitrary both in traversing and the input list, add each way
}

// 12 A
$routes = [];
curses('start');
echo "12A: ".count($routes)." routes\n";

// 12 B
$routes = [];
curses2('start');
echo "12B: ".count($routes)." routes\n";

function curses($node, $network = []) {
  global $n, $routes;
  $route = $network;
  $route[] = $node;
  foreach($n[$node] as $next) {
    if ($next === 'end') {
      $route[] = 'end';
      $routes[] = $route; // this is the end
    }elseif ($next === 'start' or ctype_lower($next) && in_array($next, $network)) {
      continue; // been there, done that
    }else{
      curses($next, $route); // we need to go deeper
    }
  }
}


function curses2($node, $network = ['nodes'=>[], 'been'=>'']) {
  global $n, $routes;
  $route = $network;
  $route['nodes'][] = $node; // you are here
  foreach($n[$node] as $next) {
    if ($next === 'end') {
      $route['nodes'][] = 'end';
      $routes[] = $route; // this is the end
    }elseif ($next === 'start') {
      continue; // we could have maybe simply not added this to the map
    }elseif (ctype_lower($next)) { // small cave, have we been here?
       if (in_array($next, $route['nodes'])) {
          if (strlen($route['been'])) { // yes we have, can we go again?
            continue; // no, this or some other small cave has already been visited.
          }else{
            $copy = $route;
            $copy['been'] = $next; // yes, but no more delays!
            curses2($next, $copy);
          }
       }else{ // no, first visit
         curses2($next, $route);
       }
    }else{ // must be a large cave
      curses2($next, $route);
    }
  }
}

