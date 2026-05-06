<!-- Stat Card Component -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
    <div class="flex items-start justify-between">
        <div class="flex-1">
            <p class="text-sm font-medium text-gray-600">{{ $title }}</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $value }}</p>
            @if ($change ?? false)
                <p class="mt-2 text-sm {{ $changeType === 'positive' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $changeType === 'positive' ? '↑' : '↓' }} {{ $change }}
                </p>
            @endif
        </div>
        @if ($icon ?? false)
            <div class="flex-shrink-0">
                <div class="p-3 rounded-lg {{ $iconBg ?? 'bg-blue-100' }}">
                    {!! $icon !!}
                </div>
            </div>
        @endif
    </div>
</div>
