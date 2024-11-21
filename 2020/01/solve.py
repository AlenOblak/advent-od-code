lines = open('input.txt').read().splitlines()

lines = list(map(int, lines))

for i in range(len(lines)):
	for j in range(i, len(lines)):
		if lines[i] + lines[j] == 2020:
			print(lines[i] * lines[j])

for i in range(len(lines)):
	for j in range(i, len(lines)):
		for k in range(j, len(lines)):
			if lines[i] + lines[j] + lines[k] == 2020:
				print(lines[i] * lines[j] * lines[k])