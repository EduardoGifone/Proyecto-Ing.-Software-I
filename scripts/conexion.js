const mysql = require('mysql')
const Connection = require('mysql/lib/Connection')

const conection = mysql.createConnection({
    host:'localhost',
    user:'root',
    password: '',
    database: 'dbtutorias',
    port: 3307
})

conection.connect( (err) =>{
    if(err) throw err
    console.log('la coneccion funciona')
})

const insertar = "INSERT INTO alumno (codigoAlumno,correoAlumno, contrasenia, nombres, apellidos, semestre, codigoTutor, dniAlumno) VALUES ('182731','182731@unsaac.edu.pe','75674356','Yerson','Chirinos Vilca','2022-I','1545','75674356')"
conection.query(insertar, (err,rows)=>{
    if(err) throw err
})

conection.query('SELECT * FROM alumno', (err,rows) => {
    if(err) throw err
    console.log('los datos de la tabla son estos: ')
    console.log(rows)
    console.log('la cantidad de resultados es: ')
    console.log(rows.length)
    const user1 = rows[0]
    console.log('mostrar el rows[0]: ')
    console.log(user1)
    console.log('Mostrar el atributo nombres: ')
    console.log(user1.nombres)
    console.log(`El usuario se llama ${user1.nombres} y su correo es ${user1.correoAlumno}`)
})

conection.end()