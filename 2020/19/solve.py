import re

lines = open('input.txt').read().split('\n\n')

rules = {}
letters = {}
for line in lines[0].splitlines():
    id, options = line.split(': ')
    options = list(map(str.strip, options.split('|')))
    opts = []
    for option in options:
        try:
            opts.append(list(map(int, option.split(' '))))
            rules[int(id)] = opts
        except ValueError:
            letters[int(id)] = option.strip('"')

def construct_rule(rule, special):
    if type(rule) == int:
        result = []
        for r in rules[rule]:
            result.append(construct_rule(r, special))
        if special and rule == 8:
            return '(' + '|'.join(result) + ')+'
        return '(' + '|'.join(result) + ')'
    elif type(rule) == list:
        result = ''
        if special and rule == [42, 31]:
            r42 = construct_rule(42, special)
            r31 = construct_rule(31, special)
            return ('((' + r42 + r31 + ')|(' + r42 + r42 + r31 + r31 + ')|(' + r42 + r42 + r42 + r31 + r31 + r31 + ')|(' 
                    + r42 + r42 + r42 + r42 + r31 + r31 + r31 + r31 + ')|(' 
                    + r42 + r42 + r42 + r42 + r42 + r31 + r31 + r31 + r31 + r31 + '))')
        else:
            for r in rule:
                if r in letters:
                    result += letters[r]
                else:
                    result += construct_rule(r, special)
            return '(' + result + ')'

pattern_1 = construct_rule(0, False)
regex_pattern_1 = re.compile('^' + pattern_1 + '$')
pattern_2 = construct_rule(0, True)
regex_pattern_2 = re.compile('^' + pattern_2 + '$')

count_1 = count_2 = 0
for line in lines[1].splitlines():
    if regex_pattern_1.match(line):
        count_1 += 1
        count_2 += 1
    elif regex_pattern_2.match(line):
        count_2 += 1
        
print(count_1)
print(count_2)