@if (session('success'))

    <script>
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: "{{ session('success') }}",
            timeout: 1000,
            killer: true
        }).show();
    </script>

@endif


@if (session('errormsg'))

    <script>
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: "{{ session('errormsg') }}",
            timeout: 1000,
            killer: true
        }).show();
    </script>

@endif