# 📚 TheBookHouse — Projekti Web

Aplikacion web i ndërtuar me **PHP** (OOP), **HTML5**, **CSS3** dhe **JavaScript** që simulon një librari online. Sistemi mbështet dy role — **përdorues të rregullt** dhe **administrator** — me autentikim të plotë përmes sesioneve dhe cookie-ve.

---

## 📋 Përmbajtja

- [Kërkesat e Sistemit](#-kërkesat-e-sistemit)
- [Struktura e Projektit](#-struktura-e-projektit)
- [Udhëzime për Ekzekutim](#-udhëzime-për-ekzekutim)
- [Kredencialet e Paracaktuara](#-kredencialet-e-paracaktuara)
- [Faqet dhe Funksionalitetet](#-faqet-dhe-funksionalitetet)
- [Sistemi i Autentikimit](#-sistemi-i-autentikimit)
- [Arkitektura OOP](#-arkitektura-oop)
- [Ruajtja e të Dhënave](#-ruajtja-e-të-dhënave)
- [Teknologjitë e Përdorura](#-teknologjitë-e-përdorura)
- [Shënime të Rëndësishme](#-shënime-të-rëndësishme)

---

## ⚙️ Kërkesat e Sistemit

| Kërkesa | Versioni minimal |
|---------|-----------------|
| PHP | 7.4 ose më i ri |
| Server lokal | XAMPP / WAMP / MAMP |
| Shfletues | Chrome, Firefox, Edge (modern) |
| Sistem operativ | Windows / macOS / Linux |

---

## 🗂️ Struktura e Projektit

```
theBookHouse-Projekti-WEB-2/
│
├── index.php                        # Faqja kryesore (homepage)
│
├── config/
│   └── constants.php                # BASE_URL — konstanta globale e projektit
│
├── auth/                            # Logjika e autentikimit
│   ├── loginLogic.php               # Procesimi i formularit të kyçjes
│   ├── logout.php                   # Shkatërrimi i sesionit dhe fshirja e cookie-t
│   ├── registerLogic.php            # Procesimi i formularit të regjistrimit
│   ├── sessionCheck.php             # Funksionet: requireLogin, requireUser, sessionTimeout
│   └── adminCheck.php               # Funksioni: requireAdmin (mbron faqet e adminit)
│
├── classes/                         # Klasat OOP
│   ├── User.php                     # Klasa bazë për përdoruesin
│   ├── Admin.php                    # Klasa Admin (trashëgon User) — menaxhon libra/autorë
│   ├── Book.php                     # Klasa Book — filtrim, kërkim, renditje
│   ├── Author.php                   # Klasa Author
│   └── Category.php                 # Klasa Category
│
├── data/                            # Ruajtja e të dhënave (skedarë PHP)
│   ├── users.php                    # Lista e përdoruesve (shkruhet dinamikisht)
│   ├── books.php                    # Lista e 32 librave me të gjitha detajet
│   ├── authors.php                  # Lista e autorëve
│   └── categories.php               # Lista e kategorive
│
├── includes/                        # Komponentë të përbashkët
│   ├── header.php                   # Navigimi, logo, menu
│   └── footer.php                   # Footer me social media links
│
├── pages/                           # Faqet e aplikacionit
│   ├── books.php                    # Lista e librave me kërkim/filtrim/renditje
│   ├── bookDetails.php              # Detajet e një libri të vetëm
│   ├── login.php                    # Faqja e kyçjes
│   ├── register.php                 # Faqja e regjistrimit
│   ├── profile.php                  # Profili i përdoruesit (kërkon kyçje)
│   └── admin/
│       ├── dashboard.php            # Paneli i adminit — menaxhimi i përdoruesve
│       └── manageBooks.php          # Menaxhimi i librave nga admini
│
├── utils/                           # Funksione ndihmëse
│   ├── functions.php                # searchBooks, filterByCategory, sortByPrice, normalizeArray
│   └── validator.php                # Validimi me Regex (emër, email, fjalëkalim, etj.)
│
└── assets/
    ├── css/
    │   ├── style.css                # Stilet kryesore globale
    │   ├── pages.css                # Stilet për faqet individuale
    │   └── admin.css                # Stilet për panelin e adminit
    ├── js/
    │   ├── script.js                # Slider, animacione, interaktivitet
    │   ├── pages.js                 # Logjika JS për faqet
    │   └── admin.js                 # Logjika JS për panelin e adminit
    └── images/
        ├── coverimages/             # Kopertina e 32 librave
        └── [imazhe të tjera]        # Logo, hero images, etj.
```

---

## 🚀 Udhëzime për Ekzekutim

### Hapi 1 — Shkarko dhe Vendos Projektin

1. Shkarko skedarin `.zip` të projektit.
2. Ekstrakto dosjen dhe kopjoje brenda direktorisë root të serverit:

| Server | Direktoria |
|--------|------------|
| XAMPP (Windows) | `C:\xampp\htdocs\` |
| XAMPP (macOS) | `/Applications/XAMPP/htdocs/` |
| XAMPP (Linux) | `/opt/lampp/htdocs/` |
| WAMP | `C:\wamp64\www\` |
| MAMP | `/Applications/MAMP/htdocs/` |

Struktura finale duhet të duket kështu:
```
htdocs/
└── theBookHouse-Projekti-WEB-2/
    ├── index.php
    ├── config/
    ├── auth/
    └── ...
```

---

### Hapi 2 — Verifiko BASE_URL

Hap skedarin `config/constants.php` dhe kontrollo:

```php
define('BASE_URL', '/theBookHouse-Projekti-WEB-2/');
```

> ⚠️ Nëse ke riemërtuar dosjen e projektit, ndrysho vlerën e `BASE_URL` që të përputhet me emrin e ri. Kjo konstantë përdoret në të gjitha lidhjet dhe ridrejtimet e projektit.

---

### Hapi 3 — Ndiz Serverin Apache

1. Hap **XAMPP Control Panel** (ose ekuivalentin tënd).
2. Kliko **Start** pranë **Apache**.
3. Sigurohu që statusi të jetë **"Running"**.

> ℹ️ Projekti **nuk kërkon MySQL** — nuk është e nevojshme të ndizni modulin MySQL.

---

### Hapi 4 — Lejo Shkrimin në Dosjen `data/`

Regjistrimi i përdoruesve të rinj shkruan direkt në `data/users.php`. Sigurohu që dosja ka **leje shkrimi**:

- **Windows (XAMPP)**: Zakonisht funksionon pa konfigurim shtesë.
- **macOS/Linux**: Ekzekuto në terminal:
  ```bash
  chmod 755 /opt/lampp/htdocs/theBookHouse-Projekti-WEB-2/data/
  ```

---

### Hapi 5 — Hap Projektin në Shfletues

```
http://localhost/theBookHouse-Projekti-WEB-2/
```

---

## 🔑 Kredencialet e Paracaktuara

### 👑 Administrator
| Fusha | Vlera |
|-------|-------|
| Username | `admin` |
| Fjalëkalimi | `admin123` |
| Email | `admin@bookhouse.com` |
| Akses | Dashboard + Manage Books |

### 👤 Përdorues i Rregullt
| Fusha | Vlera |
|-------|-------|
| Username | `dren` |
| Fjalëkalimi | `dren123` |
| Email | `user@bookhouse.com` |
| Akses | Books, Profile |

> 💡 Mund të krijosh llogari të re direkt nga faqja `/pages/register.php`.

---

## 📄 Faqet dhe Funksionalitetet

### 🏠 Homepage (`index.php`)
- **Slider automatik** me 4 seksione hero (Books, Recommendations, Book Club, New Arrivals)
- **Karta interaktive** me efekt flip 3D (Diverse Collection, Community Events, Personalized Recommendations)
- **Prezantim i librave** me 3 kopertina të rrotulluara dhe efekt vizual
- **Statistika animate** — counter fillon nga 0 dhe numëron deri te vlera finale (32 libra, 15 vjet, 10 klientë)
- **Seksion About Us** dhe **social media links** (Facebook, X, LinkedIn, Instagram, YouTube, TikTok)

---

### 📖 Lista e Librave (`pages/books.php`)
- Shfaq të gjithë librat e disponueshëm nga `data/books.php`
- **Kërkim** sipas titullit (GET parametri `q`)
- **Filtrim** sipas kategorisë (GET parametri `category`)
- **Renditje** sipas çmimit — nga më i lirë ose nga më i shtrenjtë (GET parametri `sort`)
- Të gjitha filtrat mund të kombinohen njëkohësisht

```
Shembull URL: /pages/books.php?q=harry&category=4&sort=price_asc
```

---

### 📘 Detajet e Librit (`pages/bookDetails.php`)
- Hapet me parametrin `book_id` në URL: `/pages/bookDetails.php?book_id=1`
- Shfaq: titull, autor, kategori, përshkrim, çmim dhe sasinë në stok
- Nëse libri është **jashtë stoku**, shfaqet mbivendosje "Out of Stock"
- Butonat **Add to Cart**, **Wishlist** dhe **Buy Now** ridrejtojnë tek faqja e kyçjes

---

### 🔐 Regjistrimi (`pages/register.php`)
Formulari i regjistrimit ka **validim të plotë** me Regex:

| Fusha | Rregulli i Validimit |
|-------|---------------------|
| Emri | Vetëm shkronja, minimum 2 karaktere |
| Mbiemri | Vetëm shkronja, minimum 2 karaktere |
| Username | Shkronja, numra dhe `_`, minimum 3 karaktere |
| Email | Format valid (`filter_var FILTER_VALIDATE_EMAIL`) |
| Fjalëkalimi | Minimum 6 karaktere |
| Konfirmo Fjalëkalimin | Duhet të përputhet me fjalëkalimin |

Kontrolle shtesë:
- Email-i nuk duhet të ekzistojë tashmë në sistem
- Username nuk duhet të ekzistojë tashmë në sistem

Pas regjistrimit të suksesshëm:
- Fjalëkalimi **enkriptohet** me `password_hash()` (algoritmi bcrypt)
- Përdoruesi **logohet automatikisht** dhe ridrejtohet tek `/pages/books.php`

---

### 🔑 Kyçja (`pages/login.php`)
- Autentikim me **username + fjalëkalim**
- Mbështet fjalëkalime të hashura (bcrypt) dhe plaintext (për kompatiblitet me llogari të vjetra)
- Opsioni **"Më mbaj mend"** krijon cookie `remember_user` me kohëzgjatje **7 ditë**
- Pas kyçjes: admini shkon tek `/pages/admin/dashboard.php`, përdoruesi i rregullt tek `/pages/books.php`
- Nëse je tashmë i kyçur, faqja shfaq një overlay me opsionet "Logout" ose "Go to Dashboard/Books"

---

### 👤 Profili (`pages/profile.php`)
- **Kërkon kyçje aktive** — ridrejton tek login nëse sesioni nuk ekziston
- **Kërkon rolin `user`** — admini ridrejtohet automatikisht tek dashboard
- Shfaq: emrin e plotë, username, email, numër telefoni, adresë dhe rolin
- Butonat "Edit Profile" dhe "Change Password" (funksionalitet i planifikuar)

---

### 🛠️ Paneli i Adminit (`pages/admin/dashboard.php`)
- **Kërkon rolin `admin`** — çdo rol tjetër ridrejtohet tek `/pages/books.php`
- Shfaq listën e të gjithë përdoruesve të regjistruar
- Mbështet **kërkim** sipas username ose email

---

### 📚 Menaxhimi i Librave (`pages/admin/manageBooks.php`)
- **Vetëm për admin** — i mbrojtur nga `requireAdmin()`
- Lista e librave me kërkim, filtrim sipas kategorisë dhe renditje sipas çmimit
- Aksionet e menaxhimit: shto, ndrysho dhe fshi libra

---

## 🔒 Sistemi i Autentikimit

### Sesionet
`$_SESSION['user']` ruan të dhënat: `id`, `name`, `username`, `role`

### Timeout Automatik
- Sesioni shkatërrohet automatikisht pas **30 minutash** mosaktiviteti
- Implementohet nga funksioni `enforceSessionTimeout(1800)` në `sessionCheck.php`
- Pas skadimit, ridrejton tek `/pages/login.php?timeout=1`

### Cookie "Më mbaj mend"
- Krijohet gjatë kyçjes nëse zgjidhet opsioni "Remember Me"
- Skedon pas **7 ditësh** (86400 × 7 sekonda)
- Fshihet plotësisht gjatë daljes nga sistemi (`auth/logout.php`)
- Përmban të dhënat e sesionit të enkoduar si JSON

### Mbrojtja e Faqeve
| Funksioni | Vendndodhja | Efekti |
|-----------|-------------|--------|
| `requireLogin()` | `sessionCheck.php` | Kërkon çdo sesion aktiv |
| `requireUser()` | `sessionCheck.php` | Kërkon rolin `user` + zbaton timeout |
| `requireAdmin()` | `adminCheck.php` | Kërkon rolin `admin` + zbaton timeout |
| `blockIfLoggedIn()` | `sessionCheck.php` | Bllokon hyrjen në login/register nëse je tashmë i kyçur |

---

## 🏗️ Arkitektura OOP

### Klasa `User` (`classes/User.php`)
```
Atributet:  id, name, surname, username, email, password, phone, address, role
Metodat:    getId(), getFullName(), getUsername(), getRole()
            isAdmin(), checkPassword()
Statike:    login($users, $username, $password)
```

### Klasa `Admin` (`classes/Admin.php`) — trashëgon `User`
```
Metodat shtesë:
  Librat:   addBook(), deleteBook(), updateBook(), updateStock()
  Autorët:  addAuthor(), deleteAuthor(), updateAuthor()
```

### Klasa `Book` (`classes/Book.php`)
```
Atributet:  id, title, author_id, category_id, price, stock, description, cover
Metodat:    getId(), getTitle(), getPrice(), getStock(), getDescription(), getCover()
            getAuthor($authors), getCategory($categories)
            isInStock(), reduceStock($qty)
Statike:    getAll(), findById(), filterByCategory(), filterInStock(), search(), sortByPrice()
```

### Klasa `Author` (`classes/Author.php`)
```
Metodat statike: findById($authors, $id)
```

### Klasa `Category` (`classes/Category.php`)
```
Metodat statike: findById($categories, $id)
```

---

## 💾 Ruajtja e të Dhënave

Projekti **nuk përdor bazë të dhënash (MySQL)**. Të gjitha të dhënat ruhen si **vargje PHP** në skedarë brenda dosjes `data/`:

| Skedari | Përmbajtja | Shkruhet dinamikisht? |
|---------|------------|----------------------|
| `data/users.php` | 5 përdorues (1 admin + 4 users) | ✅ Po — pas çdo regjistrimi |
| `data/books.php` | 32 libra me çmim, stok, autor, kategori | Manualisht |
| `data/authors.php` | Lista e autorëve | Manualisht |
| `data/categories.php` | Kategoritë (Fantasy, Fiction, Poetry, etj.) | Manualisht |

Regjistrimi i një përdoruesi të ri rishkruan `data/users.php` duke përdorur:
```php
file_put_contents($filePath, "<?php\n\n\$users = " . var_export($users, true) . ";\n\n?>");
```

---

## 🛠️ Teknologjitë e Përdorura

| Teknologjia | Versioni | Qëllimi |
|-------------|----------|---------|
| PHP | 7.4+ | Logjika e serverit, OOP, sesione, cookie |
| HTML5 | — | Struktura e faqeve |
| CSS3 | — | Dizajni, animacionet, efekti flip 3D i kartave |
| JavaScript (Vanilla) | — | Slider hero, counter animacion, interaktivitet |
| Regex (PHP) | — | Validimi i inputeve të formularëve |
| `password_hash()` bcrypt | — | Enkriptimi i sigurt i fjalëkalimeve |
| File-based storage | — | Ruajtja e të dhënave pa nevojën e MySQL |
| Font Awesome | CDN | Ikonat e social media dhe ndërfaqes |

---

## 📝 Shënime të Rëndësishme

1. **Nuk kërkohet MySQL** — mos e ndize modulin MySQL në XAMPP, projekti nuk e përdor.
2. **Leje shkrimi** — skedari `data/users.php` dhe dosja `data/` duhet të jenë të shkrueshme nga serveri për funksionimin e regjistrimit të përdoruesve të rinj.
3. **BASE_URL** — nëse projekti nuk hapet siç duhet, kontrollo që vlera e `BASE_URL` në `config/constants.php` të përputhet saktësisht me emrin e dosjes së projektit.
4. **Fjalëkalimet** — ruhen të enkriptuara me bcrypt. Fjalëkalimet e paracaktuara (`admin123`, `user123`) janë tashmë të hashura brenda `data/users.php`.
5. **Timeout sesioni** — pas 30 minutash mosaktiviteti, sesioni shkatërrohet automatikisht.
6. **Cookie "Më mbaj mend"** — ruan gjendjen e kyçjes për 7 ditë dhe fshihet plotësisht me logout.
7. **Ridrejtimet sipas rolit** — admini gjithmonë ridrejtohet tek dashboard, ndërsa përdoruesi i rregullt tek books.
