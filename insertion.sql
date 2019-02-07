INSERT INTO locations (address, longitude, latitude)
VALUES ('Matuail, Jatrabari, Dhaka', 0, 1);
INSERT INTO locations (address, longitude, latitude)
VALUES ('Arambag, Motijheel, Dhaka', 1, 1);
INSERT INTO locations (address, longitude, latitude)
VALUES ('Polashi, Dhaka', 3, 4);
INSERT INTO locations (address, longitude, latitude)
VALUES ('Khilgaon, Dhaka', 10, 12);
INSERT INTO locations (address, longitude, latitude)
VALUES ('Molmol, Dhaka', 7, 12);
INSERT INTO locations (address, longitude, latitude)
VALUES ('Kolkol, Dhaka', 10, 7);


INSERT INTO patients (name, email, phone_no, location_id)
VALUES ('Papon', 'pepen@gmail.com', 1521474848, 103);
INSERT INTO patients (name, email, phone_no, location_id)
VALUES ('Redwan', 'red@gmail.com', 1521484756, 101);
INSERT INTO patients (name, email, phone_no, location_id)
VALUES ('Tushar', 'tush@gmail.com', 1521987459, 102);
INSERT INTO patients (name, email, phone_no, location_id)
VALUES ('Sahil', 'sah@gmail.com', 1521474899, 104);
INSERT INTO patients (name, email, phone_no, location_id)
VALUES ('Sezan Juice', 'sezan@gmail.com', 1521474800, 103);


INSERT INTO labs (name, email, phone_no, location_id) VALUES ('Ibne Sina', 'sina@gmail.com', 171010101, 101);
INSERT INTO labs (name, email, phone_no, location_id) VALUES ('Medicare', 'medc@gmail.com', 171010103, 102);
INSERT INTO labs (name, email, phone_no, location_id) VALUES ('Medihope', 'hope@gmail.com', 171010102, 103);
INSERT INTO labs (name, email, phone_no, location_id) VALUES ('Abu Sina', 'absin@gmail.com', 171010198, 104);
INSERT INTO labs (name, email, phone_no, location_id) VALUES ('Sina Care', 'sinc@gmail.com', 171010112, 105);

INSERT INTO collectors (lab_id, name, email, phone_no) VALUES (5001, 'Agar Jan', 'agj@gmail.com', 167457845);
INSERT INTO collectors (lab_id, name, email, phone_no) VALUES (5001, 'Aga Jan', 'jan@gmail.com', 167451845);
INSERT INTO collectors (lab_id, name, email, phone_no) VALUES (5003, 'Agar Ja', 'gar@gmail.com', 167458845);
INSERT INTO collectors (lab_id, name, email, phone_no) VALUES (5002, 'Gar Jan', 'gaj@gmail.com', 167453845);
INSERT INTO collectors (lab_id, name, email, phone_no) VALUES (5004, 'Gar Ja', 'grj@gmail.com', 167457805);

INSERT INTO tests (name, type, description, disease)
VALUES ('HbA1c; GLYCOSYLATED HEMOGLOBIN', false, 'This assay is usef' ||
                                                 'ul for diagnosing Diabetes and evaluating long term control of blood glucose concentrations' ||
                                                 ' in diabetic patients. It reflects the mean glucose concentration over the previous period of' ||
                                                 ' 8 to 12 weeks and is a better indicator of long term glycemic control as compared with blood and urine ' ||
                                                 'glucose measurements.', 'Diabetics');
INSERT INTO tests (name, type, description, organ, disease)
VALUES ('abcd; Leucomm', false, 'aaaaaaa', 'heart', 'chorbi');
INSERT INTO tests (name, type, description, organ, disease)
VALUES ('degf; geucom', false, 'aaaaaa', 'eyes', 'chock uthse');
INSERT INTO tests (name, type, description, organ, disease)
VALUES ('dr101; diabetici', true, 'aaaaaa', 'lungs', 'shash koshto');
INSERT INTO tests (name, type, description, organ, disease)
VALUES ('kid2b; kidman', false, 'aaaaaaaaa', 'kidney', 'pathor');
INSERT INTO tests (name, type, description, organ, disease)
VALUES ('tiri1b; liverosis', false, 'aaaaaaaaaa', 'liver', 'hepatitis');
INSERT INTO tests (name, type, description, organ, disease)
VALUES ('blk2a; heartitis', false, 'aaaaaaaaa', 'heart', 'blocked');
INSERT INTO tests (name, type, description, organ, disease)
VALUES ('bon3d; bonisitis', false, 'aaaaaaaaaa', 'bones', 'osteoperosis');

INSERT INTO diagnosis (patient_id, lab_id, collector_id, collection_date)
VALUES (1001, 5001, 4001, current_timestamp(0));
INSERT INTO diagnosis (patient_id, lab_id, collector_id, collection_date)
VALUES (1002, 5001, 4001, current_timestamp(0));
INSERT INTO diagnosis (patient_id, lab_id, collector_id, collection_date)
VALUES (1001, 5001, 4002, current_timestamp(0));
INSERT INTO diagnosis (patient_id, lab_id, collector_id, collection_date)
VALUES (1001, 5002, 4004, current_timestamp(0));
INSERT INTO diagnosis (patient_id, lab_id, collector_id, collection_date)
VALUES (1002, 5001, 4002, current_timestamp(0));
INSERT INTO diagnosis (patient_id, lab_id, collector_id, collection_date)
VALUES (1005, 5002, 4004, current_timestamp(0));
INSERT INTO diagnosis (patient_id, lab_id, collector_id, collection_date)
VALUES (1004, 5003, 4003, current_timestamp(0));
INSERT INTO diagnosis (patient_id, lab_id, collector_id, collection_date)
VALUES (1001, 5004, 4005, current_timestamp(0));

INSERT INTO offers (lab_id, test_id, charge) VALUES (5001, 3001, 250);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5001, 3002, 450);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5001, 3003, 600);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5001, 3004, 350);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5002, 3001, 300);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5002, 3002, 400);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5002, 3004, 400);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5003, 3001, 230);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5003, 3003, 550);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5004, 3005, 700);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5004, 3001, 400);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5005, 3002, 500);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5005, 3004, 400);
INSERT INTO offers (lab_id, test_id, charge) VALUES (5005, 3005, 800);

INSERT INTO reports (content) VALUES ('HIV Aladeen');
INSERT INTO reports (content) VALUES ('HIV Aladeen');
INSERT INTO reports (content) VALUES ('Cancer Aladeen');
INSERT INTO reports (content) VALUES ('Alright Aladeen');
INSERT INTO reports (content) VALUES ('Aladeen Aladeen');


INSERT INTO samples (diagnosis_id, test_id, done, report_id, issue_time)
VALUES (10001, 3001, true, 20001, current_timestamp(0));
INSERT INTO samples (diagnosis_id, test_id, done, report_id, issue_time)
VALUES (10001, 3002, true, 20002, current_timestamp(0));
INSERT INTO samples (diagnosis_id, test_id, done, report_id, issue_time)
VALUES (10001, 3003, true, 20003, current_timestamp(0));
INSERT INTO samples (diagnosis_id, test_id, done, report_id, issue_time)
VALUES (10002, 3004, true, 20004, current_timestamp(0));
INSERT INTO samples (diagnosis_id, test_id, done, report_id, issue_time)
VALUES (10004, 3001, true, 20005, current_timestamp(0));
INSERT INTO samples (diagnosis_id, test_id, done, issue_time)
VALUES (10004, 3002, false, current_timestamp(0));
INSERT INTO samples (diagnosis_id, test_id, done, issue_time)
VALUES (10004, 3004, false, current_timestamp(0));

INSERT INTO doctors (name, email, phone_no) VALUES ('Mahinur Rahman', 'mahim@gmail.com', 1521343434);
INSERT INTO doctors (name, email, phone_no) VALUES ('Aba Caba', 'abac@gmail.com', 1721343434);
INSERT INTO doctors (name, email, phone_no) VALUES ('Dexter Morgan', 'dext@gmail.com', 1821343434);
INSERT INTO doctors (name, email, phone_no) VALUES ('Hannibal Lecter', 'hann@gmail.com', 1921343434);
INSERT INTO doctors (name, email, phone_no) VALUES ('Alam Mants', 'alam@gmail.com', 1621343434);

INSERT INTO prescriptions (doctor_id, patient_id) VALUES (2001, 1001);
INSERT INTO prescriptions (doctor_id, patient_id) VALUES (2004, 1002);
INSERT INTO prescriptions (doctor_id, patient_id) VALUES (2005, 1001);
INSERT INTO prescriptions (doctor_id, patient_id) VALUES (2001, 1004);

INSERT INTO issued (prescription_id, test_id) VALUES (30001, 3001);
INSERT INTO issued (prescription_id, test_id) VALUES (30001, 3002);
INSERT INTO issued (prescription_id, test_id) VALUES (30001, 3003);
INSERT INTO issued (prescription_id, test_id) VALUES (30002, 3001);
INSERT INTO issued (prescription_id, test_id) VALUES (30002, 3005);
INSERT INTO issued (prescription_id, test_id) VALUES (30003, 3003);
INSERT INTO issued (prescription_id, test_id) VALUES (30004, 3004);