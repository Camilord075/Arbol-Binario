<?php
    class Nodo {
        private $informacion;
        private $nodoDerecha;
        private $nodoIzquierda;
        
        public function __construct($informacion) {
            $this->informacion = $informacion;
            $this->nodoDerecha = null;
            $this->nodoIzquierda = null;
        }
        
        public function getInformacion() {
            return $this->informacion;
        }

        public function getNodoDerecha() {
            return $this->nodoDerecha;
        }

        public function getNodoIzquierda() {
            return $this->nodoIzquierda;
        }

        public function setInformacion($informacion): void {
            $this->informacion = $informacion;
        }

        public function setNodoDerecha($nodoDerecha): void {
            $this->nodoDerecha = $nodoDerecha;
        }

        public function setNodoIzquierda($nodoIzquierda): void {
            $this->nodoIzquierda = $nodoIzquierda;
        }

        public function insertar ($valor) {
            if ($valor < $this->informacion) {
                if ($this->nodoIzquierda == null) {
                    $this->nodoIzquierda = new Nodo($valor);
                } else {
                    $this->nodoIzquierda->insertar($valor);
                }
            } else {
                if ($this->nodoDerecha == null) {
                    $this->nodoDerecha = new Nodo($valor);
                } else {
                    $this->nodoDerecha->insertar($valor);
                }
            }
        }
    }
?>