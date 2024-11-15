<?php
session_start();
include("config/config.php");
include("clases/clase_csic.php");
$csic = new Csic();





// Initialize an array to store error messages
$errors = array();

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Validate CSRF Token
    if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors[] = 'Solicitud inválida. Por favor, intente nuevamente.';
    } else {
        // Unset the CSRF token to prevent reuse
        unset($_SESSION['csrf_token']);

        // Proceed with form validation and sanitization

        // Sanitize and validate 'nombre'
        if (empty($_POST['nombre'])) {
            $errors[] = 'El nombre es requerido.';
        } else {
            $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        }

        // Sanitize and validate 'apellidos'
        if (empty($_POST['apellidos'])) {
            $errors[] = 'Los apellidos son requeridos.';
        } else {
            $apellidos = filter_input(INPUT_POST, 'apellidos', FILTER_SANITIZE_STRING);
        }

        // Sanitize and validate 'dni'
        if (empty($_POST['dni'])) {
            $errors[] = 'El DNI es requerido.';
        } else {
            $dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_STRING);
            // Add DNI format validation if necessary
        }

        // Sanitize and validate 'email'
        if (empty($_POST['email'])) {
            $errors[] = 'El correo electrónico es requerido.';
        } else {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'El correo electrónico no es válido.';
            }
        }

        // Sanitize and validate 'celular'
        if (empty($_POST['celular'])) {
            $errors[] = 'El teléfono móvil es requerido.';
        } else {
            $celular = filter_input(INPUT_POST, 'celular', FILTER_SANITIZE_STRING);
            // Add phone number format validation if necessary
        }

        // Validate 'password' and 'password2'
        if (empty($_POST['password']) || empty($_POST['password2'])) {
            $errors[] = 'Ambos campos de contraseña son requeridos.';
        } else {
            $password = $_POST['password'];
            $password2 = $_POST['password2'];

            if ($password !== $password2) {
                $errors[] = 'Las contraseñas no coinciden.';
            } elseif (strlen($password) < 6) {
                $errors[] = 'La contraseña debe tener al menos 6 caracteres.';
            }
            // No need to sanitize passwords as they will be hashed
        }

        // Validate 'usuario_csic'
        if (!isset($_POST['usuario_csic'])) {
            $errors[] = 'Debe indicar si es parte del CSIC.';
        } else {
            $usuario_csic = $_POST['usuario_csic'];
            if ($usuario_csic !== '1' && $usuario_csic !== '0') {
                $errors[] = 'Valor no válido para el campo CSIC.';
            }
        }

        // Initialize optional fields
        $departamento = $unidad = $servicio = $seccion = $direccion_edificio = $planta = $numero_despacho = $codigo_postal_trabajo = $telefono_fijo = null;

        // If 'usuario_csic' is '1', validate additional fields
        if ($usuario_csic === '1') {
            // Sanitize and validate 'departamento'
            if (empty($_POST['departamento'])) {
                $errors[] = 'El departamento es requerido.';
            } else {
                $departamento = filter_input(INPUT_POST, 'departamento', FILTER_SANITIZE_STRING);
            }

            // Sanitize and validate 'unidad'
            if (empty($_POST['unidad'])) {
                $errors[] = 'La unidad es requerida.';
            } else {
                $unidad = filter_input(INPUT_POST, 'unidad', FILTER_SANITIZE_STRING);
            }

            // Sanitize and validate 'servicio'
            if (empty($_POST['servicio'])) {
                $errors[] = 'El servicio es requerido.';
            } else {
                $servicio = filter_input(INPUT_POST, 'servicio', FILTER_SANITIZE_STRING);
            }

            // Sanitize and validate 'seccion'
            if (empty($_POST['seccion'])) {
                $errors[] = 'La sección es requerida.';
            } else {
                $seccion = filter_input(INPUT_POST, 'seccion', FILTER_SANITIZE_STRING);
            }

            // Sanitize 'direccion_edificio'
            if (empty($_POST['direccion_edificio'])) {
                $errors[] = 'La dirección del edificio es requerida.';
            } else {
                $direccion_edificio = filter_input(INPUT_POST, 'direccion_edificio', FILTER_SANITIZE_STRING);
            }

            // Sanitize 'planta'
            if (empty($_POST['planta'])) {
                $errors[] = 'La planta es requerida.';
            } else {
                $planta = filter_input(INPUT_POST, 'planta', FILTER_SANITIZE_STRING);
            }

            // Sanitize 'numero_despacho'
            if (empty($_POST['numero_despacho'])) {
                $errors[] = 'El número del despacho es requerido.';
            } else {
                $numero_despacho = filter_input(INPUT_POST, 'numero_despacho', FILTER_SANITIZE_STRING);
            }

            // Sanitize and validate 'codigo_postal_trabajo'
            if (empty($_POST['codigo_postal_trabajo'])) {
                $errors[] = 'El código postal es requerido.';
            } else {
                $codigo_postal_trabajo = filter_input(INPUT_POST, 'codigo_postal_trabajo', FILTER_SANITIZE_STRING);
                if (!preg_match('/^\d{5}$/', $codigo_postal_trabajo)) {
                    $errors[] = 'El código postal debe tener 5 dígitos.';
                }
            }

            // Sanitize 'telefono_fijo'
            if (empty($_POST['telefono_fijo'])) {
                $errors[] = 'El teléfono fijo es requerido.';
            } else {
                $telefono_fijo = filter_input(INPUT_POST, 'telefono_fijo', FILTER_SANITIZE_STRING);
                // Add phone number format validation if necessary
            }
        }

        // If there are no errors, proceed to process the data
        if (empty($errors)) {
            // Hash the password securely
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            try {
                // Establish database connection (replace with your own credentials)
                $pdo = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Prepare the SQL statement
                $stmt = $pdo->prepare('INSERT INTO reservantes (nombre, apellidos, dni, email, celular, password, usuario_csic, departamento, unidad, servicio, seccion, direccion_edificio, planta, numero_despacho, codigo_postal_trabajo, telefono_fijo, activo) VALUES (:nombre, :apellidos, :dni, :email, :celular, :password, :usuario_csic, :departamento, :unidad, :servicio, :seccion, :direccion_edificio, :planta, :numero_despacho, :codigo_postal_trabajo, :telefono_fijo, :activo)');

                // Bind parameters
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':apellidos', $apellidos);
                $stmt->bindParam(':dni', $dni);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':celular', $celular);
                $stmt->bindParam(':password', $password_hash);
                $stmt->bindParam(':usuario_csic', $usuario_csic, PDO::PARAM_BOOL);
                $stmt->bindParam(':departamento', $departamento);
                $stmt->bindParam(':unidad', $unidad);
                $stmt->bindParam(':servicio', $servicio);
                $stmt->bindParam(':seccion', $seccion);
                $stmt->bindParam(':direccion_edificio', $direccion_edificio);
                $stmt->bindParam(':planta', $planta);
                $stmt->bindParam(':numero_despacho', $numero_despacho);
                $stmt->bindParam(':codigo_postal_trabajo', $codigo_postal_trabajo);
                $stmt->bindParam(':telefono_fijo', $telefono_fijo);
                $stmt->bindValue(':activo', false, PDO::PARAM_BOOL); // Default to false

                // Execute the statement
                $stmt->execute();

                // Registration successful
                echo 'Registro exitoso.';

            } catch (PDOException $e) {
                // Handle database errors
                if ($e->getCode() == 23000) {
                    // Duplicate entry error code
                    $errors[] = 'El correo electrónico ya está registrado.';
                } else {
                    $errors[] = 'Error en la base de datos: ' . $e->getMessage();
                }
            }

        }

        // If there are errors, display them
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo '<p style="color:red;">' . htmlspecialchars($error) . '</p>';
            }
        }

    }

} else {
    // If the form wasn't submitted via POST, redirect or show an error
    header('Location: index.php');
    exit();
}

