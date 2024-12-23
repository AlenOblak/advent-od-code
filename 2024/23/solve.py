lines = open('input.txt').read().split('\n')

connections = []
computers = dict()
for line in lines:
    c = line.split('-')
    connections.append((c[0], c[1]))
    connections.append((c[1], c[0]))
    if c[0] not in computers:
        computers[c[0]] = set([c[1]])
    else:
        computers[c[0]].add(c[1])
    if c[1] not in computers:
        computers[c[1]] = set([c[0]])
    else:
        computers[c[1]].add(c[0])

# part 1
groups = list()
for c in computers:
    cons = list(computers[c])
    for i in range(len(cons)):
        for j in range(i+1, len(cons)):
            con1 = cons[i]
            con2 = cons[j]
            comp_set = list([c, con1, con2])
            comp_set.sort()
            if c[0] == 't' or con1[0] == 't' or con2[0] == 't':
                if (c, con1) in connections and (c, con2) in connections and (con1, con2) in connections:
                    if comp_set not in groups:
                        groups.append(comp_set)
print(len(groups))

# part 2
def check_group(computers):
    for i in range(len(computers)-1):
        for j in range(i+1, len(computers)):
            if (i, j) not in connections:
                return False
    return True

def reduce_group(group):
    if check_group(group):
        return group
    
    group_con = {}
    for c1 in group:
        num_connections = 0
        for c2 in group:
            if c1 != c2 and (c1, c2) in connections:
                num_connections += 1
        group_con[c1] = num_connections

    min_conn = min(group_con.values())
    max_conn = max(group_con.values())
    if min_conn == max_conn:
        return group
    new_group = [c for c in group if group_con[c] != min_conn]
    
    return reduce_group(new_group)

max_group = []
for c1 in computers:
    group = [c for c in computers[c1]]
    group.append(c1)
    group = reduce_group(group)
    if len(max_group) < len(group):
        max_group = group

max_group.sort()
print(','.join(max_group))