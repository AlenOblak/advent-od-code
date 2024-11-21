import re

passports = open('input.txt').read().split("\n\n")

fields = ['byr', 'iyr', 'eyr', 'hgt', 'hcl', 'ecl', 'pid']

def is_valid_tag(tag, value):
	if tag == 'byr':
		if len(value) == 4 and 1920 <= int(value) <= 2002:
			return True
	if tag == 'iyr':
		if len(value) == 4 and 2010 <= int(value) <= 2020:
			return True
	if tag == 'eyr':
		if len(value) == 4 and 2020 <= int(value) <= 2030:
			return True
	if tag == 'hgt':
		if value[-2:] == 'cm':
			value = value[:-2]
			if len(value) == 3 and 150 <= int(value) <= 193:
				return True
		if value[-2:] == 'in':
			value = value[:-2]
			if len(value) == 2 and 59 <= int(value) <= 76:
				return True
	if tag == 'hcl':
		if len(value) == 7 and '#' == value[0]:
			value = value[1:]
			match = re.search("[0-9a-f]{6}", value)
			if match:
				return True
	if tag == 'ecl':
		if value in ['amb', 'blu', 'brn', 'gry', 'grn', 'hzl', 'oth']:
			return True
	if tag == 'pid':
		if len(value) == 9 and int(value) > 0:
			return True
	if tag == 'cid':
		return True

	return False


def is_valid_passport(passport, check):
	tags = " ".join(passport.split("\n")).split(" ")
	pass_tags = []

	for tag in tags:
		(a, b) = tag.split(":")
		pass_tags.append(a)
		if check:
			if not is_valid_tag(a, b):
				return False
	for f in fields:
		if f not in pass_tags:
			return False
	
	return True


num1 = num2 = 0
for p in passports:
	if is_valid_passport(p, False):
		num1 += 1
	if is_valid_passport(p, True):
		num2 += 1

print(num1)
print(num2)