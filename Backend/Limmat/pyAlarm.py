import RPi.GPIO as GPIO
import serial
import time, sys
import datetime
from curses import ascii

def setup():
    GPIO.setmode(GPIO.BCM)
    GPIO.setwarnings(False)
    # GPIO.setup(23, GPIO.OUT)
    # GPIO.setup(24, GPIO.OUT)
    # GPIO.setup(25, GPIO.OUT)

SERIAL_PORT = '/dev/ttyS0'
ser = serial.Serial(SERIAL_PORT, baudrate = 115200, timeout = 5)

def call(number):
    # ser.write(str.encode("AT+CFUN=1\r")) #ser.write("AT+CFUN=1\r")
    print ("Tryb CALL ON")
    # ser.write(str.encode('ATD%s;\r'))
    ser.write(str.encode('ATD%s;\r' % number))
    time.sleep(5)
    response = ser.readlines(None)
    time.sleep(5)
    # print (response)
    ser.write(str.encode("AT+CHUP\r"))
    time.sleep(0.5)
    print("END CALL")
    #ser.write(str.encode('AT+CMGDA="DEL ALL"\r')) # delete all
    time.sleep(.500)
    ser.read(ser.inWaiting()) # Clear buffer

def sms(numer,name, dienst):
    print ("Tryb SMS ON")
    ser.write(str.encode("AT+CMGF=1\r"))
    time.sleep(0.5)
    ser.write(str.encode('AT+CMGS="%s"\r'% numer))
    time.sleep(0.5)
    ser.write(str.encode('%s Dein Dienst %s hat schon angefangen, bitte quittieren\r' %(name, dienst)))
    time.sleep(0.5)
    # ser.write(ascii.ctrl('z'))
    ser.write(str.encode("\x1A\r\n"))
    time.sleep(0.5)
    response = ser.readlines()
    # print (response)
    # if "+CMGS" in response[-3]:
    #     print ("Sucess: SMS sent!")
    # else:
    #     print ("Error: SMS not sent!")
    ser.write(str.encode('AT+CMGDA="DEL ALL"\r')) # delete all
    # print ("All SMS deleted")
    time.sleep(.500)
    ser.read(ser.inWaiting()) # Clear buffer

def smsPiket(numer,name, dienst):
    print ("Tryb SMS ON")
    ser.write(str.encode("AT+CMGF=1\r"))
    time.sleep(0.5)
    ser.write(str.encode('AT+CMGS="%s"\r'% numer))
    time.sleep(0.5)
    ser.write(str.encode('%s hat sein Dienst Nr: %s nicht quittiert\r' %(name, dienst)))
    time.sleep(0.5)
    # ser.write(ascii.ctrl('z'))
    ser.write(str.encode("\x1A\r\n"))
    time.sleep(0.5)
    response = ser.readlines()
    # print (response)
    # if "+CMGS" in response[-3]:
    #     print ("Sucess: SMS sent!")
    # else:
    #     print ("Error: SMS not sent!")
    ser.write(str.encode('AT+CMGDA="DEL ALL"\r')) # delete all
    # print ("All SMS deleted")
    time.sleep(.500)
    ser.read(ser.inWaiting()) # Clear buffer

def gsmInit():

    print("Finding Module");
    time.sleep(1)
    while 1:
        data=""
        ser.write("AT\r");
        data=ser.read(10)
        print (data)
        r=data.find("OK")
        if r>=0:
            break
        time.sleep(0.5)

# call('0788803206')
# sms('0788803206','Papik','788')
# call('0788803206')