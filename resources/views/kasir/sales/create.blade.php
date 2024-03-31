@extends('layouts.my_admin_layout')
@section('title', 'Tambah Transaksi')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Tambah Transaksi</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('kasir.sales.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <?php
                            $tanggal = date('Y-m-d');
                            ?>
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date" required value="{{ $tanggal }}">
                        </div>
                        <div class="mb-3">
                            <label for="customer" class="form-label">Nama Pembeli</label>
                            <input type="text" class="form-control" id="customer" name="customer" required>
                        </div>
                        <div id="menu-item" class="row">
                            <div class="menu row col-12">
                                <div class="col-4 mb-3">
                                    <select class="form-select select2" id="menu" name="menu[]" required onchange="selectChange(this)">
                                        <option value="">Pilih Menu</option>
                                        @foreach ($menu as $menu)
                                            <option value="{{ $menu->id }}">{{ $menu->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-2 mb-3">
                                    <input type="number" class="form-control qty" id="qty" name="qty[]" required placeholder="qty" onchange="qtyChange(this)">
                                </div>

                                <div class="col-3 my-auto">
                                    <p class="" id="price">@ Rp. 0</p>
                                </div>
                                <div class="my-auto col-3">
                                    <p class="fw-bold" id="total">Total: Rp. 0</p>
                                </div>

                                <input type="hidden" name="cukup[]" value="tidak" class="cukup">
                                <div class="col-12 mb-2">
                                    <a href="javascript:void(0)" id="delete-menu" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i> Hapus Menu</a>
                                    <a href="javascript:void(0)" id="cek-stok" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Cek Stok</a>
                                    <span class="result"></span>
                                </div>
                            </div>

                        </div>
                        <div class="col-12">
                            <a href="javascript:void(0)" id="add-menu" class="btn btn-primary"><i class="fa fa-plus fa-fw"></i> Tambah Menu</a>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a class="btn my-bg text-white p-2 px-4" href="javascript:void(0)" id="submit"><i class="fa fa-save fa-fw"></i> Simpan</a>
                            <button type="submit" class="d-none btn my-bg text-white p-2 px-4 ms-2" id="sbHidden"><i class="fa fa-save"></i></i> Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
<script>
    function selectChange(selectElement) {
        var id = $(selectElement).val();
        var menu_exists = false;
        var price_ = $(selectElement).parent().parent().find('#price');
        var menu = {!! $menu_jquery !!};
        var menu_dobel = [];


        //ambil semua id menu yang sudah dipilih
        $('.select2').each(function() {
            var id = $(this).val();
            if(menu_dobel.includes(id)){
                alert('Menu tidak boleh sama');
                $(this).val('');
                return false;
            }
            menu_dobel.push(id);
        });


        for (var i = 0; i < menu.length; i++) { // Perbaiki variabel 'length'
            if (menu[i].id == id) {
                var price = menu[i].price;
                //format rupiah
                var formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                });
                price = formatter.format(price);
                price_.text('@ Rp. ' + price);
                break;
            }
        }

    }
</script>
<script>
    function qtyChange(inputElement) {
        var menu = {!! $menu_jquery !!};
        var qty = $(inputElement).val();
        var id = $('#menu').val();
        var total = $(inputElement).parent().parent().find('#total');
        console.log(id);
        for (var i = 0; i < menu.length; i++) {
            if (menu[i].id == id) {
                var price = menu[i].price;
                price = price * qty;
                var formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                });
                total.text('Total: Rp. ' + (formatter.format(price)));
                break;
            }
        }
    }
</script>

    <script>
        $(document).ready(function() {
            var menu = {!! $menu_jquery !!}
            var length = menu.length;
            var nomor=1;
            console.log(menu);
            $('.select2').select2();

            $('#add-menu').on('click', function() {
                var menu = {!! $menu_jquery !!}
                var length = menu.length;
                var html = `
                    <div class="menu row col-12">
                    <div class="col-4 mb-3">
                        <select class="form-select select2 select${nomor}" id="menu" name="menu[]" required onchange="selectChange(this)">
                            <option value="">Pilih Menu</option>
                `;
                for (var i = 0; i < length; i++) {
                    html += `<option value="${menu[i].id}">${menu[i].name}</option>`;
                }
                html += `</select></div>
                    <div class="col-2 mb-3">
                        <input type="number" class="form-control qty" id="qty" name="qty[]" required placeholder="qty" onchange="qtyChange(this)">
                    </div>
                    <div class="col-3 my-auto">
                        <p class="" id="price">@ Rp. 0</p>
                    </div>
                    <div class="my-auto col-3">
                        <p class="fw-bold" id="total">Total: Rp. 0</p>
                    </div>
                    <input type="hidden" name="cukup[]" value="tidak" class="cukup">
                    <div class="col-12 mb-2">
                        <a href="javascript:void(0)" id="delete-menu" class="btn btn-danger"><i class="fa fa-trash fa-fw"></i> Hapus Menu</a>
                        <a href="javascript:void(0)" id="cek-stok" class="btn btn-primary"><i class="fa fa-check fa-fw"></i> Cek Stok</a>
                        <span class="result"></span>
                    </div>
                </div>
                `;
                $('#menu-item').append(html);
                $('.select' + nomor).select2();
                nomor++;
            });

            $('#menu-item').on('click', '#delete-menu', function() {
                $(this).parent().parent().remove();
            });

            $('#menu-item').on('click', '#cek-stok', function() {
                var id = $(this).parent().parent().find('select').val();
                var qty = $(this).parent().parent().find('input').val();
                var result = $(this).parent().find('.result');
                $.ajax({
                    url: "{{ route('kasir.sales.checkStock') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        qty: qty
                    },
                    success: function(data) {
                        result.html(data.message);
                        if(data.status == true){
                            result.parent().parent().find('.cukup').val('cukup');
                        }else{
                            result.parent().parent().find('.cukup').val('tidak');
                        }
                    }
                });
            });

            $("#submit").on('click', function(event) {
                event.preventDefault(); // Mencegah default behavior dari tombol submit
                var menu_dobel = [];


                //ambil semua id menu yang sudah dipilih
                $('.select2').each(function() {
                    var id = $(this).val();
                    if(menu_dobel.includes(id)){
                        alert('Menu tidak boleh sama');
                        $(this).val('');
                        return false;
                    }
                    menu_dobel.push(id);
                });

                var cukup = $('.cukup');
                var length = cukup.length;
                for (var i = 0; i < length; i++) {
                    if (cukup[i].value == 'tidak') {
                        alert('Stok tidak cukup');
                        return false;
                    }
                }
                $('#sbHidden').click();
            });

        });

    </script>
@endsection
