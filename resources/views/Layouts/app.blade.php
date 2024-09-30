<html lang="ru"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Шапка и боковое меню</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=ec876c3e-f46c-4501-abab-33da77c4b228&lang=ru_RU" type="text/javascript"></script>
</head>

<body class="bg-gray-100 font-sans">
    <div class="container mx-auto px-4 ">
        @include("Components.header")
        <div class="flex flex-col md:flex-row mt-6 md:mt-8">
            @include("Components.aside")
            <main class="main-content flex flex-col md:flex-1 md:ml-4 mt-6 md:mt-0">
               @yield("content")
            </main>
        </div>
    </div>


    <style>
        .btn-sidebar {
            font-size: 24px;
            width: 241px;
            height: 55px;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            display: flex;
            color: #123E63;
            text-decoration: none;
            padding: 10px;
            background: none;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            box-shadow: 0px 5px 10px 2px rgba(34, 60, 80, 0.09);
        }

        .btn-sidebar:hover {
            background-color: #FF6B00;
            color: white;
        }

         .btn-sidebar:hover img {
            filter: brightness(0) invert(1);
        }

        .circle {
            width: 63px;
            height: 63px;
            background-color: white;
            border-radius: 50%;
            box-shadow: 0px 5px 10px 2px rgba(34, 60, 80, 0.09);
        }

        .top-nav {
            justify-content: center;
            align-items: center;
        }
    </style>



 </body></html>
