CREATE OR REPLACE FUNCTION lcs(sa varchar(30), sb varchar(30))
RETURNS integer
AS $$
DECLARE
    mxlen integer := 30;
    la integer;
    lb integer;
    lcs integer[10];
BEGIN

    if(sa IS NULL) then
        sa := "";
    else
        sa := lower(sa);
    end if;
    if(sb IS NULL) then
        sb := "";
    else
        sb := lower(sb);
    end if;
    la := length(sa);
    lb := length(sb);

    for i in 0..la loop
        lcs[mxlen*i] := 0;
    end loop;

    for j in 0..lb loop
        lcs[j] := 0;
    end loop;

    for i in 1..la loop
        for j in 1..lb loop
            if(substring(sa,i,1) = substring(sb,j,1)) then
                lcs[mxlen*i+j] := 1 + lcs[mxlen*(i-1)+j-1];
            elsif(lcs[mxlen*(i-1)+j] > lcs[mxlen*i+j-1]) then
                lcs[mxlen*i+j] := lcs[mxlen*(i-1)+j];
            else
                lcs[mxlen*i+j] := lcs[mxlen*i+j-1];
            end if;
        end loop;
    end loop;

    return lcs[mxlen*la+lb];

END ;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION distance(loc1 integer, loc2 integer)
    RETURNS numeric
AS $$
DECLARE
    lat1 numeric;
    lat2 numeric;
    lon1 numeric;
    lon2 numeric;
    R integer := 6371e3; -- Meters
    rad numeric := 0.01745329252;
    phi1 numeric;
    phi2 numeric;
    diff numeric;
    diffL numeric;
    a numeric;
    c numeric;

BEGIN

    SELECT longitude, latitude INTO lon1, lat1
    FROM locations
    WHERE location_id = loc1;

    SELECT longitude, latitude INTO lon2, lat2
    FROM locations
    WHERE location_id = loc2;

    phi1 := lat1 * rad;
    phi2 := lat2 * rad;
    diff := (lat2-lat1) * rad;
    diffL := (lon2-lon1) * rad;

    a := sin(diff/2) * sin(diff/2) + cos(phi1) * cos(phi2) * sin(diffL/2) * sin(diffL/2);
    c := 2 * atan2(sqrt(a), sqrt(1-a));

    RETURN R * c;

END;
$$ LANGUAGE plpgsql;