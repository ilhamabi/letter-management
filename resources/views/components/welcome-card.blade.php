@props([
    'title' => 'Selamat Datang',
    'subtitle' => 'Ringkasan Sistem Layanan Dokumen',
    'showDate' => true,
])

<div {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl p-6 sm:p-8 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-6']) }}>
    <div class="space-y-1">
        <h3 class="text-2xl font-bold text-gray-900 m-0 font-headline-lg">{{ $title }}</h3>
        <p class="text-gray-600 m-0 text-sm">{{ $subtitle }}</p>
    </div>
    @if($showDate)
        <div class="bg-amikom-purple text-white px-4 py-2.5 rounded-lg flex items-center gap-2 shrink-0 shadow-xs self-start md:self-auto">
            <span class="material-symbols-outlined text-sm">calendar_today</span>
            <span class="text-sm font-medium">{{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y') }}</span>
        </div>
    @endif
</div>
