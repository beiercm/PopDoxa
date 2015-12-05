import sys
import gc_connection as gc
import gen_users as gu
import gen_posts as gp
import gen_replies as gr
import gen_user_opins as guo
import gen_poll_results as gpr
import gen_poll_replies as gpr2

def main(users):
	conn = gc.connection()
	try:	
		print "Creating users..."
		gu.start(conn, users)

		print "Creating posts..."
		gp.start(conn, users * 2)

		print "Creating replies..."	
		gr.start(conn, users * 3)

		print "Creating user opinions..."
		guo.start(users)

		print "Creating poll replies..."
		gpr2.start(conn, users * .5)

		print "Creating poll results..."
		gpr.start(conn)
	except Exeception as e:
		print e

	conn.commit()

main(int(sys.argv[1]))