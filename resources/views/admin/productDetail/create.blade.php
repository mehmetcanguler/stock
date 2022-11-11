@extends('admin.layout.master')
@section('content')
    <div class="container mt-5">
        <div class="row">


            <div class="col-4">
                <div class="mr-2">
                    <form action="" method="POST" id="form">
                        @csrf
                        <div class="form-group">
                            <label for="">Beden</label>
                            <select name="size" id="size" class="form-control text-capitalize">
                                @foreach ($years as $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Renk</label>
                            <select class="form-control text-capitalize" id="colour" name="colour">
                                @foreach ($colours as $color)
                                    <option value="{{ $color }}">{{ $color }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Fiyat</label>
                            <input class="form-control" type="number" id="price" name="price" required>
                        </div>
                        <div class="form-group">
                            <label for="">Adet</label>
                            <input class="form-control" type="number" id="qty" name="qty" required>
                        </div>
                </div>
                <div class="form-group">
                    <input type="hidden" name="product_id" value="{{ $product_id }}">
                    <button type="submit" class="form-control btn btn-primary">Kaydet</button>
                </div>
                </form>
            </div>
            <div class="col-8">
                <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Barkod</th>
                            <th>Ürün adı</th>
                            <th>Renk</th>
                            <th>Beden</th>
                            <th>Fiyat</th>
                            <th>Adet</th>
                        </tr>
                    </thead>

                    <tbody id="tableProduct">
                        @foreach ($productDetail as $value)
                            <tr class="tr">
                                <th>{{ $value->barcode }}</th>
                                <th class="text-capitalize product_name">{{ $value->product->name }}</th>
                                <th class="text-capitalize colour">{{ $value->colour }}</th>
                                <th class="text-capitalize size">{{ $value->size }}</th>
                                <th class="text-capitalize price">{{ $value->price }}</th>
                                <th class="text-capitalize qty">{{ $value->qty }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#form').on('submit', function(event) {
                event.preventDefault();
                let tableProduct = document.querySelector('#tableProduct');
                $.ajax({
                    url: "{{ route('admin.productDetail.store') }}",
                    method: "POST",
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    enctype: 'multipart/form-data',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(productDetail) {
                        let product_name = document.querySelectorAll('.product_name');
                        let colour = document.querySelectorAll('.colour');
                        let size = document.querySelectorAll('.size');
                        let qty = document.querySelectorAll('.qty');
                        let trClass = document.querySelectorAll('.tr');
                     
                        for(let i = 0; i< product_name.length ; i++)
                        {
                            let productDetail_name =productDetail.product.name.toLowerCase();
                            let productDetail_colour =productDetail.colour.toLowerCase();
                            let productDetail_size =productDetail.size.toLowerCase();
                            if(product_name[i].innerText.toLowerCase() == productDetail_name && colour[i].innerText.toLowerCase() == productDetail_colour && size[i].innerText.toLowerCase() == productDetail_size)
                            {
                                console.log(trClass[2]);
                            }

                        }

                        let array = [productDetail.barcode, productDetail.product.name,
                            productDetail.colour, productDetail.size, productDetail.price,
                            productDetail.qty
                        ];
                        let tr = document.createElement('tr');
                        array.map(function(value, index) {
                            let th = document.createElement('th');
                            th.innerText = value;
                            if (index != 0) {
                                th.classList.add('text-capitalize');
                            }

                            tr.appendChild(th)
                            if (index == 1) {
                                th.classList.add('product_name')
                            }
                            if (index == 2) {
                                th.classList.add('colour')
                            }
                            if (index == 3) {
                                th.classList.add('size')
                            }
                        })
                        tableProduct.appendChild(tr)
                        // tableProduct.insertBefore(tr, tableProduct.firstChild);

                    },
                    error: function(reject) {
                        console.log(reject)
                    }
                });

                form.reset();

            });
        })
    </script>
@endsection
