<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<header class="header bg-white rounded-b-xl shadow-md flex justify-between items-center px-4 md:px-8 py-2 h-16">
    <div class="logo">
        <a href='{{ route('home') }}'>
            <img src="https://i.ibb.co.com/rHs6fTs/Group-75.png" alt="" class="h-12">
        </a>
    </div>
{{--    <nav class="top-nav flex items-center h-full">--}}
{{--        <ul class="flex gap-6 items-center">--}}
{{--            <li><a href="question.html" class="circle p-2 flex items-center justify-center"><i class="fas fa-question-circle"></i></a></li>--}}
{{--            <li>--}}
{{--                <a href="notification.html" class="circle p-2 flex items-center justify-center">--}}
{{--                    <i class="fas fa-bell"></i>--}}

{{--                </a>--}}
{{--            </li>--}}

{{--            <li><a href="account.html" class="circle p-2 flex items-center justify-center"><i class="fas fa-cog"></i></a></li>--}}
{{--        </ul>--}}
{{--    </nav>--}}
</header>
<style>
    .btn-sidebar {
        font-size: 18px; /* Reduced font size */
        width: 180px; /* Reduced width */
        height: 45px; /* Reduced height */
        align-items: center;
        justify-content: center;
        border-radius: 8px; /* Slightly smaller radius */
        display: flex;
        color: #123E63;
        text-decoration: none;
        padding: 8px; /* Reduced padding */
        background: none;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
        box-shadow: 0px 4px 8px 1.5px rgba(34, 60, 80, 0.09); /* Slightly smaller shadow */
    }

    .btn-sidebar:hover {
        background-color: #FF6B00;
        color: white;
    }

    .btn-sidebar:hover img {
        filter: brightness(0) invert(1);
    }

    .circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px; /* Smaller circle */
        height: 50px; /* Smaller height */
        background-color: white;
        border-radius: 50%;
        box-shadow: 0px 4px 8px 1.5px rgba(34, 60, 80, 0.09); /* Reduced shadow */
        text-align: center;
        margin-left: 8px; /* Reduced spacing */
    }

    .circle i {
        font-size: 24px; /* Reduced icon size */
        color: #123E63;
    }

    .circle:hover {
        background-color: #FF6B00;
    }

    .circle:hover i {
        color: white;
    }

    .top-nav {
        justify-content: center;
        align-items: center;
        height: 100%; /* Ensure full height alignment */
    }

    .top-nav ul {
        gap: 12px; /* Reduced gap between icons */
        display: flex;
        align-items: center;
    }

    .circle:hover {
        background-color: #FF6B00;
        transition: background-color 0.3s, color 0.3s; /* Smooth transition */
    }


</style>
