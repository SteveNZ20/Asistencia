CREATE TABLE Usuarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Identificador VARCHAR(50) NOT NULL,
    Nombres VARCHAR(100) NOT NULL,
    Apellidos VARCHAR(100) NOT NULL,
    Rol_ID INT,  -- Columna para vincular el rol
    CONSTRAINT FK_Rol_Usuario FOREIGN KEY (Rol_ID) REFERENCES Roles(ID)
);

CREATE TABLE Datos (
    ID INT,
    DNI VARCHAR(20) NOT NULL,
    Correo_Electronico VARCHAR(100) NOT NULL,
    Fecha_Nacimiento DATE NOT NULL,
    Ruta_Foto VARCHAR(255),
    Ruta_Documentos VARCHAR(255),
    PRIMARY KEY (ID),
    FOREIGN KEY (ID) REFERENCES Usuarios(ID)
);

CREATE TABLE Horarios (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    UsuarioID INT,
    Fecha DATE NOT NULL,
    Hora_Ingreso TIME,
    Hora_Salida TIME,
    FOREIGN KEY (UsuarioID) REFERENCES Usuarios(ID)
);

CREATE TABLE Sedes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Nombre_Sede VARCHAR(100) NOT NULL,
    Correo VARCHAR(100),
    Direccion VARCHAR(255) NOT NULL
);

CREATE TABLE AdmSedes (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    SedeID INT,
    Encargado_Mañana INT,
    Encargado_Tarde INT,
    Fecha_Inicio DATE,
    Fecha_Fin DATE,
    FOREIGN KEY (SedeID) REFERENCES Sedes(ID),
    FOREIGN KEY (Encargado_Mañana) REFERENCES Usuarios(ID),
    FOREIGN KEY (Encargado_Tarde) REFERENCES Usuarios(ID)
);