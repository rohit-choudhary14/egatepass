--
select adv_reg, email, adv_mobile
from advocate_t
where trim(email) != '' and length(adv_mobile) = 10
limit 10

--
select jp.adv_reg, jp.email, jp.adv_mobile, jdp.adv_reg, jdp.email, jdp.adv_mobile
from advocate_t jp
inner join dblink('host=10.249.41.54 user=postgres dbname=rhcjodh240618',
'select adv_reg, email, adv_mobile from advocate_t where length(adv_mobile) = 10')
as jdp(adv_reg text, email text, adv_mobile text)
on jp.adv_reg = jdp.adv_reg
where length(jp.adv_mobile) != 10
limit 10

-- gate pass
select * from dblink('host=10.138.171.9 user=postgres dbname=rhcjodh240618',
'select passfor, count(*) from gatepass_details group by passfor order by passfor')
as a(passfor text, passes text)

select * from dblink('host=10.138.171.9 user=postgres dbname=rhcjodh240618',
'select passtype, count(*) from gatepass_details group by passtype order by passtype')
as a(passtype text, passes text)

--
select * from advocate_t where adv_reg ilike 'R8102004'
--update advocate_t set adv_mobile='9829022083' where adv_reg ilike 'R32016%sr%'

--
select * from dblink('host=10.138.171.9 user=postgres dbname=rhcjodh240618',
'select adv_reg, adv_name, email, adv_mobile from advocate_t where adv_reg ilike ''R32016%sr%'';')
as jdp(adv_reg text, adv_name text, email text, adv_mobile text)

select dblink_exec('host=10.138.171.9 user=postgres dbname=rhcjodh240618',
'update advocate_t set adv_mobile=''9829022083'' where adv_reg ilike ''R32016%sr%'';')
