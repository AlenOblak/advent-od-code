<?

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// part 1
foreach($lines as $line) {
	$c1 = explode('-', $line);
	$caves[$c1[0]][] = $c1[1];
	$caves[$c1[1]][] = $c1[0];
}

$all_paths = 0;
$paths[] = array('start');
while(count($paths) > 0) {
	$path = array_pop($paths);
	foreach($caves[$path[count($path)-1]] as $next) {
		if($next == 'start')
			continue;
		if($next == 'end') {
			$all_paths++;
			continue;
		}
		if(ctype_lower($next) && in_array($next, $path))
			continue;
		$paths[] = array_merge($path, array($next));
	}
}
	
echo $all_paths."\n";

// part 2

$chosen_cave = '';
foreach($caves as $cave => $p) {
	if($cave != 'start' && $cave != 'end' && ctype_lower($cave))
	{
		$chosen_cave = $cave;
		$all_paths = array();
		$paths[] = array('start');
		while(count($paths) > 0) {
			$path = array_pop($paths);
			foreach($caves[$path[count($path)-1]] as $next) {
				if($next == 'start')
					continue;
				if($next == 'end') {
					$all_paths[] = array_merge($path, array($next));					
					continue;
				}
				if(ctype_lower($next) && $next != $chosen_cave && in_array($next, $path))
					continue;
				if(ctype_lower($next) && $next == $chosen_cave && count(array_keys($path, $next)) > 1)
					continue;
				$paths[] = array_merge($path, array($next));
			}
		}
		foreach($all_paths as $path)
			$all_paths2[] = implode(',', $path);
		$all_paths2 = array_unique($all_paths2);
	}
}

echo count($all_paths2)."\n";

?>