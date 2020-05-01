<html>
<head>
    <title>Scarmed</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="js/sweetalert.min.js"></script>
    <script src="js/bootstrap.min.js"
            integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
            crossorigin="anonymous"></script><!--  jQuery -->
    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/datepicker.min.js"></script>
    <link rel="stylesheet" href="css/datepicker.min.css"/>
</head>
<body>
<div class="bootstrap-iso">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">

                <!-- Form code begins -->
                <form method="post">
                    <div class="form-group"> <!-- Date input -->
                        <label class="control-label" for="date">Date</label>
                        <input class="form-control" id="date" name="date" placeholder="MM/DD/YYY" type="text"/>
                    </div>
                    <div class="form-group"> <!-- Submit button -->
                        <button class="btn btn-primary " name="submit" type="submit">Submit</button>
                    </div>
                </form>
                <!-- Form code ends -->

            </div>
        </div>
    </div>
</div>
</body>
<script>
    $(document).ready(function(){
        var date_input=$('input[name="date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var options={
            format: 'mm/dd/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        };
        date_input.datepicker(options);
    })
</script>

</html>