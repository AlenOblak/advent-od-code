lines = open('input.txt').read().split("\n")

# part 1 and 2 combined
numbers = list(map(int, lines[0].split(",")))
spoken = {}
step = 1
last_number = None
for i in range(len(numbers)):
    spoken[numbers[i]] = [step]
    last_number = numbers[i]
    step += 1

while step <= 30000000:
    if last_number in spoken and len(spoken[last_number]) != 1:
        last_number = spoken[last_number][-1] - spoken[last_number][-2]
    else:
        last_number = 0

    if last_number in spoken:
        spoken[last_number].append(step)
    else:
        spoken[last_number] = [step]
    
    if step == 2020:
        print(last_number)
    step += 1

print(last_number)