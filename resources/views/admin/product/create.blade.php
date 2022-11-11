@extends('admin.layout.master')
@section('content')
    <div class="container mt-5">
        <div class="mb-5">
            <form action="" id="form" enctype="multipart/form-data" method="POST">


                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Ürün adı</label>
                            <input class="form-control" type="text" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="">Ürün Markası</label>
                            <input class="form-control" type="text" id="brand" name="brand" required>
                        </div>
                        <div class="form-group">
                            <label for="">Ürün Açıklama</label>
                            <input class="form-control" type="text" id="content" name="content" required>
                        </div>


                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Kategori Seçiniz</label>
                            <select id="category_id" class="form-control text-capitalize" name="category_id">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Cinsiyet Seçiniz</label>
                            <select id="gender" class="form-control text-capitalize" name="gender">
                                <option value="0">Erkek</option>
                                <option value="1">Kız</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Ürün resmi ekle</label>
                            <input class="form-control" type="file" id="image" name="image" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="form-control btn btn-primary">Kaydet</button>

            </form>
        </div>
        <div class="mt-5">


            <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Ürün Foto</th>
                        <th>Ürün adı</th>
                        <th>Kategori</th>
                        <th>Marka</th>
                        <th>Açıklama</th>
                        <th>Cinsiyet</th>
                        <th>Oluşturma Tarihi</th>
                        <th>Ürün ekle</th>
                    </tr>
                </thead>

                <tbody id="tableProduct">
                    @foreach ($products as $product)
                        <tr>
                            <th><img src="{{ asset($product->image) }}" width="200"></th>
                            <th class="text-capitalize">{{ $product->name }}</th>
                            <th class="text-capitalize">{{ $product->category->name }}</th>
                            <th class="text-capitalize">{{ $product->brand }}</th>
                            <th class="text-capitalize">{{ $product->content }}</th>
                            <th class="text-capitalize">
                                @if ($product->gender == 0)
                                    Erkek
                                @elseif ($product->gender == 1)
                                    Kız
                                @endif
                            </th>
                            <th class="text-capitalize">{{ date('d-m-Y', strtotime($product->created_at)) }}</th>
                            <th class="text-capitalize"><a class="btn btn-sm btn-success"
                                    href="{{ route('admin.productDetail', $product->id) }}"><i class="fa fa-plus"></i></a>
                            </th>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                    url: "{{ route('admin.product.store') }}",
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
                    success: function(product) {
                        let array = [product.image, product.name, product.category.name, product
                            .brand, product.content, product.gender, product.created_at
                        ];
                        let tr = document.createElement('tr');
                        array.map(function(value, index) {
                            let th = document.createElement('th');
                            if (index == 0) {
                                let img = document.createElement('img');
                                img.src = 'http://127.0.0.1:8000/' + value;
                                img.width = 200;
                                th.appendChild(img)
                            }
                            if (index == 5) {
                                value = 0 ? th.innerText = "Erkek" : th.innerText =
                                    "Kız";
                            }
                            if (index == 6) {
                                let date = new Date(value);
                                let month = date.getMonth() + 1;
                                let monthDate = month;
                                let fullMonth = `${month}`;
                                if (month.length == 1) {
                                    monthDate = "0" + fullMonth;
                                }
                                value =
                                    `${date.getDate()}-${monthDate}-${date.getFullYear()}`;
                            }
                            if (index != 0) {
                                th.innerText = value;
                                th.classList.add('text-capitalize');
                            }
                            tr.appendChild(th)
                        });
                        let th = document.createElement('th');
                        let a = document.createElement('a');
                        let i = document.createElement('i');
                        a.href = `/admin/product/create/${product.id}`;
                        a.classList.add('btn', 'btn-sm', 'btn-success');
                        i.classList.add('fa', 'fa-plus');
                        a.appendChild(i)
                        th.appendChild(a)
                        tr.appendChild(th)
                        tableProduct.insertBefore(tr, tableProduct.firstChild);
                    },
                    error: function(reject) {
                        console.log(reject)
                    }
                });

                form.reset();

            });
        });
    </script>
@endsection
