CREATE TABLE common (id BIGINT AUTO_INCREMENT, company_id BIGINT, series_id BIGINT, customer_id BIGINT, customer_name VARCHAR(100), customer_identification VARCHAR(50), customer_email VARCHAR(100), customer_phone VARCHAR(20), customer_fax VARCHAR(20), supplier_id BIGINT, supplier_name VARCHAR(100), supplier_identification VARCHAR(50), supplier_email VARCHAR(100), supplier_phone VARCHAR(20), supplier_fax VARCHAR(20), invoicing_address VARCHAR(255), invoicing_postalcode VARCHAR(255), invoicing_city VARCHAR(255), invoicing_state VARCHAR(255), invoicing_country VARCHAR(255), shipping_address VARCHAR(255), shipping_postalcode VARCHAR(255), shipping_city VARCHAR(255), shipping_state VARCHAR(255), shipping_country VARCHAR(255), contact_person VARCHAR(100), terms LONGTEXT, notes LONGTEXT, base_amount DECIMAL(53, 15), discount_amount DECIMAL(53, 15), net_amount DECIMAL(53, 15), gross_amount DECIMAL(53, 15), paid_amount DECIMAL(53, 15), tax_amount DECIMAL(53, 15), status TINYINT, payment_type_id BIGINT, discount DECIMAL(53, 2) DEFAULT 0 NOT NULL, type VARCHAR(255), draft TINYINT(1) DEFAULT '1', closed TINYINT(1) DEFAULT '0', sent_by_email TINYINT(1) DEFAULT '0', remesed TINYINT(1) DEFAULT '0', number INT, recurring_invoice_id BIGINT, estimate_id BIGINT, issue_date DATE, due_date DATE, supplier_reference VARCHAR(50), delivery_date DATE, image LONGTEXT, days_to_due MEDIUMINT, enabled TINYINT(1) DEFAULT '0', max_occurrences INT, must_occurrences INT, period INT, period_type VARCHAR(8), starting_date DATE, finishing_date DATE, last_execution_date DATE, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX compny_idx (company_id), INDEX cstnm_idx (company_id, customer_name), INDEX cstid_idx (company_id, customer_identification), INDEX cstml_idx (company_id, customer_email), INDEX cntct_idx (company_id, contact_person), INDEX common_type_idx (type), INDEX customer_id_idx (customer_id), INDEX supplier_id_idx (supplier_id), INDEX series_id_idx (series_id), INDEX payment_type_id_idx (payment_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE company (id BIGINT AUTO_INCREMENT, identification VARCHAR(100), name VARCHAR(100), address VARCHAR(255), postalcode VARCHAR(255), city VARCHAR(255), state VARCHAR(255), country VARCHAR(255), email VARCHAR(255), phone VARCHAR(50), fax VARCHAR(50), url VARCHAR(255), logo LONGTEXT, currency VARCHAR(10), currency_decimals BIGINT, legal_terms LONGTEXT, pdf_orientation VARCHAR(50), pdf_size VARCHAR(50), bic VARCHAR(50), iban VARCHAR(50), entity VARCHAR(50), office VARCHAR(50), control_digit VARCHAR(50), account VARCHAR(50), mercantil_registry VARCHAR(255), sufix VARCHAR(255), fiscality TINYINT(1) DEFAULT '0', UNIQUE INDEX cst_idx (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE company_user (company_id BIGINT, sf_guard_user_id INT, PRIMARY KEY(company_id, sf_guard_user_id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE customer (id BIGINT AUTO_INCREMENT, company_id BIGINT, name VARCHAR(100), name_slug VARCHAR(100), identification VARCHAR(50), email VARCHAR(100), contact_person VARCHAR(100), invoicing_address VARCHAR(255), invoicing_postalcode VARCHAR(255), invoicing_city VARCHAR(255), invoicing_state VARCHAR(255), invoicing_country VARCHAR(255), shipping_address VARCHAR(255), shipping_postalcode VARCHAR(255), shipping_city VARCHAR(255), shipping_state VARCHAR(255), shipping_country VARCHAR(255), website VARCHAR(255), phone VARCHAR(20), mobile VARCHAR(20), fax VARCHAR(20), comments LONGTEXT, bic VARCHAR(50), iban VARCHAR(50), entity VARCHAR(50), office VARCHAR(50), control_digit VARCHAR(50), account VARCHAR(50), payment_type_id BIGINT, discount DECIMAL(53, 2) DEFAULT 0 NOT NULL, INDEX cstm_idx (company_id, name), INDEX company_id_idx (company_id), INDEX payment_type_id_idx (payment_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE expense_type (id BIGINT AUTO_INCREMENT, company_id BIGINT, name VARCHAR(255), enabled TINYINT(1) DEFAULT '1', INDEX company_id_idx (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE item (id BIGINT AUTO_INCREMENT, company_id BIGINT, quantity DECIMAL(53, 15) DEFAULT 1 NOT NULL, discount DECIMAL(53, 2) DEFAULT 0 NOT NULL, common_id BIGINT, product_id BIGINT, expense_type_id BIGINT, description VARCHAR(8000), unitary_cost DECIMAL(53, 15) DEFAULT 0 NOT NULL, size VARCHAR(255), color VARCHAR(255), INDEX desc_idx (company_id, description), INDEX company_id_idx (company_id), INDEX common_id_idx (common_id), INDEX product_id_idx (product_id), INDEX expense_type_id_idx (expense_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE item_tax (company_id BIGINT, item_id BIGINT, tax_id BIGINT, INDEX company_id_idx (company_id), PRIMARY KEY(item_id, tax_id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE payment (id BIGINT AUTO_INCREMENT, company_id BIGINT, invoice_id BIGINT, date DATE, amount DECIMAL(53, 15), payment_type_id BIGINT, notes LONGTEXT, INDEX payment_type_id_idx (payment_type_id), INDEX company_id_idx (company_id), INDEX invoice_id_idx (invoice_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE payment_type (id BIGINT AUTO_INCREMENT, company_id BIGINT, name VARCHAR(255), description LONGTEXT, enabled TINYINT(1) DEFAULT '1', INDEX company_id_idx (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE product (id BIGINT AUTO_INCREMENT, company_id BIGINT, reference VARCHAR(100) NOT NULL, description LONGTEXT, price DECIMAL(53, 15) DEFAULT 0 NOT NULL, category_id BIGINT, size VARCHAR(255), color VARCHAR(255), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX company_id_idx (company_id), INDEX category_id_idx (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE product_category (id BIGINT AUTO_INCREMENT, company_id BIGINT, name VARCHAR(100) NOT NULL, INDEX company_id_idx (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE sf_guard_user_profile (id BIGINT AUTO_INCREMENT, sf_guard_user_id INT, first_name VARCHAR(50), last_name VARCHAR(50), email VARCHAR(100) UNIQUE, nb_display_results SMALLINT, language VARCHAR(3), country VARCHAR(2), search_filter VARCHAR(30), series VARCHAR(50), hash VARCHAR(50), INDEX sf_guard_user_id_idx (sf_guard_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE property (company_id BIGINT, keey VARCHAR(50), value LONGTEXT, INDEX company_id_idx (company_id), PRIMARY KEY(keey)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE series (id BIGINT AUTO_INCREMENT, company_id BIGINT, name VARCHAR(255), value VARCHAR(255), first_number INT DEFAULT 1, enabled TINYINT(1) DEFAULT '1', INDEX company_id_idx (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE supplier (id BIGINT AUTO_INCREMENT, company_id BIGINT, name VARCHAR(100), name_slug VARCHAR(100), identification VARCHAR(50), email VARCHAR(100), contact_person VARCHAR(100), invoicing_address VARCHAR(255), invoicing_postalcode VARCHAR(255), invoicing_city VARCHAR(255), invoicing_state VARCHAR(255), invoicing_country VARCHAR(255), website VARCHAR(255), phone VARCHAR(20), mobile VARCHAR(20), fax VARCHAR(20), comments LONGTEXT, login VARCHAR(50), password VARCHAR(50), expense_type_id BIGINT, INDEX cstm_idx (company_id, name), INDEX company_id_idx (company_id), INDEX expense_type_id_idx (expense_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE tag (id BIGINT AUTO_INCREMENT, company_id BIGINT, name VARCHAR(100), is_triple TINYINT(1), triple_namespace VARCHAR(100), triple_key VARCHAR(100), triple_value VARCHAR(100), INDEX name_idx (name), INDEX triple1_idx (triple_namespace), INDEX triple2_idx (triple_key), INDEX triple3_idx (triple_value), INDEX company_id_idx (company_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE tagging (id BIGINT AUTO_INCREMENT, tag_id BIGINT NOT NULL, taggable_model VARCHAR(30), taggable_id BIGINT, INDEX tag_idx (tag_id), INDEX taggable_idx (taggable_model, taggable_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE tax (id BIGINT AUTO_INCREMENT, company_id BIGINT, name VARCHAR(50), value DECIMAL(53, 2), active TINYINT(1) DEFAULT '1', is_default TINYINT(1) DEFAULT '0', apply_total TINYINT(1) DEFAULT '0', INDEX company_id_idx (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE template (id BIGINT AUTO_INCREMENT, company_id BIGINT, name VARCHAR(255), template LONGTEXT, models VARCHAR(200), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, slug VARCHAR(255), INDEX company_id_idx (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 ENGINE = INNODB;
CREATE TABLE sf_guard_group (id INT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_group_permission (group_id INT, permission_id INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(group_id, permission_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_permission (id INT AUTO_INCREMENT, name VARCHAR(255) UNIQUE, description TEXT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_remember_key (id INT AUTO_INCREMENT, user_id INT, remember_key VARCHAR(32), ip_address VARCHAR(50), created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), PRIMARY KEY(id, ip_address)) ENGINE = INNODB;
CREATE TABLE sf_guard_user (id INT AUTO_INCREMENT, username VARCHAR(128) NOT NULL UNIQUE, algorithm VARCHAR(128) DEFAULT 'sha1' NOT NULL, salt VARCHAR(128), password VARCHAR(128), is_active TINYINT(1) DEFAULT '1', is_super_admin TINYINT(1) DEFAULT '0', last_login DATETIME, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX is_active_idx_idx (is_active), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_group (user_id INT, group_id INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, group_id)) ENGINE = INNODB;
CREATE TABLE sf_guard_user_permission (user_id INT, permission_id INT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(user_id, permission_id)) ENGINE = INNODB;
ALTER TABLE common ADD CONSTRAINT common_supplier_id_supplier_id FOREIGN KEY (supplier_id) REFERENCES supplier(id) ON DELETE SET NULL;
ALTER TABLE common ADD CONSTRAINT common_series_id_series_id FOREIGN KEY (series_id) REFERENCES series(id) ON DELETE SET NULL;
ALTER TABLE common ADD CONSTRAINT common_payment_type_id_payment_type_id FOREIGN KEY (payment_type_id) REFERENCES payment_type(id) ON DELETE SET NULL;
ALTER TABLE common ADD CONSTRAINT common_customer_id_customer_id FOREIGN KEY (customer_id) REFERENCES customer(id) ON DELETE SET NULL;
ALTER TABLE common ADD CONSTRAINT common_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE company_user ADD CONSTRAINT company_user_sf_guard_user_id_sf_guard_user_id FOREIGN KEY (sf_guard_user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE company_user ADD CONSTRAINT company_user_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE customer ADD CONSTRAINT customer_payment_type_id_payment_type_id FOREIGN KEY (payment_type_id) REFERENCES payment_type(id) ON DELETE SET NULL;
ALTER TABLE customer ADD CONSTRAINT customer_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE common ADD CONSTRAINT common_recurring_invoice_id_common_id FOREIGN KEY (recurring_invoice_id) REFERENCES common(id) ON DELETE SET NULL;
ALTER TABLE expense_type ADD CONSTRAINT expense_type_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE common ADD CONSTRAINT common_estimate_id_common_id FOREIGN KEY (estimate_id) REFERENCES common(id) ON DELETE SET NULL;
ALTER TABLE item ADD CONSTRAINT item_product_id_product_id FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE SET NULL;
ALTER TABLE item ADD CONSTRAINT item_expense_type_id_expense_type_id FOREIGN KEY (expense_type_id) REFERENCES expense_type(id) ON DELETE SET NULL;
ALTER TABLE item ADD CONSTRAINT item_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE item ADD CONSTRAINT item_common_id_common_id FOREIGN KEY (common_id) REFERENCES common(id) ON DELETE CASCADE;
ALTER TABLE item_tax ADD CONSTRAINT item_tax_tax_id_tax_id FOREIGN KEY (tax_id) REFERENCES tax(id);
ALTER TABLE item_tax ADD CONSTRAINT item_tax_item_id_item_id FOREIGN KEY (item_id) REFERENCES item(id) ON DELETE CASCADE;
ALTER TABLE item_tax ADD CONSTRAINT item_tax_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE payment ADD CONSTRAINT payment_payment_type_id_payment_type_id FOREIGN KEY (payment_type_id) REFERENCES payment_type(id) ON DELETE SET NULL;
ALTER TABLE payment ADD CONSTRAINT payment_invoice_id_common_id FOREIGN KEY (invoice_id) REFERENCES common(id) ON DELETE CASCADE;
ALTER TABLE payment ADD CONSTRAINT payment_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE payment_type ADD CONSTRAINT payment_type_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE product ADD CONSTRAINT product_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE product ADD CONSTRAINT product_category_id_product_category_id FOREIGN KEY (category_id) REFERENCES product_category(id) ON DELETE SET NULL;
ALTER TABLE product_category ADD CONSTRAINT product_category_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_profile ADD CONSTRAINT sf_guard_user_profile_sf_guard_user_id_sf_guard_user_id FOREIGN KEY (sf_guard_user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE property ADD CONSTRAINT property_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE series ADD CONSTRAINT series_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE supplier ADD CONSTRAINT supplier_expense_type_id_expense_type_id FOREIGN KEY (expense_type_id) REFERENCES expense_type(id) ON DELETE SET NULL;
ALTER TABLE supplier ADD CONSTRAINT supplier_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE tag ADD CONSTRAINT tag_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE tax ADD CONSTRAINT tax_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE template ADD CONSTRAINT template_company_id_company_id FOREIGN KEY (company_id) REFERENCES company(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_group_permission ADD CONSTRAINT sf_guard_group_permission_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_remember_key ADD CONSTRAINT sf_guard_remember_key_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_group ADD CONSTRAINT sf_guard_user_group_group_id_sf_guard_group_id FOREIGN KEY (group_id) REFERENCES sf_guard_group(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE sf_guard_user_permission ADD CONSTRAINT sf_guard_user_permission_permission_id_sf_guard_permission_id FOREIGN KEY (permission_id) REFERENCES sf_guard_permission(id) ON DELETE CASCADE;
