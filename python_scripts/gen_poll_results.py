import random

def gen_poll_results():
	for i in range(10000):

		for j in range(3):
			output = str(i) + ',' + str(j) + ','

			c = random.randint(0, 3)

			if c == 1:
				output += 'y'
			elif c == 2:
				output += 'n'
			else:
				output += 'u'

			print(output)

def main():
	gen_poll_results()

main()