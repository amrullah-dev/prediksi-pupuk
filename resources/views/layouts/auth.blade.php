<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>

        @yield('title') | CV. Mahatani Mandiri

    </title>

    <!-- ==========================================
                    FONT AWESOME
    =========================================== -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- ==========================================
                    PAGE CSS
    =========================================== -->

    @yield('styles')

</head>

<body>

    <!-- ==========================================
                    PAGE CONTENT
    =========================================== -->

    @yield('content')

    <!-- ==========================================
                    PAGE JAVASCRIPT
    =========================================== -->

    @yield('scripts')

</body>

</html>