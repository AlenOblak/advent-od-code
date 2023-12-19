<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$rules = array();
$parts = array();
$sep = false;
foreach ($lines as $line)
    if($line == '') {
        $sep = true;
    } elseif($sep) {
        $line = explode(',', trim($line, '{}'));
        $part = array();
        foreach ($line as $l)
            $part[] = substr($l, 2);
        $parts[] = $part;
    } else {
        $line = explode('{', $line);
        $rules[$line[0]] = explode(',', trim($line[1], '}'));
    }

// part 1
echo array_sum(array_map('calc', $parts))."\n";

function calc($part) {
    global $rules;
    $state = 'in';
    while(true) {
        if($state == 'A')
            return array_sum($part);
        if($state == 'R')
            return 0;
        $rule = $rules[$state];
        foreach ($rule as $r) {
            if(strpos($r, ':')) {
                $r = explode(':', $r);
                if(strpos($r[0], '>')) {
                    $a = explode('>', $r[0]);
                    if($a[0] == 'x' && $a[1] < $part[0]) {
                        $state = $r[1];
                        break;
                    } elseif($a[0] == 'm' && $a[1] < $part[1]) {
                        $state = $r[1];
                        break;
                    } elseif($a[0] == 'a' && $a[1] < $part[2]) {
                        $state = $r[1];
                        break;
                    } elseif($a[0] == 's' && $a[1] < $part[3]) {
                        $state = $r[1];
                        break;
                    }
                } elseif(strpos($r[0], '<')) {
                    $a = explode('<', $r[0]);
                    if($a[0] == 'x' && $a[1] > $part[0]) {
                        $state = $r[1];
                        break;
                    } elseif($a[0] == 'm' && $a[1] > $part[1]) {
                        $state = $r[1];
                        break;
                    } elseif($a[0] == 'a' && $a[1] > $part[2]) {
                        $state = $r[1];
                        break;
                    } elseif($a[0] == 's' && $a[1] > $part[3]) {
                        $state = $r[1];
                        break;
                    }
                }
            } elseif ($r == 'A') {
                return array_sum($part);
            } elseif ($r == 'R') {
                return 0;
            } else {
                $state = $r;
                break;
            }
        }
    }
}

// part 2
$range[] = array('in', 1, 4000, 1, 4000, 1, 4000, 1, 4000);
$sum = 0;
while(count($range)) {
    $ra = array_pop($range);
    if($ra[0] == 'A') {
        $sum += ($ra[2] - $ra[1] + 1) * ($ra[4] - $ra[3] + 1) * ($ra[6] - $ra[5] + 1) * ($ra[8] - $ra[7] + 1);
    } elseif($ra[0] == 'R') {
        $sum += 0;
    } else {
        $rule = $rules[$ra[0]];
        foreach ($rule as $r) {
            if (strpos($r, ':')) {
                $r = explode(':', $r);
                if (strpos($r[0], '>')) {
                    $a = explode('>', $r[0]);
                    if ($a[0] == 'x') {
                        if ($ra[1] > $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $ra[4], $ra[5], $ra[6], $ra[7], $ra[8]);
                        } elseif ($ra[2] > $a[1]) {
                            $range[] = array($r[1], $a[1] + 1, $ra[2], $ra[3], $ra[4], $ra[5], $ra[6], $ra[7], $ra[8]);
                            $ra[2] = $a[1] + 0;
                        }
                    } elseif ($a[0] == 'm') {
                        if ($ra[3] > $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $ra[4], $ra[5], $ra[6], $ra[7], $ra[8]);
                        } elseif ($ra[4] > $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $a[1] + 1, $ra[4], $ra[5], $ra[6], $ra[7], $ra[8]);
                            $ra[4] = $a[1] + 0;
                        }
                    } elseif ($a[0] == 'a') {
                        if ($ra[5] > $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $ra[4], $ra[5], $ra[6], $ra[7], $ra[8]);
                        } elseif ($ra[6] > $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $ra[4], $a[1] + 1, $ra[6], $ra[7], $ra[8]);
                            $ra[6] = $a[1] + 0;
                        }
                    } elseif ($a[0] == 's') {
                        if ($ra[7] > $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $ra[4], $ra[5], $ra[6], $ra[7], $ra[8]);
                        } elseif ($ra[8] > $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $ra[4], $ra[5], $ra[6], $a[1] + 1, $ra[8]);
                            $ra[8] = $a[1] + 0;
                        }
                    }
                } elseif (strpos($r[0], '<')) {
                    $a = explode('<', $r[0]);
                    if ($a[0] == 'x') {
                        if ($ra[2] < $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $ra[4], $ra[5], $ra[6], $ra[7], $ra[8]);
                        } elseif ($ra[1] < $a[1]) {
                            $range[] = array($r[1], $ra[1], $a[1] - 1, $ra[3], $ra[4], $ra[5], $ra[6], $ra[7], $ra[8]);
                            $ra[1] = $a[1] + 0;
                        }
                    } elseif ($a[0] == 'm') {
                        if ($ra[4] < $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $ra[4], $ra[5], $ra[6], $ra[7], $ra[8]);
                        } elseif ($ra[3] < $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $a[1] - 1, $ra[5], $ra[6], $ra[7], $ra[8]);
                            $ra[3] = $a[1] + 0;
                        }
                    } elseif ($a[0] == 'a') {
                        if ($ra[6] < $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $ra[4], $ra[5], $ra[6], $ra[7], $ra[8]);
                        } elseif ($ra[5] < $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $ra[4], $ra[5], $a[1] - 1, $ra[7], $ra[8]);
                            $ra[5] = $a[1] + 0;
                        }
                    } elseif ($a[0] == 's') {
                        if ($ra[8] < $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $ra[4], $ra[5], $ra[6], $ra[7], $ra[8]);
                        } elseif ($ra[7] < $a[1]) {
                            $range[] = array($r[1], $ra[1], $ra[2], $ra[3], $ra[4], $ra[5], $ra[6], $ra[7], $a[1] - 1);
                            $ra[7] = $a[1] + 0;
                        }
                    }
                }
            } else {
                $range[] = array($r, $ra[1], $ra[2], $ra[3], $ra[4], $ra[5], $ra[6], $ra[7], $ra[8]);
            }
        }
    }
}
echo $sum."\n";