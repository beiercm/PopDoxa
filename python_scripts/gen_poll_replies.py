import os, random, mysql.connector
from mysql.connector import errorcode
import markov as mk



def gen_post():
	#email = emails[random.randint(0, len(emails) - 1)]
	n = 2500

	for i in range(n):
		poll_id = random.randint(0, 4)

		user_id = random.randint(0, 1000)

		content = mk.generate_sentence(random.randint(2, 5))

		print(user_id)
		print(poll_id)
		print(content)

def main():
	#gen_post(get_emails())
	gen_post()


main()