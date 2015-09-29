select distinct 
states.name, counties.name
from counties 
left join states on states.id = '9';

select users.first,users.last,clubs.*
from users
join clubs 
on users.id = clubs.user_id;

select states.name, counties.name, cities.name
from states 
right join counties 
on states.id = 9
right join cities
on counties.id = cities.county_id;

select counties.name,cities.name
from counties
inner join cities
where

select distinct 
states.name,counties.name,cities.name
from states
right join counties
on states.id = '9'
join cities
on cities.county_id = counties.id;

select states.name, counties.name, cities.name
from counties
join states on states.id = counties.state_id
join cities on counties.state_id = cities.county_id
where states.name = 'florida';

select states.name,counties.name, cities.name
from states
left join counties on states.id = counties.state_id
right join cities on counties.id = cities.county_id;

select states.name,counties.name
from states
left join counties on counties.state_id = states.id
where states.name = 'florida';

select states.name,counties.name,cities.name
from states
left join counties on states.id = counties.state_id
left join cities on counties.id = cities.county_id
where states.id = '9';

select states.name,counties.name
from states
left join counties on counties.state_id = states.id;

select counties.name 
from states 
join counties
on counties.state_id = states.id 
where states.name = 'florida';