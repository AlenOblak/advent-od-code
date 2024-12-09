import copy

line = open('input.txt').read()

node_type = 0
file_id = 0
position = 0
files = {}
free = {}

for c in list(map(int, line)):
    if node_type == 0:
        files[position] = [file_id, c]
        file_id += 1
    else:
        if c > 0:
            free[position] = c
    position = position + c
    node_type = 1 - node_type

files_orig = copy.deepcopy(files)
free_orig = copy.deepcopy(free)

def move_file(file_pos, free_pos):
    free_space = free[free_pos]
    file_len = files[file_pos][1]
    
    if free_pos > file_pos:
        free.pop(free_pos)
    elif free_space > file_len:
        files[free_pos] = files[file_pos]
        files.pop(file_pos)
        free[free_pos+file_len] = free[free_pos] - file_len
        free.pop(free_pos)
    elif free_space == file_len:
        files[free_pos] = files[file_pos]
        files.pop(file_pos)
        free.pop(free_pos)
    else:
        files[free_pos] = [files[file_pos][0], free_space]
        files[file_pos][1] -= free_space
        free.pop(free_pos)

def sum_it_up():
    total = 0
    for k in files.keys():
        file = files[k]
        for i in range(k, k + file[1]):
            total += i * file[0]
    return total

# part 1
while len(free):
    file_id = file_id - 1
    file_pos = max(files.keys())
    free_pos = min(free.keys())
    move_file(file_pos, free_pos)

print(sum_it_up())

# part 2
def file_to_move():
    file_keys = sorted(files.keys(), reverse=True)
    free_keys = sorted(free.keys())
    for file_pos in file_keys:
        for free_pos in free_keys:
            if file_pos > free_pos:
                if files[file_pos][1] <= free[free_pos]:
                    return file_pos, free_pos
            else:
                break
    return False, False

files = files_orig
free = free_orig
while True:
    file_pos, free_pos = file_to_move()
    if not file_pos:
        break
    move_file(file_pos, free_pos)

print(sum_it_up())