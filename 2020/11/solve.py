import copy

lines = open('input.txt').read().split("\n")

def seat_in_direction(map, x, y, d_x, d_y, algorithm):
    result = '.'
    step = 1
    while 0 <= x + step * d_x <= max_x and 0 <= y + step * d_y <= max_y:
        if map[y+step*d_y][x+step*d_x] == '#':
            return '#'
        elif map[y+step*d_y][x+step*d_x] == 'L':
            return 'L'
        step += 1
        if algorithm == 1:
            break
    return result

def count_seats(map, x, y, algorithm):
    result = 0
    directions = ((-1,-1), (0, -1), (1, -1), (-1, 0), (1, 0), (-1, 1), (0, 1), (1, 1))
    for (d_x, d_y) in directions:
        if seat_in_direction(map, x, y, d_x, d_y, algorithm) == '#':
            result += 1
    return result

def find_steps(old_map, max_seats, algorithm):
    new_map = copy.deepcopy(old_map)
    change = True
    while change:
        change = False
        for x in range(max_x+1):
            for y in range(max_y+1):
                if old_map[y][x] == '.':
                    new_map[y][x] = '.'
                elif old_map[y][x] == 'L':
                    seats = count_seats(old_map, x, y, algorithm)
                    if seats == 0:
                        new_map[y][x] = '#'
                        change = True
                    else:
                        new_map[y][x] = 'L'
                elif old_map[y][x] == '#':
                    seats = count_seats(old_map, x, y, algorithm)
                    if seats > max_seats:
                        new_map[y][x] = 'L'
                        change = True
                    else:
                        new_map[y][x] = '#'
        old_map = copy.deepcopy(new_map)

    count = 0
    for y in range(max_y + 1):
        count += old_map[y].count('#')
    return count

original_map = list(map(list, lines))
max_x = len(lines[0])-1
max_y = len(lines)-1

# part 1
count = find_steps(copy.deepcopy(original_map), 3, 1)
print(count)

# part 2
count = find_steps(copy.deepcopy(original_map), 4, 2)
print(count)
