<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Prediksi Pupuk')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @yield('styles')

    @yield('scripts')

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        html{
            scroll-behavior:smooth;
        }

        body{

            margin:0;

            background:#f3f4f6;

            color:#1f2937;

            overflow-x:hidden;

        }

        a{
            text-decoration:none;
        }

        /* ======================================================
                        SIDEBAR
        ====================================================== */

        .sidebar{

            position:fixed;

            top:0;

            left:0;

            width:250px;

            height:100vh;

            background:#0B1C14;

            display:flex;

            flex-direction:column;

            box-shadow:2px 0 10px rgba(0,0,0,.08);

            overflow:hidden;

            z-index:999;

        }

        .sidebar::-webkit-scrollbar{

            width:6px;

        }

        .sidebar::-webkit-scrollbar-thumb{

            background:#2b5645;

            border-radius:10px;

        }

        /* ======================================================
                        HEADER SIDEBAR
        ====================================================== */

        .sidebar-header{

            padding:26px 20px;

            border-bottom:1px solid rgba(255,255,255,.05);

        }

        .logo-wrap{

            display:flex;

            align-items:center;

            gap:14px;

        }

        .logo-circle{

            width:55px;

            height:55px;

            border-radius:12px;

            background:transparent;

            display:flex;

            align-items:center;

            justify-content:center;

            color:white;

            font-weight:bold;

            font-size:15px;

            box-shadow:none;

            flex-shrink:0;

            overflow:hidden;

        }

        .logo-circle img{

            width:60px;

            height:60px;

            object-fit:contain;

            display:block;

        }

        .logo-text h2{

            color:#fff;

            font-size:14px;

            font-weight:700;

            line-height:1.3;

        }

        .logo-text p{

            color:#9ca3af;

            font-size:10px;

            margin-top:3px;

        }

        /* ======================================================
                        MENU
        ====================================================== */

        .nav-section{
            flex:1;
            padding:15px 14px;
        }

        .nav-label{

            color:#6b7280;

            font-size:10px;

            text-transform:uppercase;

            letter-spacing:2px;

            font-weight:bold;

            margin:14px 12px 4px;

        }

        .nav-label:first-child{

            margin-top:0;

        }

        .sidebar a{

            display:flex;

            align-items:center;

            gap:12px;

            padding:12px 14px;

            margin-bottom:5px;

            border-radius:10px;

            color:#9ca3af;

            font-size:13px;

            transition:.25s;

        }

        .sidebar a i{

            width:18px;

            text-align:center;

            font-size:16px;

            transition:.25s;

        }

        .sidebar a:hover{

            background:rgba(255,255,255,.05);

            color:#fff;

            transform:translateX(3px);

        }

        .sidebar a:hover i{

            color:#10B981;

        }

        .sidebar a.active{

            background:linear-gradient(
            135deg,
            #059669,
            #047857
            );

            color:#fff;

            font-weight:600;

            box-shadow:0 5px 12px rgba(0,0,0,.18);

        }

        .sidebar a.active i{

            color:white;

        }

        /* ======================================================
                    FOOTER SIDEBAR
        ====================================================== */

        .sidebar-footer{

            margin-top:auto;

            transform: translateY(-12px);

            padding:16px 14px;

            border-top:1px solid rgba(255,255,255,.05);

        }

        .user-card{

            display:flex;

            align-items:center;

            gap:12px;

            background:rgba(255,255,255,.05);

            border:1px solid rgba(255,255,255,.04);

            padding:14px;

            border-radius:14px;

            color:white;

            transition:.25s;

        }

        .user-card:hover{

            background:rgba(255,255,255,.08);

            transform:translateY(-2px);

        }

        .user-card i{

            margin-left:auto;

            color:#9ca3af;

            font-size:12px;

        }        

        .user-avatar{

            width:38px;

            height:38px;

            border-radius:50%;

            background:linear-gradient(
            135deg,
            #059669,
            #047857
            );
            display:flex;

            align-items:center;

            justify-content:center;

            color:white;

            font-weight:bold;

        }

        .user-info p{

            color:white;

            font-size:13px;

            font-weight:bold;

        }

        .user-info span{

            color:#9ca3af;

            font-size:11px;

        }

        .logout-btn{

            width:100%;

            margin-top:8px;

            padding:11px;

            border:none;

            border-radius:8px;

            cursor:pointer;

            background:#dc2626;

            color:white;

            font-size:13px;

            font-weight:600;

            transition:.25s;

        }

        .logout-btn:hover{

            background:#b91c1c;

        }

        /* ======================================================
                        LAYOUT & CONTENT
        ====================================================== */

        .content{
            margin-left:250px;
            width:calc(100% - 250px);
            min-height:100vh;
            padding:34px;
            background:#f5f7fb;
            overflow-x:auto;
        }


        /* ======================================================
                            PAGE COMPONENT
        ====================================================== */

        .page-header{
            display:flex;
            justify-content:space-between;
            align-items:flex-start;
            gap:20px;
            margin-bottom:30px;
            flex-wrap:wrap;
        }

        .page-title-group{
            display:flex;
            flex-direction:column;
            gap:8px;
        }

        .page-title{
            font-size:34px;
            font-weight:700;
            color:#1f2937;
            line-height:1.2;
            letter-spacing:-.5px;
            margin:0;
        }

        .page-subtitle{
            font-size:14px;
            color:#6b7280;
            line-height:1.6;
            margin:0;
        }

        .page-toolbar{
            display:flex;
            align-items:center;
            justify-content:flex-end;
            gap:12px;
            flex-wrap:wrap;
        }

        .page-toolbar form{
            display:flex;
            justify-content:flex-end;
            align-items:flex-end;
            gap:20px;
            flex-wrap:wrap;
        }

        .page-toolbar .form-select{
            min-width:160px;
        }


        /* ======================================================
                            SECTION
        ====================================================== */

        .section-title{
            font-size:18px;
            font-weight:600;
            color:#1f2937;
            margin-bottom:18px;
        }

        .section-divider{
            width:100%;
            height:1px;
            background:#e5e7eb;
            margin:24px 0;
        }


        /* ======================================================
                            SEARCH BOX
        ====================================================== */

        .search-box{
            position:relative;
            width:320px;
            min-width:320px;
        }

        .search-box i{
            position:absolute;
            left:15px;
            top:50%;
            transform:translateY(-50%);
            color:#9ca3af;
            font-size:14px;
            pointer-events:none;
        }

        .search-box input{
            width:100%;
            height:44px;
            padding:0 16px 0 42px;
            border:1px solid #d1d5db;
            border-radius:10px;
            background:#ffffff;
            font-size:14px;
            transition:all .25s ease;
        }

        .search-box input::placeholder{
            color:#9ca3af;
        }

        .search-box input:focus{
            outline:none;
            border-color:#15803d;
            box-shadow:0 0 0 4px rgba(21,128,61,.10);
        }


        /* ======================================================
                            PAGE INFO
        ====================================================== */

        .page-info{
            display:flex;
            align-items:center;
            gap:10px;
            font-size:13px;
            color:#6b7280;
        }

        .page-info i{
            color:#15803d;
        }


        /* ======================================================
                            BREADCRUMB
        ====================================================== */

        .breadcrumb{
            display:flex;
            align-items:center;
            gap:8px;
            margin-bottom:14px;
            font-size:13px;
            color:#6b7280;
        }

        .breadcrumb a{
            color:#15803d;
            text-decoration:none;
            transition:.2s;
        }

        .breadcrumb a:hover{
            color:#166534;
        }

        .breadcrumb span{
            color:#9ca3af;
        }

        /* ======================================================
                            CARD
        ====================================================== */

        .card{
            background:#ffffff;
            border:1px solid #eef2f7;
            border-radius:18px;
            padding:28px;
            box-shadow:0 8px 24px rgba(15,23,42,.05);
            transition:all .25s ease;
        }

        .card:hover{
            box-shadow:0 12px 30px rgba(15,23,42,.08);
        }

        .card-header{
            display:flex;
            justify-content:space-between;
            align-items:center;
            gap:20px;
            margin-bottom:22px;
            flex-wrap:wrap;
        }

        .card-title{
            font-size:20px;
            font-weight:700;
            color:#1f2937;
        }

        .card-subtitle{
            font-size:14px;
            color:#6b7280;
            margin-top:4px;
        }

        .card-body{
            width:100%;
        }


        /* ======================================================
                        TABLE RESPONSIVE
        ====================================================== */

        .table-responsive{
            width:100%;
            overflow-x:auto;
            border-radius:14px;
        }


        /* ======================================================
                        TABLE MODERN
        ====================================================== */

        .table-modern{
            width:100%;
            border-collapse:collapse;
            background:#ffffff;
            min-width:700px;
        }

        .table-modern thead th{

            background:#18452f;

            color:#ffffff;

            padding:15px;

            text-align:left;

            font-size:13px;

            font-weight:600;

            letter-spacing:.3px;

            white-space:nowrap;

        }

        .table-modern tbody td{

            padding:15px;

            border-bottom:1px solid #eef2f7;

            color:#374151;

            font-size:13px;

            vertical-align:middle;

        }

        .table-modern tbody tr{

            transition:.2s;

        }

        .table-modern tbody tr:hover{

            background:#f8fafc;

        }

        .table-modern tbody tr:last-child td{

            border-bottom:none;

        }

        .table-modern tbody td strong{

            color:#111827;

            font-weight:700;

        }


        /* ======================================================
                        TABLE ALIGNMENT
        ====================================================== */

        .text-center{

            text-align:center;

        }

        .text-right{

            text-align:right;

        }

        .text-left{

            text-align:left;

        }


        /* ======================================================
                        TABLE STATUS
        ====================================================== */

        .table-id{

            font-weight:700;

            color:#18452f;

        }

        .table-muted{

            color:#9ca3af;

        }


        /* ======================================================
                        ACTION GROUP
        ====================================================== */

        .action-group{

            display:flex;

            align-items:center;

            gap:8px;

            flex-wrap:wrap;

        }


        /* ======================================================
                            BADGE
        ====================================================== */

        .badge{

            display:inline-flex;

            align-items:center;

            justify-content:center;

            padding:6px 12px;

            border-radius:999px;

            font-size:12px;

            font-weight:600;

            line-height:1;

        }

        .badge-primary{

            background:#dbeafe;

            color:#1d4ed8;

        }

        .badge-success{

            background:#dcfce7;

            color:#166534;

        }

        .badge-warning{

            background:#fef3c7;

            color:#92400e;

        }

        .badge-danger{

            background:#fee2e2;

            color:#991b1b;

        }

        .badge-secondary{

            background:#f3f4f6;

            color:#4b5563;

        }


        /* ======================================================
                        EMPTY STATE
        ====================================================== */

        .empty-state{

            padding:60px 20px;

            text-align:center;

        }

        .empty-state i{

            font-size:56px;

            color:#d1d5db;

            margin-bottom:18px;

        }

        .empty-state h3{

            font-size:20px;

            color:#374151;

            margin-bottom:10px;

        }

        .empty-state p{

            color:#6b7280;

            font-size:14px;

            margin-bottom:20px;

        }

        /* ======================================================
                            BUTTON
        ====================================================== */

        .btn{

            display:inline-flex;

            align-items:center;

            justify-content:center;

            gap:8px;

            padding:10px 18px;

            border:none;

            border-radius:10px;

            cursor:pointer;

            text-decoration:none;

            font-size:13px;

            font-weight:600;

            transition:all .25s ease;

            white-space:nowrap;

        }

        .btn:hover{

            transform:translateY(-1px);

        }

        .btn-primary{

            background:#15803d;

            color:#ffffff;

        }

        .btn-primary:hover{

            background:#166534;

        }

        .btn-success{

            background:#16a34a;

            color:#ffffff;

        }

        .btn-success:hover{

            background:#15803d;

        }

        .btn-warning{

            background:#f59e0b;

            color:#ffffff;

        }

        .btn-warning:hover{

            background:#d97706;

        }

        .btn-danger{

            background:#dc2626;

            color:#ffffff;

        }

        .btn-danger:hover{

            background:#b91c1c;

        }

        .btn-secondary{

            background:#6b7280;

            color:#ffffff;

        }

        .btn-secondary:hover{

            background:#4b5563;

        }


        /* ======================================================
                            FORM
        ====================================================== */

        .form-group{

            margin-bottom:20px;

        }

        .form-label{

            display:block;

            margin-bottom:8px;

            font-size:14px;

            font-weight:600;

            color:#374151;

        }

        .form-control,
        .form-select{

            width:100%;

            height:46px;

            padding:0 14px;

            border:1px solid #d1d5db;

            border-radius:10px;

            background:#ffffff;

            font-size:14px;

            transition:all .25s ease;

        }

        textarea.form-control{

            min-height:120px;

            padding:14px;

            resize:vertical;

        }

        .form-control:focus,
        .form-select:focus{

            outline:none;

            border-color:#15803d;

            box-shadow:0 0 0 4px rgba(21,128,61,.10);

        }


        /* ======================================================
                            ALERT
        ====================================================== */

        .alert{

            padding:14px 18px;

            border-radius:10px;

            margin-bottom:20px;

            border-left:5px solid;

            box-shadow:0 4px 12px rgba(0,0,0,.04);

        }

        .alert-success{

            background:#dcfce7;

            color:#166534;

            border-color:#16a34a;

        }

        .alert-danger{

            background:#fee2e2;

            color:#991b1b;

            border-color:#dc2626;

        }

        .alert-warning{

            background:#fef3c7;

            color:#92400e;

            border-color:#f59e0b;

        }

        .alert-info{

            background:#dbeafe;

            color:#1d4ed8;

            border-color:#2563eb;

        }


        /* ======================================================
                            UTILITY
        ====================================================== */

        .d-flex{

            display:flex;

        }

        .align-center{

            align-items:center;

        }

        .justify-between{

            justify-content:space-between;

        }

        .gap-1{

            gap:8px;

        }

        .gap-2{

            gap:16px;

        }

        .w-100{

            width:100%;

        }

        .mb-1{

            margin-bottom:8px;

        }

        .mb-2{

            margin-bottom:16px;

        }

        .mb-3{

            margin-bottom:24px;

        }

        .mt-1{

            margin-top:8px;

        }

        .mt-2{

            margin-top:16px;

        }

        .mt-3{

            margin-top:24px;

        }

        .text-center{

            text-align:center;

        }

        .text-right{

            text-align:right;

        }

        .text-muted{

            color:#6b7280;

        }


        /* ======================================================
                            RESPONSIVE
        ====================================================== */

        @media(max-width:992px){

            .content{

                padding:24px;

            }

        }

        @media(max-width:768px){

            .content{

                margin-left:0;

                width:100%;

                padding:20px;

            }

            .page-header{

                flex-direction:column;

                align-items:flex-start;

            }

            .page-toolbar{

                width:100%;

                flex-direction:column;

                align-items:stretch;

            }

            .search-box{

                width:100%;

                min-width:100%;

            }

            .card{

                padding:20px;

            }

            .action-group{

                flex-direction:column;

                align-items:stretch;

            }

            .action-group .btn{

                width:100%;

            }

        }

        @media(max-width:576px){

            .page-title{

                font-size:28px;

            }

            .btn{

                width:100%;

            }

        }

        /*==================================================
                    DASHBOARD DESIGN SYSTEM
        ==================================================*/

        /* Grid Statistik */

        .dashboard-stats{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
            gap:24px;
            margin:30px 0;
        }

        /* Card Statistik */

        .stat-card{

            border:none;

            border-radius:18px;

            box-shadow:0 5px 18px rgba(0,0,0,.06);

            transition:.25s ease;

        }

        .stat-card:hover{

            transform:translateY(-4px);

            box-shadow:0 12px 30px rgba(0,0,0,.10);

        }

        .stat-card .card-body{

            padding:0px;

        }

        .stat-header{

            display:flex;

            align-items:flex-start;

            gap:18px;

            margin-bottom:18px;

        }

        /* Icon */

        .stat-icon{

            width:48px;

            height:48px;

            border-radius:16px;

            display:flex;

            justify-content:center;

            align-items:center;

            color:#fff;

            font-size:18px;

            margin-bottom:14px;

            flex-shrink:0;

        }

        /* Warna */

        .bg-success{
            background:#16a34a;
        }

        .bg-primary{
            background:#2563eb;
        }

        .bg-warning{
            background:#f59e0b;
        }

        .bg-danger{
            background:#dc2626;
        }

        .stat-content{
            flex:1;
        }

        /* Judul */

        .stat-title{

            font-size:15px;

            font-weight:600;

            color:#374151;

            margin-bottom:8px;

        }

        /* Nilai */

        .stat-value{

            font-size:28px;

            line-height:1;

            font-weight:700;

            color:#111827;

        }

        /* Footer */

        .stat-description{

            margin-top:18px;

            color:#6b7280;

            font-size:14px;

            line-height:1.6;

        }

        /*==================================================
                            CHART
        ==================================================*/

        .chart-container{
            position:relative;
            width:100%;
            height:340px;
        }

        .card-header .card-title i{
            color:#16a34a;
            margin-right:8px;
        }

        /*==================================================
                        SUMMARY
        ==================================================*/

        .dashboard-summary{
            display:grid;
            grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
            gap:20px;
            margin-top:25px;
        }

        /* Card */

        .summary-card{
            border:none;
            border-radius:18px;
            transition:.25s;
            box-shadow:0 4px 18px rgba(0,0,0,.06);
        }

        .summary-card:hover{
            transform:translateY(-5px);
            box-shadow:0 10px 24px rgba(0,0,0,.10);
        }

        .summary-card .card-body{
            padding:22px;
        }

        /* Header */

        .summary-header{
            display:flex;
            align-items:center;
            gap:15px;
            margin-bottom:18px;
        }

        /* Icon */

        .summary-icon{
            width:50px;
            height:50px;
            border-radius:14px;
            background:#ecfdf5;
            color:#16a34a;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:22px;
        }

        /* Judul */

        .summary-title{
            font-size:13px;
            font-weight:600;
            color:#374151;
        }

        .summary-subtitle{
            font-size:13px;
            color:#9ca3af;
            margin-top:3px;
        }

        /* Nilai */

        .summary-value{
            font-size:30px;
            font-weight:700;
            color:#111827;
            margin-bottom:12px;
            line-height:1.2;
            word-break:break-word;
        }

        /* Footer */

        .summary-footer{
            border-top:1px solid #e5e7eb;
            padding-top:12px;
            color:#6b7280;
            font-size:13px;
        }

        /*=====================================
                FILTER TAHUN
        =====================================*/

        .year-filter{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .year-label{
            font-size:15px;
            font-weight:600;
            color:#374151;
            white-space:nowrap;
        }

        .year-filter .form-select{
            width:100px;
            min-width:100px;
        }

        /* =====================================================
                        FLASH ALERT
        ===================================================== */

        .alert{

            display:flex;

            align-items:center;

            gap:15px;

            padding:16px 20px;

            margin:20px 0;

            border-radius:14px;

            font-size:15px;

            font-weight:500;

            animation:fadeAlert .3s ease;

        }

        .alert i:first-child{

            font-size:18px;

        }

        .alert span{

            flex:1;

        }

        /* ================= SUCCESS ================= */

        .alert-success{

            background:#ECFDF5;

            border:1px solid #A7F3D0;

            color:#065F46;

        }

        /* ================= WARNING ================= */

        .alert-warning{

            background:#FFFBEB;

            border:1px solid #FDE68A;

            color:#92400E;

        }

        /* ================= CLOSE ================= */

        .alert-close{

            border:none;

            background:none;

            cursor:pointer;

            color:inherit;

            font-size:18px;

            opacity:.7;

            transition:.25s;

        }

        .alert-close:hover{

            opacity:1;

        }

        /* ================= ANIMATION ================= */

        @keyframes fadeAlert{

            from{

                opacity:0;

                transform:translateY(-8px);

            }

            to{

                opacity:1;

                transform:translateY(0);

            }

        }

    </style>

</head>
<body>
    
    @if(auth()->user()->role == 'admin')

        @include('layouts.partials.sidebar-admin')

    @elseif(auth()->user()->role == 'pemilik')

        @include('layouts.partials.sidebar-pemilik')

    @endif



    <!-- =========================
            CONTENT
    ========================== -->

    <div class="content">

        @yield('content')
        </div>

    <!-- ==========================================
                    JAVASCRIPT
    =========================================== -->

    <script src="{{ asset('js/live-search.js') }}"></script>

    <script src="{{ asset('js/chart.umd.min.js') }}"></script>

    <script src="{{ asset('js/flash-alert.js') }}"></script>

</body>
</html>