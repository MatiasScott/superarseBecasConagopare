import mysql.connector
import bcrypt

# CONFIGURACION DE BASE DE DATOS
db = mysql.connector.connect(
    host="23.111.136.182",
    user="superar1_Tics",
    password="/Msvs5297*",
    database="superar1_becas_conagopare"
)

cursor = db.cursor()

email = input("Ingrese el email del usuario: ")
new_password = input("Nueva contraseña: ")

# generar hash compatible con PHP password_hash
hashed = bcrypt.hashpw(new_password.encode('utf-8'), bcrypt.gensalt())

sql = "UPDATE users SET password = %s WHERE email = %s"

cursor.execute(sql, (hashed.decode('utf-8'), email))
db.commit()

if cursor.rowcount > 0:
    print("✅ Contraseña actualizada correctamente")
else:
    print("⚠️ No se encontró usuario con ese email")

cursor.close()
db.close()