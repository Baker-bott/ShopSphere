INSERT INTO users (name, email, role) VALUES
('Admin User', 'admin@shopsphere.com', 'admin'),
('Manager User', 'manager@shopsphere.com', 'manager'),
('Support Staff', 'support@shopsphere.com', 'support');

INSERT INTO products (name, description, price, category) VALUES
('Smart Watch Pro', 'Fitness tracker with heart monitor', 129.99, 'Electronics'),
('Wireless Headphones', 'Noise cancelling Bluetooth', 89.99, 'Electronics'),
('Smart Home Camera', '1080p HD with night vision', 64.99, 'Home');

INSERT INTO orders (user_id, amount, status) VALUES
(1, 129.99, 'processing'),
(2, 89.99, 'delivered'),
(3, 245.50, 'pending');
