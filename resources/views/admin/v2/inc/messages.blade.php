@if (session('success'))
    <div x-data="{ show: true }" x-show="show" @click.away="show = false"
        class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg flex justify-between items-center"
        role="alert">
        <div class="flex items-center">
            <strong class="mr-2">Success!</strong> {{ session('success') }}
        </div>
        <button @click="show = false" class="btnCloseMessage text-green-500 hover:text-green-700" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session('warning'))
    <div x-data="{ show: true }" x-show="show" @click.away="show = false"
        class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded-lg flex justify-between items-center"
        role="alert">
        <div class="flex items-center">
            <strong class="mr-2">Warning!</strong> {{ session('warning') }}
        </div>
        <button @click="show = false" class="btnCloseMessage text-yellow-500 hover:text-yellow-700" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<script>
    $('.btnCloseMessage').click(function(e) {
        $(this).parent().remove();
    })
</script>
