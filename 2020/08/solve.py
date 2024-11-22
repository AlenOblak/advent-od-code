lines = open('input.txt').read().split("\n")

# parsing
commands = {}
for i, line in enumerate(lines):
	line = line.split(' ')
	commands[i] = [line[0], line[1]]

# part 1
def simulate(commands):
	acc = 0
	pos = 0
	visited = set()
	while True:
		if pos in visited:
			return False, acc
		if pos not in commands:
			return True, acc
		visited.add(pos)
		if commands[pos][0] == 'acc':
			acc += int(commands[pos][1])
			pos += 1
		elif commands[pos][0] == 'jmp':
			pos += int(commands[pos][1])
		elif commands[pos][0] == 'nop':
			pos += 1

condition, acc = simulate(commands)
print(acc)

# part 2
for i in range(len(commands)):
	if commands[i][0] == 'nop':
		commands[i][0] = 'jmp'
	elif commands[i][0] == 'jmp':
		commands[i][0] = 'nop'
	else:
		continue
	condition, acc = simulate(commands)
	if condition:
		print(acc)
		break
	if commands[i][0] == 'nop':
		commands[i][0] = 'jmp'
	elif commands[i][0] == 'jmp':
		commands[i][0] = 'nop'