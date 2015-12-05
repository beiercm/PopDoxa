import mysql.connector
from mysql.connector import errorcode

data_path = "/home/christopher/popdoxa/PopDoxa/data/"

def connection():
	try:
		login_info = list(open("/home/christopher/login.txt"))
		conn = mysql.connector.connect(user=login_info[1].strip(), password=login_info[2].strip())
		try:
			query = "use cbpopdoxa;"
			conn.cursor().execute(query)
		except Exception as e:
			print e
		return conn

	except errorcode:
		print errorcode
		return