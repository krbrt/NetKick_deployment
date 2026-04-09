<form :action="'{{ url('admin/products/update') }}/' + currentProduct.id" method="POST">
    @csrf
    @method('PUT')