from pylab import *
import get_connection as gc

conn = gc.connection()
cursor = conn.cursor()

def gen_pie_graph(results):
	figure(1, figsize=(6, 6))

	ax = axes([0.1, 0.1, 0.8, 0.8])

# The slices will be ordered and plotted counter-clockwise.
	labels = 'yes', 'no', 'undecided'
	fracs = (results[0][1], results[1][1], results[2][1])


# make a square figure and axes
def get_results(poll_id):
	query = """
	SELECT vote, count(vote) 
	FROM poll_results 
	WHERE vote = 'y' 
	AND poll_id = """ + str(poll_id) + """
	UNION
	SELECT vote, count(vote) 
	FROM poll_results 
	WHERE vote = 'n' 
	AND poll_id = """ + str(poll_id) + """
	UNION
	SELECT vote, count(vote) 
	FROM poll_results 
	WHERE vote = 'u' 
	AND poll_id = """ + str(poll_id) + """;
	"""

	cursor.execute(query)

	results = cursor.fetchall()

	return results
	

def main():
	results = get_results(1)
	gen_pie_graph(results)

main()	