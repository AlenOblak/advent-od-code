lines = open('input.txt').read().splitlines()

def is_valid1(min, max, char, password):
	if int(min) <= password.count(char) <= int(max):
		return True
	return False
	
def is_valid2(min, max, char, password):
	num = 0
	if password[int(min)-1] == char:
		num += 1
	if password[int(max)-1] == char:
		num += 1

	if num == 1:
		return True
	return False

result1 = 0
result2 = 0
for p in lines:
	(num, char, password) = p.split(' ')
	(min, max) = num.split('-')
	char = char.strip(':')
	if is_valid1(min, max, char, password):
		result1 += 1
	if is_valid2(min, max, char, password):
		result2 += 1

print(result1)
print(result2)