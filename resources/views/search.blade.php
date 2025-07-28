<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="{{ asset('js/jQuery-3.7.1.js') }}"></script>
</head>
<body>
    <input type="text" id="search" name="search" autocomplete="off">
    <input type="text" id="abc" name="abc" autocomplete="off">
    <div id="user-list" style="max-height:200Px;position: absolute;overflow-y: scroll;"></div>

    <script src="{{ asset('js/ajax/scroll_search.js') }}"></script>
</body>
</html>