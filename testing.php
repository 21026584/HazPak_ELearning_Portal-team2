<!DOCTYPE html>
<html>
<head>
   <title>How to add and remove input fields dynamically using jQuery with Bootstrap?</title>
   <script src="https
://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
   <h4>How to add and remove input fields dynamically using jQuery with Bootstrap?</h4>
   <form>
      <div class="form-group" id="input-container"></div>
      <br/>
      <button class="remove-input">Remove Input</button>
   </form>
   <br/>
   <button id="add-input">Add Input</button>
   <script>
      $("#add-input").click(function () {
         $("#input-container").append('<input type="text" class="form-control">');
      });
      $(".remove-input").click(function () {//this removes the entire form entirely
         $(this).parent().remove();
      });
   </script>
</body>
</html>