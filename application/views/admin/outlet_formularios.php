
<div class="row">
  <div class="col-md-10">
    <?php echo form_open( 'admin/listar_formularios', array('class' => 'form-inline') ); ?>
    <div class="form-group">
      <label for="proceso_id">Proceso </label>
      <?php echo $lista_procesos; ?>
    </div>
    <div class="form-group">
      <label for="documento_id">Documento </label>
      <?php echo $lista_documentos; ?>
    </div>

    <button type="submit" class="btn btn-default">Listar Formularios</button>
  </form>
  </div>
  <div class="col-md-2">
    <a class="btn btn-default pull-right" href="admin/formulario_creacion_documento" role="button"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Crear Documento</a>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <?php
      if(isset($message))
      {
        echo '<div class="alert alert-' . (($status) ? 'success' : 'danger') . '" role="alert">' . $message . '</div>';
      }
    ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <?php 
      echo form_open('admin/editar_estado_formulario', array('id' => 'formulario_estados'));
      if(isset($listado_formularios))
      {
      	echo $listado_formularios; 
      } 
      echo form_close();
    ?>
  </div>
</div>