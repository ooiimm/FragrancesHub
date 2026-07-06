@if ($paginator->hasPages())
<nav aria-label="Navigasi halaman">
    <ul class="pagination justify-content-center mb-0" style="gap:6px;">

        {{-- Tombol Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <li>
                <span style="
                    display:inline-flex;align-items:center;justify-content:center;
                    width:38px;height:38px;border-radius:10px;
                    background:#f3f4f6;color:#d1d5db;cursor:not-allowed;font-size:.9rem;">
                    <i class="bi bi-chevron-left"></i>
                </span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" style="
                    display:inline-flex;align-items:center;justify-content:center;
                    width:38px;height:38px;border-radius:10px;
                    background:#fff;color:#14532d;border:1.5px solid #e5e7eb;
                    font-size:.9rem;text-decoration:none;
                    transition:all .2s ease;"
                   onmouseover="this.style.background='#14532d';this.style.color='#fff';this.style.borderColor='#14532d';"
                   onmouseout="this.style.background='#fff';this.style.color='#14532d';this.style.borderColor='#e5e7eb';">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
        @endif

        {{-- Nomor Halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li>
                    <span style="
                        display:inline-flex;align-items:center;justify-content:center;
                        width:38px;height:38px;border-radius:10px;
                        color:#9ca3af;font-size:.9rem;letter-spacing:1px;">
                        ···
                    </span>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li>
                            <span style="
                                display:inline-flex;align-items:center;justify-content:center;
                                width:38px;height:38px;border-radius:10px;
                                background:linear-gradient(135deg,#0B3D2E,#14532D);
                                color:#fff;font-weight:700;font-size:.88rem;
                                box-shadow:0 3px 10px rgba(11,61,46,0.3);">
                                {{ $page }}
                            </span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $url }}" style="
                                display:inline-flex;align-items:center;justify-content:center;
                                width:38px;height:38px;border-radius:10px;
                                background:#fff;color:#374151;border:1.5px solid #e5e7eb;
                                font-size:.88rem;text-decoration:none;
                                transition:all .2s ease;"
                               onmouseover="this.style.background='#f0fdf4';this.style.color='#14532d';this.style.borderColor='#14532d';"
                               onmouseout="this.style.background='#fff';this.style.color='#374151';this.style.borderColor='#e5e7eb';">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Tombol Berikutnya --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" style="
                    display:inline-flex;align-items:center;justify-content:center;
                    width:38px;height:38px;border-radius:10px;
                    background:#fff;color:#14532d;border:1.5px solid #e5e7eb;
                    font-size:.9rem;text-decoration:none;
                    transition:all .2s ease;"
                   onmouseover="this.style.background='#14532d';this.style.color='#fff';this.style.borderColor='#14532d';"
                   onmouseout="this.style.background='#fff';this.style.color='#14532d';this.style.borderColor='#e5e7eb';">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        @else
            <li>
                <span style="
                    display:inline-flex;align-items:center;justify-content:center;
                    width:38px;height:38px;border-radius:10px;
                    background:#f3f4f6;color:#d1d5db;cursor:not-allowed;font-size:.9rem;">
                    <i class="bi bi-chevron-right"></i>
                </span>
            </li>
        @endif

    </ul>
</nav>
@endif
