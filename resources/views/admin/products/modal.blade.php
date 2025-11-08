<!-- Product Add/Edit Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="productForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="product_id">

                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea class="form-control" name="description" id="description" rows="2"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Qty</label>
                        <input type="number" class="form-control" name="qty" id="qty" required>
                    </div>

                    <div class="mb-3">
                        <label>Price</label>
                        <input type="number" class="form-control" step="0.01" name="price" id="price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="modalBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('modalTitle').innerText = 'Add Product';
    document.getElementById('productForm').action = "{{ route('admin.products.store') }}";
    document.getElementById('product_id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('description').value = '';
    document.getElementById('qty').value = '';
    document.getElementById('price').value = '';

    // Remove previous _method input if exists
    const methodInput = document.querySelector('#productForm input[name="_method"]');
    if(methodInput) methodInput.remove();
}

function openEditModal(product) {
    document.getElementById('modalTitle').innerText = 'Edit Product';
    document.getElementById('productForm').action = '/admin/products/' + product.id;

    let methodInput = document.querySelector('#productForm input[name="_method"]');
    if(!methodInput){
        methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PUT';
        document.getElementById('productForm').appendChild(methodInput);
    }

    document.getElementById('product_id').value = product.id;
    document.getElementById('name').value = product.name;
    document.getElementById('description').value = product.description ?? '';
    document.getElementById('qty').value = product.qty;
    document.getElementById('price').value = product.price;
}
</script>
