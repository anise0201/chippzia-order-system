CREATE TABLE customers (
    customer_id      NUMBER(10) PRIMARY KEY,
    first_name       VARCHAR2(255),
    last_name        VARCHAR2(255),
    phone            VARCHAR2(20),
    address          VARCHAR2(255),
    city             VARCHAR2(50),
    state            VARCHAR2(50),
    created_at       DATE DEFAULT SYSDATE,
    deleted_at       DATE 
);

CREATE TABLE members (
    customer_id      NUMBER(10) PRIMARY KEY,
    email            VARCHAR2(100) UNIQUE,
    username         VARCHAR2(50) UNIQUE,
    password_hash    VARCHAR2(255),
    loyalty_points   NUMBER(10) DEFAULT 0,
    CONSTRAINT fk_members_customer
        FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
        ON DELETE CASCADE
);

CREATE TABLE employees (
    employee_id      NUMBER(10) PRIMARY KEY,
    first_name       VARCHAR2(255),
    last_name        VARCHAR2(255),
    username         VARCHAR2(50) UNIQUE,
    password_hash    VARCHAR2(255),
    email            VARCHAR2(100) UNIQUE,
    phone            VARCHAR2(20),
    authority_level  NUMBER(1) DEFAULT 1 NOT NULL,
    created_at       DATE DEFAULT SYSDATE,
    deleted_at       DATE,
    manager_id       NUMBER(10),
    CONSTRAINT ck_authority CHECK (authority_level IN (1, 2, 3))
    CONSTRAINT fk_employee_manager
        FOREIGN KEY (manager_id) REFERENCES employees(employee_id)
        ON DELETE SET NULL
);

CREATE TABLE orders (
    order_id              NUMBER(10) PRIMARY KEY,
    customer_id           NUMBER(10),
    employee_id           NUMBER(10),
    total_price           NUMBER(10, 2),
    loyalty_points_redeemed NUMBER(10) DEFAULT 0,
    order_status          VARCHAR2(20),
    created_at            DATE DEFAULT SYSDATE,
    CONSTRAINT ck_order_status CHECK (order_status IN ('Pending', 'Completed', 'Cancelled')),
    CONSTRAINT fk_orders_customer
        FOREIGN KEY (customer_id) REFERENCES customers(customer_id)
        ON DELETE CASCADE,
    CONSTRAINT fk_orders_employee
        FOREIGN KEY (employee_id) REFERENCES employees(employee_id)
        ON DELETE SET NULL
);

CREATE TABLE products (
    product_id           NUMBER(10) PRIMARY KEY,
    product_image        VARCHAR2(255),
    product_name         VARCHAR2(100),
    product_description  VARCHAR2(500),
    product_price        NUMBER(10, 2),
    inventory_quantity   NUMBER(5),
    created_at           DATE DEFAULT SYSDATE
);

CREATE TABLE order_lines (
    order_line_id        NUMBER(10) PRIMARY KEY,
    product_id           NUMBER(10),
    order_id             NUMBER(10),
    quantity             NUMBER(3),
    price                NUMBER(10, 2),
    CONSTRAINT fk_order_lines_product
        FOREIGN KEY (product_id) REFERENCES products(product_id)
        ON DELETE SET NULL,
    CONSTRAINT fk_order_lines_order
        FOREIGN KEY (order_id) REFERENCES orders(order_id)
        ON DELETE CASCADE
);

CREATE SEQUENCE customer_seq
START WITH 1      
INCREMENT BY 1     
NOCACHE             
NOCYCLE;             

CREATE SEQUENCE employee_seq
START WITH 1
INCREMENT BY 1
NOCACHE
NOCYCLE;

CREATE SEQUENCE order_seq
START WITH 1
INCREMENT BY 1
NOCACHE
NOCYCLE;

CREATE SEQUENCE order_line_seq
START WITH 1
INCREMENT BY 1
NOCACHE
NOCYCLE;

CREATE SEQUENCE product_seq
START WITH 1
INCREMENT BY 1
NOCACHE
NOCYCLE;

--DROP TABLE CUSTOMERS CASCADE CONSTRAINTS PURGE;
--DROP TABLE MEMBERS CASCADE CONSTRAINTS PURGE;
--DROP TABLE EMPLOYEES CASCADE CONSTRAINTS PURGE;
--DROP TABLE ORDERS CASCADE CONSTRAINTS PURGE;
--DROP TABLE PRODUCTS CASCADE CONSTRAINTS PURGE;
--DROP TABLE ORDER_LINES CASCADE CONSTRAINTS PURGE;
--DROP SEQUENCE customer_seq;
--DROP SEQUENCE employee_seq;