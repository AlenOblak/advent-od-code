import re

lines = open('input.txt').read().split('\n')

robots = []
for line in lines:
    robot = list(map(int, re.findall('[-0-9]+', line)))
    robots.append(robot)

max_x = 101
max_y = 103

def move_robot(robot, num):
    if num == 0:
        return robot
    robot[0] += robot[2]
    robot[1] += robot[3]
    if robot[0] < 0:
        robot[0] += max_x
    if robot[1] < 0:
        robot[1] += max_y
    if robot[0] >= max_x:
        robot[0] -= max_x
    if robot[1] >= max_y:
        robot[1] -= max_y
    return move_robot(robot, num-1)

score = [0,0,0,0]
half_x = max_x//2 
half_y = max_y//2 
for robot in robots:
    robot = move_robot(robot, 100)
    if robot[0] < half_x and robot[1] < half_y:
        score[0] += 1
    elif robot[0] < half_x and robot[1] > half_y:
        score[1] += 1
    elif robot[0] > half_x and robot[1] > half_y:
        score[2] += 1
    elif robot[0] > half_x and robot[1] < half_y:
        score[3] += 1

print(score[0] * score[1] * score[2] * score[3])

i = 101
max_score = 300
while i < 10000:
    for robot in robots:
        robot = move_robot(robot, 1)
    score = 0
    for robot in robots:
        if 30 < robot[0] < 75 and 15 < robot[1] < 55:
            score += 1
    if score > max_score:
        print(i)
        break
    i += 1