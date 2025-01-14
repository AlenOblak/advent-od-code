lines = open('input.txt').read().split('\n')

cups = list(map(int,list(lines[0])))

# part 1
def play():
    global cups_list, position, max_cup
    next_cup = position - 1
    pick_up_cups = [cups_list[position], cups_list[cups_list[position]], cups_list[cups_list[cups_list[position]]]]
    while next_cup in pick_up_cups or next_cup < 1:
        if next_cup < 1:
            next_cup = max_cup
        else:
            next_cup = next_cup - 1
    next_position = cups_list[pick_up_cups[2]]
    cups_list[pick_up_cups[2]] = cups_list[next_cup]
    cups_list[next_cup] = pick_up_cups[0]
    cups_list[position] = next_position
    position = next_position

def cups_order():
    print_list = []
    curr = cups_list[1]
    while curr != 1:
        print_list.append(curr)
        curr = cups_list[curr]
    return ''.join(map(str, print_list))

cups_list = dict()
for i in range(len(cups)-1):
    cups_list[cups[i]] = cups[i+1]
cups_list[cups[-1]] = cups[0]

position = cups[0]
max_cup = max(cups)
for _ in range(100):
    play()
print(cups_order())

# part 2
cups_list = dict()
for i in range(len(cups)-1):
    cups_list[cups[i]] = cups[i+1]
max_cup = len(cups_list) + 2
cups_list[cups[-1]] = max_cup
for i in range(max_cup, 1000000):
    cups_list[i] = i + 1
max_cup = len(cups_list) + 1
cups_list[max_cup] = cups[0]

position = cups[0]
for _ in range(10000000):
    play()
print(cups_list[1] * cups_list[cups_list[1]])