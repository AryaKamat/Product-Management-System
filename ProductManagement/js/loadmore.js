document.getElementById('filterForm').addEventListener('change', function() {
    this.submit();
});

document.getElementById('loadMore').addEventListener('click', function() {
    let nextPage = currentPage + 1;

    if (nextPage <= totalPages) {
        let url = new URL(window.location.href);
        url.searchParams.set('page', nextPage);
        fetch(url)
            .then(response => response.text())
            .then(data => {
                let parser = new DOMParser();
                let doc = parser.parseFromString(data, 'text/html');
                let newProducts = doc.querySelectorAll('#productList .col-md-4');
                let productList = document.getElementById('productList');
                newProducts.forEach(product => productList.appendChild(product));
                if (nextPage >= totalPages) {
                    document.getElementById('loadMore').style.display = 'none';
                }
            });
    }
});
