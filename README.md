# TP 7 
Made by: Hiba Lamsselak
Instructor: Aymane Nefdaoui


## Features:
- CRUD for formations, etudiant and module
- Two relations between the data, a formation has many student, and a formation has many modules
- Dropdown lists filled from the database 
- Sever-side validation
- Confirmation before every deletion and a clear message when a deletion is blocked by a relation
- Success and Error messages after every action
- Responsive bootstarp interface
- A clear homepage and a collapsing menu on every page

## Technologies:
 ### PHP, PDO, SQL, HTML, CSS, Bootstrap


## Analysis & Architecture:
- Legacy Crafts is a cebter that teaches traditional Morrocan arts and workshops.
- This app allows the management of the formations, the students and the modules that make up each formation.
- Every part can be added, displayed, modified and deleted
- Each student is attached to one formation, and a formation can host multiple students.
- Each formationn contains several modules, and each module belongs to one formation.


### Entities & Attributes:

| Entity    | Attributs          | Key |
|-----------|--------------------|-----|
|formations | id, titre, niveau  | id  |
|-----------|--------------------|-----|
|etudiants  | id, nom, tel, email| id  |
|-----------|--------------------|-----|
|modules    | id, titre, heures  | id  |


### Diagramm UML:  
![digramme UML](/images/image.png)

## Data Base:
The data base is named tp7_crud4.
Full script is in database/database.sql

![](/images/img2.png)

![](/images/img3.png)

### etudiant
![etudiant](/images/img4.png)

### formations
![formation](/images/img5.png)

### module
![module](/images/img6.png)

## Structure: 
tp7-crud/
├── index.php                 
├── README.md
├── CSS/
│   └── style.css            
├── images/                   
├── database/
│   ├── connexion.php     
│   └── database.sql          
├── includes/
│   ├── functions.php         
│   ├── header.php            
│   └── footer.php            
├── formations/index.php
        create.php
        edit.php
        delete.php
├── etudiant/                 
        index.php
        create.php
        edit.php
        delete.php
├── module/                   
        index.php
        create.php
        edit.php
        delete.php
└── screenshots/

## The PDO connection (database/connexion.php)
It creates one PDO connection to tp7_crud and stores it in $pdo. The option PDO::ERRMODE_EXCEPTION makes SQL errors throw exceptions, so problems are visible instead of failing silently, and a try / catch shows a clear message if the connection fails. Every page loads this file with require_once, so the connection settings are written only once.

### Shared files (includes/)
The menu, the Bootstrap links and the helper functions are written once and loaded with require_once, so every page stays short and consistent. functions.php contains BASE_URL (so links and styles work from every folder), h() (escapes any printed value to prevent HTML injection) and setFlash() (keeps a message for the next page).

## CRUD:
All the CRUD pages follow the same steps:

- **Read**: query() and fetchAll(PDO::FETCH_ASSOC) return the rows, displayed with a foreach in an HTML table

- **Create**: a form sent with POST, server-side validation, then prepare() and execute() with named placeholders (such as :titre), then a redirect to the list

- **Update**: the id comes from the URL (edit.php?id=3), the row is loaded with SELECT ... WHERE id = :id, the form is prefilled, then UPDATE ... WHERE id = :id

- **Delete**: a small POST form with a confirmation, then DELETE ... WHERE id = :id

## Home:
![home](/images/home.png)

## Formations:
- Read:
the list shows each formation with its number of students and modules 
![formations](/images/form.png)


- Create
The form: Create form
![create](/images/addform1.png)

After submitting, the app redirects to the list. The success message appears and the new formation is displayed.
![create](/images/addform2.png)

- Update: 
The form:
![update](/images/modform1.png)

After submitting, the list shows the updated level and the success message:
![update](/images/morform2.png)

- Delete:
The form: 
![](/images/delform.png)

After submitting: After confirming the deletion, the formation disappears from the list and a message is shown.

![](/images/delform2.png)

### Etudiant:

- Read: The students list before any change. The formation column shows the title (thanks to a JOIN), not the numeric id
![](/images/listet.png)


- Create
The form: The "Add a student" form. The Formation dropdown is filled from the formations table, and the user picks a name
![](/images/addet1.png)

After submitting: The new student appears in the list with the name of his formation, and the success message is displayed
![](/images/addet2.png)

- Update: 
The form: The edit form is prefilled, and the dropdown has the student's current formation selected.
![](/images/upet1.png)

After submitting: After the update, the student's formation changed from Calligraphy to Mosaic in the list.
![](/images/upet2.png)

- Delete:
The form: 
![](/images/delet1.png)

After submitting: After the confirmation, the student is removed from the list and a message is displayed
![](/images/delet2.png)


### Module:

- Read: The modules list before any change, with the hours and the formation title of each module
![](/images/modlist.png)
 


- Create
The form: The "Add a module" form: title, hours (validated between 1 and 500) and a Formation dropdown
![](/images/modadd1.png)

After submitting: The new module appears in the list, attached to its formation, with the success message.
![](/images/modadd2.png)

- Update: 
The form: The edit form is prefilled with the current title, hours and formation.
![](/images/modmod1.png)

After submitting: After saving, the list shows the new number of hours.
![](/images/modmod2.png)


- Delete:
The form: 
![](/images/moddel1.png)

After submitting: The module disappears from the list after the confirmation, and a message is displayed.
![](/images/moddel2.png)


















