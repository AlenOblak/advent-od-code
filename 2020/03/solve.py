lines = open('input.txt').read().splitlines()

max_x = len(lines[0])
max_y = len(lines)

def calc_trees(move_x, move_y):
	x = y = num_trees = 0
	while y < max_y - 1:
		x += move_x
		y += move_y
		if x >= max_x:
			x -= max_x
		if lines[y][x] == '#':
			num_trees += 1
	return num_trees

print(calc_trees(3,1))

result = 1
for combination in [(1,1), (3,1), (5,1), (7,1), (1,2)]:
	result *= calc_trees(*combination)

print(result)
