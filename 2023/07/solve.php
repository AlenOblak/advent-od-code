<?php

$lines = file('input.txt', FILE_IGNORE_NEW_LINES);

$cards = array();
foreach ($lines as $line)
    $cards[] = explode(' ', $line);

// part 1
$card_map = array('A', 'K', 'Q', 'J', 'T', '9', '8', '7', '6', '5', '4', '3', '2');
$card_values = array('A' => 14, 'K' => 13, 'Q' => 12, 'J' => 11, 'T' => 10);
$jolly_card = '';
uasort($cards, "card_compare");
$sum = 0;
$i = 1;
foreach ($cards as $card)
    $sum += $i++ * $card[1];
echo $sum."\n";

// part 2
$card_map = array('A', 'K', 'Q', 'T', '9', '8', '7', '6', '5', '4', '3', '2');
$card_values = array('A' => 14, 'K' => 13, 'Q' => 12, 'J' => 1, 'T' => 10);
$jolly_card = 'J';
uasort($cards, "card_compare");
$sum = 0;
$i = 1;
foreach ($cards as $card)
    $sum += $i++ * $card[1];
echo $sum."\n";

// comparing functions
function card_compare($card1, $card2) {
    global $jolly_card;
    if($jolly_card == '') {
        $rank1 = card_rank1($card1[0]);
        $rank2 = card_rank1($card2[0]);
    } else {
        $rank1 = card_rank2($card1[0]);
        $rank2 = card_rank2($card2[0]);
    }

    if($rank1 > $rank2)
        return 1;
    if($rank1 < $rank2)
        return -1;
    for($i = 0; $i < 5; $i++) {
        $res = highest_card(substr($card1[0], $i, 1), substr($card2[0], $i, 1));
        if($res != 0)
            return $res;
    }
    return 0;
};

function highest_card($card1, $card2) {
    global $card_values;
    if(!is_numeric($card1))
        $card1 = $card_values[$card1];
    if(!is_numeric($card2))
        $card2 = $card_values[$card2];
    if($card1 > $card2)
        return 1;
    if($card1 < $card2)
        return -1;
    return 0;
}

// comparison functions for part 1
function card_rank1($card) {
    global $card_map;
    $map = array();
    foreach ($card_map as $c)
        $map[$c] = substr_count($card, $c);
    rsort($map);

    if($map[0] == 5)
        return 7;
    if($map[0] == 4)
        return 6;
    if($map[0] == 3 && $map[1] == 2)
        return 5;
    if($map[0] == 3)
        return 4;
    if($map[0] == 2 && $map[1] == 2)
        return 3;
    if($map[0] == 2)
        return 2;
    return 1;
}

// comparison functions for part 2
function card_rank2($card) {
    global $card_map;
    $map = array();
    foreach ($card_map as $c)
        $map[$c] = substr_count($card, $c);
    rsort($map);
    $jolly = substr_count($card, 'J');

    if($map[0] + $jolly == 5)
        return 7;
    if($map[0] + $jolly == 4)
        return 6;
    if($map[0] + $jolly == 3 && $map[1] == 2)
        return 5;
    if($map[0] + $jolly == 3)
        return 4;
    if($map[0] + $jolly == 2 && $map[1] == 2)
        return 3;
    if($map[0] + $jolly == 2)
        return 2;
    return 1;
}