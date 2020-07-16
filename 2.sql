#2. Напишите запрос, отыскивающий неуникальные значения id в таблице CREATE TABLE (id int not null, name text);

select id, COUNT(id) c
from table_name
group by id
having c > 1;
