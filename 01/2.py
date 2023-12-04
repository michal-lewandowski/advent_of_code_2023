import re

DIGITS_REPLACEMTNS = {'one': 'on1ne','one': 'on1ne', 'two': 'tw2wo', 'three' : 'thre3hree', 'four' : 'fou4our', 'five' : 'fi5ive', 'six' : 'si6ix', 'seven' : 'seve7even', 'eight' : 'eigh8ight', 'nine' : 'nin9ine'
}

rows = open("test.txt", "r+").read().splitlines()

sum = 0
for row in rows:
    for numberName in DIGITS_REPLACEMTNS:
        row = row.replace(numberName, DIGITS_REPLACEMTNS[numberName])
    number = re.sub('[^0-9]', '', row)
    number = number[0]+number[len(number)-1]
    sum += int(number)
    
