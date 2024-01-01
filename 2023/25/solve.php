<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// parse input
$component = array();
foreach ($lines as $line) {
    $a = explode(': ', $line);
    $component[$a[0]] = explode(' ', $a[1]);
}

$connection = array();
foreach ($component as $a => $comp)
    foreach ($comp as $b) {
        $component[$b][] = $a;
        $connection[] = array($a, $b);
    }

// part 1

// find the most distant nodes
$node_a = find_farthest($connection[0][0]);
$node_b = find_farthest($node_a);

// find three paths between them and remember the connections used
$visited = array();
$path = find_shortest($node_a, $node_b);
for($i = 0; $i < count($path)-1;$i++)
    $visited[] = $path[$i].$path[$i+1];
$path = find_shortest($node_a, $node_b);
for($i = 1; $i < count($path)-1;$i++)
    $visited[] = $path[$i].$path[$i+1];
$path = find_shortest($node_a, $node_b);
for($i = 1; $i < count($path)-1;$i++)
    $visited[] = $path[$i].$path[$i+1];

// count reachable connections from the node without using the remembered connections
$result = count_reachable($node_a);
echo $result * (count($component) - $result)."\n";

function count_reachable($node_a) {
    global $component, $visited;

    $visited_nodes = array();
    $next[] = $node_a;
    while(count($next)) {
        $node = array_shift($next);
        $visited_nodes[] = $node;
        foreach ($component[$node] as $n)
            if(!in_array($n, $next) && !in_array($n, $visited_nodes) && !in_array($node.$n, $visited))
                $next[] = $n;
    }
    return count($visited_nodes);
}

function find_shortest($node_a, $node_b) {
    global $component, $visited;

    $visited_nodes = array();
    $next = array(array($node_a, array($node_a)));
    while(true) {
        $node = array_shift($next);
        if($node[0] == $node_b)
            return $node[1];
        $visited_nodes[$node[0]] = $node[1];
        foreach ($component[$node[0]] as $n)
            if(!array_key_exists($n, $visited_nodes) && !in_array($node[0].$n, $visited))
                $next[] = array($n, array_merge($node[1], array($n)));
    }
}

function find_farthest($start) {
    global $component;

    $visited = array();
    $next[] = $start;
    $last = $start;
    while(count($next)) {
        $node = array_shift($next);
        $last = $node;
        $visited[] = $node;
        foreach ($component[$node] as $n)
            if(!in_array($n, $next) && !in_array($n, $visited))
                $next[] = $n;
    }
    return $last;
}