CREATE OR REPLACE PROCEDURE issue_test(IN doctor integer, IN patient integer, IN test integer)
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