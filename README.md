
# iNotes - Task Manager

A sleek, full-stack Task Management application built to demonstrate professional **CRUD (Create, Read, Update, Delete)** operations. This project features a modern "Glassmorphism" inspired dashboard and real-time data filtering.

## 🚀 Key Features

* **Full CRUD Lifecycle:** Seamlessly add, view, edit, and delete notes with instant database synchronization.
* **Pro Search & Filtering:** Integrated **DataTables.js** for high-speed searching, pagination, and sorting of your tasks.
* **Modern UI/UX:** Developed with **Bootstrap 5**, featuring a semi-transparent blur (backdrop-filter) and a responsive, high-fidelity workspace theme.
* **Interactive Modals:** Uses JavaScript-driven Bootstrap modals for an "edit-in-place" user experience without full page reloads.
* **Security:** Implements `mysqli_real_escape_string` and `htmlspecialchars()` to mitigate SQL injection and XSS vulnerabilities.

## 🛠️ Tech Stack

* **Backend:** PHP
* **Database:** MySQL
* **Frontend:** HTML5, CSS3, JavaScript (jQuery)
* **Libraries:** * [Bootstrap 5](https://getbootstrap.com/) (Layout & Components)
* [DataTables](https://datatables.net/) (Advanced Table Logic)
* [Bootstrap Icons](https://icons.getbootstrap.com/)



## 📋 Database Configuration

To get this project running locally, create a database named `notes` and execute the following SQL to build the table:

```sql
CREATE DATABASE IF NOT EXISTS `notes`;
USE `notes`;

CREATE TABLE `notes` (
  `sno` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(50) NOT NULL,
  `description` TEXT NOT NULL,
  `tstamp` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`sno`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

```

## ⚙️ Installation

1. **Clone the Repo:** Move the files to your local server directory (e.g., `C:\xampp\htdocs\todolist\`).
2. **Database:** Import the SQL schema provided above via phpMyAdmin.
3. **Configure:** Ensure the `$servername`, `$username`, and `$password` in `index.php` match your local XAMPP/WAMP settings.
4. **Launch:** Navigate to `http://localhost/todolist/index.php`.

