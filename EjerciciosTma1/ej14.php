<?php
/**
 * Ejercicio 14: Emulación de un SGBD Relacional con Arrays Asociativos en PHP
 * 
 * Estructura de $bd según sugerencia:
 * $bd = [
 *     "departamento" => [
 *         10 => ["nombre" => "ventas", "desc" => "Dpto. de ventas"]
 *     ],
 *     "empleado" => [
 *         100 => ["nombre" => "pepe", "apellido" => "sánchez", "idDpto" => 10],
 *         200 => ["nombre" => "ana", "apellido" => "garcía", "idDpto" => 10]
 *     ]
 * ];
 * 
 * Implementa un CRUD completo por menú:
 * - Create
 * - Read (2 facetas: mostrar todos los objetos [empleados muestra nombre de dpto] y recuperar por ID)
 * - Update
 * - Delete
 */

// Estructura de la base de datos emulada
$bd = [
    "departamento" => [
        10 => [
            "nombre" => "ventas",
            "desc"   => "Dpto. de ventas"
        ]
    ],
    "empleado" => [
        100 => [
            "nombre"   => "pepe",
            "apellido" => "sánchez",
            "idDpto"   => 10
        ],
        200 => [
            "nombre"   => "ana",
            "apellido" => "garcía",
            "idDpto"   => 10
        ]
    ]
];

// Función auxiliar para lectura de datos por consola
function leer(string $mensaje): string {
    echo $mensaje;
    $linea = fgets(STDIN);
    if ($linea === false) {
        exit(0);
    }
    return trim($linea);
}

// ==========================================
// CRUD: DEPARTAMENTO
// ==========================================

function crearDepartamento(array &$bd): void {
    echo "\n--- CREAR DEPARTAMENTO ---\n";
    $id = (int)leer("Introduce el ID del departamento: ");

    if (isset($bd["departamento"][$id])) {
        echo "[ERROR] Ya existe un departamento con el ID $id.\n";
        return;
    }

    $nombre = leer("Introduce el nombre: ");
    if (empty($nombre)) {
        echo "[ERROR] El nombre no puede estar vacío.\n";
        return;
    }

    $desc = leer("Introduce la descripción (desc): ");

    $bd["departamento"][$id] = [
        "nombre" => $nombre,
        "desc"   => $desc
    ];

    echo "[ÉXITO] Departamento '$nombre' registrado con ID $id.\n";
}

function mostrarDepartamentos(array $bd): void {
    echo "\n--- LISTADO DE DEPARTAMENTOS ---\n";
    if (empty($bd["departamento"])) {
        echo "No hay departamentos registrados.\n";
        return;
    }

    printf("%-6s | %-20s | %-35s\n", "ID", "NOMBRE", "DESC");
    echo str_repeat("-", 67) . "\n";
    foreach ($bd["departamento"] as $id => $dpto) {
        printf("%-6d | %-20s | %-35s\n", $id, $dpto["nombre"], $dpto["desc"]);
    }
}

function buscarDepartamentoPorId(array $bd): void {
    echo "\n--- RECUPERAR DEPARTAMENTO POR ID ---\n";
    $id = (int)leer("Introduce el ID del departamento: ");

    if (isset($bd["departamento"][$id])) {
        $d = $bd["departamento"][$id];
        echo "-> ID: " . $id . "\n";
        echo "-> Nombre: " . $d["nombre"] . "\n";
        echo "-> Descripción (desc): " . $d["desc"] . "\n";
    } else {
        echo "[AVISO] No se encontró ningún departamento con el ID $id.\n";
    }
}

function modificarDepartamento(array &$bd): void {
    echo "\n--- MODIFICAR DEPARTAMENTO ---\n";
    $id = (int)leer("Introduce el ID del departamento a modificar: ");

    if (!isset($bd["departamento"][$id])) {
        echo "[ERROR] No existe el departamento con ID $id.\n";
        return;
    }

    $actual = $bd["departamento"][$id];
    echo "Deje el campo en blanco si desea conservar el valor actual.\n";

    $nuevoNombre = leer("Nombre actual [{$actual['nombre']}]: ");
    if (!empty($nuevoNombre)) {
        $bd["departamento"][$id]["nombre"] = $nuevoNombre;
    }

    $nuevaDesc = leer("Descripción actual [{$actual['desc']}]: ");
    if (!empty($nuevaDesc)) {
        $bd["departamento"][$id]["desc"] = $nuevaDesc;
    }

    echo "[ÉXITO] Departamento ID $id modificado correctamente.\n";
}

function eliminarDepartamento(array &$bd): void {
    echo "\n--- ELIMINAR DEPARTAMENTO ---\n";
    $id = (int)leer("Introduce el ID del departamento a eliminar: ");

    if (!isset($bd["departamento"][$id])) {
        echo "[ERROR] No existe el departamento con ID $id.\n";
        return;
    }

    // Control de integridad referencial: comprobar si algún empleado usa este idDpto
    $empleadosAsociados = [];
    foreach ($bd["empleado"] as $idEmp => $emp) {
        if ($emp["idDpto"] === $id) {
            $empleadosAsociados[] = "[ID $idEmp] " . $emp["nombre"] . " " . $emp["apellido"];
        }
    }

    if (!empty($empleadosAsociados)) {
        echo "[RESTRICCIÓN DE INTEGRIDAD] No se puede eliminar el departamento con ID $id porque tiene " .
             count($empleadosAsociados) . " empleado(s) asociado(s):\n";
        foreach ($empleadosAsociados as $empInfo) {
            echo " - $empInfo\n";
        }
        echo "Reasigne o elimine primero los empleados correspondientes.\n";
        return;
    }

    $nombre = $bd["departamento"][$id]["nombre"];
    unset($bd["departamento"][$id]);
    echo "[ÉXITO] Departamento '$nombre' (ID: $id) eliminado.\n";
}

// ==========================================
// CRUD: EMPLEADO
// ==========================================

function crearEmpleado(array &$bd): void {
    echo "\n--- CREAR EMPLEADO ---\n";
    $id = (int)leer("Introduce el ID del empleado: ");

    if (isset($bd["empleado"][$id])) {
        echo "[ERROR] Ya existe un empleado con el ID $id.\n";
        return;
    }

    $nombre = leer("Introduce el nombre: ");
    $apellido = leer("Introduce el apellido: ");

    // Validar clave foránea idDpto
    echo "Departamentos disponibles:\n";
    foreach ($bd["departamento"] as $idDpto => $d) {
        echo "  [ID $idDpto] {$d['nombre']}\n";
    }

    $idDpto = (int)leer("Introduce el idDpto del empleado: ");
    if (!isset($bd["departamento"][$idDpto])) {
        echo "[ERROR] El departamento con ID $idDpto no existe. Operación cancelada.\n";
        return;
    }

    $bd["empleado"][$id] = [
        "nombre"   => $nombre,
        "apellido" => $apellido,
        "idDpto"   => $idDpto
    ];

    echo "[ÉXITO] Empleado '$nombre $apellido' registrado con ID $id (Departamento: {$bd['departamento'][$idDpto]['nombre']}).\n";
}

function mostrarEmpleados(array $bd): void {
    echo "\n--- LISTADO DE EMPLEADOS ---\n";
    if (empty($bd["empleado"])) {
        echo "No hay empleados registrados.\n";
        return;
    }

    // Requisito: En lugar de idDpto, mostrar el nombre del departamento
    printf("%-6s | %-15s | %-20s | %-25s\n", "ID", "NOMBRE", "APELLIDO", "DEPARTAMENTO");
    echo str_repeat("-", 73) . "\n";

    foreach ($bd["empleado"] as $id => $emp) {
        $idDpto = $emp["idDpto"];
        $nombreDpto = isset($bd["departamento"][$idDpto]) 
            ? $bd["departamento"][$idDpto]["nombre"] 
            : "Desconocido (idDpto: $idDpto)";

        printf("%-6d | %-15s | %-20s | %-25s\n", $id, $emp["nombre"], $emp["apellido"], $nombreDpto);
    }
}

function buscarEmpleadoPorId(array $bd): void {
    echo "\n--- RECUPERAR EMPLEADO POR ID ---\n";
    $id = (int)leer("Introduce el ID del empleado: ");

    if (isset($bd["empleado"][$id])) {
        $emp = $bd["empleado"][$id];
        $idDpto = $emp["idDpto"];
        $nombreDpto = isset($bd["departamento"][$idDpto]) 
            ? $bd["departamento"][$idDpto]["nombre"] 
            : "Desconocido (idDpto: $idDpto)";

        echo "-> ID: " . $id . "\n";
        echo "-> Nombre: " . $emp["nombre"] . "\n";
        echo "-> Apellido: " . $emp["apellido"] . "\n";
        echo "-> idDpto: " . $idDpto . " (" . $nombreDpto . ")\n";
    } else {
        echo "[AVISO] No se encontró ningún empleado con el ID $id.\n";
    }
}

function modificarEmpleado(array &$bd): void {
    echo "\n--- MODIFICAR EMPLEADO ---\n";
    $id = (int)leer("Introduce el ID del empleado a modificar: ");

    if (!isset($bd["empleado"][$id])) {
        echo "[ERROR] No existe el empleado con ID $id.\n";
        return;
    }

    $actual = $bd["empleado"][$id];
    echo "Deje el campo en blanco si desea conservar el valor actual.\n";

    $nuevoNombre = leer("Nombre actual [{$actual['nombre']}]: ");
    if (!empty($nuevoNombre)) {
        $bd["empleado"][$id]["nombre"] = $nuevoNombre;
    }

    $nuevoApellido = leer("Apellido actual [{$actual['apellido']}]: ");
    if (!empty($nuevoApellido)) {
        $bd["empleado"][$id]["apellido"] = $nuevoApellido;
    }

    $dptoActualNombre = isset($bd["departamento"][$actual["idDpto"]])
        ? $bd["departamento"][$actual["idDpto"]]["nombre"]
        : "ID: " . $actual["idDpto"];

    echo "Departamentos disponibles:\n";
    foreach ($bd["departamento"] as $idDpto => $d) {
        echo "  [ID $idDpto] {$d['nombre']}\n";
    }

    $nuevoIdDpto = leer("idDpto actual [{$actual['idDpto']} - $dptoActualNombre]: ");
    if (!empty($nuevoIdDpto)) {
        $idDptoInt = (int)$nuevoIdDpto;
        if (!isset($bd["departamento"][$idDptoInt])) {
            echo "[ERROR] El departamento $idDptoInt no existe. Se conserva el anterior.\n";
        } else {
            $bd["empleado"][$id]["idDpto"] = $idDptoInt;
        }
    }

    echo "[ÉXITO] Empleado ID $id modificado correctamente.\n";
}

function eliminarEmpleado(array &$bd): void {
    echo "\n--- ELIMINAR EMPLEADO ---\n";
    $id = (int)leer("Introduce el ID del empleado a eliminar: ");

    if (!isset($bd["empleado"][$id])) {
        echo "[ERROR] No existe el empleado con ID $id.\n";
        return;
    }

    $nombreCompleto = $bd["empleado"][$id]["nombre"] . " " . $bd["empleado"][$id]["apellido"];
    unset($bd["empleado"][$id]);
    echo "[ÉXITO] Empleado '$nombreCompleto' (ID: $id) eliminado.\n";
}

// ==========================================
// SUBMENÚS Y MENÚ PRINCIPAL
// ==========================================

function menuDepartamentos(array &$bd): void {
    do {
        echo "\n=====================================\n";
        echo "      GESTIÓN DE DEPARTAMENTOS       \n";
        echo "=====================================\n";
        echo "1. Crear departamento (C)\n";
        echo "2. Mostrar todos los departamentos (R - Todos)\n";
        echo "3. Recuperar departamento por ID (R - Por ID)\n";
        echo "4. Modificar departamento (U)\n";
        echo "5. Eliminar departamento (D)\n";
        echo "0. Volver al Menú Principal\n";
        echo "-------------------------------------\n";
        $opcion = leer("Seleccione una opción: ");

        switch ($opcion) {
            case "1":
                crearDepartamento($bd);
                break;
            case "2":
                mostrarDepartamentos($bd);
                break;
            case "3":
                buscarDepartamentoPorId($bd);
                break;
            case "4":
                modificarDepartamento($bd);
                break;
            case "5":
                eliminarDepartamento($bd);
                break;
            case "0":
                break;
            default:
                echo "[AVISO] Opción inválida. Intente de nuevo.\n";
        }
    } while ($opcion !== "0");
}

function menuEmpleados(array &$bd): void {
    do {
        echo "\n=====================================\n";
        echo "        GESTIÓN DE EMPLEADOS         \n";
        echo "=====================================\n";
        echo "1. Crear empleado (C)\n";
        echo "2. Mostrar todos los empleados (R - Nombre Dpto)\n";
        echo "3. Recuperar empleado por ID (R - Por ID)\n";
        echo "4. Modificar empleado (U)\n";
        echo "5. Eliminar empleado (D)\n";
        echo "0. Volver al Menú Principal\n";
        echo "-------------------------------------\n";
        $opcion = leer("Seleccione una opción: ");

        switch ($opcion) {
            case "1":
                crearEmpleado($bd);
                break;
            case "2":
                mostrarEmpleados($bd);
                break;
            case "3":
                buscarEmpleadoPorId($bd);
                break;
            case "4":
                modificarEmpleado($bd);
                break;
            case "5":
                eliminarEmpleado($bd);
                break;
            case "0":
                break;
            default:
                echo "[AVISO] Opción inválida. Intente de nuevo.\n";
        }
    } while ($opcion !== "0");
}

// Bucle principal de la aplicación
do {
    echo "\n==========================================\n";
    echo "   SISTEMA GESTOR DE BD (EMULADOR EN PHP) \n";
    echo "==========================================\n";
    echo "1. Gestión de Departamentos\n";
    echo "2. Gestión de Empleados\n";
    echo "0. Salir\n";
    echo "------------------------------------------\n";
    $opcionPrincipal = leer("Seleccione una opción: ");

    switch ($opcionPrincipal) {
        case "1":
            menuDepartamentos($bd);
            break;
        case "2":
            menuEmpleados($bd);
            break;
        case "0":
            echo "\n¡Hasta luego!\n";
            break;
        default:
            echo "[AVISO] Opción inválida. Por favor, seleccione 1, 2 o 0.\n";
    }
} while ($opcionPrincipal !== "0");
?>
