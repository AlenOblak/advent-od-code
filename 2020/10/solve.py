lines = open('input.txt').read().split("\n")
lines = list(map(int, lines))

# part 1
lines.append(0)
lines.sort()
lines.append(max(lines) + 3)
num_1 = num_3 = 0
for i in range(len(lines)-1):
	if lines[i] + 1 == lines[i+1]:
		num_1 += 1
	elif lines[i] + 3 == lines[i+1]:
		num_3 += 1
print(num_1 * num_3)

# part 2
paths = {}
for l in lines:
	paths[l] = 0
paths[0] = 1
while len(lines):
	p = lines.pop(0)
	if p + 1 in lines:
		paths[p + 1] += paths[p]
	if p + 2 in lines:
		paths[p + 2] += paths[p]
	if p + 3 in lines:
		paths[p + 3] += paths[p]
print(paths[max(paths.keys())])