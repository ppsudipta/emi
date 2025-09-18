# Technical Round: EMI Processing

This project is a **Laravel-based EMI Processing system** built for a technical round assignment.  
It demonstrates:  
- Repository & Service design pattern  
- Migrations & Seeders  
- Laravel Authentication  
- Raw SQL for dynamic EMI table creation  
- Loan & EMI processing admin screens  

---

## 📌 Features
1. **Repository & Service Pattern**
   - Business logic lives in `Services`.
   - Database queries are abstracted in `Repositories`.

2. **Loan EMI Management**
   - Form for adding `loan_details`.
   - Loans stored dynamically in DB.

3. **Authentication**
   - Laravel login system.
   - Seeded admin user for access.

4. **Loan Details Page**
   - Displays all loan records.

5. **EMI Processing Page**
   - Initially blank with **Process Data** button.
   - On click:
     - Creates `emi_details` table dynamically with RAW SQL.
     - If table exists → dropped and recreated.
     - Columns: `clientid` + dynamic months (`min(first_payment_date)` → `max(last_payment_date)`).
   - EMI calculation:
     - `emi = loan_amount / num_of_payment`
     - Distributed across months
     - Last month adjusted to ensure total = loan_amount.

6. **Result Display**
   - EMI table with scrollable, styled headers.
   - Button switches to **View Loan Details** after processing.



---

## 🗄️ Database Schema

### `loan_details`
| Field              | Type    | Description                      |
|--------------------|---------|----------------------------------|
| clientid           | INT     | Unique client ID                 |
| num_of_payment     | INT     | Number of EMIs                   |
| first_payment_date | DATE    | First payment date               |
| last_payment_date  | DATE    | Last payment date                |
| loan_amount        | DECIMAL | Total loan amount                |

### `users`
| Field     | Type    | Description       |
|-----------|---------|-------------------|
| id        | INT     | Primary key       |
| username  | VARCHAR | Admin username    |
| password  | VARCHAR | Hashed password   |

### `emi_details` (Dynamic Table)
| Field     | Type    | Description           |
|-----------|---------|-----------------------|
| clientid  | INT     | Client ID             |
| YYYY_Mmm  | DECIMAL | EMI per month column  |

---

## 🔑 Seed Data

### Loan Details
| clientid | num_of_payment | first_payment_date | last_payment_date | loan_amount |
|----------|----------------|--------------------|------------------|-------------|
| 1001     | 12             | 2018-06-29         | 2019-05-29       | 1550.00     |
| 1003     | 7              | 2019-02-15         | 2019-08-15       | 6851.94     |
| 1005     | 17             | 2017-11-09         | 2019-03-09       | 1800.01     |

### User
| username  | password           |
|-----------|--------------------|
| developer | Test@Password123#  |

---

## ⚙️ Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone <repo-url>
   cd emi-processing

    Install PHP Dependencies

composer install

Install Frontend Dependencies

npm install

Build Frontend Assets (Development)

npm run dev

For production:

npm run build

Environment Setup

    Copy .env.example → .env

    Update DB credentials.

Run Migrations & Seeders

php artisan migrate --seed

Run Application

    php artisan serve

    Login

       

        Username: developer

        Password: Test@Password123#

▶️ Usage Flow

    Login with seeded user.

    Visit Loan Details page → verify seeded data.

    Go to Process EMI page → click Process Data.

        Drops & recreates emi_details.

        Adds columns for each month.

        Distributes EMI values.

    EMI results displayed in a dynamic table.

    Button changes to View Loan Details after processing.

🧪 Example EMI Processing

Loan Example:

    clientid: 2, num_of_payment: 3, loan_amount: 200, period: 2019-03-16 → 2019-05-16

    EMI = 200 / 3 = 66.67

    Distribution:

        Mar = 66.67

        Apr = 66.67

        May = 66.66 (adjusted)

✅ Technical Notes

    Repository Pattern → LoanRepository for DB access.

    Service Layer → EMIService for business logic.

    Raw SQL used for emi_details table creation.

    Laravel Auth for login.

    Blade Views for Loan Details & EMI Processing UI.

📖 Future Enhancements

    Pagination for loan & EMI tables.

    Export EMI results to CSV/Excel.

    Role-based user management.

    PHPUnit tests for EMI logic & repository.

👨‍💻 Author

Sudipta Patra
Senior Laravel Developer | Technical Round Assignment
