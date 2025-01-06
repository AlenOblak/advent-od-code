from copy import deepcopy

lines = open('input.txt').read().split('\n\n')

p1_orig = list()
p2_orig = list()

for line in lines[0].split('\n')[1:]:
    p1_orig.append(int(line))
for line in lines[1].split('\n')[1:]:
    p2_orig.append(int(line))

p1 = deepcopy(p1_orig)
p2 = deepcopy(p2_orig)

# part 1
while len(p1) > 0 and len(p2) > 0:
    c1 = p1.pop(0)
    c2 = p2.pop(0)
    if c1 > c2:
        p1.append(c1)
        p1.append(c2)
    else:
        p2.append(c2)
        p2.append(c1)

player = p1 + p2
score = 0
for i in range(1, len(player) + 1):
    score += i * player[-i]
print(score)

# part 2
def play_combat(p1, p2):
    seen_states = set()
    while len(p1) > 0 and len(p2) > 0:
        # memory check
        state = ','.join(str(p1)) + '-' + ','.join(str(p2))
        if state in seen_states:
            return 1, p1
        seen_states.add(state)
        # draw a card each
        c1 = p1.pop(0)
        c2 = p2.pop(0)
        # enough cards, recursive combat
        if len(p1) >= c1 and len(p2) >= c2:
            # make a copy
            p1_copy = deepcopy(p1)
            p2_copy = deepcopy(p2)
            winner, _ = play_combat(p1_copy[:c1], p2_copy[:c2])
        else:
            # not enough cards, winner is the one with the highest card
            if c1 > c2:
                winner = 1
            else:
                winner = 2
        if winner == 1:
            p1.append(c1)
            p1.append(c2)
        else:
            p2.append(c2)
            p2.append(c1)
    if len(p1) == 0:
        return 2, p2
    else:
        return 1, p1

p1 = deepcopy(p1_orig)
p2 = deepcopy(p2_orig)
winner, cards = play_combat(p1, p2)
score = 0
for i in range(1, len(cards) + 1):
    score += i * cards[-i]
print(score)