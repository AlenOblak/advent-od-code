lines = open('input.txt').read().split("\n")

seat_id = []
for p in lines:
	row = p[0:7].replace("F", "0").replace("B", "1")
	row = int(row, 2)
	col = p[7:10].replace("L", "0").replace("R", "1")
	col = int(col, 2)
	seat_id.append(row * 8 + col)

print(max(seat_id))

seat_id.sort()
for i in range(len(seat_id)):
	if seat_id[i]+1 != seat_id[i + 1]:
		print(seat_id[i]+1)
		break
