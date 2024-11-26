lines = open('input.txt').read().split("\n")

def masked_value(value, mask):
    value = bin(value)[2:].zfill(36)
    result = ''
    for i in range(36):
        if mask[i] == '1' or mask[i] == '0':
            result += mask[i]
        else:
            result += value[i]
    return int(result, 2)

register = {}
for line in lines:
    line = line.split(' = ')
    if line[0] == 'mask':
        mask = line[1]
    else:
        value = int(line[1])
        position = int(line[0][4:-1])
        register[position] = masked_value(value, mask)
print(sum(register.values()))

# part 2
def masked_positions(prefix, position, mask):
    if position == '':
        positions.append(prefix)
    elif mask[0] == '0':
        masked_positions(prefix + position[0], position[1:], mask[1:])
    elif mask[0] == '1':
        masked_positions(prefix + '1', position[1:], mask[1:])
    elif mask[0] == 'X':
        masked_positions(prefix + '0', position[1:], mask[1:])
        masked_positions(prefix + '1', position[1:], mask[1:])

register = {}
positions = []
for line in lines:
    line = line.split(' = ')
    if line[0] == 'mask':
        mask = line[1]
    else:
        value = int(line[1])
        position = bin(int(line[0][4:-1]))[2:].zfill(36)
        positions = []
        masked_positions('', position, mask)
        for p in positions:
           register[int(p, 2)] = value
print(sum(register.values()))
