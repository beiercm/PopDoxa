import random

def gen_user_opins():
	for i in range(1000):

		for j in range(8):
			output = str(i) + ',' + str(j) + ','

			c = random.randint(0, 3)

			if c == 1:
				output += 'f'
			elif c == 2:
				output += 'n'
			else:
				output += 'a'

			print(output)

def main():
	gen_user_opins()

main()