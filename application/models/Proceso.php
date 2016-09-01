<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proceso extends CI_Model {

    public function listar_procesos_dropdown($proceso_id = null)
    {
        $this->db->select('id');
        $this->db->select('name');
        $this->db->from('process');

        $resultado_query = $this->db->get();

        $listado_procesos = array();

        foreach($resultado_query->result() as $res)
        {
            $listado_procesos[ $res->id ] = $res->name;
        }

        return form_dropdown('proceso_id', $listado_procesos, $proceso_id, array('class' => 'form-control') );
    }

	public function listar_procesos()
    {
        $this->load->library('table');
        $template = array(
            'table_open' => '<table class="table table-striped">'
        );

        $this->table->set_template($template);
        $this->table->set_heading('Nombre', 'Descripción', 'Estado');

        $this->db->select('id');
        $this->db->select('name');
        $this->db->select('description');
        $this->db->select('status');
        $this->db->from('process');

        $resultado_query = $this->db->get();

        $listado_procesos = array();

        foreach($resultado_query->result() as $res)
        {
            $temporal = array();

            $temporal["nombre"] = $res->name;
            $temporal["descripcion"] = $res->description;
            $temporal["estado"] = '<input type="checkbox" ' . ( ( $res->status == 1 ) ? 'checked' : '' ) . ' data-toggle="toggle" data-size="mini" data-id="' . $res->id . '">'; // http://www.bootstraptoggle.com/

            array_push($listado_procesos, $temporal);
        }

        return $this->table->generate($listado_procesos);
    }

    public function crear_proceso($nombre, $descripcion)
    {
        $response = array( 'status' => FALSE, 'message' => 'nothing has been processed' );

        try 
        {
            $data = array(
                'name' => $nombre,
                'description' => $descripcion
            );

            $this->db->insert('process', $data);

            $error = $this->db->error();

            if( $error['code'] == 0)
            {
                $response['status']     = TRUE;
                $response['message']    = "Proceso <" . $nombre . "> creado exitosamente"; 
            }
            else
            {
                throw new Exception( $error['message'] ); 
            }
        }
        catch (Exception $e) 
        {
            log_message('error', "[crear_proceso][general_error]: " . $e);

            $response['status']     = FALSE;
            $response['message']    = "Se presentó un problema en la creación del Proceso";                       
        } 

        return $response; 
    }

    public function editar_estado_proceso($id, $estado)
    {
        $response = array( 'status' => FALSE, 'message' => 'nothing has been processed' );

        try 
        {
            $estado_binario = ( $estado == 'true' ) ? 1 : 0; 

            $this->db->set('status', $estado_binario);
            $this->db->where('id', $id);
            $this->db->update('process');

            $error = $this->db->error();

            if( $error['code'] == 0)
            {
                $response['status']     = TRUE;
                $response['message']    = "Proceso actualizado exitosamente"; 
            }
            else
            {
                throw new Exception( $error['message'] ); 
            }
        }
        catch (Exception $e) 
        {
            log_message('error', "[crear_proceso][general_error]: " . $e);

            $response['status']     = FALSE;
            $response['message']    = "Se presentó un problema en la actualización del Proceso";                       
        } 

        return $response;
    }
}