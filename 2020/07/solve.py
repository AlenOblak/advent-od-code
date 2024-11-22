lines = open('input.txt').read().split("\n")

# parsing
bags = {}
num_bags = {}
for line in lines:
	words = line.split(" ")
	bag_outer = words[0]+words[1]
	contains = (" ".join(words[4:])).split(', ')
	for contain in contains:
		words = contain.split(' ')
		bag_inner = words[1]+words[2]
		if words[0] == 'no':
			num_bags[bag_outer] = 0
			break
		if bag_outer in bags:
			bags[bag_outer].append({bag_inner: int(words[0])})
		else:
			bags[bag_outer] = [{bag_inner: int(words[0])}]

# part 1
search_bags = ['shinygold']
possible_bags = []
while search_bags:
	bag = search_bags.pop()
	for b in bags:
		for c in bags[b]:
			if bag in c:
				# add check
				if b not in possible_bags:
					search_bags.append(b)
					possible_bags.append(b)
print(len(possible_bags))

# part 2
while bags:
	for b in bags:
		num = 0
		sum_bags = 0
		for c in bags[b]:
			for k in c:
				if k in num_bags.keys():
					num += 1
					sum_bags += c[k] + c[k] * num_bags[k]
		# if all bags are known
		if num == len(bags[b]):
			num_bags[b] = sum_bags
			bags.pop(b)
			break
print(num_bags['shinygold'])