
    // Hàm Load More
    function loadMore() {
        let page = parseInt(document.getElementById('page').value);
        page++;
        document.getElementById('page').value = page; // Cập nhật số trang

        // Gửi request với Fetch API
        fetch("{{ route('products.loadMore') }}?page=" + page)
            .then(response => response.json())
            .then(data => {
                // Nếu có dữ liệu HTML, thêm vào
                if (data.html) {
                    document.getElementById('loadProduct').innerHTML += data.html;
                }

                // Kiểm tra nếu không còn sản phẩm để load, ẩn nút "Load More"
                if (!data.hasMore) {
                    document.getElementById('button-loadMore').style.display = 'none';
                }
            })
            .catch(error => console.error('Error:', error)); // Xử lý lỗi
    }