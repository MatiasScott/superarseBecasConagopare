import tkinter as tk
from tkinter import messagebox
import mysql.connector
import bcrypt

# CONEXION BASE DE DATOS
db = mysql.connector.connect(
    host="23.111.136.182",
    user="superar1_Tics",
    password="/Msvs5297*",
    database="superar1_becas_conagopare"
)

cursor = db.cursor(dictionary=True)

# FUNCIONES

def buscar_usuario():
    email = entry_email.get()

    sql = "SELECT id, email FROM users WHERE email=%s"
    cursor.execute(sql, (email,))
    user = cursor.fetchone()

    if user:
        label_result.config(text=f"Usuario encontrado\nID: {user['id']}\nEmail: {user['email']}")
    else:
        label_result.config(text="Usuario no encontrado")


def resetear_password():
    email = entry_email.get()
    new_password = entry_password.get()

    if not email or not new_password:
        messagebox.showerror("Error", "Ingrese email y contraseña")
        return

    hashed = bcrypt.hashpw(new_password.encode(), bcrypt.gensalt())

    sql = "UPDATE users SET password=%s WHERE email=%s"
    cursor.execute(sql, (hashed.decode(), email))
    db.commit()

    if cursor.rowcount > 0:
        messagebox.showinfo("Éxito", "Contraseña actualizada")
    else:
        messagebox.showerror("Error", "Usuario no encontrado")


def listar_usuarios():
    sql = "SELECT id, email FROM users LIMIT 20"
    cursor.execute(sql)

    users = cursor.fetchall()

    text_users.delete(1.0, tk.END)

    for u in users:
        text_users.insert(tk.END, f"{u['id']} - {u['email']}\n")


# INTERFAZ

window = tk.Tk()
window.title("Panel Admin Usuarios")
window.geometry("500x400")

tk.Label(window, text="Email").pack()

entry_email = tk.Entry(window, width=40)
entry_email.pack()

tk.Label(window, text="Nueva contraseña").pack()

entry_password = tk.Entry(window, show="*", width=40)
entry_password.pack()

tk.Button(window, text="Buscar Usuario", command=buscar_usuario).pack(pady=5)
tk.Button(window, text="Resetear Contraseña", command=resetear_password).pack(pady=5)
tk.Button(window, text="Listar Usuarios", command=listar_usuarios).pack(pady=5)

label_result = tk.Label(window, text="")
label_result.pack(pady=10)

text_users = tk.Text(window, height=10, width=50)
text_users.pack()

window.mainloop()