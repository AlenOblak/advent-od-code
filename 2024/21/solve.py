from functools import cache

lines = open('input.txt').read().split('\n')

keyboard_1 = {'7' : (0,0), '8' : (0,1), '9' : (0,2)
            , '4' : (1,0), '5' : (1,1), '6' : (1,2)
            , '1' : (2,0), '2' : (2,1), '3' : (2,2)
                         , '0' : (3,1), 'A' : (3,2)}

keyboard_2 = {             'U' : (0,1), 'A' : (0,2)
            , 'L' : (1,0), 'D' : (1,1), 'R' : (1,2)}

def keyboard_find_moves(keyboard_type, x, y, char, moves, all_moves):
    if keyboard_type == 1:
        keyboard = keyboard_1
    else:
        keyboard = keyboard_2
    # we arrive at forbidden location
    if (x, y) not in keyboard.values():
        return
    # we are at the right char, just press and get to other chars
    if keyboard[char] == (x, y):
        all_moves.append(moves+'A')
        return
    # one move closer to the char
    (key_x, key_y) = keyboard[char]
    if key_x < x:
        keyboard_find_moves(keyboard_type, x - 1, y, char, moves + 'U', all_moves)
    if key_x > x:
        keyboard_find_moves(keyboard_type, x + 1, y, char, moves + 'D', all_moves)
    if key_y < y:
        keyboard_find_moves(keyboard_type, x, y - 1, char, moves + 'L', all_moves)
    if key_y > y:
        keyboard_find_moves(keyboard_type, x, y + 1, char, moves + 'R', all_moves)

def keyboard_min_moves(keyboard_type, x, y, c, level, max_level):
    all_moves = []
    min_moves = None
    keyboard_find_moves(keyboard_type, x, y, c, '', all_moves)
    for move in all_moves:
        if keyboard_type == 1:
            num_moves = keyboard_total_moves(2, move, level, max_level)
        else:
            num_moves = keyboard_total_moves(2, move, level + 1, max_level)
        if min_moves is None or num_moves < min_moves:
            min_moves = num_moves
    return min_moves

@cache
def keyboard_total_moves(keyboard_type, move, level, max_level):
    if level == max_level:
        return len(move)
    if keyboard_type == 1:
        x, y = 3, 2
    else:
        x, y = 0, 2
    total_moves = 0
    for c in move:
        num_moves = keyboard_min_moves(keyboard_type, x, y, c, level, max_level)
        total_moves += num_moves
        if keyboard_type == 1:
            x, y = keyboard_1[c]
        else:
            x, y = keyboard_2[c]
    return total_moves

# part 1
result = 0
for line in lines:
    result += int(line[:-1]) * keyboard_total_moves(1, line, 0, 2)
print(result)

# part 2
result = 0
for line in lines:
    result += int(line[:-1]) * keyboard_total_moves(1, line, 0, 25)
print(result)