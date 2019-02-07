CREATE TABLE locations
(
    location_id integer PRIMARY KEY,
    address varchar(50) NOT NULL,
    longitude numeric,
    latitude numeric
);

CREATE TABLE patients
(
    patient_id integer PRIMARY KEY,
    name varchar(100) NOT NULL,
    email varchar(50) UNIQUE,
    phone_no integer UNIQUE,
    location_id integer REFERENCES locations(location_id)
);

CREATE TABLE tests
(
    test_id integer PRIMARY KEY,
    name varchar(100) NOT NULL,
    type boolean,
    description varchar(1000),
    organ varchar(50),
    disease varchar(50),
    package_id integer REFERENCES tests(test_id)
);

CREATE TABLE labs
(
    lab_id integer PRIMARY KEY,
    name varchar(100) NOT NULL,
    email varchar(50) UNIQUE,
    phone_no integer UNIQUE,
    location_id integer REFERENCES locations(location_id)
);

CREATE TABLE collectors
(
    collector_id integer PRIMARY KEY,
    lab_id integer REFERENCES labs(lab_id) , -- works for this lab
    name varchar(50) NOT NULL,
    email varchar(50) UNIQUE,
    phone_no integer UNIQUE
);

CREATE TABLE diagnosis
(
    diagnosis_id integer PRIMARY KEY,
    patient_id integer REFERENCES patients(patient_id),
    lab_id integer REFERENCES labs(lab_id),
    collector_id integer REFERENCES collectors(collector_id),
    collection_date timestamptz  -- time stamp with time zone
);

CREATE TABLE reports
(
    report_id integer PRIMARY KEY,
    content text
);

CREATE TABLE samples
(
    diagnosis_id integer REFERENCES diagnosis(diagnosis_id),
    test_id integer REFERENCES tests(test_id),
    done boolean ,
    report_id integer REFERENCES reports(report_id),
    issue_time timestamptz,
    PRIMARY KEY (diagnosis_id, test_id)
);

CREATE TABLE offers
(
    lab_id integer REFERENCES labs(lab_id),
    test_id integer REFERENCES tests(test_id),
    charge integer NOT NULL,
    PRIMARY KEY (lab_id, test_id)
);

CREATE TABLE doctors
(
    doctor_id integer PRIMARY KEY,
    name varchar(100) NOT NULL,
    email varchar(50) UNIQUE,
    phone_no integer UNIQUE
);

CREATE TABLE prescriptions
(
    prescription_id integer PRIMARY KEY,
    doctor_id integer REFERENCES doctors(doctor_id),
    patient_id integer REFERENCES patients(patient_id)
);

CREATE TABLE issued
(
    prescription_id integer REFERENCES prescriptions(prescription_id),
    test_id integer REFERENCES tests(test_id)
);


















