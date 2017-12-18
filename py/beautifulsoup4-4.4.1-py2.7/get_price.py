# _*_ coding: utf-8 _*_

import httplib, urllib, re
from bs4 import BeautifulSoup
from sys import argv

target_server = 'finance.naver.com'
target_directory = '/item/main.nhn'
stock_code = argv[1]
target_url = target_directory+'?code='+stock_code

conn = httplib.HTTPConnection(target_server)
conn.request('GET', target_url)
res = conn.getresponse()

data = res.read()

soup = BeautifulSoup(data, 'html.parser')
target_tag = soup.find("div", class_="today")
target_tag = target_tag.find("p", class_="no_today")

up_or_down = 'up'
if target_tag.find("em", class_="no_up") == None:
    up_or_down = 'down'
price = target_tag.find("span", class_="blind").get_text()

#print up_or_down + " " + price
print price



