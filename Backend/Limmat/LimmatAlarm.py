import sqlite3, datetime, time, subprocess, openpyxl, os, pyAlarm, locale
from gtts import gTTS

# locale.setlocale(locale.LC_ALL, "ch_DE")
locale.setlocale(locale.LC_ALL, 'de_CH.UTF-8')
db_path = "/home/pi/Limmat/Limmat.db"

# date_today = datetime.date.today()
# path = '/mnt/local_share/'+'Tageseinteilung_'+date_today.strftime("%y")+'/'+date_today.strftime("%m")+'_'+date_today.strftime("%B")+'_'+date_today.strftime("%Y")+'/'

# print(path)



def log(logText):
    f = open("/home/pi/Limmat/log.txt", "a")
    f.write(str(datetime.datetime.now())[:19]+' -----> '+str(logText)+'\n')
    f.close()
    
def driver_log(logText):
    f = open("/home/pi/Limmat/driver_log.txt", "a")
    f.write(str(datetime.datetime.now())[:19]+' -----> '+str(logText)+'\n')
    f.close()


def connetionTable():

    date_today = datetime.date.today()
    path = '/mnt/local_share/'+'Tageseinteilung_'+date_today.strftime("%y")+'/'+date_today.strftime("%m")+'_'+date_today.strftime("%B")+'_'+date_today.strftime("%Y")+'/'

    conn = sqlite3.connect(db_path)
    k = conn.cursor()
    k.execute('CREATE TABLE if not exists ConnectionTable (Shift TEXT,Name TEXT);')
    conn.commit()
    k.execute('delete from ConnectionTable')

    
    # print(date_today.isoweekday())

    try:
        dayPath = (date_today.strftime("%d") + '.' + date_today.strftime("%m") + '.' + date_today.strftime("%Y"))
        finalPath = os.path.join(path, dayPath + '.xlsx')
        wb = openpyxl.load_workbook(finalPath)
    except:
        dayPath = (date_today.strftime("%d") + '.' + date_today.strftime("%m") + '.' + date_today.strftime("%y"))
        finalPath = os.path.join(path, dayPath + '.xlsx')
        wb = openpyxl.load_workbook(finalPath)



    log(finalPath)
    ws = wb.worksheets[0]

    for wiersz in range(6, ws.max_row):
        if ws.cell(row=wiersz, column=4).value != None:
            shift = ws.cell(row=wiersz, column=4).value
            if shift < 100 and shift < 200:
                shift=shift+100
            elif shift >=500 and shift < 800:
                shift = shift % 100 + 100

            chaufferName = str(ws.cell(row=wiersz, column=5).value[:-2])

            global isoweekdayCheck
            isoweekdayCheck = ws.cell(row=8, column=4).value
            # print(isoweekdayCheck)
            # print('----------------------')

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
    audio_file = (mp3Path+"Message.mp3")
    tts = gTTS(text=nachricht, lang="de")
    tts.save(audio_file)
    time.sleep(0.5)
    subprocess.call(["mpg123", "-q", audio_file])






while True:
    connetionTable()
    date_today = datetime.date.today()
    conn = sqlite3.connect(db_path)
    k = conn.cursor()

    # print(isoweekdayCheck)
    weekday = date_today.isoweekday()
    if isoweekdayCheck < 100:
        print(str(weekday)+ " Tag der Woche")
        pass
    elif isoweekdayCheck > 100:
        weekday = int(isoweekdayCheck / 100)
        print(str(weekday)+ " Tag der Woche")


    k.execute('CREATE VIEW if not exists ZL AS SELECT * FROM Dienste WHERE WeekDay LIKE "%'+str(weekday)+'%";')
    k.execute('SELECT * FROM ZL;')



    k.execute('create table if not exists TT as  SELECT ZL.*, Chaffeure.* FROM ZL, Chaffeure, ConnectionTable  WHERE ConnectionTable.Shift=ZL.Part_1 AND Chaffeure.Name LIKE ConnectionTable.Name;')
    k.execute('SELECT * FROM TT;')
#    table = k.fetchall()
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
        driver_log(res)

    k.close()
    conn.close()


    while True:
        conn = sqlite3.connect(db_path)
        k = conn.cursor()
        k.execute('SELECT * FROM TT;')
        table = k.fetchall()


        time_now = datetime.datetime.now().strftime('%H:%M')
        for row in table:

    # Checking Allarm_1-----------------------------------------------------
            if (row[3] is not None):
                if (str(row[3][0:5]) == time_now and row[4] is None):
                    if row[5] is None:                                                  # Chceck if allarm was on

                        print(str(row[18]))
                        pyAlarm.call(str(row[18]))

                        try:
                            audio(str(row[17] + ' ' + 'bitte Dienst' + row[0] + '' + 'quittieren'))
                        except:
                            pass
                        time.sleep(1)
                        #print(str(row[18]) +' '+str(row[17])+' '+str(row[0]))
                        pyAlarm.sms(str(row[18]),str(row[17]),str(row[0]))
                        pyAlarm.smsPiket("0797937656",str(row[17]),str(row[0]))
                        
                        k.execute('UPDATE TT set Alarm_1=1 WHERE Part_1="%s";' % row[0])
                        conn.commit()
                            
                            
                            

    # Checking Allarm_2-----------------------------------------------------
            if (row[8] is not None):
                if (str(row[8][0:5]) == time_now and row[9] is None):
                    if (row[10] is None):                                               # Chceck if allarm was on

                        pyAlarm.call(str(row[18]))
                        try:
                            audio(str(row[17]+' '+'bitte Dienst'+row[6]+''+'quittieren'))
                        except:
                            pass
                        time.sleep(1)
                        pyAlarm.sms(str(row[18]), str(row[17]), str(row[6]))
                        pyAlarm.smsPiket("0797937656", str(row[17]), str(row[6]))

                        k.execute('UPDATE TT set Alarm_2=1 WHERE Part_1= "%s";'% row[0])
                        conn.commit()

    # Checking Allarm_3-----------------------------------------------------
            if (row[13] is not None):
                if (str(row[13][0:5]) == time_now and row[14] is None):
                    if (row[15] is None):                                               # Chceck if allarm was on

                        pyAlarm.call(str(row[18]))
                        try:
                            audio(str(row[17] + ' ' + 'bitte Dienst' + row[11] + '' + 'quittieren'))
                        except:
                            pass
                        time.sleep(1)
                        pyAlarm.sms(str(row[18]), str(row[17]), str(row[11]))
                        pyAlarm.smsPiket("0797937656", str(row[17]), str(row[11]))

                        k.execute('UPDATE TT set Alarm_3=1 WHERE Part_1= "%s";' % row[0])
                        conn.commit()
                        
    #-----------------------------------------------------------------------

        print(time_now)
        time.sleep(15)
        k.close()
        conn.close()
        if time_now == '03:00':
            
            conn = sqlite3.connect(db_path)
            k = conn.cursor()

            try:
                log('drop tt')
                k.execute('DROP TABLE TT;')                   # k.execute('DROP TABLE if exists TT;')
            except sqlite3.Error as err:
                log(err)
            
            try:
                log('drop zl')
                k.execute('DROP VIEW ZL;')                    # k.execute('DROP VIEW if exists ZL;')
            except sqlite3.Error as err:
                log(err)
            
            try:
                k.execute('DROP VIEW if exists unquittierte;')          # k.execute('DROP VIEW if exists unquittierte;')
            except sqlite3.Error as err:
                log(err)
            
            k.close()
            conn.close()
            # print('break')
            time.sleep(60)

            break
