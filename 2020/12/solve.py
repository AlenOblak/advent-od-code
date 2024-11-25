lines = open('input.txt').read().split("\n")

# part 1
pos_x, pos_y = 0, 0
direction = 0

for line in lines:
    command, value = line[0], int(line[1:])
    if command == 'N':
        pos_y -= value
    elif command == 'S':
        pos_y += value
    elif command == 'E':
        pos_x += value
    elif command == 'W':
        pos_x -= value
    elif command == 'R':
        direction += value
    elif command == 'L':
        direction -= value
    elif command == 'F':
        while direction >= 360:
            direction -= 360
        while direction < 0:
            direction += 360
        if direction == 270:
            pos_y -= value
        elif direction == 90:
            pos_y += value
        elif direction == 0:
            pos_x += value
        elif direction == 180:
            pos_x -= value
        
print(abs(pos_x) + abs(pos_y))

# part 2
ship_x = ship_y = 0
way_x = 10
way_y = -1

for line in lines:
    command, value = line[0], int(line[1:])
    if command == 'N':
        way_y -= value
    elif command == 'S':
        way_y += value
    elif command == 'E':
        way_x += value
    elif command == 'W':
        way_x -= value
    elif command == 'R':
        while value <= 0:
            value += 360
        while value > 0:
            way_y, way_x = way_x, -way_y
            value -= 90
    elif command == 'L':
        while value <= 0:
            value += 360
        while value > 0:
            way_y, way_x = -way_x, way_y
            value -= 90
    elif command == 'F':
        ship_x += (value * way_x)
        ship_y += (value * way_y)

print(abs(ship_x) + abs(ship_y))