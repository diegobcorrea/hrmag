#!/usr/bin/env python
# -*- coding: UTF-8 -*-
import smtplib, getpass
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
import re, sys, os
from subprocess import check_output

# Get the git log --stat entry of the new commit
log = check_output(['git', 'log', '-1', 'HEAD', '--pretty=format:%s'])

matchObj = re.match( r'(\[email \@(.*?)\])', log )

if matchObj:
   	# print "matchObj.group(2) : ", matchObj.group(2)
   	addresses = ['<ddumst@gmail.com>','<diego@mediainteractive.com.pe>']

   	sendTo = matchObj.group(2)

   	if sendTo == 'diego':
   		selectAddres = addresses[0]
   	elif sendTo == 'diegomd':
   		selectAddres = addresses[1]
   	else:
   		selectAddres = ",".join(addresses)

	# Specifying the from and to addresses
	fromaddr = ('ddumst@gmail.com')
	toaddrs  = selectAddres
	subject = (log)
	# Writing the message (this message will appear in the email)
	message = "Ya subí cambios en el sitio, pueden verlos acá <a href='http://diegobc.com/hrblog'>HRMAG online</a>"

	# Gmail Login

	username = 'ddumst@gmail.com'
	password = getpass.getpass("Password: ")

	# Sending the mail  
	# Server Smtp & Port Smtp
	server = smtplib.SMTP('smtp.gmail.com:587')
	server.starttls()
	# User credentials
	server.login(username,password)

	# Header mail
	header = MIMEMultipart()
	header['Subject'] = subject
	header['From'] = fromaddr
	header['To'] = toaddrs

	# Type message
	message = MIMEText(message, 'html', 'utf-8') 
	header.attach(message)

	# Send mail and close conection
	server.sendmail(fromaddr, toaddrs, header.as_string())
	server.quit()
else:
   	print "No match!!"