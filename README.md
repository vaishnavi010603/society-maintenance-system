
# Society Maintenance Management System

## Project Overview

The **Society Maintenance Management System** is a containerized web application used to manage:

* Monthly maintenance payments
* Society expenses
* Financial reports
* Data backups

The system is deployed on **Linux (RHEL 9)** using **Podman containers**, ensuring portability and easy deployment.

---

# Key Features

## Authentication

* Secure login for the chairman
* Session-based authentication
* Prevents unauthorized access

## Automatic Month Detection

* Automatically detects the current month
* Eliminates the need for manual updates every month

## Maintenance Payment Management

* Record maintenance payments for residents
* Track paid and unpaid entries
* Maintain monthly payment records

## Expense Tracking

* Add and manage society expenses
* Store monthly expense details

## Financial Reporting

* Generate dynamic monthly reports including:

  * Total maintenance collected
  * Total expenses
  * Remaining balance

## PDF Report Generation

* Download monthly financial reports as PDF files
* Useful for documentation and record keeping

## Data Backup

* Download a full backup of system data as a ZIP file
* Backup includes:

  * Payment records
  * Expense records
  * Resident data

## Containerized Deployment

* Fully containerized using **Podman**
* Compatible with Docker environments
* Simplifies application deployment

---

# Technology Stack

* **Backend:** PHP + Apache
* **Frontend:** HTML, CSS
* **Operating System:** RHEL 9
* **Containerization:** Podman
* **PDF Generation:** TCPDF
* **Email Service:** PHPMailer with Gmail SMTP
* **Data Storage:** CSV Files

---

# Project Structure

```
society-maintenance-system/

Containerfile
compose.yml

public/
  index.php
  login.php
  logout.php
  dashboard.php
  mark_payment.php
  add_expense.php
  report.php
  download_pdf.php
  send_email.php
  backup.php

data/
  residents.csv
  payments.csv
  expenses.csv

css/
  style.css

libs/
  tcpdf/
  phpmailer/

README.md
```

---

# Installation

## Clone Repository

```bash
git clone https://github.com/yourusername/society-maintenance-system.git
cd society-maintenance-system
```

## Build Container Image

```bash
podman build -t society-app .
```

## Run Container

```bash
podman run -d -p 8080:80 --name society-container society-app
```

## Access Application

Open browser and visit:

```
http://localhost:8080
```

---

# Default Login Credentials

* **Username:** chairman
* **Password:** admin123

---

# Application Workflow

1. Chairman logs into the system
2. Records maintenance payments
3. Adds society expenses
4. System generates monthly report
5. Chairman can:

   * Download PDF report
   * Email the report
   * Download full backup

---

# Future Improvements

* Database integration (MySQL / PostgreSQL)
* Role-based access (Secretary / Treasurer)
* Resident login portal
* Online payment gateway
* Analytics dashboard

---

# Author

Developed as a **Linux + Podman containerization project**.

---
