<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

// parse input
$modules = array();
foreach ($lines as $line) {
    $line = explode(' -> ', $line);
    $type = 'b';
    if(substr($line[0], 0, 1) == '%')
        $type = '%';
    elseif(substr($line[0], 0, 1) == '&')
        $type = '&';
    $modules[trim($line[0], '%&')] = array($type, explode(', ', $line[1]));
}

// init states
$states = array();
foreach ($modules as $m => $mod) {
    if($mod[0] == '%')
        $states[$m] = 'off';
    foreach ($mod[1] as $next) {
        if(isset($modules[$next]) && $modules[$next][0] == '&')
            $states[$next][$m] = 'low';
        if($next == 'rx')
            $module_before_rx = $m;
    }
}

// find previous modules of module rx
foreach ($modules as $m => $mod)
    foreach ($mod[1] as $next)
        if($next == $module_before_rx)
            $module_before[$m] = 0;

// simulate pulses
$low_count = $high_count = 0;
$i = 1;
while($i++) {
    pulse();
    // part 1
    if($i == 1000)
        $part1 = $low_count * $high_count;
    // part 2
    if(array_product($module_before) > 0)
        break;
}

// output results
echo $part1."\n";
echo array_product($module_before)."\n";

function pulse() {
    global $modules, $states;
    global $low_count, $high_count;
    global $module_before, $i;

    $pulses[] = array('low', 'button', 'broadcaster');
    while(count($pulses)) {
        $pulse = array_shift($pulses);
        if($pulse[0] == 'low')
            $low_count++;
        else
            $high_count++;

        if(isset($modules[$pulse[2]])) {
            if($modules[$pulse[2]][0] == '%' && $pulse[0] == 'low') {
                if($states[$pulse[2]] == 'off') {
                    $states[$pulse[2]] = 'on';
                } else {
                    $states[$pulse[2]] = 'off';
                }
            }
            if($modules[$pulse[2]][0] == '&') {
                $states[$pulse[2]][$pulse[1]] = $pulse[0];
                $new_pulse = 'low';
                foreach ($states[$pulse[2]] as $hist) {
                    if($hist == 'low')
                        $new_pulse = 'high';
                }
            }
            foreach ($modules[$pulse[2]][1] as $next) {
                if($modules[$pulse[2]][0] == 'b') {
                    $pulses[] = array('low', $pulse[2], $next);

                } elseif($modules[$pulse[2]][0] == '%') {
                    if($pulse[0] == 'low') {
                        if($states[$pulse[2]] == 'off') {
                            $pulses[] = array('low', $pulse[2], $next);
                        } else {
                            $pulses[] = array('high', $pulse[2], $next);
                        }
                    }
                } elseif($modules[$pulse[2]][0] == '&') {
                    $pulses[] = array($new_pulse, $pulse[2], $next);

                    if($new_pulse == 'high' && array_key_exists($pulse[2], $module_before) && $module_before[$pulse[2]] == 0)
                        $module_before[$pulse[2]] = $i;
                }
            }
        }
    }
}