<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documento extends CI_Model {

    public function listar_documentos_dropdown($documento_id = null)
    {
        $this->db->select('id');
        $this->db->select('name');
        $this->db->select('process');
        $this->db->from('document');

        $resultado_query = $this->db->get();

        $listado_documentos = '<select name="documento_id" class="form-control">';

        foreach($resultado_query->result() as $res)
        {
            $listado_documentos .= '<option value="' . $res->id . '" data-process="' . $res->process . '" ' . ( ($documento_id == $res->id) ? 'selected="selected"': '' ) . '>' . $res->name . '</option>';
        }

        $listado_documentos .= '</select>'; 

        return $listado_documentos;
    }

	public function obtener_ruta_documento($documento_id)
    {
        $this->db->select('directory');
        $this->db->select('template');
        $this->db->where('id', $documento_id);
        $this->db->from('document');

        $resultado_query = $this->db->get();

        $row = $resultado_query->row();

        $ruta_documento = "";

        if (isset($row))
        {
                $ruta_documento = $row->directory . $row->template;
        }

        return $ruta_documento;
    }

    public function listar_documentos($proceso_id)
    {
        $this->load->library('table');

        $template = array(
            'table_open' => '<table class="table table-striped">'
        );

        $this->table->set_template($template);
        $this->table->set_heading('Nombre', 'Descripción', 'Documento','Estado');

        $this->db->select('id');
        $this->db->select('name');
        $this->db->select('description');
        $this->db->select('status');
        $this->db->select('directory');
        $this->db->select('template');
        $this->db->where('process', $proceso_id);
        $this->db->from('document');

        $resultado_query = $this->db->get();

        $listado_documentos = array();

        foreach($resultado_query->result() as $res)
        {
            $temporal = array();

            $temporal["nombre"] = $res->name;
            $temporal["descripcion"] = $res->description;
            $temporal["template"] = anchor('admin/descargar_template/' . $res->id, '<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>');
            $temporal["estado"] = '<input type="checkbox" ' . ( ( $res->status == 1 ) ? 'checked' : '' ) . ' data-toggle="toggle" data-size="mini" data-id="' . $res->id . '">'; // http://www.bootstraptoggle.com/

            array_push($listado_documentos, $temporal);
        }

        return $this->table->generate($listado_documentos);
    }

    public function crear_documento($proceso_id, $documento_nombre, $documento_descripcion, $documento_path, $documento_template)
    {
        $response = array( 'status' => FALSE, 'message' => 'nothing has been processed' );

        try 
        {
            $data = array(
                'process'       => $proceso_id,
                'name'          => $documento_nombre,
                'description'   => $documento_descripcion,
                'directory'     => $documento_path,
                'template'      => $documento_template
            );

            $this->db->insert('document', $data);

            $error = $this->db->error();

            if( $error['code'] == 0)
            {
                $response['status']     = TRUE;
                $response['message']    = "Documento <" . $documento_nombre . "> creado exitosamente"; 
            }
            else
            {
                throw new Exception( $error['message'] ); 
            }
        }
        catch (Exception $e) 
        {
            log_message('error', "[crear_documento][general_error]: " . $e);

            $response['status']     = FALSE;
            $response['message']    = "Se presentó un problema en la creación del Documento";                       
        } 

        return $response; 
    }

    public function editar_estado_documento($id, $estado)
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