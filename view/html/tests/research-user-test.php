<?php
$users = UserGateway::getAllUsers();

?>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
            box-sizing: border-box;
        }

        #myInput {
            background-image: url('https://cdn1.iconfinder.com/data/icons/hawcons/32/698627-icon-111-search-512.png');
            background-position: 10px 12px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }

        #myUL {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        #myUL li a {
            border: 1px solid #ddd;
            margin-top: -1px; /* Prevent double borders */
            background-color: #f6f6f6;
            padding: 12px;
            text-decoration: none;
            font-size: 18px;
            color: black;
            display: block
        }

        #myUL li a:hover:not(.header) {
            background-color: #eee;
        }
    </style>
    <title>TESTS - BEBES LUTINS</title>
</head>
<body>
    <h2>Clients</h2>

    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">

    <ul id="myUL">
        
        <?php
        foreach ($users as $user) {
            $name = ucfirst($user->getFirstname()) . " " . strtoupper($user->getSurname());
            echo "<li><a href='#'>$name</a></li>";
        }
        ?>
    </ul>
</body>
</html>

<script>
    function myFunction() {

        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("myUL");
        li = ul.getElementsByTagName("li");
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("a")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = "";
            } else {
                li[i].style.display = "none";
            }
        }
    }
</script>