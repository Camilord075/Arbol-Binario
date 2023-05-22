<?php
    include("Nodo.php");
    
    class Arbol {
        private $raiz;

        public function __construct() {
            $this->raiz = null;
        }
        
        public function getRaiz() {
            return $this->raiz;
        }

        public function setRaiz($raiz): void {
            $this->raiz = new Nodo($raiz);
        }
        
        public function estaVacio() {
            return $this->raiz == null;
        }
        
        public function tieneHijos(Nodo $nodo) {
            return $nodo->getNodoDerecha() != null || $nodo->getNodoIzquierda() != null;
        }
        
        public function esHoja (Nodo $nodo) {
            return !($this->tieneHijos($nodo));
        }
        
        public function buscar ($raiz, $valor) {
            if ($raiz == null) {
                return null;
            }
            
            if ($raiz->getInformacion() == $valor) {
                return $raiz;
            }
            
            $derecho = $this->buscar($raiz->getNodoDerecha(), $valor);
            $izquierdo = $this->buscar($raiz->getNodoIzquierda(), $valor);
            
            if ($derecho != null) {
                return $derecho;
            } else {
                return $izquierdo;
            }
        }
        
        public function contar($infoNodo) {
            $nodo = $this->buscar($this->raiz, $infoNodo);
            if ($nodo != null) {
                if ($this->tieneHijos($nodo)) {
                    $nodoDer = ($nodo->getNodoDerecha() != null)?$nodo->getNodoDerecha()->getInformacion():null;
                    $nodoIzq = ($nodo->getNodoIzquierda() != null)?$nodo->getNodoIzquierda()->getInformacion():null;
                    return (1 + $this->contar($nodoIzq) + $this->contar($nodoDer));
            } else {
                    return 1;
                }
            }
            
            return 0;
        }
        
        public function agregarHijo($infoNodo, $lado, $infoPadre) {
            if ($this->estaVacio()) {
                return false;
            } else {
                $nodo = new Nodo($infoNodo);
                $padre = $this->buscar($this->raiz, $infoPadre);
                
                if ($padre != null) {
                    if ($lado == "D") {
                        if ($padre->getNodoDerecha() != null) {
                            $nodo->setNodoDerecha($padre->getNodoDerecha());
                            $padre->setNodoDerecha($nodo);
                            return true;
                        } else {
                            $padre->setNodoDerecha($nodo);
                            return true;
                        }
                    }
                    
                    if ($lado == "I") {
                        if ($padre->getNodoIzquierda() != null) {
                            $nodo->setNodoIzquierda($padre->getNodoIzquierda());
                            $padre->setNodoIzquierda($nodo);
                            return true;
                        } else {
                            $padre->setNodoIzquierda($nodo);
                            return true;
                        }
                    } else {
                        return false;
                    }
                }
            }
        }
        
        public function padreNodo($infoNodo, $raiz) {
            $nodo = $this->buscar($raiz, $infoNodo);
            
            if ($nodo != null) {
                if ($raiz->getNodoDerecha() == $nodo || $raiz->getNodoIzquierda() == $nodo) {
                    return $raiz;
                }
                
                $siguiente = $this->padreNodo($infoNodo, $raiz->getNodoIzquierda());
                
                if ($siguiente == null) {
                    $siguiente = $this->padreNodo($infoNodo, $raiz->getNodoDerecha());
                }
                
                return $siguiente;
            }
            
            return null;
        }
        
        public function eliminarNodo($infoNodo) {
            $nodo = $this->buscar($this->raiz, $infoNodo);
            
            if ($nodo != null) {
                if (!($this->tieneHijos($nodo))) {
                    if ($nodo == $this->raiz) {
                        $this->raiz = null;
                        return true;
                    }
                    
                    $padre = $this->padreNodo($infoNodo, $this->raiz);
                    
                    if ($padre->getNodoIzquierda() == $nodo) {
                        $padre->setNodoIzquierda(null);
                    } elseif ($padre->getNodoDerecha() == $nodo) {
                        $padre->setNodoDerecha(null);
                    }
                    
                    return true;
                }
            }
            
            return false;
        }
        
        public function contarPares ($infoNodo) {
            $nodo = $this->buscar($this->raiz, $infoNodo);
            if ($nodo != null) {
                if ($this->tieneHijos($nodo)) {
                    $nodoDer = ($nodo->getNodoDerecha() != null)?$nodo->getNodoDerecha()->getInformacion():null;
                    $nodoIzq = ($nodo->getNodoIzquierda() != null)?$nodo->getNodoIzquierda()->getInformacion():null;
                    
                    if (($nodo->getInformacion() % 2) == 0) {
                        return (1 + $this->contarPares($nodoIzq) + $this->contarPares($nodoDer));
                    } else {
                        return ($this->contarPares($nodoIzq) + $this->contarPares($nodoDer));
                    }
                } else {
                    if (($nodo->getInformacion() % 2) == 0) {
                        return 1;
                    } else {
                        return 0;
                    }
                }
            }
            
            return 0;
        }
        
        public function recorridoPreOrden ($infoNodo) {
            $nodoRaiz = $this->buscar($this->raiz, $infoNodo);
            
            if ($nodoRaiz == null) {
                return;
            } else {
                echo ($nodoRaiz->getInformacion() . " ");
                $nodoDer = ($nodoRaiz->getNodoDerecha() != null)?$nodoRaiz->getNodoDerecha()->getInformacion():null;
                $nodoIzq = ($nodoRaiz->getNodoIzquierda() != null)?$nodoRaiz->getNodoIzquierda()->getInformacion():null;
                $this->recorridoPreOrden($nodoIzq);
                $this->recorridoPreOrden($nodoDer);
            }
        }
        
        public function recorridoInOrden ($infoNodo) {
            $nodoRaiz = $this->buscar($this->raiz, $infoNodo);
            
            if ($nodoRaiz == null) {
                return;
            } else {
                $nodoDer = ($nodoRaiz->getNodoDerecha() != null)?$nodoRaiz->getNodoDerecha()->getInformacion():null;
                $nodoIzq = ($nodoRaiz->getNodoIzquierda() != null)?$nodoRaiz->getNodoIzquierda()->getInformacion():null;
                $this->recorridoInOrden($nodoIzq);
                echo ($nodoRaiz->getInformacion() . " ");
                $this->recorridoInOrden($nodoDer);
            }
        }
        
        public function recorridoPostOrden ($infoNodo) {
            $nodoRaiz = $this->buscar($this->raiz, $infoNodo);
            
            if ($nodoRaiz == null) {
                return;
            } else {
                $nodoDer = ($nodoRaiz->getNodoDerecha() != null)?$nodoRaiz->getNodoDerecha()->getInformacion():null;
                $nodoIzq = ($nodoRaiz->getNodoIzquierda() != null)?$nodoRaiz->getNodoIzquierda()->getInformacion():null;
                $this->recorridoPostOrden($nodoIzq);
                $this->recorridoPostOrden($nodoDer);
                echo ($nodoRaiz->getInformacion() . " ");
            }
        }
        
        public function recorridoPorNiveles() {
            if (!($this->estaVacio())) {
                $cola = array();
                array_push($cola, $this->raiz);
                
                while (!(empty($cola))) {
                    $actual = array_shift($cola);
                    
                    if (!(empty($actual))) {
                        echo ($actual->getInformacion() . " ");
                        array_push($cola, $actual->getNodoIzquierda());
                        array_push($cola, $actual->getNodoDerecha());
                    }
                }
            }
        }
        
        public function alturaArbol ($infoNodo) {
            $nodoRaiz = $this->buscar($this->raiz, $infoNodo);
            
            if ($nodoRaiz == null) {
                return 0;
            }
            
            $nodoDer = ($nodoRaiz->getNodoDerecha() != null)?$nodoRaiz->getNodoDerecha()->getInformacion():null;
            $nodoIzq = ($nodoRaiz->getNodoIzquierda() != null)?$nodoRaiz->getNodoIzquierda()->getInformacion():null;
            $ladoIzq = $this->alturaArbol($nodoIzq);
            $ladoDer = $this->alturaArbol($nodoDer);
            
            if ($ladoIzq > $ladoDer) {
                return $ladoIzq + 1;
            } else {
                return $ladoDer + 1;
            }
        }
        
        public function esCompleto ($infoNodo) {
            $nodoRaiz = $this->buscar($this->raiz, $infoNodo);
            $esCompleto = false;
            
            if ($nodoRaiz != null) {
                if (!($this->esHoja($nodoRaiz))) {
                    if ($this->tieneHijos($nodoRaiz)) {
                        $nodoDer = ($nodoRaiz->getNodoDerecha() != null)?$nodoRaiz->getNodoDerecha()->getInformacion():null;
                        $nodoIzq = ($nodoRaiz->getNodoIzquierda() != null)?$nodoRaiz->getNodoIzquierda()->getInformacion():null;

                        $esCompleto = $this->esCompleto($nodoIzq) && $this->esCompleto($nodoDer);
                    } else {
                        $esCompleto = false;
                    }
                } else {
                    $esCompleto = true;
                }
            }
            
            return $esCompleto;
        }
        
        public function verNodo ($infoNodo) {
            $nodoRaiz = $this->buscar($this->raiz, $infoNodo);
            
            if ($nodoRaiz != null) {
                $informacion = $nodoRaiz->getInformacion();
                echo "{id: '$informacion' , label: '$informacion'},";
                
                $nodoDer = ($nodoRaiz->getNodoDerecha() != null)?$nodoRaiz->getNodoDerecha()->getInformacion():null;
                $nodoIzq = ($nodoRaiz->getNodoIzquierda() != null)?$nodoRaiz->getNodoIzquierda()->getInformacion():null;
                
                $this->verNodo($nodoIzq);
                $this->verNodo($nodoDer);
            }
        }
        
        public function verAristas ($infoNodo) {
            $nodoRaiz = $this->buscar($this->raiz, $infoNodo);
            
            if ($nodoRaiz != null) {
                $desde = $nodoRaiz->getInformacion();
                $nodoIzq = ($nodoRaiz->getNodoIzquierda() != null)?$nodoRaiz->getNodoIzquierda()->getInformacion():null;
                $nodoDer = ($nodoRaiz->getNodoDerecha() != null)?$nodoRaiz->getNodoDerecha()->getInformacion():null;
                
                if ($nodoRaiz->getNodoIzquierda() != null) {
                    $hacia = $nodoIzq;
                    echo "{from: '$desde', to: '$hacia', label: 'Izq'},";
                }
                
                if ($nodoRaiz->getNodoDerecha() != null) {
                    $hacia = $nodoDer;
                    echo "{from: '$desde', to: '$hacia', label: 'Der'},";
                }
                
                $this->verAristas($nodoIzq);
                $this->verAristas($nodoDer);
            }
        }
        
        public function verNodoHoja ($infoNodo) {
            $nodoRaiz = $this->buscar($this->raiz, $infoNodo);
            
            if ($nodoRaiz != null) {
                if ($this->esHoja($nodoRaiz)) {
                    $informacion = $nodoRaiz->getInformacion();
                    echo "{id: '$informacion' , label: '$informacion' , color: {
                        background: '#EC7630'
                    }},";
                } else {
                    $informacion = $nodoRaiz->getInformacion();
                    echo "{id: '$informacion' , label: '$informacion'},";
                }
                
                $nodoDer = ($nodoRaiz->getNodoDerecha() != null)?$nodoRaiz->getNodoDerecha()->getInformacion():null;
                $nodoIzq = ($nodoRaiz->getNodoIzquierda() != null)?$nodoRaiz->getNodoIzquierda()->getInformacion():null;
                
                $this->verNodoHoja($nodoIzq);
                $this->verNodoHoja($nodoDer);
            }
        }
    }
?>