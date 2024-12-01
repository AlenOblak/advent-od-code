lines = open('input.txt').read().splitlines()

cubes = []
cubes_4d = []
for y, line in enumerate(lines):
    for x in range(len(line)):
        if line[x] == '#':
            cubes.append((x, y, 0))
            cubes_4d.append((x, y, 0, 0))

# part 1
def new_cycle(cubes):
    neighbours = {}
    for y, x, z in cubes:
        for i in range(-1, 2):        
            for j in range(-1, 2):        
                for k in range(-1, 2):        
                    if i != 0 or j != 0 or k != 0:
                        if f'{y+i} {x+j} {z+k}' not in neighbours:
                            neighbours[f'{y+i} {x+j} {z+k}'] = 1
                        else:
                            neighbours[f'{y+i} {x+j} {z+k}'] = neighbours[f'{y+i} {x+j} {z+k}'] + 1

    new_cubes = []
    for cube in neighbours.keys():
        c = cube.split(' ')
        c = list(map(int, c))
        if (c[0], c[1], c[2]) in cubes and f'{c[0]} {c[1]} {c[2]}' in neighbours and 2 <= neighbours[f'{c[0]} {c[1]} {c[2]}'] <= 3:
            new_cubes.append((c[0], c[1], c[2]))
        elif (c[0], c[1], c[2]) not in cubes and f'{c[0]} {c[1]} {c[2]}' in neighbours and neighbours[f'{c[0]} {c[1]} {c[2]}'] == 3:
            new_cubes.append((c[0], c[1], c[2]))
    
    return new_cubes

for i in range(6):
    cubes = new_cycle(cubes)
print(len(cubes))

# part 2
def new_cycle_4d(cubes):
    neighbours = {}
    for y, x, z, w in cubes:
        for i in range(-1, 2):
            for j in range(-1, 2):
                for k in range(-1, 2):
                    for l in range(-1, 2):
                        if i != 0 or j != 0 or k != 0 or l != 0:
                            if f'{y + i} {x + j} {z + k} {w + l}' not in neighbours:
                                neighbours[f'{y + i} {x + j} {z + k} {w + l}'] = 1
                            else:
                                neighbours[f'{y + i} {x + j} {z + k} {w + l}'] = neighbours[f'{y + i} {x + j} {z + k} {w + l}'] + 1

    new_cubes = []
    for cube in neighbours.keys():
        c = cube.split(' ')
        c = list(map(int, c))
        if (c[0], c[1], c[2], c[3]) in cubes and f'{c[0]} {c[1]} {c[2]} {c[3]}' in neighbours and 2 <= neighbours[f'{c[0]} {c[1]} {c[2]} {c[3]}'] <= 3:
            new_cubes.append((c[0], c[1], c[2], c[3]))
        elif (c[0], c[1], c[2], c[3]) not in cubes and f'{c[0]} {c[1]} {c[2]} {c[3]}' in neighbours and neighbours[f'{c[0]} {c[1]} {c[2]} {c[3]}'] == 3:
            new_cubes.append((c[0], c[1], c[2], c[3]))

    return new_cubes

for i in range(6):
    cubes_4d = new_cycle_4d(cubes_4d)
print(len(cubes_4d))
