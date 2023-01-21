DROP DATABASE if EXISTS dbTutorias;
CREATE DATABASE dbTutorias;
use dbTutorias;

create TABLE Tutor(
    codigoTutor varchar(6) not null,
    correoTutor varchar(40) not null,
    contrasenia varchar(20) not null,
    nombres varchar(60) not null,
    apellidos varchar(60) not null,
    dniTutor varchar(8) not null,
    
    PRIMARY KEY (codigoTutor)
);

create TABLE Alumno(
	codigoAlumno varchar(6) not null,
    correoAlumno varchar(40) not null,
    contrasenia varchar(20) not null,
    nombres varchar(60) not null,
    apellidos varchar(60) not null,
    semestre varchar(12) not null,
    codigoTutor varchar(6) not null,
    dniAlumno varchar(8) not null,
    
	PRIMARY KEY (codigoAlumno),
    FOREIGN KEY (codigoTutor) REFERENCES Tutor(codigoTutor)
);

CREATE TABLE Disponibilidad(
    codigoTutor varchar(6) not null,
    dia varchar(15) not null CHECK (dia in ("lunes", "martes", "miercoles", "jueves", "viernes", "sabado", "domingo")),
    horaInicio int not null,
    horaFin int not null,
    estado varchar(10) not null CHECK (estado in ("libre", "ocupado")),
    
    PRIMARY KEY(codigoTutor, dia, horaInicio),
    FOREIGN KEY(codigoTutor) REFERENCES Tutor(codigoTutor)
);

CREATE TABLE Cita(
    fecha date not null,
    horaInicio int not null,
    horaFin int not null,
    codigoAlumno varchar(6) not null,
    estado varchar(20) not null CHECK (estado in ("PENDIENTE","CONFIRMADO","RECHAZADO","POSTERGADO","REALIZADO","NP","NO CLASIFICADO")),
    razon varchar(200),
    observacion varchar(100),

    PRIMARY KEY(fecha,horaInicio,codigoAlumno),
    FOREIGN KEY (codigoAlumno) REFERENCES alumno(codigoAlumno)
);

CREATE TABLE Mensaje(
	idMensaje int not null AUTO_INCREMENT,
    contenido varchar(250) not null,
    fecha datetime not null,
    codigoAlumno varchar(6),
    codigoTutor varchar(6),
    
    PRIMARY KEY (idMensaje),
    FOREIGN KEY(codigoAlumno) REFERENCES Alumno(codigoAlumno),
    FOREIGN KEY(codigoTutor) REFERENCES Tutor(codigoTutor)
);
CREATE TABLE Notificaciones(
    idNotificacion int not null AUTO_INCREMENT,
    codigoAlumno varchar(6) not null,
    fecha datetime not null,
    mensaje varchar(200) not null,
    asunto varchar(20) not null CHECK (asunto in ("PENDIENTE","CONFIRMADO","RECHAZADO","POSTERGADO","REALIZADO","NP")),
    visto varchar(2) not null CHECK (visto in ("Si", "No")),
    
    PRIMARY KEY(idNotificacion),
    FOREIGN KEY(codigoAlumno) REFERENCES Alumno(codigoAlumno)
);
insert into Tutor VALUES("1545", "alberto@unsaac.edu.pe", "12345678", "Alberto", "Flores Casas", "12457896");
insert into Tutor VALUES("1234", "antonio@unsaac.edu.pe", "88888888", "Antonio", "Vera Rivera", "13742343");
insert into Tutor VALUES("4444", "vanesa@unsaac.edu.pe", "44441111", "Vanesa Lisa", "Rojas Prado", "13143342");

insert into Alumno VALUES("192999", "192999@unsaac.edu.pe", "12345678", "Miguel", "Cconcho Castellano", "2022-I", "1545", "76232097");
insert into Alumno VALUES("193110", "193110@unsaac.edu.pe", "12345678", "Daniela", "Sanchez Flores", "2022-I", "1545", "76204510");
insert into Alumno VALUES("182731","182731@unsaac.edu.pe","11223344","Yerson","Chirinos Vilca","2022-I","1545","11223344");
insert into Alumno VALUES("190000","190000@unsaac.edu.pe","12341234","Martin","Apaza Torres","2022-I","1545","12341234");
insert into Alumno VALUES("200000","200000@unsaac.edu.pe","20000000","Fernanda","Madrigal Ramoz","2022-I","4444","78553456");
insert into Alumno VALUES("200344","200344@unsaac.edu.pe","12121212","Rosa","Martin Rios","2022-I","1234","85434456");
insert into Alumno VALUES("210004","210004@unsaac.edu.pe","11111111","Armando","Landis Pardo","2022-I","1234","75437689");