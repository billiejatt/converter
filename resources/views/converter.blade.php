<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XML to CSV Converter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .tabs {
            overflow: hidden;
            border-bottom: 1px solid #ccc;
            margin-bottom: 20px;
        }

        .tab {
            float: left;
        }

        .tab button {
            background-color: inherit;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
        }

        .tab button:hover {
            background-color: #ddd;
        }

        .tabcontent {
            display: none;
            padding: 20px;
            border-top: none;
        }

        #fileTab {
            display: block;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button[type="submit"],
        button[type="button"] {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover,
        button[type="button"]:hover {
            background-color: #0056b3;
        }

        #csvOutput {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>XML to CSV Converter</h2>

        <div class="tabs">
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'fileTab')">From XML File</button>
            </div>
            <div class="tab">
                <button class="tablinks" onclick="openTab(event, 'textTab')">From XML Text</button>
            </div>
        </div>

        <div id="fileTab" class="tabcontent">
            <form action="{{ route('convert.file') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="xmlFile">Upload XML File:</label><br>
                    <input type="file" id="xmlFile" name="xmlFile" accept=".xml">
                </div>
                <div class="form-group">
                    <button type="submit" name="convertFile">Convert to CSV</button>
                </div>
            </form>
        </div>

        <div id="textTab" class="tabcontent">
            <form action="{{ route('convert.text') }}" method="post">
                @csrf
                <div class="form-group">
                    <label for="xmlData">Enter XML Data:</label><br>
                    <textarea id="xmlData" name="xmlData" required>{{ old('xmlData') }}</textarea><br>
                </div>
                <div class="form-group">
                    <button type="submit" name="convertText">Convert to CSV</button>
                </div>
            </form>
        </div>

        @if (isset($csvContent))
        <h2>CSV Output</h2>
        <textarea id="csvOutput" name="csvOutput" readonly>{{ $csvContent }}</textarea>
        <a href="{{ route('download.csv') }}" download="converted_data.csv"><button type="button">Download CSV</button></a>
        @endif

    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>

</html>