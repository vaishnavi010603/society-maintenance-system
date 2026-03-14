Society Maintenance Management System

A containerized internal web application for managing monthly maintenance payments, society expenses, financial reports, and backups for residential housing societies.

This project is designed to run on Linux (RHEL 9) and is containerized using Podman to ensure portability, easy deployment, and simplified system management.

Overview

Managing financial records in housing societies is often done manually using spreadsheets or notebooks, which can lead to errors and lack of transparency.

The Society Maintenance Management System provides a lightweight web-based solution that allows society administrators to:

Record maintenance payments

Track expenses

Generate monthly financial reports

Download reports as PDF

Send reports through email

Backup society data

The application is containerized to ensure consistent deployment across different environments.

Features
Authentication

Secure chairman login

Session-based authentication

Automatic Month Detection

Automatically detects the current month

Eliminates manual monthly configuration

Maintenance Payment Tracking

Record maintenance payments for residents

Track paid and unpaid entries

Expense Management

Add society expenses

Maintain monthly expense records

Financial Reporting

Generate dynamic monthly financial reports including:

Total maintenance collected

Total expenses

Net balance

PDF Report Generation

Export financial reports as downloadable PDF documents

Email Reporting

Send monthly reports via Gmail SMTP

Data Backup

Download a complete backup of system data in ZIP format

Containerized Deployment

Containerized using Podman

Compatible with Docker-based environments

Simplifies deployment and portability

Technology Stack
Component	Technology
Backend	PHP with Apache
Frontend	HTML, CSS
Operating System	RHEL 9
Containerization	Podman
PDF Generation	TCPDF
Email Service	PHPMailer with Gmail SMTP
Data Storage	CSV Files
System Architecture

The application follows a simple architecture:

User (Chairman)
↓
Web Browser
↓
Apache Web Server (PHP Application)
↓
CSV Data Storage
↓
External Services

TCPDF for PDF generation

PHPMailer with Gmail SMTP for email delivery

Project Structure
society-maintenance-system/

containerfile
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
Installation
Clone the Repository
git clone https://github.com/yourusername/society-maintenance-system.git
cd society-maintenance-system
Build Container Image
podman build -t society-app .
Run the Container
podman run -d \
-p 8080:80 \
--name society-container \
society-app
Access the Application

Open a web browser and navigate to:

http://localhost:8080
Podman Compose Deployment (Optional)

If using podman-compose:

podman-compose up -d
Default Login Credentials
Username: chairman
Password: admin123

These credentials can be modified in the login configuration file.

Application Workflow

Chairman logs into the system.

Maintenance payments for residents are recorded.

Society expenses are added.

The system generates a monthly financial report.

The chairman can:

Download the report as PDF

Email the report

Download a backup of all records

Advantages

Lightweight storage using CSV files

No external database required

Easy containerized deployment

Portable across servers

Suitable for small housing societies

Future Improvements

Database integration (MySQL or PostgreSQL)

Role-based access (Chairman, Secretary, Treasurer)

Resident login portal

Online payment gateway integration

Analytics dashboard with graphs

Author

Developed as a containerized web application project using Linux and Podman.

License

This project is intended for educational purposes and small-scale society management systems.
