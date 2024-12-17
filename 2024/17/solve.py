lines = open('input.txt').read().split('\n')

reg_a = int(lines[0][12:])
reg_b = int(lines[1][12:])
reg_c = int(lines[2][12:])
program = list(map(int,lines[4][9:].split(',')))

def combo_op(operand, reg_a, reg_b, reg_c):
    if operand < 4:
        return operand
    if operand == 4:
        return reg_a
    if operand == 5:
        return reg_b
    if operand == 6:
        return reg_c

def program_output(reg_a, reg_b, reg_c, program):
    pointer = 0
    output = []
    while True:
        operator = program[pointer]
        operand = program[pointer+1]
        
        if operator == 0:
            reg_a = reg_a // (pow(2, combo_op(operand, reg_a, reg_b, reg_c)))
        if operator == 1:
            reg_b = reg_b ^ operand
        if operator == 2:
            reg_b = combo_op(operand, reg_a, reg_b, reg_c) % 8
        if operator == 3:
            if reg_a != 0:
                pointer = operand -2
        if operator == 4:
            reg_b = reg_b ^ reg_c
        if operator == 5:
            output.append(combo_op(operand, reg_a, reg_b, reg_c) % 8)
        if operator == 6:
            reg_b = reg_a // (pow(2, combo_op(operand, reg_a, reg_b, reg_c)))
        if operator == 7:
            reg_c = reg_a // (pow(2, combo_op(operand, reg_a, reg_b, reg_c)))
    
        pointer += 2
        if pointer >= len(program):
            break
    return output

# part 1
print(','.join(list(map(str, program_output(reg_a, reg_b, reg_c, program)))))

# part 2
def find_powers(powers, i):
    base_reg_a = 0
    for k, p in enumerate(powers):
        base_reg_a += p * pow(8, k)
    for a in range(8):
        reg_a = base_reg_a + a * pow(8, i)
        output = program_output(reg_a, reg_b, reg_c, program)
        if len(output) == len(powers) and output[i] == program[i]:
            if i == 0:
                return reg_a
            powers[i] = a
            result = find_powers(powers, i-1) 
            if result is not None:
                return result
    powers[i] = 0
    return None
           
i = len(program) - 1
powers = [0] * len(program)
result = find_powers(powers, i)
print(result)