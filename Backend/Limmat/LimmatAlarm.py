
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
