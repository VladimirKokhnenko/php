drop database if exists vkorginizer_db;
create database if not exists vkorginizer_db;
use vkorginizer_db;

create table Years
(
    Id int primary key auto_increment,
    NameYear year not null
);

create table Months
(
    Id int primary key auto_increment,
    Year_Fk int not null,
    NameMonth varchar(10),
    NumberMonth int not null,
    foreign key (Year_Fk) references Years (Id) on delete cascade
);

create table Weeks
(
    Id int primary key auto_increment,
    Month_Fk int not null,
    NameWeek int not null,
    foreign key (Month_Fk)  references Months (Id) on delete cascade
);

create table Days
(
    Id int primary key auto_increment,
    Week_Fk int not null,
    DateDay int not null,
    foreign key (Week_Fk) references Weeks (Id) on delete cascade
);

create table Tasks
(
    Id int primary key auto_increment,
    Days_Fk int not null,
    NameTask varchar(100) default null,
    TimeTask time not null,
    DescriptionTask text default null,
    foreign key (Days_Fk) references Days (Id) on delete cascade
);