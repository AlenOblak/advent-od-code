lines = open('input.txt').read().splitlines()

list1 = []
list2 = []

for line in lines:
    line = line.split('   ')
    list1.append(int(line[0]))
    list2.append(int(line[1]))

# part 2
result_2 = 0
for e1 in list1:
    result_2 += e1 * list2.count(e1)

# part 1
list1.sort()
list2.sort()
result_1 = 0
while len(list1) > 0:
    e1 = list1.pop(0)
    e2 = list2.pop(0)
    result_1 += abs(e1 - e2)
print(result_1)
print(result_2)