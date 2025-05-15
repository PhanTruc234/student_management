<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
        }
        .title,.title-name{
            font-size: 17px;
            margin: 10px 0; 
        }
        .sidebar {
            width: 270px;
            background-color: #343a40;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-size: 20px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            margin-bottom: 12px;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }
        .item-person, .item-book{
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 17px;
        }
        .img-logo{
            width: 70px;
            border-radius: 100%; 
            overflow: hidden;
            margin: 0 auto;
        }
        img{
            width: 100%;
            object-fit: cover;
        }
        /* CSS cho thông báo */
        .alert {
            position: absolute;
            top: 20px;
            right: -60%;
            padding: 15px;
            background-color: green; 
            color: white;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: none;
            opacity: 0;
            animation: runIn 0.5s ease-in-out forwards, runOut 0.5s ease-in-out 3s forwards;
            z-index: 9999;
        }

        @keyframes runIn {
            0% {
                right: -60%;
                opacity: 0;
            }
            100% {
                right: 20px;
                opacity: 1;
            }
        }

        @keyframes runOut {
            0% {
                right: 20px;
                opacity: 1;
            }
            100% {
                right: -60%;
                opacity: 0;
            }
        }

        .alert.error { background-color: red; }
        .alert.info { background-color: blue; }
        .alert.warning { background-color: orange; }
    </style>
    <title>@yield('title')</title>
</head>
<body>
    <div class="sidebar">
        <h1 class="title">KHOA CÔNG NGHỆ THÔNG TIN</h1>
        <div class="img-logo"><img src="https://scontent.fhan14-2.fna.fbcdn.net/v/t39.30808-1/467775294_1086766406792449_195283251104119265_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=100&ccb=1-7&_nc_sid=2d3e12&_nc_ohc=uDEVfWrQcDIQ7kNvwHFx6PZ&_nc_oc=AdmvR-BE9gFC3_AZwz8j8mpIqJbqzosubMam7ur0YELPChjCy1Jh3VI2AtYwA2vDw30&_nc_zt=24&_nc_ht=scontent.fhan14-2.fna&_nc_gid=AliN117GfyPaDx_AttRung&oh=00_AfK5O8JSQQnmO1-PlNu9cWExAc936OJqZQLKNZ7fIOkHcQ&oe=68229FB6" alt=""></div>
        <h4 class="title-name">Quản lý sinh viên</h4>
        <div class="item-person">
            <a href="{{ route('students.index') }}"><i class="fa-solid fa-person"></i></a>
            <a href="{{ route('students.index') }}">Sinh viên</a>
        </div>
        <div class="item-book">
            <a href="{{ route('subjects.index') }}"><i class="fa-solid fa-book"></i></a>
            <a href="{{ route('subjects.index') }}">Môn học</a>
        </div>

    </div>
    <div class="main-content">
        <div id="notification" class="alert"></div>
        <div class="row">
            <h1 class="mt-3 mb-3">@yield('title')</h1>
        </div>
        <div class="content">
            @yield('content')
        </div>
    </div>
    <script>
        const notify = document.getElementById("notification");
        @if (session('success'))
            notify.innerText = "{{ session('success') }}";
            notify.classList.add('success');
        @elseif (session('error'))
            notify.innerText = "{{ session('error') }}";
            notify.classList.add('error');
        @elseif (session('info'))
            notify.innerText = "{{ session('info') }}";
            notify.classList.add('info');
        @elseif (session('warning'))
            notify.innerText = "{{ session('warning') }}";
            notify.classList.add('warning');
        @endif

        if (notify.innerText !== "") {
            notify.style.display = 'block';
        }
    </script>
</body>
</html>
