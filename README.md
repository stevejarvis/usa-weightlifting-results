![logo](https://github.com/stevejarvis/usa-weightlifting-results/blob/master/usaw.png) USA Weightlifting Results
================================================================================================================

SQL database and code to search years of USA Weightlifting competitions. See it live at [nerdster.org](http://www.nerdster.org/usaw/).

# Contributing
To contribute, there are three tables that need to be updated:

## Table for the actual results
A new table should be added named "YearCompetition" with the following schema (just follow suite with what
already exists). 

+-------------+-------------+------+-----+---------+-------+
| Field       | Type        | Null | Key | Default | Extra |
+-------------+-------------+------+-----+---------+-------+
| class       | char(10)    | NO   |     | NULL    |       |
| name        | char(40)    | NO   |     | NULL    |       |
| yearOfBirth | year(4)     | NO   |     | NULL    |       |
| team        | char(11)    | NO   |     | NULL    |       |
| bodyWeight  | double      | NO   |     | NULL    |       |
| snatch1     | char(10)    | NO   |     | NULL    |       |
| snatch2     | char(10)    | NO   |     | NULL    |       |
| snatch3     | char(10)    | NO   |     | NULL    |       |
| jerk1       | char(10)    | NO   |     | NULL    |       |
| jerk2       | char(10)    | NO   |     | NULL    |       |
| jerk3       | char(10)    | NO   |     | NULL    |       |
| total       | smallint(6) | NO   |     | NULL    |       |
| place       | smallint(6) | NO   |     | NULL    |       |
+-------------+-------------+------+-----+---------+-------+

## Competition database
To look up the competitions for which we have records. Should add a script
to generate this table based on the names of all the specific competition tables.

+-------+----------+------+-----+---------+-------+
| Field | Type     | Null | Key | Default | Extra |
+-------+----------+------+-----+---------+-------+
| name  | char(40) | NO   |     | NULL    |       |
| year  | year(4)  | NO   |     | NULL    |       |
+-------+----------+------+-----+---------+-------+

## Athlete database
A database with records for all individual athletes. This is autogenerated with the
'populateathletedb.php' script, just use that.

+-------+-------------+------+-----+---------+-------+
| Field | Type        | Null | Key | Default | Extra |
+-------+-------------+------+-----+---------+-------+
| key   | varchar(80) | NO   | PRI | NULL    |       |
| name  | char(40)    | NO   |     | NULL    |       |
| year  | year(4)     | NO   |     | NULL    |       |
| comp  | char(40)    | NO   |     | NULL    |       |
| title | char(40)    | NO   |     | NULL    |       |
| class | char(10)    | NO   |     | NULL    |       |
| place | char(10)    | NO   |     | NULL    |       |
+-------+-------------+------+-----+---------+-------+

# Running
To run the code and see that results are returned as expected, set it up on a local MySQL
and web server. The javascript used at [nerdster](https://github.com/stevejarvis/stevejarvis.github.io)
could help get it going, just change URIs as necessary.