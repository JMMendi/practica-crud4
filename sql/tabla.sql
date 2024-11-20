create table categorias(
    id int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(40) unique not null
);

create table articulos (
    id int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar(40) UNIQUE not null,
    descripcion text not null,
    disponible enum("SI", "NO"),
    categoria_id int not null,
    constraint fk_art_cat FOREIGN KEY(categoria_id) REFERENCES categorias(id) on delete cascade
);