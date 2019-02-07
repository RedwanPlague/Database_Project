CREATE OR REPLACE FUNCTION match(sa varchar(30), sb varchar(30))
RETURNS numeric
AS $$
DECLARE
    mxlen integer := 30;
    la integer;
    lb integer;
    lcs integer[1000];
BEGIN

    la := length(sa);
    lb := length(sb);

    for i in 1..la loop
        if(substring(sa from i for 1) = substring(sb from 1 for 1)) then
            lcs[mxlen*i+1] = 1;
        else
            lcs[mxlen*i+1] = 0;
        end if;
    end loop;

    for j in 1..lb loop
        if(substring(sa from 1 for 1) = substring(sb from j for 1)) then
                lcs[mxlen+j] = 1;
        else
                lcs[mxlen+j] = 0;
        end if;
    end loop;

    for i in 2..la loop
        for j in 2..lb loop
            if(substring(sa from i for 1) = substring(sb from j for 1)) then
                lcs[mxlen*i+j] = 1 + lcs[mxlen*(i-1)+j-1];
            elsif(lcs[mxlen*(i-1)+j] > lcs[mxlen*i+j-1]) then
                lcs[mxlen*i+j] = lcs[mxlen*(i-1)+j];
            else
                lcs[mxlen*i+j] = lcs[mxlen*i+j-1];
            end if;
        end loop;
    end loop;

    return (lcs[mxlen*la+lb] / la) * 100;

END ;
$$ LANGUAGE plpgsql;