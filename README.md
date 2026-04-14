# Cam-Job-Connect
CamJobConnect is a platform that connects clients with skilled service providers in Cameroon, including plumbers, electricians, software engineers, graphic designers, and more, making it easy to post jobs, find professionals, and get work done efficiently.


It allows users to register, choose a role (client or service provider), browse services, hire professionals, track job progress, calculate service costs based on hourly rates, and leave reviews after job completion. The system is built as an MVP (Minimum Viable Product) that demonstrates the full workflow of a real-world service marketplace.

---

## Features

Users can register and log in with a role-based system:
- Clients
- Service Providers
- Admin

Service providers can:
- Create and manage service profiles
- Set hourly rates for their services
- Receive job requests from clients
- Track assigned jobs

Clients can:
- Browse available service providers
- View services and hourly rates
- Hire providers based on their needs
- Specify number of hours required
- Automatically calculate total cost (hourly rate × hours)
- Confirm job completion and simulate payment
- Leave reviews and ratings for providers

Reviews:
- Clients can leave ratings and comments after service completion
- Reviews are visible to all users when browsing providers
- Helps future clients choose trusted providers

Payments:
- Payment system is fully simulated (no real payment API integrated)
- The system calculates total cost and records payment details in the database
- Designed to demonstrate real-world payment flow logic

---

## Admin System

The admin account is not manually registered like normal users. It is automatically created when the project runs for the first time using the database initialization script.

Default admin credentials:
- Email: admin@camjobconnect.com  
- Password: admin123

The system checks if an admin exists in the database, and if not, it automatically creates one during setup.

---

## Database Setup

1. Create database:
```sql

Run the initialization script which:




Creates the database if it does not exist


Creates all required tables


Automatically creates the default admin account if none exists




Import the provided schema file into phpMyAdmin or MySQL.



Project Status
This project is an MVP (Minimum Viable Product) and was never fully completed. It demonstrates core functionality of a service marketplace system including:


Authentication and role-based access


Job creation and assignment


Simulated payment processing


Reviews and rating system


Admin dashboard analytics


However, it is not production-ready and still lacks:


Real payment gateway integration


Advanced security improvements


Full UI/UX polishing


Deployment optimization



Tech Stack


PHP (Backend)


MySQL (Database)


HTML, CSS, JavaScript (Frontend)


Apache (XAMPP)



Purpose
CamJobConnect was built as a portfolio and academic MVP project to demonstrate how a real-world freelance/service marketplace system works in practice, connecting skilled workers with clients in Cameroon. The project is yet to be fully developed.


License

All Rights Reserved © CamJobConnect

This project is not open source and is protected under copyright.
Unauthorized copying, modification, distribution, or use of this code is strictly prohibited without explicit permission from the author.
