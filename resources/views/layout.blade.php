<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Football</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">หน้าแรก </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/matches">ตารางแข่งขัน </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/countries">ตารางประเทศ </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/goals">ตารางประตู</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/teams">ตารางทีม</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/players">นักกีฬา</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/referees">กรรมการ</a>
                </li>                                       
                <li class="nav-item">
                    <a class="nav-link" href="/stadiums">สนาม</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="/matchreferees">ตารางกรรมการกับเกม</a>
                </li> 
            </ul>
        </div>
    </nav>

    <div class="container py-5">
        @yield('content')
    </div>

</body>

</html>
