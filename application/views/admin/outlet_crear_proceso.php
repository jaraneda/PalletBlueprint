<div class="row">
  <div class="col-md-12">
    <?php
      if(isset($message))
      {
        echo '<div class="alert alert-' . ($status) ? 'success' : 'danger' . '" role="alert">' . $message . '</div>';
      }
      echo validation_errors('<div class="alert alert-danger" role="alert">', '</div>');
    ?>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <?php echo form_open('admin/crear_proceso', array('class' => 'form-horizontal')); ?>
      <div class="form-group">
        <label for="proceso_nombre" class="col-sm-2 control-label">Nombre</label>
        <div class="col-sm-10">
          <input type="text" class="form-control" id="proceso_nombre" name="proceso_nombre" placeholder="Nombre de Proceso" value="<?php echo set_value('proceso_nombre'); ?>">
        </div>
      </div>
      <div class="form-group">
        <label for="proceso_descripcion" class="col-sm-2 control-label">Descripción</label>
        <div class="col-sm-10">
          <textarea class="form-control" id="proceso_descripcion" name="proceso_descripcion" rows="3" value="<?php echo set_value('proceso_descripcion'); ?>"></textarea>
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
          <button type="submit" class="btn btn-default pull-right">Crear Proceso</button>
        </div>
      </div>
    </form>
  </div>
</div>