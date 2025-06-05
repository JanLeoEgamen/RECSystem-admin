@if(Session::has('success'))
    <div id="flash-message" class="bg-green-200 border-green-600 p-4 mb-3 rounded-sm shadow-sm transition-opacity duration-700">
        {{ Session::get('success') }}
    </div>
@endif

@if(Session::has('error'))
    <div id="flash-message" class="bg-red-200 border-red-600 p-4 mb-3 rounded-sm shadow-sm transition-opacity duration-700">
        {{ Session::get('error') }}
    </div>
@endif

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const flash = document.getElementById('flash-message');
        if (flash) {
            setTimeout(() => {
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 700); // remove after fade out
            }, 4000); // 4 seconds visible
        }
    });
</script>
