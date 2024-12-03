import re

lines = open('input.txt').read().splitlines()

result_1 = result_2 = 0
enabled = True
for line in lines:
    while True:
        repl = re.search('mul\((\d+),(\d+)\)|do\(\)|don\'t\(\)', line)
        if not repl:
            break
        if repl.group(0) == "do()":
            enabled = True
        elif repl.group(0) == "don't()":
            enabled = False
        else:
            a, b = int(repl.group(1)), int(repl.group(2))
            result_1 += a * b
            if enabled:
                result_2 += a * b
        line = line.replace(repl.group(0), '',1)

print(result_1)
print(result_2)