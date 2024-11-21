import string

groups = open('input.txt').read().split("\n\n")

num = 0
for group in groups:
	chars = set(group.replace("\n", ""))
	num += len(chars)

print(num)

num = 0
for group in groups:
	persons = group.split("\n")
	chars = set(string.ascii_lowercase)
	for p in persons:
		chars.intersection_update(set(p))
	num += len(chars)

print(num)