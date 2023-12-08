import re

DIGITS_REPLACEMTNS = {'one': 'o1e','one': 'o1e', 'two': 't2o', 'three' : 't3e', 'four' : 'f4r', 'five' : 'f5e', 'six' : 's6x', 'seven' : 's7n', 'eight' : 'e8t', 'nine' : 'n9e'
}

sum = 0
for row in open("test.txt", "r+").read().splitlines():
    for numberName in DIGITS_REPLACEMTNS:
        row = row.replace(numberName, DIGITS_REPLACEMTNS[numberName])
    number = re.sub('[^0-9]', '', row)
    number = number[0]+number[len(number)-1]
    sum += int(number)
    
