from pylab import *
import get_connection as gc

conn = gc.connection()
cursor = conn.cursor()

class Poll(object):

	def __init__

def gen_pie_graph(results):
	figure(1, figsize=(6, 6))

	ax = axes([0.1, 0.1, 0.8, 0.8])

# The slices will be ordered and plotted counter-clockwise.
	labels = 'yes', 'no', 'undecided'
	fracs = (results[0][1], results[1][1], results[2][1])

	pie(fracs, explode=None, labels=labels,
                autopct='%1.1f%%', shadow=True, startangle=90)
                # The default startangle is 0, which would start
                # the Frogs slice on the x-axis.  With startangle=90,
                # everything is rotated counter-clockwise by 90 degrees,
                # so the plotting starts on the positive y-axis.

	title('Poll 1', bbox={'facecolor':'0.8', 'pad':5})


	#show()
	savefig('poll_2.png')

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