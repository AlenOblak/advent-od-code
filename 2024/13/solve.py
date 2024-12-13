import re

machines = open('input.txt').read().split('\n\n')

def machine_prize(button_a, button_b, position):
    b = position[0] // button_b[0]
    x = b * button_b[0]
    y = b * button_b[1]
    a = 0
    a1 = b1 = da = db = None
    while y != position[1]:
        while x != position[0]:
            if x < position[0]:
                x += button_a[0]
                y += button_a[1]
                a += 1
            else:
                x -= button_b[0]
                y -= button_b[1]
                b -=1
            if b < 0:
                return 0
            if a > 10000:
                return 0
        if a1 is None:
            a1 = a
            b1 = b
        elif da is None:
            da = a - a1
            db = b - b1
        if x == position[0] and y == position[1]:
            return a * 3 + b
        elif b < 0:
            return 0
        elif da is not None:
            break
        else:
            x -= button_b[0]
            y -= button_b[1]
            b -= 1
    dy = da * button_a[1] + db * button_b[1]
    times = (position[1] - y) // dy
    a += da * times
    b += db * times
    y += dy * times
    if x == position[0] and y == position[1]:
        return a * 3 + b
    return 0

prize_1 = 0
prize_2 = 0
for machine in machines:
    lines = machine.splitlines()
    button_a = list(map(int, re.findall('[0-9]+', lines[0])))
    button_b = list(map(int, re.findall('[0-9]+', lines[1])))
    position = list(map(int, re.findall('[0-9]+', lines[2])))
    prize_1 += machine_prize(button_a, button_b, position)
    position[0] += 10000000000000
    position[1] += 10000000000000
    prize_2 += machine_prize(button_a, button_b, position)

print(prize_1)
print(prize_2)