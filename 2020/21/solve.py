lines = open('input.txt').read().split('\n')

foods = list()
all_allergens = set()
for line in lines:
    ingredients, allergens = line[:-1].split(' (contains ')
    ingredients = ingredients.split(' ')
    allergens = allergens.split(', ')
    foods.append([ingredients, allergens])
    for allergen in allergens:
        all_allergens.add(allergen)

allergens = dict()
while len(all_allergens) > 0:
    allergen_remove = None
    for ale in all_allergens:
        ingredients = set()
        for f in foods:
            if ale in f[1]:
                if len(ingredients) == 0:
                    ingredients = set(f[0])
                else:
                    ingredients = ingredients.intersection(f[0])
        if len(ingredients) == 1:
            ing = ingredients.pop()
            allergen_remove = ale
            allergens[ale] = ing
            for f in foods:
                if ing in f[0]:
                    f[0].remove(ing)
                if ale in f[1]:
                    f[1].remove(ale)
            break
    all_allergens.remove(allergen_remove)

result = 0
for f in foods:
    result += len(f[0])
print(result)

# part 2
allergens_list = [allergens[k] for k in sorted(allergens.keys())]
print(','.join(allergens_list))