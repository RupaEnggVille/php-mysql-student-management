# AWS Deployment Guide

# Student Marks Management System
AWS + Docker + PHP + MySQL Deployment

---

# Project Overview

The Student Marks Management System is a cloud-native web application developed using:

- PHP
- MySQL
- Docker
- Docker Compose
- AWS EC2

The application allows administrators and teachers to:

- Add student records
- Store marks in MySQL database
- Search student records
- Display marks dynamically

---

# Architecture Overview

```text
User Browser
     │
     ▼
AWS Security Group
     │
     ▼
Amazon EC2 Instance (Ubuntu)
     │
     ▼
Docker Engine
     │
     ├── PHP + Apache Container
     └── MySQL Container
Prerequisites

Before deployment, ensure you have:

AWS Account
EC2 Key Pair (.pem file)
Basic Linux command knowledge
Git installed locally
Docker knowledge (basic)
AWS Services Used
Service	Purpose
EC2	Host application
Security Groups	Firewall rules
IAM	Access management
CloudWatch	Monitoring
S3	Backup storage (optional)
Route 53	Domain management (optional)
Step 1: Launch EC2 Instance
Create EC2 Instance
Open AWS Console
Navigate to EC2 Dashboard
Click Launch Instance
Instance Configuration
Setting	Value
AMI	Ubuntu Server 22.04
Instance Type	t2.micro
Storage	10 GB
Key Pair	Create/Select Existing
Step 2: Configure Security Group

Allow the following inbound rules:

Type	Port	Source
SSH	22	Your IP
HTTP	80	Anywhere
Custom TCP	8080	Anywhere
MySQL (Optional)	3306	Your IP
Step 3: Connect to EC2

Use SSH:

ssh -i your-key.pem ubuntu@your-ec2-public-ip

Example:

ssh -i student-key.pem ubuntu@54.221.10.20
Step 4: Update Ubuntu Packages
sudo apt update -y
sudo apt upgrade -y
Step 5: Install Docker
sudo apt install docker.io -y

Start Docker:

sudo systemctl start docker
sudo systemctl enable docker

Verify:

docker --version
Step 6: Add User to Docker Group
sudo usermod -aG docker ubuntu
newgrp docker

Verify:

docker ps
Step 7: Install Docker Compose
sudo apt install docker-compose -y

Verify:

docker-compose --version
Step 8: Install Git
sudo apt install git -y
Step 9: Clone GitHub Repository
git clone https://github.com/your-username/student-marks-management-system.git

Navigate into project directory:

cd student-marks-management-system
Step 10: Verify Project Structure
student-marks-management-system/
│
├── app/
├── database/
├── docker/
├── architecture/
├── screenshots/
├── docs/
├── README.md
└── docker-compose.yml
Step 11: Dockerfile

Create Dockerfile

FROM php:8.2-apache

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

EXPOSE 80
Step 12: Docker Compose Configuration

Create docker-compose.yml

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
Step 13: Update Database Connection

Edit db.php

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
Step 14: Build and Run Containers
docker-compose up -d --build

Verify containers:

docker ps

Expected output:

student-app
student-db
Step 15: Access the Application

Open browser:

http://your-ec2-public-ip:8080

Example:

http://54.221.10.20:8080
Step 16: Verify MySQL Database

Access MySQL container:

docker exec -it student-db mysql -u root -p

Password:

root

Show databases:

SHOW DATABASES;

Use database:

USE student_management;

Show tables:

SHOW TABLES;
Step 17: View Container Logs

PHP Container:

docker logs student-app

MySQL Container:

docker logs student-db
Step 18: Stop Application
docker-compose down
