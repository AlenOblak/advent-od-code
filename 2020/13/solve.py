lines = open('input.txt').read().split("\n")

number = int(lines[0])
buses = lines[1].split(",")

# part 1
buses_num = []
for bus in buses:
    if bus.isnumeric():
        bus = int(bus)
        buses_num.append(bus)

delay = 0
result = 0
while result == 0:
    for bus in buses_num:
        if (number + delay) % bus == 0:
            result = bus * delay
            break
    delay += 1
print(result)

#part 2
buses_num = []
for i, bus in enumerate(buses):
    if bus.isnumeric():
        bus = int(bus)
        buses_num.append([i, bus])

depart = buses_num[0][0]
step = buses_num[0][1]
for i in range(len(buses_num)-1):
    num1 = num2 = None
    while num2 is None:
        if (depart + buses_num[i+1][0]) % buses_num[i+1][1] == 0:
            if i == len(buses_num)-2:
                break
            if num1 is None:
                num1 = depart
            else:
                num2 = depart
                break
        depart += step
    if num1 is not None:
        step = num2 - num1
print(depart)