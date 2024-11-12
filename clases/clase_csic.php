<?php
class Csic
{


    private $password;
    private $password2;
    private $nombre;
    private $apellido;
    private $email;
    private $telefono;
    private $direccion;
    private $codigo_postal;
    private $provincia;
    private $uid;
    private $nueva_unidad_nombre;
    private $id;
    private $unidad;
    private $unidad_id;
    private $accion;
    private $activo;
    private $rol;
    private $token;
    private $sala_id;

    public function __construct($data = array())
    {
        foreach ($data as $key => $value) {
            $this->$key = stripslashes(strip_tags($value));
        }
    }

    public function storeFormValues($params)
    {
        $this->__construct($params);
    }

    public function resetea_password()
    {
        try {
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = "UPDATE usuarios SET usuario_password = :password WHERE  usuario_hash = :uid";
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':uid', $this->uid);
            $stmt->execute();
            $rowCount = $stmt->rowCount();
            return $rowCount;
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
    public function chequear_usuario()
    {
        try {
            $ahora = time();
            $nuevo_hash = password_hash($ahora, PASSWORD_DEFAULT);
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare("UPDATE usuarios SET usuario_hash = :nuevo_hash WHERE usuario_password  = :uid ");
            $stmt->bindParam(":uid", $this->uid);
            $stmt->bindParam(":nuevo_hash", $nuevo_hash);
            $stmt->execute();
            return $nuevo_hash;
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
    public function registra_usuario()
    {
        if(trim($this->nombre) === ''){ return -1; }
        if(trim($this->email) === ''){ return -2; }
        if(trim($this->password) === ''){ return -3; }
        if($this->password !== $this->password2){ return -4; }

        try {
            $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = "INSERT IGNORE INTO usuarios (usuario_nombre, usuario_email, usuario_telefono, usuario_provincia, usuario_password) VALUES (:nombre, :email, :telefono, :provincia, :password)";

            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':nombre', $this->nombre);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':telefono', $this->telefono);
            $stmt->bindParam(':provincia', $this->provincia);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();
            $rowCount = $con->lastInsertId();


            $_SESSION["usuario_id"] = $rowCount;
            $_SESSION["usuario_nombre"] = $this->nombre;

            return (int)$rowCount;
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }

    public function resetear_usuario()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare("SELECT usuario_password FROM usuarios WHERE usuario_email  = :email ");
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_OBJ);

            if ($row) {
                return $row->usuario_password;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
    public function login_usuario()
    {
        try {
            // Connect to the database
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare("SELECT * FROM usuarios WHERE email = :email");
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            if ($row && password_verify($this->password, $row->password)) {
                $_SESSION["logueado"] = 1;
                $_SESSION["id"] = $row->id;
                $_SESSION["nombre"] = $row->nombre;
                $_SESSION["rol"] = $row->rol;
                $_SESSION["email"] = $row->email;
                $_SESSION["activo"] = $row->activo;
                $_SESSION["unidad"] = $row->unidad;
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            //die("Database error: " . $e->getMessage());
            return 0;
        }
    }


    public function  g($email, $password, $nombre, $apellido, $activo = 1, $rol)
    {
        try {
            // Connect to the database
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Hash the password using password_hash()
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepare the SQL statement
            $stmt = $con->prepare("INSERT INTO usuarios (email, password, nombre, apellido, activo, rol, unidad) VALUES (:email, :password, :nombre, :apellido, :activo, :rol,1)");
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashed_password); // Save the hashed password, not the plain text
            $stmt->bindParam(":nombre", $nombre);
            $stmt->bindParam(":apellido", $apellido);
            $stmt->bindParam(":activo", $activo);
            $stmt->bindParam(":rol", $rol);

            // Execute the query
            $stmt->execute();

            return true; // User created successfully
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return false; // Failed to create user
        }
    }



    public function do_this($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            echo $e->getMessage();
            //  echo "doThis error";
            return 0;
        }
    }

    public function get_this_1($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "getThis1 function error";
            return 0;
        }
    }

    public function get_this_all($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $valid = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //echo $sql;
            return 0;
        }
    }

    public function insert_return_last_id($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return $con->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 0;
        }
    }

    public function graba_nueva_unidad()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare("INSERT INTO unidades SET nombre = :nombre");
            $stmt->bindParam(":nombre", $this->nueva_unidad_nombre);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            //die("Database error: " . $e->getMessage());
            return 0;
        }
    }

    public function edita_unidad()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare("UPDATE unidades SET nombre = :nombre WHERE id = :id");
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":id", $this->id,PDO::PARAM_INT);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            //die("Database error: " . $e->getMessage());
            return 0;
        }
    }

    public function elimina_unidad()
    {
        $sql = "DELETE FROM unidades WHERE id = $this->unidad";
        self::do_this($sql);

        $sql = "DELETE FROM usuarios WHERE unidad = $this->unidad";
        self::do_this($sql);

        $sql = "DELETE FROM salas WHERE unidad_id = $this->unidad";
        self::do_this($sql);

        $sql = "DELETE FROM reservas WHERE unidad = $this->unidad";
        self::do_this($sql);

        $sql = "DELETE FROM edificio WHERE unidad = $this->unidad";
        self::do_this($sql);

        return 1;
    }

    public function traer_unidades()
    {
        $sql = "SELECT * FROM unidades WHERE 1";
        return self::get_this_all($sql);
    }

    public function traer_edificios()
    {
        $sql = "SELECT * FROM edificio WHERE 1";
        return self::get_this_all($sql);
    }


    public function generateToken($userId) {
        return bin2hex(random_bytes(16)) . '-' . $userId;
    }



    public function nuevo_administrador()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $con->prepare("INSERT INTO usuarios (email, nombre, apellido, activo, rol, unidad) VALUES (:email, :nombre, :apellido, 0, 2, :unidad)");
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":apellido", $this->apellido);
            $stmt->bindParam(":unidad", $this->unidad);
            $stmt->execute();
            $nuevo_admin = $con->lastInsertId();
            $token = self::generateToken($nuevo_admin);
            $sql = "UPDATE usuarios SET activation_token = '$token' WHERE id = $nuevo_admin";
            self::do_this($sql);
            return $token;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return false;
        }
    }

    public function activar_usuario()
    {
        $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE activation_token = :token");
        $stmt->bindParam(":token", $this->token);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);
        if ($user) {

            return $user->id;
        } else {
            return false;
        }
    }

    public function graba_nuevo_edificio()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare("INSERT INTO edificio SET nombre = :nombre, direccion = :direccion, codigo_postal = :codigo_postal, unidad = :unidad");
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":direccion", $this->direccion);
            $stmt->bindParam(":codigo_postal", $this->codigo_postal);
            $stmt->bindParam(":unidad", $this->unidad_id,PDO::PARAM_INT);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            //die("Database error: " . $e->getMessage());
            return 0;
        }
    }

    public function edita_edificio()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare("UPDATE edificio SET nombre = :nombre, direccion = :direccion, codigo_postal = :codigo_postal, unidad = :unidad WHERE id = :id");
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":direccion", $this->direccion);
            $stmt->bindParam(":codigo_postal", $this->codigo_postal);
            $stmt->bindParam(":unidad", $this->unidad_id,PDO::PARAM_INT);
            $stmt->bindParam(":id", $this->id,PDO::PARAM_INT);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            //die("Database error: " . $e->getMessage());
            return 0;
        }
    }

    public function elimina_edificio()
    {
        $sql = "DELETE FROM edificio WHERE id = $this->id";
        self::do_this($sql);

        $sql = "DELETE FROM salas WHERE edificio_id = $this->id";
        self::do_this($sql);

        $sql = "DELETE FROM reservas WHERE edificio_id = $this->id";
        self::do_this($sql);

    }

    public function traer_roles()
    {
        $sql = "SELECT * FROM roles WHERE id != 1";
        return self::get_this_all($sql);
    }

    public function editar_usuario()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $con->prepare("UPDATE usuarios SET email = :email,  nombre = :nombre, apellido = :apellido, activo = :activo, rol = :rol, unidad = :unidad WHERE id = :id");
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":apellido", $this->apellido);
            $stmt->bindParam(":activo", $this->activo);
            $stmt->bindParam(":rol", $this->rol);
            $stmt->bindParam(":unidad", $this->unidad);
            $stmt->bindParam(":id", $this->id);
            $stmt->execute();

            return 1;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return false;
        }
    }

    public function nuevo_usuario()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $con->prepare("INSERT INTO usuarios (email, nombre, apellido, activo, rol, unidad) VALUES (:email, :nombre, :apellido, 0, :rol, :unidad)");
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":nombre", $this->nombre);
            $stmt->bindParam(":apellido", $this->apellido);
            $stmt->bindParam(":unidad", $this->unidad);
            $stmt->bindParam(":rol", $this->rol);
            $stmt->execute();
            $nuevo_admin = $con->lastInsertId();
            $token = self::generateToken($nuevo_admin);
            $sql = "UPDATE usuarios SET activation_token = '$token' WHERE id = $nuevo_admin";
            self::do_this($sql);
            return $token;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            return false;
        }
    }


    public function traer_sala_detalle()
    {
        $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
        $stmt = $pdo->prepare("SELECT * FROM salas WHERE id = :sala_id");
        $stmt->bindParam(":sala_id", $this->sala_id);
        $stmt->execute();
        $sala = $stmt->fetch(PDO::FETCH_OBJ);
        if ($sala) {
            return $sala;
        } else {
            return false;
        }
    }
}

