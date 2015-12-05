import random, os

class MarkovGenerator(object):

	def __init__(self):
		self.file_name = "BushKerryDebate.txt"
		self.read_data()


	def read_data(self):
		os.chdir("/home/christopher/popdoxa/PopDoxa/data")
		input_file = open(self.file_name)

		lang_dict = {}
		start_words = []

		for line in input_file:
			line = line.strip().split(' ')
			if line[0] not in start_words:
				start_words.append(line[0])

			for i in range(len(line) - 1):
				word = line[i]

				if '.' in word or '!' in word or '?' in word:
					if word not in lang_dict:
						lang_dict[word] = ["*"]
					else:
						lang_dict[word].append("*")

					if i < len(line) - 2:
						start_words.append(line[i + 1])
						continue

				if line[i] not in lang_dict:
					lang_dict[line[i]] = [line[i+1]]
				else:
					lang_dict[line[i]].append(line[i+1])


			word = line[len(line) - 1]

			if word not in lang_dict:
				lang_dict[word] = ["*"]
			else:
				lang_dict[word].append("*")

		self.lang_tuple = (lang_dict, start_words)



	def generate_sentence(self, n):
		lang_dict = self.lang_tuple[0]
		start_list = self.lang_tuple[1]
		final_sentence = ""

		for i in range(n):

			cur_word = start_list[random.randint(0, len(start_list) - 1)]
			sentence = ""

			while cur_word != '*':
				sentence += cur_word
				sentence += ' '

				word_list = lang_dict[cur_word]

				cur_word = word_list[random.randint(0, len(word_list) - 1)]

			final_sentence += sentence

		return final_sentence

