import serial
import sys

ser = serial.Serial(
   port = '/dev/ttyUSB0',
   baudrate = 115200,
   parity = serial.PARITY_NONE,
   stopbits = serial.STOPBITS_ONE,
   bytesize = serial.EIGHTBITS
)

if ser.isOpen() == False :
   ser.open()
   if ser.isOpen() == False :
      print "Can't open serial port"
      sys.exit(1)


#for i in range(100000) :
#      ser.write('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa')
