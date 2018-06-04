CREATE DATABASE IF NOT EXISTS mgaccesorios;
USE mgaccesorios;

CREATE TABLE users(
    id_user INT(6) auto_increment NOT NULL,
    name VARCHAR(20) NOT NULL,
    lastname VARCHAR(20) NOT NULL,
    username VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(20) NOT NULL,
    password VARCHAR(20) NOT NULL,
    rol INT(2) NOT NULL,
    estatus INT(2) NOT NULL,
    remember_token VARCHAR(100),
    CONSTRAINT pk_users PRIMARY KEY(id_user)
)ENGINE=InnoDb;

CREATE TABLE sucursales(
    id_sucursal INT(6) auto_increment NOT NULL,
    nombre_sucursal VARCHAR(50) NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    telefono INT(10),
    estatus INT(2) NOT NULL,
    CONSTRAINT pk_sucursales PRIMARY KEY(id_sucursal)
)ENGINE=InnoDb;

CREATE TABLE venta(
    id_venta INT(6) auto_increment NOT NULL,
    id_sucursal INT(6) NOT NULL,
    CONSTRAINT pk_venta PRIMARY KEY(id_venta),
    CONSTRAINT fk_venta_sucursales FOREIGN KEY(id_sucursal) REFERENCES sucursales(id_sucursal)
)ENGINE=InnoDb;

CREATE TABLE cobro(
    id_cobro INT(6) auto_increment NOT NULL,
    id_venta INT(6) NOT NULL,
    id_user INT(6) NOT NULL,
    monto_total DECIMAL(7,0) NOT NULL,
    fecha datetime NOT NULL,
    CONSTRAINT pk_cobro PRIMARY KEY(id_cobro),
    CONSTRAINT fk_cobro_venta FOREIGN KEY(id_venta) REFERENCES venta(id_venta),
    CONSTRAINT fk_cobro_users FOREIGN KEY(id_user) REFERENCES users(id_user)
)ENGINE=InnoDb;

CREATE TABLE producto(
    id_producto INT(6) auto_increment NOT NULL,
    referencia VARCHAR(10) NOT NULL,
    categoria_producto VARCHAR(20) NOT NULL,
    tipo_producto VARCHAR(20) NOT NULL,
    marca TEXT NOT NULL,
    modelo VARCHAR(20) NOT NULL,
    color VARCHAR(20) NOT NULL,
    precio_compra DECIMAL(7,0) NOT NULL,
    precio_venta DECIMAL(7,0) NOT NULL,
    estatus INT(2),
    CONSTRAINT pk_producto PRIMARY KEY(id_producto)
)ENGINE=InnoDb;

CREATE TABLE cuenta(
    id_cuenta INT(6) auto_increment NOT NULL,
    id_venta INT(6) NOT NULL,
    id_producto INT(6) NOT NULL,
    cantidad INT(5) NOT NULL,
    precio DECIMAL(7,0) NOT NULL,
    fecha datetime NOT NULL,
    CONSTRAINT pk_cuenta PRIMARY KEY(id_cuenta),
    CONSTRAINT fk_cuenta_venta FOREIGN KEY(id_venta) REFERENCES venta(id_venta),
    CONSTRAINT fk_cuenta_producto FOREIGN KEY(id_producto) REFERENCES producto(id_producto)
)ENGINE=InnoDb;

CREATE TABLE detalleAlmacen(
    id_detallea INT(6) auto_increment NOT NULL,
    id_producto INT(6) NOT NULL,
    id_sucursal INT(6) NOT NULL,
    existencia INT(5) NOT NULL,
    CONSTRAINT pk_detalleAlmacen PRIMARY KEY(id_detalleA),
    CONSTRAINT fk_detalleAlmacen_producto FOREIGN KEY(id_producto) REFERENCES producto(id_producto),
    CONSTRAINT fk_detalleAlmacen_sucursales FOREIGN KEY(id_sucursal) REFERENCES sucursales(id_sucursal)
)ENGINE=InnoDb;

CREATE TABLE devoluciones(
    id_devolucion INT(6) auto_increment NOT NULL,
    id_venta INT(6) NOT NULL,
    id_sucursal INT(6) NOT NULL,
    id_producto INT(6) NOT NULL,
    descripcion VARCHAR(50) NOT NULL,
    cantidad INT(5) NOT NULL,
    CONSTRAINT pk_devoluciones PRIMARY KEY(id_devolucion),
    CONSTRAINT fk_devoluciones_venta FOREIGN KEY(id_venta) REFERENCES venta(id_venta),
    CONSTRAINT fk_devoluciones_sucursales FOREIGN KEY(id_sucursal) REFERENCES sucursales(id_sucursal),
    CONSTRAINT fk_devoluciones_producto FOREIGN KEY(id_producto) REFERENCES producto(id_producto)
)ENGINE=InnoDb;

CREATE TABLE fondo(
    id_fondo INT(6) auto_increment NOT NULL,
    id_user INT(6) NOT NULL,
    cantidad INT(5) NOT NULL,
    fecha datetime NOT NULL,
    CONSTRAINT pk_fondo PRIMARY KEY(id_fondo),
    CONSTRAINT fk_fondo_users FOREIGN KEY(id_user) REFERENCES users(id_user)
)ENGINE=InnoDb;

CREATE TABLE gastos(
    id_gasto INT(6) auto_increment NOT NULL,
    id_fondo int(6) NOT NULL,
    descripcion VARCHAR(50) NOT NULL,
    cantidad INT(5) NOT NULL,
    fecha datetime NOT NULL,
    CONSTRAINT pk_gastos PRIMARY KEY(id_gasto),
    CONSTRAINT fk_gastos_fondo FOREIGN KEY(id_fondo) REFERENCES fondo(id_fondo)
)ENGINE=InnoDb;

CREATE TABLE salidaEspecial(
    id_especial INT(6) auto_increment NOT NULL,
    id_sucursal INT(6) NOT NULL,
    id_producto INT(6) NOT NULL,
    id_user INT(6) NOT NULL,
    descripcion VARCHAR(50) NOT NULL,
    cantidad INT(4) NOT NULL,
    fecha datetime NOT NULL,
    CONSTRAINT pk_salidaEspecial PRIMARY KEY(id_especial),
    CONSTRAINT fk_salidaEspecial_sucursales FOREIGN KEY(id_sucursal) REFERENCES sucursales(id_sucursal),
    CONSTRAINT fk_salidaEspecial_producto FOREIGN KEY(id_producto) REFERENCES producto(id_producto),
    CONSTRAINT fk_salidaEspecial_users FOREIGN KEY(id_user) REFERENCES users(id_user)
)ENGINE=InnoDb;

CREATE TABLE traspasos(
    id_traspaso INT(6) auto_increment NOT NULL,
    id_producto INT(6) NOT NULL,
    id_user INT(6) NOT NULL,
    sucursal_origen VARCHAR(20) NOT NULL,
    sucursal_descuida VARCHAR(20) NOT NULL,
    cantidad INT(5) NOT NULL,
    fecha datetime NOT NULL,
    CONSTRAINT pk_traspasos PRIMARY KEY(id_traspaso),
    CONSTRAINT fk_traspasos_producto FOREIGN KEY(id_producto) REFERENCES producto(id_producto),
    CONSTRAINT fk_traspasos_users FOREIGN KEY(id_user) REFERENCES users(id_user)
)ENGINE=InnoDb;

CREATE TABLE saldo(
    id_saldo INT(6) auto_increment NOT NULL,
    id_fondo INT(6) NULL,
    id_cobro INT(6) NULL,
    id_gasto INT(6) NULL,
    id_devolucion INT(6) NULL,
    saldo_actual INT(10) NOT NULL,
    CONSTRAINT pk_saldo PRIMARY KEY(id_saldo),
    CONSTRAINT fk_saldo_fondo FOREIGN KEY(id_fondo) REFERENCES fondo(id_fondo),
    CONSTRAINT fk_saldo_cobro FOREIGN KEY(id_cobro) REFERENCES cobro(id_cobro),
    CONSTRAINT fk_saldo_gastos FOREIGN KEY(id_gasto) REFERENCES gastos(id_gasto),
    CONSTRAINT fk_saldo_devoluciones FOREIGN KEY(id_devolucion) REFERENCES devoluciones(id_devolucion),
)ENGINE=InnoDb;
