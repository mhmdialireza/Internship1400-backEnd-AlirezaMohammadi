<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>monomial</title>
    <link rel="stylesheet" href="./assets/css/style.css">
</head>

<body>
    <div id="wrapper">
        <div class="overlay">
            <div class="desc">
                <div id="form" >
                    <label for="polynomial">Enter your polynomial</label>
                    <input id="polynomial" name="polynomial" type="text" placeholder="ex : 2.2x+4x-2x-9">
                    <button type="submit">submit</button>
                </div>
                <div class="solve">
                    <div>
                        <p>Answer : </p>
                        <p id="answer">-</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./js/jquery.min.js"></script>
    <script src="./js/ajaxRequest.js"></script>
</body>

</html>