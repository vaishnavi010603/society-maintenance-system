Society Maintenance Management System
Project Overview

The Society Maintenance Management System is a containerized web application developed to manage monthly maintenance payments, track society expenses, generate financial reports, and create data backups for residential housing societies.

The application is designed to run on Linux (RHEL 9) and is deployed using Podman containers to ensure portability, consistency, and ease of deployment.

This system helps society administrators maintain financial records in a structured and efficient manner.

Key Features
Authentication

Secure login for the chairman

Session-based authentication

Prevents unauthorized access

Automatic Month Detection

Automatically detects the current month

Eliminates the need for manual updates every month

Maintenance Payment Management

Record maintenance payments for residents

Track paid and unpaid entries

Maintain monthly payment records

Expense Tracking

Add and manage society expenses

Store monthly expense details

Financial Reporting

Generate dynamic monthly reports

Displays:

Total maintenance collected

Total expenses

Remaining balance

PDF Report Generation

Download monthly financial reports as PDF files

Useful for record keeping and documentation

Email Reporting

Send reports via email using Gmail SMTP

Enables digital sharing of monthly reports

Data Backup

Download full system backup as a ZIP file

Backup includes:

Payment records

Expense records

Resident data

Containerized Deployment

Fully containerized using Podman

Docker-compatible container environment

Simplifies deployment across systems

Technology Stack

Backend: PHP with Apache Web Server

Frontend: HTML and CSS

Operating System: RHEL 9 Virtual Machine

Containerization: Podman

PDF Generation: TCPDF Library

Email Service: PHPMailer with Gmail SMTP

Data Storage: CSV Files

System Architecture

The application follows a simple web-based architecture:

User (Chairman) accesses the application through a web browser

Apache web server runs the PHP application

Application processes payment and expense data

Data is stored in CSV files

Additional services:

TCPDF for PDF generation

PHPMailer with Gmail SMTP for sending email reports

Project Structure
society-maintenance-system

containerfile
compose.yml

public
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

data
  residents.csv
  payments.csv
  expenses.csv

css
  style.css

libs
  tcpdf
  phpmailer

README.md
Installation Guide
Step 1: Clone the Repository
git clone https://github.com/yourusername/society-maintenance-system.git
cd society-maintenance-system
Step 2: Build the Container Image
podman build -t society-app .
Step 3: Run the Container
podman run -d -p 8080:80 --name society-container society-app
Step 4: Access the Application

Open a web browser and navigate to:

http://localhost:8080
Podman Compose Deployment (Optional)

If you prefer using Podman Compose:

podman-compose up -d
Default Login Credentials

Username: chairman

Password: admin123

These credentials can be modified in the login configuration file.

Application Workflow

Chairman logs into the system.

Maintenance payments are recorded for residents.

Society expenses are added.

The system automatically generates monthly financial reports.

The chairman can:

Download reports as PDF

Send reports via email

Download a full backup of system data

Advantages of the System

Lightweight system using CSV storage

No database installation required

Easy container deployment using Podman

Portable across different environments

Suitable for small and medium housing societies

Future Enhancements

Integration with MySQL or PostgreSQL database

Role-based access control (Chairman, Secretary, Treasurer)

Resident login portal

Online payment gateway integration

Dashboard analytics with charts and graphs

Author

Developed as a Linux and containerization project using Podman.

License

This project is intended for educational and internal society management purposes.
