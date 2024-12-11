from collections import defaultdict

numbers = open('input.txt').read().split(' ')

numbers = list(map(int, numbers))
stones = dict(zip(numbers, [1 for i in range(len(numbers))]))

def blink():
    global stones
    new_stones = defaultdict(int)
    for stone, count in stones.items():
        if stone == 0:
            new_stones[1] += count
        elif len(str(stone)) % 2 == 0:
            mid = int((len(str(stone)))/2)
            new_stones[int(str(stone)[:mid])] += count
            new_stones[int(str(stone)[mid:])] += count
        else:
            new_stones[stone * 2024] += count
    stones = new_stones

# part 1 & 2
for i in range(1, 76):
    blink()
    if i in (25, 75):
        print(sum(stones.values()))