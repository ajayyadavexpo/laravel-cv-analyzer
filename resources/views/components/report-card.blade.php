@props([
    'title',
    'items' => [],
    'empty' => 'No items available.',
])

<div class="group rounded-3xl border border-slate-200/80 bg-white/90 p-6 shadow-sm ring-1 ring-slate-950/[0.03] transition-all duration-200 hover:-translate-y-0.5 hover:shadow-lg hover:shadow-slate-200/60">
    <div class="mb-5 flex items-center justify-between gap-4">
        <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-900">
            {{ $title }}
        </h3>

        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
            {{ count($items) }}
        </span>
    </div>

    @if (count($items))
        <div class="space-y-3">
            @foreach ($items as $item)
                <div class="relative overflow-hidden rounded-2xl border border-slate-200/70 bg-gradient-to-br from-slate-50 to-white p-4 transition duration-200 hover:border-slate-300 hover:bg-white hover:shadow-sm">
                    <div class="flex gap-3">
                        <div class="mt-1 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-slate-900 text-white shadow-sm">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.704 5.29a1 1 0 010 1.42l-7.25 7.25a1 1 0 01-1.414 0L3.296 9.216a1 1 0 111.414-1.414l4.037 4.037 6.543-6.543a1 1 0 011.414-.006z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <p class="text-sm leading-6 text-slate-700">
                            {{ $item }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-5 text-center">
            <p class="text-sm font-medium text-slate-500">
                {{ $empty }}
            </p>
        </div>
    @endif
</div>