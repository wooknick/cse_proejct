# _*_ coding: utf-8 _*_

import httplib, urllib, re
from bs4 import BeautifulSoup
from sys import argv

target_server = 'finance.naver.com'
target_directory = '/sise/'
target_url = target_directory


conn = httplib.HTTPConnection(target_server)
conn.request('GET', target_url)
res = conn.getresponse()

data = res.read()

soup = BeautifulSoup(data, 'html.parser')
target = soup.find("div", id="contentarea")

find_table = soup.find_all('table')
find_up = find_table[10].find_all('a')
find_down = find_table[12].find_all('a')

# if find_up != [] and find_down != []:
#     answer = [[find_up[0].get_text().encode("utf-8"), re.sub("[^0-9]","",find_up[0]["href"])], [find_up[1].get_text().encode("utf-8"), re.sub("[^0-9]","",find_up[1]["href"])],[find_up[2].get_text().encode("utf-8"), re.sub("[^0-9]","",find_up[2]["href"])],[find_down[0].get_text().encode("utf-8"), re.sub("[^0-9]","",find_down[0]["href"])],[find_down[1].get_text().encode("utf-8"), re.sub("[^0-9]","",find_down[1]["href"])],[find_down[2].get_text().encode("utf-8"), re.sub("[^0-9]","",find_down[2]["href"])]]
# else:
#     answer = [["장 마감","000000"],["장 마감","000000"],["장 마감","000000"],["장 마감","000000"],["장 마감","000000"],["장 마감","000000"]]
# 
# print answer[int(argv[1])][int(argv[2])]


if find_up != [] and find_down != []:
	answer = find_up[0].get_text().encode("utf-8")+"/"+str(re.sub("[^0-9]","",find_up[0]["href"]))+"/"+find_up[1].get_text().encode("utf-8")+"/"+str(re.sub("[^0-9]","",find_up[1]["href"]))+"/"+find_up[2].get_text().encode("utf-8")+"/"+str(re.sub("[^0-9]","",find_up[2]["href"]))+"/"+find_down[0].get_text().encode("utf-8")+"/"+str(re.sub("[^0-9]","",find_down[0]["href"]))+"/"+find_down[1].get_text().encode("utf-8")+"/"+str(re.sub("[^0-9]","",find_down[1]["href"]))+"/"+find_down[2].get_text().encode("utf-8")+"/"+str(re.sub("[^0-9]","",find_down[2]["href"]))
else:
	answer = "장마감/장마감/장마감/장마감/장마감/장마감/장마감/장마감/장마감/장마감/장마감/장마감"
		
print answer