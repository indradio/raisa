<html>
<head>
    <title>Import Excel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            padding: 20px 50px;
        }
        input[type="file"] {
            display:block;
            border: 1px solid #b5b5b5;
            border-radius: 2px;
            padding: 5px;
            font-size: 16px;
            color: #777;
        }
        button[type="submit"] {
            background: #06c;
            border-color: #06c;
            outline: none;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
            border-radius: 3px;
            padding: 5px 10px;
        }
        .help {
            font-size: 12px;
            color: #b5b5b5;
            margin-top: 2px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <?= form_open_multipart(); ?>
        <input type="file" name="excel" required />
        <p class="help">* Gunakan file dengan extensi .xlsx</p>
        <button type="submit" name="submit" value="upload">Upload... </button>
    <?= form_close(); ?>
</body>
</html>