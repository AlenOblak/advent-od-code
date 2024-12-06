lines = open('input.txt').read().split('\n')

map = []
start_x = start_y = 0
for i, line in enumerate(lines):
    if '^' in line:
        start_x = i
        start_y = line.index('^')
        line = line.replace('^', '.')
    map.append(list(line))

# part 1
def go_walk(i, j):
    x = start_x
    y = start_y
    direction = 'N'
    visited = set()
    visited.add((x, y))
    visited_dir = set()
    visited_dir.add((x, y, direction))

    while True:
        if direction == 'N':
            if x - 1 < 0:
                break
            elif map[x - 1][y] == '.' and (x-1, y) != (i, j):
                x -= 1
            else:
                direction = 'E'
        elif direction == 'E':
            if y + 1 == len(map[0]):
                break
            elif map[x][y + 1] == '.' and (x, y+1) != (i, j):
                y += 1
            else:
                direction = 'S'
        elif direction == 'S':
            if x + 1 == len(map):
                break
            elif map[x + 1][y] == '.' and (x+1, y) != (i, j):
                x += 1
            else:
                direction = 'W'
        elif direction == 'W':
            if y - 1 < 0:
                break
            elif map[x][y - 1] == '.' and (x, y-1) != (i, j):
                y -= 1
            else:
                direction = 'N'
        if (x, y, direction) in visited_dir:
            return (), True
        visited.add((x, y))
        visited_dir.add((x, y, direction))
    return visited, False

visited, is_loop = go_walk(-1, -1)
print(len(visited))

# part 2
possible_blocks = 0
for (i, j) in visited:
    if map[i][j] == '.':
        v, is_loop = go_walk(i, j)
        if is_loop:
            possible_blocks += 1
print(possible_blocks)