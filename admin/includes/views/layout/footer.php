</div>
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright © 2024 All Rights Design by Club Thịt Chó Bách Khoa</p>
    </div>
</footer>
<!-- Bootstrap JS và jQuery -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Toastr -->
<script src="/resources/js/toastr.min.js"></script>
<link rel="stylesheet" href="/resources/css/toastr.min.css">

<script>
    // Hàm hiển thị toast
    function showToast(type, message) {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "timeOut": "3000",
        };
        if (type === 'success') {
            toastr.success(message);
        } else if (type === 'error') {
            toastr.error(message);
        }
    }
</script>

</body>

</html>