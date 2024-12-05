lines = open('input.txt').read().split('\n\n')

rules = [line.split('|') for line in lines[0].split('\n')]
pages = [line.split(',') for line in lines[1].split('\n')]

# part 1
def is_page_ok(page):
    for rule in rules:
        if rule[0] in page and rule[1] in page and page.index(rule[0]) > page.index(rule[1]):
            return False
    return True

un_pages = []
sum = 0
for page in pages:
    if is_page_ok(page):
        sum += int(page[int((len(page)-1)/2)])
    else:
        un_pages.append(page)
print(sum)

# part 2
def fix_page(page):
    while not is_page_ok(page):
        for rule in rules:
            if rule[0] in page and rule[1] in page:
                pos1 = page.index(rule[0])
                pos2 = page.index(rule[1])
                if pos1 > pos2:
                    page.pop(pos1)
                    page.insert(pos2, rule[0])
                    break
    return page

sum = 0
for page in un_pages:
    page = fix_page(page)
    sum += int(page[int((len(page) - 1) / 2)])
print(sum)