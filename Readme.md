# Harrobi Web Aplikazioa

## 📌 Deskribapena
Harrobi enpresarentzat egindako **web aplikazioa** da hau.  
Aplikazio honen bidez, bezeroak, langileak eta instalazioak kudeatu daitezke modu errazean.  
Sistema hau PHPn garatua dago eta MariaDB/MySQL datu-base bat erabiltzen du.

---

## ⚙️ Ezaugarri nagusiak
**Bezeroen kudeaketa**  
  - Bezero berriak gehitu (bezeroaGehitu.php)  
  - Datuak aldatu (bezeroaAldatu.php)  
  - Ezabatu (bezeroaEzabatu.php)  
  - Bezeroen zerrenda ikusi (bezeroa.php)

**Langileen kudeaketa**  
  - Langileen informazioa ikusi eta editatu (langilea.php)  
  - Langileak model/langileak.php fitxategitik kudeatzen dira.

**Instalazioen kudeaketa**  
  - Instalazio berriak gehitu (gehituInstalazioa.php)  
  - Datuak aldatu (instalazioaAldatu.php)  
  - Ezabatu (instalazioaEzabatu.php)  
  - Zerrenda ikusi (instalazioak.php)

**Erabiltzailearen perfila**  
  - perfila.php fitxategian profil informazioa ikusi eta kudeatu.  

**Saio kudeaketa**  
  - session.php saioaren kontrola.  
  - konexioa.php datu-basearekiko konexioa.

---

## 🛠️ Instalazioa
1. **Eskakizunak**  
   - PHP 7.4+  
   - MariaDB/MySQL  
   - XAMPP edo antzeko ingurune bat

2. **Datu-basea sortu**  
   - db/harrobi.sql fitxategia inportatu zure datu-base zerbitzarian.  
   - Sortuko dira taulak: bezeroak, langileak, instalazioak, etab.

3. **Konfigurazioa**  
   - konexioa.php editatu eta zure datu-basearen erabiltzailea, pasahitza eta zerbitzaria konfiguratu.

4. **Exekuzioa**  
   - Fitxategi guztiak zure **htdocs** edo web zerbitzariaren karpetan jarri.  
   - Nabigatzailetik ireki:  
     
     http://localhost/Harrobi-main/index.php
     


---

## 📂 Fitxategi garrantzitsuak
index.php → Hasierako orria  
bezeroa.php → Bezeroen zerrenda  
langilea.php → Langileen atala  
instalazioak.php → Instalazioen atala  
perfila.php → Erabiltzailearen profila  
konexioa.php → Datu-basearekiko konexioa  
session.php → Saioaren kontrola  

**Modeloak (logika):**
model/bezeroak.php  
model/langileak.php  
model/instalazioa.php  

**Estiloa:**
css/form.css  
css/login.css  
css/taulak.css  

---


