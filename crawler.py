# -*- coding:utf-8 -*-

# Learned from iplaypython.com
# author: niceforbear

import urllib
# print dir(urllib)
# help(urllib)
help(urllib.urlretrieve)
url = "http://www.iplaypython.com/"
html = urllib.urlopen(url)
#print html.read().decode("gbk").encode("utf-8")
print dir(html)
html.info

# =====================================================================================

urllib.urlretrieve(url,"c:\\Users\\greatecho\\Desktop\\abc.txt") #catch and download

def callback(a,b,c):
"""
@a:xxxxxx
@b:xxxxxx
@c:xxx
"""
down_progress = 100.0 *a*b/c
if down_progress > 100:
down_progress = 100
print "%.2f%%" %down_progress,

local = "C:\\Users\\greatecho\\Desktop\\iplaypython.html"
urllib.urlretrieve(url,local,callback)
"""
1:input type :string
2:input local path and file name
3: a function,we can define the action of the func,
but it is a must to keep 3 para in the function
(1)the num of data blocks
(2)size of each data block, byte unit
(3)size of internet file (some time return -1)
"""

# ==========================================================

import chardet #字符集检测

url = "http://www.iplaypython.com"
content = urllib.urlopen(url).read()
result = chardet.detect(content)
print result['我是中文']

def automatic_detect(url):
content = urllib.urlopen(url).read()
result = chardet.detect(content)
encoding =result['encoding']
return encoding

# print automatic_detect(url)

urls = ["http://www.iplaypython.com",
"http://www.baidu.com",
"http://www.163.com",
"http://www.jd.com",
"http://www.taobao.com"
]
for url in urls:
print automatic_detect(url),

# =================================================
# import urllib

# url = "http://blog.csdn.net/yuanmeng001"
# url = "http://www.jd.com/robots.txt"
# html = urllib.urlopen(url)
# #print html.info()
# print html.read()
# print html.getcode()

import urllib2
import random

url ="http://blog.csdn.net/yuanmeng001"
my_headers =[
"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.94 Safari/537.36",
"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.94 Safari/537.36"
]
# req = urllib2.Request(url,)
# req.add_header("User-Agent","Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.94 Safari/537.36")
# req.add_header("GET",url)
# req.add_header("Host","blog.csdn.net")
# #req.add_header("Referer","http://blog.csdn.net/") #***
# html = urllib2.urlopen(req)

# print html.read()
#print req.headers.items()

#Agent ip , Fake Header-info

def get_content(url,headers):
"""
@get 403 Page
"""
random_header = random.choice(headers)
req = urllib2.Request(url)
req.add_header("User-Agent",random_header)
req.add_header("Host","blog.csdn.net")
req.add_header("GET",url)
req.add_header("Referer","http://blog.csdn.net/")

content = urllib2.urlopen(req).read()
return content

print get_content(url,my_headers)

# ============================================================

# -*- coding:utf-8 -*-
# pic_spider
import re
import urllib

def get_content(url):
"""
doc.
"""
html = urllib.urlopen(url)
content = html.read()
html.close()
return content

def get_images(info):
"""doc
<img class="BDE_Image" src="http://imgsrc.baidu.com/forum/w%3D580/sign=fe2da5958fb1cb133e693c1bed5556da/20168a82b9014a903c8688c7ab773912b31bee16.jpg" pic_ext="jpeg" width="510" height="765" style="cursor: url(http://tb2.bdstatic.com/tb/static-pb/img/cur_zin.cur), pointer;">
"""
regex = r'class="BDE_Image" src="(.+?\.jpg)"'
pat = re.compile(regex)
images_code = re.findall(pat,info)
i = 0
for image_url in images_code:
print image_url
urllib.urlretrieve(image_url,'%s.jpg' % i)
i += 1

url = 'http://tieba.baidu.com/p/2772656630'
info = get_content(url)
print get_images(info)

# ======================================================

# -*- coding:utf-8 -*-
import urllib
from bs4 import BeautifulSoup

def get_content(url):
"""doc"""
html = urllib.urlopen(url)
content = html.read()
html.close()
return content

def get_images(info):
soup = BeautifulSoup(info)
all_img = soup.find_all('img',class_="BDE_Image")
#return [img['src'] for img in all_img]
x=1
for img in all_img:
print img
image_name = '%s.jpg' % x
urllib.urlretrieve(img['src'],image_name)
x += 1

url = 'http://tieba.baidu.com/p/2772656630'
info = get_content(url)
get_images(info)

# =================================================================

#!/usr/bin/env python
# encoding: utf-8

# 把str编码由ascii改为utf8（或gb18030）
import sys
reload(sys)
sys.setdefaultencoding('utf8')
import time
import re
import requests #?????
from bs4 import BeautifulSoup
file_name = 'book_list.txt'
file_content = '' # 最终要写到文件里的内容
file_content += '生成时间：' + time.asctime()

def book_spider(book_tag):
global file_content
url = "http://book.douban.com/tag/%s?type=S" % book_tag
source_code = requests.get(url)
# just get the code, no headers or anything
plain_text = source_code.text
# BeautifulSoup objects can be sorted through easy
soup = BeautifulSoup(plain_text)
'''print('\n')
print('--' * 30)
print('--' * 30)
print("\t"*4+book_tag+" :")
print('--' * 30)
print('--' * 30)
print('\n')'''
title_divide = '\n' + '--' * 30 + '\n' + '--' * 30 + '\n' # / it can continue the content next line
file_content += title_divide + '\t' * 4 + \
book_tag + '：' + title_divide
count = 1
for book_info in soup.findAll('div', {'class': 'info'}):
title = book_info.findAll('a', {'onclick': re.compile(r"\"moreurl(.+)")})[0].get('title')
pub = book_info.findAll('div', {'class':'pub'})[0].string.strip()
rating = book_info.findAll('span', {'class':'rating_nums'})[0].string.strip()
people_num = book_info.findAll('span', {'class':'pl'})[0].string.strip()
file_content += "*%d\t《%s》\t评分：%s%s\n\t%s\n\n" % (count, title, rating, people_num, pub)
count += 1

# 此函数并未使用。若需要抓取书籍详情页面的信息，
# 可在以下代码的基础上进一步完善。
def get_single_book_data(book_url):
source_code = requests.get(book_url)
plain_text = source_code.text
soup = BeautifulSoup(plain_text)
# for rating in soup.findAll('strong', {'class':'ll rating_num '}):
# print("评分：" + rating.string.strip())
for rating in soup.findAll('p', {'class':'rating_self clearfix'}):
print rating.strong.string
'''for book_info in soup.findAll('div', {'id':'info'}):
if book_info != None:
info = book_info.string
print("详情：" + info)'''

def do_spider(book_lists):
for book_tag in book_lists:
book_spider(book_tag)

book_lists = ['心理学','人物传记','中国历史','旅行','生活','科普']
do_spider(book_lists)

# 将最终结果写入文件
f = open(file_name, 'w')
f.write(file_content)
f.close()
print get_single_book_data('http://book.douban.com/subject/4242172/')
