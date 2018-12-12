<?php

namespace Catalog;

class Lists
{
    private $empty_string = 'Seleccionar...';

    /**
     * @param null $fields_param
     * @param null $conditions_param
     * @param mixed $empty
     * @return array
     */
    public function get_compensations_type_list($fields_param = null, $conditions_param = null, $empty = false)
    {
        $fields = [
            'DriverVariableCompensationCatalog.id',
            'DriverVariableCompensationCatalog.name',
        ];
        if ($fields_param !== null)
            $fields = $fields_param;

        $conditions = [];
        if ($conditions_param !== null)
            $conditions = $conditions_param;

        $result = $this->generate_request('drivers_variable_compensations_catalog', $fields, $conditions);
        return $this->prepare_response($result, $empty);
    }

    /**
     * Validate if there is not a message for empty label, if there is one, add it
     *
     * @param null $result
     * @param bool $empty
     * @return mixed
     */
    private function prepare_response($result = null, $empty = false)
    {
        if (is_string($empty))
            $this->empty_string = $empty;

        $response = ['' => $this->empty_string];

        if ($empty !== false) {
            if (!empty($result) && is_array($result))
                $response += $result;

            return $response;
        } else
            return $result;
    }

    /**
     * @param string $request
     * @param array $fields
     * @param array $conditions
     * @param string $query_type
     * @param bool $nolimit
     * @param array $aditional_params
     * @return bool
     */
    private function generate_request($request = null, $fields = null, $conditions = null, $query_type = 'list', $nolimit = true, $aditional_params = [])
    {
        if (($request === null) || ($fields === null) || ($conditions === null))
            return false;

        $params = [
            'fields' => $fields,
            'conditions' => $conditions,
            'query_type' => $query_type,
            'nolimit' => $nolimit
        ];

        if (!empty($aditional_params) && is_array($aditional_params)) {
            $params += $aditional_params;
        }

        $result = $this->APIV2->Request($request, 'GET', 'json', null, $params);

        return $result;
    }
}