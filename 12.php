<?php

// Look. Underwater cave exploring is seriously one of _the_ most risky activities. And these want recursion?? Madness!

$input = file('12.txt', FILE_IGNORE_NEW_LINES);

$input = explode("\n", 'start-A
start-b
A-c
A-b
b-d
A-end
b-end');
$xinput = explode("\n", 'dc-end
HN-start
start-kj
dc-start
dc-HN
LN-dc
HN-end
kj-sa
kj-HN
kj-dc');
$xinput = explode("\n", 'fs-end
he-DX
fs-he
start-DX
pj-DX
end-zg
zg-sl
zg-pj
pj-he
RW-he
fs-DX
pj-RW
zg-RW
start-pj
he-WI
zg-he
pj-fs
start-RW');

// lines are connections between nodes.
// nodes are "start", "end", [A-Z]{2} or [a-z]{2}
// uppercase nodes can be passed multiple times, lowercase only _once_ (or, in B, twice one single time)
// there are no uppercase connecting to uppercase so bouncing around shouldn't be possible

// create a "map" n
foreach($input as $line) {
  list($a, $b) = explode('-', $line);
  $n[$a][] = $b;
  $n[$b][] = $a; // since the order of nodes is arbitrary both in traversing and the input list, add each way
}

$routes = [];

curses('start');
echo "12A: ".count($routes)." routes\n";
$routes = [];

$count = 0; // fuck routes o.o

curses2('start');
echo "12B: $count routes\n";
// foreach($routes as $route) echo join(',', $route['nodes'])."\n";

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

function curses2($node, $route_so_far = []) {
  global $n, $count;
  $route = $route_so_far;
  $route['nodes'][] = $node; // we're here, so we can add it
  echo "($node) ". join(',', $n[$node])."\n";
  foreach($n[$node] as $next) {
    if ($next === 'end') {
      echo "\n".join(',', $route['nodes']).",end\n";
      $count++; // this is the end
    }elseif ($next === 'start') {
      echo '-';
      continue; // been there, done that
    }elseif (ctype_upper($next)) { // if it's uppercase, fine, go ahead
      curses2($next, $route);
    }else{
      if (! in_array($next, $route['nodes'])) {
        curses2($next, $route); // deeeeper
      }elseif (empty($route['been'])) {
        $route['been'] = $next;
        curses2($next, $route); // we need to go deeper
      }
    }
  }
  echo '---';
}
