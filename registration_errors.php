<?php  
/**
 * print array errors 
 * 
 * @param array $errors
 * 
 * @return Response html
 */
if (count($errors) > 0) : 
?>
  <div class="error">
    <?php foreach ($errors as $error) : ?>
      <br>
      <div class="row justify-content-center">
      
        <div class="alert alert-danger" style="background-color: red;border-color:red" role="alert"><?php echo $error ?></td></div>
      </div>
  	<?php endforeach ?>
  </div>
<?php  endif ?>
