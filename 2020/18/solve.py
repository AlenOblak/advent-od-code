import re

lines = open('input.txt').read().splitlines()

def calc_expression_1(expression):
    while True:
        # find (123)
        parenthesis = re.search('\(\d+\)', expression)
        if parenthesis:
            repl_exp = eval(parenthesis.group(0))
            expression = expression.replace(parenthesis.group(0), str(repl_exp), 1)
            continue
    
        # find + or *
        replace = re.search('\d+\s[+*]\s\d+', expression)
        if replace:
            repl_exp = eval(replace.group(0))
            expression = expression.replace(replace.group(0), str(repl_exp), 1)
            continue
        
        # nothing to replace, finish
        return int(expression)
    
def calc_expression_2(expression):
    while True:
        # find (1 + 2 * 3)
        parenthesis = re.search('\(([\d\s\+\*]+)\)', expression)
        if parenthesis:
            repl_exp = calc_expression_2(parenthesis.group(0)[1:-1])
            expression = expression.replace(parenthesis.group(0), str(repl_exp), 1)
            continue
    
        # find +
        plus = re.search('\d+\s\+\s\d+', expression)
        if plus:
            repl_exp = eval(plus.group(0))
            expression = expression.replace(plus.group(0), str(repl_exp), 1)
            continue
        
        # find *
        times = re.search('\d+\s\*\s\d+', expression)
        if times:
            repl_exp = eval(times.group(0))
            expression = expression.replace(times.group(0), str(repl_exp), 1)
            continue
        
        # nothing to replace, finish
        return int(expression)

sum_1 = sum_2 = 0
for line in lines:
    sum_1 += calc_expression_1(line)
    sum_2 += calc_expression_2(line)

print(sum_1)
print(sum_2)