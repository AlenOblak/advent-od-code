lines = open('input.txt').read().splitlines()

grid = []
for line in lines:
    grid.append(list(line))

# part 1
def is_xmas(x, y):
    count = 0
    if x < max_x and grid[x][y] == 'X' and grid[x + 1][y] == 'M' and grid[x + 2][y] == 'A' and grid[x + 3][y] == 'S':
        count += 1
    if (y < max_y and x < max_x and grid[x][y] == 'X' and grid[x + 1][y + 1] == 'M' and grid[x + 2][y + 2] == 'A' 
            and grid[x + 3][y + 3] == 'S'):
        count += 1
    if y < max_y and grid[x][y] == 'X' and grid[x][y + 1] == 'M' and grid[x][y + 2] == 'A' and grid[x][y + 3] == 'S':
        count += 1
    if (y > 2 and x > 2 and grid[x][y] == 'X' and grid[x - 1][y - 1] == 'M' and grid[x - 2][y - 2] == 'A' 
            and grid[x - 3][y - 3] == 'S'):
        count += 1
    if x > 2 and grid[x][y] == 'X' and grid[x - 1][y] == 'M' and grid[x - 2][y] == 'A' and grid[x - 3][y] == 'S':
        count += 1
    if y > 2 and grid[x][y] == 'X' and grid[x][y - 1] == 'M' and grid[x][y - 2] == 'A' and grid[x][y - 3] == 'S':
        count += 1
    if (y > 2 and x < max_x and grid[x][y] == 'X' and grid[x + 1][y - 1] == 'M' and grid[x + 2][y - 2] == 'A' 
            and grid[x + 3][y - 3] == 'S'):
        count += 1
    if (y < max_y and x > 2 and grid[x][y] == 'X' and grid[x - 1][y + 1] == 'M' and grid[x - 2][y + 2] == 'A' 
            and grid[x - 3][y + 3] == 'S'):
        count += 1
    return count

result = 0
max_x = len(grid) - 3
max_y = len(grid[0]) - 3
for x in range(len(grid)):
    for y in range(len(grid[0])):
        result += is_xmas(x, y)

print(result)

# part 2
def is_mas(x, y):
    count = 0
    if (y < max_y and x < max_x and grid[x][y] == 'M' and grid[x + 1][y + 1] == 'A' and grid[x + 2][y + 2] == 'S'
            and ((grid[x][y+2] == 'M' and grid[x+2][y] == 'S') or (grid[x+2][y] == 'M' and grid[x][y+2] == 'S'))):
        count += 1
    if (y > 1 and x > 1 and grid[x][y] == 'M' and grid[x - 1][y - 1] == 'A' and grid[x - 2][y - 2] == 'S'
            and ((grid[x][y-2] == 'M' and grid[x-2][y] == 'S') or (grid[x-2][y] == 'M' and grid[x][y-2] == 'S'))):
        count += 1
    if (y > 1 and x < max_x and grid[x][y] == 'M' and grid[x + 1][y - 1] == 'A' and grid[x + 2][y - 2] == 'S' 
            and ((grid[x][y - 2] == 'M' and grid[x + 2][y] == 'S') or (grid[x + 2][y] == 'M' and grid[x][y - 2] == 'S'))):
        count += 1
    if (y < max_y and x > 1 and grid[x][y] == 'M' and grid[x - 1][y + 1] == 'A' and grid[x - 2][y + 2] == 'S' 
            and ((grid[x][y + 2] == 'M' and grid[x - 2][y] == 'S') or (grid[x - 2][y] == 'M' and grid[x][y + 2] == 'S'))):
        count += 1
    return count

result = 0
max_x = len(grid) - 2
max_y = len(grid[0]) - 2
for x in range(len(grid)):
    for y in range(len(grid[0])):
        result += is_mas(x, y)

print(int(result / 2))