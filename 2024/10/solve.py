lines = open('input.txt').read().split('\n')

map = [list(line) for line in lines]
max_x = len(map[0])
max_y = len(map)

def get_positions(x, y, height):

    if height == 9 and map[x][y] == '9':
        positions.append((x, y))

    next_height = str(height + 1)
    if x > 0 and map[x-1][y] == next_height:
        get_positions(x - 1, y, height + 1)
    if x < max_x - 1 and map[x+1][y] == next_height:
        get_positions(x + 1, y, height + 1)
    if y > 0 and map[x][y-1] == next_height:
        get_positions(x, y - 1, height + 1)
    if y < max_y -1 and map[x][y+1] == next_height:
        get_positions(x, y + 1, height + 1)

result1 = result2 = 0
for x in range(max_x):
    for y in range(max_y):
        if map[x][y] == '0':
            positions = []
            get_positions(x, y, 0)
            result1 += len(list(set(positions)))
            result2 += len(positions)
print(result1)
print(result2)