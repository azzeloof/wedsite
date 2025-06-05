CREATE TABLE guests (
    guest_id INT AUTO_INCREMENT PRIMARY KEY,
    last_name_1 VARCHAR(255) NOT NULL,
    first_name_1 VARCHAR(255) NULL,
    last_name_2 VARCHAR(255) NULL,
    first_name_2 VARCHAR(255) NULL,
    phone_number_1 VARCHAR(15) NULL,
    email_1 VARCHAR(255) NULL,
    phone_number_2 VARCHAR(15) NULL,
    email_2 VARCHAR(255) NULL,
    needs_transportation BOOLEAN NULL,
    rsvp_code VARCHAR(10) NOT NULL UNIQUE,
    guest_1_attending BOOLEAN NULL, -- NULL means not yet responded
    guest_2_attending BOOLEAN NULL, -- NULL means not yet responded
    plus_ones_allowed INT DEFAULT 0, -- How many guests this code allows
    plus_ones_attending INT NULL,
    dietary_restrictions TEXT NULL,
    has_rsvpd BOOLEAN DEFAULT FALSE NOT NULL,
    submission_timestamp TIMESTAMP NULL
);

-- Index for faster lookups during authentication
CREATE INDEX idx_code_lastname_1 ON guests (rsvp_code, last_name_1);
CREATE INDEX idx_code_lastname_2 ON guests (rsvp_code, last_name_2);