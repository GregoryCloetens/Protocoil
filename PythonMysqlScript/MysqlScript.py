import serial
import pymysql

#database Connection
connection = pymysql.connect(host="185.182.57.35", user="michaib313_michaib313", passwd="code2012", database="michaib313_Protocoil" )
cursor = connection.cursor()

#Read Serialport
HC12 = serial.Serial('COM4')
HC12.baudrate = 9600
print(HC12.name)
while True:
  incoming = HC12.readline()
  incoming = incoming.decode('utf-8')
  incoming = incoming.rstrip('\n') 
  segments = incoming.split(';')
  numArgs = len(segments)
  
  if segments[1] == "G":
    if numArgs == 4:
      # Uitvoering van correct command
      if segments[2] == "err":
        # foutmelding
        if segments[3] == "sig":
          # geen signaal
          # TODO - Foutmelding loggen in SQL - Geen signaal op GPS module
          updateSql = "UPDATE user SET error = 1, errorlog = 'geen signaal - GPS'  WHERE jacket_id = "+ segments[0] +" ;"
          cursor.execute(updateSql)
          connection.commit()
          print("gebruiker: ", segments[0]," geen signaal op GPS Module")
        elif segments[3] == "dev":
          # device error
          # TODO - Foutmelding loggen in SQL - GPS module niet actief
          updateSql = "UPDATE user SET error = 1, errorlog = 'GPS niet aangelosten niet' WHERE jacket_id = "+ segments[0] +" ;"
          cursor.execute(updateSql)
          connection.commit()
          print("gebruiker: ", segments[0], " GPS Module niet actief")
        else:
          # Ongekende fout
          # TODO - Foutmelding loggen in SQL - algemene fout GPS module
          updateSql = "UPDATE user SET error = 1, errorlog = 'GPS werkt niet'  WHERE jacket_id = "+ segments[0] +" ;"
          print("gebruiker: ", segments[0], " Communicatie Fout - GPS Module")
      else:
        # geen foutmelding
        # TODO - GPS loggen in SQL
        updateSql = "UPDATE user SET GPSX = "+ segments[2] +", GPSY = "+ segments[3] +", error = 0, errorlog = NULL WHERE jacket_id = "+ segments[0] +" ;"
        cursor.execute(updateSql)
        connection.commit()
        print("UPDATE user SET GPSX = "+ segments[2] +", GPSY = "+ segments[3] +" WHERE jacket_id = "+ segments[0] +" ;")
    else: 
      # Uitvoering van foutprocedure incompleet command
      # TODO - Communicatie fout loggen in SQL
      print("gebruiker: ", segments[0], " Onvolledig command - GPS MODULE")  
  elif segments[1] == "W":
    if numArgs == 3:
      if segments[2] == "w":
        # zeer nat!!
        # TODO - Gebruiker is nat loggen in SQL
        updateSql = "UPDATE user SET wet = 1, alert = 1  WHERE jacket_id = "+ segments[0] +" ;"
        cursor.execute(updateSql)
        print("Gebruiker ", segments[0], " is WET")
        connection.commit()
    else: 
      # Uitvoering van foutprocedure incompleet command
      # TODO - Communicatie fout loggen in SQL
      print("gebruiker: ", segments[0], " Onvolledig command - WATER MODULE")
  elif segments[1] == "M":
    if numArgs == 3:
      if segments[2] == "p":
        # Manual Pull
        # TODO Gebruiker heeft aan de NOOD bel getrokken! loggen in SQL
        updateSql = "UPDATE user SET alert = 1  WHERE jacket_id = "+ segments[0] +" ;"
        cursor.execute(updateSql)
        connection.commit()
        print("gebruiker: ", segments[0], " gebruiker vraagt hulp")
    else: 
      # Uitvoering van foutprocedure incompleet command
      # TODO - Communicatie fout loggen in SQL
      print("gebruiker: ", segments[0], " Onvolledig command - Manual Trigger")
  elif segments[1] == "J" and numArgs == 3 and segments[2] == "init":
    updateSql = "UPDATE user SET wet = 0, alert = 0, error = 0, errorlog = NULL, fallDirection = NULL, fallTime = NULL WHERE jacket_id = "+ segments[0] +" ;"
    cursor.execute(updateSql)
    connection.commit() 
  elif segments[1] == "F" and numArgs == 5 and segments[2] == "ff":
    if segments[3] == "1":
      updateSql = "UPDATE user SET fallDirection = "+ segments[3] +", fallTime = "+ segments[4] +", alert = 1 WHERE jacket_id = "+ segments[0] +" ;"
      cursor.execute(updateSql)
      connection.commit()
      print("gebruiker: "+ segments[0]+ " is gevallen op LINKS met een snelheid van "+ segments[4] +" ;")
    elif segments[3] == "2":
      updateSql = "UPDATE user SET fallDirection = "+ segments[3] +", fallTime = "+ segments[4] +", alert = 1 WHERE jacket_id = "+ segments[0] +" ;"
      cursor.execute(updateSql)
      connection.commit()
      print("gebruiker: "+ segments[0]+ " is gevallen op RECHTS met een snelheid van "+ segments[4] +" ;")
    elif segments[3] == "3":
      updateSql = "UPDATE user SET fallDirection = "+ segments[3] +", fallTime = "+ segments[4] +", alert = 1 WHERE jacket_id = "+ segments[0] +" ;"
      cursor.execute(updateSql)
      connection.commit()
      print("gebruiker: "+ segments[0]+ " is gevallen op FRONTAAL met een snelheid van "+ segments[4] +" ;")
    elif segments[3] == "4":
      updateSql = "UPDATE user SET fallDirection = "+ segments[3] +", fallTime = "+ segments[4] +", alert = 1 WHERE jacket_id = "+ segments[0] +" ;"
      cursor.execute(updateSql)
      connection.commit()
      print("gebruiker: "+ segments[0]+ " is gevallen op ACHTERWAARTS met een snelheid van "+ segments[4] +" ;")
    elif segments[3] == "5":
      updateSql = "UPDATE user SET fallDirection = "+ segments[3] +", fallTime = "+ segments[4] +" , alert = 1 WHERE jacket_id = "+ segments[0] +" ;"
      cursor.execute(updateSql)
      connection.commit()
      print("gebruiker: "+ segments[0]+ " is gevallen op VOETEN met een snelheid van "+ segments[4] +" ;")
    elif segments[3] == "6":
      updateSql = "UPDATE user SET fallDirection = "+ segments[3] +", fallTime = "+ segments[4] +" , alert = 1 WHERE jacket_id = "+ segments[0] +" ;"
      cursor.execute(updateSql)
      connection.commit()
      print("gebruiker: "+ segments[0]+ " is gevallen op HOOFD met een snelheid van "+ segments[4] +" ;")
  else:
    # algemene fout - Communicatie MODULE
    # TODO - Alegmene fout loggen in SQL
    print("gebruiker: ", segments[0], " User Fout")

       