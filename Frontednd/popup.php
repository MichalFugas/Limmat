<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <title>Okno Popup</title>
        <link rel="stylesheet" href="/CSS/pup.css">
        <link href="https://unpkg.com/ionicons@4.5.0/dist/css/ionicons.min.css" rel="stylesheet">

    </head>
    <body>
<!--<a onclick="pop()" class="btn">Show box</a>-->


<div id="box">
<span class="icon ion-md-checkmark"></span>
<h1>Good Job!</h1>

<a class="close">Close</a>

</div>
<script type="text/javascript">
    var c = 0;
    function pop(){
        if (c == 0){
            document.getElementById("box").style.display = "block";
            c = 1;
            setTimeout(function(){
                document.getElementById("box").style.display = "none";
                c = 0;
            }, 3000);
            // return false;
        }else{
            document.getElementById("box").style.display = "none";
            c = 0;
        }
    }
</script>
</body>
    <?php
    echo"<script>pop();</script>"
    ?>

</html>







<!---->
<!---->
<!---->
<!--    <a onclick="pop()" class="btn">Okno Pup</a>-->
<!--    <div id="box">-->
<!--    <i class="icon ion-md-checkmark"></i>-->
<!--    <h1>Dobra robota !</h1>-->
<!--    <a onclick="pop()" class="close">Close</a>-->
<!---->
<!--    <script type="text/javascript">-->
<!--        var c = 0;-->
<!--        function pop(){-->
<!--            if (c == 0){-->
<!--                document.getElementById("box").style.display = "block";-->
<!--                c = 1;-->
<!--                setTimeout(function(){-->
<!--                    document.getElementById("box").style.display = "none";-->
<!--                    c = 0;-->
<!--                }, 3000);-->
<!--                // return false;-->
<!--            }else{-->
<!--                document.getElementById("box").style.display = "none";-->
<!--                c = 0;-->
<!--            }-->
<!--        }-->
<!--    </script>-->
<!--    </div>-->
<!--    --><?php
//
//    echo "<script>pop()</script>";
//
//    ?>
<!--    </body>-->
<!--</html>-->



