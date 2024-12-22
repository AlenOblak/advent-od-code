lines = open('input.txt').read().split('\n')

def next_secret(number):
    # first
    new_number = 64 * number
    number = number ^ new_number
    number = number % 16777216
    # second
    new_number = number // 32
    number = number ^ new_number
    number = number % 16777216
    # third
    new_number = number * 2048
    number = number ^ new_number
    number = number % 16777216
    return number

# part 1
result_1 = 0
monkeys = []
for line in lines:
    number = int(line)
    monkey = {}
    last_digit = number % 10
    diff = None
    diffs = []
    for i in range(2000):
        number = next_secret(number)
        diff = number % 10 - last_digit
        last_digit = number % 10
        diffs.append(diff)
        if len(diffs) > 4:
            diffs.pop(0)
            if ' '.join(map(str, diffs)) not in monkey:
                monkey[' '.join(map(str, diffs))] = last_digit
    result_1 += number
    monkeys.append(monkey)
    
print(result_1)

# part 2
combs = {}
best_comb = None
for monkey in monkeys:
    for comb in monkey:
        if comb not in combs:
            sum = 0
            for m in monkeys:
                if comb in m:
                    sum += m[comb]
            combs[comb] = sum
        if best_comb is None or combs[comb] > combs[best_comb]:
            best_comb = comb

print(combs[best_comb])