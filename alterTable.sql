ALTER TABLE patients ADD COLUMN password varchar(30) DEFAULT '123';
ALTER TABLE labs ADD COLUMN password varchar(30) DEFAULT '123';

ALTER TABLE patients ALTER patient_id SET DEFAULT nextval('patient_id_seq');
ALTER TABLE doctors ALTER doctor_id SET DEFAULT nextval('doctor_id_seq');
ALTER TABLE labs ALTER lab_id SET DEFAULT nextval('lab_id_seq');
ALTER TABLE collectors ALTER collector_id SET DEFAULT nextval('collector_id_seq');
ALTER TABLE tests ALTER test_id SET DEFAULT nextval('test_id_seq');
ALTER TABLE locations ALTER location_id SET DEFAULT nextval('location_id_seq');
ALTER TABLE diagnosis ALTER diagnosis_id SET DEFAULT nextval('diagnosis_id_seq');
ALTER TABLE reports ALTER report_id SET DEFAULT nextval('report_id_seq');
ALTER TABLE prescriptions ALTER prescription_id SET DEFAULT nextval('prescription_id_seq');

ALTER TABLE samples ADD UNIQUE (report_id);

ALTER TABLE doctors ADD COLUMN password varchar(30) DEFAULT '123';
ALTER TABLE collectors ADD COLUMN password varchar(30) DEFAULT '123';

ALTER TABLE tests ADD UNIQUE(name);
ALTER TABLE samples ADD collected boolean ;