[GROUP PROJECT-OR.pdf](https://github.com/user-attachments/files/28735959/GROUP.PROJECT-OR.pdf)

AHMAD FUAD BIN EMIRUL FAIZAL (2240230)
PKDT MUHAMMAD AIMUS ALAMIN BIN ZURAIDI (2240238)
PKDT MUHAMMAD AZROL HAFIZ BIN ASROL MIZAL (2240239)
PKDT SAIDFUDIN BIN EBBAS (2240247)

# UPNM Facility Allocation System using Linear Programming

A web-based facility allocation and optimization system developed for the Operational Research (TSI3743) project. The system utilizes a Linear Programming (LP) optimization engine to dynamically allocate operational hours between two user groups (Cadets and Public) while satisfying predetermined capacity and resource constraints.

## 📝 Project Description

Managing campus facilities efficiently requires a systematic balancing act between standard operating constraints and targeted priorities. This system provides an automated solution that mathematical models operational research theories into a working web application. 

### Key Features:
* **Role-Based Access Control (RBAC):** Strict interface and permission separation between Administrators and General Users (Cadets/Public).
* **LP Optimization Engine:** A robust brute-force backend (`process.php`) that computes optimal hour allocations based on structural mathematical constraints ($2x + y \le 60$, $x \ge 10$) to maximize facility utilization ($Max\ Z = 5x + 3y$).
* **Real-time Status Monitoring:** Live data feeds showcasing remaining facility available hours and active user reservation tracking.
* **Administrative Central Hub:** Secure controls allowing admins to run optimization engines, view system history logs, and reset resource capacities back to default baselines.

---

## 🚀 Instructions to Run the System Locally

Follow these steps to deploy and run the system on a local server environment:

### Prerequisites
1. Download and install **XAMPP** (with PHP 8.0 or higher) from [apachefriends.org](https://www.apachefriends.org/).
2. Ensure you have a modern web browser installed.

### Step 1: Clone or Place the Project Files
1. Copy the entire project folder (`campus_lp_system`) containing all PHP and CSS files.
2. Navigate to your local server directory, which is typically found at:
   * **Windows:** `C:\xampp\htdocs\`
   * **Mac:** `/Applications/XAMPP/xamppfiles/htdocs/`
3. Paste the project folder directly inside the `htdocs` directory.

### Step 2: Database Setup & Configuration
1. Open XAMPP Control Panel and start both **Apache** and **MySQL** modules.
2. Open your browser and navigate to the database management tool: `http://localhost/phpmyadmin/`
3. Create a new database named exactly: `campus_lp_db` (or look at your `db.php` configuration file).
4. Click on the **Import** tab at the top menu.
5. Choose the SQL file provided with this project (e.g., `campus_lp_db.sql` or your relevant backup database file) and click **Go** to generate the necessary tables (`users`, `optimization_input`, `optimization_results`, `facility_status`).

### Step 3: Launching the Web Application
1. In your web browser, enter the following URL to access the main portal:
   ```html
   http://localhost/campus_lp_system/index.php

To test the User View, use the standard user credentials provided during registration.
To test the Admin View, navigate directly to the admin gateway page at http://localhost/campus_lp_system/admin_login.php and authenticate using admin credentials.
