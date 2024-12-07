lines = open('input.txt').read().split('\n')

def solve(value, operands, concat):
    if len(operands) > 1:
        if solve(value / int(operands[-1]), operands[:-1], concat):
            return True
        if solve(value - int(operands[-1]), operands[:-1], concat):
            return True
        if concat and int(str(int(value))) == value and str(int(value)).endswith(operands[-1]):
            rest = str(int(value))[:-len(operands[-1])]
            if len(rest) > 0 and solve(int(rest), operands[:-1], concat):
                return True
    else:
        if value == int(operands[0]):
            return True
    return False
    
def solve_line(line, concat):
    value, operands = line.split(': ')
    operands = operands.split(' ')
    if solve(int(value), operands, concat):
        return int(value)
    return 0

sum = 0
for line in lines:
    sum += solve_line(line, False)
print(sum)

sum = 0
for line in lines:
    sum += solve_line(line, True)
print(sum)