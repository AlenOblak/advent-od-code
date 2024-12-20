import copy

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

def get_cheapest_node():
    min_score = None
    min_node = None
    for node in to_check:
        if min_score is None or min_score > node[3]:
            min_score = node[3]
            min_node = node
    to_check.remove(min_node)
    return min_node

def insert_node(node):
    for n in to_check:
        if n[0] == node[0] and n[1] == node[1] and n[2] == node[2]:
            if n[3] < node[3]:
                return
            elif n[3] == node[3]:
                for l in node[4]:
                    if l not in n[4]:
                        n[4].append(l)
            else:
                n[3] = node[3]
                n[4] = node[4]
            return
    if str(node[0]) +'.'+ str(node[1]) +'.'+ node[2] in checked:
        n = checked[str(node[0]) +'.'+ str(node[1]) +'.'+ node[2]]
        if n[0] > node[3]:
            n[0] = node[3]
            n[1] = node[4]
        elif n[0] == node[3]:
            for l in node[4]:
                if l not in n[1]:
                    n[1].append(l)
        return
    to_check.append([node[0], node[1], node[2], node[3], node[4]])

def next_nodes(node):    
    next_node = [node[0], node[1], node[2], node[3], copy.deepcopy(node[4])]
    if node[2] == 'E' or node[2] == 'W':
        next_node[2] = 'S'
        next_node[3] += 1000
        if grid[node[0]+1][node[1]] == '.':
            insert_node(next_node)
        next_node[2] = 'N'
        if grid[node[0]-1][node[1]] == '.':
            insert_node(next_node)
    elif node[2] == 'S' or node[2] == 'N':
        next_node[2] = 'E'
        next_node[3] += 1000
        if grid[node[0]][node[1]+1] == '.':
            insert_node(next_node)
        next_node[2] = 'W'
        if grid[node[0]][node[1]-1] == '.':
            insert_node(next_node)
    next_node = [node[0], node[1], node[2], node[3], [[node[0], node[1], node[2]]]]
    if node[2] == 'E' and grid[node[0]][node[1]+1] == '.':
        next_node[1] += 1
        next_node[3] += 1
        insert_node(next_node)
    elif node[2] == 'W' and grid[node[0]][node[1]-1] == '.':
        next_node[1] -= 1
        next_node[3] += 1
        insert_node(next_node)
    elif node[2] == 'S' and grid[node[0]+1][node[1]] == '.':
        next_node[0] += 1
        next_node[3] += 1
        insert_node(next_node)
    elif node[2] == 'N' and grid[node[0]-1][node[1]] == '.':
        next_node[0] -= 1
        next_node[3] += 1
        insert_node(next_node)

def walk_back(node):
    nodes_to_check = [node[0]]
    nodes_checked = set()
    while nodes_to_check:
        node = nodes_to_check.pop(0)
        nodes_checked.add(str(node[0])+'.'+str(node[1]))
        for n in checked[str(node[0]) +'.'+ str(node[1]) +'.'+ node[2]][1]:
            if n not in nodes_to_check:
                nodes_to_check.append(n)
    return nodes_checked

to_check = [[start[0], start[1], 'E', 0, []]]
checked = {}
result_1 = result_2 = 0
while True:
    node = get_cheapest_node()
    checked[str(node[0])+'.'+str(node[1])+'.'+node[2]] = (node[3], node[4])
    if node[0] == finish[0] and node[1] == finish[1]:
        result_1 = node[3]
        result_2 = walk_back(node[4])
        break
    next_nodes(node)

print(result_1)
print(len(result_2)+1)