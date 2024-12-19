function removeCategory(id) {
    if (confirm('Bạn có chắc chắn muốn xoá danh mục này không?')) {
        fetch('/admin/category/destroy/' + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        })
        .then(response => {
            if (response.ok) {
                alert('Xoá thành công!');
                location.reload();
            } else {
                alert('Xoá thất bại!');
            }
        });
    }
}


document.getElementById('upload').addEventListener('change', function () {
    var file = this.files[0]; // Lấy file được chọn bởi người dùng
    var formData = new FormData();
    formData.append('file', file); // Thêm file vào formData

    // Lấy URL của route upload từ meta tag
    var uploadUrl = document.querySelector('meta[name="upload-route"]').getAttribute('content');
    
    fetch(uploadUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: formData
    })
    .then(response => response.json())
    .then(results => {
        if (results.error === false) {

            var baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
           // Nếu URL trả về là dạng /uploads/xxx.jpg, ta cần thêm domain trước để tạo thành URL hoàn chỉnh
           var fullUrl = baseUrl + results.url;

           // Hiển thị ảnh đã upload
           document.getElementById('image_show').innerHTML = `<a href="${fullUrl}" target="_blank"><img src="${fullUrl}" width="100px"></a>`;
            // Lưu URL của ảnh vào input hidden
            document.getElementById('thumb').value = results.url;
        } else {
            alert('Có lỗi xảy ra khi upload file');
        }
    })
    .catch(error => {
        alert('Có lỗi xảy ra khi upload file.');
        console.error(error);
    });
});
