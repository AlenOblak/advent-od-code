from xmlrpc.client import MAXINT

lines = open('input.txt').read().split('\n')

grid = [list(line) for line in lines]

start = [0, 0]
finish = [0, 0]
for x, line in enumerate(grid):
    for y, li in enumerate(line):
        if li == 'S':
            start = [x, y]
        elif li == 'E':
            finish = [x, y]
grid[start[0]][start[1]] = '.'
grid[finish[0]][finish[1]] = '.'

max_x = len(grid[0])
max_y = len(grid)
price = [[None for i in range(max_x)] for j in range(max_y)]
visited = [[False for i in range(max_x)] for j in range(max_y)]

def min_price():
    global price, visited, grid
    result = MAXINT
    x_pos, y_pos = None, None
    for x in range(max_x):
        for y in range(max_y):
            if grid[x][y] == '.' and price[x][y] is not None and price[x][y] < result and visited[x][y] is False:
                result = price[x][y]
                x_pos, y_pos = x, y
    return x_pos, y_pos

def next_step(x, y):
    global price, visited, grid
    cur_price = price[x][y]
    if x > 0 and grid[x-1][y] == '.' and (price[x-1][y] is None or price[x-1][y] + 1 > cur_price):
        price[x-1][y] = cur_price + 1
        visited[x-1][y] = False
    if y > 0 and grid[x][y-1] == '.' and (price[x][y-1] is None or price[x][y-1] + 1 > cur_price):
        price[x][y-1] = cur_price + 1
        visited[x][y-1] = False
    if x < max_x and grid[x+1][y] == '.' and (price[x+1][y] is None or price[x+1][y] + 1 > cur_price):
        price[x+1][y] = cur_price + 1
        visited[x + 1][y] = False
    if y < max_y and grid[x][y+1] == '.' and (price[x][y+1] is None or price[x][y+1] + 1 > cur_price):
        price[x][y+1] = cur_price + 1
        visited[x][y+1] = False

def walk_grid():
    global price, visited
    price = [[None for i in range(max_x + 1)] for j in range(max_y + 1)]
    visited = [[False for i in range(max_x + 1)] for j in range(max_y + 1)]
    price[start[0]][start[1]] = 0
    while True:
        x, y = min_price()
        if x is None:
            return None
        if x == finish[0] and y == finish[1]:
            return price[x][y]
        visited[x][y] = True
        next_step(x, y)

result_no_cheat = walk_grid()

path_prices = []
for y in range(1, max_y-1):
    for x in range(1, max_x-1):
        if price[x][y] is not None:
            path_prices.append([x, y, price[x][y]])

# part 1
diff = 100
cheat_time = 2
cheat_blocks_1 = set()
for a in path_prices:
    for b in path_prices:
        distance = abs(a[0] - b[0])+ abs(a[1] - b[1])
        if distance <= cheat_time and (a[2] - b[2] - distance) >= diff:
            cheat_blocks_1.add((a[0], a[1], b[0], b[1]))
print(len(cheat_blocks_1))

# part 2
diff = 100
cheat_time = 20
cheat_blocks_2 = set()
for a in path_prices:
    for b in path_prices:
        distance = abs(a[0] - b[0])+ abs(a[1] - b[1])
        if distance <= cheat_time and (a[2] - b[2] - distance) >= diff:
            cheat_blocks_2.add((a[0], a[1], b[0], b[1]))
print(len(cheat_blocks_2))