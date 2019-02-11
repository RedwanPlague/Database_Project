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
