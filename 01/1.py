import re

f = open("test.txt", "r+")
rows = f.read().splitlines()

sum = 0
for row in rows:
    number = re.sub('[^0-9]', '', row)
    number = number[0]+number[len(number)-1]
    sum += int(number)
    
print(sum)

    
