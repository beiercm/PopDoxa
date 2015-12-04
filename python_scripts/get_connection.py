import mysql.connector
from mysql.connector import errorcode

def connection():
	try:
		login_info = list(open("/home/christopher/login.txt"))
		conn = mysql.connector.connect(user=login_info[1].strip(), password=login_info[2].strip())
		return conn

	except errorcode:
		print errorcode
		return