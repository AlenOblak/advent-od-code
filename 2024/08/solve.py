lines = open('input.txt').read().split('\n')

map = [list(line) for line in lines]
max_x = len(map[0])
max_y = len(map)

antennas = {}
for x, line in enumerate(map):
    for y, char in enumerate(line):
        if char != '.':
            if char in antennas:
                antennas[char].append((x, y))
            else:
                antennas[char] = [(x, y)]

# part 1
nodes = set()
for ant in antennas:
    for a in range(0, len(antennas[ant])-1):
        for b in range(a+1, len(antennas[ant])):
            x1, y1 = antennas[ant][a]
            x2, y2 = antennas[ant][b]
            a1 = x1 - (x2 - x1)
            b1 = y1 - (y2 - y1)
            if a1 >= 0 and b1 >= 0 and a1 < max_x and b1 < max_y:
                nodes.add((a1, b1))
            a1 = x2 + (x2 - x1)
            b1 = y2 + (y2 - y1)
            if a1 >= 0 and b1 >= 0 and a1 < max_x and b1 < max_y:
                nodes.add((a1, b1))
print(len(nodes))

# part 2
nodes = set()
for ant in antennas:
    for a in range(0, len(antennas[ant])-1):
        for b in range(a+1, len(antennas[ant])):
            x1, y1 = antennas[ant][a]
            x2, y2 = antennas[ant][b]
            dx = (x2 - x1)
            dy = (y2 - y1)
            nodes.add((x1, y1))
            nodes.add((x2, y2))
            while True:
                x1 -= dx
                y1 -= dy
                if x1 >= 0 and y1 >= 0 and x1 < max_x and y1 < max_y:
                    nodes.add((x1, y1))
                else:
                    break
            while True:
                x2 += dx
                y2 += dy
                if x2 >= 0 and y2 >= 0 and x2 < max_x and y2 < max_y:
                    nodes.add((x2, y2))
                else:
                    break
print(len(nodes))