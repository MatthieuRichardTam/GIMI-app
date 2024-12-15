# GIMI - Intelligent Management of Injectable Medications

## Description
GIMI is a web application designed to improve the management of medication infusions in hospital settings. This project was developed by 12 students from École Centrale de Lille in collaboration with CHU de Lille and the CRIStAL laboratory. The goal is to reduce noise disturbances caused by alarms and to limit medication incompatibilities during multiple injections.

## Key Features

### 1. Alarm Reduction
- **Injection Dashboard**: Real-time visualization of ongoing infusions, prioritized by color (green, yellow, red, white, blue).
- **Proactive Notifications**: Alerts for imminent injection completions.

### 2. Management of Medication Incompatibilities
- **Compatibility Test**: Verification of potential interactions between multiple medications.
- **Incompatibility Warnings**: Alerts when adding an incompatible injection.

## Installation and Configuration

### Prerequisites
- [XAMPP](https://www.apachefriends.org/index.html) (Apache and MySQL server).

### Installation Steps

#### 1. Install XAMPP
- Download and install XAMPP.
- Start Apache and MySQL from the XAMPP control panel.

#### 2. Configure Application Files
- Copy the project files to `C:\xampp\htdocs\GIMI`.

#### 3. Initialize the Database
- Open [phpMyAdmin](http://localhost/phpmyadmin).
- Create a database named `gimi`.
- Import the `gimi.sql` file located in `assets`.

#### 4. Launch the Application
- Open a browser and go to `http://localhost/GIMI`.
- Use the credentials defined in the `users` table to log in.

## Technical Structure

### Front-End
- Languages: HTML, CSS (via Tailwind), JavaScript (AJAX).
- Reusable components: `head.php`, `sidebar.php`, etc.

### Back-End
- Languages: PHP, SQL.
- Object-Oriented Programming: Classes such as `Patient`, `Injection`, and `PdoMySQL`.

### Database
- Key tables:
  - `users`: User management.
  - `patients`: Patient information.
  - `injections`: Infusion data.
  - `compatibilities`: Management of medication compatibilities.

## Screenshots and Page Descriptions

### Login Page
![Login Page](screenshots/login_page.png)
The login page allows users to authenticate with their username and password. Once logged in, they are redirected to the main dashboard.

### Dashboard
![Dashboard](screenshots/dashboard.png)
The dashboard displays ongoing infusions, prioritized by urgency. Patients with critical infusions appear at the top of the list. Injections are color-coded based on their status:
- **Green**: Recently started injection.
- **Yellow**: Injection nearing completion.
- **Red**: Injection requiring immediate attention.

### Compatibility Test Page
![Compatibility Test](screenshots/compatibility_page.png)
This page allows users to check for incompatibilities between multiple medications. Users select medications from a dropdown menu, and the system displays any detected incompatibilities.

### Add Patient Page
![Add Patient](screenshots/add_patient.png)
This page enables users to add new patients to the database. Users input details such as the patient's name, birth date, room, and bed.

### Add Injection Page
![Add Injection](screenshots/add_injection.png)
Users can add injections for a patient by specifying details such as the medication, dosage, and flow rate. The system automatically checks for potential incompatibilities.

### Notifications Page
![Notifications Page](screenshots/notifications.png)
This page displays the most urgent injections requiring immediate intervention. Healthcare professionals can take charge of an alert and mark it as resolved after completing the necessary actions.

## Authors
- Developed by 12 students from École Centrale de Lille.
- Supervised by CHU de Lille


