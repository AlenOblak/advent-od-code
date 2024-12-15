lines = open('input.txt').read().split('\n\n')

grid = [list(line) for line in lines[0].split('\n')]
moves = list(''.join(lines[1].split('\n')))
grid_2 = []

bot = []
bot_2 = []
for y, line in enumerate(grid):
    line_2 = ''
    for x, char in enumerate(line):
        if char == '@':
            bot = [y, x]
            bot_2 = [y, x * 2]
            line_2 += '..'
        elif char == 'O':
            line_2 += '[]'
        else:
            line_2 += char + char
    grid_2.append(list(line_2))

def can_move(y, x, dy, dx):
    if grid[y + dy][x + dx] == '.':
        return True
    if grid[y + dy][x + dx] == '#':
        return False
    return can_move(y + dy, x + dx, dy, dx)

def move_boxes(y, x, dy, dx):
    if grid[y][x] == 'O':
        move_boxes(y + dy, x + dx, dy, dx)
        grid[y + dy][x + dx] = 'O'
        grid[y][x] = '.'

def can_move_2(y, x, dy, dx):
    if grid_2[y + dy][x + dx] == '.':
        return True
    if grid_2[y + dy][x + dx] == '#':
        return False
    if dx != 0:
        return can_move_2(y, x + dx, 0, dx)
    elif dy != 0:
        if grid_2[y + dy][x] == '[':
            ddx = 1
        elif grid_2[y + dy][x] == ']':
            ddx = -1
        return can_move_2(y + dy, x, dy, 0) and can_move_2(y + dy, x + ddx, dy, 0) 

def move_boxes_2(y, x, dy, dx):
    if grid_2[y][x] == '.':
        return
    if dx != 0:
        box = grid_2[y][x]
        move_boxes_2(y, x + dx, 0, dx)
        grid_2[y][x + dx] = box
        grid_2[y][x] = '.'
    elif dy != 0:
        if grid_2[y][x] == '[':
            ddx = 1
        else:
            ddx = -1
        move_boxes_2(y + dy, x, dy, 0)
        move_boxes_2(y + dy, x + ddx, dy, 0)
        if ddx == 1:
            grid_2[y + dy][x] = '['
            grid_2[y + dy][x + ddx] = ']'
        else:
            grid_2[y + dy][x] = ']'
            grid_2[y + dy][x + ddx] = '['
        grid_2[y][x] = '.'
        grid_2[y][x + ddx] = '.'

directions = {'<': (-1, 0), '^': (0, -1), '>': (1, 0), 'v': (0, 1)}
while len(moves) > 0:
    move = moves.pop(0)
    dx, dy = directions[move]
    if can_move(bot[0], bot[1], dy, dx):
        bot[0] += dy
        bot[1] += dx
        move_boxes(bot[0], bot[1], dy, dx)
    if can_move_2(bot_2[0], bot_2[1], dy, dx):
        bot_2[0] += dy
        bot_2[1] += dx
        move_boxes_2(bot_2[0], bot_2[1], dy, dx)

result = 0
for y, line in enumerate(grid):
    for x, char in enumerate(line):
        if char == 'O':
            result += 100 * y + x
print(result)

result = 0
for y, line in enumerate(grid_2):
    for x, char in enumerate(line):
        if char == '[':
            result += 100 * y + x
print(result)