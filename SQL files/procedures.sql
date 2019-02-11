CREATE OR REPLACE FUNCTION issue_test(IN doctor integer, IN patient integer, IN test integer)
RETURNS void
AS $$
DECLARE
    prescription integer;
BEGIN

    if not exists(SELECT prescription_id FROM prescriptions WHERE doctor_id = doctor AND patient_id = patient) then
        INSERT INTO prescriptions (doctor_id, patient_id)  VALUES (doctor, patient);
    end if;

    SELECT prescription_id INTO prescription
    FROM prescriptions
    WHERE doctor_id = doctor AND patient_id = patient;

    INSERT INTO issued VALUES (prescription, test);

END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION book_test(IN patient integer, IN lab integer, IN test integer, IN isu_date varchar(20))
RETURNS void
AS $$
DECLARE
    diagnosis_id integer;
    is_date date;
BEGIN

    is_date := to_date(isu_date, 'YYYY-MM-DD');

    if not exists(SELECT D.diagnosis_id
                  FROM diagnosis D
                  WHERE D.patient_id = patient AND D.lab_id = lab AND D.collection_date = is_date) then
        INSERT INTO diagnosis(patient_id, lab_id) VALUES (patient, lab);

    end if;

    SELECT D.diagnosis_id INTO diagnosis_id
    FROM diagnosis D
    WHERE D.patient_id = patient AND D.lab_id = lab AND D.collection_date = is_date;

    INSERT INTO samples VALUES (diagnosis_id, test, false, null, false);

END;
$$ LANGUAGE plpgsql;
