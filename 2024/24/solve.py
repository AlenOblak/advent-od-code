lines = open('input.txt').read().split('\n\n')

start = lines[0].split('\n')
gates_in = lines[1].split('\n')

inputs = {}
for s in start:
    s = s.split(': ')
    inputs[s[0]] = int(s[1])

gates = []
for g in gates_in:
    g = g.split(' ')
    gates.append([g[1], g[0], g[2], g[4]])

def simulate(gates):
    values = {i : inputs[i] for i in inputs.keys()}
    while len(gates) > 0:
        for g in gates:
            if g[1] in values and g[2] in values and g[3] not in values:
                if g[0] == 'AND':
                    values[g[3]] = values[g[1]] and values[g[2]]
                elif g[0] == 'OR':
                    values[g[3]] = values[g[1]] or values[g[2]]
                if g[0] == 'XOR':
                    values[g[3]] = values[g[1]] ^ values[g[2]]
                gates.remove(g)
        
    result = {}
    for i in values:
        if i[0] == 'z':
            result[i] = values[i]
    
    number = ''
    for i in range(len(result)):
        number = str(result['z'+f'{i:02d}']) + number
    if number == '':
        return 0
    return int(number, 2)

# part 1
sim_gates = [g for g in gates]
result = simulate(sim_gates)
print(result)

# part 2
def find_gate(op1, op2, op):
    for g in gates:
        if g[0] == op and ((g[1] == op1 and g[2] == op2) or (g[1] == op2 and g[2] == op1)):
            return g

def find_gate_2(op, out):
    for g in gates:
        if g[0] == op and g[3] == out:
            return g

def gates_to_swap(g1, g2, g3, g4):
    if g2 == g3:
        return g1, g4

def swap_out_gates(g1, g2):
    for g in gates:
        if g[3] == g1:
            g[3] = g2
        elif g[3] == g2:
            g[3] = g1

swapped_gates = []
for i in range(len(inputs) // 2):
    g1 = find_gate(f'x{i:02d}', f'y{i:02d}', 'XOR')
    g2 = find_gate(f'x{i:02d}', f'y{i:02d}', 'AND')
    if i == 0:
        forward_gate = g2[3]
    else:
        g3 = find_gate(g1[3], forward_gate, 'XOR')
        if g3 is None:
            g3 = find_gate_2('XOR', f'z{i:02d}')
            swap1, swap2 = gates_to_swap(g1[3], forward_gate, g3[1], g3[2])
            swap_out_gates(swap1, swap2)
            swapped_gates.append(swap1)
            swapped_gates.append(swap2)
            g3 = find_gate(g1[3], forward_gate, 'XOR')
        if g3[3] != f'z{i:02d}':
            swapped_gates.append(g3[3])
            swapped_gates.append(f'z{i:02d}')
            swap_out_gates(g3[3], f'z{i:02d}')
            g3 = find_gate(g1[3], forward_gate, 'XOR')
        g4 = find_gate(g1[3], forward_gate, 'AND')
        g5 = find_gate(g2[3], g4[3], 'OR')
        if g5 is None:
            if g2[3] == f'z{i:02d}' and g3[3] != f'z{i:02d}':
                swapped_gates.append(g2[3])
                swapped_gates.append(g3[3])
                swap_out_gates(g2[3], g3[3])
                g2 = find_gate(f'x{i:02d}', f'y{i:02d}', 'AND')
                g4 = find_gate(g1[3], forward_gate, 'AND')
                g5 = find_gate(g2[3], g4[3], 'OR')
        forward_gate = g5[3]

swapped_gates.sort()
print(','.join(swapped_gates))