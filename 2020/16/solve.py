lines = open('input.txt').read().split("\n\n")

rules = []
for line in lines[0].split("\n"):
    line = line.split(': ')
    numbers = line[1].split(' or ')
    n1 = numbers[0].split('-')
    n2 = numbers[1].split('-')
    rules.append([line[0], [int(n1[0]), int(n1[1])], [int(n2[0]), int(n2[1])]])

tickets = []
for line in lines[2].split("\n")[1:]:
    line = list(map(int, line.split(',')))
    tickets.append(line)

# part 1 (with some preparation for part 2)
result = 0
good_tickets = []
for ticket in tickets:
    ticket_ok = True
    for number in ticket:
        match = False
        for rule in rules:
            if rule[1][0] <= number <= rule[1][1]:
                match = True
                break
            elif rule[2][0] <= number <= rule[2][1]:
                match = True
                break
        if match is False:
            result += number
            ticket_ok = False
    if ticket_ok is True:
        good_tickets.append(ticket)
print(result)

# part 2
rules_mapping = []
for r_i, rule in enumerate(rules):
    possible_mapping = list(range(len(rules)))
    for t_i, ticket in enumerate(good_tickets):
        for p_i in possible_mapping:
            if not (rule[1][0] <= ticket[p_i] <= rule[1][1]) and not (rule[2][0] <= ticket[p_i] <= rule[2][1]):
                possible_mapping.remove(p_i)
    rules_mapping.append(possible_mapping) 

# remove mappings one by one
rules_found = []
while True:
    only_one = None
    for rule in rules_mapping:
        if len(rule) == 1 and rule[0] not in rules_found:
            only_one = rule[0]
            rules_found.append(only_one)
            break
    if only_one is not None:
        for rule in rules_mapping:
            if len(rule) > 1 and only_one in rule:
                rule.remove(only_one)
    else:
        break

# compute for my ticket
my_ticket = lines[1].split("\n")[1]
my_ticket = list(map(int, my_ticket.split(',')))
result = 1
for i in range(0,6):
    result *= my_ticket[rules_mapping[i][0]]
print(result)