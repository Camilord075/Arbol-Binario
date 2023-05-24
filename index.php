<?php
    include("./arbol/Arbol.php");
    
    session_start();
    
    if (isset($_SESSION["arbol"]) == false) {
        $_SESSION["arbol"] = new Arbol();
    }
    
    $raiz = null;
    $contenido = "";
    
    $txtAccion = (isset($_POST["accion"]))?$_POST["accion"]:"";
    
    if ($_POST) {
        switch ($txtAccion) {
            case "Crear":
                if ($_SESSION["arbol"]->estaVacio()) {
                    if (isset($_POST["dato-raiz"])){
                        if ($_POST["dato-raiz"] == "0") {    
                            $_SESSION["arbol"]->setRaiz($_POST["dato-raiz"]);
                        } else {
                            $_SESSION["arbol"]->setRaiz(intval($_POST["dato-raiz"]));
                        }
                        $contenido = "swal({
                            title: 'Crear Árbol',
                            text: 'Se ha creado el árbol correctamente',
                            icon: 'success',
                        })";
                    }
                }
                break;

            case "Agregar":
                if ($_POST["valor-hoja"] == "0") {
                    $txtHoja = (isset($_POST["valor-hoja"]))?$_POST["valor-hoja"]:"";
                } else {
                    $txtHoja = (isset($_POST["valor-hoja"]))?intval($_POST["valor-hoja"]):"";
                }
                
                if ($txtHoja != "") {
                    if ($_SESSION["arbol"]->agregarHijo($txtHoja)) {
                        $contenido = "swal({
                            title: 'Agregar Hoja',
                            text: 'Se ha agregado una hoja correctamente',
                            icon: 'success',
                        })";
                    }
                }
                break;
                
            case "Eliminar":
                $txtHojaEliminar = (isset($_POST["valor-hoja-eliminar"]))?$_POST["valor-hoja-eliminar"]:"";
                
                if ($txtHojaEliminar != "") {
                    if ($_SESSION["arbol"]->eliminarNodo($txtHojaEliminar)) {
                        $contenido = "swal({
                            title: 'Eliminar Hoja',
                            text: 'Se ha eliminado una hoja correctamente',
                            icon: 'success',
                        })";
                    } else {
                        $contenido = "swal({
                            title: 'Eliminar Hoja',
                            text: 'El nodo por borrar no existe o no es hoja, no se pudo eliminar',
                            icon: 'error',
                        })";
                    }
                }
                
                break;
                
            case "Mostrar":
                $contenido = "swal({
                    title: 'Ver Hojas',
                    text: 'Se están mostrando las hojas, ver en el visor',
                    icon: 'success',
                })";
            
            default:
                break;
        }
    }
    
    $raiz = $_SESSION["arbol"]->getRaiz();
    echo '<br>';
?>
<!DOCTYPE html>
<html lang="es-CO">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arbol</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <script src="./node_modules/vis/dist/vis.js"></script>
    <link rel="stylesheet" href="./node_modules/vis/dist/vis.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body class="bg-primary">
    <div class="container bg-primary">
        <br>
        <div class="row" style="text-align: center">
            <div class="col-md-12" style="background-image: url('./imagenes/arboles-a-contra-luz-del-sol_1920x1080_xtrafondos.com.jpg'); background-repeat: no-repeat; background-attachment: fixed; border-radius: 7px">
                <br><br>
                <h1 class="h1" style="color: white; background-color: rgba(0,0,0,0.5); border-radius: 7px">Proyecto Árbol de Búsqueda Binaria</h1>
                <br><br>
            </div>
        </div>
        <br>
    </div>
    <nav class="navbar navbar-expand navbar-dark bg-dark justify-content-center">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link" href="#agregar">Agregar</a>
            <a class="nav-item nav-link" href="#eliminar">Eliminar</a>
            <a class="nav-item nav-link" href="#conteos">Conteos</a>
            <a class="nav-item nav-link" href="#recorridos">Recorridos</a>
            <a class="nav-item nav-link" href="#completo">Completo</a>
            <a class="nav-item nav-link" href="#hojas">Hojas</a>
            <a class="nav-item nav-link" href="#arbol">Mostrar</a>
        </div>
    </nav>
    <br>
    <div class="container bg-light" id="arbol" style="border-radius: 7px">
    </div>
    <script type="text/javascript">
        var nodos = new vis.DataSet([
            <?php
                if ($txtAccion == "Mostrar") {
                    if ($_SESSION["arbol"]->estaVacio()) {
                        echo "";
                    } else {
                        $_SESSION["arbol"]->verNodoHoja($raiz->getInformacion());
                    }
                } else {
                    if ($_SESSION["arbol"]->estaVacio()) {
                        echo "";
                    } else {
                        $_SESSION["arbol"]->verNodo($raiz->getInformacion());
                    }
                }
            ?>
        ]);

        var aristas = new vis.DataSet([
            <?php
                if ($_SESSION["arbol"]->estaVacio()) {
                    echo "";
                } else {
                    $_SESSION["arbol"]->verAristas($raiz->getInformacion());
                }
            ?>
        ]);
        
        var pantalla = document.getElementById("arbol");

        var datos = {
            nodes: nodos,
            edges: aristas
        };

        var opciones = {
            layout: {
                hierarchical: {
                    direction: "UD",
                    sortMethod: "directed",
                },
            },
            nodes: {
                borderWidth: 0		
            },
            edges: {
                arrows: "to"
            },
        }

        var network = new vis.Network(pantalla, datos, opciones);
    </script>
    <br>
    <div class="container bg-light" id="conteos" style="border-radius: 7px">
    <br>
        <div class="row">
            <div class="col-md-3">
                <div class="h-100">
                    <br><br>
                    <h1 style="text-align: center">Conteos y Altura</h1>
                    <br><br>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Conteo de Nodos
                    </div>
                    <div class="card-body">
                        <div class="h-100">
                            <br><br>
                            <h1 style="text-align: center"><?php echo ($_SESSION["arbol"]->estaVacio())?0:$_SESSION["arbol"]->contar($raiz->getInformacion()); ?></h1>
                            <br><br>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Conteo de Nodos Pares
                    </div>
                    <div class="card-body">
                        <div class="h-100">
                            <br><br>
                            <h1 style="text-align: center"><?php echo ($_SESSION["arbol"]->estaVacio())?0:$_SESSION["arbol"]->contarPares($raiz->getInformacion()); ?></h1>
                            <br><br>
                        </div>
                    </div>
                </div>
                <br>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Altura del Arbol
                    </div>
                    <div class="card-body">
                        <div class="h-100">
                            <br><br>
                            <h1 style="text-align: center"><?php echo ($_SESSION["arbol"]->estaVacio())?0:$_SESSION["arbol"]->alturaArbol($raiz->getInformacion()); ?></h1>
                            <br><br>
                        </div>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    <br>
    <div class="container bg-light" style="border-radius: 7px">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h1 id="agregar" style="text-align: center">Agregar Nodo</h1>
                <br>
                <div class="card">
                    <div class="card-body">
                        <form action="index.php" method="post">
                            <div class="form-group">
                                <label for="valor-hoja">Valor del nodo *</label>
                                <input type="number" class="form-control" name="valor-hoja" id="valor-hoja" placeholder="Ingrese el valor" required>
                            </div>
                            <br>
                            <button type="submit" id="agregar-hoja" name="accion" value="Agregar" class="btn btn-primary">Agregar Nodo</button>
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    <br>
    <div class="container bg-light" style="border-radius: 7px">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h1 id="eliminar" style="text-align: center">Eliminar Nodo</h1>
                <br>
                <div class="card">
                    <div class="card-body">
                        <form action="index.php" method="post">
                            <div class="form-group">
                                <label for="valor-hoja">Valor del Nodo *</label>
                                <input type="number" class="form-control" name="valor-hoja-eliminar" id="valor-hoja-eliminar" placeholder="Ingrese el valor" required <?php echo ($_SESSION["arbol"]->estaVacio())?"readonly":""; ?>>
                            </div>
                            <br>
                            <button type="submit" id="eliminar-hoja" name="accion" value="Eliminar" <?php echo ($_SESSION["arbol"]->estaVacio())?'disabled':''; ?> class="btn btn-primary">Eliminar Nodo</button>
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    <br>
    <div class="container bg-light" style="border-radius: 7px" id="recorridos">
        <div class="row">
            <h1 id=recorridos" style="text-align: center">Recorridos</h1>
            <div class="col-md-12">
                <br>
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        Recorrido PreOrden
                    </div>
                    <div class="card-body">
                        <h1 style="text-align: center">
                            <?php if ($_SESSION["arbol"]->estaVacio()){
                                echo 'No hay recorrido';
                            } else {
                                $_SESSION["arbol"]->recorridoPreOrden($raiz->getInformacion());
                            }
                            ?>
                        </h1>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        Recorrido InOrden
                    </div>
                    <div class="card-body">
                        <h1 style="text-align: center">
                            <?php if ($_SESSION["arbol"]->estaVacio()){
                                echo 'No hay recorrido';
                            } else {
                                $_SESSION["arbol"]->recorridoInOrden($raiz->getInformacion());
                            }
                            ?>
                        </h1>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        Recorrido PostOrden
                    </div>
                    <div class="card-body">
                        <h1 style="text-align: center">
                            <?php if ($_SESSION["arbol"]->estaVacio()){
                                echo 'No hay recorrido';
                            } else {
                                $_SESSION["arbol"]->recorridoPostOrden($raiz->getInformacion());
                            }
                            ?>
                        </h1>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header" style="text-align: center">
                        Recorrido Por Niveles
                    </div>
                    <div class="card-body">
                        <h1 style="text-align: center">
                            <?php if ($_SESSION["arbol"]->estaVacio()){
                                echo 'No hay recorrido';
                            } else {
                                $_SESSION["arbol"]->recorridoPorNiveles($raiz->getInformacion());
                            }
                            ?>
                        </h1>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    <br>
    <div class="container bg-light" style="border-radius: 7px" id="completo">
        <div class="row">
            <h1 style="text-align: center">¿Árbol Completo?</h1>
            <br>
            <h2 style="text-align: center">
                <?php
                    if ($_SESSION["arbol"]->estaVacio()) {
                        echo 'El árbol está vacío';
                    } else {
                        echo ($_SESSION["arbol"]->esCompleto($raiz->getInformacion()))?"El árbol es completo":"El árbol NO es completo";
                    }
                ?>
            </h2>
        </div>
    </div>
    <br>
    <div class="container bg-light" style="border-radius: 7px" id="hojas">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="text-align: center">
                <h1>Ver Hojas</h1>
                <div class="card">
                    <div class="card-body">
                        <br>
                        <form action="index.php" method="post">
                        <button type="submit" id="ver-hojas" name="accion" value="Mostrar" <?php echo ($_SESSION["arbol"]->estaVacio())?'disabled':''; ?> class="btn btn-primary btn-lg">Ver Hojas</button>
                        </form>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
    <br>
    <script type="text/javascript">
        <?php
            echo $contenido;
        ?>
    </script>
</body>
</html>