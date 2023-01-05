import sqlite3, datetime, time, subprocess, openpyxl, os#, pyAlarm
from gtts import gTTS



# db_path = "/Users/michalfugas/Documents/Projekty IT/Python/LimmatAlarm/Limmat.db"
db_path = "/home/pi/Limmat/Limmat.db"
# path = '/Users/michalfugas/Documents/Projekty IT/Python/LimmatAlarm/Dienste/'
path = '/home/pi/Limmat/Dienste/'
def connetionTable():

    conn = sqlite3.connect(db_path)
    k = conn.cursor()
    k.execute('CREATE TABLE if not exists ConnectionTable (Shift TEXT,Name TEXT);')
    conn.commit()
    k.execute('delete from ConnectionTable')

    date_today = datetime.date.today()
    # print(date_today.isoweekday())

    try:
        dayPath = (date_today.strftime("%d") + '.' + date_today.strftime("%m") + '.' + date_today.strftime("%y"))
        finalPath = os.path.join(path, dayPath + '.xlsx')
        wb = openpyxl.load_workbook(finalPath)
    except:
        dayPath = (date_today.strftime("%d") + '.' + date_today.strftime("%m") + '.' + date_today.strftime("%Y"))
        finalPath = os.path.join(path, dayPath + '.xlsx')
        wb = openpyxl.load_workbook(finalPath)

    print(finalPath)
    ws = wb.worksheets[0]

    for wiersz in range(6, ws.max_row):
        if ws.cell(row=wiersz, column=4).value != None:
            shift = ws.cell(row=wiersz, column=4).value
            if shift < 100 and shift < 200:
                shift=shift+100
            elif shift >=500 and shift < 600:
                shift = shift - 400
            elif shift >= 600 and shift < 700:
                shift = shift - 500
            elif shift >= 700 and shift < 800:
                shift = shift - 600
            chaufferName = str(ws.cell(row=wiersz, column=5).value[:-2])

            # print(shift,chaufferName)
            k.execute('insert into ConnectionTable values ("%s","%s");' % (shift,chaufferName))

            conn.commit()
        else:
            k.execute('SELECT * FROM ConnectionTable')
            global ctLength
            ctLength = (len(k.fetchall()))
            print(str(ctLength) + ' CT')
            break
    k.close()
    conn.close()



def audio(nachricht):
    mp3Path = '/home/pi/Limmat/MP3/'
    alarm_file = (mp3Path+"Alarm.mp3")
    audio_file = (mp3Path+"Message.mp3")
    tts = gTTS(text=nachricht, lang="de")
    tts.save(audio_file)
    subprocess.call(["mpg123", "-q", alarm_file])
    time.sleep(0.5)
    subprocess.call(["mpg123", "-q", audio_file])
    # subprocess.call(["afplay", alarm_file])
    # subprocess.call(["afplay", audio_file])



while True:
    connetionTable()
    date_today = datetime.date.today()
    conn = sqlite3.connect(db_path)
    k = conn.cursor()


    k.execute('CREATE VIEW if not exists ZL AS SELECT * FROM Dienste WHERE WeekDay LIKE "%'+str(date_today.isoweekday())+'%";')
    k.execute('SELECT * FROM ZL;')




    k.execute('create table if not exists TT as  SELECT ZL.*, Chaffeure.* FROM ZL, Chaffeure, ConnectionTable  WHERE ConnectionTable.Shift=ZL.Part_1 AND Chaffeure.Name LIKE ConnectionTable.Name;')
    k.execute('SELECT * FROM TT;')
    # table = k.fetchall()
    tempTableLength = len(k.fetchall())
    print(str(tempTableLength) + ' TT')
    if tempTableLength != ctLength:
        print('ERROR')

    ctPPL = k.execute('SELECT Name FROM ConnectionTable;')
    ctPPL = k.fetchall()
    ttPPL = k.execute('SELECT Name FROM TT;')
    ttPPL = k.fetchall()
    res = [x for x in ctPPL + ttPPL if x not in ctPPL or x not in ttPPL]
    print(res)

    k.close()
    conn.close()
    break

    while True:
        conn = sqlite3.connect(db_path)
        k = conn.cursor()
        k.execute('SELECT * FROM TT;')
        table = k.fetchall()


        time_now = datetime.datetime.now().strftime('%H:%M')
        for row in table:

    # Checking Allarm_1-----------------------------------------------------

            if row[3] == time_now and row[4] is None:
                if row[5] is None:                                                  # Chceck if allarm was on

                    pyAlarm.call(str(row[18]))
                    try:
                        audio(str(row[17] + ' ' + 'bitte Dienst' + row[0] + '' + 'quittieren'))
                    except:
                        pass
                    time.sleep(1)
                    #print(str(row[18]) +' '+str(row[17])+' '+str(row[0]))
                    pyAlarm.sms(str(row[18]),str(row[17]),str(row[0]))
                    pyAlarm.smsPiket("0797937656",str(row[17]),str(row[0]))


                    # print('Wyslana')
                    # print('')
                    k.execute('UPDATE TT set Alarm_1=1 WHERE Part_1= %s;' % row[0])
                    conn.commit()

    # Checking Allarm_2-----------------------------------------------------
            if (row[8] == time_now and row[9] is None):
                if (row[10] is None):                                               # Chceck if allarm was on

                    pyAlarm.call(str(row[18]))
                    try:
                        audio(str(row[17]+' '+'bitte Dienst'+row[6]+''+'quittieren'))
                    except:
                        pass
                    time.sleep(1)
                    pyAlarm.sms(str(row[18]), str(row[17]), str(row[6]))
                    pyAlarm.smsPiket("0797937656", str(row[17]), str(row[6]))


                    # print('Wyslana')
                    # print('')
                    k.execute('UPDATE TT set Alarm_2=1 WHERE Part_1= %s;'% row[0])
                    conn.commit()
    # Checking Allarm_3-----------------------------------------------------
            if (row[13] == time_now and row[14] is None):
                if (row[15] is None):                                               # Chceck if allarm was on

                    pyAlarm.call(str(row[18]))
                    try:
                        audio(str(row[17] + ' ' + 'bitte Dienst' + row[11] + '' + 'quittieren'))
                    except:
                        pass
                    time.sleep(1)
                    pyAlarm.sms(str(row[18]), str(row[17]), str(row[11]))
                    pyAlarm.smsPiket("0797937656", str(row[17]), str(row[11]))

                    # pyAlarm.sms(str(row[18]), 'Dein Dienst hat schon angefangen, bitte quittieren')


                    # print('Wyslana')
                    # print('')
                    k.execute('UPDATE TT set Alarm_3=1 WHERE Part_1= %s;' % row[0])
                    conn.commit()
    #-----------------------------------------------------------------------

        print(time_now)
        time.sleep(15)
        k.close()
        conn.close()
        if time_now == '03:00':
            conn = sqlite3.connect(db_path)
            k = conn.cursor()
            k.execute('DROP TABLE if exists TT;')
            k.execute('DROP VIEW if exists ZL;')
            k.close()
            conn.close()
            print('break')
            time.sleep(30)
            break
