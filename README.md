# AccesioMart

This is our college project. We are a team of two members, Sahil Kumar Gupta and Aayush Parajuli. We are 4th semester BCA students at Everest College, affiliated with Tribhuvan University.

## About Us

### Sahil Kumar Gupta
- **LinkedIn**: [Sahil Gupta](https://www.linkedin.com/in/sahil-gupta-44294b2b2/)
- **GitHub**: [Sahil Gupta](https://github.com/sahilgupta43)

### Aayush Parajuli
- **LinkedIn**: [Aayush Parajuli](https://www.linkedin.com/in/aayush-parajuli-232ba3317/)
- **GitHub**: [Aayush Parajuli](https://github.com/Aayush-Parajuli-lab)

## Project Overview

### Project Name
AccesioMart

### Project Description
AccesioMart is an e-commerce platform designed to provide a seamless shopping experience. Our project focuses on delivering a user-friendly interface and robust functionalities, utilizing various web technologies to enhance performance and user engagement.

### Technologies Used
- **HTML**
- **CSS**
- **JavaScript**
- **PHP**
- **AJAX**
- **JSON**
- **MySQL**

### Features
- User Registration and Authentication
- Product Listing and Details
- Shopping Cart
- Order Management
- User Profile Management
- Search and Filter Options
- Responsive Design

### Installation
To clone and run this project, you will need to have [Git](https://git-scm.com), [XAMPP](https://www.apachefriends.org/index.html), or any other PHP and MySQL server setup installed on your computer.

#### Steps:
1. Clone the repository:
    ```bash
    git clone https://github.com/YourUsername/AccesioMart.git
    ```
2. Move the project to your server directory (e.g., XAMPP's `htdocs` folder).
3. Import the database:
   - Open PHPMyAdmin.
   - Create a new database named `accesiomart`.
   - Import the `accesiomart.sql` file located in the project's `database` folder.
4. Update the database configuration in `config.php`:
    ```php
    <?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'accesiomart');
    $db = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    ?>
    ```
5. Open your web browser and navigate to `http://localhost/AccesioMart`.

### Usage
- Register as a new user or login with existing credentials.
- Browse products and add them to your cart.
- Proceed to checkout to place your order.
- Manage your profile and view order history.

### Contributing
Contributions are welcome! Please follow these steps:
1. Fork the project.
2. Create your feature branch:
    ```bash
    git checkout -b feature/YourFeature
    ```
3. Commit your changes:
    ```bash
    git commit -m 'Add some feature'
    ```
4. Push to the branch:
    ```bash
    git push origin feature/YourFeature
    ```
5. Open a pull request.

### License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
