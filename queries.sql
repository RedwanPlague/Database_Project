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