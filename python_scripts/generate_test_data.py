import sys
import gen_users as gu
import gen_posts as gp
import gen_replies as gr
import gen_user_opins as guo
import gen_poll_results as gpr
import gen_poll_replies as gpr2

def main(users):
	print "Creating users..."
	gu.start(users)

	print "Creating posts..."
	gp.start(users * 2)

	print "Creating replies..."	
	gr.start(users * 3)

	print "Creating user opinions..."
	guo.start(users)

	print "Creating poll replies..."
	gpr2.start(users * .5)

	print "Creating poll results..."
	gpr.start()

main(int(sys.argv[1]))