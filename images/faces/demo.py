import os
list = os.listdir(".")
for i in list:
	arr =  i.split(".")
	if arr[1] == "JPG":
		os.system("mv "+i+" "+arr[0]+".jpg")

