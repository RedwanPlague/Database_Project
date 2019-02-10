/* 1 */
SELECT LB.lab_id, LB.name, LB.email, LB.phone_no,
       (SELECT LC.address FROM locations LC WHERE LC.location_id = LB.location_id) location_name,
       (SELECT O.charge FROM offers O WHERE O.lab_id = LB.lab_id AND O.test_id = 3001) charge
FROM labs LB
WHERE LB.lab_id IN (SELECT O.lab_id FROM offers O WHERE O.test_id = 3001);

SELECT LB.lab_id, LB.name, LB.email, LB.phone_no,
       (SELECT LC.address FROM locations LC WHERE LC.location_id = LB.location_id) location_name, O.charge
FROM labs LB JOIN offers O ON (LB.lab_id = O.lab_id)
WHERE O.test_id = 3001;

/* 2 */
SELECT T.test_id, T.name, T.description, T.organ, T.disease,
       (SELECT O.charge FROM offers O WHERE O.test_id = T.test_id AND O.lab_id = 5001) charge
FROM tests T
WHERE T.test_id IN (SELECT O.test_id FROM offers O WHERE lab_id = 5001);

SELECT T.test_id, T.name, T.description, T.organ, T.disease, O.charge
FROM tests T JOIN offers O ON (T.test_id = O.test_id)
WHERE O.lab_id = 5001;

/* 3 */
SELECT LB.lab_id, LB.name, LB.email, LB.phone_no,
       (SELECT LC.address FROM locations LC WHERE LC.location_id = LB.location_id) location_name
FROM labs LB WHERE LB.lab_id = 5001;

/* 4 */
SELECT
       P.name,
       (SELECT LC.address FROM locations LC WHERE LC.location_id = P.location_id) AS location,
       D.collection_date
FROM diagnosis D JOIN patients P ON (D.patient_id = P.patient_id)
WHERE D.collector_id = 4001;

/* 5 */
SELECT
    (SELECT L.name FROM labs L WHERE L.lab_id = (SELECT D.lab_id FROM diagnosis D WHERE D.diagnosis_id = S.diagnosis_id)),
    (SELECT T.name FROM tests T WHERE T.test_id = S.test_id),
    S.issue_time,
    R.content
FROM reports R JOIN samples S ON (R.report_id = S.report_id)
WHERE S.done AND S.diagnosis_id IN
                 (SELECT D.diagnosis_id FROM diagnosis D WHERE D.patient_id = 1001)
ORDER BY S.issue_time DESC ;

/* 6 */
SELECT
    (SELECT P.name FROM patients P WHERE P.patient_id = D.patient_id),
    (SELECT LC.address FROM locations LC WHERE location_id = (SELECT P.location_id FROM patients P WHERE P.patient_id = D.patient_id)),
    (SELECT T.name FROM tests T WHERE T.test_id = S.test_id),
    S.issue_time
FROM samples S JOIN diagnosis D ON S.diagnosis_id = D.diagnosis_id
WHERE D.collector_id = 4001 AND NOT S.collected
ORDER BY S.issue_time DESC ;
