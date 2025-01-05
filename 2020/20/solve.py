lines = open('input.txt').read().split('\n\n')

tile_edges = dict()
tiles = dict()
for line in lines:
    line = line.split('\n')
    tile_num = int(line[0][5:9])
    l1 = line[1]
    l2 = line[10]
    l3 = l4 = ''
    for l in line[1:]:
        l3 += l[0]
        l4 += l[-1]
    tile_edges[tile_num] = [l1, l2, l3, l4, l1[::-1], l2[::-1], l3[::-1], l4[::-1]]
    tiles[tile_num] = [line[i] for i in range(1, 11)]

# part 1
result = []
for tile_num in tile_edges:
    count = 0
    for t in tile_edges[tile_num][:4]:
        for tile_num_2 in tile_edges:
            if tile_num == tile_num_2:
                continue
            if t in tile_edges[tile_num_2]:
                count += 1
    if count == 2:
        result.append(tile_num)

print(result[0] * result[1] * result[2] * result[3])

# part 2
def add_tile_to_grid(tile_num, x, y):
    tile = tiles[tile_num]
    start_x = x * 8
    start_y = y * 8
    for i in range(1, 9):
        for j in range(1, 9):
            grid[start_x + i - 1][start_y + j - 1] = tile[i][j]
    tile_grid[x][y] = tile_num

def prepare_first_tile(tile_num):
    edges = list()
    for i, t in enumerate(tile_edges[tile_num][:4]):
        for tile_num_2 in tile_edges:
            if tile_num == tile_num_2:
                continue
            if t in tile_edges[tile_num_2]:
                edges.append(i)
    if 0 in edges:
        flip_up_down(tile_num)
    if 2 in edges:
        flip_left_right(tile_num)

def flip_up_down(tile_num):
    tiles[tile_num] = [l for l in tiles[tile_num][::-1]]
    calc_tile_edges(tile_num)
    
def flip_left_right(tile_num):
    tiles[tile_num] = [l[::-1] for l in tiles[tile_num]]
    calc_tile_edges(tile_num)

def calc_tile_edges(tile_num):
    l1 = tiles[tile_num][0]
    l2 = tiles[tile_num][9]
    l3 = l4 = ''
    for l in tiles[tile_num]:
        l3 += l[0]
        l4 += l[-1]
    tile_edges[tile_num] = [l1, l2, l3, l4, l1[::-1], l2[::-1], l3[::-1], l4[::-1]]

def rotate_left(tile_num):
    new_tile = ['' for _ in range(10)]
    for l in tiles[tile_num]:
        for i, c in enumerate(l):
            new_tile[9 - i] = new_tile[9 - i] + c
    tiles[tile_num] = new_tile
    calc_tile_edges(tile_num)

def rotate_right(tile_num):
    rotate_left(tile_num)
    rotate_left(tile_num)
    rotate_left(tile_num)

def find_and_prepare_tile(x, y):
    if y > 0:
        # match with left tile
        left_tile = tile_grid[x][y-1]
        edge = tile_edges[left_tile][3]
        for tile_num2, edges in tile_edges.items():
            if tile_num2 != left_tile and edge in edges:
                edge_pos = edges.index(edge)
                if edge_pos == 0:
                    rotate_left(tile_num2)
                    flip_up_down(tile_num2)
                elif edge_pos == 1:
                    rotate_right(tile_num2)
                elif edge_pos == 2:
                    pass
                elif edge_pos == 3:
                    flip_left_right(tile_num2)
                elif edge_pos == 4:
                    rotate_left(tile_num2)
                elif edge_pos == 5:
                    rotate_right(tile_num2)
                    flip_up_down(tile_num2)
                elif edge_pos == 6:
                    flip_up_down(tile_num2)
                elif edge_pos == 7:
                    flip_left_right(tile_num2)
                    flip_up_down(tile_num2)
                return tile_num2
    else:
        # match with upper tile
        upper_tile = tile_grid[x-1][y]
        edge = tile_edges[upper_tile][1]
        for tile_num2, edges in tile_edges.items():
            if tile_num2 != upper_tile and edge in edges:
                edge_pos = edges.index(edge)
                if edge_pos == 0:
                    pass
                elif edge_pos == 1:
                    flip_up_down(tile_num2)
                elif edge_pos == 2:
                    rotate_left(tile_num2)
                    flip_up_down(tile_num2)
                elif edge_pos == 3:
                    rotate_left(tile_num2)
                elif edge_pos == 4:
                    flip_left_right(tile_num2)
                elif edge_pos == 5:
                    flip_left_right(tile_num2)
                    flip_up_down(tile_num2)
                elif edge_pos == 6:
                    rotate_right(tile_num2)
                elif edge_pos == 7:
                    rotate_left(tile_num2)
                    flip_left_right(tile_num2)
                return tile_num2

def grid_to_list(grid):
    list = []
    for x in range(len(grid)):
        for y in range(len(grid[x])):
            if grid[x][y] == '#':
                list.append((x, y))
    return list

def flip_grid_up_down(grid):
    grid = [l for l in grid[::-1]]
    return grid

def flip_grid_left_right(grid):
    grid = [l[::-1] for l in grid]
    return grid

def rotate_grid_left(grid):
    new_len = len(grid[0])
    new_grid = ['' for _ in range(new_len)]
    for l in grid:
        for i, c in enumerate(l):
            new_grid[new_len - 1 - i] = new_grid[new_len - 1 - i] + c
    return new_grid

def search_sea_monster(monster_grid):
    monster_count = 0
    monster = grid_to_list(monster_grid)
    rocks = grid_to_list(grid)
    max_x = max_y = 0
    for x, y in monster:
        max_x = max(max_x, x)
        max_y = max(max_y, y)
    for x in range(len(grid) - max_x):
        for y in range(len(grid[0]) - max_y):
            monster_matches = 0
            for dx, dy in monster:
                if grid[x + dx][y + dy] == '#':
                    monster_matches += 1
            if monster_matches == 15:
                monster_count += 1
                for dx, dy in monster:
                    rocks.remove((x + dx, y + dy))
    return monster_count, len(rocks)

def search_sea_monster_in_all_directions():
    monster_grids = []
    monster_grid = ['                  # ', '#    ##    ##    ###', ' #  #  #  #  #  #   ']
    
    # original monster
    monster_grids.append(monster_grid)
    # flip monster up down
    monster_grid = flip_grid_up_down(monster_grid)
    monster_grids.append(monster_grid)
    # flip monster left right
    monster_grid = flip_grid_left_right(monster_grid)
    monster_grids.append(monster_grid)
    # flip monster up down
    monster_grid = flip_grid_up_down(monster_grid)
    monster_grids.append(monster_grid)
    # rotate monster left
    monster_grid = rotate_grid_left(monster_grid)
    monster_grids.append(monster_grid)
    # flip monster left right
    monster_grid = flip_grid_left_right(monster_grid)
    monster_grids.append(monster_grid)
    # flip monster up down
    monster_grid = flip_grid_up_down(monster_grid)
    monster_grids.append(monster_grid)
    # flip monster left right
    monster_grid = flip_grid_left_right(monster_grid)
    monster_grids.append(monster_grid)

    for g in monster_grids:
        num_monsters, rocks = search_sea_monster(g)
        if num_monsters > 0:
            return rocks

# construct the grid
grid = [[None for i in range(8 * 12)] for j in range(8 * 12)]
tile_grid = [[None for i in range(12)] for j in range(12)]
x = y = 0
# take first corner tile, rotate it properly and add to the grid
prepare_first_tile(result[0])
add_tile_to_grid(result[0], x, y)
# add the rest of the tiles to the grid
for x in range(12):
    for y in range(12):
        if x != 0 or y != 0:
            tile_num = find_and_prepare_tile(x, y)
            add_tile_to_grid(tile_num, x, y)

# search for sea monsters in the grid
print(search_sea_monster_in_all_directions())