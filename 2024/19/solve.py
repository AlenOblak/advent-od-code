from functools import cache

lines = open('input.txt').read().split('\n')

towels = lines[0].split(', ')

@cache
def combinations(pattern):
    num = 0
    for towel in towels:
        if towel == pattern:
            num += 1
        elif pattern[:len(towel)] == towel:
            num += combinations(pattern[len(towel):])
    return num

result_1= result_2 = 0
for pattern in lines[2:]:
    comb = combinations(pattern)
    if comb:
        result_1 += 1
    result_2 += comb

print(result_1)
print(result_2)