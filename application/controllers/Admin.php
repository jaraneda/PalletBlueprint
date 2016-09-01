<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        if( !$this->session->userdata('logged_in') )
        {
        	redirect('signin');
        }

        $this->load->model('proceso');
        $this->load->model('documento');
        $this->load->model('formulario');
    }

    public function index()
    {
        $data['outlet'] = $this->session->flashdata('outlet');
    	$this->load->view('admin/home', $data);
    }

    // PROCESOS

    public function listar_procesos($respuesta = array())
    {
        $lista_procesos = $this->proceso->listar_procesos();

        $data = array_merge($respuesta, array('lista_procesos' => $lista_procesos));

        $outlet = $this->load->view('admin/outlet_procesos', $data, true);

        return $this->render_outlet($outlet);
    }

    public function formulario_creacion_proceso($respuesta = array())
    {
        $outlet = $this->load->view('admin/outlet_crear_proceso', $respuesta, true);
        return $this->render_outlet($outlet);
    }

    public function crear_proceso()
    {
        $this->form_validation->set_rules('proceso_nombre', 'Nombre', 'trim|required|min_length[3]|max_length[64]');
        $this->form_validation->set_rules('proceso_descripcion', 'Descripción', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->formulario_creacion_proceso(); 
        }
        else
        {
            $proceso_nombre         = $this->input->post('proceso_nombre', TRUE);
            $proceso_descripcion    = $this->input->post('proceso_descripcion', TRUE);

            $response = $this->proceso->crear_proceso($proceso_nombre, $proceso_descripcion);

            if( $response['status'] )
            {
                $this->listar_procesos($response);
            }
            else
            {
                $this->formulario_creacion_proceso($response);
            }
        }
    }

    public function editar_estado_proceso()
    {
        $proceso_id         = $this->input->post('proceso_id', TRUE);
        $proceso_estado     = $this->input->post('proceso_estado', TRUE);

        //return $this->render_outlet( '<h1>' . print_r($this->input->post(), true) . '</h1>' );

        $response = $this->proceso->editar_estado_proceso($proceso_id, $proceso_estado);

        $this->listar_procesos($response);
    }

    // DOCUMENTOS

    public function listar_documentos($respuesta = array())
    {
        $proceso_id = $this->input->post('proceso_id', TRUE);

        if(isset($proceso_id))
        {
            $listado_documentos = $this->documento->listar_documentos($proceso_id);
            $respuesta = array_merge($respuesta, array('listado_documentos' => $listado_documentos));
        }

        $lista_procesos = $this->proceso->listar_procesos_dropdown($proceso_id);

        $data = array_merge($respuesta, array('lista_procesos' => $lista_procesos));

        $outlet = $this->load->view('admin/outlet_documentos', $data, true);

        return $this->render_outlet($outlet);
    }

    public function formulario_creacion_documento($respuesta = array())
    {
        $lista_procesos = $this->proceso->listar_procesos_dropdown();

        $data = array_merge($respuesta, array('lista_procesos' => $lista_procesos));

        $outlet = $this->load->view('admin/outlet_crear_documento', $data, true);
        return $this->render_outlet($outlet);
    }

    public function crear_documento()
    {
        $this->form_validation->set_rules('documento_nombre', 'Nombre', 'trim|required|min_length[3]|max_length[64]');
        $this->form_validation->set_rules('documento_descripcion', 'Descripción', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->formulario_creacion_documento(); 
        }
        else
        {
            $config['upload_path']      = './tmp_uploads/';
            $config['allowed_types']    = 'pdf';
            $config['remove_spaces']    = TRUE;
            $config['encrypt_name']     = TRUE;

            $this->load->library('upload', $config);

            if ( $this->upload->do_upload('documento_template'))
            {
                $proceso_id             = $this->input->post('proceso_id', TRUE);
                $documento_nombre       = $this->input->post('documento_nombre', TRUE);
                $documento_descripcion  = $this->input->post('documento_descripcion', TRUE);
                $documento_path         = $this->upload->data('file_path');
                $documento_template     = $this->upload->data('file_name');

                $response = $this->documento->crear_documento($proceso_id, $documento_nombre, $documento_descripcion, $documento_path, $documento_template);

                if( $response['status'] )
                {
                    $this->listar_documentos($response);
                }
                else
                {
                    $this->formulario_creacion_proceso($response);
                }
            }
            else
            {
                $response = array(
                    'status'    => FALSE,
                    'message'   => 'Se presentó un problema al subir el archivo. <br /><br />' . $this->upload->display_errors()
                );
                $this->formulario_creacion_proceso($response);
            }
            
        }
    }

    public function descargar_template($documento_id)
    {
        $this->load->helper('download');
        if( is_numeric($documento_id) )
        {
            $ruta_documento = $this->documento->obtener_ruta_documento($documento_id);
            force_download( $ruta_documento , NULL);
        }
    }

    // FORMULARIOS

    public function listar_formularios($respuesta = array())
    {
        $proceso_id     = $this->input->post('proceso_id', TRUE);
        $documento_id   = $this->input->post('documento_id', TRUE);

        if( isset($proceso_id) && isset($documento_id) )
        {
            $lista_formularios = $this->formulario->listar_formularios($proceso_id, $documento_id);
            $respuesta = array_merge($respuesta, array('listado_formularios' => $lista_formularios));
        }

        $lista_procesos     = $this->proceso->listar_procesos_dropdown($proceso_id);
        $lista_documentos   = $this->documento->listar_documentos_dropdown($documento_id);

        $data = array_merge($respuesta, array('lista_procesos' => $lista_procesos, 'lista_documentos' => $lista_documentos));

        $outlet = $this->load->view('admin/outlet_formularios', $data, true);

        return $this->render_outlet($outlet);
    }

    public function formulario_creacion_formulario($respuesta = array())
    {
        $lista_procesos = $this->proceso->listar_procesos_dropdown();

        $data = array_merge($respuesta, array('lista_procesos' => $lista_procesos));

        $outlet = $this->load->view('admin/outlet_crear_formulario', $data, true);
        return $this->render_outlet($outlet);
    }

    private function render_outlet($outlet = null){

        $this->session->set_flashdata('outlet', $outlet);
        return redirect('admin');
    }
}