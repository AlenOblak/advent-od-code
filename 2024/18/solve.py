from xmlrpc.client import MAXINT

lines = open('input.txt').read().split('\n')

max_x = max_y = 70
grid = [['.' for i in range(max_x + 1)] for j in range(max_y + 1)]
price = [[None for i in range(max_x + 1)] for j in range(max_y + 1)]
visited = [[False for i in range(max_x + 1)] for j in range(max_y + 1)]

start = [0, 0]
finish = [max_x, max_y]

def min_price():
    global price, visited, grid
    result = MAXINT
    x_pos, y_pos = None, None
    for x in range(0, max_x+1 ):
        for y in range(0, max_y+1 ):
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
    price[0][0] = 0
    while True:
        x, y = min_price()
        if x is None:
            return None
        if x == finish[0] and y == finish[1]:
            return price[x][y]
        visited[x][y] = True
        next_step(x, y)

def fill_grid(number):
    global grid
    grid = [['.' for i in range(max_x + 1)] for j in range(max_y + 1)]
    for line in lines:
        x, y = list(map(int, line.split(',')))
        grid[y][x] = '#'
        number -= 1
        if number == 0:
            return

# part 1
fill_grid(1024)
result = walk_grid()
print(result)

# part 2
lower = 1024
upper = len(lines) - 1
while True:
    middle = (lower + upper) // 2
    if middle == lower:
        print(lines[middle])
        break
    fill_grid(middle)
    
    result = walk_grid()
    if result is None:
        upper = middle
    else:
        lower = middle