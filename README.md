# PHP-Assignment
Simple CRUD Rest API Appointment Booking Application for a doctor in PHP using Zend Framework and SQLite DB.

# DB Schema File
data/schema.sql

# Executing Rest APIs using CURL
# Appointments List

curl -i -H "Accept: application/json" http://localhost:8080/appointment
HTTP/1.1 200 OK
Host: localhost:8080
Connection: close
X-Powered-By: PHP/5.6.37
Content-Type: application/json; charset=utf-8

[{"status":"success","message":"Appointments available","data":[{"id":"36","firstname":"alice","lastname":"stewart","email":"astewart@gmail.com","phone":"16041234567","address":"12345 abc Ave Surrey BC Canada","reason":"throat infection","starttime":"2018-08-30 10:00:00","endtime":"2018-08-30 10:30:00"},{"id":"37","firstname":"bob","lastname":"martin","email":"bob_martin123@gmail.com","phone":"160412347788","address":"12345 81a Ave Abbotsford BC Canada","reason":"diabetics issues","starttime":"2018-08-23 14:00:00","endtime":"2018-08-23 14:30:00"},{"id":"38","firstname":"catherine","lastname":"chow","email":"chow.catherine@gmail.com","phone":"16041239090","address":"17856 78 Ave Langley BC Canada","reason":"thyroid issues","starttime":"2018-08-31 11:00:00","endtime":"2018-08-31 11:30:00"},{"id":"39","firstname":"david","lastname":"proctor","email":"davidproctor87@gmail.com","phone":"16041230987","address":"13606 saanich street Langley BC Canada","reason":"skin infection","starttime":"2018-08-22 12:00:00","endtime":"2018-08-31 12:30:00"}]}]

# Appointment Details

curl -i -H "Accept: application/json" http://localhost:8080/appointment/36
HTTP/1.1 200 OK
Host: localhost:8080
Connection: close
X-Powered-By: PHP/5.6.37
Content-Type: application/json; charset=utf-8

[{"status":"success","message":"Appointments details are available","data":{"id":"36","firstname":"alice","lastname":"stewart","email":"astewart@gmail.com","phone":"16041234567","address":"12345 abc Ave Surrey BC Canada","reason":"throat infection","starttime":"2018-08-30 10:00:00","endtime":"2018-08-30 10:30:00"}}]

# Create Appointment

curl -i -H "Accept: application/json" -X POST -d "firstname=harneet&lastname=deol&email=hkdeol87@gmail.com&address=12345 89 ave surrey bc&phone=6045671234&reason=throat infection&starttime=2018-09-12 10:00:00&endtime=2018-09-12 10:30:00" http://localhost:8080/appointment
HTTP/1.1 200 OK
Host: localhost:8080
Connection: close
X-Powered-By: PHP/5.6.37
Content-Type: application/json; charset=utf-8

[{"status":"success","message":"Appointment added successfully!","data":{"firstname":"harneet","lastname":"deol","email":"hkdeol87@gmail.com","address":"12345 89 ave surrey bc","phone":"6045671234","reason":"throat infection","starttime":"2018-09-12 10:00:00","endtime":"2018-09-12 10:30:00"}}]

# Update Appointment

curl -i -H "Accept: application/json" -X PUT -d "firstname=harneet&lastname=deol&email=hkdeol123@gmail.com&address=12345 89 ave surrey bc&phone=6045671234&reason=skin issues infection&starttime=2018-09-12 10:00:00&endtime=2018-09-12 10:30:00" http://localhost:8080/appointment/40
HTTP/1.1 200 OK
Host: localhost:8080
Connection: close
X-Powered-By: PHP/5.6.37
Content-Type: application/json; charset=utf-8

[{"status":"success","message":"Appointment updated successfully!","data":{"firstname":"harneet","lastname":"deol","email":"hkdeol123@gmail.com","address":"12345 89 ave surrey bc","phone":"6045671234","reason":"skin issues infection","starttime":"2018-09-12 10:00:00","endtime":"2018-09-12 10:30:00","id":40}}]

# Delete Appointment
curl -i -H "Accept: application/json" -X DELETE http://localhost:8080/appointment/40
HTTP/1.1 200 OK
Host: localhost:8080
Connection: close
X-Powered-By: PHP/5.6.37
Content-Type: application/json; charset=utf-8

[{"status":"success","message":"Appointment deleted successfully!","data":40}]

# Unit Tests
To run the unit tests, after initial project creation, install zend-test:

$ composer require --dev zendframework/zend-test
Once testing support is present, you can run the tests using:

$ ./vendor/bin/phpunit

C:\Users\hirda n sebi\Desktop\AppointmentBookingSystem>"vendor/bin/phpunit"
PHPUnit 5.7.27 by Sebastian Bergmann and contributors.

..........................                                        26 / 26 (100%)

Time: 3.66 seconds, Memory: 22.75MB

OK (26 tests, 70 assertions)
