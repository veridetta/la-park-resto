@extends('layouts.my_admin_layout')
@section('title', 'Dashboard')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            <h1 class="mb-4 fw-bold my-text-color">Selamat Datang, {{ Auth::user()->name }}</h1>

        </div>
    </main>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });

    </script>
@endsection
