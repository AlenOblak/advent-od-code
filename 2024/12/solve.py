lines = open('input.txt').read().split('\n')

grid = [list(line) for line in lines]
max_x = len(grid[0])
max_y = len(grid)
visited_grid = [[0 for _ in range(max_x)] for _ in range(max_y)]

def next_unvisited():
    for x in range(max_x):
        for y in range(max_y):
            if visited_grid[x][y] == 0:
                return x, y
    return False, False

def get_area(x, y):
    key = grid[x][y]
    area = [(x, y)]
    visited_grid[x][y] = 1
    unvisited_points = [(x, y)]
    directions = [(0, 1), (0, -1), (1, 0), (-1, 0)]
    while(len(unvisited_points) > 0):
        x, y = unvisited_points.pop()
        for dx, dy in directions:
            if 0 <= x + dx < max_x and 0 <= y + dy < max_y and grid[x + dx][y + dy] == key:
                if (x + dx, y + dy) not in unvisited_points and (x + dx, y + dy) not in area:
                    unvisited_points.append((x + dx, y + dy))
                if (x + dx, y + dy) not in area:
                    area.append((x + dx, y + dy))
                    visited_grid[x + dx][y + dy] = 1
    return area

def area_price_1(area):
    result = 0
    directions = [(0, 1), (0, -1), (1, 0), (-1, 0)]
    for x, y in area:
        result += 4
        for dx, dy in directions:
            if 0 <= x + dx < max_x and 0 <= y + dy < max_y and (x + dx, y + dy) in area:
                result -= 1
    return len(area) * result

def area_price_2(area):
    result = 0
    for x, y in area:
        corners = [[(-1, -1), (0, -1), (-1, 0)], 
                   [(0, -1), (1, -1), (1, 0)], 
                   [(1, 0), (1, 1), (0, 1)], 
                   [(0, 1), (-1, 1), (-1, 0)]]
        for directions in corners:
            point_neighbours = 0
            special_neighbour = 0
            for dx, dy in directions:
                if 0 <= x + dx < max_x and 0 <= y + dy < max_y and (x + dx, y + dy) in area:
                    point_neighbours += 1
                    if abs(dx) + abs(dy) == 2:
                        special_neighbour += 1
            if point_neighbours == 0 or (point_neighbours == 1 and special_neighbour == 1):
                result += 1
            if point_neighbours == 2:
                result += 1/3
    return int(len(area) * round(result))

result_1 = 0
result_2 = 0
while True:
    x, y = next_unvisited()
    if x is False:
        break
    area = get_area(x, y)
    result_1 += area_price_1(area)
    result_2 += area_price_2(area)

print(result_1)
print(result_2)