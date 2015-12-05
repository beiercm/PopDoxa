import random
from get_connection import data_path

def start(n):
	with open(data_path + "user_opins.txt", 'w+') as f_out:
		for i in range(1, n + 1):

			for j in range(1, 9):
				output = str(i) + ',' + str(j) + ','

				c = random.randint(0, 3)

				if c == 1:
					output += 'f'
				elif c == 2:
					output += 'n'
				else:
					output += 'a'

				f_out.write(output + "\n")

