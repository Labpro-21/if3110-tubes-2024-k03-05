# Tugas Besar IF3110 2024/2025

# LinkInPurry
<img src="php\src\public\images\meme.jpg">

<div align="center">
  
**LinkInPurry** is a web-based application created to assist O.W.C.A. agents in finding job opportunities that match their unique skill sets. The platform allows companies to post job openings and job seekers to apply, enabling seamless recruitment for both parties.
  
</div>

## Table of Contents
1. [Description](#description)
2. [Requirements](#requirements)
3. [Installation](#installation)
4. [Running the Server](#running-the-server)
5. [Features](#features)
6. [Screenshots](#screenshots)
7. [Contribution Guidelines](#contribution-guidelines)

---

### Description
LinkInPurry connects job seekers with companies offering various positions. The platform allows:
- Companies to post job openings, update details, review applicants, and manage open roles.
- Job Seekers to browse, search, filter, and apply for jobs.
- Both authenticated job seekers and unauthenticated users can view job listings, but only authenticated users can apply for roles or manage their postings.

### Requirements
- **Client-Side**:
  - HTML, CSS, and JavaScript 
  
- **Server-Side**:
  - PHP
  
- **Database**:
  - MySQL

  
- **Libraries**:
  - Rich Text Editor: Using `quill.js`.


- **Docker**:
  - Dockerfile and docker-compose.yml should be configured to run both the application and the database as services.

### Installation
To set up the LinkInPurry project locally:

1. **Clone the repository**:
   ```bash
   git clone <repository_url>
   cd <repository_directory>
   ```
2. **Set up the database**:
   - Ensure that a MySQL is installed.

3. **Docker Setup**:
   - Ensure Docker and Docker Compose are installed on your machine.
   - Use the provided `docker-compose.yml` file to set up and launch both the application and the database services:
     ```bash
     docker-compose up -d
     ```


### Running the Server
To start the application server:

1. **Local PHP Server**:
   - The application will be accessible at `http://localhost`.

### Features
LinkInPurry includes a range of essential and optional (bonus) features:

1. **User Authentication and Authorization**:
   - Register as a company or job seeker.
   - Log in and log out functionality.
   
2. **Job Management (Company)**:
   - Create, edit, close, and delete job postings.
   - View a list of company's job postings with pagination.
   - Approve or reject applicants with feedback.
   - View and edit Profile's company

3. **Job Search and Filtering (Job Seeker and Unauthenticated User)**:
   - Search for jobs by title, filter by job type and location.
   - Sort jobs by posting date.
   
4. **Application Management (Job Seeker)**:
   - Submit job applications with CV and optional introduction video.
   - Track application status and view application history.

5. **Responsive Design**:
   - The home page for both job seekers and companies is responsive to screen sizes of at least 1280 x 768 and 400 x 800.

### Screenshots
#### Home Page (Job Seeker)
![Job Seeker Home Page](images/job_seeker_home.png)

#### Home Page (Company)
![Company Home Page](images/company_home.png)

#### Job Details
![Job Details Page](images/job_details.png)


### Contribution Guidelines
1. Fauzhan Azhim -13522

