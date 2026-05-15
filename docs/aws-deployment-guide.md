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

## **The application allows administrators and teachers to:**

- Add student records
- Store marks in MySQL database
- Search student records
- Display marks dynamically

---

## **Architecture Overview**

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
```

## **Prerequisites**

### **Before deployment, ensure you have:**

- AWS Account
- EC2 Key Pair (.pem file)
- Basic Linux command knowledge
- Git installed locally
- Docker knowledge (basic)
- AWS Services Used

**Service	Purpose**
- EC2 - Host application
- Security Group - Firewall rules
- IAM - Access management
- CloudWatch - Monitoring
- S3 - Backup storage (optional)
- Route 53 - Domain management (optional)

# **Execution Steps:**

## **Step 1: Launch EC2 Instance**

Open AWS Console --> Navigate to EC2 Dashboard --> Click Launch Instance --> Instance Configuration --> Set Value for number of instances --> select AMI (Ubuntu Server 22.04) --> Instance Type	(t2.micro) --> Storage Volume (10 GB) --> Key Pair (Create/Select Existing)
## **Configure Security Group**

**Allow the following inbound rules:**
```text
Type        Port     Source

SSH          22      Your IP
HTTP         80      Anywhere
Custom TCP  8080     Anywhere
MySQL       3306	 Your IP (optional)
```

## **Step 2: Connect to EC2**
```shell
ssh -i your-key.pem ubuntu@your-ec2-public-ip

#Example:

ssh -i student-key.pem ubuntu@54.221.10.20
```

## **Step 3: Update Ubuntu Packages**
```shell
sudo apt update -y
sudo apt upgrade -y
```

## **Step 4: Install Docker**
```shell
sudo apt install docker.io -y

#Start Docker:

sudo systemctl start docker
sudo systemctl enable docker
```
**Verify:**
```shell
docker --version
sudo systemctl status docker
```

## **Step 5: Add User to Docker Group**
By default, only the root user can connect to the docker-daemon by CLI. If you want to connect any other user to docker-daemon, you have to add that user to docker group.
```shell
sudo usermod -aG docker ubuntu
```
After adding the user to group, better to logout and login again to run docker commands with that user.

**Verify:**
```shell
docker ps
```

## **Step 6: Install Docker Compose**
```shell
sudo apt install docker-compose -y
```
**Verify:**
```shell
docker-compose --version
```

## **Step 7: Install Git**
```shell
sudo apt install git -y # optional (git will be installed by updating the apt package manager)

#Clone GitHub Repository
git clone https://github.com/RupaEnggVille/php-mysql-student-management.git
```

## **Step 8: Navigate into project directory:**
```shell
cd php-mysql-student-management
```

## **Step 9: Verify Project Structure**
```text
php-mysql-student-management/
│
├── app/
├── database/
├── docker/
├── architecture/
├── screenshots/
├── docs/
├── README.md
└── docker-compose.yml
```

## **Step 10: Dockerfile**
```shell
vim Dockerfile
```
```text
FROM php:8.2-apache

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

EXPOSE 80
```

## **Step 11: Docker Compose Configuration**
```shell
vim docker-compose.yml
```
```text
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
```

## **Step 12: Update Database Connection**
Edit db.php
```shell
vim db.php
```
```text
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
```

## **Step 13: Build and Run Containers**
```shell
docker-compose up -d --build
```
**Verify containers:**
```shell
docker ps
```
**Expected output:**
student-app
student-db

## **Step 14: Access the Application**

**Open browser:**

http://your-ec2-public-ip:8080

Example:
```text
http://54.221.10.20:8080
```

## **Step 15: Verify MySQL Database**

Access MySQL container:
```shell
docker exec -it student-db mysql -u root -p
```
Password: root

To Show databases:
```shell
SHOW DATABASES;
```
To Use a database:
```shell
USE student_management;
```
To Show tables in the database:
```shell
SHOW TABLES;
```
To exit from the database:
Press ctrl+p+q
## **Step 16: View Container Logs**

Check PHP Container logs:
```shell
docker logs student-app
```
Check MySQL Container logs:
```shell
docker logs student-db
```

## **Step 17: Stop Application**
```shell
docker-compose down
```
