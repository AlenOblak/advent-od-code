import copy

lines = open('input.txt').read().splitlines()

def is_safe(levels):
    if levels[1] < levels[0]:
        direction = 'decreasing'
    else:
        direction = 'increasing'
    for i in range(0, len(levels) - 1):
        if direction == 'decreasing' and not ((levels[i] > levels[i + 1]) and (1 <= abs(levels[i] - levels[i + 1]) <= 3)):
            return False
        if direction == 'increasing' and not ((levels[i] < levels[i + 1]) and (1 <= abs(levels[i] - levels[i + 1]) <= 3)):
            return False
    return True

# part 1
result = 0
for line in lines:
    levels = list(map(int, line.split(' ')))
    if is_safe(levels):
        result += 1
print(result)

# part 2
result = 0
for line in lines:
    levels = list(map(int, line.split(' ')))

    if is_safe(levels):
        result += 1
    else:
        for i in range(0, len(levels)):
            new_levels = copy.deepcopy(levels)
            new_levels.pop(i)
            if is_safe(new_levels):
                result += 1
                break

print(result)