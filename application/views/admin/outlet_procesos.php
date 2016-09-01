
<div class="row">
  <div class="col-md-12">
    <a class="btn btn-default pull-right" href="admin/formulario_creacion_proceso" role="button"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Crear Proceso</a>
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
      echo form_open('admin/editar_estado_proceso', array('id' => 'formulario_estados'));
      echo $lista_procesos; 
      echo form_close();
    ?>
  </div>
</div>

<script>
  $(function() {
    $('input[type="checkbox"]').change(function() {
      $('#formulario_estados').append(
        
        $('<input/>',{type: 'hidden', name: 'proceso_id', value: $(this).attr('data-id') }),
        $('<input/>',{type: 'hidden', name: 'proceso_estado', value: $(this).prop('checked') })

      ).submit();
    });
  });
</script>