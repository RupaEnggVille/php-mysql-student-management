# Project Documentation

# Student Marks Management System

AWS + Docker + PHP + MySQL

---

# 1. Introduction

The Student Marks Management System is a web-based application developed to manage student academic records efficiently. The system allows administrators or teachers to add, store, search, and display student marks dynamically using PHP and MySQL.

The project is containerized using Docker and deployed on AWS EC2 for scalable and production-ready cloud deployment.

---

# 2. Project Objectives

The main objectives of this project are:

- Manage student records digitally
- Store student marks securely
- Retrieve student data dynamically
- Provide responsive web interface
- Deploy application using Docker
- Host application on AWS cloud

---

# 3. Technologies Used

## Frontend

| Technology | Purpose |
|---|---|
| HTML5 | Web page structure |
| CSS3 | Styling and responsive design |
| Bootstrap | UI components |
| JavaScript | Client-side interactions |

---

## Backend

| Technology | Purpose |
|---|---|
| PHP | Server-side scripting |
| Apache | Web server |
| MySQL | Database |

---

## DevOps & Cloud

| Technology | Purpose |
|---|---|
| Docker | Containerization |
| Docker Compose | Multi-container orchestration |
| AWS EC2 | Cloud hosting |
| Amazon RDS | Managed database (optional) |
| GitHub | Source code management |

---

# 4. Features

The application provides the following features:

- Add new student records
- Store student marks
- Search students by name or roll number
- Dynamic marks table display
- Responsive user interface
- Dockerized deployment
- AWS cloud deployment

---

# 5. System Architecture

```text id="q3n8m1"
User Browser
      │
      ▼
AWS EC2 Instance
      │
      ▼
Docker Engine
      │
      ├── PHP + Apache Container
      └── MySQL Container
6. Project Structure
student-marks-management-system/
│
├── app/
│   ├── index.php
│   ├── add_student.php
│   ├── search.php
│   ├── db.php
│   └── style.css
│
├── database/
│   └── database.sql
│
├── docker/
│   ├── Dockerfile
│   └── docker-compose.yml
│
├── architecture/
│   └── architecture-diagram.png
│
├── screenshots/
│   ├── home-page.png
│   ├── add-student.png
│   └── search-student.png
│
├── docs/
│   ├── aws-deployment-guide.md
│   └── project-documentation.md
│
├── README.md
└── .gitignore
7. Database Design
Database Name
student_management
students Table
Column Name	Data Type	Description
id	INT	Primary Key
name	VARCHAR(100)	Student name
roll_no	VARCHAR(20)	Roll number
maths	INT	Maths marks
science	INT	Science marks
english	INT	English marks
total	INT	Total marks
percentage	FLOAT	Percentage
8. Database Script
CREATE DATABASE student_management;

USE student_management;

CREATE TABLE students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    roll_no VARCHAR(20),
    maths INT,
    science INT,
    english INT,
    total INT,
    percentage FLOAT
);
9. Docker Configuration
Dockerfile
FROM php:8.2-apache

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

EXPOSE 80
docker-compose.yml
version: '3.9'

services:
  web:
    build: .
    container_name: student-app
    ports:
      - "8080:80"
    volumes:
      - .:/var/www/html
    depends_on:
      - mysql

  mysql:
    image: mysql:8.0
    container_name: student-db
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: student_management
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql
      - ./database/database.sql:/docker-entrypoint-initdb.d/database.sql

volumes:
  mysql_data:
10. PHP Database Connection
db.php
<?php

$host = "mysql";
$user = "root";
$password = "root";
$database = "student_management";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
11. Application Pages
Home Page

Purpose:

Display all students
Show marks table
Provide navigation

Features:

Search bar
Edit/Delete buttons
Statistics cards
Add Student Page

Purpose:

Add new student details

Features:

Student form
Automatic percentage calculation
Responsive layout
Search Student Page

Purpose:

Search students dynamically

Features:

Search by name
Search by roll number
Dynamic results table
12. AWS Deployment Overview

The project is deployed using:

Ubuntu EC2 instance
Docker Engine
Docker Compose

Deployment workflow:

GitHub Repository
        │
        ▼
AWS EC2 Instance
        │
        ▼
Docker Compose
        │
        ├── PHP Container
        └── MySQL Container
13. Security Configuration

Security measures used:

AWS Security Groups
Docker container isolation
IAM permissions
SSH key authentication

Recommended production improvements:

SSL certificates
HTTPS configuration
NGINX reverse proxy
Web Application Firewall
14. Monitoring and Logging

Monitoring services:

CloudWatch
Docker logs
EC2 metrics

Commands:

docker logs student-app
docker logs student-db
15. Advantages of the System
User-friendly interface
Cloud deployment support
Containerized architecture
Easy scalability
Dynamic database integration
Production-ready setup
16. Future Enhancements

Planned improvements:

Login authentication
Admin dashboard
Role-based access
Export reports to PDF/Excel
Jenkins CI/CD pipeline
Kubernetes deployment
Terraform provisioning
SSL integration
Analytics dashboard
17. Learning Outcomes

This project demonstrates:

PHP web development
MySQL database integration
Docker containerization
AWS cloud deployment
GitHub project management
DevOps deployment practices
18. Conclusion

The Student Marks Management System is a complete full-stack web application that demonstrates modern cloud-native deployment using AWS, Docker, PHP, and MySQL.

The project provides hands-on experience in:

Full-stack development
Containerization
Cloud deployment
Database management
DevOps workflows

This project can be used as:

Academic mini project
Resume project
Portfolio project
DevOps practice project
Cloud deployment demonstration
