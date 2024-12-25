lines = open('input.txt').read().split('\n\n')

def parse_lock(lines):
    lines = lines.split('\n')
    result = [-1 for _ in lines[0]]
    for line in lines:
        for x, c in enumerate(line):
            if c == '#':
                result[x] += 1
    return result

def lock_key_overlap(lock, key):
    for i in range(len(lock)):
        if lock[i] + key[i] > 5:
            return False
    return True

locks = []
keys = []
for line in lines:
    if line[0] == '#':
        locks.append(parse_lock(line))
    else:
        keys.append(parse_lock(line))

result = 0
for lock in locks:
    for key in keys:
        if lock_key_overlap(lock, key):
            result += 1

print(result)
