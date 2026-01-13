<div>
    <a href="{{ $link }}" 
        class="btn text-base font-medium hover:bg-blue-700" 
        target="_blank" 
        aria-current="page">
        {{ $slot ?? 'Action' }}
     </a>
</div>