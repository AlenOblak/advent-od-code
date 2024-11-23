lines = open('input.txt').read().split("\n")
lines = list(map(int, lines))

# part 1
magic_number = 0
numbers = lines[0:25]
for i in range(25, len(lines)):
	current_number = lines[i]
	found = False
	for j in numbers:
		if current_number - j in numbers:
			found = True
			break
	if not found:
		magic_number = current_number
		break
	numbers.pop(0)
	numbers.append(current_number)
print(magic_number)	

# part 2
for i in range(0, len(lines)):
	sum_range = 0
	j = i
	while sum_range < magic_number:
		sum_range += lines[j]
		j += 1
	if sum_range == magic_number:
		numbers = lines[i:j + 1]
		break
print(min(numbers) + max(numbers))