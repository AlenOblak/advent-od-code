lines = open('input.txt').read().split('\n')

def solve_eq(tot_value, value, operands, concat):
    if value > tot_value:
        return False
    if len(operands) == 0:
        if tot_value == value:
            return True
    else:
        if solve_eq(tot_value, value * operands[0], operands[1:], concat):
            return True
        if solve_eq(tot_value, value + operands[0], operands[1:], concat):
            return True
        if concat and solve_eq(tot_value, int(str(value) + str(operands[0])), operands[1:], concat):
            return True
    return False
    
def solve_line(line, concat):
    value, operands = line.split(': ')
    operands = list(map(int, operands.split(' ')))
    if solve_eq(int(value), operands[0], operands[1:], concat):
        return int(value)
    return 0

# part 1
print(sum([solve_line(line, False) for line in lines]))

# part 2
print(sum([solve_line(line, True) for line in lines]))