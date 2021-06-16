#define USE_ARDUINO_INTERRUPTS true
#include <MMA7660.h>
#include <Wire.h>
#include <TinyGPS++.h>
#include <SoftwareSerial.h>
//#include <PulseSensorPlayground.h>
MMA7660 acc;

// Definitions of Sensor Recieve and Transmit pins
static const int GpsRXPin = 4, GpsTXPin = 3, HC12RXPin = 10, HC12TXPin = 11, manualTrigger = 2, pulseWire = A3, LED = 13, waterTrigger = 5;
static const int BaudRate = 9600;
static const int uid = 1;
static const int freeFallDetectionLimit = 200;
static int fallLength = 0;
static int counter = 10;
int xHistory[10] = {0, 0, 0, 0, 0, 0, 0, 0, 0, 0};
int yHistory[10] = {0, 0, 0, 0, 0, 0, 0, 0, 0, 0};
int zHistory[10] = {0, 0, 0, 0, 0, 0, 0, 0, 0, 0};
int xTotal = 0;
int yTotal = 0;
int zTotal = 0;
int gTotal = 0;

TinyGPSPlus gps;
SoftwareSerial HC12(HC12RXPin, HC12TXPin); //RX, TX
SoftwareSerial ss(GpsRXPin,  GpsTXPin);
boolean Manual_safe = true;
int beat;
//int threshold = 550;


// FUNCTIONS
void send_gps() {

  while (ss.available() > 0)
    if (gps.encode(ss.read()))
      if (gps.location.isValid())
      {
        HC12.print(String(uid) + ";G;" + String(gps.location.lat(), 6) + ";" + String(gps.location.lng(), 6) + "\n");
      }
      else
      {
        HC12.print(String(uid) + ";G;err;sig\n");
      }

  if (millis() > 1000 && gps.charsProcessed() < 10)
  {
    HC12.print(String(uid) + ";G;err;dev\n");
    while (true);
  }
}

void detectFall() {
  int8_t x, y, z;
  acc.getXYZ(&x, &y, &z);

  // Total is het totaal van de afgelopen 10 waarden. History is een Array met deze 10 waarden. gTotal is het totaal van X Y en Z as
  // ipv elke loop 10 waarden op te tellen wordt de waarde die zal veranderen uit het totaal gehaald en de nieuwe waarde in het totaal bijgeteld.
  // resultaat een totaal van 8 bewerkingen inplaats van 32.

  xTotal = xTotal - xHistory[counter];
  yTotal = yTotal - yHistory[counter];
  zTotal = zTotal - zHistory[counter];
  xHistory[counter] = x;
  yHistory[counter] = y;
  zHistory[counter] = z;
  xTotal = xTotal + xHistory[counter];
  yTotal = yTotal + yHistory[counter];
  zTotal = zTotal + zHistory[counter];
  gTotal = abs(xTotal) + abs(yTotal) + abs(zTotal);

  //Sectie Freefall detection
  if (gTotal < freeFallDetectionLimit) { //freefall triggered
    fallLength = fallLength + 1;
    //HC12.print(String(uid) + ";F;ff;" + String(gTotal) + "\n");
  } else if (fallLength) {
    if (fallLength > 10 && yTotal < 200 ) {
      if (abs(xTotal) > abs(yTotal)) {
        // x groter als y
        if (abs(xTotal) > abs(zTotal)) {
          //x is de grootste
          if (xTotal > 0) {
            HC12.print(String(uid) + ";F;ff;1;" + String(fallLength) + "\n");
            Serial.println("postieve x");
          } else {
            HC12.print(String(uid) + ";F;ff;2;" + String(fallLength) + "\n");
            Serial.println("negatieve x");
          }
        } else {
          //z is de grootste
          if (zTotal > 0) {
            HC12.print(String(uid) + ";F;ff;3;" + String(fallLength) + "\n");
          } else {
            HC12.print(String(uid) + ";F;ff;4;" + String(fallLength) + "\n");
          }
        }
      } else {
        // y groter als x
        if (abs(yTotal) > abs(zTotal)) {
          //y is de grootste
          if (yTotal > 0) {
            HC12.print(String(uid) + ";F;ff;5;" + String(fallLength) + "\n");
          } else {
            HC12.print(String(uid) + ";F;ff;6;" + String(fallLength) + "\n");
          }
        } else {
          //z is de grootste
          if (zTotal > 0) {
            HC12.print(String(uid) + ";F;ff;3;" + String(fallLength) + "\n");
          } else {
            HC12.print(String(uid) + ";F;ff;4;" + String(fallLength) + "\n");
          }
        }
      }
      fallLength = 0;
    }
  }
}



// x(blue) = up y(red) = right  z(green) == back
//Serial.println (String(x) +" "+ String(y) +" "+ String(z));

void send_bpm() {
  beat = analogRead(pulseWire);
  //if(beat > threshold){                          // If the signal is above "550", then "turn-on" Arduino's on-Board LED.
  //Serial.println(beat);
  //}
  delay(1);
}

void manual_alert() {
  if (Manual_safe == true && !digitalRead(7)) {
    HC12.print(String(uid) + ";M;p\n");
    digitalWrite(LED, HIGH);
    Manual_safe = false;
    delay(250);
  }
}

void water() {
  if (digitalRead(waterTrigger) == LOW) {
    HC12.print(String(uid) + ";W;w\n");
    digitalWrite(LED, HIGH);
  }
}

void setup() {
  Serial.begin(BaudRate);
  HC12.begin(BaudRate); // HC Baudrate
  ss.begin(BaudRate);
  acc.init();
  pinMode(manualTrigger, INPUT_PULLUP); // Manual Lever
  pinMode(waterTrigger, INPUT); // wet
  pinMode(LED, OUTPUT);
  delay(5);
  attachInterrupt(digitalPinToInterrupt(manualTrigger), manual_alert, LOW);
  HC12.print(String(uid) + ";J;init\n");
}

void loop() {
  if (counter == 0) {
    counter = 10;
    send_gps();
    water();
    send_bpm();
  }
  counter = counter - 1;
  detectFall();
  delay(100);
}
