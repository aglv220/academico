from array import array
from lib2to3.pgen2 import driver
from telnetlib import EC
from token import OP
from traceback import print_tb
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.options import Options
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import json

#definir opciones de ingreso a chrome
opts = Options()
opts.add_argument("Chrome/51.0.2704.103 --headless")

#definir driver de google chrome
driver = webdriver.Chrome('./chromedriver.exe',options=opts)
#ejecutar pagina semilla
driver.get('https://canvas.utp.edu.pe/login/ldap')

#definir boton de acceder con cuenta de canvas y hacer click 
buton1= driver.find_element(By.XPATH,'//div[@class="ctacanvas_main"]')
buton1.click() 

#definir credenciales 
user = open('correo.txt').readline().strip()
#definir contraseña y leer el archivo  
password = open('password.txt').readline().strip()

#recorrer el doom y buscar el input 
input_user = WebDriverWait(driver, 10).until(
    EC.presence_of_element_located((By.XPATH,'//input[@id="pseudonym_session_unique_id"]'))
)
input_pass = driver.find_element(By.XPATH,'//input[@id="pseudonym_session_password"]')
#ingresar credenciales de usuario y contraseña en canvas 
input_user.send_keys(user)
input_pass.send_keys(password)

#declarar el boton de login y hacer click
boton = driver.find_element(By.XPATH,'//button[@class="Button Button--login"]')
boton.click() 

#acceder al menu de cursos y hacer click 
#menuCurso = driver.find_element(By.XPATH,'//header[@id="header"]//button[@id="global_nav_courses_link"]')
#menuCurso.click()

#curso1 = WebDriverWait(driver,20).until(
     # EC.presence_of_all_elements_located((By.XPATH,'//a[@class="fOyUs_bGBk fbyHH_bGBk fbyHH_bSMN"]'))
#)

tareas = WebDriverWait(driver,20).until(
     EC.presence_of_all_elements_located((By.XPATH,'//a[@class="fOyUs_bGBk fbyHH_bGBk fbyHH_bSMN"]//span[@class="ergWt_bGBk"]'))
)

cursos = WebDriverWait(driver,20).until(
     EC.presence_of_all_elements_located((By.XPATH,'//span[@class="Grouping-styles__title"]'))
)

datos = []  

for curso in cursos:
     for tarea in tareas:
          datos.append(curso.get_attribute("innerHTML")+";"+tarea.get_attribute("innerHTML"))


with open('canvas.json', 'w') as file:
    json.dump(datos, file)