
--Creamos ususario
CREATE USER 
'Ureserva_pistas'@'localhost' 
IDENTIFIED  BY 'Ureserva_pistas2$';
GRANT USAGE ON *.* TO 'Ureserva_pistas'@'localhost';
ALTER USER 'Ureserva_pistas'@'localhost' 
REQUIRE NONE
WITH MAX_QUERIES_PER_HOUR 0 
MAX_CONNECTIONS_PER_HOUR 0 
MAX_UPDATES_PER_HOUR 0 
MAX_USER_CONNECTIONS 0;
GRANT ALL PRIVILEGES ON reserva_pistas.* 
TO 'Ureserva_pistas'@'localhost';
FLUSH PRIVILEGES;
