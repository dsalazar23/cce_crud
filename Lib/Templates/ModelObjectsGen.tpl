<?php

/**
 * @generated
 * - Clase Generada Automaticamente - NO MODIFICAR MANUALMENTE
 * Esta clase representa el modelo de la tabla '${table_name}'
 *
 * @package     Model.gen
 * @author      JpBaena13
 * @since       PHP 5
 */
class gen${domain_class_name} {

    ${variables}

    /**
     * Constructor de la clase ${domain_class_name}
     */
    function __construct($id = null) {
        ${constructor}
    }

    /**
     * Cambia el objeto DTO de la clase por el especificado
     *
     * @param  ${domain_class_name}DTO $${DTO_name} DTO a modificar
     */
    public function set${domain_class_name}DTO($${DTO_name}) {
        $this->${DTO_name} = $${DTO_name};
    }

    /**
     * Retorna el objeto DTO de clase
     *
     * @return  ${domain_class_name}DTO $${DTO_name} DTO de clase.
     */
    public function get${domain_class_name}DTO() {
        return $this->${DTO_name};
    }

    /**
     * Guarda el objeto ${domain_class_name} en la base de datos.
     */
    public function save() {
        if ($this->getId()) {
            FactoryDAO::get${domain_class_name}DAO()->update($this->${DTO_name});

        } else {
            $this->setId(FactoryDAO::get${domain_class_name}DAO()->insert($this->${DTO_name}));
        }
    }
    
    /**
     * Retorna un arreglo con todos lo objetos encontrados en la fuente de datos
     *
     * @return Array Arreglo con todos los objetos <${domain_class_name}>
     */
    public static function getAll($objects = true) {
         $${DTO_name}s = FactoryDAO::get${domain_class_name}DAO()->queryAll();

         if (!$objects)
            return $${DTO_name}s;

         $arr = Array();

         foreach ($${DTO_name}s as $${DTO_name} ) {
            $object = new ${domain_class_name}();
            $object->set${domain_class_name}DTO($${DTO_name});
            array_push($arr, $object);
         }

         return $arr;
    }
    
    /**
     * Elimina el objeto ${domain_class_name} en la base de datos.
     * 
     * @param int $id 
     *            Identificador único del objeto.
     */
    public static function delete($id) {
        return FactoryDAO::get${domain_class_name}DAO()->delete($id);
    }
    
    // *** Métodos GETS ***
    ${get_methods}
    // *** Métodos SETS ***
    ${set_methods}
}
?>